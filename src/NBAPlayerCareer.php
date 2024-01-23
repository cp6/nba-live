<?php

namespace Corbpie\NBALive;

class NBAPlayerCareer extends NBABase
{

    public array $data = [];

    public array $season_totals_regular = [];

    public array $career_totals_regular = [];

    public array $season_totals_post = [];

    public array $career_totals_post = [];

    public array $season_totals_all_star = [];

    public array $career_totals_all_star = [];

    public array $season_totals_college = [];

    public array $career_totals_college = [];

    public array $season_totals_showcase = [];

    public array $career_totals_showcase = [];

    public array $season_rankings_regular = [];

    public array $season_rankings_post = [];

    public function __construct(int $player_id = 202331, string $per_mode = NBABase::MODE_TOTAL)
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/playercareerstats?LeagueID=&PerMode={$per_mode}&PlayerID={$player_id}");

        if (isset($this->data['resultSets'][0]['rowSet'])) {
            foreach ($this->data['resultSets'][0]['rowSet'] as $values) {
                $this->season_totals_regular[] = [
                    'season' => $values[1],
                    'team_id' => $values[3],
                    'team' => $values[4],
                    'player_age' => $values[5],
                    'gp' => $values[6],
                    'gs' => $values[7],
                    'min' => $values[8],
                    'fgm' => $values[9],
                    'fga' => $values[10],
                    'fg_pct' => $values[11],
                    'fg3m' => $values[12],
                    'fg3a' => $values[13],
                    'fg3_pct' => $values[14],
                    'ftm' => $values[15],
                    'fta' => $values[16],
                    'ft_pct' => $values[17],
                    'oreb' => $values[18],
                    'dreb' => $values[19],
                    'reb' => $values[20],
                    'ast' => $values[21],
                    'stl' => $values[22],
                    'blk' => $values[23],
                    'tov' => $values[24],
                    'pf' => $values[25],
                    'pts' => $values[26]
                ];
            }
        }

        if (isset($this->data['resultSets'][1]['rowSet'])) {
            foreach ($this->data['resultSets'][1]['rowSet'] as $values) {
                $this->career_totals_regular[] = [
                    'team_id' => $values[2],
                    'gp' => $values[3],
                    'gs' => $values[4],
                    'min' => $values[5],
                    'fgm' => $values[6],
                    'fga' => $values[7],
                    'fg_pct' => $values[8],
                    'fg3m' => $values[9],
                    'fg3a' => $values[10],
                    'fg3_pct' => $values[11],
                    'ftm' => $values[12],
                    'fta' => $values[13],
                    'ft_pct' => $values[14],
                    'oreb' => $values[15],
                    'dreb' => $values[16],
                    'reb' => $values[17],
                    'ast' => $values[18],
                    'stl' => $values[19],
                    'blk' => $values[20],
                    'tov' => $values[21],
                    'pf' => $values[22],
                    'pts' => $values[23]
                ];
            }
        }

        if (isset($this->data['resultSets'][2]['rowSet'])) {
            foreach ($this->data['resultSets'][2]['rowSet'] as $values) {
                $this->season_totals_post[] = [
                    'season' => $values[1],
                    'team_id' => $values[3],
                    'team' => $values[4],
                    'player_age' => $values[5],
                    'gp' => $values[6],
                    'gs' => $values[7],
                    'min' => $values[8],
                    'fgm' => $values[9],
                    'fga' => $values[10],
                    'fg_pct' => $values[11],
                    'fg3m' => $values[12],
                    'fg3a' => $values[13],
                    'fg3_pct' => $values[14],
                    'ftm' => $values[15],
                    'fta' => $values[16],
                    'ft_pct' => $values[17],
                    'oreb' => $values[18],
                    'dreb' => $values[19],
                    'reb' => $values[20],
                    'ast' => $values[21],
                    'stl' => $values[22],
                    'blk' => $values[23],
                    'tov' => $values[24],
                    'pf' => $values[25],
                    'pts' => $values[26]
                ];
            }
        }

        if (isset($this->data['resultSets'][3]['rowSet'])) {
            foreach ($this->data['resultSets'][3]['rowSet'] as $values) {
                $this->career_totals_post[] = [
                    'team_id' => $values[2],
                    'gp' => $values[3],
                    'gs' => $values[4],
                    'min' => $values[5],
                    'fgm' => $values[6],
                    'fga' => $values[7],
                    'fg_pct' => $values[8],
                    'fg3m' => $values[9],
                    'fg3a' => $values[10],
                    'fg3_pct' => $values[11],
                    'ftm' => $values[12],
                    'fta' => $values[13],
                    'ft_pct' => $values[14],
                    'oreb' => $values[15],
                    'dreb' => $values[16],
                    'reb' => $values[17],
                    'ast' => $values[18],
                    'stl' => $values[19],
                    'blk' => $values[20],
                    'tov' => $values[21],
                    'pf' => $values[22],
                    'pts' => $values[23]
                ];
            }
        }

        if (isset($this->data['resultSets'][4]['rowSet'])) {
            foreach ($this->data['resultSets'][4]['rowSet'] as $values) {
                $this->season_totals_all_star[] = [
                    'season' => $values[1],
                    'team_id' => $values[3],
                    'team' => $values[4],
                    'player_age' => $values[5],
                    'gp' => $values[6],
                    'gs' => $values[7],
                    'min' => $values[8],
                    'fgm' => $values[9],
                    'fga' => $values[10],
                    'fg_pct' => $values[11],
                    'fg3m' => $values[12],
                    'fg3a' => $values[13],
                    'fg3_pct' => $values[14],
                    'ftm' => $values[15],
                    'fta' => $values[16],
                    'ft_pct' => $values[17],
                    'oreb' => $values[18],
                    'dreb' => $values[19],
                    'reb' => $values[20],
                    'ast' => $values[21],
                    'stl' => $values[22],
                    'blk' => $values[23],
                    'tov' => $values[24],
                    'pf' => $values[25],
                    'pts' => $values[26]
                ];
            }
        }

        if (isset($this->data['resultSets'][5]['rowSet'])) {
            foreach ($this->data['resultSets'][5]['rowSet'] as $values) {
                $this->career_totals_all_star[] = [
                    'team_id' => $values[2],
                    'gp' => $values[3],
                    'gs' => $values[4],
                    'min' => $values[5],
                    'fgm' => $values[6],
                    'fga' => $values[7],
                    'fg_pct' => $values[8],
                    'fg3m' => $values[9],
                    'fg3a' => $values[10],
                    'fg3_pct' => $values[11],
                    'ftm' => $values[12],
                    'fta' => $values[13],
                    'ft_pct' => $values[14],
                    'oreb' => $values[15],
                    'dreb' => $values[16],
                    'reb' => $values[17],
                    'ast' => $values[18],
                    'stl' => $values[19],
                    'blk' => $values[20],
                    'tov' => $values[21],
                    'pf' => $values[22],
                    'pts' => $values[23]
                ];
            }
        }

        if (isset($this->data['resultSets'][6]['rowSet'])) {
            foreach ($this->data['resultSets'][6]['rowSet'] as $values) {
                $this->season_totals_college[] = [
                    'season' => $values[1],
                    'org_id' => $values[3],
                    'school' => $values[4],
                    'player_age' => $values[5],
                    'gp' => $values[6],
                    'gs' => $values[7],
                    'min' => $values[8],
                    'fgm' => $values[9],
                    'fga' => $values[10],
                    'fg_pct' => $values[11],
                    'fg3m' => $values[12],
                    'fg3a' => $values[13],
                    'fg3_pct' => $values[14],
                    'ftm' => $values[15],
                    'fta' => $values[16],
                    'ft_pct' => $values[17],
                    'oreb' => $values[18],
                    'dreb' => $values[19],
                    'reb' => $values[20],
                    'ast' => $values[21],
                    'stl' => $values[22],
                    'blk' => $values[23],
                    'tov' => $values[24],
                    'pf' => $values[25],
                    'pts' => $values[26]
                ];
            }
        }

        if (isset($this->data['resultSets'][7]['rowSet'])) {
            foreach ($this->data['resultSets'][7]['rowSet'] as $values) {
                $this->career_totals_college[] = [
                    'org_id' => $values[2],
                    'gp' => $values[3],
                    'gs' => $values[4],
                    'min' => $values[5],
                    'fgm' => $values[6],
                    'fga' => $values[7],
                    'fg_pct' => $values[8],
                    'fg3m' => $values[9],
                    'fg3a' => $values[10],
                    'fg3_pct' => $values[11],
                    'ftm' => $values[12],
                    'fta' => $values[13],
                    'ft_pct' => $values[14],
                    'oreb' => $values[15],
                    'dreb' => $values[16],
                    'reb' => $values[17],
                    'ast' => $values[18],
                    'stl' => $values[19],
                    'blk' => $values[20],
                    'tov' => $values[21],
                    'pf' => $values[22],
                    'pts' => $values[23]
                ];
            }
        }

        if (isset($this->data['resultSets'][8]['rowSet'])) {
            foreach ($this->data['resultSets'][8]['rowSet'] as $values) {
                $this->season_totals_showcase[] = [
                    'season' => $values[1],
                    'team_id' => $values[3],
                    'team' => $values[4],
                    'player_age' => $values[5],
                    'gp' => $values[6],
                    'gs' => $values[7],
                    'min' => $values[8],
                    'fgm' => $values[9],
                    'fga' => $values[10],
                    'fg_pct' => $values[11],
                    'fg3m' => $values[12],
                    'fg3a' => $values[13],
                    'fg3_pct' => $values[14],
                    'ftm' => $values[15],
                    'fta' => $values[16],
                    'ft_pct' => $values[17],
                    'oreb' => $values[18],
                    'dreb' => $values[19],
                    'reb' => $values[20],
                    'ast' => $values[21],
                    'stl' => $values[22],
                    'blk' => $values[23],
                    'tov' => $values[24],
                    'pf' => $values[25],
                    'pts' => $values[26]
                ];
            }
        }

        if (isset($this->data['resultSets'][9]['rowSet'])) {
            foreach ($this->data['resultSets'][9]['rowSet'] as $values) {
                $this->career_totals_showcase[] = [
                    'team_id' => $values[2],
                    'gp' => $values[3],
                    'gs' => $values[4],
                    'min' => $values[5],
                    'fgm' => $values[6],
                    'fga' => $values[7],
                    'fg_pct' => $values[8],
                    'fg3m' => $values[9],
                    'fg3a' => $values[10],
                    'fg3_pct' => $values[11],
                    'ftm' => $values[12],
                    'fta' => $values[13],
                    'ft_pct' => $values[14],
                    'oreb' => $values[15],
                    'dreb' => $values[16],
                    'reb' => $values[17],
                    'ast' => $values[18],
                    'stl' => $values[19],
                    'blk' => $values[20],
                    'tov' => $values[21],
                    'pf' => $values[22],
                    'pts' => $values[23]
                ];
            }
        }

        if (isset($this->data['resultSets'][10]['rowSet'])) {
            foreach ($this->data['resultSets'][10]['rowSet'] as $values) {
                $this->season_rankings_regular[] = [
                    'season' => $values[1],
                    'team_id' => $values[3],
                    'team' => $values[4],
                    'player_age' => $values[5],
                    'gp' => $values[6],
                    'gs' => $values[7],
                    'rank_min' => $values[8],
                    'rank_fgm' => $values[9],
                    'rank_fga' => $values[10],
                    'rank_fg_pct' => $values[11],
                    'rank_fg3m' => $values[12],
                    'rank_fg3a' => $values[13],
                    'rank_fg3_pct' => $values[14],
                    'rank_ftm' => $values[15],
                    'rank_fta' => $values[16],
                    'rank_ft_pct' => $values[17],
                    'rank_oreb' => $values[18],
                    'rank_dreb' => $values[19],
                    'rank_reb' => $values[20],
                    'rank_ast' => $values[21],
                    'rank_stl' => $values[22],
                    'rank_blk' => $values[23],
                    'rank_tov' => $values[24],
                    'rank_pts' => $values[25],
                    'rank_eff' => $values[26]
                ];
            }
        }

        if (isset($this->data['resultSets'][11]['rowSet'])) {
            foreach ($this->data['resultSets'][11]['rowSet'] as $values) {
                $this->season_rankings_post[] = [
                    'season' => $values[1],
                    'team_id' => $values[3],
                    'team' => $values[4],
                    'player_age' => $values[5],
                    'gp' => $values[6],
                    'gs' => $values[7],
                    'rank_min' => $values[8],
                    'rank_fgm' => $values[9],
                    'rank_fga' => $values[10],
                    'rank_fg_pct' => $values[11],
                    'rank_fg3m' => $values[12],
                    'rank_fg3a' => $values[13],
                    'rank_fg3_pct' => $values[14],
                    'rank_ftm' => $values[15],
                    'rank_fta' => $values[16],
                    'rank_ft_pct' => $values[17],
                    'rank_oreb' => $values[18],
                    'rank_dreb' => $values[19],
                    'rank_reb' => $values[20],
                    'rank_ast' => $values[21],
                    'rank_stl' => $values[22],
                    'rank_blk' => $values[23],
                    'rank_tov' => $values[24],
                    'rank_pts' => $values[25],
                    'rank_eff' => $values[26]
                ];
            }
        }

    }

}