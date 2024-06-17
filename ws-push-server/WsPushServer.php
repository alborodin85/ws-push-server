<?php

namespace It5\WsPushServer;

class WsPushServer
{
    private string $commandSocketAddress;
    private string $wsSocketAddress;
    private string $commandAuthToken;

    private string $pingText;
    private string $pongText;

    // Массив вида [wsToken => user_id, ... ]
    private array $usersByWsTokens = [];
    // Массив вида [wsToken => connect, ... ]
    private array $connectsByWsTokens = [];

    /**
     * @param string $socketAddress Например, 'tcp://0.0.0.0:80'
     * @param string $commandAuthToken Токен аутентификации клиента для возможности выполнять команды
     */
    public function __construct(string $socketAddress, string $commandAuthToken, string $wsSocketAddress, string $pingText, string $pongText)
    {
        $this->commandSocketAddress = $socketAddress;
        $this->commandAuthToken = $commandAuthToken;
        $this->wsSocketAddress = $wsSocketAddress;
        $this->pingText = $pingText;
        $this->pongText = $pongText;
    }

    public function run(): void
    {
        $commandErrno = 0;
        $commandErrStr = '';
        $commandSocket = stream_socket_server($this->commandSocketAddress, $commandErrno, $commandErrStr);

        if (!$commandSocket) {
            die("$commandErrStr ($commandErrno)\n");
        }

        $wsSocketErrno = 0;
        $wsSocketErrstr = '';
        $wsSocket = stream_socket_server($this->wsSocketAddress, $wsSocketErrno, $wsSocketErrstr);

        if (!$wsSocket) {
            throw new \Exception("wsSocket $wsSocketErrstr ($wsSocketErrno)\n");
        }

        $connects = array();
        while (true) {
            //формируем массив прослушиваемых сокетов:
            $read = $connects;
            $read[] = $commandSocket;
            $read[] = $wsSocket;
            $write = $except = null;

            if (!stream_select($read, $write, $except, null)) {//ожидаем сокеты доступные для чтения (без таймаута)
                break;
            }

            if (in_array($commandSocket, $read)) {//есть новое соединение
                $connect = stream_socket_accept($commandSocket, -1);//принимаем новое соединение
                $connects[] = $connect;//добавляем его в список необходимых для обработки
                unset($read[array_search($commandSocket, $read)]);
            }

            if (in_array($wsSocket, $read)) {   //есть новое соединение
                //принимаем новое соединение и производим рукопожатие:
                if (($connect = stream_socket_accept($wsSocket, -1)) && $info = Utils::handshake($connect)) {
                    // Действия при открытии сокета
                    $matches = [];
                    preg_match('/^.*?auth_token=(\w*).*$/ius', $info['uri'], $matches);
                    if (isset($matches[1]) && isset($this->usersByWsTokens[$matches[1]])) {
                        $connects[] = $connect;
                        $this->connectsByWsTokens[$matches[1]] = $connect;
                        echo date('Y-m-d H:i:s') . " open [$matches[1]] \n";
                    } else {
                        fclose($connect);
                    }
                }
                unset($read[array_search($wsSocket, $read)]);
            }

            foreach ($read as $connect) {//обрабатываем все соединения

                $sourceData = fread($connect, 1460); // 1460 байт - стандартный размер MTU

                if (!$sourceData) { //соединение было закрыто
                    fclose($connect);
                    unset($connects[array_search($connect, $connects)]);
                    // Действия при закрытии сокета

                    $wsToken = array_search($connect, $this->connectsByWsTokens);
                    unset($this->connectsByWsTokens[$wsToken]);
                    unset($this->usersByWsTokens[$wsToken]);

                    echo date('Y-m-d H:i:s') . " closed [$wsToken] \n";

                    continue;
                }

                if (str_contains($sourceData, "\r\n\r\n")) {
                    $sourceDataArr = explode("\r\n\r\n", $sourceData);

                    $headersAsString = $sourceDataArr[0];
                    $headersAsArray = explode("\r\n", $headersAsString);
                    $headers = Utils::parseHttpHeaders($headersAsArray);
                    [$method, $path, $getParams, $protocol] = Utils::parseFirstHttpString($headersAsArray[0]);

                    if (!Utils::checkAuthToken($headers, $this->commandAuthToken)) {
                        fwrite($connect, "HTTP/1.1 401 Error\r\nContent-Type: text/html\r\nConnection: close\r\n\r\nAuth Error");
                        fclose($connect);
                        unset($connects[array_search($connect, $connects)]);
                        continue;
                    }

                    $dataArray = [];
                    if ($contentLength = $headers['content-length'] ?? 0) {
                        $headersLength = strlen($sourceDataArr[0]) + 4; // прибавляем сюда \r\n\r\n
                        $totalLength = $contentLength + $headersLength;
                        // stream_set_timeout($connect, 1);
                        stream_set_blocking($connect, false);

                        $wasEmptyBuffer = false;
                        while (strlen($sourceData) < $totalLength) {
                            $buffer = fread($connect, 1460);
                            if (strlen($buffer)) {
                                $wasEmptyBuffer = false;
                                $sourceData .= $buffer;
                                usleep(1);
                            } elseIf($wasEmptyBuffer) {
                                break;
                            } else {
                                $wasEmptyBuffer = true;
                                usleep(1000_000);
                            }
                        }
                        $sourceDataArr = explode("\r\n\r\n", $sourceData);
                        $dataArray = Utils::parseQueryData($sourceDataArr[1]);
                    }

                    switch ($path) {
                        case '/ws-command/getAuthToken':
                            if (!isset($getParams['user_id'])) {
                                fwrite($connect, "HTTP/1.1 400 bad request\r\nContent-Type: text/html\r\nConnection: close\r\n\r\nНе указан user_id!");
                                break;
                            }
                            $userId = $getParams['user_id'];

                            $wsToken = md5(random_bytes(10));
                            $this->usersByWsTokens[$wsToken] = $userId;

                            $responseArr = [
                                'token' => $wsToken,
                                'ping_text' => $this->pingText,
                            ];
                            $responseStr = json_encode($responseArr);

                            fwrite($connect, "HTTP/1.1 200 OK\r\nContent-Type: text/html\r\nConnection: close\r\n\r\n$responseStr");
                            break;
                        case '/ws-command/sendMessage':
                            if (!isset($getParams['user_id'])) {
                                fwrite($connect, "HTTP/1.1 400 bad request\r\nContent-Type: text/html\r\nConnection: close\r\n\r\nНе указан user_id!");
                                break;
                            }
                            $userId = $getParams['user_id'];
                            if ($dataArray['message']) {
                                $message = urldecode($dataArray['message']);

                                $wsTokensArray = array_keys($this->usersByWsTokens, $userId);
                                foreach ($wsTokensArray as $wsToken) {
                                    if (isset($this->connectsByWsTokens[$wsToken])) {
                                        fwrite($this->connectsByWsTokens[$wsToken], Utils::encode($message));
                                    }
                                }
                            }

                            fwrite($connect, "HTTP/1.1 200 OK\r\nContent-Type: text/html\r\nConnection: close\r\n\r\nsendMessage");
                            break;
                        case '/ws-command/sendAll':
                            if ($dataArray['message']) {
                                $message = urldecode($dataArray['message']);
                                foreach ($this->connectsByWsTokens as $connectItem) {
                                    fwrite($connectItem, Utils::encode($message));
                                }
                            }

                            fwrite($connect, "HTTP/1.1 200 OK\r\nContent-Type: text/html\r\nConnection: close\r\n\r\nsendAll");
                            break;
                        case '/ws-command/detachUser':
                            if (!isset($getParams['user_id'])) {
                                fwrite($connect, "HTTP/1.1 400 bad request\r\nContent-Type: text/html\r\nConnection: close\r\n\r\nНе указан user_id!");
                                break;
                            }
                            $userId = $getParams['user_id'];

                            $wsTokensArray = array_keys($this->usersByWsTokens, $userId);
                            foreach ($wsTokensArray as $wsToken) {
                                unset($this->connectsByWsTokens[$wsToken]);
                                unset($this->usersByWsTokens[$wsToken]);
                            }

                            fwrite($connect, "HTTP/1.1 200 OK\r\nContent-Type: text/html\r\nConnection: close\r\n\r\nOK");
                            break;
                        case '/ws-command/countUsers':
                            $countUsers = count($this->connectsByWsTokens);
                            fwrite($connect, "HTTP/1.1 200 OK\r\nContent-Type: text/html\r\nConnection: close\r\n\r\n$countUsers");
                            break;
                        default:
                            fwrite($connect, "HTTP/1.1 501 Not Implemented\r\nContent-Type: text/html\r\nConnection: close\r\n\r\nNot Implemented");
                    }
                    fclose($connect);
                    unset($connects[array_search($connect, $connects)]);
                } else {
                    // Действия при получении сообщения в сокете
                    $message = '';
                    try {
                        $message = Utils::decode($sourceData)['payload'];
                    } catch (\Throwable) {
                        //
                    }

                    if ($message == $this->pingText) {
                        fwrite($connect, Utils::encode($this->pongText));
                    }
                }
            }
        }
    }
}
