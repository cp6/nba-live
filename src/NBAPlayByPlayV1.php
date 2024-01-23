<?php

namespace Corbpie\NBALive;

class NBAPlayByPlayV1 extends NBABase
{

    public array $data = [];

    public array $all_plays = [];

    public array $last_10_plays = [];

    public array $scoring_plays = [];

    public int $plays_count;

    public function __construct(string $game_id = '', int $start_period = 1, int $end_period = 4)
    {
        if (!isset($this->game_id)) {
            $this->game_id = $game_id;
        }

        $this->data = $this->ApiCall("https://stats.nba.com/stats/playbyplay?EndPeriod={$end_period}&GameID={$this->game_id}&StartPeriod={$start_period}");

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
                "score_margin" => (!is_null($p[11])) ? (int)$p[11] : null
            ];
        }

        $this->last_10_plays = array_slice($this->all_plays, -10);
        $this->plays_count = count($this->all_plays);

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