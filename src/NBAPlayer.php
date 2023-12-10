<?php

namespace Corbpie\NBALive;

use DateTime;

class NBAPlayer extends NBABase
{

    public array $data = [];

    public array $details = [];

    public array $seasons = [];

    public function __construct(int $player_id = 0)
    {
        if (!isset($this->player_id)) {
            $this->player_id = $player_id;
        }

        $this->data = $this->ApiCall("https://stats.nba.com/stats/commonplayerinfo?LeagueID=&PlayerID={$this->player_id}");

        $p = $this->data['resultSets']['0']['rowSet'][0];

        $this->details = [
            'id' => $p[0],
            'first_name' => $p[1],
            'last_name' => $p[2],
            'short_name' => $p[5],
            'slug' => $p[6],
            'birthdate' => str_replace("T00:00:00", "", $p[7]),
            'age' => (new DateTime('now'))->diff(new DateTime($p[7]))->y,
            'school' => $p[8],
            'last_aff' => $p[10],
            'country' => $p[9],
            'height' => $p[11],
            'height_cm' => $this->feetInchesToCm($p[11]),
            'weight' => (int)$p[12],
            'weight_kg' => (int)number_format((int)$p[12] * 0.45359237, 0),
            'seasons' => $p[13],
            'jersey' => (int)$p[14],
            'position' => $p[15],
            'status' => $p[16],
            'current_team_id' => $p[18],
            'current_team_name' => $p[19],
            'current_team_short' => $p[20],
            'from_year' => $p[24],
            'to_year' => $p[25],
            'draft_year' => (int)$p[29],
            'draft_round' => (int)$p[30],
            'draft_number' => (int)$p[31],
            'played_current_season' => $p[17] === 'Y',
        ];

        if (isset($this->data['resultSets']['2']['rowSet'])) {
            foreach ($this->data['resultSets']['2']['rowSet'] as $season) {
                $this->seasons[] = [
                    'type' => (int)$season[0][0],
                    'year' => (int)substr($season[0], 1)
                ];
            }
        }

    }

    public function feetInchesToCm(string $feetInches): int
    {
        $array = explode('-', $feetInches);
        if (isset($array[1])) {
            return (int)number_format(($array[0] * 30.48) + ($array[1] * 2.54), 0);
        }
        return (int)number_format(($array[0] * 30.48), 0);
    }

}