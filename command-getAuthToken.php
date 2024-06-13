<?php

use It5\WsPushServer\CurlClient;

require_once 'vendor/autoload.php';

$url = getenv('WS_SERVER_COMMAND_URL') . '/getAuthToken';
$query = http_build_query(['user_id' => 1]);
$url .= '?' . $query;
$method = 'GET';
$parameters = '';

$commandAuthToken = getenv('WS_SERVER_COMMAND_TOKEN');
$headers = [
    "Authorization: Bearer $commandAuthToken"
];

[$curlResult, $responseCode, $curlError] = CurlClient::makeRequest($url, $method, $parameters, $headers);

CurlClient::dump($curlResult, $responseCode, $curlError);
