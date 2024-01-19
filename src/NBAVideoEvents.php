<?php

namespace Corbpie\NBALive;

use DateTime;

class NBAVideoEvents extends NBABase
{
    public array $data = [];

    public array $details = [];

    public function __construct(int $event_id = 0, string $game_id = '0022300568')
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/videoevents?GameEventID={$event_id}&GameID={$game_id}");

        $this->details = [
            $this->data['resultSets']
        ];

    }

}