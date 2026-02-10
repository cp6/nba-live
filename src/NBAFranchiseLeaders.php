<?php

namespace Corbpie\NBALive;

/**
 * Retrieve all-time franchise leaders for a team.
 */
class NBAFranchiseLeaders extends NBABase
{
    /** @var array Raw API response data */
    public array $data = [];

    /** @var array Franchise leaders by category */
    public array $leaders = [];

    /**
     * Fetch franchise leaders for a team.
     *
     * @param int $team_id Team identifier
     * @throws NBAApiException When the API request fails
     */
    public function __construct(int $team_id = 0)
    {
        if ($team_id <= 0) {
            return;
        }

        $this->data = $this->ApiCall("https://stats.nba.com/stats/franchiseleaders?LeagueID=00&TeamID={$team_id}");

        if (isset($this->data['resultSets'][0]['rowSet'])) {
            foreach ($this->data['resultSets'][0]['rowSet'] as $l) {
                $this->leaders[] = [
                    'team_id' => $l[0] ?? 0,
                    'pts_player_id' => $l[1] ?? 0,
                    'pts_player' => $l[2] ?? '',
                    'pts' => $l[3] ?? 0,
                    'ast_player_id' => $l[4] ?? 0,
                    'ast_player' => $l[5] ?? '',
                    'ast' => $l[6] ?? 0,
                    'reb_player_id' => $l[7] ?? 0,
                    'reb_player' => $l[8] ?? '',
                    'reb' => $l[9] ?? 0,
                    'blk_player_id' => $l[10] ?? 0,
                    'blk_player' => $l[11] ?? '',
                    'blk' => $l[12] ?? 0,
                    'stl_player_id' => $l[13] ?? 0,
                    'stl_player' => $l[14] ?? '',
                    'stl' => $l[15] ?? 0,
                ];
            }
        }
    }
}
