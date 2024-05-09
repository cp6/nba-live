<?php

namespace Corbpie\NBALive;

use DateInterval;
use DateTime;
use DateTimeZone;

class NBAToday extends NBABase
{
    public array $summary = [];

    public array $all_games = [];

    public array $upcoming_games = [];

    public array $live_games = [];

    public array $completed_games = [];

    public function __construct()
    {
        $games = $this->ApiCall("https://cdn.nba.com/static/json/liveData/scoreboard/todaysScoreboard_00.json");

        $live = $completed = $upcoming = 0;

        $this->all_games = $games['scoreboard']['games'];

        if (isset($games['scoreboard'])) {
            foreach ($this->all_games as $game) {
                if ($game['gameStatus'] === 2) {
                    $this->live_games[] = $game;
                    $live++;
                } elseif ($game['gameStatus'] === 3) {
                    $this->completed_games[] = $game;
                    $completed++;
                } else {
                    $this->upcoming_games[] = $game;
                    $upcoming++;
                }
            }
        }

        $this->summary = [
            'date' => $games['scoreboard']['gameDate'],
            'all_games' => $live + $completed + $upcoming,
            'live_games' => $live,
            'completed_games' => $completed,
            'upcoming_games' => $upcoming,
        ];
    }


    public function gameFormatter(array $games): array
    {
        $formatted = [];

        foreach ($games as $game) {
            $formatted_time_left = ($game['gameClock'] === '') ? null : sprintf('%02d:%02d', (new DateInterval(strstr($game['gameClock'], '.', true) . "S"))->i, (new DateInterval(strstr($game['gameClock'], '.', true) . "S"))->s);

            if ($game['homeTeam']['score'] > $game['awayTeam']['score']) {
                $margin = $game['homeTeam']['score'] - $game['awayTeam']['score'];
            } else {
                $margin = $game['awayTeam']['score'] - $game['homeTeam']['score'];
            }

            if (is_null($formatted_time_left)) {
                $seconds_left = 0;
            } else {
                $seconds_left = array_sum(array_map(function ($v, $i) {
                    return ($i === 0) ? $v * 60 : $v;
                }, explode(':', $formatted_time_left), range(0, 1)));
            }

            $formatted[] = [
                'status' => $game['gameStatus'],
                'starting_in' => ($game['gameStatus'] === 1) ? $this->startingIn($game['gameTimeUTC']) : null,
                'game_id' => $game['gameId'],
                'game_code' => $game['gameCode'],
                'margin' => ($game['gameStatus'] === 1) ? null : $margin,
                'home_score' => ($game['gameStatus'] === 1) ? null : $game['homeTeam']['score'],
                'away_score' => ($game['gameStatus'] === 1) ? null : $game['awayTeam']['score'],
                'time_left_string' => ($game['gameStatus'] === 1) ? null : $game['gameStatusText'],
                'time_left' => ($game['gameStatus'] === 1) ? null : $formatted_time_left,
                'seconds_left' => $seconds_left,
                'period' => ($game['gameStatus'] === 1) ? null : $game['period'],
                'home_team' => [
                    'id' => $game['homeTeam']['teamId'],
                    'name' => $game['homeTeam']['teamName'],
                    'short' => $game['homeTeam']['teamTricode'],
                    'in_bonus' => !(($game['homeTeam']['inBonus'] === '0' || is_null($game['homeTeam']['inBonus']))),
                    'timeouts_remaining' => ($game['gameStatus'] === 1) ? null : $game['homeTeam']['timeoutsRemaining'],
                    'wins' => $game['homeTeam']['wins'],
                    'losses' => $game['homeTeam']['losses'],
                    'seed' => $game['homeTeam']['seed']
                ],
                'away_team' => [
                    'id' => $game['awayTeam']['teamId'],
                    'name' => $game['awayTeam']['teamName'],
                    'short' => $game['awayTeam']['teamTricode'],
                    'in_bonus' => !(($game['awayTeam']['inBonus'] === '0' || is_null($game['awayTeam']['inBonus']))),
                    'timeouts_remaining' => ($game['gameStatus'] === 1) ? null : $game['awayTeam']['timeoutsRemaining'],
                    'wins' => $game['awayTeam']['wins'],
                    'losses' => $game['awayTeam']['losses'],
                    'seed' => $game['awayTeam']['seed']
                ],
                'periods' => ($game['gameStatus'] === 1) ? [] : [
                    'one' => [
                        [
                            'home_score' => $game['homeTeam']['periods'][0]['score'] ?? null,
                            'away_score' => $game['awayTeam']['periods'][0]['score'] ?? null,
                        ]
                    ],
                    'two' => [
                        [
                            'home_score' => $game['homeTeam']['periods'][1]['score'] ?? null,
                            'away_score' => $game['awayTeam']['periods'][1]['score'] ?? null,
                        ]
                    ],
                    'three' => [
                        [
                            'home_score' => $game['homeTeam']['periods'][2]['score'] ?? null,
                            'away_score' => $game['awayTeam']['periods'][2]['score'] ?? null,
                        ]
                    ],
                    'four' => [
                        [
                            'home_score' => $game['homeTeam']['periods'][3]['score'] ?? null,
                            'away_score' => $game['awayTeam']['periods'][3]['score'] ?? null,
                        ]
                    ],
                    'five' => [
                        [
                            'home_score' => $game['homeTeam']['periods'][4]['score'] ?? null,
                            'away_score' => $game['awayTeam']['periods'][4]['score'] ?? null,
                        ]
                    ],
                    'six' => [
                        [
                            'home_score' => $game['homeTeam']['periods'][5]['score'] ?? null,
                            'away_score' => $game['awayTeam']['periods'][5]['score'] ?? null,
                        ]
                    ],
                    'seven' => [
                        [
                            'home_score' => $game['homeTeam']['periods'][6]['score'] ?? null,
                            'away_score' => $game['awayTeam']['periods'][6]['score'] ?? null,
                        ]
                    ]
                ],
                'game_series' => $game['seriesText'],
                'game_type' => $game['gameSubtype'],
                'game_time_utc' => (new DateTime($game['gameTimeUTC']))->format('Y-m-d H:i:s'),
                'game_time_et' => (new DateTime($game['gameEt']))->format('Y-m-d H:i:s')
            ];
        }

        return $formatted;
    }

    public function startingIn(string $utc_datetime): ?string
    {
        $utc_datetime = new DateTime($utc_datetime, new DateTimeZone('UTC'));
        $current_time = new DateTime('now', new DateTimeZone('UTC'));

        if ($current_time >= $utc_datetime) {//Datetime has passed
            return null;
        }

        return $current_time->diff($utc_datetime)->format('%H:%I');
    }

}