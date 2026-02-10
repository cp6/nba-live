<?php

namespace Corbpie\NBALive;

/**
 * Retrieve NBA league standings data.
 */
class NBAStandings extends NBABase
{
    // Standings API array indices - documented for maintainability
    private const IDX_TEAM_ID = 2;
    private const IDX_TEAM_NAME = 4;
    private const IDX_CONFERENCE = 6;
    private const IDX_DIVISION = 10;
    private const IDX_WINS = 13;
    private const IDX_LOSSES = 14;
    private const IDX_WIN_PCT = 15;
    private const IDX_HOME_RECORD = 18;
    private const IDX_ROAD_RECORD = 19;
    private const IDX_OT = 23;
    private const IDX_3PTS_OR_LESS = 24;
    private const IDX_10PTS_OR_MORE = 25;
    private const IDX_LONGEST_W_STREAK = 30;
    private const IDX_LONGEST_L_STREAK = 31;
    private const IDX_CURRENT_HOME_STREAK = 32;
    private const IDX_CURRENT_ROAD_STREAK = 34;
    private const IDX_CURRENT_STREAK = 36;
    private const IDX_CONF_GAMES_BACK = 38;
    private const IDX_DIV_GAMES_BACK = 39;
    private const IDX_CLINCHED_PLAYOFFS = 42;
    private const IDX_CLINCHED_PLAYIN = 43;
    private const IDX_ELIMINATED_CONF = 44;
    private const IDX_AHEAD_AT_HALF = 46;
    private const IDX_BEHIND_AT_HALF = 47;
    private const IDX_TIED_AT_HALF = 48;
    private const IDX_AHEAD_AT_THIRD = 49;
    private const IDX_BEHIND_AT_THIRD = 50;
    private const IDX_TIED_AT_THIRD = 51;
    private const IDX_SCORED_100_PTS = 52;
    private const IDX_OPP_SCORED_100_PTS = 53;
    private const IDX_OPP_OVER_500 = 54;
    private const IDX_LEAD_FGP = 55;
    private const IDX_LEAD_REB = 56;
    private const IDX_FEWER_TOV = 57;
    private const IDX_PTS_PG = 58;
    private const IDX_OPP_PTS_PG = 59;
    private const IDX_DIFF_PTS_PG = 60;
    private const IDX_VS_EAST = 61;
    private const IDX_VS_ATLANTIC = 62;
    private const IDX_VS_CENTRAL = 63;
    private const IDX_VS_SOUTHEAST = 64;
    private const IDX_VS_WEST = 65;
    private const IDX_VS_NORTHWEST = 66;
    private const IDX_VS_PACIFIC = 67;
    private const IDX_VS_SOUTHWEST = 68;
    private const IDX_TOTAL_PTS = 85;
    private const IDX_OPP_TOTAL_PTS = 86;
    private const IDX_DIFF_TOTAL_PTS = 87;
    private const IDX_LEAGUE_GAMES_BACK = 88;

    /** @var array Raw API response data */
    public array $data = [];

    /** @var array All teams standings */
    public array $standings = [];

    /** @var array Eastern Conference standings */
    public array $east_standings = [];

    /** @var array Western Conference standings */
    public array $west_standings = [];

    /**
     * Fetch NBA standings for a given season.
     *
     * @param string $season Season identifier (e.g., '2024-25')
     * @throws NBAApiException When the API request fails
     */
    public function __construct(string $season = self::CURRENT_SEASON)
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/leaguestandingsv3?LeagueID=00&Season={$season}&SeasonType=Regular+Season&SeasonYear=");

        $league = $east = $west = 0;

        if (isset($this->data['resultSets'][0]['rowSet'][0])) {
            foreach ($this->data['resultSets'][0]['rowSet'] as $team) {
                $league++;
                $baseStanding = $this->buildTeamStanding($team, $league);
                $this->standings[] = $baseStanding;

                if ($team[self::IDX_CONFERENCE] === 'East') {
                    $east++;
                    $this->east_standings[] = array_merge(
                        ['conference_rank' => $east],
                        $baseStanding
                    );
                } else {
                    $west++;
                    $this->west_standings[] = array_merge(
                        ['conference_rank' => $west],
                        $baseStanding
                    );
                }
            }
        }
    }

    /**
     * Build a team standing array from raw API data.
     *
     * @param array $team Raw team data from API
     * @param int $leagueRank Team's league-wide rank
     * @return array Formatted team standing data
     */
    private function buildTeamStanding(array $team, int $leagueRank): array
    {
        return [
            'league_rank' => $leagueRank,
            'team_id' => $team[self::IDX_TEAM_ID],
            'team' => $team[self::IDX_TEAM_NAME],
            'conference' => $team[self::IDX_CONFERENCE],
            'division' => $team[self::IDX_DIVISION],
            'wins' => $team[self::IDX_WINS],
            'losses' => $team[self::IDX_LOSSES],
            'win_pct' => $team[self::IDX_WIN_PCT],
            'gp' => ($team[self::IDX_WINS] + $team[self::IDX_LOSSES]),
            'league_games_back' => $team[self::IDX_LEAGUE_GAMES_BACK],
            'pts_pg' => $team[self::IDX_PTS_PG],
            'opp_pts_pg' => $team[self::IDX_OPP_PTS_PG],
            'diff_pts_pg' => $team[self::IDX_DIFF_PTS_PG],
            'total_pts' => $team[self::IDX_TOTAL_PTS],
            'opp_total_pts' => $team[self::IDX_OPP_TOTAL_PTS],
            'diff_total_pts' => $team[self::IDX_DIFF_TOTAL_PTS],
            'home_record' => trim($team[self::IDX_HOME_RECORD]),
            'road_record' => trim($team[self::IDX_ROAD_RECORD]),
            'ot' => trim($team[self::IDX_OT]),
            '3pts_or_less' => trim($team[self::IDX_3PTS_OR_LESS]),
            '10pts_or_more' => trim($team[self::IDX_10PTS_OR_MORE]),
            'longest_w_streak' => $team[self::IDX_LONGEST_W_STREAK],
            'longest_l_streak' => $team[self::IDX_LONGEST_L_STREAK],
            'current_home_streak' => $team[self::IDX_CURRENT_HOME_STREAK],
            'current_road_streak' => $team[self::IDX_CURRENT_ROAD_STREAK],
            'current_streak' => $team[self::IDX_CURRENT_STREAK],
            'conf_games_back' => $team[self::IDX_CONF_GAMES_BACK],
            'div_games_back' => $team[self::IDX_DIV_GAMES_BACK],
            'clinched_playoffs' => $team[self::IDX_CLINCHED_PLAYOFFS],
            'clinched_playin' => $team[self::IDX_CLINCHED_PLAYIN],
            'eliminated_conf' => $team[self::IDX_ELIMINATED_CONF],
            'ahead_at_half' => trim($team[self::IDX_AHEAD_AT_HALF]),
            'behind_at_Half' => trim($team[self::IDX_BEHIND_AT_HALF]),
            'tied_at_half' => trim($team[self::IDX_TIED_AT_HALF]),
            'ahead_at_third' => trim($team[self::IDX_AHEAD_AT_THIRD]),
            'behind_at_third' => trim($team[self::IDX_BEHIND_AT_THIRD]),
            'tied_at_third' => trim($team[self::IDX_TIED_AT_THIRD]),
            'scored_100_pts' => trim($team[self::IDX_SCORED_100_PTS]),
            'opp_scored_100_pts' => trim($team[self::IDX_OPP_SCORED_100_PTS]),
            'opp_over_500' => trim($team[self::IDX_OPP_OVER_500]),
            'lead_fgp' => trim($team[self::IDX_LEAD_FGP]),
            'lead_reb' => trim($team[self::IDX_LEAD_REB]),
            'fewer_tov' => trim($team[self::IDX_FEWER_TOV]),
            'vs_east' => $team[self::IDX_VS_EAST],
            'vs_west' => $team[self::IDX_VS_WEST],
            'vs_atlantic' => $team[self::IDX_VS_ATLANTIC],
            'vs_central' => $team[self::IDX_VS_CENTRAL],
            'vs_southeast' => $team[self::IDX_VS_SOUTHEAST],
            'vs_northwest' => $team[self::IDX_VS_NORTHWEST],
            'vs_pacific' => $team[self::IDX_VS_PACIFIC],
            'vs_southwest' => $team[self::IDX_VS_SOUTHWEST]
        ];
    }
}
