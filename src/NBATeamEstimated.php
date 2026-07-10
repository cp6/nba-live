<?php

declare(strict_types=1);

namespace Corbpie\NBALive;

use Corbpie\NBALive\Contracts\FetchableEndpoint;
use Corbpie\NBALive\Http\NbaHttpClientInterface;

final class NBATeamEstimated extends NBABase implements FetchableEndpoint
{
    public array $data = [];

    public array $teams = [];

    public function fetch(string $season = NBABase::CURRENT_SEASON, string $season_type = NBABase::TYPE_REGULAR): array
    {
        $this->teams = [];

        $params = http_build_query([
            'LeagueID' => '00',
            'Season' => $season,
            'SeasonType' => $season_type,
        ], '', '&');

        $this->data = $this->ApiCall("https://stats.nba.com/stats/teamestimatedmetrics?{$params}");

        $resultSet = $this->data['resultSet'] ?? null;
        if (!is_array($resultSet)) {
            return $this->data;
        }

        foreach (ResultSetMapper::mapRows($resultSet) as $row) {
            $this->teams[] = [
                'team_id' => ResultSetMapper::pick($row, 'TEAM_ID'),
                'team_name' => ResultSetMapper::pick($row, 'TEAM_NAME'),
                'gp' => ResultSetMapper::pick($row, 'GP'),
                'w' => ResultSetMapper::pick($row, 'W'),
                'l' => ResultSetMapper::pick($row, 'L'),
                'w_pct' => ResultSetMapper::pick($row, 'W_PCT'),
                'min' => ResultSetMapper::pick($row, 'MIN'),
                'e_off_rating' => ResultSetMapper::pick($row, 'E_OFF_RATING'),
                'e_def_rating' => ResultSetMapper::pick($row, 'E_DEF_RATING'),
                'e_net_rating' => ResultSetMapper::pick($row, 'E_NET_RATING'),
                'e_pace' => ResultSetMapper::pick($row, 'E_PACE'),
                'e_ast_ratio' => ResultSetMapper::pick($row, 'E_AST_RATIO'),
                'e_oreb_pct' => ResultSetMapper::pick($row, 'E_OREB_PCT'),
                'e_dreb_pct' => ResultSetMapper::pick($row, 'E_DREB_PCT'),
                'e_reb_pct' => ResultSetMapper::pick($row, 'E_REB_PCT'),
                'e_tm_tov_pct' => ResultSetMapper::pick($row, 'E_TM_TOV_PCT'),
                'gp_rank' => ResultSetMapper::pick($row, 'GP_RANK'),
                'w_rank' => ResultSetMapper::pick($row, 'W_RANK'),
                'l_rank' => ResultSetMapper::pick($row, 'L_RANK'),
                'w_pct_rank' => ResultSetMapper::pick($row, 'W_PCT_RANK'),
                'min_rank' => ResultSetMapper::pick($row, 'MIN_RANK'),
                'e_off_rating_rank' => ResultSetMapper::pick($row, 'E_OFF_RATING_RANK'),
                'e_def_rating_rank' => ResultSetMapper::pick($row, 'E_DEF_RATING_RANK'),
                'e_net_rating_rank' => ResultSetMapper::pick($row, 'E_NET_RATING_RANK'),
                'e_ast_ratio_rank' => ResultSetMapper::pick($row, 'E_AST_RATIO_RANK'),
                'e_oreb_pct_rank' => ResultSetMapper::pick($row, 'E_OREB_PCT_RANK'),
                'e_dreb_pct_rank' => ResultSetMapper::pick($row, 'E_DREB_PCT_RANK'),
                'e_reb_pct_rank' => ResultSetMapper::pick($row, 'E_REB_PCT_RANK'),
                'e_tm_tov_pct_rank' => ResultSetMapper::pick($row, 'E_TM_TOV_PCT_RANK'),
                'e_pace_rank' => ResultSetMapper::pick($row, 'E_PACE_RANK'),
            ];
        }

        return $this->data;
    }

    public function __construct(string $season = NBABase::CURRENT_SEASON, string $season_type = NBABase::TYPE_REGULAR, ?NbaHttpClientInterface $httpClient = null)
    {
        parent::__construct($httpClient);
        $this->fetch($season, $season_type);
    }

    public function sortAsc(array $team_data, string $key = 'e_off_rating'): array
    {
        usort($team_data, fn ($a, $b) => $a[$key] <=> $b[$key]);

        return $team_data;
    }

    public function sortDesc(array $team_data, string $key = 'e_def_rating'): array
    {
        usort($team_data, fn ($a, $b) => $b[$key] <=> $a[$key]);

        return $team_data;
    }
}
