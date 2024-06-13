<?php

use server\CurlClient;

require_once '../Config.php';
require_once '../../vendor/autoload.php';

$wsServerUrl = 'https://tt2.it5.su/ws/';

$url = 'tt2-ws-push-server-ssh/ws-command/getAuthToken';
$query = http_build_query(['user_id' => 1]);
$url .= '?' . $query;
$method = 'GET';
$parameters = '';

$commandAuthToken = Config::$COMMAND_AUTH_TOKEN;
$headers = [
    "Authorization: Bearer $commandAuthToken"
];

[$curlResult, $responseCode, $curlError] = CurlClient::makeRequest($url, $method, $parameters, $headers);

//CurlClient::dump($curlResult, $responseCode, $curlError);

$authResult = json_decode($curlResult, true);
$wsAuthToken = $authResult['token'];
$wsUrl = "$wsServerUrl?auth_token=$wsAuthToken"

?><!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Тестирование ws-push-server</title>
</head>
<body>
<h1>Тестирование ws-push-server</h1>
<input type="button" value="send message" id="send-msg"/>
<div id="socket-info"></div>

<script>
    window.addEventListener('DOMContentLoaded', function () {

        let socket;

        connect();

        function showMessage(message) {
            const pre = document.createElement('pre');
            pre.appendChild(document.createTextNode(message));
            document.getElementById('socket-info').appendChild(pre);
        }

        function connect() {
            // новое соединение открываем, если старое соединение закрыто
            if (socket === undefined || socket.readyState !== 1) {
                socket = new WebSocket('<?=$wsUrl?>');
            } else {
                showMessage('Надо закрыть уже имеющееся соединение');
                return;
            }

            let pingSendIntervalId;
            socket.onmessage = function (event) {
                showMessage('Получено сообщение от сервера: ' + event.data);
            }
            socket.onopen = function () {
                showMessage('Соединение с сервером установлено');
                // Функционал пингов необходимо реализовать в браузере, т. к. сервер однопоточный и там их реализовать сложнее
                pingSendIntervalId = setInterval(() => socket.send('<?= $authResult["ping_text"] ?>'), 45 * 1000);
            }
            socket.onerror = function (error) {
                showMessage('Произошла ошибка: ' + error.message);
            };
            socket.onclose = function (event) {
                clearInterval(pingSendIntervalId);
                showMessage('Соединение с сервером закрыто');
                if (event.wasClean) {
                    showMessage('Соединение закрыто чисто');
                } else {
                    showMessage('Обрыв соединения');
                }
                showMessage('Код: ' + event.code + ', причина: ' + event.reason);
            };
        }

        document.getElementById('send-msg').onclick = function () {
            if (socket !== undefined && socket.readyState === 1) {
                const message = 'Привет из браузера';
                socket.send(message);
                showMessage('Отправлено сообщение серверу: ' + message);
            } else {
                showMessage('Невозможно отправить сообщение, нет соединения');
            }
        };
    });
</script>

</body>
</html>
