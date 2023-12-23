<?php

namespace Corbpie\NBALive;

class NBABoxScoreTracking extends NBABoxScoreFilters
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

        $this->data = $this->ApiCall("https://stats.nba.com/stats/boxscoreplayertrackv3?GameID={$this->game_id}");

        $this->home_players = $this->data['boxScorePlayerTrack']['homeTeam']['players'];
        $this->away_players = $this->data['boxScorePlayerTrack']['awayTeam']['players'];

        $this->home_team = $this->data['boxScorePlayerTrack']['homeTeam']['statistics'];
        $this->away_team = $this->data['boxScorePlayerTrack']['awayTeam']['statistics'];

    }

}