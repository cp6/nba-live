<?php

namespace Corbpie\NBALive;

use DateInterval;

class NBAPlayByPlayV2 extends NBABase
{

    public array $data = [];

    public array $all_plays = [];

    public array $scoring_plays = [];

    public array $last_10_plays = [];

    public int $plays_count;

    public function __construct(string $game_id = '', int $start_period = 1, int $end_period = 4)
    {
        if (!isset($this->game_id)) {
            $this->game_id = $game_id;
        }

        $this->data = $this->ApiCall("https://stats.nba.com/stats/playbyplayv2?EndPeriod={$end_period}&GameID={$this->game_id}&StartPeriod={$start_period}");

        foreach ($this->data['resultSets'][0]['rowSet'] as $p) {
            $this->all_plays[] = [
                "game_id" => $p[0],
                "event_num" => $p[1],
                "event_msg_type" => $p[2],
                "event_msg_action_type" => $p[3],
                "period" => $p[4],
                "wc_time_string" => $p[5],
                "pc_time_string" => $p[6],
                "home_description" => $p[7],
                "neutral_description" => $p[8],
                "visitor_description" => $p[9],
                "score" => $p[10],
                "score_margin" => (!is_null($p[11]))? (int)$p[11] : null,
                "person1_type" => $p[12],
                "player1_id" => $p[13],
                "player1_name" => $p[14],
                "player1_team_id" => $p[15],
                "player1_team_city" => $p[16],
                "player1_team_nickname" => $p[17],
                "player1_team_abbreviation" => $p[18],
                "person2_type" => $p[19],
                "player2_id" => $p[20],
                "player2_name" => $p[21],
                "player2_team_id" => $p[22],
                "player2_team_city" => $p[23],
                "player2_team_nickname" => $p[24],
                "player2_team_abbreviation" => $p[25],
                "person3_type" => $p[26],
                "player3_id" => $p[27],
                "player3_name" => $p[28],
                "player3_team_id" => $p[29],
                "player3_team_city" => $p[30],
                "player3_team_nickname" => $p[31],
                "player3_team_abbreviation" => $p[32],
                "video_available_flag" => $p[33]
            ];
        }

        $this->last_10_plays = array_slice($this->all_plays, -10);
        $this->plays_count = count($this->all_plays);

    }

    public function playerOnly(int $player_id): array
    {
        $player_only = [];

        foreach ($this->all_plays as $play) {
            if ($play['player1_id'] === $player_id || $play['player2_id'] === $player_id || $play['player3_id'] === $player_id) {
                $player_only[] = $play;
            }
        }

        return $player_only;
    }

    public function teamOnly(int $team_id): array
    {
        $team_only = [];

        foreach ($this->all_plays as $play) {
            if ($play['player1_team_id'] === $team_id || $play['player2_team_id'] === $team_id || $play['player3_team_id'] === $team_id) {
                $team_only[] = $play;
            }
        }

        return $team_only;
    }

    public function scoredOnly(): array
    {
        $this->scoring_plays = [];

        foreach ($this->all_plays as $play) {
            if (!is_null($play['score_margin'])) {
                $this->scoring_plays [] = $play;
            }
        }

        return $this->scoring_plays;
    }

}