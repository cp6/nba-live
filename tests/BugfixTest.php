<?php

declare(strict_types=1);

namespace Corbpie\NBALive\Tests;

use Corbpie\NBALive\Dto\TeamStanding;
use Corbpie\NBALive\Http\NbaHttpResponse;
use Corbpie\NBALive\NBABoxScoreFilters;
use Corbpie\NBALive\NBADashFilters;
use Corbpie\NBALive\NBALeagueDashFilters;
use Corbpie\NBALive\NBAPlayoffPicture;
use Corbpie\NBALive\NBASchedule;
use Corbpie\NBALive\NBATeamEstimated;
use Corbpie\NBALive\NBATeamGameLogs;
use Corbpie\NBALive\NBAToday;
use Corbpie\NBALive\Season;
use PHPUnit\Framework\TestCase;

final class BugfixTest extends TestCase
{
    public function testTeamStandingToArrayUsesConsistentKey(): void
    {
        $standing = TeamStanding::fromResultSetRow([
            'TeamID' => 1,
            'TeamName' => 'Pacers',
            'BehindAtHalf' => '10-5',
        ], 1);

        $this->assertArrayHasKey('behind_at_half', $standing->toArray());
        $this->assertArrayNotHasKey('behind_at_Half', $standing->toArray());
    }

    public function testTeamGameLogsValidatesUninitializedTeamId(): void
    {
        $logs = new NBATeamGameLogs();

        $this->expectException(\InvalidArgumentException::class);
        $logs->fetch();
    }

    public function testTeamEstimatedGuardsMissingResultSetAndResetsTeams(): void
    {
        $mock = new MockNbaHttpClient();
        $url = 'https://stats.nba.com/stats/teamestimatedmetrics?LeagueID=00&Season=2025-26&SeasonType=Regular%2BSeason';
        $body = json_encode([
            'resultSet' => [
                'headers' => ['TEAM_NAME', 'TEAM_ID', 'GP', 'W', 'L', 'W_PCT', 'MIN', 'E_OFF_RATING', 'E_DEF_RATING', 'E_NET_RATING', 'E_PACE', 'E_AST_RATIO', 'E_OREB_PCT', 'E_DREB_PCT', 'E_REB_PCT', 'E_TM_TOV_PCT', 'GP_RANK', 'W_RANK', 'L_RANK', 'W_PCT_RANK', 'MIN_RANK', 'E_OFF_RATING_RANK', 'E_DEF_RATING_RANK', 'E_NET_RATING_RANK', 'E_AST_RATIO_RANK', 'E_OREB_PCT_RANK', 'E_DREB_PCT_RANK', 'E_REB_PCT_RANK', 'E_TM_TOV_PCT_RANK', 'E_PACE_RANK'],
                'rowSet' => [
                    ['Pacers', 1610612754, 10, 6, 4, 0.6, 480, 110.0, 105.0, 5.0, 100.0, 18.5, 0.25, 0.75, 0.5, 0.12, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1],
                ],
            ],
        ], JSON_THROW_ON_ERROR);

        $mock->register($url, new NbaHttpResponse($url, 200, $body, strlen($body), 0.01, '127.0.0.1'));

        $endpoint = new NBATeamEstimated(httpClient: $mock);
        $this->assertCount(1, $endpoint->teams);
        $this->assertArrayHasKey('e_ast_ratio', $endpoint->teams[0]);
        $this->assertArrayNotHasKey('e_ast_ration', $endpoint->teams[0]);

        $endpoint->fetch();
        $this->assertCount(1, $endpoint->teams);
    }

    public function testTeamEstimatedHandlesEmptyPayload(): void
    {
        $mock = new MockNbaHttpClient();
        $url = 'https://stats.nba.com/stats/teamestimatedmetrics?LeagueID=00&Season=2025-26&SeasonType=Regular%2BSeason';
        $mock->register($url, new NbaHttpResponse($url, 200, '{}', 2, 0.01, '127.0.0.1'));

        $endpoint = new NBATeamEstimated(httpClient: $mock);
        $this->assertSame([], $endpoint->teams);
    }

    public function testPlayoffPictureParsesAllResultSetsAndWestIndexes(): void
    {
        $mock = new MockNbaHttpClient();
        $url = 'https://stats.nba.com/stats/playoffpicture?LeagueID=00&SeasonID=22025';
        $body = json_encode([
            'resultSets' => [
                [
                    'name' => 'EastConfPlayoffPicture',
                    'headers' => ['CONFERENCE', 'HIGH_SEED_RANK', 'HIGH_SEED_TEAM', 'HIGH_SEED_TEAM_ID', 'LOW_SEED_RANK', 'LOW_SEED_TEAM', 'LOW_SEED_TEAM_ID', 'HIGH_SEED_SERIES_W', 'HIGH_SEED_SERIES_L', 'HIGH_SEED_SERIES_REMAINING_G', 'HIGH_SEED_SERIES_REMAINING_HOME_G', 'HIGH_SEED_SERIES_REMAINING_AWAY_G'],
                    'rowSet' => [['East', 1, 'BOS', 1, 8, 'ATL', 2, 0, 0, 0, 0, 0]],
                ],
                [
                    'name' => 'WestConfPlayoffPicture',
                    'headers' => ['CONFERENCE', 'HIGH_SEED_RANK', 'HIGH_SEED_TEAM', 'HIGH_SEED_TEAM_ID', 'LOW_SEED_RANK', 'LOW_SEED_TEAM', 'LOW_SEED_TEAM_ID', 'HIGH_SEED_SERIES_W', 'HIGH_SEED_SERIES_L', 'HIGH_SEED_SERIES_REMAINING_G', 'HIGH_SEED_SERIES_REMAINING_HOME_G', 'HIGH_SEED_SERIES_REMAINING_AWAY_G'],
                    'rowSet' => [['West', 1, 'OKC', 3, 8, 'SAC', 4, 0, 0, 0, 0, 0]],
                ],
                [
                    'name' => 'EastConfStandings',
                    'headers' => ['CONFERENCE', 'RANK', 'TEAM', 'TEAM_SLUG', 'TEAM_ID', 'WINS', 'LOSSES', 'PCT', 'DIV', 'CONF', 'HOME', 'AWAY', 'GB', 'GR_OVER_500', 'GR_OVER_500_HOME', 'GR_OVER_500_AWAY', 'GR_UNDER_500', 'GR_UNDER_500_HOME', 'GR_UNDER_500_AWAY', 'RANKING_CRITERIA', 'CLINCHED_PLAYOFFS', 'CLINCHED_CONFERENCE', 'CLINCHED_DIVISION', 'Clinched_Play_In', 'ELIMINATED_PLAYOFFS', 'SOSA_REMAINING'],
                    'rowSet' => [['East', 1, 'Celtics', 'celtics', 1, 50, 20, 0.714, '0-0', '0-0', '0-0', '0-0', 0, 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0]],
                ],
                [
                    'name' => 'WestConfStandings',
                    'headers' => ['CONFERENCE', 'RANK', 'TEAM', 'TEAM_SLUG', 'TEAM_ID', 'WINS', 'LOSSES', 'PCT', 'DIV', 'CONF', 'HOME', 'AWAY', 'GB', 'GR_OVER_500', 'GR_OVER_500_HOME', 'GR_OVER_500_AWAY', 'GR_UNDER_500', 'GR_UNDER_500_HOME', 'GR_UNDER_500_AWAY', 'RANKING_CRITERIA', 'CLINCHED_PLAYOFFS', 'CLINCHED_CONFERENCE', 'CLINCHED_DIVISION', 'Clinched_Play_In', 'ELIMINATED_PLAYOFFS', 'SOSA_REMAINING'],
                    'rowSet' => [['West', 1, 'Thunder', 'thunder', 3, 55, 15, 0.786, '0-0', '0-0', '0-0', '0-0', 0, 0, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0]],
                ],
                [
                    'name' => 'EastConfRemainingGames',
                    'headers' => ['TEAM', 'TEAM_ID', 'REMAINING_G', 'REMAINING_HOME_G', 'REMAINING_AWAY_G'],
                    'rowSet' => [['Celtics', 1, 12, 6, 6]],
                ],
                [
                    'name' => 'WestConfRemainingGames',
                    'headers' => ['TEAM', 'TEAM_ID', 'REMAINING_G', 'REMAINING_HOME_G', 'REMAINING_AWAY_G'],
                    'rowSet' => [['Thunder', 3, 12, 7, 5]],
                ],
            ],
        ], JSON_THROW_ON_ERROR);

        $mock->register($url, new NbaHttpResponse($url, 200, $body, strlen($body), 0.01, '127.0.0.1'));

        $picture = new NBAPlayoffPicture('22025', $mock);

        $this->assertSame(1, $picture->east_conf_playoff_picture[0]['high_seed_rank']);
        $this->assertSame(1, $picture->west_conf_playoff_picture[0]['high_seed_rank']);
        $this->assertSame('Celtics', $picture->east_conf_standings[0]['team']);
        $this->assertSame('Thunder', $picture->west_conf_standings[0]['team']);
        $this->assertSame(12, $picture->east_conf_remaining_games[0]['remaining_g']);
        $this->assertSame(5, $picture->west_conf_remaining_games[0]['remaining_away_g']);

        $picture->fetch('22025');
        $this->assertCount(1, $picture->east_conf_standings);
    }

    public function testScheduleForTeamFiltersAndFetchResets(): void
    {
        $mock = new MockNbaHttpClient();
        $url = 'https://stats.nba.com/stats/scoreboardv2?DayOffset=0&GameDate=2026-01-15&LeagueID=00';
        $body = json_encode([
            'resultSets' => [
                [
                    'headers' => [],
                    'rowSet' => [
                        ['2026-01-15T00:00:00', 1, '0022500999', 1, '7:00 pm ET', '20260115/INDNYK', 1610612754, 1610612752, 0, 0, 0, 0, 0, 0, 0, 'MSG'],
                        ['2026-01-15T00:00:00', 2, '0022501000', 1, '7:30 pm ET', '20260115/BOSLAL', 1610612738, 1610612747, 0, 0, 0, 0, 0, 0, 0, 'TD Garden'],
                    ],
                ],
            ],
        ], JSON_THROW_ON_ERROR);
        $mock->register($url, new NbaHttpResponse($url, 200, $body, strlen($body), 0.01, '127.0.0.1'));

        $schedule = new NBASchedule('2026-01-15', $mock);
        $this->assertCount(2, $schedule->schedule);

        $filtered = $schedule->forTeam(1610612754);
        $this->assertCount(1, $filtered);
        $this->assertSame('0022500999', $filtered[0]['game_id']);

        $schedule->fetch('2026-01-15');
        $this->assertCount(2, $schedule->schedule);
    }

    public function testTodayFetchReturnsPayloadAndResetsBuckets(): void
    {
        $mock = new MockNbaHttpClient();
        $url = 'https://cdn.nba.com/static/json/liveData/scoreboard/todaysScoreboard_00.json';
        $body = json_encode([
            'scoreboard' => [
                'gameDate' => '2026-01-15',
                'games' => [
                    ['gameStatus' => 2, 'gameId' => '1'],
                    ['gameStatus' => 3, 'gameId' => '2'],
                    ['gameStatus' => 1, 'gameId' => '3'],
                ],
            ],
        ], JSON_THROW_ON_ERROR);
        $mock->register($url, new NbaHttpResponse($url, 200, $body, strlen($body), 0.01, '127.0.0.1'));

        $today = new NBAToday($mock);
        $payload = $today->fetch();

        $this->assertArrayHasKey('scoreboard', $payload);
        $this->assertCount(1, $today->live_games);
        $this->assertCount(1, $today->completed_games);
        $this->assertCount(1, $today->upcoming_games);
    }

    public function testSeasonConstantsAlignWithNBABaseDefaults(): void
    {
        $this->assertSame(Season::CURRENT, \Corbpie\NBALive\NBABase::CURRENT_SEASON);
        $this->assertSame(Season::PREVIOUS, \Corbpie\NBALive\NBABase::PREVIOUS_SEASON);
    }

    public function testFilterBasesUseEncodedSeasonTypeAndFilterEmptyParams(): void
    {
        $dash = new NBADashFilters();
        $this->assertStringContainsString('SeasonType=Regular%2BSeason', $dash->build());
        $this->assertStringNotContainsString('DateFrom=', $dash->build());

        $league = new NBALeagueDashFilters();
        $this->assertStringContainsString('SeasonType=Regular%2BSeason', $league->build());
        $this->assertStringNotContainsString('College=', $league->build());
    }

    public function testBoxScoreFiltersPropertyIsUsedConsistently(): void
    {
        $filters = new class extends NBABoxScoreFilters {
            public function exposeFilters(): string
            {
                return $this->filters;
            }
        };

        $this->assertSame($filters->build(), $filters->exposeFilters());
        $filters->end_period = 1;
        $filters->applyFilters();
        $this->assertStringContainsString('endPeriod=1', $filters->exposeFilters());
    }
}
