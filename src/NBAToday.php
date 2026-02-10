<?php

namespace Corbpie\NBALive;

use DateInterval;
use DateTime;
use DateTimeZone;

/**
 * Retrieve today's NBA games including live, upcoming, and completed games.
 */
class NBAToday extends NBABase
{
    /** @var array Summary of today's games */
    public array $summary = [];

    /** @var array All games today */
    public array $all_games = [];

    /** @var array Games that haven't started yet */
    public array $upcoming_games = [];

    /** @var array Games currently in progress */
    public array $live_games = [];

    /** @var array Games that have finished */
    public array $completed_games = [];

    /**
     * Fetch today's games from the NBA API.
     *
     * @throws NBAApiException When the API request fails
     */
    public function __construct()
    {
        $games = $this->ApiCall("https://cdn.nba.com/static/json/liveData/scoreboard/todaysScoreboard_00.json");

        $live = $completed = $upcoming = 0;

        $this->all_games = $games['scoreboard']['games'] ?? [];

        if (isset($games['scoreboard'])) {
            foreach ($this->all_games as $game) {
                $status = $game['gameStatus'] ?? 0;
                if ($status === self::GAME_STATUS_IN_PROGRESS) {
                    $this->live_games[] = $game;
                    $live++;
                } elseif ($status === self::GAME_STATUS_COMPLETED) {
                    $this->completed_games[] = $game;
                    $completed++;
                } else {
                    $this->upcoming_games[] = $game;
                    $upcoming++;
                }
            }
        }

        $this->summary = [
            'date' => $games['scoreboard']['gameDate'] ?? '',
            'all_games' => $live + $completed + $upcoming,
            'live_games' => $live,
            'completed_games' => $completed,
            'upcoming_games' => $upcoming,
        ];
    }

    /**
     * Format raw game data into a more usable structure.
     *
     * @param array $games Array of raw game data
     * @return array Formatted game data
     */
    public function gameFormatter(array $games): array
    {
        $formatted = [];

        foreach ($games as $game) {
            $gameClock = $game['gameClock'] ?? '';
            $formatted_time_left = null;

            if (!empty($gameClock)) {
                $clockPart = strstr($gameClock, '.', true);
                if ($clockPart) {
                    $interval = new DateInterval($clockPart . "S");
                    $formatted_time_left = sprintf('%02d:%02d', $interval->i, $interval->s);
                }
            }

            $homeScore = $game['homeTeam']['score'] ?? 0;
            $awayScore = $game['awayTeam']['score'] ?? 0;
            $margin = abs($homeScore - $awayScore);
            $gameStatus = $game['gameStatus'] ?? 0;

            $seconds_left = 0;
            if ($formatted_time_left !== null) {
                $timeParts = explode(':', $formatted_time_left);
                $seconds_left = ($timeParts[0] ?? 0) * 60 + ($timeParts[1] ?? 0);
            }

            $isNotStarted = $gameStatus === self::GAME_STATUS_NOT_STARTED;

            $formatted[] = [
                'status' => $gameStatus,
                'starting_in' => $isNotStarted ? $this->startingIn($game['gameTimeUTC'] ?? '') : null,
                'game_id' => $game['gameId'] ?? '',
                'game_code' => $game['gameCode'] ?? '',
                'margin' => $isNotStarted ? null : $margin,
                'home_score' => $isNotStarted ? null : $homeScore,
                'away_score' => $isNotStarted ? null : $awayScore,
                'time_left_string' => $isNotStarted ? null : ($game['gameStatusText'] ?? ''),
                'time_left' => $isNotStarted ? null : $formatted_time_left,
                'seconds_left' => $seconds_left,
                'period' => $isNotStarted ? null : ($game['period'] ?? 0),
                'home_team' => $this->formatTeamData($game['homeTeam'] ?? [], $isNotStarted),
                'away_team' => $this->formatTeamData($game['awayTeam'] ?? [], $isNotStarted),
                'periods' => $isNotStarted ? [] : $this->formatPeriods($game),
                'game_series' => $game['seriesText'] ?? '',
                'game_type' => $game['gameSubtype'] ?? '',
                'game_sub_label' => $game['gameSubLabel'] ?? '',
                'game_time_utc' => isset($game['gameTimeUTC']) ? (new DateTime($game['gameTimeUTC']))->format('Y-m-d H:i:s') : '',
                'game_time_et' => isset($game['gameEt']) ? (new DateTime($game['gameEt']))->format('Y-m-d H:i:s') : ''
            ];
        }

        return $formatted;
    }

    /**
     * Format team data for output.
     *
     * @param array $team Raw team data
     * @param bool $isNotStarted Whether the game has started
     * @return array Formatted team data
     */
    private function formatTeamData(array $team, bool $isNotStarted): array
    {
        $inBonus = $team['inBonus'] ?? null;

        return [
            'id' => $team['teamId'] ?? 0,
            'name' => $team['teamName'] ?? '',
            'short' => $team['teamTricode'] ?? '',
            'in_bonus' => !($inBonus === '0' || $inBonus === null),
            'timeouts_remaining' => $isNotStarted ? null : ($team['timeoutsRemaining'] ?? 0),
            'wins' => $team['wins'] ?? 0,
            'losses' => $team['losses'] ?? 0,
            'seed' => $team['seed'] ?? 0
        ];
    }

    /**
     * Format period scores for output.
     *
     * @param array $game Raw game data
     * @return array Formatted period data
     */
    private function formatPeriods(array $game): array
    {
        $periodNames = ['one', 'two', 'three', 'four', 'five', 'six', 'seven'];
        $periods = [];

        foreach ($periodNames as $index => $name) {
            $periods[$name] = [[
                'home_score' => $game['homeTeam']['periods'][$index]['score'] ?? null,
                'away_score' => $game['awayTeam']['periods'][$index]['score'] ?? null,
            ]];
        }

        return $periods;
    }

    /**
     * Calculate time until game starts.
     *
     * @param string $utc_datetime Game start time in UTC
     * @return string|null Formatted time remaining or null if game has started
     */
    public function startingIn(string $utc_datetime): ?string
    {
        if (empty($utc_datetime)) {
            return null;
        }

        $utc_datetime = new DateTime($utc_datetime, new DateTimeZone('UTC'));
        $current_time = new DateTime('now', new DateTimeZone('UTC'));

        if ($current_time >= $utc_datetime) {
            return null;
        }

        return $current_time->diff($utc_datetime)->format('%H:%I');
    }
}
