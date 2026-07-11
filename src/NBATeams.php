<?php

declare(strict_types=1);

namespace Corbpie\NBALive;

/**
 * Static catalog of the 30 NBA teams with common lookups.
 */
final class NBATeams
{
    /**
     * @return list<array{id: int, abbr: string, name: string, city: string, full_name: string, conference: string, division: string}>
     */
    public static function all(): array
    {
        return [
            ['id' => 1610612737, 'abbr' => 'ATL', 'name' => 'Hawks', 'city' => 'Atlanta', 'full_name' => 'Atlanta Hawks', 'conference' => 'East', 'division' => 'Southeast'],
            ['id' => 1610612738, 'abbr' => 'BOS', 'name' => 'Celtics', 'city' => 'Boston', 'full_name' => 'Boston Celtics', 'conference' => 'East', 'division' => 'Atlantic'],
            ['id' => 1610612751, 'abbr' => 'BKN', 'name' => 'Nets', 'city' => 'Brooklyn', 'full_name' => 'Brooklyn Nets', 'conference' => 'East', 'division' => 'Atlantic'],
            ['id' => 1610612766, 'abbr' => 'CHA', 'name' => 'Hornets', 'city' => 'Charlotte', 'full_name' => 'Charlotte Hornets', 'conference' => 'East', 'division' => 'Southeast'],
            ['id' => 1610612741, 'abbr' => 'CHI', 'name' => 'Bulls', 'city' => 'Chicago', 'full_name' => 'Chicago Bulls', 'conference' => 'East', 'division' => 'Central'],
            ['id' => 1610612739, 'abbr' => 'CLE', 'name' => 'Cavaliers', 'city' => 'Cleveland', 'full_name' => 'Cleveland Cavaliers', 'conference' => 'East', 'division' => 'Central'],
            ['id' => 1610612742, 'abbr' => 'DAL', 'name' => 'Mavericks', 'city' => 'Dallas', 'full_name' => 'Dallas Mavericks', 'conference' => 'West', 'division' => 'Southwest'],
            ['id' => 1610612743, 'abbr' => 'DEN', 'name' => 'Nuggets', 'city' => 'Denver', 'full_name' => 'Denver Nuggets', 'conference' => 'West', 'division' => 'Northwest'],
            ['id' => 1610612765, 'abbr' => 'DET', 'name' => 'Pistons', 'city' => 'Detroit', 'full_name' => 'Detroit Pistons', 'conference' => 'East', 'division' => 'Central'],
            ['id' => 1610612744, 'abbr' => 'GSW', 'name' => 'Warriors', 'city' => 'Golden State', 'full_name' => 'Golden State Warriors', 'conference' => 'West', 'division' => 'Pacific'],
            ['id' => 1610612745, 'abbr' => 'HOU', 'name' => 'Rockets', 'city' => 'Houston', 'full_name' => 'Houston Rockets', 'conference' => 'West', 'division' => 'Southwest'],
            ['id' => 1610612754, 'abbr' => 'IND', 'name' => 'Pacers', 'city' => 'Indiana', 'full_name' => 'Indiana Pacers', 'conference' => 'East', 'division' => 'Central'],
            ['id' => 1610612746, 'abbr' => 'LAC', 'name' => 'Clippers', 'city' => 'LA', 'full_name' => 'LA Clippers', 'conference' => 'West', 'division' => 'Pacific'],
            ['id' => 1610612747, 'abbr' => 'LAL', 'name' => 'Lakers', 'city' => 'Los Angeles', 'full_name' => 'Los Angeles Lakers', 'conference' => 'West', 'division' => 'Pacific'],
            ['id' => 1610612763, 'abbr' => 'MEM', 'name' => 'Grizzlies', 'city' => 'Memphis', 'full_name' => 'Memphis Grizzlies', 'conference' => 'West', 'division' => 'Southwest'],
            ['id' => 1610612748, 'abbr' => 'MIA', 'name' => 'Heat', 'city' => 'Miami', 'full_name' => 'Miami Heat', 'conference' => 'East', 'division' => 'Southeast'],
            ['id' => 1610612749, 'abbr' => 'MIL', 'name' => 'Bucks', 'city' => 'Milwaukee', 'full_name' => 'Milwaukee Bucks', 'conference' => 'East', 'division' => 'Central'],
            ['id' => 1610612750, 'abbr' => 'MIN', 'name' => 'Timberwolves', 'city' => 'Minnesota', 'full_name' => 'Minnesota Timberwolves', 'conference' => 'West', 'division' => 'Northwest'],
            ['id' => 1610612740, 'abbr' => 'NOP', 'name' => 'Pelicans', 'city' => 'New Orleans', 'full_name' => 'New Orleans Pelicans', 'conference' => 'West', 'division' => 'Southwest'],
            ['id' => 1610612752, 'abbr' => 'NYK', 'name' => 'Knicks', 'city' => 'New York', 'full_name' => 'New York Knicks', 'conference' => 'East', 'division' => 'Atlantic'],
            ['id' => 1610612760, 'abbr' => 'OKC', 'name' => 'Thunder', 'city' => 'Oklahoma City', 'full_name' => 'Oklahoma City Thunder', 'conference' => 'West', 'division' => 'Northwest'],
            ['id' => 1610612753, 'abbr' => 'ORL', 'name' => 'Magic', 'city' => 'Orlando', 'full_name' => 'Orlando Magic', 'conference' => 'East', 'division' => 'Southeast'],
            ['id' => 1610612755, 'abbr' => 'PHI', 'name' => '76ers', 'city' => 'Philadelphia', 'full_name' => 'Philadelphia 76ers', 'conference' => 'East', 'division' => 'Atlantic'],
            ['id' => 1610612756, 'abbr' => 'PHX', 'name' => 'Suns', 'city' => 'Phoenix', 'full_name' => 'Phoenix Suns', 'conference' => 'West', 'division' => 'Pacific'],
            ['id' => 1610612757, 'abbr' => 'POR', 'name' => 'Trail Blazers', 'city' => 'Portland', 'full_name' => 'Portland Trail Blazers', 'conference' => 'West', 'division' => 'Northwest'],
            ['id' => 1610612758, 'abbr' => 'SAC', 'name' => 'Kings', 'city' => 'Sacramento', 'full_name' => 'Sacramento Kings', 'conference' => 'West', 'division' => 'Pacific'],
            ['id' => 1610612759, 'abbr' => 'SAS', 'name' => 'Spurs', 'city' => 'San Antonio', 'full_name' => 'San Antonio Spurs', 'conference' => 'West', 'division' => 'Southwest'],
            ['id' => 1610612761, 'abbr' => 'TOR', 'name' => 'Raptors', 'city' => 'Toronto', 'full_name' => 'Toronto Raptors', 'conference' => 'East', 'division' => 'Atlantic'],
            ['id' => 1610612762, 'abbr' => 'UTA', 'name' => 'Jazz', 'city' => 'Utah', 'full_name' => 'Utah Jazz', 'conference' => 'West', 'division' => 'Northwest'],
            ['id' => 1610612764, 'abbr' => 'WAS', 'name' => 'Wizards', 'city' => 'Washington', 'full_name' => 'Washington Wizards', 'conference' => 'East', 'division' => 'Southeast'],
        ];
    }

    /**
     * @return array{id: int, abbr: string, name: string, city: string, full_name: string, conference: string, division: string}|null
     */
    public static function findById(int $teamId): ?array
    {
        foreach (self::all() as $team) {
            if ($team['id'] === $teamId) {
                return $team;
            }
        }

        return null;
    }

    /**
     * @return array{id: int, abbr: string, name: string, city: string, full_name: string, conference: string, division: string}|null
     */
    public static function findByAbbreviation(string $abbr): ?array
    {
        $abbr = strtoupper(trim($abbr));

        foreach (self::all() as $team) {
            if ($team['abbr'] === $abbr) {
                return $team;
            }
        }

        return null;
    }

    /**
     * Case-insensitive match against abbreviation, name, city, or full name.
     *
     * @return array{id: int, abbr: string, name: string, city: string, full_name: string, conference: string, division: string}|null
     */
    public static function find(string $query): ?array
    {
        $query = strtolower(trim($query));

        foreach (self::all() as $team) {
            if (
                strtolower($team['abbr']) === $query
                || strtolower($team['name']) === $query
                || strtolower($team['city']) === $query
                || strtolower($team['full_name']) === $query
            ) {
                return $team;
            }
        }

        return null;
    }

    /**
     * @return list<array{id: int, abbr: string, name: string, city: string, full_name: string, conference: string, division: string}>
     */
    public static function byConference(string $conference): array
    {
        $conference = ucfirst(strtolower(trim($conference)));

        return array_values(array_filter(
            self::all(),
            static fn (array $team): bool => $team['conference'] === $conference
        ));
    }

    /**
     * @return list<array{id: int, abbr: string, name: string, city: string, full_name: string, conference: string, division: string}>
     */
    public static function byDivision(string $division): array
    {
        $division = strtolower(trim($division));

        return array_values(array_filter(
            self::all(),
            static fn (array $team): bool => strtolower($team['division']) === $division
        ));
    }

    /**
     * @return array<int, string> team_id => abbreviation
     */
    public static function idToAbbreviationMap(): array
    {
        $map = [];

        foreach (self::all() as $team) {
            $map[$team['id']] = $team['abbr'];
        }

        return $map;
    }
}
