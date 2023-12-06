<?php

namespace Corbpie\NBALive;

class NBALiveLeagueLeaders extends NBALiveBase
{

    public array $data = [];

    public array $details = [];

    public function __construct(string $stat = 'PTS', string $mode = self::MODE_TOTAL, string $season = self::CURRENT_SEASON, string $type = self::TYPE_REGULAR)
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/leagueleaders?ActiveFlag=&LeagueID=00&PerMode={$mode}&Scope=S&Season={$season}&SeasonType={$type}&StatCategory={$stat}");

        $rank = 0;

        foreach ($this->data['resultSet']['rowSet'] as $p) {
            $rank++;
            $this->details[] = [
                'rank' => $rank,
                'player_id' => $p[0],
                'name' => $p[2],
                'team_id' => $p[3],
                'team' => $p[4],
                'gp' => $p[5],
                'min' => $p[6],
                'fgm' => $p[7],
                'fga' => $p[8],
                'fgp' => $p[9],
                'ftm' => $p[13],
                'fta' => $p[14],
                'ftp' => $p[15],
                'f3m' => $p[10],
                'f3a' => $p[11],
                'f3p' => $p[12],
                'oreb' => $p[16],
                'dreb' => $p[17],
                'reb' => $p[18],
                'ast' => $p[19],
                'stl' => $p[20],
                'blk' => $p[21],
                'tov' => $p[22],
                'pf' => $p[23],
                'pts' => $p[24],
                'eff' => $p[25],
                'ast_tov' => $p[26] ?? null,
                'stl_tov' => $p[27] ?? null
            ];
        }

    }


}