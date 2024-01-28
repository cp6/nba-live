<?php

namespace Corbpie\NBALive;

class NBATeamDashPtShots extends NBATeamDashFilters
{
    public array $data = [];

    public array $general_shooting = [];

    public array $shot_clock_shooting = [];

    public array $dribble_shooting = [];

    public array $closest_defender_shooting = [];

    public array $closest_defender_10ft_shooting = [];

    public array $touch_time_shooting = [];

    public function fetch(): void
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/teamdashptshots?" . $this->build());

        if (isset($this->data['resultSets'][0]['rowSet'])) {
            foreach ($this->data['resultSets'][0]['rowSet'] as $d) {
                $this->general_shooting[] = [
                    'team_id' => $d[0],
                    'team' => $d[1],
                    'per_mode' => $this->data['parameters']['PerMode'],
                    'season' => $this->data['parameters']['Season'],
                    'season_type' => $this->data['parameters']['SeasonType'],
                    'sort_order' => $d[2],
                    'g' => $d[3],
                    'shot_type' => $d[4],
                    'fga_freq' => $d[5],
                    'fgm' => $d[6],
                    'fga' => $d[7],
                    'fg_pct' => $d[8],
                    'efg_pct' => $d[9],
                    'fg2a_freq' => $d[10],
                    'fg2m' => $d[11],
                    'fg2a' => $d[12],
                    'fg2_pct' => $d[13],
                    'fg3a_freq' => $d[14],
                    'fg3m' => $d[15],
                    'fg3a' => $d[16],
                    'fg3_pct' => $d[17]
                ];
            }
        }

        if (isset($this->data['resultSets'][1]['rowSet'])) {
            foreach ($this->data['resultSets'][1]['rowSet'] as $d) {
                $this->shot_clock_shooting[] = [
                    'team_id' => $d[0],
                    'team' => $d[1],
                    'per_mode' => $this->data['parameters']['PerMode'],
                    'season' => $this->data['parameters']['Season'],
                    'season_type' => $this->data['parameters']['SeasonType'],
                    'sort_order' => $d[2],
                    'g' => $d[3],
                    'shot_type' => $d[4],
                    'fga_freq' => $d[5],
                    'fgm' => $d[6],
                    'fga' => $d[7],
                    'fg_pct' => $d[8],
                    'efg_pct' => $d[9],
                    'fg2a_freq' => $d[10],
                    'fg2m' => $d[11],
                    'fg2a' => $d[12],
                    'fg2_pct' => $d[13],
                    'fg3a_freq' => $d[14],
                    'fg3m' => $d[15],
                    'fg3a' => $d[16],
                    'fg3_pct' => $d[17]
                ];
            }
        }

        if (isset($this->data['resultSets'][2]['rowSet'])) {
            foreach ($this->data['resultSets'][2]['rowSet'] as $d) {
                $this->dribble_shooting[] = [
                    'team_id' => $d[0],
                    'team' => $d[1],
                    'per_mode' => $this->data['parameters']['PerMode'],
                    'season' => $this->data['parameters']['Season'],
                    'season_type' => $this->data['parameters']['SeasonType'],
                    'sort_order' => $d[2],
                    'g' => $d[3],
                    'shot_type' => $d[4],
                    'fga_freq' => $d[5],
                    'fgm' => $d[6],
                    'fga' => $d[7],
                    'fg_pct' => $d[8],
                    'efg_pct' => $d[9],
                    'fg2a_freq' => $d[10],
                    'fg2m' => $d[11],
                    'fg2a' => $d[12],
                    'fg2_pct' => $d[13],
                    'fg3a_freq' => $d[14],
                    'fg3m' => $d[15],
                    'fg3a' => $d[16],
                    'fg3_pct' => $d[17]
                ];
            }
        }

        if (isset($this->data['resultSets'][3]['rowSet'])) {
            foreach ($this->data['resultSets'][3]['rowSet'] as $d) {
                $this->closest_defender_shooting[] = [
                    'team_id' => $d[0],
                    'team' => $d[1],
                    'per_mode' => $this->data['parameters']['PerMode'],
                    'season' => $this->data['parameters']['Season'],
                    'season_type' => $this->data['parameters']['SeasonType'],
                    'sort_order' => $d[2],
                    'g' => $d[3],
                    'shot_type' => $d[4],
                    'fga_freq' => $d[5],
                    'fgm' => $d[6],
                    'fga' => $d[7],
                    'fg_pct' => $d[8],
                    'efg_pct' => $d[9],
                    'fg2a_freq' => $d[10],
                    'fg2m' => $d[11],
                    'fg2a' => $d[12],
                    'fg2_pct' => $d[13],
                    'fg3a_freq' => $d[14],
                    'fg3m' => $d[15],
                    'fg3a' => $d[16],
                    'fg3_pct' => $d[17]
                ];
            }
        }

        if (isset($this->data['resultSets'][4]['rowSet'])) {
            foreach ($this->data['resultSets'][4]['rowSet'] as $d) {
                $this->closest_defender_10ft_shooting[] = [
                    'team_id' => $d[0],
                    'team' => $d[1],
                    'per_mode' => $this->data['parameters']['PerMode'],
                    'season' => $this->data['parameters']['Season'],
                    'season_type' => $this->data['parameters']['SeasonType'],
                    'sort_order' => $d[2],
                    'g' => $d[3],
                    'shot_type' => $d[4],
                    'fga_freq' => $d[5],
                    'fgm' => $d[6],
                    'fga' => $d[7],
                    'fg_pct' => $d[8],
                    'efg_pct' => $d[9],
                    'fg2a_freq' => $d[10],
                    'fg2m' => $d[11],
                    'fg2a' => $d[12],
                    'fg2_pct' => $d[13],
                    'fg3a_freq' => $d[14],
                    'fg3m' => $d[15],
                    'fg3a' => $d[16],
                    'fg3_pct' => $d[17]
                ];
            }
        }

        if (isset($this->data['resultSets'][5]['rowSet'])) {
            foreach ($this->data['resultSets'][5]['rowSet'] as $d) {
                $this->touch_time_shooting[] = [
                    'team_id' => $d[0],
                    'team' => $d[1],
                    'per_mode' => $this->data['parameters']['PerMode'],
                    'season' => $this->data['parameters']['Season'],
                    'season_type' => $this->data['parameters']['SeasonType'],
                    'sort_order' => $d[2],
                    'g' => $d[3],
                    'shot_type' => $d[4],
                    'fga_freq' => $d[5],
                    'fgm' => $d[6],
                    'fga' => $d[7],
                    'fg_pct' => $d[8],
                    'efg_pct' => $d[9],
                    'fg2a_freq' => $d[10],
                    'fg2m' => $d[11],
                    'fg2a' => $d[12],
                    'fg2_pct' => $d[13],
                    'fg3a_freq' => $d[14],
                    'fg3m' => $d[15],
                    'fg3a' => $d[16],
                    'fg3_pct' => $d[17]
                ];
            }
        }

    }

}