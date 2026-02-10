<?php

namespace Corbpie\NBALive\Tests;

use Corbpie\NBALive\NBABase;
use PHPUnit\Framework\TestCase;

/**
 * Tests for NBABase class utility methods.
 */
class NBABaseTest extends TestCase
{
    private NBABase $base;

    protected function setUp(): void
    {
        $this->base = new class extends NBABase {
            public function __construct()
            {
                // Skip header() call in tests
            }

            // Expose protected methods for testing
            public function testValidateRequiredString(string $value, string $paramName): void
            {
                $this->validateRequiredString($value, $paramName);
            }

            public function testValidatePositiveInt(int $value, string $paramName): void
            {
                $this->validatePositiveInt($value, $paramName);
            }

            public function testGetNestedValue(array $array, array $keys, mixed $default = null): mixed
            {
                return $this->getNestedValue($array, $keys, $default);
            }
        };
    }

    public function testSecondsToFormattedGameTimeQ1(): void
    {
        $result = NBABase::secondsToFormattedGameTime(360);

        $this->assertEquals(1, $result['period']);
        $this->assertEquals('Q1', $result['period_string']);
        $this->assertEquals(360, $result['seconds']);
    }

    public function testSecondsToFormattedGameTimeQ2(): void
    {
        $result = NBABase::secondsToFormattedGameTime(900);

        $this->assertEquals(2, $result['period']);
        $this->assertEquals('Q2', $result['period_string']);
    }

    public function testSecondsToFormattedGameTimeQ3(): void
    {
        $result = NBABase::secondsToFormattedGameTime(1600);

        $this->assertEquals(3, $result['period']);
        $this->assertEquals('Q3', $result['period_string']);
    }

    public function testSecondsToFormattedGameTimeQ4(): void
    {
        $result = NBABase::secondsToFormattedGameTime(2400);

        $this->assertEquals(4, $result['period']);
        $this->assertEquals('Q4', $result['period_string']);
    }

    public function testSecondsToFormattedGameTimeOT1(): void
    {
        $result = NBABase::secondsToFormattedGameTime(3000);

        $this->assertEquals(5, $result['period']);
        $this->assertEquals('OT1', $result['period_string']);
    }

    public function testFeetInchesToCm(): void
    {
        // 6'8" should be approximately 203 cm
        $result = $this->base->feetInchesToCm('6-8');
        $this->assertEquals(203, $result);

        // 7'0" should be approximately 213 cm
        $result = $this->base->feetInchesToCm('7-0');
        $this->assertEquals(213, $result);
    }

    public function testSortPlayersAsc(): void
    {
        $players = [
            ['statistics' => ['points' => 30]],
            ['statistics' => ['points' => 10]],
            ['statistics' => ['points' => 20]],
        ];

        $result = $this->base->sortPlayersAsc($players, 'points');

        $this->assertEquals(10, $result[0]['statistics']['points']);
        $this->assertEquals(20, $result[1]['statistics']['points']);
        $this->assertEquals(30, $result[2]['statistics']['points']);
    }

    public function testSortPlayersDesc(): void
    {
        $players = [
            ['statistics' => ['points' => 10]],
            ['statistics' => ['points' => 30]],
            ['statistics' => ['points' => 20]],
        ];

        $result = $this->base->sortPlayersDesc($players, 'points');

        $this->assertEquals(30, $result[0]['statistics']['points']);
        $this->assertEquals(20, $result[1]['statistics']['points']);
        $this->assertEquals(10, $result[2]['statistics']['points']);
    }

    public function testValidateRequiredStringThrowsOnEmpty(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('game_id is required');

        $this->base->testValidateRequiredString('', 'game_id');
    }

    public function testValidateRequiredStringPassesOnValid(): void
    {
        // Should not throw
        $this->base->testValidateRequiredString('0022301214', 'game_id');
        $this->assertTrue(true);
    }

    public function testValidatePositiveIntThrowsOnZero(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('team_id must be a positive integer');

        $this->base->testValidatePositiveInt(0, 'team_id');
    }

    public function testValidatePositiveIntThrowsOnNegative(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->base->testValidatePositiveInt(-1, 'team_id');
    }

    public function testGetNestedValueReturnsValue(): void
    {
        $array = [
            'level1' => [
                'level2' => [
                    'value' => 'found'
                ]
            ]
        ];

        $result = $this->base->testGetNestedValue($array, ['level1', 'level2', 'value']);
        $this->assertEquals('found', $result);
    }

    public function testGetNestedValueReturnsDefault(): void
    {
        $array = ['level1' => ['level2' => []]];

        $result = $this->base->testGetNestedValue($array, ['level1', 'level2', 'missing'], 'default');
        $this->assertEquals('default', $result);
    }

    public function testConstants(): void
    {
        $this->assertEquals('2024-25', NBABase::CURRENT_SEASON);
        $this->assertEquals('2023-24', NBABase::PREVIOUS_SEASON);
        $this->assertEquals('PerGame', NBABase::MODE_PER_GAME);
        $this->assertEquals('Totals', NBABase::MODE_TOTAL);
        $this->assertEquals('Per48', NBABase::MODE_PER48);
        $this->assertEquals('INACTIVE', NBABase::STATUS_INACTIVE);
        $this->assertEquals('ACTIVE', NBABase::STATUS_ACTIVE);
        $this->assertEquals(1, NBABase::GAME_STATUS_NOT_STARTED);
        $this->assertEquals(2, NBABase::GAME_STATUS_IN_PROGRESS);
        $this->assertEquals(3, NBABase::GAME_STATUS_COMPLETED);
        $this->assertEquals(720, NBABase::QUARTER_DURATION_SECONDS);
        $this->assertEquals(300, NBABase::OT_DURATION_SECONDS);
    }
}
