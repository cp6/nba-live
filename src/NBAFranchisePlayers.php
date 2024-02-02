<?php

namespace Corbpie\NBALive;

class NBAFranchisePlayers extends NBABase
{

    public array $data = [];

    public array $players = [];


    public function __construct(int $team_id = 202331, string $per_mode = NBABase::MODE_TOTAL, string $season_type = NBABase::TYPE_REGULAR)
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/franchiseplayers?LeagueID=00&PerMode={$per_mode}&SeasonType={$season_type}&TeamID={$team_id}");

        if (isset($this->data['resultSets'][0]['rowSet'])) {
            foreach ($this->data['resultSets'][0]['rowSet'] as $values) {
                $this->players[] = [
                    'team_id' => $values[1],
                    'team' => $values[2],
                    'player_id' => $values[3],
                    'player' => $values[4],
                    'season_type' => $values[5],
                    'active_with_team' => $values[6],
                    'gp' => $values[7],
                    'fgm' => $values[8],
                    'fga' => $values[9],
                    'fg_pct' => $values[10],
                    'fg3m' => $values[11],
                    'fg3a' => $values[12],
                    'fg3_pct' => $values[13],
                    'ftm' => $values[14],
                    'fta' => $values[15],
                    'ft_pct' => $values[16],
                    'oreb' => $values[17],
                    'dreb' => $values[18],
                    'reb' => $values[19],
                    'ast' => $values[20],
                    'pf' => $values[21],
                    'stl' => $values[22],
                    'tov' => $values[23],
                    'blk' => $values[24],
                    'pts' => $values[25]
                ];
            }
        }

    }

}