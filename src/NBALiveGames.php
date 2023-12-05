<?php

namespace Corbpie\NBALive;

use DateInterval;
use DateTime;

class NBALiveGames extends NBALiveBase
{
    public array $upcoming_games = [];

    public array $live_games = [];

    public array $completed_games = [];

    public function getProcessGames(): array
    {
        $games = $this->ApiCall("scoreboard/todaysScoreboard_00");

        $total = $live = $completed = $upcoming = 0;

        if (isset($games['scoreboard'])) {
            foreach ($games['scoreboard']['games'] as $game) {
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
                $total++;
            }
        }

        return [
            'date' => $games['scoreboard']['gameDate'],
            'all_games' => $total,
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
            $formatted[] = [
                'game_id' => $game['gameId'],
                'game_code' => $game['gameCode'],
                'margin' => ($game['homeTeam']['score'] > $game['awayTeam']['score']) ? ($game['homeTeam']['score'] - $game['awayTeam']['score']) : ($game['awayTeam']['score'] - $game['homeTeam']['score']),
                'home_score' => $game['homeTeam']['score'],
                'away_score' => $game['awayTeam']['score'],
                'time_left_string' => $game['gameStatusText'],
                'time_left' => $formatted_time_left,
                'seconds_left' => ($formatted_time_left === null) ? 0 : array_sum(array_map(function ($v, $i) {
                    return ($i === 0) ? $v * 60 : $v;
                }, explode(':', $formatted_time_left), range(0, 1))),
                'period' => $game['period'],
                'home_team' => [
                    'id' => $game['homeTeam']['teamId'],
                    'name' => $game['homeTeam']['teamName'],
                    'short' => $game['homeTeam']['teamTricode'],
                    'in_bonus' => !(($game['homeTeam']['inBonus'] === '0')),
                    'timeouts_remaining' => $game['homeTeam']['timeoutsRemaining'],
                    'wins' => $game['homeTeam']['wins'],
                    'losses' => $game['homeTeam']['losses'],
                    'seed' => $game['homeTeam']['seed']
                ],
                'away_team' => [
                    'id' => $game['awayTeam']['teamId'],
                    'name' => $game['awayTeam']['teamName'],
                    'short' => $game['awayTeam']['teamTricode'],
                    'in_bonus' => !(($game['awayTeam']['inBonus'] === '0')),
                    'timeouts_remaining' => $game['awayTeam']['timeoutsRemaining'],
                    'wins' => $game['awayTeam']['wins'],
                    'losses' => $game['awayTeam']['losses'],
                    'seed' => $game['awayTeam']['seed']
                ],
                'periods' => [
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

}