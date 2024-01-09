<?php

namespace Corbpie\NBALive;


class NBABoxScore extends NBABase
{

    public array $data = [];

    public array $home_players = [];

    public array $away_players = [];

    public array $home_team = [];

    public array $away_team = [];

    public int $home_tid;

    public int $away_tid;

    public function __construct(string $game_id = '')
    {
        if (!isset($this->game_id)) {
            $this->game_id = $game_id;
        }

        $this->data = $this->ApiCall("https://cdn.nba.com/static/json/liveData/boxscore/boxscore_{$this->game_id}.json");

        $this->home_team = $this->data['game']['homeTeam']['statistics'];
        $this->away_team = $this->data['game']['awayTeam']['statistics'];

        $this->home_players = $this->data['game']['homeTeam']['players'];
        $this->away_players = $this->data['game']['awayTeam']['players'];

        $this->home_tid = $this->data['game']['homeTeam']['teamId'];
        $this->away_tid = $this->data['game']['awayTeam']['teamId'];

    }

    public function sortAsc(array $players_data, string $key = 'points'): array
    {
        usort($players_data, fn($a, $b) => $a['statistics'][$key] <=> $b['statistics'][$key]);
        return $players_data;
    }

    public function sortDesc(array $players_data, string $key = 'points'): array
    {
        usort($players_data, fn($a, $b) => $b['statistics'][$key] <=> $a['statistics'][$key]);
        return $players_data;
    }

}