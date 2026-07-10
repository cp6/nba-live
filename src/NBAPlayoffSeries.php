<?php

declare(strict_types=1);

namespace Corbpie\NBALive;

use Corbpie\NBALive\Contracts\FetchableEndpoint;
use Corbpie\NBALive\Http\NbaHttpClientInterface;
final class NBAPlayoffSeries extends NBABase implements FetchableEndpoint
{

    public array $data = [];

    public array $results = [];

    public function fetch(string $season = NBABase::CURRENT_SEASON, string $series_id = ''): array
    {
        $this->results = [];



        $this->data = $this->ApiCall("https://stats.nba.com/stats/commonplayoffseries?LeagueID=00&Season=$season&SeriesID=$series_id");

        if (isset($this->data['resultSets'][0]['rowSet'][0])) {
            foreach ($this->data['resultSets'][0]['rowSet'] as $d) {
                $this->results[] = [
                    'game_id' => $d[0],
                    'home_tid' => $d[1],
                    'away_tid' => $d[2],
                    'series_id' => $d[3],
                    'game_num' => $d[4]
                ];
            }
        }

        return $this->data;
    }

    public function __construct(string $season = NBABase::CURRENT_SEASON, string $series_id = '', ?NbaHttpClientInterface $httpClient = null)
    {
        parent::__construct($httpClient);
        $this->fetch($season, $series_id);
    }

}
