<?php

namespace Corbpie\NBALive;

class NBABoxScoreAdvanced extends NBABoxScoreFilters
{

    public array $data = [];

    public array $home_players = [];

    public array $away_players = [];

    public array $home_team = [];

    public array $away_team = [];

    public function fetch(): array
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/boxscoreadvancedv3?" . $this->build() . "&GameID={$this->game_id}");

        if (isset($this->data['boxScoreAdvanced'])) {
            $this->home_players = $this->data['boxScoreAdvanced']['homeTeam']['players'];
            $this->away_players = $this->data['boxScoreAdvanced']['awayTeam']['players'];

            $this->home_team = $this->data['boxScoreAdvanced']['homeTeam']['statistics'];
            $this->away_team = $this->data['boxScoreAdvanced']['awayTeam']['statistics'];
        }

        return $this->data;
    }

}