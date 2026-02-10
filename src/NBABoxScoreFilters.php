<?php

namespace Corbpie\NBALive;

/**
 * Base class for box score endpoints that support time/period filtering.
 */
class NBABoxScoreFilters extends NBABase
{
    /** @var int Range type (use 1 for filtering) */
    public int $range_type = 1;

    /** @var int Start period (0 = start of Q1) */
    public int $start_period = 0;

    /** @var int Start range in seconds */
    public int $start_range = 0;

    /** @var int End period (7 covers up to 3 OTs) */
    public int $end_period = 7;

    /** @var int End range in seconds (3900 = 65 minutes of game time) */
    public int $end_range = 3900;

    /** @var string Pre-built filter query string */
    public string $filters = "endPeriod=4&endRange=28800&rangeType=1&startPeriod=0&startRange=0";

    /**
     * Initialize filters with default values.
     */
    public function __construct()
    {
        $this->filters = $this->build();
    }

    /**
     * Build filter query string from current property values.
     *
     * @return string URL query string for API filtering
     */
    public function build(): string
    {
        return "endPeriod={$this->end_period}&endRange={$this->end_range}&rangeType={$this->range_type}&startPeriod={$this->start_period}&startRange={$this->start_range}";
    }

    /**
     * Get filter for Quarter 1 only.
     *
     * @return string Filter query string
     */
    public function buildQ1(): string
    {
        return "endPeriod=1&endRange=28800&rangeType=1&startPeriod=1&startRange=0";
    }

    /**
     * Get filter for Quarter 2 only.
     *
     * @return string Filter query string
     */
    public function buildQ2(): string
    {
        return "endPeriod=2&endRange=28800&rangeType=1&startPeriod=2&startRange=0";
    }

    /**
     * Get filter for Quarter 3 only.
     *
     * @return string Filter query string
     */
    public function buildQ3(): string
    {
        return "endPeriod=3&endRange=28800&rangeType=1&startPeriod=3&startRange=0";
    }

    /**
     * Get filter for Quarter 4 only.
     *
     * @return string Filter query string
     */
    public function buildQ4(): string
    {
        return "endPeriod=4&endRange=28800&rangeType=1&startPeriod=4&startRange=0";
    }

    /**
     * Get filter for Overtime 1 only.
     *
     * @return string Filter query string
     */
    public function buildOt1(): string
    {
        return "endPeriod=5&endRange=38800&rangeType=1&startPeriod=5&startRange=0";
    }

    /**
     * Get filter for Overtime 2 only.
     *
     * @return string Filter query string
     */
    public function buildOt2(): string
    {
        return "endPeriod=6&endRange=38800&rangeType=1&startPeriod=6&startRange=0";
    }

    /**
     * Get filter for Overtime 3 only.
     *
     * @return string Filter query string
     */
    public function buildOt3(): string
    {
        return "endPeriod=7&endRange=38800&rangeType=1&startPeriod=7&startRange=0";
    }

    /**
     * Get filter for First Half (Q1 + Q2).
     *
     * @return string Filter query string
     */
    public function buildH1(): string
    {
        return "endPeriod=2&endRange=28800&rangeType=1&startPeriod=1&startRange=0";
    }

    /**
     * Get filter for Second Half (Q3 + Q4).
     *
     * @return string Filter query string
     */
    public function buildH2(): string
    {
        return "endPeriod=4&endRange=28800&rangeType=1&startPeriod=3&startRange=0";
    }
}
