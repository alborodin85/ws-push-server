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
                if (($connect = stream_socket_accept($wsSocket, -1)) && $info = $this->handshake($connect)) {
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
                                        fwrite($this->connectsByWsTokens[$wsToken], $this->encode($message));
                                    }
                                }
                            }

                            fwrite($connect, "HTTP/1.1 200 OK\r\nContent-Type: text/html\r\nConnection: close\r\n\r\nsendMessage");
                            break;
                        case '/ws-command/sendAll':
                            if ($dataArray['message']) {
                                $message = urldecode($dataArray['message']);
                                foreach ($this->connectsByWsTokens as $connectItem) {
                                    fwrite($connectItem, $this->encode($message));
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
                        $message = $this->decode($sourceData)['payload'];
                    } catch (\Throwable) {
                        //
                    }
                    $wsToken = array_search($connect, $this->connectsByWsTokens);

                    echo date('Y-m-d H:i:s') . " [$wsToken]: $message\n";

                    if ($message == $this->pingText) {
                        fwrite($connect, $this->encode($this->pongText));
                    }
                }
            }
        }
    }

    # <editor-fold defaultstate="collapsed" desc="handshake($connect)">
    private function handshake($connect): array
    {
        /** @noinspection DuplicatedCode */
        $info = array();

        $line = fgets($connect);
        $header = explode(' ', $line);
        $info['method'] = $header[0];
        $info['uri'] = $header[1];

        //считываем заголовки из соединения
        while ($line = rtrim(fgets($connect))) {
            if (preg_match('/\A(\S+): (.*)\z/', $line, $matches)) {
                $info[$matches[1]] = $matches[2];
            } else {
                break;
            }
        }

        $address = explode(':', stream_socket_get_name($connect, true)); //получаем адрес клиента
        $info['ip'] = $address[0];
        $info['port'] = $address[1];

        if (empty($info['Sec-WebSocket-Key'])) {
            return [];
        }

        //отправляем заголовок согласно протоколу вебсокета
        $SecWebSocketAccept = base64_encode(pack('H*', sha1($info['Sec-WebSocket-Key'] . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
        $upgrade = "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" .
            "Upgrade: websocket\r\n" .
            "Connection: Upgrade\r\n" .
            "Sec-WebSocket-Accept:$SecWebSocketAccept\r\n\r\n";
        fwrite($connect, $upgrade);

        return $info;
    }
    # </editor-fold>

    # <editor-fold defaultstate="collapsed" desc="encode($payload, $type, $masked)/decode($data)">
    /** @noinspection PhpSameParameterValueInspection */
    private function encode($payload, $type = 'text', $masked = false): string
    {
        /** @noinspection DuplicatedCode */
        $frameHead = array();
        $payloadLength = strlen($payload);

        switch ($type) {
            case 'text':
                // first byte indicates FIN, Text-Frame (10000001):
                $frameHead[0] = 129;
                break;

            case 'close':
                // first byte indicates FIN, Close Frame(10001000):
                $frameHead[0] = 136;
                break;

            case 'ping':
                // first byte indicates FIN, Ping frame (10001001):
                $frameHead[0] = 137;
                break;

            case 'pong':
                // first byte indicates FIN, Pong frame (10001010):
                $frameHead[0] = 138;
                break;
        }

        // set mask and payload length (using 1, 3 or 9 bytes)
        if ($payloadLength > 65535) {
            $payloadLengthBin = str_split(sprintf('%064b', $payloadLength), 8);
            $frameHead[1] = ($masked === true) ? 255 : 127;
            for ($i = 0; $i < 8; $i++) {
                $frameHead[$i + 2] = bindec($payloadLengthBin[$i]);
            }
            // most significant bit MUST be 0
            if ($frameHead[2] > 127) {
                throw new \Exception('frame too large (1004)');
            }
        } elseif ($payloadLength > 125) {
            $payloadLengthBin = str_split(sprintf('%016b', $payloadLength), 8);
            $frameHead[1] = ($masked === true) ? 254 : 126;
            $frameHead[2] = bindec($payloadLengthBin[0]);
            $frameHead[3] = bindec($payloadLengthBin[1]);
        } else {
            $frameHead[1] = ($masked === true) ? $payloadLength + 128 : $payloadLength;
        }

        // convert frame-head to string:
        foreach (array_keys($frameHead) as $i) {
            $frameHead[$i] = chr($frameHead[$i]);
        }
        if ($masked === true) {
            // generate a random mask:
            $mask = array();
            for ($i = 0; $i < 4; $i++) {
                $mask[$i] = chr(rand(0, 255));
            }

            $frameHead = array_merge($frameHead, $mask);
        }
        $frame = implode('', $frameHead);

        // append payload to frame:
        for ($i = 0; $i < $payloadLength; $i++) {
            $frame .= ($masked === true) ? $payload[$i] ^ $mask[$i % 4] : $payload[$i];
        }

        return $frame;
    }

    private function decode($data): array
    {
        /** @noinspection DuplicatedCode */
        $unmaskedPayload = '';
        $decodedData = array();

        // estimate frame type:
        $firstByteBinary = sprintf('%08b', ord($data[0]));
        $secondByteBinary = sprintf('%08b', ord($data[1]));
        $opcode = bindec(substr($firstByteBinary, 4, 4));
        $isMasked = $secondByteBinary[0] == '1';
        $payloadLength = ord($data[1]) & 127;

        // unmasked frame is received:
        if (!$isMasked) {
            return array('type' => '', 'payload' => 'protocol error (1002)', 'error' => 'protocol error (1002)');
        }

        switch ($opcode) {
            // text frame:
            case 1:
                $decodedData['type'] = 'text';
                break;

            case 2:
                $decodedData['type'] = 'binary';
                break;

            // connection close frame:
            case 8:
                $decodedData['type'] = 'close';
                break;

            // ping frame:
            case 9:
                $decodedData['type'] = 'ping';
                break;

            // pong frame:
            case 10:
                $decodedData['type'] = 'pong';
                break;

            default:
                return array('type' => '', 'payload' => 'unknown opcode (1003)', 'error' => 'unknown opcode (1003)');
        }

        if ($payloadLength === 126) {
            $mask = substr($data, 4, 4);
            $payloadOffset = 8;
            $dataLength = bindec(sprintf('%08b', ord($data[2])) . sprintf('%08b', ord($data[3]))) + $payloadOffset;
        } elseif ($payloadLength === 127) {
            $mask = substr($data, 10, 4);
            $payloadOffset = 14;
            $tmp = '';
            for ($i = 0; $i < 8; $i++) {
                $tmp .= sprintf('%08b', ord($data[$i + 2]));
            }
            $dataLength = bindec($tmp) + $payloadOffset;
            unset($tmp);
        } else {
            $mask = substr($data, 2, 4);
            $payloadOffset = 6;
            $dataLength = $payloadLength + $payloadOffset;
        }

        /**
         * We have to check for large frames here. socket_recv cuts at 1024 bytes
         * so if websocket-frame is > 1024 bytes we have to wait until whole
         * data is transferd.
         */
        if (strlen($data) < $dataLength) {
            return array('type' => '', 'payload' => '', 'error' => 'data to large!');
        }

        for ($i = $payloadOffset; $i < $dataLength; $i++) {
            $j = $i - $payloadOffset;
            if (isset($data[$i])) {
                $unmaskedPayload .= $data[$i] ^ $mask[$j % 4];
            }
        }
        $decodedData['payload'] = $decodedData['type'] == 'text' ? $unmaskedPayload : 'Служебная команда';

        return $decodedData;
    }
    # </editor-fold>
}
