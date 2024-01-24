<?php

namespace Corbpie\NBALive;

class NBATeamEstimated extends NBABase
{
    public array $data = [];

    public array $teams = [];

    public function __construct($season = NBABase::CURRENT_SEASON, $season_type = NBABase::TYPE_REGULAR)
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/teamestimatedmetrics?LeagueID=00&Season={$season}&SeasonType={$season_type}");

        foreach ($this->data['resultSet']['rowSet'] as $t) {
            $this->teams[] = [
                'team_id' => $t[1],
                'team_name' => $t[0],
                'gp' => $t[2],
                'w' => $t[3],
                'l' => $t[4],
                'w_pct' => $t[5],
                'min' => $t[6],
                'e_off_rating' => $t[7],
                'e_def_rating' => $t[8],
                'e_net_rating' => $t[9],
                'e_pace' => $t[10],
                'e_ast_ration' => $t[11],
                'e_oreb_pct' => $t[12],
                'e_dreb_pct' => $t[13],
                'e_reb_pct' => $t[14],
                'e_tm_tov_pct' => $t[15],
                'gp_rank' => $t[16],
                'w_rank' => $t[17],
                'l_rank' => $t[18],
                'w_pct_rank' => $t[19],
                'min_rank' => $t[20],
                'e_off_rating_rank' => $t[21],
                'e_def_rating_rank' => $t[22],
                'e_net_rating_rank' => $t[23],
                'e_ast_ratio_rank' => $t[24],
                'e_oreb_pct_rank' => $t[25],
                'e_dreb_pct_rank' => $t[26],
                'e_reb_pct_rank' => $t[27],
                'e_tm_tov_pct_rank' => $t[28],
                'e_pace_rank' => $t[29]
            ];
        }

    }

    public function sortAsc(array $team_data, string $key = 'e_off_rating'): array
    {
        usort($team_data, fn($a, $b) => $a[$key] <=> $b[$key]);
        return $team_data;
    }

    public function sortDesc(array $team_data, string $key = 'e_def_rating'): array
    {
        usort($team_data, fn($a, $b) => $b[$key] <=> $a[$key]);
        return $team_data;
    }

}