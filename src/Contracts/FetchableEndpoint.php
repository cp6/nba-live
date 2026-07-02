<?php

declare(strict_types=1);

namespace Corbpie\NBALive\Contracts;

/**
 * Endpoint classes that load data via an explicit fetch() call.
 */
interface FetchableEndpoint
{
    /**
     * @return array<string, mixed>
     */
    public function fetch(): array;
}
