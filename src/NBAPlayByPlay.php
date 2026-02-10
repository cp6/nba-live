<?php

namespace Corbpie\NBALive;

use DateInterval;

/**
 * Retrieve NBA play-by-play data from the live CDN.
 */
class NBAPlayByPlay extends NBABase
{
    /** @var array Raw API response data */
    public array $data = [];

    /** @var array All plays in the game */
    public array $all_plays = [];

    /** @var array Last 10 plays */
    public array $last_10_plays = [];

    /** @var int Total number of plays */
    public int $plays_count = 0;

    /**
     * Fetch play-by-play data for a specific game.
     *
     * @param string $game_id NBA game identifier
     * @throws NBAApiException When the API request fails
     */
    public function __construct(string $game_id = '')
    {
        if (!isset($this->game_id)) {
            $this->game_id = $game_id;
        }

        $this->data = $this->ApiCall("https://cdn.nba.com/static/json/liveData/playbyplay/playbyplay_{$this->game_id}.json");

        if (isset($this->data['game'])) {
            $this->all_plays = $this->data['game']['actions'] ?? [];
            $this->last_10_plays = array_slice($this->all_plays, -10);
            $this->plays_count = count($this->all_plays);
        }
    }

    /**
     * Filter plays by a specific player.
     *
     * @param int $player_id Player identifier
     * @return array Plays involving the specified player
     */
    public function playerOnly(int $player_id): array
    {
        return array_values(array_filter(
            $this->all_plays,
            fn($play) => isset($play['personIdsFilter'][0]) && $play['personIdsFilter'][0] === $player_id
        ));
    }

    /**
     * Filter plays by a specific team.
     *
     * @param int $team_id Team identifier
     * @return array Plays by the specified team
     */
    public function teamOnly(int $team_id): array
    {
        return array_values(array_filter(
            $this->all_plays,
            fn($play) => isset($play['teamId']) && $play['teamId'] === $team_id
        ));
    }

    /**
     * Get score progression throughout the game.
     *
     * @return array Score line with each scoring change
     */
    public function scoreLine(): array
    {
        $scores = [];
        $score_home = $score_away = 0;

        foreach ($this->all_plays as $play) {
            $newHomeScore = (int)($play['scoreHome'] ?? 0);
            $newAwayScore = (int)($play['scoreAway'] ?? 0);

            if ($score_home !== $newHomeScore || $score_away !== $newAwayScore) {
                $score_home = $newHomeScore;
                $score_away = $newAwayScore;

                $formatted_time_left = $this->formatGameClock($play['clock'] ?? '');

                $scores[] = [
                    'action_number' => $play['actionNumber'] ?? 0,
                    'home' => $score_home,
                    'away' => $score_away,
                    'margin' => abs($score_home - $score_away),
                    'period' => $play['period'] ?? 0,
                    'time_left' => $formatted_time_left
                ];
            }
        }

        return $scores;
    }

    /**
     * Format game clock string to MM:SS format.
     *
     * @param string $clock Raw clock string (e.g., "PT05M30.00S")
     * @return string|null Formatted time or null if empty
     */
    protected function formatGameClock(string $clock): ?string
    {
        if (empty($clock)) {
            return null;
        }

        $clockPart = strstr($clock, '.', true);
        if (!$clockPart) {
            return null;
        }

        try {
            $interval = new DateInterval($clockPart . "S");
            return sprintf('%02d:%02d', $interval->i, $interval->s);
        } catch (\Exception) {
            return null;
        }
    }
}
