<?php

declare(strict_types=1);

namespace Corbpie\NBALive;

/**
 * Maps NBA stats API resultSet rows to associative arrays using header names.
 */
final class ResultSetMapper
{
    /**
     * Map a single resultSet to an array of associative rows.
     *
     * @param array<string, mixed> $resultSet
     * @return list<array<string, mixed>>
     */
    public static function mapRows(array $resultSet): array
    {
        $headers = $resultSet['headers'] ?? [];

        if ($headers === []) {
            return [];
        }

        $rows = [];

        foreach ($resultSet['rowSet'] ?? [] as $row) {
            if (!is_array($row)) {
                continue;
            }

            $mapped = [];

            foreach ($headers as $index => $header) {
                if (!is_string($header)) {
                    continue;
                }

                $mapped[$header] = $row[$index] ?? null;
            }

            $rows[] = $mapped;
        }

        return $rows;
    }

    /**
     * Map the first resultSet in a stats API response.
     *
     * @param array<string, mixed> $response
     * @return list<array<string, mixed>>
     */
    public static function mapFirstResultSet(array $response): array
    {
        $resultSet = $response['resultSets'][0] ?? null;

        if (!is_array($resultSet)) {
            return [];
        }

        return self::mapRows($resultSet);
    }
}
