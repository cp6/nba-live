<?php

namespace Corbpie\NBALive;

use DateInterval;

class NBAPlayByPlayV3 extends NBABase
{

    public array $data = [];

    public array $all_plays = [];

    public array $scoring_plays = [];

    public array $last_10_plays = [];

    public array $streaks = [];

    public int $plays_count;
    public int $home_tid;

    public int $away_tid;

    public function __construct(string $game_id = '', int $start_period = 1, int $end_period = 4)
    {
        if (!isset($this->game_id)) {
            $this->game_id = $game_id;
        }

        $this->data = $this->ApiCall("https://stats.nba.com/stats/playbyplayv3?EndPeriod={$end_period}&GameID={$this->game_id}&StartPeriod={$start_period}");

        $this->all_plays = $this->data['game']['actions'];
        $this->last_10_plays = array_slice($this->all_plays, -10);
        $this->plays_count = count($this->all_plays);

    }

    public function playerOnly(int $player_id): array
    {
        $player_only = [];

        foreach ($this->all_plays as $play) {
            if ($play['personId'] === $player_id) {
                $player_only[] = $play;
            }
        }

        return $player_only;
    }

    public function teamOnly(int $team_id): array
    {
        $team_only = [];

        foreach ($this->all_plays as $play) {
            if ($play['teamId'] === $team_id) {
                $team_only[] = $play;
            }
        }

        return $team_only;
    }

    public function scoredOnly(): array
    {
        $this->scoring_plays = [];

        foreach ($this->all_plays as $play) {
            if ($play['shotResult'] === 'Made' || ($play['actionType'] === 'Free Throw' && str_contains($play['description'], '(1 PTS)'))) {
                $this->scoring_plays [] = $play;
            }
        }

        return $this->scoring_plays;
    }

    public function scoreStreaks(): array
    {
        $this->streaks = [];

        $period = 1;
        $last_score_tid = null;

        $team1_tid = $team1_name = $team1_score = $team1_start = $team1_end = null;
        $team2_tid = $team2_name = $team2_score = $team2_start = $team2_end = null;

        foreach ($this->all_plays as $play) {
            //Set team IDs
            if ($play['teamId'] !== 0) {
                if (is_null($team1_tid)) {
                    $team1_tid = $play['teamId'];
                    $team1_name = $play['teamTricode'];
                }
                if (!is_null($team1_tid) && is_null($team2_tid) && $team1_tid !== $play['teamId']) {
                    $team2_tid = $play['teamId'];
                    $team2_name = $play['teamTricode'];
                }
            }

            $description = $play['description'];

            //Get point scoring plays
            if (($play['isFieldGoal'] === 1 && $play['shotResult'] !== 'Missed') || ($play['actionType'] === 'Free Throw' && str_contains($description, 'Free Throw'))) {

                //Reset streaks at end of each qtr
                if ($period !== $play['period']) {
                    $team1_tid = $team1_name = $team1_score = $team1_start = $team1_end = null;
                    $team2_tid = $team1_name = $team2_score = $team2_start = $team2_end = null;
                }

                //Missed
                if (str_contains($description, 'MISS')){
                    continue;
                }

                //Get points scored amount
                if (str_contains($description, 'Free Throw')) {
                    $pts = 1;
                } elseif (str_contains($description, '3PT')) {
                    $pts = 3;
                } else {
                    $pts = 2;
                }
                //echo "$pts $description<br>";
                //First score of game
                if (is_null($last_score_tid)) {

                    $formatted_time_left = ($play['clock'] === '') ? null : sprintf('%02d:%02d', (new DateInterval(strstr($play['clock'], '.', true) . "S"))->i, (new DateInterval(strstr($play['clock'], '.', true) . "S"))->s);
                    if ($play['teamId'] === $team1_tid) {
                        $team1_start = $formatted_time_left;
                        $team1_score = $pts;
                    } else {
                        $team2_start = $formatted_time_left;
                        $team2_score = $pts;
                    }
                    //scorer was same as last scorer
                } elseif ($last_score_tid === $play['teamId']) {

                    if ($play['teamId'] === $team1_tid) {
                        $team1_score += $pts;
                    } else {
                        $team2_score += $pts;
                    }
                    //new scorer
                } else {
                    $formatted_time_left = ($play['clock'] === '') ? null : sprintf('%02d:%02d', (new DateInterval(strstr($play['clock'], '.', true) . "S"))->i, (new DateInterval(strstr($play['clock'], '.', true) . "S"))->s);
                    if ($play['teamId'] === $team1_tid) {
                        $team1_start = $team2_end = $formatted_time_left;
                        $team1_score = $pts;

                        $this->streaks[] = [
                            'team_id' => $team2_tid,
                            'team_name' => $team2_name,
                            'points' => $team2_score,
                            'period' => $period,
                            'start' => $team2_start,
                            'end' => $team2_end,
                        ];
                    } else {
                        $team2_start = $team1_end = $formatted_time_left;
                        $team2_score = $pts;

                        $this->streaks[] = [
                            'team_id' => $team1_tid,
                            'team_name' => $team1_name,
                            'points' => $team1_score,
                            'period' => $period,
                            'start' => $team1_start,
                            'end' => $team1_end,
                        ];
                    }
                }

                $last_score_tid = $play['teamId'];
            }

            $period = $play['period'];
        }

        return $this->streaks;
    }

}