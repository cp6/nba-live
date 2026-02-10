<?php

namespace Corbpie\NBALive;

/**
 * Retrieve NBA game summary data including team stats, referees, and line scores.
 */
class NBAGameSummary extends NBABase
{
    // Result set indices
    private const RESULT_OTHER_STATS = 1;
    private const RESULT_OFFICIALS = 2;
    private const RESULT_INACTIVE = 3;
    private const RESULT_ATTENDANCE = 4;
    private const RESULT_LINE_SCORE = 5;
    private const RESULT_LAST_MEETING = 6;
    private const RESULT_STATUSES = 8;

    /** @var array Raw API response data */
    public array $data = [];

    /** @var array Home team summary stats */
    public array $home = [];

    /** @var array Away team summary stats */
    public array $away = [];

    /** @var array Game officials/referees */
    public array $refs = [];

    /** @var array Inactive players */
    public array $inactive = [];

    /** @var array Home team line score by quarter */
    public array $home_line_score = [];

    /** @var array Away team line score by quarter */
    public array $away_line_score = [];

    /** @var int Game attendance */
    public int $attendance = 0;

    /** @var array Last meeting between these teams */
    public array $last_meeting = [];

    /** @var array Various game status flags */
    public array $statuses = [];

    /**
     * Fetch game summary data.
     *
     * @param string $game_id NBA game identifier
     * @throws NBAApiException When the API request fails
     */
    public function __construct(string $game_id = '')
    {
        if (!isset($this->game_id)) {
            $this->game_id = $game_id;
        }

        $this->data = $this->ApiCall("https://stats.nba.com/stats/boxscoresummaryv2?GameID={$this->game_id}");

        $this->parseOtherStats();
        $this->parseOfficials();
        $this->parseInactivePlayers();
        $this->parseLineScores();
        $this->parseAttendance();
        $this->parseLastMeeting();
        $this->parseStatuses();
    }

    /**
     * Parse other stats (paint points, fast break, etc.) for both teams.
     */
    private function parseOtherStats(): void
    {
        $resultSet = $this->data['resultSets'][self::RESULT_OTHER_STATS]['rowSet'] ?? [];

        if (isset($resultSet[1])) {
            $this->home = $this->buildOtherStats($resultSet[1]);
        }

        if (isset($resultSet[0])) {
            $this->away = $this->buildOtherStats($resultSet[0]);
        }
    }

    /**
     * Build other stats array from raw data.
     *
     * @param array $row Raw row data
     * @return array Formatted stats
     */
    private function buildOtherStats(array $row): array
    {
        return [
            'team_id' => $row[1] ?? 0,
            'team_name_short' => $row[2] ?? '',
            'pts_paint' => $row[4] ?? 0,
            'pts_second_chance' => $row[5] ?? 0,
            'pts_fast_break' => $row[6] ?? 0,
            'largest_lead' => $row[7] ?? 0,
            'lead_changes' => $row[8] ?? 0,
            'times_tied' => $row[9] ?? 0,
            'team_turnovers' => $row[10] ?? 0,
            'total_turnovers' => $row[11] ?? 0,
            'team_rebounds' => $row[12] ?? 0,
            'pts_off_to' => $row[13] ?? 0
        ];
    }

    /**
     * Parse game officials data.
     */
    private function parseOfficials(): void
    {
        $resultSet = $this->data['resultSets'][self::RESULT_OFFICIALS]['rowSet'] ?? [];

        foreach ($resultSet as $refs) {
            $this->refs[] = [
                'ref_id' => $refs[0] ?? 0,
                'first_name' => $refs[1] ?? '',
                'last_name' => $refs[2] ?? '',
                'jersey_number' => (int)($refs[3] ?? 0)
            ];
        }
    }

    /**
     * Parse inactive players data.
     */
    private function parseInactivePlayers(): void
    {
        $resultSet = $this->data['resultSets'][self::RESULT_INACTIVE]['rowSet'] ?? [];

        foreach ($resultSet as $inactive) {
            $this->inactive[] = [
                'player_id' => $inactive[0] ?? 0,
                'first_name' => $inactive[1] ?? '',
                'last_name' => $inactive[2] ?? '',
                'jersey_number' => (int)($inactive[3] ?? 0),
                'team_id' => $inactive[4] ?? 0,
                'team_name_short' => $inactive[7] ?? ''
            ];
        }
    }

    /**
     * Parse line scores for both teams.
     */
    private function parseLineScores(): void
    {
        $resultSet = $this->data['resultSets'][self::RESULT_LINE_SCORE]['rowSet'] ?? [];

        if (isset($resultSet[0])) {
            $this->away_line_score = $this->buildLineScore($resultSet[0]);
        }

        if (isset($resultSet[1])) {
            $this->home_line_score = $this->buildLineScore($resultSet[1]);
        }
    }

    /**
     * Build line score array from raw data.
     *
     * @param array $row Raw row data
     * @return array Formatted line score
     */
    private function buildLineScore(array $row): array
    {
        return [
            'team_id' => $row[3] ?? 0,
            'game_id' => $row[2] ?? '',
            'team_name_short' => $row[4] ?? '',
            'pts_q1' => $row[8] ?? 0,
            'pts_q2' => $row[9] ?? 0,
            'pts_q3' => $row[10] ?? 0,
            'pts_q4' => $row[11] ?? 0,
            'pts_ot1' => $row[12] ?? 0,
            'pts_ot2' => $row[13] ?? 0,
            'pts_ot3' => $row[14] ?? 0,
            'pts_ot4' => $row[15] ?? 0,
            'pts_ot5' => $row[16] ?? 0,
            'pts_ot6' => $row[17] ?? 0,
            'pts' => $row[22] ?? 0
        ];
    }

    /**
     * Parse game attendance.
     */
    private function parseAttendance(): void
    {
        $this->attendance = $this->data['resultSets'][self::RESULT_ATTENDANCE]['rowSet'][0][1] ?? 0;
    }

    /**
     * Parse last meeting data between these teams.
     */
    private function parseLastMeeting(): void
    {
        $row = $this->data['resultSets'][self::RESULT_LAST_MEETING]['rowSet'][0] ?? null;

        if ($row) {
            $homePoints = $row[7] ?? 0;
            $awayPoints = $row[12] ?? 0;

            $this->last_meeting = [
                'game_id' => $row[1] ?? '',
                'date' => str_replace("T00:00:00", "", $row[2] ?? ''),
                'home_team_id' => $row[3] ?? 0,
                'home_team_name_short' => $row[6] ?? '',
                'home_points' => $homePoints,
                'away_team_id' => $row[8] ?? 0,
                'away_team_name_short' => $row[11] ?? '',
                'away_points' => $awayPoints,
                'winner' => ($homePoints > $awayPoints) ? ($row[3] ?? 0) : ($row[8] ?? 0)
            ];
        }
    }

    /**
     * Parse game status flags.
     */
    private function parseStatuses(): void
    {
        $row = $this->data['resultSets'][self::RESULT_STATUSES]['rowSet'][0] ?? null;

        if ($row) {
            $this->statuses = [
                'video_available' => ($row[1] ?? 0) === 1,
                'pt_available' => ($row[2] ?? 0) === 1,
                'pt_xyz_available' => ($row[3] ?? 0) === 1,
                'wh_status' => ($row[4] ?? 0) === 1,
                'hustle_status' => ($row[5] ?? 0) === 1,
                'historical_status' => ($row[6] ?? 0) === 1
            ];
        }
    }
}
