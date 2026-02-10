<?php

namespace Corbpie\NBALive;

/**
 * Retrieve NBA box score matchup data showing player defensive assignments.
 */
class NBABoxScoreMatchups extends NBABase
{
    /** @var array Raw API response data */
    public array $data = [];

    /** @var array Home team players data */
    public array $home_players = [];

    /** @var array Away team players data */
    public array $away_players = [];

    /**
     * Fetch matchup box score data for a specific game.
     *
     * @param string $game_id NBA game identifier
     * @throws NBAApiException When the API request fails
     */
    public function __construct(string $game_id = '')
    {
        if (!isset($this->game_id)) {
            $this->game_id = $game_id;
        }

        $this->data = $this->ApiCall("https://stats.nba.com/stats/boxscorematchupsv3?GameID={$this->game_id}");

        if (isset($this->data['boxScoreMatchups'])) {
            $this->home_players = $this->data['boxScoreMatchups']['homeTeam']['players'] ?? [];
            $this->away_players = $this->data['boxScoreMatchups']['awayTeam']['players'] ?? [];
        }
    }

    /**
     * Get matchup data for a specific player.
     *
     * @param int $player_id Player identifier
     * @return array Matchup data for the player
     */
    public function playerOnly(int $player_id): array
    {
        $player_only = [];

        $allPlayers = array_merge(
            $this->data['boxScoreMatchups']['homeTeam']['players'] ?? [],
            $this->data['boxScoreMatchups']['awayTeam']['players'] ?? []
        );

        foreach ($allPlayers as $mu) {
            if (($mu['personId'] ?? 0) === $player_id) {
                $player_only[] = $mu;
            }
        }

        return $player_only;
    }

    /**
     * Get all matchups where a specific player was being defended.
     *
     * @param int $player_id Player identifier
     * @return array Matchup data where the player was defended
     */
    public function playerMatchedWith(int $player_id): array
    {
        $matched_with = [];

        $allPlayers = array_merge(
            $this->data['boxScoreMatchups']['homeTeam']['players'] ?? [],
            $this->data['boxScoreMatchups']['awayTeam']['players'] ?? []
        );

        foreach ($allPlayers as $player) {
            foreach ($player['matchups'] ?? [] as $mu) {
                if (($mu['personId'] ?? 0) === $player_id) {
                    $matched_with[] = [
                        'player_id' => $player['personId'] ?? 0,
                        'player_name' => $player['nameI'] ?? '',
                        'matched_on_id' => $mu['personId'] ?? 0,
                        'matched_on_name' => $mu['nameI'] ?? '',
                        'statistics' => $mu['statistics'] ?? []
                    ];
                }
            }
        }

        return $matched_with;
    }
}
