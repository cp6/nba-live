<?php

namespace Corbpie\NBALive;

/**
 * Retrieve comprehensive team dashboard statistics.
 */
class NBATeamDashboard extends NBABase
{
    /** @var array Raw API response data */
    public array $data = [];

    /** @var array Overall team stats */
    public array $overall = [];

    /** @var array Stats by location (home/away) */
    public array $by_location = [];

    /** @var array Stats by win/loss */
    public array $by_outcome = [];

    /** @var array Stats by month */
    public array $by_month = [];

    /** @var array Stats by pre/post all-star */
    public array $by_season_segment = [];

    /** @var int Team identifier */
    public int $team_id;

    /** @var string Season identifier */
    public string $season = NBABase::CURRENT_SEASON;

    /** @var string Per mode */
    public string $per_mode = NBABase::MODE_PER_GAME;

    /**
     * Fetch team dashboard data.
     *
     * @return array Raw API response data
     * @throws NBAApiException When the API request fails
     */
    public function fetch(): array
    {
        if (!isset($this->team_id) || $this->team_id <= 0) {
            throw new \InvalidArgumentException('team_id must be set before calling fetch()');
        }

        $this->data = $this->ApiCall("https://stats.nba.com/stats/teamdashboardbygeneralsplits?DateFrom=&DateTo=&GameSegment=&LastNGames=0&LeagueID=00&Location=&MeasureType=Base&Month=0&OpponentTeamID=0&Outcome=&PORound=0&PaceAdjust=N&PerMode={$this->per_mode}&Period=0&PlusMinus=N&Rank=N&Season={$this->season}&SeasonSegment=&SeasonType=Regular+Season&ShotClockRange=&TeamID={$this->team_id}&VsConference=&VsDivision=");

        // Overall stats
        if (isset($this->data['resultSets'][0]['rowSet'][0])) {
            $this->overall = $this->buildStats($this->data['resultSets'][0]['rowSet'][0]);
        }

        // By location
        if (isset($this->data['resultSets'][1]['rowSet'])) {
            foreach ($this->data['resultSets'][1]['rowSet'] as $row) {
                $this->by_location[] = $this->buildStats($row);
            }
        }

        // By outcome
        if (isset($this->data['resultSets'][2]['rowSet'])) {
            foreach ($this->data['resultSets'][2]['rowSet'] as $row) {
                $this->by_outcome[] = $this->buildStats($row);
            }
        }

        // By month
        if (isset($this->data['resultSets'][3]['rowSet'])) {
            foreach ($this->data['resultSets'][3]['rowSet'] as $row) {
                $this->by_month[] = $this->buildStats($row);
            }
        }

        // By season segment
        if (isset($this->data['resultSets'][4]['rowSet'])) {
            foreach ($this->data['resultSets'][4]['rowSet'] as $row) {
                $this->by_season_segment[] = $this->buildStats($row);
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
            'gp' => $row[3] ?? 0,
            'w' => $row[4] ?? 0,
            'l' => $row[5] ?? 0,
            'w_pct' => $row[6] ?? 0,
            'min' => $row[7] ?? 0,
            'fgm' => $row[8] ?? 0,
            'fga' => $row[9] ?? 0,
            'fg_pct' => $row[10] ?? 0,
            'fg3m' => $row[11] ?? 0,
            'fg3a' => $row[12] ?? 0,
            'fg3_pct' => $row[13] ?? 0,
            'ftm' => $row[14] ?? 0,
            'fta' => $row[15] ?? 0,
            'ft_pct' => $row[16] ?? 0,
            'oreb' => $row[17] ?? 0,
            'dreb' => $row[18] ?? 0,
            'reb' => $row[19] ?? 0,
            'ast' => $row[20] ?? 0,
            'tov' => $row[21] ?? 0,
            'stl' => $row[22] ?? 0,
            'blk' => $row[23] ?? 0,
            'pf' => $row[25] ?? 0,
            'pts' => $row[26] ?? 0,
            'plus_minus' => $row[27] ?? 0,
        ];
    }
}
