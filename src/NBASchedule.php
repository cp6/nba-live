<?php

namespace Corbpie\NBALive;

use DateTime;
use DateTimeZone;

class NBASchedule extends NBABase
{

    public array $schedule = [];

    public function __construct(string $date = '2023-12-20')
    {
        $games = $this->ApiCall("https://stats.nba.com/stats/scoreboardv2?DayOffset=0&GameDate={$date}&LeagueID=00");

        foreach ($games['resultSets'][0]['rowSet'] as $game) {

            $time_formatted = DateTime::createFromFormat('g:i a', str_replace(" ET", "", $game[4]))->format('H:i:s');

            $date_time = str_replace("T00:00:00", " $time_formatted", $game[0]);

            $this->schedule[] = [
                'game_id' => $game[2],
                'game_sequence' => $game[1],
                'game_status' => $game[3],
                'game_status_text' => $game[4],
                'game_code' => $game[5],
                'home_tid' => $game[6],
                'away_tid' => $game[7],
                'arena' => $game[15],
                'live_period' => ($game[9] === 0) ? null : $game[9],
                'date_time_et' => $date_time,
                'date_time_utc' => (new DateTime($date_time, new DateTimeZone('America/New_York')))->setTimezone(new DateTimeZone('UTC'))->format('Y-m-d H:i:s')
            ];

        }

    }

}