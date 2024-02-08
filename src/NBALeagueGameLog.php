<?php

namespace Corbpie\NBALive;

class NBALeagueGameLog extends NBABase
{
    public array $data = [];

    public array $games = [];

    public function __construct(string $season = NBABase::CURRENT_SEASON, string $season_type = NBABase::TYPE_REGULAR, string $sorter = 'DATE', string $date_from = '', string $date_to = '', $direction = 'ASC')
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/leaguegamelog?Counter=0&DateFrom={$date_from}&DateTo={$date_to}&Direction={$direction}&LeagueID=00&PlayerOrTeam=T&Season={$season}&SeasonType={$season_type}&Sorter={$sorter}");

        if (isset($this->data['resultSets'][0]['rowSet'][0])) {
            foreach ($this->data['resultSets'][0]['rowSet'] as $g) {
                $this->games[] = [
                    'game_id' => $g[4],
                    'team_id' => $g[1],
                    'team_abr' => $g[2],
                    'team' => $g[3],
                    'game_date' => $g[5],
                    'matchup' => $g[6],
                    'was_win' => $g[7] === 'W',
                    'min' => $g[8],
                    'fgm' => $g[9],
                    'fga' => $g[10],
                    'fg_pct' => $g[11],
                    'fg3m' => $g[12],
                    'fg3a' => $g[13],
                    'fg3_pct' => $g[14],
                    'ftm' => $g[15],
                    'fta' => $g[16],
                    'ft_pct' => $g[17],
                    'oreb' => $g[18],
                    'dreb' => $g[19],
                    'reb' => $g[20],
                    'ast' => $g[21],
                    'stl' => $g[22],
                    'blk' => $g[23],
                    'tov' => $g[24],
                    'pf' => $g[25],
                    'pts' => $g[26],
                    'plus_minus' => $g[27],
                    'has_video' => $g[28] === 1
                ];
            }
        }

    }

}