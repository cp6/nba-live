<?php

namespace Corbpie\NBALive;

/**
 * Retrieve individual player game logs.
 */
class NBAPlayerGameLogs extends NBABase
{
    /** @var array Raw API response data */
    public array $data = [];

    /** @var array Processed game logs */
    public array $games = [];

    /** @var int Player identifier */
    public int $player_id;

    /** @var string Season identifier */
    public string $season = NBABase::CURRENT_SEASON;

    /** @var string Season type */
    public string $season_type = NBABase::TYPE_REGULAR;

    /**
     * Fetch player game logs from the API.
     *
     * @return array Raw API response data
     * @throws NBAApiException When the API request fails
     */
    public function fetch(): array
    {
        if (!isset($this->player_id) || $this->player_id <= 0) {
            throw new \InvalidArgumentException('player_id must be set before calling fetch()');
        }

        $this->data = $this->ApiCall("https://stats.nba.com/stats/playergamelogs?DateFrom=&DateTo=&GameSegment=&LastNGames=0&LeagueID=00&Location=&MeasureType=Base&Month=0&OpponentTeamID=0&Outcome=&PORound=0&PaceAdjust=N&PerMode=Totals&Period=0&PlayerID={$this->player_id}&PlusMinus=N&Rank=N&Season={$this->season}&SeasonSegment=&SeasonType={$this->season_type}&ShotClockRange=&VsConference=&VsDivision=");

        if (isset($this->data['resultSets'][0]['rowSet'])) {
            foreach ($this->data['resultSets'][0]['rowSet'] as $g) {
                $this->games[] = [
                    'season' => $g[0] ?? '',
                    'player_id' => $g[1] ?? 0,
                    'player_name' => $g[3] ?? '',
                    'team_id' => $g[5] ?? 0,
                    'team_abbr' => $g[6] ?? '',
                    'game_id' => $g[8] ?? '',
                    'game_date' => $g[9] ?? '',
                    'matchup' => $g[10] ?? '',
                    'wl' => $g[11] ?? '',
                    'min' => $g[12] ?? 0,
                    'fgm' => $g[13] ?? 0,
                    'fga' => $g[14] ?? 0,
                    'fg_pct' => $g[15] ?? 0,
                    'fg3m' => $g[16] ?? 0,
                    'fg3a' => $g[17] ?? 0,
                    'fg3_pct' => $g[18] ?? 0,
                    'ftm' => $g[19] ?? 0,
                    'fta' => $g[20] ?? 0,
                    'ft_pct' => $g[21] ?? 0,
                    'oreb' => $g[22] ?? 0,
                    'dreb' => $g[23] ?? 0,
                    'reb' => $g[24] ?? 0,
                    'ast' => $g[25] ?? 0,
                    'tov' => $g[26] ?? 0,
                    'stl' => $g[27] ?? 0,
                    'blk' => $g[28] ?? 0,
                    'pf' => $g[30] ?? 0,
                    'pts' => $g[31] ?? 0,
                    'plus_minus' => $g[32] ?? 0,
                ];
            }
        }

        return $this->data;
    }

    /**
     * Get the last X games from the game log.
     *
     * @param int $count Number of games to return
     * @return array Last X games
     */
    public function lastXGames(int $count = 10): array
    {
        return array_slice($this->games, 0, $count);
    }
}
