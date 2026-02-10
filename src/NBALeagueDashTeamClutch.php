<?php

namespace Corbpie\NBALive;

/**
 * Retrieve clutch time statistics for teams league-wide.
 */
class NBALeagueDashTeamClutch extends NBABase
{
    /** @var array Raw API response data */
    public array $data = [];

    /** @var array Team clutch stats */
    public array $teams = [];

    /** @var string Season identifier */
    public string $season = NBABase::CURRENT_SEASON;

    /** @var string Per mode */
    public string $per_mode = NBABase::MODE_PER_GAME;

    /** @var string Season type */
    public string $season_type = NBABase::TYPE_REGULAR;

    /**
     * Fetch clutch time team stats.
     *
     * @return array Raw API response data
     * @throws NBAApiException When the API request fails
     */
    public function fetch(): array
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/leaguedashteamclutch?ClutchTime=Last+5+Minutes&AheadBehind=Ahead+or+Behind&Conference=&DateFrom=&DateTo=&Division=&GameScope=&GameSegment=&LastNGames=0&LeagueID=00&Location=&MeasureType=Base&Month=0&OpponentTeamID=0&Outcome=&PORound=0&PaceAdjust=N&PerMode={$this->per_mode}&Period=0&PlusMinus=N&PointDiff=5&Rank=N&Season={$this->season}&SeasonSegment=&SeasonType={$this->season_type}&ShotClockRange=&TeamID=0&VsConference=&VsDivision=");

        if (isset($this->data['resultSets'][0]['rowSet'])) {
            foreach ($this->data['resultSets'][0]['rowSet'] as $t) {
                $this->teams[] = [
                    'team_id' => $t[0] ?? 0,
                    'team_name' => $t[1] ?? '',
                    'gp' => $t[2] ?? 0,
                    'w' => $t[3] ?? 0,
                    'l' => $t[4] ?? 0,
                    'w_pct' => $t[5] ?? 0,
                    'min' => $t[6] ?? 0,
                    'fgm' => $t[7] ?? 0,
                    'fga' => $t[8] ?? 0,
                    'fg_pct' => $t[9] ?? 0,
                    'fg3m' => $t[10] ?? 0,
                    'fg3a' => $t[11] ?? 0,
                    'fg3_pct' => $t[12] ?? 0,
                    'ftm' => $t[13] ?? 0,
                    'fta' => $t[14] ?? 0,
                    'ft_pct' => $t[15] ?? 0,
                    'oreb' => $t[16] ?? 0,
                    'dreb' => $t[17] ?? 0,
                    'reb' => $t[18] ?? 0,
                    'ast' => $t[19] ?? 0,
                    'tov' => $t[20] ?? 0,
                    'stl' => $t[21] ?? 0,
                    'blk' => $t[22] ?? 0,
                    'pf' => $t[24] ?? 0,
                    'pts' => $t[25] ?? 0,
                    'plus_minus' => $t[26] ?? 0,
                ];
            }
        }

        return $this->data;
    }

    /**
     * Get best clutch teams by win percentage.
     *
     * @param int $limit Number of teams to return
     * @return array Top clutch teams
     */
    public function bestClutchTeams(int $limit = 10): array
    {
        $sorted = $this->teams;
        usort($sorted, fn($a, $b) => ($b['w_pct'] ?? 0) <=> ($a['w_pct'] ?? 0));
        return \array_slice($sorted, 0, $limit);
    }
}
