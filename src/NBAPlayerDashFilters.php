<?php

namespace Corbpie\NBALive;

class NBAPlayerDashFilters extends NBABase
{
    public string $date_from = '';
    public string $date_to = '';
    public string $game_segment = '';
    public int $last_n_games = 0;
    public string $league_id = '';
    public string $location = '';
    public string $measure_type = 'Base';
    public int $month = 0;
    public int $opponent_team_id = 0;
    public string $outcome = '';
    public string $po_round = '';
    public string $pace_adjust = 'N';
    public string $per_mode = 'Totals';
    public int $period = 0;
    public int $player_id;
    public string $plus_minus = 'N';
    public string $rank = 'N';
    public string $season = '';
    public string $season_segment = '';
    public string $season_type = 'Regular Season';
    public string $shot_clock_range = '';
    public string $vs_conference = '';
    public string $vs_division = '';

    public function build(): string
    {
        $params = [
            'DateFrom' => $this->date_from,
            'DateTo' => $this->date_to,
            'GameSegment' => $this->game_segment,
            'LastNGames' => $this->last_n_games,
            'LeagueID' => $this->league_id,
            'Location' => $this->location,
            'MeasureType' => $this->measure_type,
            'Month' => $this->month,
            'OpponentTeamID' => $this->opponent_team_id,
            'Outcome' => $this->outcome,
            'PORound' => $this->po_round,
            'PaceAdjust' => $this->pace_adjust,
            'PerMode' => $this->per_mode,
            'Period' => $this->period,
            'PlayerID' => $this->player_id,
            'PlusMinus' => $this->plus_minus,
            'Rank' => $this->rank,
            'Season' => $this->season,
            'SeasonSegment' => $this->season_segment,
            'SeasonType' => $this->season_type,
            'ShotClockRange' => $this->shot_clock_range,
            'VsConference' => $this->vs_conference,
            'VsDivision' => $this->vs_division,
        ];

        $params = array_filter($params, function ($value) {
            return $value !== '' && $value !== null;
        });

        return http_build_query($params, '', '&');
    }

}