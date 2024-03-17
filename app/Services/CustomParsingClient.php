<?php

namespace App\Services;

class CustomParsingClient implements \PHPHtmlParser\CurlInterface
{
    public function get(string $url, array $options): string
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, config('olx.user-agent'));
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}
