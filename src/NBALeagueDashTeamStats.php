<?php

declare(strict_types=1);

namespace Corbpie\NBALive;

use Corbpie\NBALive\Contracts\FetchableEndpoint;
use Corbpie\NBALive\Http\NbaHttpClientInterface;

/**
 * League-wide team dashboard statistics.
 */
final class NBALeagueDashTeamStats extends NBALeagueDashFilters implements FetchableEndpoint
{
    /** @var array<string, mixed> */
    public array $data = [];

    /** @var list<array<string, mixed>> */
    public array $teams = [];

    public function __construct(?NbaHttpClientInterface $httpClient = null)
    {
        parent::__construct($httpClient);
        $this->per_mode = NBABase::MODE_PER_GAME;
        $this->league_id = '00';
    }

    public function fetch(): array
    {
        $this->teams = [];

        $this->data = $this->ApiCall('https://stats.nba.com/stats/leaguedashteamstats?' . $this->teamStatsQuery());

        foreach (ResultSetMapper::mapFirstResultSet($this->data) as $row) {
            $this->teams[] = [
                'team_id' => ResultSetMapper::pick($row, 'TEAM_ID'),
                'team_name' => ResultSetMapper::pick($row, 'TEAM_NAME', ''),
                'gp' => ResultSetMapper::pick($row, 'GP'),
                'w' => ResultSetMapper::pick($row, 'W'),
                'l' => ResultSetMapper::pick($row, 'L'),
                'w_pct' => ResultSetMapper::pick($row, 'W_PCT'),
                'min' => ResultSetMapper::pick($row, 'MIN'),
                'fgm' => ResultSetMapper::pick($row, 'FGM'),
                'fga' => ResultSetMapper::pick($row, 'FGA'),
                'fg_pct' => ResultSetMapper::pick($row, 'FG_PCT'),
                'fg3m' => ResultSetMapper::pick($row, 'FG3M'),
                'fg3a' => ResultSetMapper::pick($row, 'FG3A'),
                'fg3_pct' => ResultSetMapper::pick($row, 'FG3_PCT'),
                'ftm' => ResultSetMapper::pick($row, 'FTM'),
                'fta' => ResultSetMapper::pick($row, 'FTA'),
                'ft_pct' => ResultSetMapper::pick($row, 'FT_PCT'),
                'oreb' => ResultSetMapper::pick($row, 'OREB'),
                'dreb' => ResultSetMapper::pick($row, 'DREB'),
                'reb' => ResultSetMapper::pick($row, 'REB'),
                'ast' => ResultSetMapper::pick($row, 'AST'),
                'tov' => ResultSetMapper::pick($row, 'TOV'),
                'stl' => ResultSetMapper::pick($row, 'STL'),
                'blk' => ResultSetMapper::pick($row, 'BLK'),
                'blka' => ResultSetMapper::pick($row, 'BLKA'),
                'pf' => ResultSetMapper::pick($row, 'PF'),
                'pfd' => ResultSetMapper::pick($row, 'PFD'),
                'pts' => ResultSetMapper::pick($row, 'PTS'),
                'plus_minus' => ResultSetMapper::pick($row, 'PLUS_MINUS'),
            ];
        }

        return $this->data;
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function leaders(string $stat = 'pts', int $limit = 10): array
    {
        $sorted = $this->teams;
        usort($sorted, static fn (array $a, array $b): int => ($b[$stat] ?? 0) <=> ($a[$stat] ?? 0));

        return array_slice($sorted, 0, $limit);
    }

    private function teamStatsQuery(): string
    {
        $params = [
            'Conference' => $this->conference,
            'DateFrom' => $this->date_from,
            'DateTo' => $this->date_to,
            'Division' => $this->division,
            'GameScope' => $this->game_scope,
            'GameSegment' => $this->game_segment,
            'LastNGames' => $this->last_n_games,
            'LeagueID' => $this->league_id !== '' ? $this->league_id : '00',
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
            'TeamID' => $this->team_id > 0 ? $this->team_id : '',
            'VsConference' => $this->vs_conference,
            'VsDivision' => $this->vs_division,
        ];

        $params = array_filter($params, static fn ($value) => $value !== '');

        return http_build_query($params, '', '&');
    }
}
