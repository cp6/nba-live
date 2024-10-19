<?php

namespace Corbpie\NBALive;

use DateTime;
use DateTimeZone;

class NBASchedule extends NBABase
{

    public array $schedule = [];

    public function __construct(string $date = '2023-12-20')
    {
        $games = $this->ApiCall("https://stats.nba.com/stats/scoreboardv2?DayOffset=0&GameDate={$date}&LeagueID=00");

        $this->process($games);
    }

    public function fullForTeam(int $team_id): array
    {
        $games = $this->ApiCall("https://cdn.nba.com/static/json/staticData/scheduleLeagueV2.json");

        $data = $games['leagueSchedule']['gameDates'];

        $games = [];

        for ($i = 0; $i <= 173; $i++) {
            foreach ($data[$i]['games'] as $game) {
                if ($game['homeTeam']['teamId'] === $team_id || $game['awayTeam']['teamId'] === $team_id) {
                    $game['time_until_game'] = $this->getTimeAway($game['gameDateTimeEst']);
                    $games[] = $game;

                }
            }
        }

        return $games;
    }

    private function getTimeAway($dateString): ?string
    {
        $now = new DateTime();
        $date = new DateTime($dateString);

        if ($date < $now) {
            return null;
        }

        $interval = $now->diff($date);

        $days = $interval->d;
        $hours = $interval->h;
        $minutes = $interval->i;

        $result = [];
        if ($days > 0) {
            $result[] = $days . " Day" . ($days > 1 ? "s" : "");
        }
        if ($hours > 0) {
            $result[] = $hours . " Hour" . ($hours > 1 ? "s" : "");
        }
        if ($minutes > 0 && count($result) < 2) {
            $result[] = $minutes . " Minute" . ($minutes > 1 ? "s" : "");
        }

        return implode(" ", $result);
    }

    public function process(array $data, ?int $team_id = null): array
    {
        if (isset($this->data['resultSets'][0]['rowSet'][0])) {
            foreach ($data['resultSets'][0]['rowSet'] as $game) {

                $time_formatted = DateTime::createFromFormat('g:i a', str_replace(" ET", "", $game[4]))->format('H:i:s');

                $date_time = str_replace("T00:00:00", " $time_formatted", $game[0]);

                if ($team_id === null || ($team_id === $game[6] || $team_id === $game[7])) {
                    $this->schedule[] = [
                        'game_id' => $game[2],
                        'game_sequence' => $game[1],
                        'game_status' => $game[3],
                        'game_status_text' => $game[4],
                        'game_code' => $game[5],
                        'home_tid' => $game[6],
                        'away_tid' => $game[7],
                        'arena' => $game[15],
                        'live_period' => ($game[9] === 0) ? null : $game[9],
                        'date_time_et' => $date_time,
                        'date_time_utc' => (new DateTime($date_time, new DateTimeZone('America/New_York')))->setTimezone(new DateTimeZone('UTC'))->format('Y-m-d H:i:s')
                    ];
                }

            }
        }

        return $this->schedule;
    }

    public function forTeam(int $team_tid = 1610612746): array
    {
        return $this->process();
    }

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