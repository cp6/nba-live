<?php

namespace Corbpie\NBALive;

class NBATeamDashFilters extends NBABase
{
    public string $date_from = '';
    public string $date_to = '';
    public string $game_segment = '';
    public int $last_n_games = 0;
    public string $league_id = '';
    public string $location = '';
    public string $measure_type = 'Base';//(Base)|(Advanced)|(Misc)|(Four Factors)|(Scoring)|(Opponent)|(Usage)|(Defense)
    public int $month = 0;
    public int $opponent_team_id = 0;
    public string $outcome = '';
    public string $po_round = '';
    public string $pace_adjust = 'N';
    public string $per_mode = 'Totals';//(Totals)|(PerGame)|(MinutesPer)|(Per48)|(Per40)|(Per36)|(PerMinute)|(PerPossession)|(PerPlay)|(Per100Possessions)|(Per100Plays)
    public int $period = 0;
    public string $plus_minus = 'N';
    public string $rank = 'N';
    public string $season = NBABase::CURRENT_SEASON;
    public string $season_segment = '';
    public string $season_type = 'Regular Season';//(Regular Season)|(Pre Season)|(Playoffs)|(All Star)
    public string $shot_clock_range = '';
    public string $vs_conference = '';
    public string $vs_division = '';

    public function build(): string
    {
        $params = [
            'TeamId' => $this->team_id,
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