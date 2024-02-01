<?php

namespace Corbpie\NBALive;

class NBAPlayoffPicture extends NBABase
{

    public array $data = [];

    public array $east_conf_playoff_picture = [];

    public array $west_conf_playoff_picture = [];

    public array $east_conf_standings = [];

    public array $west_conf_standings = [];

    public array $east_conf_remaining_games = [];

    public array $west_conf_remaining_games = [];

    public function __construct(string $season = '22019')
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/playoffpicture?LeagueID=00&SeasonID=$season");

        if (isset($this->data['resultSets'][0]['rowSet'][0])) {
            foreach ($this->data['resultSets'][0]['rowSet'] as $d) {
                $this->east_conf_playoff_picture[] = [
                    'high_seed_rank' => $d[0],
                    'high_seed_team' => $d[1],
                    'high_seed_team_id' => $d[2],
                    'low_seed_rank' => $d[3],
                    'low_seed_team' => $d[4],
                    'low_seed_team_id' => $d[5],
                    'high_seed_series_w' => $d[6],
                    'high_seed_series_l' => $d[7],
                    'high_seed_series_remaining_g' => $d[8],
                    'high_seed_series_remaining_home_g' => $d[9],
                    'high_seed_series_remaining_away_g' => $d[10]
                ];
            }
        }

        if (isset($this->data['resultSets'][1]['rowSet'][0])) {
            foreach ($this->data['resultSets'][1]['rowSet'] as $d) {
                $this->west_conf_playoff_picture[] = [
                    'high_seed_rank' => $d[1],
                    'high_seed_team' => $d[2],
                    'high_seed_team_id' => $d[3],
                    'low_seed_rank' => $d[4],
                    'low_seed_team' => $d[5],
                    'low_seed_team_id' => $d[6],
                    'high_seed_series_w' => $d[7],
                    'high_seed_series_l' => $d[8],
                    'high_seed_series_remaining_g' => $d[9],
                    'high_seed_series_remaining_home_g' => $d[10],
                    'high_seed_series_remaining_away_g' => $d[11]
                ];
            }
        }

        if (isset($this->data['resultSets'][2]['rowSet'][0])) {

        }

        if (isset($this->data['resultSets'][3]['rowSet'][0])) {

        }

        if (isset($this->data['resultSets'][4]['rowSet'][0])) {

        }

        if (isset($this->data['resultSets'][5]['rowSet'][0])) {

        }

    }

}