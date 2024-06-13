<?php

namespace ws-push-server;

class Utils
{
    public static function parseFirstHttpString($firstHttpString): array
    {
        $stringAsArray = explode(' ', $firstHttpString);
        $method = trim($stringAsArray[0] ?? '');
        $uri = trim($stringAsArray[1] ?? '');
        $protocol = trim($stringAsArray[2] ?? '');

        $path = '';
        $getParams = [];
        if ($uri) {
            $uriAsArray = explode('?', $uri);
            $path = $uriAsArray[0];
            $getParamsAsStr = $uriAsArray[1] ?? '';
            $getParamsAsArray = explode('&', $getParamsAsStr);
            foreach ($getParamsAsArray as $paramsPair) {
                if (!$paramsPair) {
                    continue;
                }
                $paramsPairArr = explode('=', $paramsPair);
                $getParams[strtolower($paramsPairArr[0])] = $paramsPairArr[1];
            }
        }

        return [$method, $path, $getParams, $protocol];
    }

    public static function parseHttpHeaders(array $headersAsArray): array
    {
        $headersKeyedArray = [];
        foreach ($headersAsArray as $headerAsStr) {
            if (!trim($headerAsStr)) {
                continue;
            }
            $headerPair = explode(':', $headerAsStr);
            $headersKeyedArray[strtolower(trim($headerPair[0]))] = trim($headerPair[1] ?? '');
        }

        return $headersKeyedArray;
    }

    public static function parseQueryData(string $dataAsStr): array
    {
        $dataAsArray = [];
        $paramsAsString = explode('&', $dataAsStr);
        foreach ($paramsAsString as $paraStr) {
            if (!trim($paraStr)) {
                continue;
            }
            $paraArray = explode('=', $paraStr);
            $dataAsArray[strtolower($paraArray[0])] = $paraArray[1] ?? '';
        }

        return $dataAsArray;
    }

    public static function checkAuthToken(array $headers, string $correctToken): bool
    {
        $isCorrectAuth = false;
        if (isset($headers['authorization'])) {
            $tokensPair = explode(' ', $headers['authorization']);
            $tokenFromRequest = $tokensPair[1];
            if ($tokenFromRequest == $correctToken) {
                $isCorrectAuth = true;
            }
        }

        return $isCorrectAuth;
    }
}
