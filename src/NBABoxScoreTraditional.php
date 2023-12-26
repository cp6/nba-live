<?php

namespace Corbpie\NBALive;

class NBABoxScoreTraditional extends NBABoxScoreFilters
{
    public array $data = [];

    public array $home_players = [];

    public array $away_players = [];

    public array $home_team = [];

    public array $home_starters = [];

    public array $home_bench = [];

    public array $away_team = [];

    public array $away_starters = [];

    public array $away_bench = [];

    public array $teams = [];
    public array $teams_starters = [];

    public array $teams_bench = [];

    public function fetch(): array
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/boxscoretraditionalv3?" . $this->build() . "&GameID={$this->game_id}");

        $this->home_players = $this->data['boxScoreTraditional']['homeTeam']['players'];
        $this->away_players = $this->data['boxScoreTraditional']['awayTeam']['players'];

        $this->home_team = $this->data['boxScoreTraditional']['homeTeam']['statistics'];
        $this->home_starters = $this->data['boxScoreTraditional']['homeTeam']['starters'];
        $this->home_bench = $this->data['boxScoreTraditional']['homeTeam']['bench'];

        $this->away_team = $this->data['boxScoreTraditional']['awayTeam']['statistics'];
        $this->away_starters = $this->data['boxScoreTraditional']['awayTeam']['starters'];
        $this->away_bench = $this->data['boxScoreTraditional']['awayTeam']['bench'];

        $this->teams = [
            'home' => $this->home_team,
            'away' => $this->away_team
        ];

        $this->teams_starters = [
            'home' => $this->home_starters,
            'away' => $this->away_starters
        ];

        $this->teams_bench = [
            'home' => $this->home_bench,
            'away' => $this->away_bench
        ];

        return $this->data;
    }

}