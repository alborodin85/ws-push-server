<?php

require_once 'vendor/autoload.php';

use It5\WsPushServer\WsPushServer;

$commandSocketAddress = getenv('COMMAND_SOCKET_ADDRESS');
$commandAuthToken = getenv('WS_SERVER_COMMAND_TOKEN');
$wsSocketAddress = getenv('WS_SOCKET_ADDRESS');
$pingText = getenv('PING_TEXT');
$pongText = getenv('PONG_TEXT');

$server = new WsPushServer($commandSocketAddress, $commandAuthToken, $wsSocketAddress, $pingText, $pongText);

$server->run();
