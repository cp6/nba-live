<?php

namespace Corbpie\NBALive;

class NBATeamInfo extends NBABase
{

    public array $data = [];

    public array $info = [];

    public array $ranks = [];

    public array $seasons = [];

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
                'season' => $info[1],
                'city' => $info[2],
                'name' => $info[3],
                'short_name' => $info[4],
                'conference' => $info[5],
                'division' => $info[6],
                'slug' => $info[8],
                'wins' => $info[9],
                'loss' => $info[10],
                'pct' => $info[11],
                'conf_rank' => $info[12],
                'div_rank' => $info[13],
                'min_year' => $info[14],
                'max_year' => $info[15],
            ];

        }

        if (isset($this->data['resultSets'][1]['rowSet'][0])) {

            $ranks = $this->data['resultSets'][1]['rowSet'][0];

            $this->ranks = [
                'team_id' => $this->team_id,
                'season' => $ranks[1],
                'pts_ranks' => $ranks[2],
                'pts_pg' => $ranks[3],
                'reb_rank' => $ranks[4],
                'reb_pg' => $ranks[5],
                'ast_rank' => $ranks[6],
                'ast_pg' => $ranks[8],
                'opp_pts_rank' => $ranks[9],
                'opp_pts_pg' => $ranks[10],
            ];

        }

        if (isset($this->data['resultSets'][2]['rowSet'])) {

            $seasons = $this->data['resultSets'][2]['rowSet'];

            foreach ($seasons as $season) {
                $this->seasons[] = [
                    'season' => $season[0]
                ];
            }

        }

    }

}