<?php

namespace Corbpie\NBALive;

/**
 * Retrieve defensive NBA box score statistics.
 */
class NBABoxScoreDefensive extends NBABase
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
     * Fetch defensive box score data for a specific game.
     *
     * @param string $game_id NBA game identifier
     * @throws NBAApiException When the API request fails
     */
    public function __construct(string $game_id = '')
    {
        if (!isset($this->game_id)) {
            $this->game_id = $game_id;
        }

        $this->data = $this->ApiCall("https://stats.nba.com/stats/boxscoredefensivev2?GameID={$this->game_id}");

        if (isset($this->data['boxScoreDefensive'])) {
            $this->home_players = $this->data['boxScoreDefensive']['homeTeam']['players'] ?? [];
            $this->away_players = $this->data['boxScoreDefensive']['awayTeam']['players'] ?? [];
        }
    }
}
