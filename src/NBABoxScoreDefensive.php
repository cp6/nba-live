<?php

namespace Corbpie\NBALive;

class NBABoxScoreDefensive extends NBABase
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

        $this->data = $this->ApiCall("https://stats.nba.com/stats/boxscoredefensivev2?GameID={$this->game_id}");

        $this->home_players = $this->data['boxScoreDefensive']['homeTeam']['players'];
        $this->away_players = $this->data['boxScoreDefensive']['awayTeam']['players'];
    }

}