<?php

namespace Corbpie\NBALive;

class NBABoxScoreScoring extends NBABoxScoreFilters
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

        $this->data = $this->ApiCall("https://stats.nba.com/stats/boxscorescoringv3?" . $this->build() . "&GameID={$this->game_id}");

        $this->home_players = $this->data['boxScoreScoring']['homeTeam']['players'];
        $this->away_players = $this->data['boxScoreScoring']['awayTeam']['players'];

        $this->home_team = $this->data['boxScoreScoring']['homeTeam']['statistics'];
        $this->away_team = $this->data['boxScoreScoring']['awayTeam']['statistics'];

    }

}