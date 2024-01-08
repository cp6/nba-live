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


    }

}