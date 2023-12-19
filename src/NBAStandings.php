<?php

namespace Corbpie\NBALive;

class NBAStandings extends NBABase
{

    public array $data = [];

    public array $standings = [];

    public array $east_standings = [];

    public array $west_standings = [];

    public function __construct(string $season = self::CURRENT_SEASON)
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/leaguestandingsv3?LeagueID=00&Season={$season}&SeasonType=Regular+Season&SeasonYear=");

        $league = $east = $west = 0;

        foreach ($this->data['resultSets'][0]['rowSet'] as $team) {
            $league++;
            $this->standings[] = [
                'league_rank' => $league,
                'team_id' => $team[2],
                'team' => $team[4],
                'conference' => $team[6],
                'division' => $team[10],
                'wins' => $team[13],
                'losses' => $team[14],
                'win_pct' => $team[15],
                'gp' => ($team[13] + $team[14]),
                'league_games_back' => $team[88],
                'pts_pg' => $team[58],
                'opp_pts_pg' => $team[59],
                'diff_pts_pg' => $team[60],
                'total_pts' => $team[85],
                'opp_total_pts' => $team[86],
                'diff_total_pts' => $team[87],
                'home_record' => trim($team[18]),
                'road_record' => trim($team[19]),
                'ot' => trim($team[23]),
                '3pts_or_less' => trim($team[24]),
                '10pts_or_more' => trim($team[25]),
                'longest_w_streak' => $team[30],
                'longest_l_streak' => $team[31],
                'current_home_streak' => $team[32],
                'current_road_streak' => $team[34],
                'current_streak' => $team[36],
                'conf_games_back' => $team[38],
                'div_games_back' => $team[39],
                'clinched_playoffs' => $team[42],
                'clinched_playin' => $team[43],
                'eliminated_conf' => $team[44],
                'ahead_at_half' => trim($team[46]),
                'behind_at_Half' => trim($team[47]),
                'tied_at_half' => trim($team[48]),
                'ahead_at_third' => trim($team[49]),
                'behind_at_third' => trim($team[50]),
                'tied_at_third' => trim($team[51]),
                'scored_100_pts' => trim($team[52]),
                'opp_scored_100_pts' => trim($team[53]),
                'opp_over_500' => trim($team[54]),
                'lead_fgp' => trim($team[55]),
                'lead_reb' => trim($team[56]),
                'fewer_tov' => trim($team[57]),
                'vs_east' => $team[61],
                'vs_west' => $team[65],
                'vs_atlantic' => $team[62],
                'vs_central' => $team[63],
                'vs_southeast' => $team[64],
                'vs_northwest' => $team[66],
                'vs_pacific' => $team[67],
                'vs_southwest' => $team[68]
            ];

            if ($team[6] === 'East') {
                $east++;
                $this->east_standings[] = [
                    'league_rank' => $league,
                    'conference_rank' => $east,
                    'team_id' => $team[2],
                    'team' => $team[4],
                    'conference' => $team[6],
                    'division' => $team[10],
                    'wins' => $team[13],
                    'losses' => $team[14],
                    'win_pct' => $team[15],
                    'gp' => ($team[13] + $team[14]),
                    'league_games_back' => $team[88],
                    'pts_pg' => $team[58],
                    'opp_pts_pg' => $team[59],
                    'diff_pts_pg' => $team[60],
                    'total_pts' => $team[85],
                    'opp_total_pts' => $team[86],
                    'diff_total_pts' => $team[87],
                    'home_record' => trim($team[18]),
                    'road_record' => trim($team[19]),
                    'ot' => trim($team[23]),
                    '3pts_or_less' => trim($team[24]),
                    '10pts_or_more' => trim($team[25]),
                    'longest_w_streak' => $team[30],
                    'longest_l_streak' => $team[31],
                    'current_home_streak' => $team[32],
                    'current_road_streak' => $team[34],
                    'current_streak' => $team[36],
                    'conf_games_back' => $team[38],
                    'div_games_back' => $team[39],
                    'clinched_playoffs' => $team[42],
                    'clinched_playin' => $team[43],
                    'eliminated_conf' => $team[44],
                    'ahead_at_half' => trim($team[46]),
                    'behind_at_Half' => trim($team[47]),
                    'tied_at_half' => trim($team[48]),
                    'ahead_at_third' => trim($team[49]),
                    'behind_at_third' => trim($team[50]),
                    'tied_at_third' => trim($team[51]),
                    'scored_100_pts' => trim($team[52]),
                    'opp_scored_100_pts' => trim($team[53]),
                    'opp_over_500' => trim($team[54]),
                    'lead_fgp' => trim($team[55]),
                    'lead_reb' => trim($team[56]),
                    'fewer_tov' => trim($team[57]),
                    'vs_east' => $team[61],
                    'vs_west' => $team[65],
                    'vs_atlantic' => $team[62],
                    'vs_central' => $team[63],
                    'vs_southeast' => $team[64],
                    'vs_northwest' => $team[66],
                    'vs_pacific' => $team[67],
                    'vs_southwest' => $team[68]
                ];
            } else {
                $west++;
                $this->west_standings[] = [
                    'league_rank' => $league,
                    'conference_rank' => $west,
                    'team_id' => $team[2],
                    'team' => $team[4],
                    'conference' => $team[6],
                    'division' => $team[10],
                    'wins' => $team[13],
                    'losses' => $team[14],
                    'win_pct' => $team[15],
                    'gp' => ($team[13] + $team[14]),
                    'league_games_back' => $team[88],
                    'pts_pg' => $team[58],
                    'opp_pts_pg' => $team[59],
                    'diff_pts_pg' => $team[60],
                    'total_pts' => $team[85],
                    'opp_total_pts' => $team[86],
                    'diff_total_pts' => $team[87],
                    'home_record' => trim($team[18]),
                    'road_record' => trim($team[19]),
                    'ot' => trim($team[23]),
                    '3pts_or_less' => trim($team[24]),
                    '10pts_or_more' => trim($team[25]),
                    'longest_w_streak' => $team[30],
                    'longest_l_streak' => $team[31],
                    'current_home_streak' => $team[32],
                    'current_road_streak' => $team[34],
                    'current_streak' => $team[36],
                    'conf_games_back' => $team[38],
                    'div_games_back' => $team[39],
                    'clinched_playoffs' => $team[42],
                    'clinched_playin' => $team[43],
                    'eliminated_conf' => $team[44],
                    'ahead_at_half' => trim($team[46]),
                    'behind_at_Half' => trim($team[47]),
                    'tied_at_half' => trim($team[48]),
                    'ahead_at_third' => trim($team[49]),
                    'behind_at_third' => trim($team[50]),
                    'tied_at_third' => trim($team[51]),
                    'scored_100_pts' => trim($team[52]),
                    'opp_scored_100_pts' => trim($team[53]),
                    'opp_over_500' => trim($team[54]),
                    'lead_fgp' => trim($team[55]),
                    'lead_reb' => trim($team[56]),
                    'fewer_tov' => trim($team[57]),
                    'vs_east' => $team[61],
                    'vs_west' => $team[65],
                    'vs_atlantic' => $team[62],
                    'vs_central' => $team[63],
                    'vs_southeast' => $team[64],
                    'vs_northwest' => $team[66],
                    'vs_pacific' => $team[67],
                    'vs_southwest' => $team[68]
                ];
            }

        }

    }

}