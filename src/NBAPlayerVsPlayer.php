<?php

namespace Corbpie\NBALive;

/**
 * Retrieve head-to-head matchup stats between two players.
 */
class NBAPlayerVsPlayer extends NBABase
{
    /** @var array Raw API response data */
    public array $data = [];

    /** @var array First player overall stats */
    public array $player1_overall = [];

    /** @var array Second player overall stats */
    public array $player2_overall = [];

    /** @var array First player on-court stats */
    public array $player1_on_court = [];

    /** @var array Second player on-court stats */
    public array $player2_on_court = [];

    /**
     * Fetch player vs player matchup data.
     *
     * @param int $player_id First player ID
     * @param int $vs_player_id Second player ID
     * @param string $season Season identifier
     * @param string $per_mode Stats mode
     * @throws NBAApiException When the API request fails
     */
    public function __construct(
        int $player_id = 0,
        int $vs_player_id = 0,
        string $season = self::CURRENT_SEASON,
        string $per_mode = self::MODE_PER_GAME
    ) {
        if ($player_id <= 0 || $vs_player_id <= 0) {
            return;
        }

        $this->data = $this->ApiCall("https://stats.nba.com/stats/playervsplayer?DateFrom=&DateTo=&GameSegment=&LastNGames=0&LeagueID=00&Location=&MeasureType=Base&Month=0&OpponentTeamID=0&Outcome=&PORound=0&PerMode={$per_mode}&Period=0&PlayerID={$player_id}&PlusMinus=N&Season={$season}&SeasonSegment=&SeasonType=Regular+Season&VsConference=&VsDivision=&VsPlayerID={$vs_player_id}");

        // Overall stats
        if (isset($this->data['resultSets'][0]['rowSet'][0])) {
            $this->player1_overall = $this->buildStats($this->data['resultSets'][0]['rowSet'][0]);
        }
        if (isset($this->data['resultSets'][1]['rowSet'][0])) {
            $this->player2_overall = $this->buildStats($this->data['resultSets'][1]['rowSet'][0]);
        }

        // On-court stats
        if (isset($this->data['resultSets'][2]['rowSet'][0])) {
            $this->player1_on_court = $this->buildStats($this->data['resultSets'][2]['rowSet'][0]);
        }
        if (isset($this->data['resultSets'][3]['rowSet'][0])) {
            $this->player2_on_court = $this->buildStats($this->data['resultSets'][3]['rowSet'][0]);
        }
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
            'player_id' => $row[0] ?? 0,
            'player_name' => $row[1] ?? '',
            'gp' => $row[3] ?? 0,
            'w' => $row[4] ?? 0,
            'l' => $row[5] ?? 0,
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
