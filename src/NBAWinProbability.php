<?php

namespace Corbpie\NBALive;

/**
 * Retrieve win probability data for a game.
 */
class NBAWinProbability extends NBABase
{
    /** @var array Raw API response data */
    public array $data = [];

    /** @var array Win probability by play */
    public array $probabilities = [];

    /** @var string Game identifier */
    public string $game_id;

    /**
     * Fetch win probability data for a game.
     *
     * @param string $game_id Game identifier
     * @throws NBAApiException When the API request fails
     */
    public function __construct(string $game_id = '')
    {
        if (empty($game_id)) {
            return;
        }

        $this->game_id = $game_id;
        $this->data = $this->ApiCall("https://stats.nba.com/stats/winprobabilitypbp?GameID={$game_id}&RunType=each+second");

        if (isset($this->data['resultSets'][0]['rowSet'])) {
            foreach ($this->data['resultSets'][0]['rowSet'] as $p) {
                $this->probabilities[] = [
                    'game_id' => $p[0] ?? '',
                    'event_num' => $p[1] ?? 0,
                    'home_pct' => $p[2] ?? 0,
                    'visitor_pct' => $p[3] ?? 0,
                    'home_pts' => $p[4] ?? 0,
                    'visitor_pts' => $p[5] ?? 0,
                    'home_score_margin' => $p[6] ?? 0,
                    'period' => $p[7] ?? 0,
                    'seconds_remaining' => $p[8] ?? 0,
                    'home_poss_ind' => $p[9] ?? 0,
                    'home_g' => $p[10] ?? 0,
                    'description' => $p[11] ?? '',
                    'location' => $p[12] ?? '',
                    'pctimestring' => $p[13] ?? '',
                    'isvisible' => $p[14] ?? 0,
                ];
            }
        }
    }

    /**
     * Get the biggest swings in win probability.
     *
     * @param int $limit Number of swings to return
     * @return array Biggest probability swings
     */
    public function biggestSwings(int $limit = 10): array
    {
        $swings = [];
        for ($i = 1; $i < \count($this->probabilities); $i++) {
            $prev = $this->probabilities[$i - 1]['home_pct'] ?? 0;
            $curr = $this->probabilities[$i]['home_pct'] ?? 0;
            $swing = abs($curr - $prev);
            if ($swing > 0) {
                $swings[] = [
                    'swing' => $swing,
                    'from' => $prev,
                    'to' => $curr,
                    'play' => $this->probabilities[$i],
                ];
            }
        }
        usort($swings, fn($a, $b) => $b['swing'] <=> $a['swing']);
        return \array_slice($swings, 0, $limit);
    }

    /**
     * Get win probability at end of each quarter.
     *
     * @return array Win probability by quarter end
     */
    public function byQuarterEnd(): array
    {
        $quarters = [];
        $currentPeriod = 0;
        foreach ($this->probabilities as $p) {
            $period = $p['period'] ?? 0;
            if ($period > $currentPeriod) {
                $currentPeriod = $period;
            }
            $quarters[$period] = $p;
        }
        return $quarters;
    }
}
