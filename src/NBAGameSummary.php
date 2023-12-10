<?php

namespace Corbpie\NBALive;


class NBAGameSummary extends NBABase
{
    public array $data = [];

    public array $home = [];

    public array $away = [];

    public array $refs = [];

    public array $inactive = [];

    public array $home_line_score = [];

    public array $away_line_score = [];

    public int $attendance;

    public array $last_meeting = [];

    public array $statuses = [];

    public function __construct(string $game_id = '')
    {
        if (!isset($this->game_id)) {
            $this->game_id = $game_id;
        }

        $this->data = $this->ApiCall("https://stats.nba.com/stats/boxscoresummaryv2?GameID={$this->game_id}");

        if (isset($this->data['resultSets'][1]['rowSet'][1])) {
            $this->home = [
                'team_id' => $this->data['resultSets'][1]['rowSet'][1][1],
                'team_name_short' => $this->data['resultSets'][1]['rowSet'][1][2],
                'pts_paint' => $this->data['resultSets'][1]['rowSet'][1][4],
                'pts_second_chance' => $this->data['resultSets'][1]['rowSet'][1][5],
                'pts_fast_break' => $this->data['resultSets'][1]['rowSet'][1][6],
                'largest_lead' => $this->data['resultSets'][1]['rowSet'][1][7],
                'lead_changes' => $this->data['resultSets'][1]['rowSet'][1][8],
                'times_tied' => $this->data['resultSets'][1]['rowSet'][1][9],
                'team_turnovers' => $this->data['resultSets'][1]['rowSet'][1][10],
                'total_turnovers' => $this->data['resultSets'][1]['rowSet'][1][11],
                'team_rebounds' => $this->data['resultSets'][1]['rowSet'][1][12],
                'pts_off_to' => $this->data['resultSets'][1]['rowSet'][1][13]
            ];
        }

        if (isset($this->data['resultSets'][1]['rowSet'][0])) {
            $this->away = [
                'team_id' => $this->data['resultSets'][1]['rowSet'][0][1],
                'team_name_short' => $this->data['resultSets'][1]['rowSet'][0][2],
                'pts_paint' => $this->data['resultSets'][1]['rowSet'][0][4],
                'pts_second_chance' => $this->data['resultSets'][1]['rowSet'][0][5],
                'pts_fast_break' => $this->data['resultSets'][1]['rowSet'][0][6],
                'largest_lead' => $this->data['resultSets'][1]['rowSet'][0][7],
                'lead_changes' => $this->data['resultSets'][1]['rowSet'][0][8],
                'times_tied' => $this->data['resultSets'][1]['rowSet'][0][9],
                'team_turnovers' => $this->data['resultSets'][1]['rowSet'][0][10],
                'total_turnovers' => $this->data['resultSets'][1]['rowSet'][0][11],
                'team_rebounds' => $this->data['resultSets'][1]['rowSet'][0][12],
                'pts_off_to' => $this->data['resultSets'][1]['rowSet'][0][13]
            ];
        }

        if (isset($this->data['resultSets'][2]['rowSet'])) {
            foreach ($this->data['resultSets'][2]['rowSet'] as $refs) {
                $this->refs[] = [
                    'ref_id' => $refs[0],
                    'first_name' => $refs[1],
                    'last_name' => $refs[2],
                    'jersey_number' => (int)$refs[3]
                ];
            }
        }

        if (isset($this->data['resultSets'][3]['rowSet'])) {
            foreach ($this->data['resultSets'][3]['rowSet'] as $inactive) {
                $this->inactive[] = [
                    'player_id' => $inactive[0],
                    'first_name' => $inactive[1],
                    'last_name' => $inactive[2],
                    'jersey_number' => (int)$inactive[3],
                    'team_id' => $inactive[4],
                    'team_name_short' => $inactive[7]
                ];
            }
        }

        if (isset($this->data['resultSets'][5]['rowSet'][0])) {
            $this->away_line_score = [
                'team_id' => $this->data['resultSets'][5]['rowSet'][0][3],
                'game_id' => $this->data['resultSets'][5]['rowSet'][0][2],
                'team_name_short' => $this->data['resultSets'][5]['rowSet'][0][4],
                'pts_q1' => $this->data['resultSets'][5]['rowSet'][0][8],
                'pts_q2' => $this->data['resultSets'][5]['rowSet'][0][9],
                'pts_q3' => $this->data['resultSets'][5]['rowSet'][0][10],
                'pts_q4' => $this->data['resultSets'][5]['rowSet'][0][11],
                'pts_ot1' => $this->data['resultSets'][5]['rowSet'][0][12],
                'pts_ot2' => $this->data['resultSets'][5]['rowSet'][0][13],
                'pts_ot3' => $this->data['resultSets'][5]['rowSet'][0][14],
                'pts_ot4' => $this->data['resultSets'][5]['rowSet'][0][15],
                'pts_ot5' => $this->data['resultSets'][5]['rowSet'][0][16],
                'pts_ot6' => $this->data['resultSets'][5]['rowSet'][0][17],
                'pts' => $this->data['resultSets'][5]['rowSet'][0][22]
            ];
        }

        if (isset($this->data['resultSets'][5]['rowSet'][1])) {
            $this->home_line_score = [
                'team_id' => $this->data['resultSets'][5]['rowSet'][1][3],
                'game_id' => $this->data['resultSets'][5]['rowSet'][1][2],
                'team_name_short' => $this->data['resultSets'][5]['rowSet'][1][4],
                'pts_q1' => $this->data['resultSets'][5]['rowSet'][1][8],
                'pts_q2' => $this->data['resultSets'][5]['rowSet'][1][9],
                'pts_q3' => $this->data['resultSets'][5]['rowSet'][1][10],
                'pts_q4' => $this->data['resultSets'][5]['rowSet'][1][11],
                'pts_ot1' => $this->data['resultSets'][5]['rowSet'][1][12],
                'pts_ot2' => $this->data['resultSets'][5]['rowSet'][1][13],
                'pts_ot3' => $this->data['resultSets'][5]['rowSet'][1][14],
                'pts_ot4' => $this->data['resultSets'][5]['rowSet'][1][15],
                'pts_ot5' => $this->data['resultSets'][5]['rowSet'][1][16],
                'pts_ot6' => $this->data['resultSets'][5]['rowSet'][1][17],
                'pts' => $this->data['resultSets'][5]['rowSet'][1][22]
            ];
        }

        $this->attendance = $this->data['resultSets'][4]['rowSet'][0][1];

        if (isset($this->data['resultSets'][6]['rowSet'][0])) {
            $this->last_meeting = [
                'game_id' => $this->data['resultSets'][6]['rowSet'][0][1],
                'date' => str_replace("T00:00:00", "", $this->data['resultSets'][6]['rowSet'][0][2]),
                'home_team_id' => $this->data['resultSets'][6]['rowSet'][0][3],
                'home_team_name_short' => $this->data['resultSets'][6]['rowSet'][0][6],
                'home_points' => $this->data['resultSets'][6]['rowSet'][0][7],
                'away_team_id' => $this->data['resultSets'][6]['rowSet'][0][8],
                'away_team_name_short' => $this->data['resultSets'][6]['rowSet'][0][11],
                'away_points' => $this->data['resultSets'][6]['rowSet'][0][12],
                'winner' => ($this->data['resultSets'][6]['rowSet'][0][7] > $this->data['resultSets'][6]['rowSet'][0][12]) ? $this->data['resultSets'][6]['rowSet'][0][3] : $this->data['resultSets'][6]['rowSet'][0][8]
            ];
        }

        if (isset($this->data['resultSets'][8]['rowSet'][0])) {
            $this->statuses = [
                'video_available' => $this->data['resultSets'][8]['rowSet'][0][1] === 1,
                'pt_available' => $this->data['resultSets'][8]['rowSet'][0][2] === 1,
                'pt_xyz_available' => $this->data['resultSets'][8]['rowSet'][0][3] === 1,
                'wh_status' => $this->data['resultSets'][8]['rowSet'][0][4] === 1,
                'hustle_status' => $this->data['resultSets'][8]['rowSet'][0][5] === 1,
                'historical_status' => $this->data['resultSets'][8]['rowSet'][0][6] === 1
            ];
        }

    }

}