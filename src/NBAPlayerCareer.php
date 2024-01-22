<?php

namespace Corbpie\NBALive;

class NBAPlayerCareer extends NBABase
{

    public array $data = [];

    public array $season_totals_regular = [];

    public array $career_totals_regular = [];

    public array $season_totals_post = [];

    public array $career_totals_post = [];

    public array $season_totals_all_star = [];

    public array $career_totals_all_star = [];

    public array $season_totals_college = [];

    public array $career_totals_college = [];

    public array $season_totals_showcase = [];

    public array $career_totals_showcase = [];

    public array $season_rankings_regular = [];

    public array $season_rankings_post = [];

    public function __construct(int $player_id = 202331, string $per_mode = 'Totals')
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/playercareerstats?LeagueID=&PerMode={$per_mode}&PlayerID={$player_id}");

    }

}