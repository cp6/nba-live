<?php

declare(strict_types=1);

namespace Corbpie\NBALive\Tests;

use Corbpie\NBALive\ResultSetMapper;
use Corbpie\NBALive\Season;
use PHPUnit\Framework\TestCase;

final class ResultSetMapperTest extends TestCase
{
    public function testMapRowsUsesHeaders(): void
    {
        $resultSet = [
            'headers' => ['GAME_ID', 'PTS'],
            'rowSet' => [
                ['0022500123', 110],
                ['0022500124', 98],
            ],
        ];

        $rows = ResultSetMapper::mapRows($resultSet);

        $this->assertCount(2, $rows);
        $this->assertSame('0022500123', $rows[0]['GAME_ID']);
        $this->assertSame(110, $rows[0]['PTS']);
    }

    public function testMapFirstResultSet(): void
    {
        $response = [
            'resultSets' => [
                [
                    'headers' => ['TEAM_ID'],
                    'rowSet' => [[1610612754]],
                ],
            ],
        ];

        $rows = ResultSetMapper::mapFirstResultSet($response);

        $this->assertSame(1610612754, $rows[0]['TEAM_ID']);
    }

    public function testSeasonCurrentInJuly(): void
    {
        $date = new \DateTimeImmutable('2026-07-02', new \DateTimeZone('UTC'));

        $this->assertSame('2025-26', Season::current($date));
        $this->assertSame('2024-25', Season::previous($date));
    }

    public function testSeasonCurrentInOctober(): void
    {
        $date = new \DateTimeImmutable('2026-10-15', new \DateTimeZone('UTC'));

        $this->assertSame('2026-27', Season::current($date));
        $this->assertSame('2025-26', Season::previous($date));
    }
}
