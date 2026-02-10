<?php

namespace Corbpie\NBALive;

/**
 * Retrieve estimated advanced metrics for players.
 */
class NBAPlayerEstimatedMetrics extends NBABase
{
    /** @var array Raw API response data */
    public array $data = [];

    /** @var array Player estimated metrics */
    public array $players = [];

    /** @var string Season identifier */
    public string $season = NBABase::CURRENT_SEASON;

    /** @var string Season type */
    public string $season_type = NBABase::TYPE_REGULAR;

    /**
     * Fetch estimated metrics.
     *
     * @return array Raw API response data
     * @throws NBAApiException When the API request fails
     */
    public function fetch(): array
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/playerestimatedmetrics?LeagueID=00&Season={$this->season}&SeasonType={$this->season_type}");

        if (isset($this->data['resultSets'][0]['rowSet'])) {
            foreach ($this->data['resultSets'][0]['rowSet'] as $p) {
                $this->players[] = [
                    'player_id' => $p[0] ?? 0,
                    'player_name' => $p[1] ?? '',
                    'gp' => $p[2] ?? 0,
                    'w' => $p[3] ?? 0,
                    'l' => $p[4] ?? 0,
                    'w_pct' => $p[5] ?? 0,
                    'min' => $p[6] ?? 0,
                    'e_off_rating' => $p[7] ?? 0,
                    'e_def_rating' => $p[8] ?? 0,
                    'e_net_rating' => $p[9] ?? 0,
                    'e_ast_ratio' => $p[10] ?? 0,
                    'e_oreb_pct' => $p[11] ?? 0,
                    'e_dreb_pct' => $p[12] ?? 0,
                    'e_reb_pct' => $p[13] ?? 0,
                    'e_tov_pct' => $p[14] ?? 0,
                    'e_usg_pct' => $p[15] ?? 0,
                    'e_pace' => $p[16] ?? 0,
                    'gp_rank' => $p[17] ?? 0,
                    'w_rank' => $p[18] ?? 0,
                    'l_rank' => $p[19] ?? 0,
                    'w_pct_rank' => $p[20] ?? 0,
                    'min_rank' => $p[21] ?? 0,
                    'e_off_rating_rank' => $p[22] ?? 0,
                    'e_def_rating_rank' => $p[23] ?? 0,
                    'e_net_rating_rank' => $p[24] ?? 0,
                ];
            }
        }

        return $this->data;
    }

    /**
     * Get top players by estimated net rating.
     *
     * @param int $limit Number of players
     * @return array Top players
     */
    public function topByNetRating(int $limit = 10): array
    {
        $sorted = $this->players;
        usort($sorted, fn($a, $b) => ($b['e_net_rating'] ?? 0) <=> ($a['e_net_rating'] ?? 0));
        return \array_slice($sorted, 0, $limit);
    }

    /**
     * Get best offensive players by estimated offensive rating.
     *
     * @param int $limit Number of players
     * @return array Top offensive players
     */
    public function topOffensive(int $limit = 10): array
    {
        $sorted = $this->players;
        usort($sorted, fn($a, $b) => ($b['e_off_rating'] ?? 0) <=> ($a['e_off_rating'] ?? 0));
        return \array_slice($sorted, 0, $limit);
    }

    /**
     * Get best defensive players by estimated defensive rating (lower is better).
     *
     * @param int $limit Number of players
     * @return array Top defensive players
     */
    public function topDefensive(int $limit = 10): array
    {
        $sorted = $this->players;
        usort($sorted, fn($a, $b) => ($a['e_def_rating'] ?? 999) <=> ($b['e_def_rating'] ?? 999));
        return \array_slice($sorted, 0, $limit);
    }
}
