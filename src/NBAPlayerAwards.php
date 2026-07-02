<?php

declare(strict_types=1);

namespace Corbpie\NBALive;

use Corbpie\NBALive\Contracts\FetchableEndpoint;
use Corbpie\NBALive\Http\NbaHttpClientInterface;
final class NBAPlayerAwards extends NBABase implements FetchableEndpoint
{

    public array $data = [];

    public array $awards = [];

    public function fetch(int $player_id = 0): array
    {

        if ($this->player_id <= 0) {
            $this->player_id = $player_id;
        }

        $this->data = $this->ApiCall("https://stats.nba.com/stats/playerawards?PlayerID={$this->player_id}");

        if (isset($this->data['resultSets'][0]['rowSet'])) {
            foreach ($this->data['resultSets'][0]['rowSet'] as $award) {
                $this->awards[] = [
                    'team' => $award[3],
                    'desc' => $award[4],
                    'all_nba_team_number' => $award[5],
                    'season' => $award[6],
                    'month' => $award[7],
                    'week' => $award[8],
                    'conference' => $award[9],
                    'type' => $award[10],
                    'sub_type1' => $award[11],
                    'sub_type2' => $award[12],
                    'sub_type3' => $award[13]
                ];
            }
        }

        return $this->data;
    }

    public function __construct(int $player_id = 0, ?NbaHttpClientInterface $httpClient = null)
    {
        parent::__construct($httpClient);
        $this->fetch($player_id);
    }

}
