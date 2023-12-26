<?php

namespace Corbpie\NBALive;

class NBAPlayerShooting extends NBAPlayerDashFilters
{
    public array $data = [];

    public array $shot_5ft = [];

    public array $shot_8ft = [];

    public array $shot_area = [];

    public array $assisted = [];

    public array $shot_types_summary = [];

    public array $shot_types = [];

    public array $assisted_by = [];

    public function fetch(): array
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/playerdashboardbyshootingsplits?" . $this->build());

        if (isset($this->data['resultSets']['1']['rowSet'])) {
            foreach ($this->data['resultSets']['1']['rowSet'] as $values) {
                $this->shot_5ft[] = [
                    'group_set' => $values[0],
                    'group_value' => $values[1],
                    'player_id' => $this->data['parameters']['PlayerID'],
                    'season' => $this->data['parameters']['Season'],
                    'per_mode' => $this->data['parameters']['PerMode'],
                    'fgm' => $values[2],
                    'fga' => $values[3],
                    'fg_pct' => $values[4],
                    'fg3m' => $values[5],
                    'fg3a' => $values[6],
                    'fg3_pct' => $values[7],
                    'efg_pct' => $values[8],
                    'blka' => $values[9],
                    'pct_ast_2pm' => $values[10],
                    'pct_uast_2pm' => $values[11],
                    'pct_ast_3pm' => $values[12],
                    'pct_uast_3pm' => $values[13],
                    'pct_ast_fgm' => $values[14],
                    'pct_uast_fgm' => $values[15],
                    'fgm_rank' => $values[16],
                    'fga_rank' => $values[17],
                    'fg_pct_rank' => $values[18],
                    'fg3m_rank' => $values[19],
                    'fg3a_rank' => $values[20],
                    'fg3_pct_rank' => $values[21],
                    'efg_pct_rank' => $values[22],
                    'blka_rank' => $values[23],
                    'pct_ast_2pm_rank' => $values[24],
                    'pct_uast_2pm_rank' => $values[25],
                    'pct_ast_3pm_rank' => $values[26],
                    'pct_uast_3pm_rank' => $values[27],
                    'pct_ast_fgm_rank' => $values[28],
                    'pct_uast_fgm_rank' => $values[29]
                ];
            }
        }

        if (isset($this->data['resultSets']['2']['rowSet'])) {
            foreach ($this->data['resultSets']['2']['rowSet'] as $values) {
                $this->shot_8ft[] = [
                    'group_set' => $values[0],
                    'group_value' => $values[1],
                    'player_id' => $this->data['parameters']['PlayerID'],
                    'season' => $this->data['parameters']['Season'],
                    'per_mode' => $this->data['parameters']['PerMode'],
                    'fgm' => $values[2],
                    'fga' => $values[3],
                    'fg_pct' => $values[4],
                    'fg3m' => $values[5],
                    'fg3a' => $values[6],
                    'fg3_pct' => $values[7],
                    'efg_pct' => $values[8],
                    'blka' => $values[9],
                    'pct_ast_2pm' => $values[10],
                    'pct_uast_2pm' => $values[11],
                    'pct_ast_3pm' => $values[12],
                    'pct_uast_3pm' => $values[13],
                    'pct_ast_fgm' => $values[14],
                    'pct_uast_fgm' => $values[15],
                    'fgm_rank' => $values[16],
                    'fga_rank' => $values[17],
                    'fg_pct_rank' => $values[18],
                    'fg3m_rank' => $values[19],
                    'fg3a_rank' => $values[20],
                    'fg3_pct_rank' => $values[21],
                    'efg_pct_rank' => $values[22],
                    'blka_rank' => $values[23],
                    'pct_ast_2pm_rank' => $values[24],
                    'pct_uast_2pm_rank' => $values[25],
                    'pct_ast_3pm_rank' => $values[26],
                    'pct_uast_3pm_rank' => $values[27],
                    'pct_ast_fgm_rank' => $values[28],
                    'pct_uast_fgm_rank' => $values[29]
                ];
            }
        }

        if (isset($this->data['resultSets']['3']['rowSet'])) {
            foreach ($this->data['resultSets']['3']['rowSet'] as $values) {
                $this->shot_area[] = [
                    'group_set' => $values[0],
                    'group_value' => $values[1],
                    'player_id' => $this->data['parameters']['PlayerID'],
                    'season' => $this->data['parameters']['Season'],
                    'per_mode' => $this->data['parameters']['PerMode'],
                    'fgm' => $values[2],
                    'fga' => $values[3],
                    'fg_pct' => $values[4],
                    'fg3m' => $values[5],
                    'fg3a' => $values[6],
                    'fg3_pct' => $values[7],
                    'efg_pct' => $values[8],
                    'blka' => $values[9],
                    'pct_ast_2pm' => $values[10],
                    'pct_uast_2pm' => $values[11],
                    'pct_ast_3pm' => $values[12],
                    'pct_uast_3pm' => $values[13],
                    'pct_ast_fgm' => $values[14],
                    'pct_uast_fgm' => $values[15],
                    'fgm_rank' => $values[16],
                    'fga_rank' => $values[17],
                    'fg_pct_rank' => $values[18],
                    'fg3m_rank' => $values[19],
                    'fg3a_rank' => $values[20],
                    'fg3_pct_rank' => $values[21],
                    'efg_pct_rank' => $values[22],
                    'blka_rank' => $values[23],
                    'pct_ast_2pm_rank' => $values[24],
                    'pct_uast_2pm_rank' => $values[25],
                    'pct_ast_3pm_rank' => $values[26],
                    'pct_uast_3pm_rank' => $values[27],
                    'pct_ast_fgm_rank' => $values[28],
                    'pct_uast_fgm_rank' => $values[29]
                ];
            }
        }

        if (isset($this->data['resultSets']['4']['rowSet'])) {
            foreach ($this->data['resultSets']['4']['rowSet'] as $values) {
                $this->assisted[] = [
                    'group_set' => $values[0],
                    'group_value' => $values[1],
                    'player_id' => $this->data['parameters']['PlayerID'],
                    'season' => $this->data['parameters']['Season'],
                    'per_mode' => $this->data['parameters']['PerMode'],
                    'fgm' => $values[2],
                    'fga' => $values[3],
                    'fg_pct' => $values[4],
                    'fg3m' => $values[5],
                    'fg3a' => $values[6],
                    'fg3_pct' => $values[7],
                    'efg_pct' => $values[8],
                    'blka' => $values[9],
                    'pct_ast_2pm' => $values[10],
                    'pct_uast_2pm' => $values[11],
                    'pct_ast_3pm' => $values[12],
                    'pct_uast_3pm' => $values[13],
                    'pct_ast_fgm' => $values[14],
                    'pct_uast_fgm' => $values[15],
                    'fgm_rank' => $values[16],
                    'fga_rank' => $values[17],
                    'fg_pct_rank' => $values[18],
                    'fg3m_rank' => $values[19],
                    'fg3a_rank' => $values[20],
                    'fg3_pct_rank' => $values[21],
                    'efg_pct_rank' => $values[22],
                    'blka_rank' => $values[23],
                    'pct_ast_2pm_rank' => $values[24],
                    'pct_uast_2pm_rank' => $values[25],
                    'pct_ast_3pm_rank' => $values[26],
                    'pct_uast_3pm_rank' => $values[27],
                    'pct_ast_fgm_rank' => $values[28],
                    'pct_uast_fgm_rank' => $values[29]
                ];
            }
        }

        if (isset($this->data['resultSets']['5']['rowSet'])) {
            foreach ($this->data['resultSets']['5']['rowSet'] as $values) {
                $this->shot_types_summary[] = [
                    'group_set' => $values[0],
                    'group_value' => $values[1],
                    'player_id' => $this->data['parameters']['PlayerID'],
                    'season' => $this->data['parameters']['Season'],
                    'per_mode' => $this->data['parameters']['PerMode'],
                    'fgm' => $values[2],
                    'fga' => $values[3],
                    'fg_pct' => $values[4],
                    'fg3m' => $values[5],
                    'fg3a' => $values[6],
                    'fg3_pct' => $values[7],
                    'efg_pct' => $values[8],
                    'blka' => $values[9],
                    'pct_ast_2pm' => $values[10],
                    'pct_uast_2pm' => $values[11],
                    'pct_ast_3pm' => $values[12],
                    'pct_uast_3pm' => $values[13],
                    'pct_ast_fgm' => $values[14],
                    'pct_uast_fgm' => $values[15]
                ];
            }
        }

        if (isset($this->data['resultSets']['6']['rowSet'])) {
            foreach ($this->data['resultSets']['6']['rowSet'] as $values) {
                $this->shot_types[] = [
                    'group_set' => $values[0],
                    'group_value' => $values[1],
                    'player_id' => $this->data['parameters']['PlayerID'],
                    'season' => $this->data['parameters']['Season'],
                    'per_mode' => $this->data['parameters']['PerMode'],
                    'fgm' => $values[2],
                    'fga' => $values[3],
                    'fg_pct' => $values[4],
                    'fg3m' => $values[5],
                    'fg3a' => $values[6],
                    'fg3_pct' => $values[7],
                    'efg_pct' => $values[8],
                    'blka' => $values[9],
                    'pct_ast_2pm' => $values[10],
                    'pct_uast_2pm' => $values[11],
                    'pct_ast_3pm' => $values[12],
                    'pct_uast_3pm' => $values[13],
                    'pct_ast_fgm' => $values[14],
                    'pct_uast_fgm' => $values[15],
                    'fgm_rank' => $values[16],
                    'fga_rank' => $values[17],
                    'fg_pct_rank' => $values[18],
                    'fg3m_rank' => $values[19],
                    'fg3a_rank' => $values[20],
                    'fg3_pct_rank' => $values[21],
                    'efg_pct_rank' => $values[22],
                    'blka_rank' => $values[23],
                    'pct_ast_2pm_rank' => $values[24],
                    'pct_uast_2pm_rank' => $values[25],
                    'pct_ast_3pm_rank' => $values[26],
                    'pct_uast_3pm_rank' => $values[27],
                    'pct_ast_fgm_rank' => $values[28],
                    'pct_uast_fgm_rank' => $values[29]
                ];
            }
        }

        if (isset($this->data['resultSets']['7']['rowSet'])) {
            foreach ($this->data['resultSets']['7']['rowSet'] as $values) {
                $this->assisted_by[] = [
                    'group_set' => $values[0],
                    'group_value' => null,
                    'player_id' => $this->data['parameters']['PlayerID'],
                    'season' => $this->data['parameters']['Season'],
                    'per_mode' => $this->data['parameters']['PerMode'],
                    'assisted_by_player_id' => $values[1],
                    'assisted_by' => $values[2],
                    'fgm' => $values[3],
                    'fga' => $values[4],
                    'fg_pct' => $values[5],
                    'fg3m' => $values[6],
                    'fg3a' => $values[7],
                    'fg3_pct' => $values[8],
                    'efg_pct' => $values[9],
                    'blka' => $values[10],
                    'pct_ast_2pm' => $values[11],
                    'pct_uast_2pm' => $values[12],
                    'pct_ast_3pm' => $values[13],
                    'pct_uast_3pm' => $values[14],
                    'pct_ast_fgm' => $values[15],
                    'pct_uast_fgm' => $values[16],
                    'fgm_rank' => $values[17],
                    'fga_rank' => $values[18],
                    'fg_pct_rank' => $values[19],
                    'fg3m_rank' => $values[20],
                    'fg3a_rank' => $values[21],
                    'fg3_pct_rank' => $values[22],
                    'efg_pct_rank' => $values[23],
                    'blka_rank' => $values[24],
                    'pct_ast_2pm_rank' => $values[25],
                    'pct_uast_2pm_rank' => $values[26],
                    'pct_ast_3pm_rank' => $values[27],
                    'pct_uast_3pm_rank' => $values[28],
                    'pct_ast_fgm_rank' => $values[29],
                    'pct_uast_fgm_rank' => $values[30]
                ];
            }
        }

        return $this->data;
    }

}