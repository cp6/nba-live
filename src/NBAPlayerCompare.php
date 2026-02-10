<?php

namespace Corbpie\NBALive;

/**
 * Compare two players head-to-head statistics.
 */
class NBAPlayerCompare extends NBABase
{
    /** @var array Raw API response data */
    public array $data = [];

    /** @var array First player stats */
    public array $player1 = [];

    /** @var array Second player stats */
    public array $player2 = [];

    /** @var array Overall comparison */
    public array $overall = [];

    /**
     * Compare two players.
     *
     * @param int $player_id_1 First player ID
     * @param int $player_id_2 Second player ID
     * @param string $season Season identifier
     * @param string $per_mode Stats mode (Totals, PerGame, Per36, etc.)
     * @throws NBAApiException When the API request fails
     */
    public function __construct(
        int $player_id_1 = 0,
        int $player_id_2 = 0,
        string $season = self::CURRENT_SEASON,
        string $per_mode = self::MODE_PER_GAME
    ) {
        if ($player_id_1 <= 0 || $player_id_2 <= 0) {
            return;
        }

        $this->data = $this->ApiCall("https://stats.nba.com/stats/playercompare?Conference=&DateFrom=&DateTo=&Division=&GameSegment=&LastNGames=0&LeagueID=00&Location=&MeasureType=Base&Month=0&OpponentTeamID=0&Outcome=&PORound=0&PaceAdjust=N&PerMode={$per_mode}&Period=0&PlayerIDList={$player_id_1},{$player_id_2}&PlusMinus=N&Rank=N&Season={$season}&SeasonSegment=&SeasonType=Regular+Season&ShotClockRange=&VsConference=&VsDivision=");

        if (isset($this->data['resultSets'][0]['rowSet'][0])) {
            $p1 = $this->data['resultSets'][0]['rowSet'][0];
            $this->player1 = $this->buildPlayerStats($p1);
        }

        if (isset($this->data['resultSets'][0]['rowSet'][1])) {
            $p2 = $this->data['resultSets'][0]['rowSet'][1];
            $this->player2 = $this->buildPlayerStats($p2);
        }

        if (isset($this->data['resultSets'][1]['rowSet'][0])) {
            $o = $this->data['resultSets'][1]['rowSet'][0];
            $this->overall = [
                'gp' => $o[3] ?? 0,
                'w' => $o[4] ?? 0,
                'l' => $o[5] ?? 0,
                'w_pct' => $o[6] ?? 0,
                'min' => $o[7] ?? 0,
                'pts' => $o[26] ?? 0,
            ];
        }
    }

    /**
     * Build player stats array from raw data.
     *
     * @param array $p Raw player data
     * @return array Formatted player stats
     */
    private function buildPlayerStats(array $p): array
    {
        return [
            'player_id' => $p[0] ?? 0,
            'player_name' => $p[1] ?? '',
            'gp' => $p[3] ?? 0,
            'w' => $p[4] ?? 0,
            'l' => $p[5] ?? 0,
            'w_pct' => $p[6] ?? 0,
            'min' => $p[7] ?? 0,
            'fgm' => $p[8] ?? 0,
            'fga' => $p[9] ?? 0,
            'fg_pct' => $p[10] ?? 0,
            'fg3m' => $p[11] ?? 0,
            'fg3a' => $p[12] ?? 0,
            'fg3_pct' => $p[13] ?? 0,
            'ftm' => $p[14] ?? 0,
            'fta' => $p[15] ?? 0,
            'ft_pct' => $p[16] ?? 0,
            'oreb' => $p[17] ?? 0,
            'dreb' => $p[18] ?? 0,
            'reb' => $p[19] ?? 0,
            'ast' => $p[20] ?? 0,
            'tov' => $p[21] ?? 0,
            'stl' => $p[22] ?? 0,
            'blk' => $p[23] ?? 0,
            'blka' => $p[24] ?? 0,
            'pf' => $p[25] ?? 0,
            'pts' => $p[26] ?? 0,
            'plus_minus' => $p[27] ?? 0,
        ];
    }
}
