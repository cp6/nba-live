<?php

namespace Corbpie\NBALive;

class NBALiveBase
{
    public int $response_code;

    public bool|string $response_body = '';

    protected function ApiCall(string $uri): array
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://cdn.nba.com/static/json/liveData/{$uri}.json");
        curl_setopt($curl, CURLOPT_HTTPHEADER, ["Accept: application/json"]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:120.0) Gecko/20100101 Firefox/120.0");
        curl_setopt($curl, CURLOPT_REFERER, "https://www.nba.com/games");
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 0);

        $this->response_body = curl_exec($curl);
        $this->response_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($this->response_code >= 200 && $this->response_code < 300) {
            return json_decode($this->response_body, true) ?? [];
        }

        return [
            'http_code' => $this->response_code,
            'response' => json_decode($this->response_body, true),
        ];
    }

}