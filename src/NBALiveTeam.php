<?php

namespace Corbpie\NBALive;

class NBALiveTeam extends NBALiveBase
{

    public array $data = [];

    public array $details = [];

    public function __construct(int $team_id = 1610612754)
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/teamdetails?TeamID={$team_id}");

        $team = $this->data['resultSets']['0']['rowSet'][0];

        $this->details = [
            'id' => $team[0],
            'name' => $team[2],
            'short_name' => $team[1],
            'city' => $team[4],
            'arena' => $team[5],
            'year_founded' => $team[3],
        ];

    }

}