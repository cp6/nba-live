<?php

namespace Corbpie\NBALive;

class NBABase
{
    public const CURRENT_SEASON = '2023-24';

    public const PREVIOUS_SEASON = '2022-23';

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

    public string $game_id;

    public int $player_id;

    public int $team_id;

    public function __construct()
    {
        header('Content-Type: application/json');
    }

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

    public static function secondsToFormattedGameTime(float $seconds): array
    {
        $seconds = round($seconds);
        if ($seconds <= 720) {
            $period = 1;
            $period_txt = "Q1";
            $seconds_in = $seconds;
            $seconds_out = 720 - $seconds_in;
            $string = gmdate('i:s', $seconds_in);
            $seconds_period_string = gmdate('i:s', $seconds_out);
        } else if ($seconds <= 1440) {
            $period = 2;
            $period_txt = "Q2";
            $seconds_in = $seconds - 720;
            $seconds_out = 720 - $seconds_in;
            $string = gmdate('i:s', $seconds_in);
            $seconds_period_string = gmdate('i:s', $seconds_out);
        } else if ($seconds <= 2160) {
            $period = 3;
            $period_txt = "Q3";
            $seconds_in = $seconds - 1440;
            $seconds_out = 1440 - ($seconds - 720);
            $string = gmdate('i:s', $seconds_in);
            $seconds_period_string = gmdate('i:s', $seconds_out);
        } else if ($seconds <= 2880) {
            $period = 4;
            $period_txt = "Q4";
            $seconds_in = $seconds - 2160;
            $seconds_out = 2160 - ($seconds - 720);
            $string = gmdate('i:s', $seconds_in);
            $seconds_period_string = gmdate('i:s', $seconds_out);
        } else if ($seconds <= 3180) {
            $period = 5;//OT1
            $period_txt = "OT1";
            $seconds_in = $seconds - 2880;
            $seconds_out = 2880 - ($seconds - 300);
            $string = gmdate('i:s', $seconds_in);
            $seconds_period_string = gmdate('i:s', $seconds_out);
        } else if ($seconds <= 3480) {
            $period = 6;//OT2
            $period_txt = "OT2";
            $seconds_in = $seconds - 3180;
            $seconds_out = 3180 - ($seconds - 300);
            $string = gmdate('i:s', $seconds_in);
            $seconds_period_string = gmdate('i:s', $seconds_out);
        } else if ($seconds <= 3780) {
            $period = 7;//OT3
            $period_txt = "OT3";
            $seconds_in = $seconds - 3480;
            $seconds_out = 3480 - ($seconds - 300);
            $string = gmdate('i:s', $seconds_in);
            $seconds_period_string = gmdate('i:s', $seconds_out);
        } else {
            $period = 8;//OT4
            $period_txt = "OT4";
            $seconds_in = $seconds - 3780;
            $seconds_out = 3780 - ($seconds - 300);
            $string = gmdate('i:s', $seconds_in);
            $seconds_period_string = gmdate('i:s', $seconds_out);
        }

        return [
            'period' => $period,
            'period_string' => $period_txt,
            'seconds' => $seconds,
            'seconds_period' => $seconds_in,
            'seconds_period_string' => $seconds_period_string,
            'full_string' => $period_txt . ' ' . $seconds_period_string
        ];
    }

}