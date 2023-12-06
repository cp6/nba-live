<?php

namespace Corbpie\NBALive;

class NBALiveLeagueLeaders extends NBALiveBase
{

    public array $data = [];

    public array $details = [];

    public function __construct(string $mode = 'Totals', string $season = self::CURRENT_SEASON)
    {

    }


}