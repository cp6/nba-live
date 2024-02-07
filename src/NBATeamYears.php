<?php

namespace Corbpie\NBALive;

class NBATeamYears extends NBABase
{

    public array $data = [];

    public array $teams = [];

    public function __construct($league_id = '00')
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/commonteamyears?LeagueID={$league_id}");

        foreach ($this->data['resultSets'][0]['rowSet'] as $team){
            $this->teams[] = [
                'team_id' => $team[1],
                'team' => $team[4],
                'min_year' => (int)$team[2],
                'max_year' => (int)$team[3],
            ];
        }

    }

}