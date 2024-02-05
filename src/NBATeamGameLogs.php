<?php

namespace Corbpie\NBALive;

class NBATeamGameLogs extends NBABase
{
    public array $data = [];

    public array $games = [];

    public int $team_id;

    public string $season = NBABase::CURRENT_SEASON;

    public string $season_type = NBABase::TYPE_REGULAR;

    public string $date_from = '';

    public string $date_to = '';

    public function fetch(): array
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/teamgamelog?DateFrom={$this->date_from}&DateTo={$this->date_to}&LeagueID=&Season={$this->season}&SeasonType={$this->season_type}&TeamID={$this->team_id}");

        if (isset($this->data['resultSets'][0]['rowSet'][0])) {
            foreach ($this->data['resultSets'][0]['rowSet'] as $g) {
                $this->games[] = [
                    'game_id' => $g[1],
                    'game_date' => date('Y-m-d', strtotime($g[2])),
                    'matchup' => $g[3],
                    'was_win' => $g[4] === 'W',
                    'wins' => $g[5],
                    'losses' => $g[6],
                    'win_pct' => $g[7],
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
                    'pts' => $g[26]
                ];
            }
        }

        return $this->data;
    }

    public function lastXGames(int $games = 10): array
    {
        return array_slice($this->games, 0, $games);
    }

}