<?php

namespace Corbpie\NBALive;

class NBAStandings extends NBABase
{

    public array $standings = [];

    public array $east_standings = [];

    public array $west_standings = [];

    public function __construct(string $season = self::CURRENT_SEASON)
    {
        $teams = $this->ApiCall("https://stats.nba.com/stats/leaguestandingsv3?LeagueID=00&Season={$season}&SeasonType=Regular+Season&SeasonYear=");

        $league = $east = $west = 0;

        foreach ($teams['resultSets'][0]['rowSet'] as $team) {
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
                'home_record' => trim($team[18]),
                'road_record' => trim($team[19]),
            ];

            if ($team[6] === 'EAST') {
                $east++;
                $this->east_standings[] = [
                    'league_rank' => $league,
                    'conference_rank' => $east,
                    'team_id' => $team[2],
                    'conference' => $team[6],
                    'division' => $team[10],
                    'wins' => $team[13],
                    'losses' => $team[14],
                    'win_pct' => $team[15],
                    'home_record' => trim($team[18]),
                    'road_record' => trim($team[19]),
                ];
            } else {
                $west++;
                $this->west_standings[] = [
                    'league_rank' => $league,
                    'conference_rank' => $west,
                    'team_id' => $team[2],
                    'conference' => $team[6],
                    'division' => $team[10],
                    'wins' => $team[13],
                    'losses' => $team[14],
                    'win_pct' => $team[15],
                    'home_record' => trim($team[18]),
                    'road_record' => trim($team[19]),
                ];
            }

        }

    }

}