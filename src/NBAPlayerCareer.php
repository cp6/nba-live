<?php

namespace Corbpie\NBALive;

class NBAPlayerCareer extends NBABase
{

    public array $data = [];

    public function __construct(int $player_id = 202331, string $per_mode = 'Totals')
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/playercareerstats?LeagueID=&PerMode={$per_mode}&PlayerID={$player_id}");

    }

}