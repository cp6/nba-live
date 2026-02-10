<?php

namespace Corbpie\NBALive;

/**
 * Retrieve scoring-focused NBA box score statistics.
 */
class NBABoxScoreScoring extends NBABoxScoreFilters
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
     * Fetch scoring box score data.
     *
     * @return array Raw API response data
     * @throws NBAApiException When the API request fails
     */
    public function fetch(): array
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/boxscorescoringv3?" . $this->build() . "&GameID={$this->game_id}");

        if (isset($this->data['boxScoreScoring'])) {
            $this->home_players = $this->data['boxScoreScoring']['homeTeam']['players'] ?? [];
            $this->away_players = $this->data['boxScoreScoring']['awayTeam']['players'] ?? [];

            $this->home_team = $this->data['boxScoreScoring']['homeTeam']['statistics'] ?? [];
            $this->away_team = $this->data['boxScoreScoring']['awayTeam']['statistics'] ?? [];
        }

        return $this->data;
    }
}
