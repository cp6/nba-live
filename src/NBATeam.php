<?php

namespace Corbpie\NBALive;

class NBATeam extends NBABase
{

    public array $data = [];

    public array $details = [];

    public function __construct(int $team_id = 0)
    {
        if (!isset($this->team_id)) {
            $this->team_id = $team_id;
        }

        $this->data = $this->ApiCall("https://stats.nba.com/stats/teamdetails?TeamID={$this->team_id}");

        if (isset($this->data['resultSets'][0]['rowSet'][0])) {
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

}