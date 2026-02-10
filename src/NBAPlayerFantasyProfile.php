<?php

namespace Corbpie\NBALive;

/**
 * Retrieve fantasy basketball profile for a player.
 */
class NBAPlayerFantasyProfile extends NBABase
{
    /** @var array Raw API response data */
    public array $data = [];

    /** @var array Overall fantasy stats */
    public array $overall = [];

    /** @var array Fantasy stats by last N games */
    public array $last_n_games = [];

    /** @var array Fantasy stats by opponent */
    public array $by_opponent = [];

    /** @var int Player identifier */
    public int $player_id;

    /** @var string Season identifier */
    public string $season = NBABase::CURRENT_SEASON;

    /**
     * Fetch fantasy profile data.
     *
     * @return array Raw API response data
     * @throws NBAApiException When the API request fails
     */
    public function fetch(): array
    {
        if (!isset($this->player_id) || $this->player_id <= 0) {
            throw new \InvalidArgumentException('player_id must be set before calling fetch()');
        }

        $this->data = $this->ApiCall("https://stats.nba.com/stats/playerfantasyprofile?LeagueID=00&MeasureType=Base&PaceAdjust=N&PerMode=PerGame&PlusMinus=N&PlayerID={$this->player_id}&Rank=N&Season={$this->season}&SeasonType=Regular+Season");

        // Overall stats
        if (isset($this->data['resultSets'][0]['rowSet'][0])) {
            $this->overall = $this->buildStats($this->data['resultSets'][0]['rowSet'][0]);
        }

        // Last N games
        if (isset($this->data['resultSets'][1]['rowSet'])) {
            foreach ($this->data['resultSets'][1]['rowSet'] as $row) {
                $this->last_n_games[] = $this->buildStats($row);
            }
        }

        // By opponent
        if (isset($this->data['resultSets'][2]['rowSet'])) {
            foreach ($this->data['resultSets'][2]['rowSet'] as $row) {
                $this->by_opponent[] = $this->buildOpponentStats($row);
            }
        }

        return $this->data;
    }

    /**
     * Build stats array from raw data.
     *
     * @param array $row Raw row data
     * @return array Formatted stats
     */
    private function buildStats(array $row): array
    {
        return [
            'group_set' => $row[0] ?? '',
            'group_value' => $row[1] ?? '',
            'gp' => $row[2] ?? 0,
            'w' => $row[3] ?? 0,
            'l' => $row[4] ?? 0,
            'min' => $row[6] ?? 0,
            'fgm' => $row[7] ?? 0,
            'fga' => $row[8] ?? 0,
            'fg_pct' => $row[9] ?? 0,
            'fg3m' => $row[10] ?? 0,
            'fg3a' => $row[11] ?? 0,
            'fg3_pct' => $row[12] ?? 0,
            'ftm' => $row[13] ?? 0,
            'fta' => $row[14] ?? 0,
            'ft_pct' => $row[15] ?? 0,
            'oreb' => $row[16] ?? 0,
            'dreb' => $row[17] ?? 0,
            'reb' => $row[18] ?? 0,
            'ast' => $row[19] ?? 0,
            'tov' => $row[20] ?? 0,
            'stl' => $row[21] ?? 0,
            'blk' => $row[22] ?? 0,
            'pf' => $row[24] ?? 0,
            'pts' => $row[25] ?? 0,
            'fan_duel_pts' => $row[26] ?? 0,
            'nba_fantasy_pts' => $row[27] ?? 0,
        ];
    }

    /**
     * Build opponent stats array from raw data.
     *
     * @param array $row Raw row data
     * @return array Formatted stats
     */
    private function buildOpponentStats(array $row): array
    {
        return [
            'vs_team_id' => $row[0] ?? 0,
            'vs_team_city' => $row[1] ?? '',
            'vs_team_name' => $row[2] ?? '',
            'vs_team_abbr' => $row[3] ?? '',
            'gp' => $row[4] ?? 0,
            'w' => $row[5] ?? 0,
            'l' => $row[6] ?? 0,
            'min' => $row[8] ?? 0,
            'pts' => $row[27] ?? 0,
            'fan_duel_pts' => $row[28] ?? 0,
            'nba_fantasy_pts' => $row[29] ?? 0,
        ];
    }
}
