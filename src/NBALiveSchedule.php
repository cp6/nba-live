<?php

namespace Corbpie\NBALive;

class NBALiveSchedule extends NBALiveBase
{

    public array $schedule = [];

    public function __construct(string $date = '2023-12-20')
    {
        $games = $this->ApiCall("https://stats.nba.com/stats/scoreboardv2?DayOffset=0&GameDate={$date}&LeagueID=00");

        foreach ($games['resultSets'][0]['rowSet'] as $game) {

            $this->schedule[] = [
                'game_id' => $game[2],
                'game_sequence' => $game[1],
                'game_status' => $game[3],
                'game_status_text' => $game[4],
                'game_code' => $game[5],
                'home_tid' => $game[6],
                'away_tid' => $game[7],
                'arena' => $game[15],
                'live_period' => $game[9],
                'game_date' => $game[0],
            ];

        }

    }

}