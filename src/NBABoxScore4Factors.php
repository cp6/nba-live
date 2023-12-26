<?php

namespace Corbpie\NBALive;

class NBABoxScore4Factors extends NBABoxScoreFilters
{

    public array $data = [];

    public array $home_players = [];

    public array $away_players = [];

    public array $home_team = [];

    public array $away_team = [];

    public function fetch(): array
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/boxscorefourfactorsv3?" . $this->build() . "&GameID={$this->game_id}");

        $this->home_players = $this->data['boxScoreFourFactors']['homeTeam']['players'];
        $this->away_players = $this->data['boxScoreFourFactors']['awayTeam']['players'];

        $this->home_team = $this->data['boxScoreFourFactors']['homeTeam']['statistics'];
        $this->away_team = $this->data['boxScoreFourFactors']['awayTeam']['statistics'];

        return $this->data;
    }

}