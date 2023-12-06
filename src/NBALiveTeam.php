<?php

namespace Corbpie\NBALive;

class NBALiveTeam extends NBALiveBase
{

    public array $data = [];

    public array $details = [];

    public function __construct(int $team_id = 1610612754)
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/teamdetails?TeamID={$team_id}");
    }

    public function getTeam(): array
    {
        $d = $this->data['resultSets']['0']['rowSet'][0];

        $this->details = [
            'id' => $d[0],
            'name' => $d[2],
            'short_name' => $d[1],
            'city' => $d[4],
            'arena' => $d[5],
            'year_founded' => $d[3],
        ];

        return $this->details;
    }

}