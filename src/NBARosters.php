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
                    'season' => $p[1],
                    'player' => $p[3],
                    'nickname' => $p[4],
                    'slug' => $p[5],
                    'number' => $p[6],
                    'position' => $p[7],
                    'height' => $p[8],
                    'weight' => $p[9],
                    'birthdate' => $p[10],
                    'age' => $p[11],
                    'exp' => $p[12],
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