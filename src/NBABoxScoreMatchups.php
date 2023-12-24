<?php

namespace Corbpie\NBALive;

class NBABoxScoreMatchups extends NBABase
{

    public array $data = [];

    public array $home_players = [];

    public array $away_players = [];

    public function __construct(string $game_id = '')
    {
        if (!isset($this->game_id)) {
            $this->game_id = $game_id;
        }

        $this->data = $this->ApiCall("https://stats.nba.com/stats/boxscorematchupsv3?GameID={$this->game_id}");

        $this->home_players = $this->data['boxScoreMatchups']['homeTeam']['players'];
        $this->away_players = $this->data['boxScoreMatchups']['awayTeam']['players'];

    }

    public function playerOnly(int $player_id): array
    {
        $player_only = [];

        foreach ($this->data['boxScoreMatchups']['homeTeam']['players'] as $mu) {
            if ($mu['personId'] === $player_id) {
                $player_only[] = $mu;
                continue;
            }
        }

        foreach ($this->data['boxScoreMatchups']['awayTeam']['players'] as $mu) {
            if ($mu['personId'] === $player_id) {
                $player_only[] = $mu;
                continue;
            }
        }

        return $player_only;
    }

    public function playerMatchedWith(int $player_id): array
    {
        $matched_with = [];

        foreach ($this->data['boxScoreMatchups']['homeTeam']['players'] as $player) {
            foreach ($player['matchups'] as $mu) {
                if ($mu['personId'] === $player_id) {
                    $matched_with[] = [
                        'player_id' => $player['personId'],
                        'player_name' => $player['nameI'],
                        'matched_on_id' => $mu['personId'],
                        'matched_on_name' => $mu['nameI'],
                        'statistics' => $mu['statistics']
                    ];
                    continue;
                }
            }
        }

        foreach ($this->data['boxScoreMatchups']['awayTeam']['players'] as $player) {
            foreach ($player['matchups'] as $mu) {
                if ($mu['personId'] === $player_id) {
                    $matched_with[] = [
                        'player_id' => $player['personId'],
                        'player_name' => $player['nameI'],
                        'matched_on_id' => $mu['personId'],
                        'matched_on_name' => $mu['nameI'],
                        'statistics' => $mu['statistics']
                    ];
                    continue;
                }
            }
        }

        return $matched_with;
    }

}