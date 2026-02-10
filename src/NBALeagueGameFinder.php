<?php

namespace Corbpie\NBALive;

/**
 * Search for games by various criteria.
 */
class NBALeagueGameFinder extends NBABase
{
    /** @var array Raw API response data */
    public array $data = [];

    /** @var array Matching games */
    public array $games = [];

    /** @var string Season identifier */
    public string $season = NBABase::CURRENT_SEASON;

    /** @var string Season type */
    public string $season_type = NBABase::TYPE_REGULAR;

    /** @var int|null Team ID filter */
    public ?int $team_id = null;

    /** @var int|null Player ID filter */
    public ?int $player_id = null;

    /** @var string|null Date from filter (YYYY-MM-DD) */
    public ?string $date_from = null;

    /** @var string|null Date to filter (YYYY-MM-DD) */
    public ?string $date_to = null;

    /** @var string|null Outcome filter (W or L) */
    public ?string $outcome = null;

    /**
     * Fetch games matching criteria.
     *
     * @return array Raw API response data
     * @throws NBAApiException When the API request fails
     */
    public function fetch(): array
    {
        $teamFilter = $this->team_id ? "&TeamID={$this->team_id}" : "&TeamID=";
        $playerFilter = $this->player_id ? "&PlayerID={$this->player_id}" : "&PlayerID=";
        $dateFromFilter = $this->date_from ?? '';
        $dateToFilter = $this->date_to ?? '';
        $outcomeFilter = $this->outcome ?? '';

        $this->data = $this->ApiCall("https://stats.nba.com/stats/leaguegamefinder?Conference=&DateFrom={$dateFromFilter}&DateTo={$dateToFilter}&Division=&DraftNumber=&DraftRound=&DraftYear=&EqAST=&EqBLK=&EqDD=&EqDREB=&EqFG3A=&EqFG3M=&EqFG3_PCT=&EqFGA=&EqFGM=&EqFG_PCT=&EqFTA=&EqFTM=&EqFT_PCT=&EqMINUTES=&EqOREB=&EqPF=&EqPTS=&EqREB=&EqSTL=&EqTD=&EqTOV=&GameID=&GtAST=&GtBLK=&GtDD=&GtDREB=&GtFG3A=&GtFG3M=&GtFG3_PCT=&GtFGA=&GtFGM=&GtFG_PCT=&GtFTA=&GtFTM=&GtFT_PCT=&GtMINUTES=&GtOREB=&GtPF=&GtPTS=&GtREB=&GtSTL=&GtTD=&GtTOV=&LeagueID=00&Location=&LtAST=&LtBLK=&LtDD=&LtDREB=&LtFG3A=&LtFG3M=&LtFG3_PCT=&LtFGA=&LtFGM=&LtFG_PCT=&LtFTA=&LtFTM=&LtFT_PCT=&LtMINUTES=&LtOREB=&LtPF=&LtPTS=&LtREB=&LtSTL=&LtTD=&LtTOV=&Outcome={$outcomeFilter}{$playerFilter}&PlayerOrTeam=T&RookieYear=&Season={$this->season}&SeasonSegment=&SeasonType={$this->season_type}{$teamFilter}&VsConference=&VsDivision=&VsTeamID=");

        if (isset($this->data['resultSets'][0]['rowSet'])) {
            foreach ($this->data['resultSets'][0]['rowSet'] as $g) {
                $this->games[] = [
                    'season_id' => $g[0] ?? '',
                    'team_id' => $g[1] ?? 0,
                    'team_abbr' => $g[2] ?? '',
                    'team_name' => $g[3] ?? '',
                    'game_id' => $g[4] ?? '',
                    'game_date' => $g[5] ?? '',
                    'matchup' => $g[6] ?? '',
                    'wl' => $g[7] ?? '',
                    'min' => $g[8] ?? 0,
                    'pts' => $g[9] ?? 0,
                    'fgm' => $g[10] ?? 0,
                    'fga' => $g[11] ?? 0,
                    'fg_pct' => $g[12] ?? 0,
                    'fg3m' => $g[13] ?? 0,
                    'fg3a' => $g[14] ?? 0,
                    'fg3_pct' => $g[15] ?? 0,
                    'ftm' => $g[16] ?? 0,
                    'fta' => $g[17] ?? 0,
                    'ft_pct' => $g[18] ?? 0,
                    'oreb' => $g[19] ?? 0,
                    'dreb' => $g[20] ?? 0,
                    'reb' => $g[21] ?? 0,
                    'ast' => $g[22] ?? 0,
                    'stl' => $g[23] ?? 0,
                    'blk' => $g[24] ?? 0,
                    'tov' => $g[25] ?? 0,
                    'pf' => $g[26] ?? 0,
                    'plus_minus' => $g[27] ?? 0,
                ];
            }
        }

        return $this->data;
    }

    /**
     * Get games with high scoring.
     *
     * @param int $min_pts Minimum points
     * @return array High scoring games
     */
    public function highScoringGames(int $min_pts = 120): array
    {
        return array_filter($this->games, fn($g) => ($g['pts'] ?? 0) >= $min_pts);
    }
}
