<?php

namespace Corbpie\NBALive;

class NBARosters extends NBABase
{

    public array $data = [];

    public array $players = [];

    public array $coaches = [];

    public function __construct(int $team_id, string $season = self::CURRENT_SEASON)
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/commonteamroster?LeagueID=&Season={$season}&TeamID={$team_id}");

        if (isset($this->data['resultSets'][0]['rowSet'])) {
            foreach ($this->data['resultSets'][0]['rowSet'] as $p) {
                $this->players[] = [
                    'player_id' => $p[14],
                    'year' => (int)$p[1],
                    'season' => $season,
                    'team_id' => $team_id,
                    'player' => $p[3],
                    'nickname' => $p[4],
                    'slug' => $p[5],
                    'number' => (int)$p[6],
                    'position' => $p[7],
                    'height' => $p[8],
                    'height_cm' => $this->feetInchesToCm($p[8]),
                    'weight' => $p[9],
                    'weight_kg' => (int)number_format((int)$p[9] * 0.45359237, 0),
                    'birthdate' => \DateTime::createFromFormat('M d, Y', $p[10])->format('Y-m-d'),
                    'age' => $p[11],
                    'exp' => ($p[12] !== 'R')? (int)$p[12] : 0,
                    'school' => $p[13],
                    'how_acquired' => $p[15]
                ];
            }
        }

        if (isset($this->data['resultSets'][1]['rowSet'])) {
            foreach ($this->data['resultSets'][1]['rowSet'] as $c) {
                $this->coaches[] = [
                    'coach_id' => $c[2],
                    'season' => $c[1],
                    'first_name' => $c[3],
                    'last_name' => $c[4],
                    'coach_name' => $c[5],
                    'is_assistant' => $c[6],
                    'coach_type' => $c[7],
                    'sort_sequence' => $c[8],
                    'sub_sort_sequence' => $c[9]
                ];
            }
        }

    }


}