<?php

namespace Corbpie\NBALive;

class NBAPlayoffSeries extends NBABase
{

    public array $data = [];

    public array $results = [];

    public function __construct(string $season = NBABase::CURRENT_SEASON, string $series_id = '')
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/commonplayoffseries?LeagueID=00&Season=$season&SeriesID=$series_id");

        if (isset($this->data['resultSets'][0]['rowSet'][0])) {
            foreach ($this->data['resultSets'][0]['rowSet'] as $d) {
                $this->results[] = [
                    'game_id' => $d[0],
                    'home_tid' => $d[1],
                    'away_tid' => $d[2],
                    'series_id' => $d[3],
                    'game_num' => $d[4]
                ];
            }
        }


    }

}