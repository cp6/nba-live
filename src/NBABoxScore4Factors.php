<?php

namespace Corbpie\NBALive;

/**
 * Retrieve Four Factors NBA box score statistics.
 * The four factors are: effective field goal percentage, turnover percentage,
 * offensive rebounding percentage, and free throw rate.
 */
class NBABoxScore4Factors extends NBABoxScoreFilters
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
     * Fetch four factors box score data.
     *
     * @return array Raw API response data
     * @throws NBAApiException When the API request fails
     */
    public function fetch(): array
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/boxscorefourfactorsv3?" . $this->build() . "&GameID={$this->game_id}");

        if (isset($this->data['boxScoreFourFactors'])) {
            $this->home_players = $this->data['boxScoreFourFactors']['homeTeam']['players'] ?? [];
            $this->away_players = $this->data['boxScoreFourFactors']['awayTeam']['players'] ?? [];

            $this->home_team = $this->data['boxScoreFourFactors']['homeTeam']['statistics'] ?? [];
            $this->away_team = $this->data['boxScoreFourFactors']['awayTeam']['statistics'] ?? [];
        }

        return $this->data;
    }
}
