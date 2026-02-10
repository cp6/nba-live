<?php

namespace Corbpie\NBALive;

/**
 * Retrieve complete franchise history for all NBA teams.
 */
class NBAFranchiseHistory extends NBABase
{
    /** @var array Raw API response data */
    public array $data = [];

    /** @var array Active franchises */
    public array $active = [];

    /** @var array Defunct franchises */
    public array $defunct = [];

    /**
     * Fetch franchise history data.
     *
     * @throws NBAApiException When the API request fails
     */
    public function __construct()
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/franchisehistory?LeagueID=00");

        // Active franchises
        if (isset($this->data['resultSets'][0]['rowSet'])) {
            foreach ($this->data['resultSets'][0]['rowSet'] as $f) {
                $this->active[] = $this->buildFranchise($f);
            }
        }

        // Defunct franchises
        if (isset($this->data['resultSets'][1]['rowSet'])) {
            foreach ($this->data['resultSets'][1]['rowSet'] as $f) {
                $this->defunct[] = $this->buildFranchise($f);
            }
        }
    }

    /**
     * Build franchise array from raw data.
     *
     * @param array $f Raw franchise data
     * @return array Formatted franchise data
     */
    private function buildFranchise(array $f): array
    {
        return [
            'league_id' => $f[0] ?? '',
            'team_id' => $f[1] ?? 0,
            'team_city' => $f[2] ?? '',
            'team_name' => $f[3] ?? '',
            'start_year' => $f[4] ?? '',
            'end_year' => $f[5] ?? '',
            'years' => $f[6] ?? 0,
            'games' => $f[7] ?? 0,
            'wins' => $f[8] ?? 0,
            'losses' => $f[9] ?? 0,
            'win_pct' => $f[10] ?? 0,
            'playoff_appearances' => $f[11] ?? 0,
            'division_titles' => $f[12] ?? 0,
            'conference_titles' => $f[13] ?? 0,
            'championships' => $f[14] ?? 0,
        ];
    }

    /**
     * Get franchise by team ID.
     *
     * @param int $team_id Team identifier
     * @return array|null Franchise data or null
     */
    public function getByTeamId(int $team_id): ?array
    {
        foreach (array_merge($this->active, $this->defunct) as $f) {
            if (($f['team_id'] ?? 0) === $team_id) {
                return $f;
            }
        }
        return null;
    }
}
