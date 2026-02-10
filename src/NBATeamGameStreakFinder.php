<?php

namespace Corbpie\NBALive;

/**
 * Find winning/losing streaks for teams.
 */
class NBATeamGameStreakFinder extends NBABase
{
    /** @var array Raw API response data */
    public array $data = [];

    /** @var array Streak data */
    public array $streaks = [];

    /** @var int Team identifier */
    public int $team_id;

    /** @var string Season identifier */
    public string $season = NBABase::CURRENT_SEASON;

    /** @var string Season type */
    public string $season_type = NBABase::TYPE_REGULAR;

    /** @var int Minimum streak length */
    public int $min_games = 3;

    /** @var string Streak type (W or L) */
    public string $streak_type = 'W';

    /**
     * Fetch streak data.
     *
     * @return array Raw API response data
     * @throws NBAApiException When the API request fails
     */
    public function fetch(): array
    {
        if (!isset($this->team_id) || $this->team_id <= 0) {
            throw new \InvalidArgumentException('team_id must be set before calling fetch()');
        }

        $wStreak = $this->streak_type === 'W' ? $this->min_games : 0;
        $lStreak = $this->streak_type === 'L' ? $this->min_games : 0;

        $this->data = $this->ApiCall("https://stats.nba.com/stats/teamgamestreakfinder?ActiveStreaksOnly=&BtrOPPAST=&BtrOPPBLK=&BtrOPPDREB=&BtrOPPFG3A=&BtrOPPFG3M=&BtrOPPFG3_PCT=&BtrOPPFGA=&BtrOPPFGM=&BtrOPPFG_PCT=&BtrOPPFTA=&BtrOPPFTM=&BtrOPPFT_PCT=&BtrOPPOREB=&BtrOPPPF=&BtrOPPPTS=&BtrOPPREB=&BtrOPPSTL=&BtrOPPTOV=&Conference=&DateFrom=&DateTo=&Division=&EqAST=&EqBLK=&EqDD=&EqDREB=&EqFG3A=&EqFG3M=&EqFG3_PCT=&EqFGA=&EqFGM=&EqFG_PCT=&EqFTA=&EqFTM=&EqFT_PCT=&EqMINUTES=&EqOREB=&EqOPPAST=&EqOPPBLK=&EqOPPDREB=&EqOPPFG3A=&EqOPPFG3M=&EqOPPFG3_PCT=&EqOPPFGA=&EqOPPFGM=&EqOPPFG_PCT=&EqOPPFTA=&EqOPPFTM=&EqOPPFT_PCT=&EqOPPOREB=&EqOPPPF=&EqOPPPTS=&EqOPPREB=&EqOPPSTL=&EqOPPTOV=&EqPF=&EqPTS=&EqREB=&EqSTL=&EqTD=&EqTOV=&GameID=&GtAST=&GtBLK=&GtDD=&GtDREB=&GtFG3A=&GtFG3M=&GtFG3_PCT=&GtFGA=&GtFGM=&GtFG_PCT=&GtFTA=&GtFTM=&GtFT_PCT=&GtMINUTES=&GtOREB=&GtOPPAST=&GtOPPBLK=&GtOPPDREB=&GtOPPFG3A=&GtOPPFG3M=&GtOPPFG3_PCT=&GtOPPFGA=&GtOPPFGM=&GtOPPFG_PCT=&GtOPPFTA=&GtOPPFTM=&GtOPPFT_PCT=&GtOPPOREB=&GtOPPPF=&GtOPPPTS=&GtOPPREB=&GtOPPSTL=&GtOPPTOV=&GtPF=&GtPTS=&GtREB=&GtSTL=&GtTD=&GtTOV=&LeagueID=00&Location=&LStreak={$lStreak}&LtAST=&LtBLK=&LtDD=&LtDREB=&LtFG3A=&LtFG3M=&LtFG3_PCT=&LtFGA=&LtFGM=&LtFG_PCT=&LtFTA=&LtFTM=&LtFT_PCT=&LtMINUTES=&LtOREB=&LtOPPAST=&LtOPPBLK=&LtOPPDREB=&LtOPPFG3A=&LtOPPFG3M=&LtOPPFG3_PCT=&LtOPPFGA=&LtOPPFGM=&LtOPPFG_PCT=&LtOPPFTA=&LtOPPFTM=&LtOPPFT_PCT=&LtOPPOREB=&LtOPPPF=&LtOPPPTS=&LtOPPREB=&LtOPPSTL=&LtOPPTOV=&LtPF=&LtPTS=&LtREB=&LtSTL=&LtTD=&LtTOV=&MinGames={$this->min_games}&Outcome=&PORound=&Season={$this->season}&SeasonSegment=&SeasonType={$this->season_type}&TeamID={$this->team_id}&VsConference=&VsDivision=&VsTeamID=&WStreak={$wStreak}&WrsOPPAST=&WrsOPPBLK=&WrsOPPDREB=&WrsOPPFG3A=&WrsOPPFG3M=&WrsOPPFG3_PCT=&WrsOPPFGA=&WrsOPPFGM=&WrsOPPFG_PCT=&WrsOPPFTA=&WrsOPPFTM=&WrsOPPFT_PCT=&WrsOPPOREB=&WrsOPPPF=&WrsOPPPTS=&WrsOPPREB=&WrsOPPSTL=&WrsOPPTOV=");

        if (isset($this->data['resultSets'][0]['rowSet'])) {
            foreach ($this->data['resultSets'][0]['rowSet'] as $s) {
                $this->streaks[] = [
                    'team_id' => $s[1] ?? 0,
                    'team_abbr' => $s[2] ?? '',
                    'team_name' => $s[3] ?? '',
                    'season_id' => $s[4] ?? '',
                    'streak_length' => $s[5] ?? 0,
                    'start_date' => $s[6] ?? '',
                    'end_date' => $s[7] ?? '',
                    'active_streak' => ($s[8] ?? 0) === 1,
                ];
            }
        }

        return $this->data;
    }

    /**
     * Get longest streak.
     *
     * @return array|null Longest streak or null
     */
    public function longestStreak(): ?array
    {
        if (empty($this->streaks)) {
            return null;
        }
        usort($this->streaks, fn($a, $b) => ($b['streak_length'] ?? 0) <=> ($a['streak_length'] ?? 0));
        return $this->streaks[0];
    }
}
