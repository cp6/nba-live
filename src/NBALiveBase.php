<?php

namespace Corbpie\NBALive;

class NBALiveBase
{
    public const CURRENT_SEASON = '2023-24';

    public const MODE_PER_GAME = 'PerGame';

    public const MODE_TOTAL = 'Totals';

    public const MODE_PER48 = 'Per48';

    public const TYPE_REGULAR = 'Regular+Season';

    public const TYPE_PLAY_IN = 'PlayIn';

    public const TYPE_PLAYOFFS = 'Playoffs';

    public const TYPE_ALL_STAR = 'All+Star';

    public const TYPE_PRE_SEASON = 'Pre+Season';

    public string $url;

    public int $response_code;

    public int $response_size;

    public float $connect_time;

    public string $ip;

    public bool|string $response_body = '';

    protected function ApiCall(string $url): array
    {
        $this->url = $url;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        $header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
        $header[1] = "Accept-Language: en-us,en;q=0.5";
        curl_setopt($curl, CURLOPT_REFERER, "https://stats.nba.com/");
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:120.0) Gecko/20100101 Firefox/120.0");
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_ENCODING, "gzip,deflate");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $this->response_body = curl_exec($curl);
        $this->response_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $this->response_size = curl_getinfo($curl, CURLINFO_SIZE_DOWNLOAD);
        $this->connect_time = curl_getinfo($curl, CURLINFO_CONNECT_TIME);
        $this->ip = curl_getinfo($curl, CURLINFO_PRIMARY_IP);

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