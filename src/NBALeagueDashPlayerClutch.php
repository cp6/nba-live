<?php

namespace Corbpie\NBALive;

/**
 * Retrieve clutch time statistics for players league-wide.
 */
class NBALeagueDashPlayerClutch extends NBABase
{
    /** @var array Raw API response data */
    public array $data = [];

    /** @var array Player clutch stats */
    public array $players = [];

    /** @var string Season identifier */
    public string $season = NBABase::CURRENT_SEASON;

    /** @var string Per mode */
    public string $per_mode = NBABase::MODE_PER_GAME;

    /** @var string Season type */
    public string $season_type = NBABase::TYPE_REGULAR;

    /**
     * Fetch clutch time player stats.
     *
     * @return array Raw API response data
     * @throws NBAApiException When the API request fails
     */
    public function fetch(): array
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/leaguedashplayerclutch?ClutchTime=Last+5+Minutes&AheadBehind=Ahead+or+Behind&College=&Conference=&Country=&DateFrom=&DateTo=&Division=&DraftPick=&DraftYear=&GameScope=&GameSegment=&Height=&LastNGames=0&LeagueID=00&Location=&MeasureType=Base&Month=0&OpponentTeamID=0&Outcome=&PORound=0&PaceAdjust=N&PerMode={$this->per_mode}&Period=0&PlayerExperience=&PlayerPosition=&PlusMinus=N&PointDiff=5&Rank=N&Season={$this->season}&SeasonSegment=&SeasonType={$this->season_type}&ShotClockRange=&StarterBench=&TeamID=0&VsConference=&VsDivision=&Weight=");

        if (isset($this->data['resultSets'][0]['rowSet'])) {
            foreach ($this->data['resultSets'][0]['rowSet'] as $p) {
                $this->players[] = [
                    'player_id' => $p[0] ?? 0,
                    'player_name' => $p[1] ?? '',
                    'team_id' => $p[3] ?? 0,
                    'team_abbr' => $p[4] ?? '',
                    'age' => $p[5] ?? 0,
                    'gp' => $p[6] ?? 0,
                    'w' => $p[7] ?? 0,
                    'l' => $p[8] ?? 0,
                    'min' => $p[10] ?? 0,
                    'fgm' => $p[11] ?? 0,
                    'fga' => $p[12] ?? 0,
                    'fg_pct' => $p[13] ?? 0,
                    'fg3m' => $p[14] ?? 0,
                    'fg3a' => $p[15] ?? 0,
                    'fg3_pct' => $p[16] ?? 0,
                    'ftm' => $p[17] ?? 0,
                    'fta' => $p[18] ?? 0,
                    'ft_pct' => $p[19] ?? 0,
                    'oreb' => $p[20] ?? 0,
                    'dreb' => $p[21] ?? 0,
                    'reb' => $p[22] ?? 0,
                    'ast' => $p[23] ?? 0,
                    'tov' => $p[24] ?? 0,
                    'stl' => $p[25] ?? 0,
                    'blk' => $p[26] ?? 0,
                    'pf' => $p[28] ?? 0,
                    'pts' => $p[29] ?? 0,
                    'plus_minus' => $p[30] ?? 0,
                ];
            }
        }

        return $this->data;
    }

    /**
     * Get top clutch performers by stat.
     *
     * @param string $stat Stat key (pts, ast, reb, etc.)
     * @param int $limit Number of players to return
     * @return array Top performers
     */
    public function topPerformers(string $stat = 'pts', int $limit = 10): array
    {
        $sorted = $this->players;
        usort($sorted, fn($a, $b) => ($b[$stat] ?? 0) <=> ($a[$stat] ?? 0));
        return \array_slice($sorted, 0, $limit);
    }
}
