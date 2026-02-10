<?php

namespace Corbpie\NBALive;

use DateTime;
use DateTimeZone;

/**
 * Retrieve NBA game schedule data.
 */
class NBASchedule extends NBABase
{
    /** @var array Processed schedule data */
    public array $schedule = [];

    /**
     * Fetch schedule for a specific date.
     *
     * @param string $date Date in Y-m-d format (e.g., '2023-12-20')
     * @throws NBAApiException When the API request fails
     */
    public function __construct(string $date = '2023-12-20')
    {
        $games = $this->ApiCall("https://stats.nba.com/stats/scoreboardv2?DayOffset=0&GameDate={$date}&LeagueID=00");

        $this->process($games);
    }

    /**
     * Get full season schedule for a specific team.
     *
     * @param int $team_id Team identifier
     * @return array Array of games for the team
     * @throws NBAApiException When the API request fails
     */
    public function fullForTeam(int $team_id): array
    {
        $games = $this->ApiCall("https://cdn.nba.com/static/json/staticData/scheduleLeagueV2.json");

        $data = $games['leagueSchedule']['gameDates'] ?? [];
        $result = [];
        $totalDays = count($data);

        for ($i = 0; $i < $totalDays; $i++) {
            if (!isset($data[$i]['games'])) {
                continue;
            }

            foreach ($data[$i]['games'] as $game) {
                $homeTeamId = $game['homeTeam']['teamId'] ?? 0;
                $awayTeamId = $game['awayTeam']['teamId'] ?? 0;

                if ($homeTeamId === $team_id || $awayTeamId === $team_id) {
                    $result[] = [
                        'game_id' => $game['gameId'] ?? '',
                        'game_code' => $game['gameCode'] ?? '',
                        'game_status' => $game['gameStatus'] ?? 0,
                        'game_sequence' => $game['gameSequence'] ?? 0,
                        'game_datetime_est' => $game['gameTimeEst'] ?? '',
                        'game_datetime_utc' => $game['gameDateTimeUTC'] ?? '',
                        'game_datetime_home' => $game['homeTeamTime'] ?? '',
                        'game_datetime_away' => $game['awayTeamTime'] ?? '',
                        'day' => $game['day'] ?? '',
                        'week_number' => $game['weekNumber'] ?? 0,
                        'home_tid' => $homeTeamId,
                        'home_name' => $game['homeTeam']['teamName'] ?? '',
                        'home_city' => $game['homeTeam']['teamCity'] ?? '',
                        'home_short' => $game['homeTeam']['teamTricode'] ?? '',
                        'home_wins' => $game['homeTeam']['wins'] ?? 0,
                        'home_losses' => $game['homeTeam']['losses'] ?? 0,
                        'away_tid' => $awayTeamId,
                        'away_name' => $game['awayTeam']['teamName'] ?? '',
                        'away_city' => $game['awayTeam']['teamCity'] ?? '',
                        'away_short' => $game['awayTeam']['teamTricode'] ?? '',
                        'away_wins' => $game['awayTeam']['wins'] ?? 0,
                        'away_loses' => $game['awayTeam']['losses'] ?? 0,
                        'arena_name' => $game['arenaName'] ?? '',
                        'arena_state' => $game['arenaState'] ?? '',
                        'arena_city' => $game['arenaCity'] ?? '',
                        'time_until_game' => $this->getTimeAway($game['gameDateTimeEst'] ?? '')
                    ];
                }
            }
        }

        return $result;
    }


    /**
     * Calculate time remaining until a game starts.
     *
     * @param string $dateString Game datetime string
     * @return string|null Formatted time remaining or null if game has passed
     */
    private function getTimeAway(string $dateString): ?string
    {
        if (empty($dateString)) {
            return null;
        }

        $now = new DateTime();
        $date = new DateTime($dateString);

        if ($date < $now) {
            return null;
        }

        $interval = $now->diff($date);

        $months = $interval->y * 12 + $interval->m;
        $weeks = floor($interval->d / 7);
        $days = $interval->d % 7;
        $hours = $interval->h;
        $minutes = $interval->i;

        $result = [];
        if ($months > 0) {
            $result[] = $months . " Month" . ($months > 1 ? "s" : "");
        }
        if ($weeks > 0) {
            $result[] = $weeks . " Week" . ($weeks > 1 ? "s" : "");
        }
        if ($days > 0 && count($result) < 2) {
            $result[] = $days . " Day" . ($days > 1 ? "s" : "");
        }
        if ($hours > 0 && count($result) < 2) {
            $result[] = $hours . " Hour" . ($hours > 1 ? "s" : "");
        }
        if ($minutes > 0 && count($result) < 2) {
            $result[] = $minutes . " Minute" . ($minutes > 1 ? "s" : "");
        }

        return implode(" ", array_slice($result, 0, 2));
    }

    /**
     * Process raw schedule data into formatted array.
     *
     * @param array $data Raw API response data
     * @param int|null $team_id Optional team ID to filter results
     * @return array Processed schedule data
     */
    public function process(array $data, ?int $team_id = null): array
    {
        // BUG FIX: Changed from $this->data to $data parameter
        if (isset($data['resultSets'][0]['rowSet'][0])) {
            foreach ($data['resultSets'][0]['rowSet'] as $game) {
                $timeFormatted = DateTime::createFromFormat('g:i a', str_replace(" ET", "", $game[4]));
                $timeString = $timeFormatted ? $timeFormatted->format('H:i:s') : '00:00:00';

                $dateTime = str_replace("T00:00:00", " $timeString", $game[0]);

                if ($team_id === null || ($team_id === $game[6] || $team_id === $game[7])) {
                    $this->schedule[] = [
                        'game_id' => $game[2],
                        'game_sequence' => $game[1],
                        'game_status' => $game[3],
                        'game_status_text' => $game[4],
                        'game_code' => $game[5],
                        'home_tid' => $game[6],
                        'away_tid' => $game[7],
                        'arena' => $game[15] ?? '',
                        'live_period' => ($game[9] === 0) ? null : $game[9],
                        'date_time_et' => $dateTime,
                        'date_time_utc' => (new DateTime($dateTime, new DateTimeZone('America/New_York')))->setTimezone(new DateTimeZone('UTC'))->format('Y-m-d H:i:s')
                    ];
                }
            }
        }

        return $this->schedule;
    }

    /**
     * Get schedule filtered by team.
     *
     * @param int $team_tid Team identifier
     * @return array Filtered schedule data
     * @deprecated Use process() with team_id parameter instead
     */
    public function forTeam(int $team_tid = 1610612746): array
    {
        return $this->schedule;
    }

    /**
     * Get upcoming games for a team within a specified number of days.
     *
     * @param int $team_id Team identifier
     * @param int $days_ahead Number of days to look ahead (default: 7)
     * @return array Upcoming games for the team
     * @throws NBAApiException When the API request fails
     */
    public function upcomingGames(int $team_id = 1610612746, int $days_ahead = 7): array
    {
        $current_date = strtotime('today');

        $this->schedule = [];

        for ($i = 0; $i < $days_ahead; $i++) {
            $dayTimestamp = strtotime("+$i day", $current_date);
            $formatted_date = date('Y-m-d', $dayTimestamp);

            $games = $this->ApiCall("https://stats.nba.com/stats/scoreboardv2?DayOffset=0&GameDate={$formatted_date}&LeagueID=00");

            $this->process($games, $team_id);
        }

        return $this->schedule;
    }
}
