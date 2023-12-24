<?php

namespace Corbpie\NBALive;

class NBATeamLineups extends NBATeamDashFilters
{
    public int $players_amount = 5;

    public array $data = [];

    public array $details = [];

    public array $player_only = [];

    public function fetch(): void
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/teamdashlineups?GroupQuantity={$this->players_amount}&" . $this->build());

        if (isset($this->data['resultSets']['1']['rowSet'])) {
            foreach ($this->data['resultSets']['1']['rowSet'] as $values) {
                $player_id_array = explode("-", substr(substr($values[1], 1), 0, -1));
                $player_name_array = explode("-", $values[2]);
                $this->details[] = [
                    'players' => $this->players_amount,
                    'team_id' => $this->data['parameters']['TeamID'],
                    'season' => $this->data['parameters']['Season'],
                    'per_mode' => $this->data['parameters']['PerMode'],
                    'measure_type' => $this->data['parameters']['MeasureType'],
                    'player_1_id' => (isset($player_id_array[0])) ? (int)$player_id_array[0] : null,
                    'player_1_name' => (isset($player_name_array[0])) ? trim($player_name_array[0]) : null,
                    'player_2_id' => (isset($player_id_array[1])) ? (int)$player_id_array[1] : null,
                    'player_2_name' => (isset($player_name_array[1])) ? trim($player_name_array[1]) : null,
                    'player_3_id' => (isset($player_id_array[2])) ? (int)$player_id_array[2] : null,
                    'player_3_name' => (isset($player_name_array[2])) ? trim($player_name_array[2]) : null,
                    'player_4_id' => (isset($player_id_array[3])) ? (int)$player_id_array[3] : null,
                    'player_4_name' => (isset($player_name_array[3])) ? trim($player_name_array[3]) : null,
                    'player_5_id' => (isset($player_id_array[4])) ? (int)$player_id_array[4] : null,
                    'player_5_name' => (isset($player_name_array[4])) ? trim($player_name_array[4]) : null,
                    'gp' => $values[3],
                    'w' => $values[4],
                    'l' => $values[5],
                    'w_pct' => $values[6],
                    'min' => $values[7],
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
                    'tov' => $values[21],
                    'stl' => $values[22],
                    'blk' => $values[23],
                    'blka' => $values[24],
                    'pf' => $values[25],
                    'pfd' => $values[26],
                    'pts' => $values[27],
                    'plus_minus' => $values[28],
                    'gp_rank' => $values[29],
                    'w_rank' => $values[30],
                    'l_rank' => $values[31],
                    'w_pct_rank' => $values[32],
                    'min_rank' => $values[33],
                    'fgm_rank' => $values[34],
                    'fga_rank' => $values[35],
                    'fg_pct_rank' => $values[36],
                    'fg3m_rank' => $values[37],
                    'fg3a_rank' => $values[38],
                    'fg3_pct_rank' => $values[39],
                    'ftm_rank' => $values[40],
                    'fta_rank' => $values[41],
                    'ft_pct_rank' => $values[42],
                    'oreb_rank' => $values[43],
                    'dreb_rank' => $values[44],
                    'reb_rank' => $values[45],
                    'ast_rank' => $values[46],
                    'tov_rank' => $values[47],
                    'stl_rank' => $values[48],
                    'blk_rank' => $values[49],
                    'blka_rank' => $values[50],
                    'pf_rank' => $values[51],
                    'pfd_rank' => $values[52],
                    'pts_rank' => $values[53],
                    'plus_minus_rank' => $values[54]
                ];
            }
        }

    }

    public function playerOnly(int $player_id): array
    {
        if (!isset($this->details)) {
            $this->fetch();
        }

        foreach ($this->details as $lu) {
            if ($lu['player_1_id'] === $player_id || $lu['player_2_id'] === $player_id || $lu['player_3_id'] === $player_id || $lu['player_4_id'] === $player_id || $lu['player_5_id'] === $player_id) {
                $this->player_only[] = $lu;
            }
        }

        return $this->player_only;

    }

}