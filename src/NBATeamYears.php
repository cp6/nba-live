<?php

namespace Corbpie\NBALive;

/**
 * Retrieve all NBA teams and their active years.
 */
class NBATeamYears extends NBABase
{
    /** @var array Raw API response data */
    public array $data = [];

    /** @var array All teams with their year ranges */
    public array $teams = [];

    /**
     * Fetch all teams for a league.
     *
     * @param string $league_id League identifier (default: '00' for NBA)
     * @throws NBAApiException When the API request fails
     */
    public function __construct(string $league_id = '00')
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/commonteamyears?LeagueID={$league_id}");

        if (isset($this->data['resultSets'][0]['rowSet'])) {
            foreach ($this->data['resultSets'][0]['rowSet'] as $team) {
                $this->teams[] = [
                    'team_id' => $team[1] ?? 0,
                    'team' => $team[4] ?? '',
                    'min_year' => (int)($team[2] ?? 0),
                    'max_year' => (int)($team[3] ?? 0),
                ];
            }
        }
    }
}
