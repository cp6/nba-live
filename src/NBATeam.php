<?php

declare(strict_types=1);

namespace Corbpie\NBALive;

use Corbpie\NBALive\Contracts\FetchableEndpoint;
use Corbpie\NBALive\Http\NbaHttpClientInterface;

/**
 * Retrieve NBA team details.
 */
final class NBATeam extends NBABase implements FetchableEndpoint
{
    /** @var array Raw API response data */
    public array $data = [];

    /** @var array Team details */
    public array $details = [];

    /**
     * Fetch team details by team ID.
     *
     * @param int $team_id Team identifier
     * @throws NBAApiException When the API request fails
     */
    public function fetch(int $team_id = 0): array
    {

        if ($this->team_id <= 0) {
            $this->team_id = $team_id;
        }

        $this->data = $this->ApiCall("https://stats.nba.com/stats/teamdetails?TeamID={$this->team_id}");

        if (isset($this->data['resultSets'][0]['rowSet'][0])) {
            $team = $this->data['resultSets'][0]['rowSet'][0];

            $this->details = [
                'id' => $team[0] ?? 0,
                'name' => $team[2] ?? '',
                'short_name' => $team[1] ?? '',
                'city' => $team[4] ?? '',
                'arena' => $team[5] ?? '',
                'year_founded' => $team[3] ?? 0,
            ];
        }

        return $this->data;
    }

    public function __construct(int $team_id = 0, ?NbaHttpClientInterface $httpClient = null)
    {
        parent::__construct($httpClient);
        $this->fetch($team_id);
    }
}
