<?php

namespace Corbpie\NBALive;

use Corbpie\NBALive\NBABase;

class NBABoxScoreFilters extends NBABase
{
    public int $range_type = 2;

    public int $start_period = 0;

    public int $start_range = 0;

    public int $end_period = 7;//Cover up to 3 OTs

    public int $end_range = 40000;

    public function build(): string
    {
        return "endPeriod={$this->end_period}&endRange={$this->end_range}&rangeType={$this->range_type}&startPeriod={$this->start_period}&startRange={$this->start_range}";
    }

}