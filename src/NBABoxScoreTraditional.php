<?php

namespace Corbpie\NBALive;

/**
 * Retrieve traditional NBA box score statistics with filtering options.
 */
class NBABoxScoreTraditional extends NBABoxScoreFilters
{
    /** @var array Raw API response data */
    public array $data = [];

    /** @var array Home team players data */
    public array $home_players = [];

    /** @var array Away team players data */
    public array $away_players = [];

    /** @var array Home team statistics */
    public array $home_team = [];

    /** @var array Home team starters */
    public array $home_starters = [];

    /** @var array Home team bench players */
    public array $home_bench = [];

    /** @var array Away team statistics */
    public array $away_team = [];

    /** @var array Away team starters */
    public array $away_starters = [];

    /** @var array Away team bench players */
    public array $away_bench = [];

    /** @var array Both teams statistics */
    public array $teams = [];

    /** @var array Both teams starters */
    public array $teams_starters = [];

    /** @var array Both teams bench players */
    public array $teams_bench = [];

    /**
     * Fetch traditional box score data.
     *
     * @param bool $players_only If true, only populate player arrays and return early
     * @return array Raw API response data
     * @throws NBAApiException When the API request fails
     */
    public function fetch(bool $players_only = false): array
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/boxscoretraditionalv3?{$this->filters}&GameID={$this->game_id}");

        if (isset($this->data['boxScoreTraditional'])) {
            $this->home_players = $this->data['boxScoreTraditional']['homeTeam']['players'] ?? [];
            $this->away_players = $this->data['boxScoreTraditional']['awayTeam']['players'] ?? [];

            if ($players_only) {
                return $this->data;
            }

            $this->home_team = $this->data['boxScoreTraditional']['homeTeam']['statistics'] ?? [];
            $this->home_starters = $this->data['boxScoreTraditional']['homeTeam']['starters'] ?? [];
            $this->home_bench = $this->data['boxScoreTraditional']['homeTeam']['bench'] ?? [];

            $this->away_team = $this->data['boxScoreTraditional']['awayTeam']['statistics'] ?? [];
            $this->away_starters = $this->data['boxScoreTraditional']['awayTeam']['starters'] ?? [];
            $this->away_bench = $this->data['boxScoreTraditional']['awayTeam']['bench'] ?? [];

            $this->teams = [
                'home' => $this->home_team,
                'away' => $this->away_team
            ];

            $this->teams_starters = [
                'home' => $this->home_starters,
                'away' => $this->away_starters
            ];

            $this->teams_bench = [
                'home' => $this->home_bench,
                'away' => $this->away_bench
            ];
        }

        return $this->data;
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
