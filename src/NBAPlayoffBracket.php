<?php

namespace Corbpie\NBALive;

class NBAPlayoffBracket extends NBABase
{

    public array $data = [];

    public array $results = [];

    public array $east = [];

    public array $west = [];

    public function __construct(string $season = '2023')
    {
        $this->data = $this->ApiCall("https://cdn.nba.com/static/json/staticData/brackets/{$season}/PlayoffBracket.json");

        if (isset($this->data['bracket']['playoffBracketSeries'][0])) {
            foreach ($this->data['bracket']['playoffBracketSeries'] as $s) {

                $series = [
                    'id' => $s['seriesId'],
                    'round' => $s['roundNumber'],
                    'conference' => $s['seriesConference'],
                    'text' => $s['seriesText'],
                    'status' => $s['seriesStatus'],
                    'winner' => $s['seriesWinner'],
                    'high_seed_tid' => $s['highSeedId'],
                    'high_seed_name' => $s['highSeedName'],
                    'high_seed_name_short' => $s['highSeedTricode'],
                    'high_seed_rank' => $s['lowSeedRank'],
                    'high_seed_series_wins' => $s['lowSeedSeriesWins'],
                    'low_seed_tid' => $s['lowSeedId'],
                    'low_seed_name' => $s['lowSeedName'],
                    'low_seed_name_short' => $s['lowSeedTricode'],
                    'low_seed_rank' => $s['lowSeedRank'],
                    'low_seed_series_wins' => $s['lowSeedSeriesWins'],
                    'display_order' => $s['displayOrderNumber'],
                    'display_top_tid' => $s['displayTopTeam'],
                    'round_desc_text' => $s['poRoundDesc'],
                    'next_game_id' => $s['nextGameId'],
                    'next_game_number' => $s['nextGameNumber'],
                    'next_game_status' => $s['nextGameStatus'],
                    'next_game_datetime_et' => (!empty($s['nextGameDateTimeEt'])) ? date("Y-m-d H:i:s", strtotime($s['nextGameDateTimeEt'])) : null,
                    'next_game_text' => $s['nextGameStatusText'],
                    'last_game_id' => $s['lastCompletedGameId']
                ];

                $this->results[] = $series;

                if ($s['seriesConference'] === 'East') {
                    $this->east[] = $series;
                } else {
                    $this->west[] = $series;
                }

            }
        }

    }

}