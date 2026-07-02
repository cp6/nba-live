<?php

declare(strict_types=1);

namespace Corbpie\NBALive;

use Corbpie\NBALive\Contracts\FetchableEndpoint;
use Corbpie\NBALive\Http\NbaHttpClientInterface;

/**
 * Retrieve hustle NBA box score statistics (deflections, loose balls, etc.).
 */
final class NBABoxScoreHustle extends NBABase implements FetchableEndpoint
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
     * Fetch hustle box score data for a specific game.
     *
     * @param string $game_id NBA game identifier
     * @throws NBAApiException When the API request fails
     */
    public function fetch(string $game_id = ''): array
    {

        if ($this->game_id === '') {
            $this->game_id = $game_id;
        }

        $this->data = $this->ApiCall("https://stats.nba.com/stats/boxscorehustlev2?GameID={$this->game_id}");

        if (isset($this->data['boxScoreHustle'])) {
            $this->home_players = $this->data['boxScoreHustle']['homeTeam']['players'] ?? [];
            $this->away_players = $this->data['boxScoreHustle']['awayTeam']['players'] ?? [];

            $this->home_team = $this->data['boxScoreHustle']['homeTeam']['statistics'] ?? [];
            $this->away_team = $this->data['boxScoreHustle']['awayTeam']['statistics'] ?? [];
        }

        return $this->data;
    }

    public function __construct(string $game_id = '', ?NbaHttpClientInterface $httpClient = null)
    {
        parent::__construct($httpClient);

        if ($game_id !== '') {

            $this->fetch($game_id);

        }
    }
}
