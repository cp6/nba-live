<?php

namespace Corbpie\NBALive;

class NBADashFilters extends NBABase
{
    public string $date_from = '';
    public string $date_to = '';
    public string $game_segment = '';
    public string $ist_round = '';
    public int $last_n_games = 0;
    public string $league_id = '00';
    public string $location = '';
    public string $measure_type = 'Base';
    public int $month = 0;
    public string $opponent_team_id = '';
    public string $outcome = '';
    public string $pace_adjust = 'N';
    public string $per_mode = 'PerGame';
    public int $period = 0;
    public string $plus_minus = 'N';
    public string $rank = 'N';
    public string $season = '2023-24';
    public string $season_segment = '';
    public string $season_type = 'Regular+Season';
    public string $the_team_id = '';
    public string $vs_conference = '';
    public string $vs_division = '';

    public function build(): string
    {
        $params = [
            'DateFrom' => $this->date_from,
            'DateTo' => $this->date_to,
            'GameSegment' => $this->game_segment,
            'ISTRound' => $this->ist_round,
            'LastNGames' => $this->last_n_games,
            'LeagueID' => $this->league_id,
            'Location' => $this->location,
            'MeasureType' => $this->measure_type,
            'Month' => $this->month,
            'OpponentTeamID' => $this->opponent_team_id,
            'Outcome' => $this->outcome,
            'PaceAdjust' => $this->pace_adjust,
            'PerMode' => $this->per_mode,
            'Period' => $this->period,
            'PlusMinus' => $this->plus_minus,
            'Rank' => $this->rank,
            'Season' => $this->season,
            'SeasonSegment' => $this->season_segment,
            'SeasonType' => $this->season_type,
            'TeamID' => $this->the_team_id,
            'VsConference' => $this->vs_conference,
            'VsDivision' => $this->vs_division,
        ];

        // Remove empty values from the array
        $params = array_filter($params, function ($value) {
            return $value !== '' && $value !== null;
        });

        // Build the query string
        return http_build_query($params, '', '&');
    }

}