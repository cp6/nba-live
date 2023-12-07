<?php

namespace Corbpie\NBALive;

class NBARotations extends NBABase
{
    public array $data = [];

    public array $details = [];

    public function __construct(string $game_id)
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/gamerotation?GameID={$game_id}&LeagueID=00");

        foreach ($this->data['resultSets'][0]['rowSet'] as $r) {

            $in_seconds = (int)($r[7] / 10);
            $out_seconds = (int)($r[8] / 10);

            $in_qtr = $this->timeAsQtr($in_seconds);
            $out_qtr = $this->timeAsQtr($out_seconds);

            $total_time = gmdate("i:s", (int)($out_seconds - $in_seconds));

            $in_time_string = gmdate("i:s", (int)$in_seconds);
            $out_time_string = gmdate("i:s", (int)$out_seconds);

            $in_time_left_qtr = $this->timeLeftInQtr($in_seconds);
            $out_time_left_qtr = $this->timeLeftInQtr($out_seconds);

            $in_time_left = gmdate("i:s", (int)$in_time_left_qtr);
            $out_time_left = gmdate("i:s", (int)$out_time_left_qtr);

            $this->details[] = [
                'team_id' => $r[1],
                'team_short' => $r[3],
                'player_id' => $r[4],
                'player_name' => $r[5][0] . '.' . $r[6],
                'in_period' => $in_qtr,
                'in' => $in_time_string,
                'in_time_left' => $in_time_left,
                'out_period' => $out_qtr,
                'out' => $out_time_string,
                'out_time_left' => $out_time_left,
                'total_time' => $total_time,
                'pts' => $r[9],
                'pts_diff' => $r[10],
                'usg_pct' => $r[11],
            ];

        }

    }

    public function timeAsQtr(int $seconds): int
    {
        if ($seconds <= 720) {
            return 1;
        } else if ($seconds <= 1440) {
            return 2;
        } else if ($seconds <= 2160) {
            return 3;
        } else if ($seconds <= 2880) {
            return 4;
        } else if ($seconds <= 3180) {
            return 5;//OT1
        } else if ($seconds <= 3480) {
            return 6;//OT2
        } else {
            return 7;//OT3
        }
    }

    public function timeLeftInQtr(int $seconds): int
    {
        if ($seconds <= 720) {
            return (720 - $seconds);
        } else if ($seconds <= 1440) {
            return (1440 - $seconds);
        } else if ($seconds <= 2160) {
            return (2160 - $seconds);
        } else if ($seconds <= 2880) {
            return (2880 - $seconds);
        } else if ($seconds <= 3180) {
            return (3180 - $seconds);
        } else if ($seconds <= 3480) {
            return (3480 - $seconds);
        } else {
            return ($seconds <= 3780);
        }
    }

    public function playerOnly(int $player_id): array
    {
        $player_only = [];

        foreach ($this->details as $play) {
            if ($play['player_id'] === $player_id) {
                $player_only[] = $play;
            }
        }

        return $player_only;
    }

    public function teamOnly(int $team_id): array
    {
        $team_only = [];

        foreach ($this->details as $play) {
            if ($play['team_id'] === $team_id) {
                $team_only[] = $play;
            }
        }

        return $team_only;
    }

}