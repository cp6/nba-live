<?php

namespace Corbpie\NBALive;

/**
 * Retrieve NBA team roster including players and coaches.
 */
class NBARosters extends NBABase
{
    /** @var array Raw API response data */
    public array $data = [];

    /** @var array Team players */
    public array $players = [];

    /** @var array Team coaches */
    public array $coaches = [];

    /**
     * Fetch team roster for a specific season.
     *
     * @param int $team_id Team identifier
     * @param string $season Season identifier
     * @throws NBAApiException When the API request fails
     */
    public function __construct(int $team_id, string $season = self::CURRENT_SEASON)
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/commonteamroster?LeagueID=&Season={$season}&TeamID={$team_id}");

        if (isset($this->data['resultSets'][0]['rowSet'])) {
            foreach ($this->data['resultSets'][0]['rowSet'] as $p) {
                $birthdate = null;
                if (!empty($p[10])) {
                    $parsedDate = \DateTime::createFromFormat('M d, Y', $p[10]);
                    $birthdate = $parsedDate ? $parsedDate->format('Y-m-d') : null;
                }

                $this->players[] = [
                    'player_id' => $p[14] ?? 0,
                    'year' => (int)($p[1] ?? 0),
                    'season' => $season,
                    'team_id' => $team_id,
                    'player' => $p[3] ?? '',
                    'nickname' => $p[4] ?? '',
                    'slug' => $p[5] ?? '',
                    'number' => (int)($p[6] ?? 0),
                    'position' => $p[7] ?? '',
                    'height' => $p[8] ?? '',
                    'height_cm' => !empty($p[8]) ? $this->feetInchesToCm($p[8]) : 0,
                    'weight' => $p[9] ?? '',
                    'weight_kg' => (int)number_format((int)($p[9] ?? 0) * 0.45359237, 0),
                    'birthdate' => $birthdate,
                    'age' => $p[11] ?? 0,
                    'exp' => ($p[12] ?? 'R') !== 'R' ? (int)$p[12] : 0,
                    'school' => $p[13] ?? '',
                    'how_acquired' => $p[15] ?? ''
                ];
            }
        }

        if (isset($this->data['resultSets'][1]['rowSet'])) {
            foreach ($this->data['resultSets'][1]['rowSet'] as $c) {
                $this->coaches[] = [
                    'coach_id' => $c[2] ?? 0,
                    'season' => $c[1] ?? '',
                    'first_name' => $c[3] ?? '',
                    'last_name' => $c[4] ?? '',
                    'coach_name' => $c[5] ?? '',
                    'is_assistant' => $c[6] ?? 0,
                    'coach_type' => $c[7] ?? '',
                    'sort_sequence' => $c[8] ?? 0,
                    'sub_sort_sequence' => $c[9] ?? 0
                ];
            }
        }
    }
}
