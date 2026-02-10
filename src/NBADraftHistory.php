<?php

namespace Corbpie\NBALive;

/**
 * Retrieve NBA Draft history data.
 */
class NBADraftHistory extends NBABase
{
    /** @var array Raw API response data */
    public array $data = [];

    /** @var array All draft picks */
    public array $picks = [];

    /**
     * Fetch draft history.
     *
     * @param string|null $season Draft year (null for all years)
     * @param int|null $team_id Filter by team
     * @param string|null $college Filter by college
     * @throws NBAApiException When the API request fails
     */
    public function __construct(?string $season = null, ?int $team_id = null, ?string $college = null)
    {
        $seasonFilter = $season ?? '';
        $teamFilter = $team_id ?? '';
        $collegeFilter = $college ?? '';

        $this->data = $this->ApiCall("https://stats.nba.com/stats/drafthistory?College={$collegeFilter}&LeagueID=00&OverallPick=&RoundNum=&RoundPick=&Season={$seasonFilter}&TeamID={$teamFilter}&TopX=");

        if (isset($this->data['resultSets'][0]['rowSet'])) {
            foreach ($this->data['resultSets'][0]['rowSet'] as $p) {
                $this->picks[] = [
                    'player_id' => $p[0] ?? 0,
                    'player_name' => $p[1] ?? '',
                    'season' => $p[2] ?? '',
                    'round_number' => $p[3] ?? 0,
                    'round_pick' => $p[4] ?? 0,
                    'overall_pick' => $p[5] ?? 0,
                    'draft_type' => $p[6] ?? '',
                    'team_id' => $p[7] ?? 0,
                    'team_city' => $p[8] ?? '',
                    'team_name' => $p[9] ?? '',
                    'team_abbr' => $p[10] ?? '',
                    'organization' => $p[11] ?? '',
                    'organization_type' => $p[12] ?? '',
                ];
            }
        }
    }

    /**
     * Get picks by round.
     *
     * @param int $round Round number
     * @return array Picks in the specified round
     */
    public function byRound(int $round): array
    {
        return array_filter($this->picks, fn($p) => ($p['round_number'] ?? 0) === $round);
    }

    /**
     * Get lottery picks (1-14).
     *
     * @return array Lottery picks
     */
    public function lotteryPicks(): array
    {
        return array_filter($this->picks, fn($p) => ($p['overall_pick'] ?? 0) <= 14);
    }
}
