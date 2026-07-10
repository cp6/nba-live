<?php

declare(strict_types=1);

namespace Corbpie\NBALive;

/**
 * NBA season helpers based on the league calendar (season starts in October).
 */
final class Season
{
    /**
     * Canonical current season string for property/constructor defaults.
     * Prefer current() when resolving relative to a specific date.
     */
    public const CURRENT = '2025-26';

    /** Canonical previous season string for property/constructor defaults. */
    public const PREVIOUS = '2024-25';

    /**
     * Resolve the current NBA season identifier (e.g. 2025-26).
     */
    public static function current(?\DateTimeInterface $date = null): string
    {
        $date ??= new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
        $year = (int) $date->format('Y');
        $month = (int) $date->format('n');
        $startYear = $month >= 10 ? $year : $year - 1;

        return self::format($startYear);
    }

    /**
     * Resolve the previous NBA season identifier.
     */
    public static function previous(?\DateTimeInterface $date = null): string
    {
        $date ??= new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
        $year = (int) $date->format('Y');
        $month = (int) $date->format('n');
        $startYear = ($month >= 10 ? $year : $year - 1) - 1;

        return self::format($startYear);
    }

    private static function format(int $startYear): string
    {
        return sprintf('%d-%02d', $startYear, ($startYear + 1) % 100);
    }
}
