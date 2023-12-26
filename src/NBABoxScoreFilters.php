<?php

namespace Corbpie\NBALive;

class NBABoxScoreFilters extends NBABase
{
    public int $range_type = 1;//Use 1 for filtering

    public int $start_period = 0;//Start Q1

    public int $start_range = 0;//Start at 0 seconds

    public int $end_period = 7;//Cover up to 3 OTs

    public int $end_range = 3900;//End after 65 minutes of game time

    public string $filters = "endPeriod=4&endRange=28800&rangeType=1&startPeriod=0&startRange=0";

    public function __construct()
    {
        $this->filters = "endPeriod={$this->end_period}&endRange={$this->end_range}&rangeType={$this->range_type}&startPeriod={$this->start_period}&startRange={$this->start_range}";
    }

    public function build(): string
    {
        return "endPeriod={$this->end_period}&endRange={$this->end_range}&rangeType={$this->range_type}&startPeriod={$this->start_period}&startRange={$this->start_range}";
    }

    public function buildQ1(): string
    {
        return "endPeriod=1&endRange=28800&rangeType=1&startPeriod=1&startRange=0";
    }

    public function buildQ2(): string
    {
        return "endPeriod=2&endRange=28800&rangeType=1&startPeriod=2&startRange=0";
    }

    public function buildQ3(): string
    {
        return "endPeriod=3&endRange=28800&rangeType=1&startPeriod=3&startRange=0";
    }

    public function buildQ4(): string
    {
        return "endPeriod=4&endRange=28800&rangeType=1&startPeriod=4&startRange=0";
    }

    public function buildOt1(): string
    {
        return "endPeriod=5&endRange=38800&rangeType=1&startPeriod=5&startRange=0";
    }

    public function buildOt2(): string
    {
        return "endPeriod=6&endRange=38800&rangeType=1&startPeriod=6&startRange=0";
    }

    public function buildOt3(): string
    {
        return "endPeriod=7&endRange=38800&rangeType=1&startPeriod=7&startRange=0";
    }

    public function buildH1(): string
    {
        return "endPeriod=2&endRange=28800&rangeType=1&startPeriod=1&startRange=0";
    }

    public function buildH2(): string
    {
        return "endPeriod=4&endRange=28800&rangeType=1&startPeriod=3&startRange=0";
    }

}