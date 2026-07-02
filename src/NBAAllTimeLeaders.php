<?php

declare(strict_types=1);

namespace Corbpie\NBALive;

use Corbpie\NBALive\Contracts\FetchableEndpoint;
use Corbpie\NBALive\Http\NbaHttpClientInterface;

/**
 * Retrieve NBA all-time statistical leaders.
 */
final class NBAAllTimeLeaders extends NBABase implements FetchableEndpoint
{
    /** @var array Raw API response data */
    public array $data = [];

    /** @var array All-time leaders */
    public array $leaders = [];

    /**
     * Fetch all-time leaders for a stat category.
     *
     * @param string $stat_category Stat category (PTS, AST, REB, STL, BLK, FGM, FG3M, FTM, etc.)
     * @param string $per_mode Per mode (Totals, PerGame)
     * @param int $top_x Number of leaders to return
     * @param string $season_type Season type
     * @throws NBAApiException When the API request fails
     */
    public function fetch(string $stat_category = 'PTS',
        string $per_mode = self::MODE_TOTAL,
        int $top_x = 10,
        string $season_type = self::TYPE_REGULAR): array
    {

        $this->data = $this->ApiCall("https://stats.nba.com/stats/alltimeleadersgrids?LeagueID=00&PerMode={$per_mode}&SeasonType={$season_type}&TopX={$top_x}");

        // Map stat category to result set index
        $categoryMap = [
            'GP' => 0, 'PTS' => 1, 'AST' => 2, 'REB' => 3, 'STL' => 4,
            'BLK' => 5, 'FGM' => 6, 'FGA' => 7, 'FG_PCT' => 8, 'FG3M' => 9,
            'FG3A' => 10, 'FG3_PCT' => 11, 'FTM' => 12, 'FTA' => 13, 'FT_PCT' => 14,
            'OREB' => 15, 'DREB' => 16, 'TOV' => 17, 'PF' => 18
        ];

        $index = $categoryMap[$stat_category] ?? 1;

        if (isset($this->data['resultSets'][$index]['rowSet'])) {
            foreach ($this->data['resultSets'][$index]['rowSet'] as $l) {
                $this->leaders[] = [
                    'player_id' => $l[0] ?? 0,
                    'player_name' => $l[1] ?? '',
                    'value' => $l[2] ?? 0,
                    'is_active' => ($l[4] ?? 'N') === 'Y',
                ];
            }
        }

        return $this->data;
    }

    public function __construct(string $stat_category = 'PTS',
        string $per_mode = self::MODE_TOTAL,
        int $top_x = 10,
        string $season_type = self::TYPE_REGULAR, ?NbaHttpClientInterface $httpClient = null)
    {
        parent::__construct($httpClient);
        $this->fetch($stat_category, $per_mode, $top_x, $season_type);
    }
}
