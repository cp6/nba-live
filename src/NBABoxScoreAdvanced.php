<?php

namespace Corbpie\NBALive;

/**
 * Retrieve advanced NBA box score statistics.
 */
class NBABoxScoreAdvanced extends NBABoxScoreFilters
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

    /**
     * Fetch advanced box score data.
     *
     * @return array Raw API response data
     * @throws NBAApiException When the API request fails
     */
    public function fetch(): array
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/boxscoreadvancedv3?" . $this->build() . "&GameID={$this->game_id}");

        if (isset($this->data['boxScoreAdvanced'])) {
            $this->home_players = $this->data['boxScoreAdvanced']['homeTeam']['players'] ?? [];
            $this->away_players = $this->data['boxScoreAdvanced']['awayTeam']['players'] ?? [];

            $this->home_team = $this->data['boxScoreAdvanced']['homeTeam']['statistics'] ?? [];
            $this->away_team = $this->data['boxScoreAdvanced']['awayTeam']['statistics'] ?? [];
        }

        return $this->data;
    }
}
