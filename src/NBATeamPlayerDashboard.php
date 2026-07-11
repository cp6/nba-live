<?php

declare(strict_types=1);

namespace Corbpie\NBALive;

use Corbpie\NBALive\Contracts\FetchableEndpoint;
use Corbpie\NBALive\Http\NbaHttpClientInterface;

/**
 * Team overall + player season totals dashboard.
 */
final class NBATeamPlayerDashboard extends NBATeamDashFilters implements FetchableEndpoint
{
    /** @var array<string, mixed> */
    public array $data = [];

    /** @var array<string, mixed> */
    public array $team_overall = [];

    /** @var list<array<string, mixed>> */
    public array $players = [];

    public function __construct(?NbaHttpClientInterface $httpClient = null)
    {
        parent::__construct($httpClient);
        $this->per_mode = NBABase::MODE_PER_GAME;
    }

    public function fetch(): array
    {
        $this->validatePositiveInt($this->team_id, 'team_id');

        $this->team_overall = [];
        $this->players = [];

        $this->data = $this->ApiCall('https://stats.nba.com/stats/teamplayerdashboard?' . $this->build());

        $overallRows = ResultSetMapper::mapResultSetAt($this->data, 0);
        if ($overallRows !== []) {
            $row = $overallRows[0];
            $this->team_overall = [
                'team_id' => ResultSetMapper::pick($row, 'TEAM_ID'),
                'team_name' => ResultSetMapper::pick($row, 'TEAM_NAME', ''),
                'group_value' => ResultSetMapper::pick($row, 'GROUP_VALUE', ''),
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
                'pts' => ResultSetMapper::pick($row, 'PTS'),
                'plus_minus' => ResultSetMapper::pick($row, 'PLUS_MINUS'),
            ];
        }

        foreach (ResultSetMapper::mapResultSetAt($this->data, 1) as $row) {
            $this->players[] = [
                'player_id' => ResultSetMapper::pick($row, 'PLAYER_ID'),
                'player_name' => ResultSetMapper::pick($row, 'PLAYER_NAME', ''),
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
                'pts' => ResultSetMapper::pick($row, 'PTS'),
                'plus_minus' => ResultSetMapper::pick($row, 'PLUS_MINUS'),
                'nba_fantasy_pts' => ResultSetMapper::pick($row, 'NBA_FANTASY_PTS'),
                'dd2' => ResultSetMapper::pick($row, 'DD2'),
                'td3' => ResultSetMapper::pick($row, 'TD3'),
            ];
        }

        return $this->data;
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function leaders(string $stat = 'pts', int $limit = 5): array
    {
        $sorted = $this->players;
        usort($sorted, static fn (array $a, array $b): int => ($b[$stat] ?? 0) <=> ($a[$stat] ?? 0));

        return array_slice($sorted, 0, $limit);
    }
}
