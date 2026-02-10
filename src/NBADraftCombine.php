<?php

namespace Corbpie\NBALive;

/**
 * Retrieve NBA Draft Combine measurements and stats.
 */
class NBADraftCombine extends NBABase
{
    /** @var array Raw API response data */
    public array $data = [];

    /** @var array All combine participants */
    public array $players = [];

    /**
     * Fetch draft combine data.
     *
     * @param string $season Draft year
     * @throws NBAApiException When the API request fails
     */
    public function __construct(string $season = self::CURRENT_SEASON)
    {
        // Extract year from season format (e.g., "2024-25" -> "2024")
        $year = explode('-', $season)[0];

        $this->data = $this->ApiCall("https://stats.nba.com/stats/draftcombinestats?LeagueID=00&SeasonYear={$year}");

        if (isset($this->data['resultSets'][0]['rowSet'])) {
            foreach ($this->data['resultSets'][0]['rowSet'] as $p) {
                $this->players[] = [
                    'season' => $p[0] ?? '',
                    'player_id' => $p[1] ?? 0,
                    'player_name' => $p[3] ?? '',
                    'position' => $p[4] ?? '',
                    'height_wo_shoes' => $p[5] ?? null,
                    'height_w_shoes' => $p[6] ?? null,
                    'weight' => $p[7] ?? null,
                    'wingspan' => $p[8] ?? null,
                    'standing_reach' => $p[9] ?? null,
                    'body_fat_pct' => $p[10] ?? null,
                    'hand_length' => $p[11] ?? null,
                    'hand_width' => $p[12] ?? null,
                    'standing_vertical_leap' => $p[13] ?? null,
                    'max_vertical_leap' => $p[14] ?? null,
                    'lane_agility_time' => $p[15] ?? null,
                    'modified_lane_agility_time' => $p[16] ?? null,
                    'three_quarter_sprint' => $p[17] ?? null,
                    'bench_press' => $p[18] ?? null,
                ];
            }
        }
    }

    /**
     * Get players sorted by a measurement.
     *
     * @param string $measurement Measurement key
     * @param string $direction 'asc' or 'desc'
     * @return array Sorted players
     */
    public function sortBy(string $measurement, string $direction = 'desc'): array
    {
        $sorted = $this->players;
        usort($sorted, function ($a, $b) use ($measurement, $direction) {
            $aVal = $a[$measurement] ?? 0;
            $bVal = $b[$measurement] ?? 0;
            return $direction === 'desc' ? $bVal <=> $aVal : $aVal <=> $bVal;
        });
        return $sorted;
    }
}
