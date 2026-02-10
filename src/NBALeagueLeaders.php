<?php

namespace Corbpie\NBALive;

/**
 * Retrieve NBA league leaders for various statistical categories.
 */
class NBALeagueLeaders extends NBABase
{
    // League leaders API array indices
    private const IDX_PLAYER_ID = 0;
    private const IDX_NAME = 2;
    private const IDX_TEAM_ID = 3;
    private const IDX_TEAM = 4;
    private const IDX_GP = 5;
    private const IDX_MIN = 6;
    private const IDX_FGM = 7;
    private const IDX_FGA = 8;
    private const IDX_FGP = 9;
    private const IDX_F3M = 10;
    private const IDX_F3A = 11;
    private const IDX_F3P = 12;
    private const IDX_FTM = 13;
    private const IDX_FTA = 14;
    private const IDX_FTP = 15;
    private const IDX_OREB = 16;
    private const IDX_DREB = 17;
    private const IDX_REB = 18;
    private const IDX_AST = 19;
    private const IDX_STL = 20;
    private const IDX_BLK = 21;
    private const IDX_TOV = 22;
    private const IDX_PF = 23;
    private const IDX_PTS = 24;
    private const IDX_EFF = 25;
    private const IDX_AST_TOV = 26;
    private const IDX_STL_TOV = 27;

    /** @var array Raw API response data */
    public array $data = [];

    /** @var array Processed league leaders data */
    public array $details = [];

    /**
     * Fetch league leaders for a specific stat category.
     *
     * @param string $stat Statistical category (e.g., 'PTS', 'REB', 'AST')
     * @param string $mode Statistics mode (PerGame, Totals, Per48)
     * @param string $season Season identifier
     * @param string $type Season type (Regular+Season, Playoffs, etc.)
     * @throws NBAApiException When the API request fails
     */
    public function __construct(
        string $stat = 'PTS',
        string $mode = self::MODE_TOTAL,
        string $season = self::CURRENT_SEASON,
        string $type = self::TYPE_REGULAR
    ) {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/leagueleaders?ActiveFlag=&LeagueID=00&PerMode={$mode}&Scope=S&Season={$season}&SeasonType={$type}&StatCategory={$stat}");

        $rank = 0;
        if (isset($this->data['resultSet']['rowSet'])) {
            foreach ($this->data['resultSet']['rowSet'] as $p) {
                $rank++;
                $this->details[] = [
                    'rank' => $rank,
                    'player_id' => $p[self::IDX_PLAYER_ID] ?? 0,
                    'name' => $p[self::IDX_NAME] ?? '',
                    'team_id' => $p[self::IDX_TEAM_ID] ?? 0,
                    'team' => $p[self::IDX_TEAM] ?? '',
                    'gp' => $p[self::IDX_GP] ?? 0,
                    'min' => $p[self::IDX_MIN] ?? 0,
                    'fgm' => $p[self::IDX_FGM] ?? 0,
                    'fga' => $p[self::IDX_FGA] ?? 0,
                    'fgp' => $p[self::IDX_FGP] ?? 0,
                    'ftm' => $p[self::IDX_FTM] ?? 0,
                    'fta' => $p[self::IDX_FTA] ?? 0,
                    'ftp' => $p[self::IDX_FTP] ?? 0,
                    'f3m' => $p[self::IDX_F3M] ?? 0,
                    'f3a' => $p[self::IDX_F3A] ?? 0,
                    'f3p' => $p[self::IDX_F3P] ?? 0,
                    'oreb' => $p[self::IDX_OREB] ?? 0,
                    'dreb' => $p[self::IDX_DREB] ?? 0,
                    'reb' => $p[self::IDX_REB] ?? 0,
                    'ast' => $p[self::IDX_AST] ?? 0,
                    'stl' => $p[self::IDX_STL] ?? 0,
                    'blk' => $p[self::IDX_BLK] ?? 0,
                    'tov' => $p[self::IDX_TOV] ?? 0,
                    'pf' => $p[self::IDX_PF] ?? 0,
                    'pts' => $p[self::IDX_PTS] ?? 0,
                    'eff' => $p[self::IDX_EFF] ?? 0,
                    'ast_tov' => $p[self::IDX_AST_TOV] ?? null,
                    'stl_tov' => $p[self::IDX_STL_TOV] ?? null
                ];
            }
        }
    }
}
