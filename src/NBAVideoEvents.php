<?php

declare(strict_types=1);

namespace Corbpie\NBALive;

use Corbpie\NBALive\Contracts\FetchableEndpoint;
use Corbpie\NBALive\Http\NbaHttpClientInterface;
final class NBAVideoEvents extends NBABase implements FetchableEndpoint
{
    public array $data = [];

    public array $details = [];

    public function fetch(int $event_id = 0, string $game_id = '0022300568'): array
    {

        $this->data = $this->ApiCall("https://stats.nba.com/stats/videoevents?GameEventID={$event_id}&GameID={$game_id}");

        $this->details = [
            $this->data['resultSets']
        ];

        return $this->data;
    }

    public function __construct(int $event_id = 0, string $game_id = '0022300568', ?NbaHttpClientInterface $httpClient = null)
    {
        parent::__construct($httpClient);
        $this->fetch($event_id, $game_id);
    }

}
