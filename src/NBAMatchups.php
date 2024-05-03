<?php

namespace Corbpie\NBALive;

class NBAMatchups extends NBABase
{
    public string $season = NBABase::CURRENT_SEASON;

    public string $season_type = NBABase::TYPE_REGULAR;

    public string $mode_type = NBABase::MODE_TOTAL;

    public array $data = [];

    public array $details = [];

    public ?int $off_player_id = null;

    public ?int $off_team_id = null;

    public ?int $def_player_id = null;

    public ?int $def_team_id = null;

    public function fetch()
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/leagueseasonmatchups?DefPlayerID={$this->def_player_id}&DefTeamID={$this->def_team_id}&LeagueID=00&OffPlayerID={$this->off_player_id}&OffTeamID={$this->off_team_id}&PerMode={$this->mode_type}&Season={$this->season}&SeasonType={$this->season_type}");

        if (isset($this->data['resultSets'][0]['rowSet'][0])){
            foreach ($this->data['resultSets'][0]['rowSet'] as $p) {
                $this->details[] = [
                    'offensive_player_id' => $p[1],
                    'offensive_player' => $p[2],
                    'defensive_player_id' => $p[3],
                    'defensive_player' => $p[4],
                    'gp' => $p[5],
                    'matchup_min' => $p[6],
                    'partial_poss' => $p[7],
                    'player_pts' => $p[8],
                    'team_pts' => $p[9],
                    'matchup_ast' => $p[10],
                    'matchup_tov' => $p[11],
                    'matchup_blk' => $p[12],
                    'matchup_fgm' => $p[13],
                    'matchup_fga' => $p[14],
                    'matchup_fg_pct' => $p[15],
                    'matchup_fg3m' => $p[16],
                    'matchup_fg3a' => $p[17],
                    'matchup_fg3_pct' => $p[18],
                    'help_blk' => $p[19],
                    'help_fgm' => $p[20],
                    'help_fga' => $p[21],
                    'help_fg_perc' => $p[22],
                    'matchup_ftm' => $p[23],
                    'matchup_fta' => $p[24],
                    'sfl' => $p[25],
                    'matchup_time_sec' => $p[26],
                ];
            }
        }

    }

}