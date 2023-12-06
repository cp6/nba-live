<?php

namespace Corbpie\NBALive;

use DateTime;

class NBALivePlayer extends NBALiveBase
{

    public array $data = [];

    public array $details = [];

    public array $seasons = [];

    public function __construct(int $player_id = 202331)
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/commonplayerinfo?LeagueID=&PlayerID={$player_id}");
    }

    public function getPlayer(): array
    {
        $d = $this->data['resultSets']['0']['rowSet'][0];

        $this->details = [
            'id' => $d[0],
            'first_name' => $d[1],
            'last_name' => $d[2],
            'short_name' => $d[5],
            'slug' => $d[6],
            'birthdate' => str_replace("T00:00:00", "", $d[7]),
            'age' => (new DateTime('now'))->diff(new DateTime($d[7]))->y,
            'school' => $d[8],
            'last_aff' => $d[10],
            'country' => $d[9],
            'height' => $d[11],
            'height_cm' => $this->feetInchesToCm($d[11]),
            'weight' => (int)$d[12],
            'weight_kg' => (int)number_format((int)$d[12] * 0.45359237, 0),
            'seasons' => $d[13],
            'jersey' => (int)$d[14],
            'position' => $d[15],
            'status' => $d[16],
            'current_team_id' => $d[18],
            'current_team_name' => $d[19],
            'current_team_short' => $d[20],
            'from_year' => $d[24],
            'to_year' => $d[25],
            'draft_year' => (int)$d[29],
            'draft_round' => (int)$d[30],
            'draft_number' => (int)$d[31],
            'played_current_season' => $d[17] === 'Y',
        ];

        return $this->details;
    }

    public function getSeasons(int $player_id = 202331): array
    {
        foreach ($this->data['resultSets']['2']['rowSet'] as $season) {
            $this->seasons[] = [
                'type' => (int)$season[0][0],
                'year' => (int)substr($season[0], 1)
            ];
        }

        return $this->seasons;
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