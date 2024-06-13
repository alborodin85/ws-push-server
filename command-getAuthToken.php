<?php

use server\CurlClient;

require_once 'Config.php';
require_once '../vendor/autoload.php';

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

CurlClient::dump($curlResult, $responseCode, $curlError);