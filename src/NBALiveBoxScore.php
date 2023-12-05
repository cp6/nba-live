<?php

namespace Corbpie\NBALive;


class NBALiveBoxScore extends NBALiveBase
{

    public string $game_id;

    public array $home_players = [];

    public array $away_players = [];

    public array $home_team = [];

    public array $away_team = [];

    public function __construct(string $game_id)
    {
        $this->game_id = $game_id;
    }

    public function process(): array
    {
        $data = $this->ApiCall("boxscore/boxscore_{$this->game_id}");

        $this->home_team = $data['game']['homeTeam']['statistics'];
        $this->away_team = $data['game']['awayTeam']['statistics'];

        $this->home_players = $data['game']['homeTeam']['players'];
        $this->away_players = $data['game']['awayTeam']['players'];

        return $data;
    }

}