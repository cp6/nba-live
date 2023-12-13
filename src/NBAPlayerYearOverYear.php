<?php

namespace Corbpie\NBALive;

class NBAPlayerYearOverYear extends NBAPlayerDashFilters
{

    public array $data = [];

    public array $season_array = [];

    public array $details = [];

    public function fetch(): array
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/playerdashboardbyyearoveryear?" . $this->build());

        if (isset($this->data['resultSets']['0']['rowSet'])) {
            foreach ($this->data['resultSets']['0']['rowSet'] as $values) {
                $this->season_array = [
                    'group_set' => $values[0],
                    'group_value' => $values[1],
                    'team_id' => $values[2],
                    'team_abbreviation' => $values[3],
                    'max_game_date' => $values[4],
                    'gp' => $values[5],
                    'w' => $values[6],
                    'l' => $values[7],
                    'w_pct' => $values[8],
                    'min' => $values[9],
                    'fgm' => $values[10],
                    'fga' => $values[11],
                    'fg_pct' => $values[12],
                    'fg3m' => $values[13],
                    'fg3a' => $values[14],
                    'fg3_pct' => $values[15],
                    'ftm' => $values[16],
                    'fta' => $values[17],
                    'ft_pct' => $values[18],
                    'oreb' => $values[19],
                    'dreb' => $values[20],
                    'reb' => $values[21],
                    'ast' => $values[22],
                    'tov' => $values[23],
                    'stl' => $values[24],
                    'blk' => $values[25],
                    'blka' => $values[26],
                    'pf' => $values[27],
                    'pfd' => $values[28],
                    'pts' => $values[29],
                    'plus_minus' => $values[30],
                    'nba_fantasy_pts' => $values[31],
                    'dd2' => $values[32],
                    'td3' => $values[33],
                    'wnba_fantasy_pts' => $values[34],
                    'gp_rank' => $values[35],
                    'w_rank' => $values[36],
                    'l_rank' => $values[37],
                    'w_pct_rank' => $values[38],
                    'min_rank' => $values[39],
                    'fgm_rank' => $values[40],
                    'fga_rank' => $values[41],
                    'fg_pct_rank' => $values[42],
                    'fg3m_rank' => $values[43],
                    'fg3a_rank' => $values[44],
                    'fg3_pct_rank' => $values[45],
                    'ftm_rank' => $values[46],
                    'fta_rank' => $values[47],
                    'ft_pct_rank' => $values[48],
                    'oreb_rank' => $values[49],
                    'dreb_rank' => $values[50],
                    'reb_rank' => $values[51],
                    'ast_rank' => $values[52],
                    'tov_rank' => $values[53],
                    'stl_rank' => $values[54],
                    'blk_rank' => $values[55],
                    'blka_rank' => $values[56],
                    'pf_rank' => $values[57],
                    'pfd_rank' => $values[58],
                    'pts_rank' => $values[59],
                    'plus_minus_rank' => $values[60],
                    'nba_fantasy_pts_rank' => $values[61],
                    'dd2_rank' => $values[62],
                    'td3_rank' => $values[63],
                    'wnba_fantasy_pts_rank' => $values[64]
                ];
            }
        }

        if (isset($this->data['resultSets']['1']['rowSet'])) {
            foreach ($this->data['resultSets']['1']['rowSet'] as $values) {
                $this->details[] = [
                    'group_set' => $values[0],
                    'group_value' => $values[1],
                    'team_id' => $values[2],
                    'team_abbreviation' => $values[3],
                    'max_game_date' => $values[4],
                    'gp' => $values[5],
                    'w' => $values[6],
                    'l' => $values[7],
                    'w_pct' => $values[8],
                    'min' => $values[9],
                    'fgm' => $values[10],
                    'fga' => $values[11],
                    'fg_pct' => $values[12],
                    'fg3m' => $values[13],
                    'fg3a' => $values[14],
                    'fg3_pct' => $values[15],
                    'ftm' => $values[16],
                    'fta' => $values[17],
                    'ft_pct' => $values[18],
                    'oreb' => $values[19],
                    'dreb' => $values[20],
                    'reb' => $values[21],
                    'ast' => $values[22],
                    'tov' => $values[23],
                    'stl' => $values[24],
                    'blk' => $values[25],
                    'blka' => $values[26],
                    'pf' => $values[27],
                    'pfd' => $values[28],
                    'pts' => $values[29],
                    'plus_minus' => $values[30],
                    'nba_fantasy_pts' => $values[31],
                    'dd2' => $values[32],
                    'td3' => $values[33],
                    'wnba_fantasy_pts' => $values[34],
                    'gp_rank' => $values[35],
                    'w_rank' => $values[36],
                    'l_rank' => $values[37],
                    'w_pct_rank' => $values[38],
                    'min_rank' => $values[39],
                    'fgm_rank' => $values[40],
                    'fga_rank' => $values[41],
                    'fg_pct_rank' => $values[42],
                    'fg3m_rank' => $values[43],
                    'fg3a_rank' => $values[44],
                    'fg3_pct_rank' => $values[45],
                    'ftm_rank' => $values[46],
                    'fta_rank' => $values[47],
                    'ft_pct_rank' => $values[48],
                    'oreb_rank' => $values[49],
                    'dreb_rank' => $values[50],
                    'reb_rank' => $values[51],
                    'ast_rank' => $values[52],
                    'tov_rank' => $values[53],
                    'stl_rank' => $values[54],
                    'blk_rank' => $values[55],
                    'blka_rank' => $values[56],
                    'pf_rank' => $values[57],
                    'pfd_rank' => $values[58],
                    'pts_rank' => $values[59],
                    'plus_minus_rank' => $values[60],
                    'nba_fantasy_pts_rank' => $values[61],
                    'dd2_rank' => $values[62],
                    'td3_rank' => $values[63],
                    'wnba_fantasy_pts_rank' => $values[64]
                ];
            }
        }

        return $this->data;
    }

}