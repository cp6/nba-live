<?php

namespace Corbpie\NBALive;

/**
 * Retrieve usage NBA box score statistics.
 */
class NBABoxScoreUsage extends NBABoxScoreFilters
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
     * Fetch usage box score data.
     *
     * @return array Raw API response data
     * @throws NBAApiException When the API request fails
     */
    public function fetch(): array
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/boxscoreusagev3?" . $this->build() . "&GameID={$this->game_id}");

        if (isset($this->data['boxScoreUsage'])) {
            $this->home_players = $this->data['boxScoreUsage']['homeTeam']['players'] ?? [];
            $this->away_players = $this->data['boxScoreUsage']['awayTeam']['players'] ?? [];

            $this->home_team = $this->data['boxScoreUsage']['homeTeam']['statistics'] ?? [];
            $this->away_team = $this->data['boxScoreUsage']['awayTeam']['statistics'] ?? [];
        }

        return $this->data;
    }
}
