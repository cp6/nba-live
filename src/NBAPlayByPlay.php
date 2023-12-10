<?php

namespace Corbpie\NBALive;

use DateInterval;

class NBAPlayByPlay extends NBABase
{

    public array $all_plays = [];

    public array $last_10_plays = [];

    public int $plays_count;

    public function __construct(string $game_id = '')
    {
        if (!isset($this->game_id)) {
            $this->game_id = $game_id;
        }

        $data = $this->ApiCall("https://cdn.nba.com/static/json/liveData/playbyplay/playbyplay_{$this->game_id}.json");

        $this->all_plays = $data['game']['actions'];
        $this->last_10_plays = array_slice($this->all_plays, -10);
        $this->plays_count = count($this->all_plays);

    }

    public function playerOnly(int $player_id): array
    {
        $player_only = [];

        foreach ($this->all_plays as $play) {
            if (isset($play['personIdsFilter'][0]) && $play['personIdsFilter'][0] === $player_id) {
                $player_only[] = $play;
            }
        }

        return $player_only;
    }

    public function teamOnly(int $team_id): array
    {
        $team_only = [];

        foreach ($this->all_plays as $play) {
            if (isset($play['teamId']) && $play['teamId'] === $team_id) {
                $team_only[] = $play;
            }
        }

        return $team_only;
    }

    public function scoreLine(): array
    {
        $scores = [];

        $score_home = $score_away = 0;

        foreach ($this->all_plays as $play) {

            if ($score_home !== (int)$play['scoreHome'] || $score_away !== (int)$play['scoreAway']) {

                $score_home = (int)$play['scoreHome'];
                $score_away = (int)$play['scoreAway'];

                $formatted_time_left = ($play['clock'] === '') ? null : sprintf('%02d:%02d', (new DateInterval(strstr($play['clock'], '.', true) . "S"))->i, (new DateInterval(strstr($play['clock'], '.', true) . "S"))->s);

                $scores[] = [
                    'action_number' => $play['actionNumber'],
                    'home' => (int)$play['scoreHome'],
                    'away' => (int)$play['scoreAway'],
                    'margin' => ($score_home > $score_away) ? $score_home - $score_away : $score_away - $score_home,
                    'period' => $play['period'],
                    'time_left' => $formatted_time_left
                ];

            }

        }

        return $scores;
    }

}