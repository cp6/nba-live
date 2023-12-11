<?php

namespace Corbpie\NBALive;

class NBABoxScoreHustle extends NBABase
{

    public array $data = [];

    public array $home_players = [];

    public array $away_players = [];

    public array $home_team = [];

    public array $away_team = [];

    public function __construct(string $game_id = '')
    {
        if (!isset($this->game_id)) {
            $this->game_id = $game_id;
        }

        $this->data = $this->ApiCall("https://stats.nba.com/stats/boxscorehustlev2?GameID={$this->game_id}");

        $this->home_players = $this->data['boxScoreHustle']['homeTeam']['players'];
        $this->away_players = $this->data['boxScoreHustle']['awayTeam']['players'];

        $this->home_team = $this->data['boxScoreHustle']['homeTeam']['statistics'];
        $this->away_team = $this->data['boxScoreHustle']['awayTeam']['statistics'];
    }

}