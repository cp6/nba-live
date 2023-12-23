<?php

namespace Corbpie\NBALive;

class NBATeamPlayerOnOff extends NBATeamDashFilters
{
    public array $data = [];

    public array $on = [];

    public array $off = [];

    public array $player_only = [];

    public function fetch(): void
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/teamplayeronoffdetails?" . $this->build());

        foreach ($this->data['resultSets'][1]['rowSet'] as $p) {
            $this->on[] = [
                'player_id' => $p[4],
                'player' => $p[5],
                'team_id' => $p[1],
                'team' => $p[2],
                'season' => $this->season,
                'season_type' => $this->season_type,
                'per_mode' => $this->per_mode,
                'status' => 'ON',
                'gp' => $p[7],
                'w' => $p[8],
                'l' => $p[9],
                'w_pct' => $p[10],
                'min' => $p[11],
                'fgm' => $p[12],
                'fga' => $p[13],
                'fg_pct' => $p[14],
                'fg3m' => $p[15],
                'fg3a' => $p[16],
                'fg3_pct' => $p[17],
                'ftm' => $p[18],
                'fta' => $p[19],
                'ft_pct' => $p[20],
                'oreb' => $p[21],
                'dreb' => $p[22],
                'reb' => $p[23],
                'ast' => $p[24],
                'pf' => $p[29],
                'pfd' => $p[30],
                'stl' => $p[26],
                'tov' => $p[25],
                'blk' => $p[27],
                'blka' => $p[28],
                'pts' => $p[31],
                'plus_minus' => $p[32],
                'gp_rank' => $p[33],
                'w_rank' => $p[34],
                'l_rank' => $p[35],
                'w_pct_rank' => $p[36],
                'min_rank' => $p[37],
                'fgm_rank' => $p[38],
                'fga_rank' => $p[39],
                'fg_pct_rank' => $p[40],
                'fg3m_rank' => $p[41],
                'fg3a_rank' => $p[42],
                'fg3_pct_rank' => $p[43],
                'ftm_rank' => $p[44],
                'fta_rank' => $p[45],
                'ft_pct_rank' => $p[46],
                'oreb_rank' => $p[47],
                'dreb_rank' => $p[48],
                'reb_rank' => $p[49],
                'ast_rank' => $p[50],
                'pf_rank' => $p[55],
                'pfd_rank' => $p[56],
                'stl_rank' => $p[52],
                'tov_rank' => $p[51],
                'blk_rank' => $p[53],
                'blka_rank' => $p[54],
                'pts_rank' => $p[57],
                'plus_minus_rank' => $p[58]
            ];
        }

        foreach ($this->data['resultSets'][2]['rowSet'] as $p) {
            $this->off[] = [
                'player_id' => $p[4],
                'player' => $p[5],
                'team_id' => $p[1],
                'team' => $p[2],
                'season' => $this->season,
                'season_type' => $this->season_type,
                'per_mode' => $this->per_mode,
                'status' => 'OFF',
                'gp' => $p[7],
                'w' => $p[8],
                'l' => $p[9],
                'w_pct' => $p[10],
                'min' => $p[11],
                'fgm' => $p[12],
                'fga' => $p[13],
                'fg_pct' => $p[14],
                'fg3m' => $p[15],
                'fg3a' => $p[16],
                'fg3_pct' => $p[17],
                'ftm' => $p[18],
                'fta' => $p[19],
                'ft_pct' => $p[20],
                'oreb' => $p[21],
                'dreb' => $p[22],
                'reb' => $p[23],
                'ast' => $p[24],
                'pf' => $p[29],
                'pfd' => $p[30],
                'stl' => $p[26],
                'tov' => $p[25],
                'blk' => $p[27],
                'blka' => $p[28],
                'pts' => $p[31],
                'plus_minus' => $p[32],
                'gp_rank' => $p[33],
                'w_rank' => $p[34],
                'l_rank' => $p[35],
                'w_pct_rank' => $p[36],
                'min_rank' => $p[37],
                'fgm_rank' => $p[38],
                'fga_rank' => $p[39],
                'fg_pct_rank' => $p[40],
                'fg3m_rank' => $p[41],
                'fg3a_rank' => $p[42],
                'fg3_pct_rank' => $p[43],
                'ftm_rank' => $p[44],
                'fta_rank' => $p[45],
                'ft_pct_rank' => $p[46],
                'oreb_rank' => $p[47],
                'dreb_rank' => $p[48],
                'reb_rank' => $p[49],
                'ast_rank' => $p[50],
                'pf_rank' => $p[55],
                'pfd_rank' => $p[56],
                'stl_rank' => $p[52],
                'tov_rank' => $p[51],
                'blk_rank' => $p[53],
                'blka_rank' => $p[54],
                'pts_rank' => $p[57],
                'plus_minus_rank' => $p[58]
            ];
        }

    }

    public function player(int $player_id): array
    {
        if (count($this->on) === 0 && count($this->off) === 0) {
            $this->fetch();
        }

        foreach ($this->on as $on) {
            if ($on['player_id'] === $player_id) {
                $this->player_only['on'] = $on;
            }
        }

        foreach ($this->off as $off) {
            if ($off['player_id'] === $player_id) {
                $this->player_only['off'] = $off;
            }
        }

        return $this->player_only;

    }

}