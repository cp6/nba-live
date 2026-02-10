<?php

namespace Corbpie\NBALive;

/**
 * Retrieve detailed shot chart data with coordinates.
 */
class NBAShotChart extends NBABase
{
    /** @var array Raw API response data */
    public array $data = [];

    /** @var array All shots */
    public array $shots = [];

    /** @var array Made shots only */
    public array $made_shots = [];

    /** @var array Missed shots only */
    public array $missed_shots = [];

    /** @var array League averages */
    public array $league_averages = [];

    /**
     * Fetch shot chart data.
     *
     * @param int $player_id Player identifier (0 for team)
     * @param int $team_id Team identifier (0 for all)
     * @param string $season Season identifier
     * @param string $season_type Season type
     * @throws NBAApiException When the API request fails
     */
    public function __construct(
        int $player_id = 0,
        int $team_id = 0,
        string $season = self::CURRENT_SEASON,
        string $season_type = self::TYPE_REGULAR
    ) {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/shotchartdetail?AheadBehind=&ClutchTime=&ContextFilter=&ContextMeasure=FGA&DateFrom=&DateTo=&EndPeriod=10&EndRange=28800&GameID=&GameSegment=&LastNGames=0&LeagueID=00&Location=&Month=0&OpponentTeamID=0&Outcome=&Period=0&PlayerID={$player_id}&PlayerPosition=&PointDiff=&Position=&RangeType=0&RookieYear=&Season={$season}&SeasonSegment=&SeasonType={$season_type}&StartPeriod=1&StartRange=0&TeamID={$team_id}&VsConference=&VsDivision=");

        if (isset($this->data['resultSets'][0]['rowSet'])) {
            foreach ($this->data['resultSets'][0]['rowSet'] as $s) {
                $shot = [
                    'grid_type' => $s[0] ?? '',
                    'game_id' => $s[1] ?? '',
                    'game_event_id' => $s[2] ?? 0,
                    'player_id' => $s[3] ?? 0,
                    'player_name' => $s[4] ?? '',
                    'team_id' => $s[5] ?? 0,
                    'team_name' => $s[6] ?? '',
                    'period' => $s[7] ?? 0,
                    'minutes_remaining' => $s[8] ?? 0,
                    'seconds_remaining' => $s[9] ?? 0,
                    'event_type' => $s[10] ?? '',
                    'action_type' => $s[11] ?? '',
                    'shot_type' => $s[12] ?? '',
                    'shot_zone_basic' => $s[13] ?? '',
                    'shot_zone_area' => $s[14] ?? '',
                    'shot_zone_range' => $s[15] ?? '',
                    'shot_distance' => $s[16] ?? 0,
                    'loc_x' => $s[17] ?? 0,
                    'loc_y' => $s[18] ?? 0,
                    'shot_attempted' => $s[19] ?? 0,
                    'shot_made' => $s[20] ?? 0,
                    'game_date' => $s[21] ?? '',
                    'home_team' => $s[22] ?? '',
                    'away_team' => $s[23] ?? '',
                ];

                $this->shots[] = $shot;

                if (($shot['shot_made'] ?? 0) === 1) {
                    $this->made_shots[] = $shot;
                } else {
                    $this->missed_shots[] = $shot;
                }
            }
        }

        if (isset($this->data['resultSets'][1]['rowSet'])) {
            foreach ($this->data['resultSets'][1]['rowSet'] as $avg) {
                $this->league_averages[] = [
                    'grid_type' => $avg[0] ?? '',
                    'shot_zone_basic' => $avg[1] ?? '',
                    'shot_zone_area' => $avg[2] ?? '',
                    'shot_zone_range' => $avg[3] ?? '',
                    'fga' => $avg[4] ?? 0,
                    'fgm' => $avg[5] ?? 0,
                    'fg_pct' => $avg[6] ?? 0,
                ];
            }
        }
    }

    /**
     * Get shots by zone.
     *
     * @param string $zone Zone name (e.g., 'Restricted Area', 'Mid-Range')
     * @return array Shots in the specified zone
     */
    public function byZone(string $zone): array
    {
        return array_filter($this->shots, fn($s) => ($s['shot_zone_basic'] ?? '') === $zone);
    }

    /**
     * Get shooting percentage.
     *
     * @return float Shooting percentage
     */
    public function getShootingPct(): float
    {
        $total = count($this->shots);
        if ($total === 0) return 0.0;
        return round(count($this->made_shots) / $total * 100, 1);
    }
}
