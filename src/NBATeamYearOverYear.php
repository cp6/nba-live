<?php

namespace Corbpie\NBALive;

class NBATeamYearOverYear extends NBABase
{
    public array $data = [];

    public array $details = [];

    public array $latest = [];

    public function __construct(int $team_id, string $per_mode = 'Totals', string $season_type = 'Regular+Season')
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/teamyearbyyearstats?LeagueID=00&PerMode={$per_mode}&SeasonType={$season_type}&TeamID={$team_id}");

        if (isset($this->data['resultSets']['0']['rowSet'])) {
            foreach ($this->data['resultSets']['0']['rowSet'] as $values) {
                $this->details[] = [
                    'team_id' => $values[0],
                    'city' => $values[1],
                    'name' => $values[2],
                    'year' => $values[3],
                    'gp' => $values[4],
                    'w' => $values[5],
                    'l' => $values[6],
                    'w_pct' => $values[7],
                    'conf_rank' => $values[8],
                    'div_rank' => $values[9],
                    'po_wins' => $values[10],
                    'po_loses' => $values[11],
                    'conf_count' => $values[12],
                    'div_count' => $values[13],
                    'finals_appearance' => $values[14],
                    'fgm' => $values[15],
                    'fga' => $values[16],
                    'fg_pct' => $values[17],
                    'fg3m' => $values[18],
                    'fg3a' => $values[19],
                    'fg3_pct' => $values[20],
                    'ftm' => $values[21],
                    'fta' => $values[22],
                    'ft_pct' => $values[23],
                    'oreb' => $values[24],
                    'dreb' => $values[25],
                    'reb' => $values[26],
                    'ast' => $values[27],
                    'pf' => $values[28],
                    'stl' => $values[29],
                    'tov' => $values[30],
                    'blk' => $values[31],
                    'pts' => $values[32],
                    'pts_rank' => $values[33]
                ];
            }

            $this->latest = end($this->data['resultSets']['0']['rowSet']);
        }

    }

}