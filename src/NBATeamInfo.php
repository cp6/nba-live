<?php

namespace Corbpie\NBALive;

/**
 * Retrieve NBA team information including basic info, rankings, and seasons.
 */
class NBATeamInfo extends NBABase
{
    /** @var array Raw API response data */
    public array $data = [];

    /** @var array Team basic information */
    public array $info = [];

    /** @var array Team statistical rankings */
    public array $ranks = [];

    /** @var array Seasons the team has played */
    public array $seasons = [];

    /**
     * Fetch team information by team ID.
     *
     * @param int $team_id Team identifier
     * @throws NBAApiException When the API request fails
     */
    public function __construct(int $team_id = 0)
    {
        if (!isset($this->team_id)) {
            $this->team_id = $team_id;
        }

        $this->data = $this->ApiCall("https://stats.nba.com/stats/teaminfocommon?LeagueID=00&Season=&SeasonType=&TeamID={$this->team_id}");

        if (isset($this->data['resultSets'][0]['rowSet'][0])) {
            $info = $this->data['resultSets'][0]['rowSet'][0];

            $this->info = [
                'team_id' => $this->team_id,
                'season' => $info[1] ?? '',
                'city' => $info[2] ?? '',
                'name' => $info[3] ?? '',
                'short_name' => $info[4] ?? '',
                'conference' => $info[5] ?? '',
                'division' => $info[6] ?? '',
                'slug' => $info[8] ?? '',
                'wins' => $info[9] ?? 0,
                'loss' => $info[10] ?? 0,
                'pct' => $info[11] ?? 0,
                'conf_rank' => $info[12] ?? 0,
                'div_rank' => $info[13] ?? 0,
                'min_year' => $info[14] ?? 0,
                'max_year' => $info[15] ?? 0,
            ];
        }

        if (isset($this->data['resultSets'][1]['rowSet'][0])) {
            $ranks = $this->data['resultSets'][1]['rowSet'][0];

            $this->ranks = [
                'team_id' => $this->team_id,
                'season' => $ranks[1] ?? '',
                'pts_ranks' => $ranks[2] ?? 0,
                'pts_pg' => $ranks[3] ?? 0,
                'reb_rank' => $ranks[4] ?? 0,
                'reb_pg' => $ranks[5] ?? 0,
                'ast_rank' => $ranks[6] ?? 0,
                'ast_pg' => $ranks[8] ?? 0,
                'opp_pts_rank' => $ranks[9] ?? 0,
                'opp_pts_pg' => $ranks[10] ?? 0,
            ];
        }

        if (isset($this->data['resultSets'][2]['rowSet'])) {
            foreach ($this->data['resultSets'][2]['rowSet'] as $season) {
                $this->seasons[] = [
                    'season' => $season[0] ?? ''
                ];
            }
        }
    }
}
