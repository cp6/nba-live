<?php

namespace Corbpie\NBALive;

/**
 * Retrieve NBA game rotation data showing player substitution patterns.
 */
class NBARotations extends NBABase
{
    /** @var array Raw API response data */
    public array $data = [];

    /** @var array Processed rotation details */
    public array $details = [];

    /**
     * Fetch rotation data for a specific game.
     *
     * @param string $game_id NBA game identifier
     * @throws NBAApiException When the API request fails
     */
    public function __construct(string $game_id = '')
    {
        if (!isset($this->game_id)) {
            $this->game_id = $game_id;
        }

        $this->data = $this->ApiCall("https://stats.nba.com/stats/gamerotation?GameID={$this->game_id}&LeagueID=00");

        $rotations = $this->data['resultSets'][0]['rowSet'] ?? [];

        foreach ($rotations as $r) {
            $in_seconds = (int)(($r[7] ?? 0) / 10);
            $out_seconds = (int)(($r[8] ?? 0) / 10);

            $in_qtr = $this->timeAsQtr($in_seconds);
            $out_qtr = $this->timeAsQtr($out_seconds);

            $total_time = gmdate("i:s", $out_seconds - $in_seconds);

            $in_time_string = gmdate("i:s", $in_seconds);
            $out_time_string = gmdate("i:s", $out_seconds);

            $in_time_left_qtr = $this->timeLeftInQtr($in_seconds);
            $out_time_left_qtr = $this->timeLeftInQtr($out_seconds);

            $in_time_left = gmdate("i:s", $in_time_left_qtr);
            $out_time_left = gmdate("i:s", $out_time_left_qtr);

            $firstName = $r[5] ?? '';
            $lastName = $r[6] ?? '';
            $playerName = (!empty($firstName) ? $firstName[0] . '.' : '') . $lastName;

            $this->details[] = [
                'team_id' => $r[1] ?? 0,
                'team_short' => $r[3] ?? '',
                'player_id' => $r[4] ?? 0,
                'player_name' => $playerName,
                'in_period' => $in_qtr,
                'in' => $in_time_string,
                'in_time_left' => $in_time_left,
                'out_period' => $out_qtr,
                'out' => $out_time_string,
                'out_time_left' => $out_time_left,
                'total_time' => $total_time,
                'pts' => $r[9] ?? 0,
                'pts_diff' => $r[10] ?? 0,
                'usg_pct' => $r[11] ?? 0,
            ];
        }
    }

    /**
     * Determine which quarter/period a given time falls into.
     *
     * @param int $seconds Total seconds elapsed in the game
     * @return int Period number (1-7, where 5+ are overtime periods)
     */
    public function timeAsQtr(int $seconds): int
    {
        $boundaries = [
            1 => self::QUARTER_DURATION_SECONDS,
            2 => self::QUARTER_DURATION_SECONDS * 2,
            3 => self::QUARTER_DURATION_SECONDS * 3,
            4 => self::QUARTER_DURATION_SECONDS * 4,
            5 => self::QUARTER_DURATION_SECONDS * 4 + self::OT_DURATION_SECONDS,
            6 => self::QUARTER_DURATION_SECONDS * 4 + self::OT_DURATION_SECONDS * 2,
        ];

        foreach ($boundaries as $period => $maxSeconds) {
            if ($seconds <= $maxSeconds) {
                return $period;
            }
        }

        return 7; // OT3+
    }

    /**
     * Calculate time remaining in the current quarter/period.
     *
     * @param int $seconds Total seconds elapsed in the game
     * @return int Seconds remaining in the current period
     */
    public function timeLeftInQtr(int $seconds): int
    {
        $boundaries = [
            self::QUARTER_DURATION_SECONDS,
            self::QUARTER_DURATION_SECONDS * 2,
            self::QUARTER_DURATION_SECONDS * 3,
            self::QUARTER_DURATION_SECONDS * 4,
            self::QUARTER_DURATION_SECONDS * 4 + self::OT_DURATION_SECONDS,
            self::QUARTER_DURATION_SECONDS * 4 + self::OT_DURATION_SECONDS * 2,
            self::QUARTER_DURATION_SECONDS * 4 + self::OT_DURATION_SECONDS * 3,
        ];

        foreach ($boundaries as $boundary) {
            if ($seconds <= $boundary) {
                return $boundary - $seconds;
            }
        }

        return 0;
    }

    /**
     * Filter rotations by a specific player.
     *
     * @param int $player_id Player identifier
     * @return array Rotations for the specified player
     */
    public function playerOnly(int $player_id): array
    {
        return array_values(array_filter(
            $this->details,
            fn($play) => ($play['player_id'] ?? 0) === $player_id
        ));
    }

    /**
     * Filter rotations by a specific team.
     *
     * @param int $team_id Team identifier
     * @return array Rotations for the specified team
     */
    public function teamOnly(int $team_id): array
    {
        return array_values(array_filter(
            $this->details,
            fn($play) => ($play['team_id'] ?? 0) === $team_id
        ));
    }
}
