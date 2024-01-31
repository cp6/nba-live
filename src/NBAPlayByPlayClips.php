<?php

namespace Corbpie\NBALive;

class NBAPlayByPlayClips extends NBABase
{

    public array $data = [];

    public array $media = [];

    public array $details = [];

    public function __construct(string $game_id, int $event_number)
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/videoeventsasset?GameEventID={$event_number}&GameID={$game_id}");

        if (isset($this->data['resultSets']['Meta']['videoUrls'][0])) {
            $this->media = $this->data['resultSets']['Meta']['videoUrls'][0];
        }

        if (isset($this->data['resultSets']['playlist'][0])) {
            $this->details = $this->data['resultSets']['playlist'][0];
        }

    }

}