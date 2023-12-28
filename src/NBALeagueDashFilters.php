<?php

namespace Corbpie\NBALive;

class NBALeagueDashFilters extends NBABase
{
    public string $college = '';
    public string $conference = '';
    public string $country = '';
    public string $date_from = '';
    public string $date_to = '';
    public string $distance_range = 'By Zone';//(5ft Range)|(8ft Range)|(By Zone)
    public string $division = '';
    public string $draft_pick = '';
    public string $draft_year = '';
    public string $game_scope = '';
    public string $game_segment = '';
    public string $height = '';
    public int $last_n_games = 0;
    public string $league_id = '';
    public string $location = '';
    public string $measure_type = 'Base';
    public int $month = 0;
    public int $opponent_team_id = 0;
    public string $outcome = '';
    public string $po_round = '';
    public string $pace_adjust = 'N';
    public string $per_mode = 'Totals';//(Totals)|(PerGame)|(MinutesPer)|(Per48)|(Per40)|(Per36)|(PerMinute)|(PerPossession)|(PerPlay)|(Per100Possessions)|(Per100Plays)

    public string $period = '0';
    public string $player_experience = '';
    public string $player_position = '';
    public string $plus_minus = 'N';
    public string $rank = 'N';

    public string $season = NBABase::CURRENT_SEASON;
    public string $season_segment = '';
    public string $season_type = 'Regular Season';//(Regular Season)|(Pre Season)|(Playoffs)|(All Star)
    public string $shot_clock_range = '';
    public string $starter_bench = '';
    public string $vs_conference = '';
    public string $vs_division = '';
    public string $weight = '';

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
            'PaceAdjust' => $this->pace_adjust,
            'PerMode' => $this->per_mode,
            'Period' => $this->period,
            'PlusMinus' => $this->plus_minus,
            'Rank' => $this->rank,
            'Season' => $this->season,
            'SeasonSegment' => $this->season_segment,
            'SeasonType' => $this->season_type,
            'TeamID' => $this->team_id ?? null,
            'VsConference' => $this->vs_conference,
            'VsDivision' => $this->vs_division,
            'Weight' => $this->weight,
            'StarterBench' => $this->starter_bench,
            'ShotClockRange' => $this->shot_clock_range,
            'PlayerPosition' => $this->player_position,
            'PlayerExperience' => $this->player_experience,
            'PORound' => $this->po_round,
            'Height' => $this->height,
            'GameScope' => $this->game_scope,
            'DraftYear' => $this->draft_year,
            'DraftPick' => $this->draft_pick,
            'Division' => $this->division,
            'DistanceRange' => $this->distance_range,
            'Country' => $this->country,
            'College' => $this->college,
            'Conference' => $this->conference
        ];

        return http_build_query($params, '', '&');
    }

}