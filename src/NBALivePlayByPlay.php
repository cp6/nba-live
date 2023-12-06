<?php

namespace Corbpie\NBALive;

class NBALivePlayByPlay extends NBALiveBase
{

    public array $all_plays = [];

    public array $last_10_plays = [];

    public int $plays_count;

    public function __construct(string $game_id)
    {
        $data = $this->ApiCall("https://cdn.nba.com/static/json/liveData/playbyplay/playbyplay_{$game_id}.json");

        $this->all_plays = $data['game']['actions'];
        $this->last_10_plays = array_slice($this->all_plays, -10);
        $this->plays_count = count($this->all_plays);

    }

}