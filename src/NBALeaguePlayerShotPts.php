<?php

namespace Corbpie\NBALive;

class NBALeaguePlayerShotPts extends NBALeagueDashFilters
{

    public array $data = [];

    public array $details = [];

    public function fetch(): array
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/leaguedashplayerptshot?" . $this->build());

        if (isset($this->data['resultSets'][0]['rowSet'][0])) {
            foreach ($this->data['resultSets'][0]['rowSet'] as $p) {
                $this->details[] = [
                    'player_id' => $p[0],
                    'name' => $p[1],
                    'team_id' => $p[2],
                    'team' => $p[3],
                    'age' => $p[4],
                    'gp' => $p[5],
                    'g' => $p[6],
                    'fga_frequency' => $p[7],
                    'fgm' => $p[8],
                    'fga' => $p[9],
                    'fg_pct' => $p[10],
                    'efg_pct' => $p[11],
                    'fg2a_frequency' => $p[12],
                    'fg2m' => $p[13],
                    'fg2a' => $p[14],
                    'fg2_pct' => $p[15],
                    'fg3a_frequency' => $p[16],
                    'fg3m' => $p[17],
                    'fg3a' => $p[18],
                    'fg3_pct' => $p[19]
                ];
            }
        }

        return $this->data;
    }


}