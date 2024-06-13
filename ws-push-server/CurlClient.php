<?php

namespace ws-push-server;

class CurlClient
{
    public static function makeRequest(string $url, string $method, string $parameters, array $headers): array
    {
        $curl = curl_init();

        $method = strtoupper($method);

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HEADER => false,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_HTTPHEADER => $headers,
        ]);

        if ($parameters) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $parameters);
        }

        $curlResult = curl_exec($curl);
        $responseCode = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
        if (!$responseCode) {
            $responseCode = 500;
        }

        curl_close($curl);

        $curlError = curl_error($curl);
        if ($responseCode != 200) {
            $curlError .= $curlResult;
        }

        return [$curlResult, $responseCode, $curlError];
    }

    public static function dump(string $curlResult, int $responseCode, string $curlError): void
    {
        echo "responseCode: $responseCode \n";
        echo "curlResult: $curlResult\n";
        if ($curlError) {
            echo "curlError: $curlError\n";
        }
    }
}
