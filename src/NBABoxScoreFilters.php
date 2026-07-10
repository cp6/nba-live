<?php

declare(strict_types=1);

namespace Corbpie\NBALive;

use Corbpie\NBALive\Http\NbaHttpClientInterface;

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
    public string $filters = '';

    public function __construct(?NbaHttpClientInterface $httpClient = null)
    {
        parent::__construct($httpClient);
        $this->filters = $this->build();
    }

    /**
     * Build filter query string from current property values.
     *
     * @return string URL query string for API filtering
     */
    public function build(): string
    {
        return http_build_query([
            'endPeriod' => $this->end_period,
            'endRange' => $this->end_range,
            'rangeType' => $this->range_type,
            'startPeriod' => $this->start_period,
            'startRange' => $this->start_range,
        ], '', '&');
    }

    /**
     * Sync $filters from the current property values and return it.
     */
    public function applyFilters(): string
    {
        $this->filters = $this->build();

        return $this->filters;
    }

    public function buildQ1(): string
    {
        return 'endPeriod=1&endRange=28800&rangeType=1&startPeriod=1&startRange=0';
    }

    public function buildQ2(): string
    {
        return 'endPeriod=2&endRange=28800&rangeType=1&startPeriod=2&startRange=0';
    }

    public function buildQ3(): string
    {
        return 'endPeriod=3&endRange=28800&rangeType=1&startPeriod=3&startRange=0';
    }

    public function buildQ4(): string
    {
        return 'endPeriod=4&endRange=28800&rangeType=1&startPeriod=4&startRange=0';
    }

    public function buildOt1(): string
    {
        return 'endPeriod=5&endRange=38800&rangeType=1&startPeriod=5&startRange=0';
    }

    public function buildOt2(): string
    {
        return 'endPeriod=6&endRange=38800&rangeType=1&startPeriod=6&startRange=0';
    }

    public function buildOt3(): string
    {
        return 'endPeriod=7&endRange=38800&rangeType=1&startPeriod=7&startRange=0';
    }

    public function buildH1(): string
    {
        return 'endPeriod=2&endRange=28800&rangeType=1&startPeriod=1&startRange=0';
    }

    public function buildH2(): string
    {
        return 'endPeriod=4&endRange=28800&rangeType=1&startPeriod=3&startRange=0';
    }
}
