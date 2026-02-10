<?php

namespace Corbpie\NBALive;

/**
 * Retrieve NBA live box score data from the CDN.
 */
class NBABoxScore extends NBABase
{
    /** @var array Raw API response data */
    public array $data = [];

    /** @var array Home team players data */
    public array $home_players = [];

    /** @var array Away team players data */
    public array $away_players = [];

    /** @var array Home team statistics */
    public array $home_team = [];

    /** @var array Away team statistics */
    public array $away_team = [];

    /** @var int Home team ID */
    public int $home_tid;

    /** @var int Away team ID */
    public int $away_tid;

    /**
     * Fetch box score data for a specific game.
     *
     * @param string $game_id NBA game identifier
     * @throws NBAApiException When the API request fails
     */
    public function __construct(string $game_id = '')
    {
        if (!isset($this->game_id)) {
            $this->game_id = $game_id;
        }

        $this->data = $this->ApiCall("https://cdn.nba.com/static/json/liveData/boxscore/boxscore_{$this->game_id}.json");

        if (isset($this->data['game'])) {
            $this->home_team = $this->data['game']['homeTeam']['statistics'] ?? [];
            $this->away_team = $this->data['game']['awayTeam']['statistics'] ?? [];

            $this->home_players = $this->data['game']['homeTeam']['players'] ?? [];
            $this->away_players = $this->data['game']['awayTeam']['players'] ?? [];

            $this->home_tid = $this->data['game']['homeTeam']['teamId'] ?? 0;
            $this->away_tid = $this->data['game']['awayTeam']['teamId'] ?? 0;
        }
    }

    /**
     * Get inactive players for both teams.
     *
     * @return array{home_inactive: array, away_inactive: array} Inactive players by team
     */
    public function getInactive(): array
    {
        $home_inactive = array_filter(
            $this->home_players,
            fn($player) => ($player['status'] ?? '') === self::STATUS_INACTIVE
        );

        $away_inactive = array_filter(
            $this->away_players,
            fn($player) => ($player['status'] ?? '') === self::STATUS_INACTIVE
        );

        return [
            'home_inactive' => array_values($home_inactive),
            'away_inactive' => array_values($away_inactive)
        ];
    }

    /**
     * Sort players in ascending order by a statistics key.
     *
     * @param array $players_data Array of player data
     * @param string $key Statistics key to sort by (default: 'points')
     * @return array Sorted player data
     */
    public function sortAsc(array $players_data, string $key = 'points'): array
    {
        return $this->sortPlayersAsc($players_data, $key);
    }

    /**
     * Sort players in descending order by a statistics key.
     *
     * @param array $players_data Array of player data
     * @param string $key Statistics key to sort by (default: 'points')
     * @return array Sorted player data
     */
    public function sortDesc(array $players_data, string $key = 'points'): array
    {
        return $this->sortPlayersDesc($players_data, $key);
    }
}
