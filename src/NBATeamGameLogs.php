<?php

namespace Corbpie\NBALive;

/**
 * Retrieve NBA team game logs for a season.
 */
class NBATeamGameLogs extends NBABase
{
    // Game log API array indices
    private const IDX_GAME_ID = 1;
    private const IDX_GAME_DATE = 2;
    private const IDX_MATCHUP = 3;
    private const IDX_WIN_LOSS = 4;
    private const IDX_WINS = 5;
    private const IDX_LOSSES = 6;
    private const IDX_WIN_PCT = 7;
    private const IDX_MIN = 8;
    private const IDX_FGM = 9;
    private const IDX_FGA = 10;
    private const IDX_FG_PCT = 11;
    private const IDX_FG3M = 12;
    private const IDX_FG3A = 13;
    private const IDX_FG3_PCT = 14;
    private const IDX_FTM = 15;
    private const IDX_FTA = 16;
    private const IDX_FT_PCT = 17;
    private const IDX_OREB = 18;
    private const IDX_DREB = 19;
    private const IDX_REB = 20;
    private const IDX_AST = 21;
    private const IDX_STL = 22;
    private const IDX_BLK = 23;
    private const IDX_TOV = 24;
    private const IDX_PF = 25;
    private const IDX_PTS = 26;

    /** @var array Raw API response data */
    public array $data = [];

    /** @var array Processed game logs */
    public array $games = [];

    /** @var int Team identifier */
    public int $team_id;

    /** @var string Season identifier */
    public string $season = NBABase::CURRENT_SEASON;

    /** @var string Season type */
    public string $season_type = NBABase::TYPE_REGULAR;

    /** @var string Start date filter (Y-m-d format) */
    public string $date_from = '';

    /** @var string End date filter (Y-m-d format) */
    public string $date_to = '';

    /**
     * Fetch team game logs from the API.
     *
     * @return array Raw API response data
     * @throws NBAApiException When the API request fails
     * @throws \InvalidArgumentException When team_id is not set
     */
    public function fetch(): array
    {
        if (!isset($this->team_id) || $this->team_id <= 0) {
            throw new \InvalidArgumentException('team_id must be set before calling fetch()');
        }

        $this->data = $this->ApiCall("https://stats.nba.com/stats/teamgamelog?DateFrom={$this->date_from}&DateTo={$this->date_to}&LeagueID=&Season={$this->season}&SeasonType={$this->season_type}&TeamID={$this->team_id}");

        if (isset($this->data['resultSets'][0]['rowSet'][0])) {
            foreach ($this->data['resultSets'][0]['rowSet'] as $g) {
                $this->games[] = [
                    'game_id' => $g[self::IDX_GAME_ID] ?? '',
                    'game_date' => date('Y-m-d', strtotime($g[self::IDX_GAME_DATE] ?? '')),
                    'matchup' => $g[self::IDX_MATCHUP] ?? '',
                    'was_win' => ($g[self::IDX_WIN_LOSS] ?? '') === 'W',
                    'wins' => $g[self::IDX_WINS] ?? 0,
                    'losses' => $g[self::IDX_LOSSES] ?? 0,
                    'win_pct' => $g[self::IDX_WIN_PCT] ?? 0,
                    'min' => $g[self::IDX_MIN] ?? 0,
                    'fgm' => $g[self::IDX_FGM] ?? 0,
                    'fga' => $g[self::IDX_FGA] ?? 0,
                    'fg_pct' => $g[self::IDX_FG_PCT] ?? 0,
                    'fg3m' => $g[self::IDX_FG3M] ?? 0,
                    'fg3a' => $g[self::IDX_FG3A] ?? 0,
                    'fg3_pct' => $g[self::IDX_FG3_PCT] ?? 0,
                    'ftm' => $g[self::IDX_FTM] ?? 0,
                    'fta' => $g[self::IDX_FTA] ?? 0,
                    'ft_pct' => $g[self::IDX_FT_PCT] ?? 0,
                    'oreb' => $g[self::IDX_OREB] ?? 0,
                    'dreb' => $g[self::IDX_DREB] ?? 0,
                    'reb' => $g[self::IDX_REB] ?? 0,
                    'ast' => $g[self::IDX_AST] ?? 0,
                    'stl' => $g[self::IDX_STL] ?? 0,
                    'blk' => $g[self::IDX_BLK] ?? 0,
                    'tov' => $g[self::IDX_TOV] ?? 0,
                    'pf' => $g[self::IDX_PF] ?? 0,
                    'pts' => $g[self::IDX_PTS] ?? 0
                ];
            }
        }

        return $this->data;
    }

    /**
     * Get the last X games from the game log.
     *
     * @param int $games Number of games to return (default: 10)
     * @return array Last X games
     */
    public function lastXGames(int $games = 10): array
    {
        return array_slice($this->games, 0, $games);
    }
}
