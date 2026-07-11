<?php

declare(strict_types=1);

namespace Corbpie\NBALive\Tests;

use Corbpie\NBALive\Http\NbaHttpResponse;
use Corbpie\NBALive\Http\RetryNbaHttpClient;
use Corbpie\NBALive\NBAApiException;
use Corbpie\NBALive\NBACommonPlayerInfo;
use Corbpie\NBALive\NBALeagueDashPlayerStats;
use Corbpie\NBALive\NBALeagueDashTeamStats;
use Corbpie\NBALive\NBAScoreboard;
use Corbpie\NBALive\NBATeamPlayerDashboard;
use Corbpie\NBALive\NBATeams;
use PHPUnit\Framework\TestCase;

final class NewFeaturesTest extends TestCase
{
    public function testTeamsCatalogLookups(): void
    {
        $this->assertCount(30, NBATeams::all());
        $this->assertSame('IND', NBATeams::findById(1610612754)['abbr'] ?? null);
        $this->assertSame(1610612738, NBATeams::findByAbbreviation('bos')['id'] ?? null);
        $this->assertSame('LAL', NBATeams::find('lakers')['abbr'] ?? null);
        $this->assertCount(15, NBATeams::byConference('East'));
        $this->assertCount(5, NBATeams::byDivision('Pacific'));
    }

    public function testRetryClientRetriesThenSucceeds(): void
    {
        $inner = new class implements \Corbpie\NBALive\Http\NbaHttpClientInterface {
            public int $calls = 0;

            public function get(string $url): NbaHttpResponse
            {
                $this->calls++;

                if ($this->calls < 3) {
                    throw new NBAApiException('temporary', 28);
                }

                return new NbaHttpResponse($url, 200, '{"ok":true}', 10, 0.01, '127.0.0.1');
            }
        };

        $client = new RetryNbaHttpClient($inner, maxAttempts: 3, baseDelayMs: 1);
        $response = $client->get('https://example.test/retry');

        $this->assertSame(200, $response->statusCode);
        $this->assertSame(3, $inner->calls);
    }

    public function testRetryClientRetriesHttpStatusThenReturns(): void
    {
        $inner = new class implements \Corbpie\NBALive\Http\NbaHttpClientInterface {
            public int $calls = 0;

            public function get(string $url): NbaHttpResponse
            {
                $this->calls++;

                if ($this->calls === 1) {
                    return new NbaHttpResponse($url, 503, 'busy', 4, 0.01, '127.0.0.1');
                }

                return new NbaHttpResponse($url, 200, '{"ok":true}', 10, 0.01, '127.0.0.1');
            }
        };

        $client = new RetryNbaHttpClient($inner, maxAttempts: 3, baseDelayMs: 1);
        $response = $client->get('https://example.test/status');

        $this->assertSame(200, $response->statusCode);
        $this->assertSame(2, $inner->calls);
    }

    public function testLeagueDashPlayerStatsMapsRowsAndLeaders(): void
    {
        $mock = new MockNbaHttpClient();
        $endpoint = new NBALeagueDashPlayerStats($mock);
        $query = (new \ReflectionClass($endpoint))->getMethod('playerStatsQuery');
        $query->setAccessible(true);
        $url = 'https://stats.nba.com/stats/leaguedashplayerstats?' . $query->invoke($endpoint);

        $body = json_encode([
            'resultSets' => [[
                'headers' => ['PLAYER_ID', 'PLAYER_NAME', 'TEAM_ID', 'TEAM_ABBREVIATION', 'AGE', 'GP', 'W', 'L', 'W_PCT', 'MIN', 'FGM', 'FGA', 'FG_PCT', 'FG3M', 'FG3A', 'FG3_PCT', 'FTM', 'FTA', 'FT_PCT', 'OREB', 'DREB', 'REB', 'AST', 'TOV', 'STL', 'BLK', 'BLKA', 'PF', 'PFD', 'PTS', 'PLUS_MINUS', 'NBA_FANTASY_PTS', 'DD2', 'TD3'],
                'rowSet' => [
                    [1, 'Player A', 1610612754, 'IND', 25, 10, 6, 4, 0.6, 32, 8, 16, 0.5, 2, 5, 0.4, 4, 5, 0.8, 1, 4, 5, 6, 2, 1, 1, 0, 2, 3, 22, 5, 30, 1, 0],
                    [2, 'Player B', 1610612738, 'BOS', 28, 10, 7, 3, 0.7, 30, 10, 18, 0.55, 3, 7, 0.42, 5, 6, 0.83, 2, 5, 7, 4, 3, 2, 0, 1, 3, 4, 28, 8, 35, 2, 1],
                ],
            ]],
        ], JSON_THROW_ON_ERROR);

        $mock->register($url, new NbaHttpResponse($url, 200, $body, strlen($body), 0.01, '127.0.0.1'));
        $endpoint->fetch();

        $this->assertCount(2, $endpoint->players);
        $this->assertSame(28, $endpoint->leaders('pts', 1)[0]['pts']);
    }

    public function testLeagueDashTeamStatsMapsRows(): void
    {
        $mock = new MockNbaHttpClient();
        $endpoint = new NBALeagueDashTeamStats($mock);
        $query = (new \ReflectionClass($endpoint))->getMethod('teamStatsQuery');
        $query->setAccessible(true);
        $url = 'https://stats.nba.com/stats/leaguedashteamstats?' . $query->invoke($endpoint);

        $body = json_encode([
            'resultSets' => [[
                'headers' => ['TEAM_ID', 'TEAM_NAME', 'GP', 'W', 'L', 'W_PCT', 'MIN', 'FGM', 'FGA', 'FG_PCT', 'FG3M', 'FG3A', 'FG3_PCT', 'FTM', 'FTA', 'FT_PCT', 'OREB', 'DREB', 'REB', 'AST', 'TOV', 'STL', 'BLK', 'BLKA', 'PF', 'PFD', 'PTS', 'PLUS_MINUS'],
                'rowSet' => [
                    [1610612754, 'Pacers', 10, 6, 4, 0.6, 240, 40, 88, 0.45, 12, 34, 0.35, 18, 22, 0.82, 10, 34, 44, 25, 13, 8, 5, 4, 18, 20, 110, 4],
                ],
            ]],
        ], JSON_THROW_ON_ERROR);

        $mock->register($url, new NbaHttpResponse($url, 200, $body, strlen($body), 0.01, '127.0.0.1'));
        $endpoint->fetch();

        $this->assertSame('Pacers', $endpoint->teams[0]['team_name']);
        $this->assertSame(110, $endpoint->teams[0]['pts']);
    }

    public function testTeamPlayerDashboardRequiresTeamIdAndMapsPlayers(): void
    {
        $mock = new MockNbaHttpClient();
        $endpoint = new NBATeamPlayerDashboard($mock);
        $endpoint->team_id = 1610612754;

        $url = 'https://stats.nba.com/stats/teamplayerdashboard?' . $endpoint->build();
        $body = json_encode([
            'resultSets' => [
                [
                    'headers' => ['GROUP_SET', 'TEAM_ID', 'TEAM_NAME', 'GROUP_VALUE', 'GP', 'W', 'L', 'W_PCT', 'MIN', 'FGM', 'FGA', 'FG_PCT', 'FG3M', 'FG3A', 'FG3_PCT', 'FTM', 'FTA', 'FT_PCT', 'OREB', 'DREB', 'REB', 'AST', 'TOV', 'STL', 'BLK', 'BLKA', 'PF', 'PFD', 'PTS', 'PLUS_MINUS'],
                    'rowSet' => [['Overall', 1610612754, 'Pacers', '2025-26', 10, 6, 4, 0.6, 240, 40, 88, 0.45, 12, 34, 0.35, 18, 22, 0.82, 10, 34, 44, 25, 13, 8, 5, 4, 18, 20, 110, 4]],
                ],
                [
                    'headers' => ['GROUP_SET', 'PLAYER_ID', 'PLAYER_NAME', 'GP', 'W', 'L', 'W_PCT', 'MIN', 'FGM', 'FGA', 'FG_PCT', 'FG3M', 'FG3A', 'FG3_PCT', 'FTM', 'FTA', 'FT_PCT', 'OREB', 'DREB', 'REB', 'AST', 'TOV', 'STL', 'BLK', 'BLKA', 'PF', 'PFD', 'PTS', 'PLUS_MINUS', 'NBA_FANTASY_PTS', 'DD2', 'TD3'],
                    'rowSet' => [['Players', 203999, 'Star Player', 10, 6, 4, 0.6, 34, 9, 18, 0.5, 1, 4, 0.25, 5, 6, 0.83, 2, 8, 10, 8, 3, 1, 1, 0, 2, 4, 24, 6, 40, 3, 0]],
                ],
            ],
        ], JSON_THROW_ON_ERROR);

        $mock->register($url, new NbaHttpResponse($url, 200, $body, strlen($body), 0.01, '127.0.0.1'));
        $endpoint->fetch();

        $this->assertSame('Pacers', $endpoint->team_overall['team_name']);
        $this->assertSame('Star Player', $endpoint->players[0]['player_name']);
    }

    public function testCommonPlayerInfoParsesBioAndHeadline(): void
    {
        $mock = new MockNbaHttpClient();
        $url = 'https://stats.nba.com/stats/commonplayerinfo?LeagueID=00&PlayerID=203999';
        $body = json_encode([
            'resultSets' => [
                [
                    'name' => 'CommonPlayerInfo',
                    'headers' => ['PERSON_ID', 'FIRST_NAME', 'LAST_NAME', 'DISPLAY_FIRST_LAST', 'DISPLAY_LAST_COMMA_FIRST', 'DISPLAY_FI_LAST', 'PLAYER_SLUG', 'BIRTHDATE', 'SCHOOL', 'COUNTRY', 'LAST_AFFILIATION', 'HEIGHT', 'WEIGHT', 'SEASON_EXP', 'JERSEY', 'POSITION', 'ROSTERSTATUS', 'TEAM_ID', 'TEAM_NAME', 'TEAM_ABBREVIATION', 'TEAM_CODE', 'TEAM_CITY', 'PLAYERCODE', 'FROM_YEAR', 'TO_YEAR', 'DLEAGUE_FLAG', 'NBA_FLAG', 'GAMES_PLAYED_FLAG', 'DRAFT_YEAR', 'DRAFT_ROUND', 'DRAFT_NUMBER'],
                    'rowSet' => [[203999, 'Nikola', 'Jokic', 'Nikola Jokic', 'Jokic, Nikola', 'N. Jokic', 'nikola-jokic', '1995-02-19T00:00:00', 'Mega Basket', 'Serbia', 'Serbia', '6-11', '284', 10, '15', 'Center', 'Active', 1610612743, 'Nuggets', 'DEN', 'nuggets', 'Denver', 'nikola_jokic', 2015, 2025, 'N', 'Y', 'Y', '2014', '2', '41']],
                ],
                [
                    'name' => 'PlayerHeadlineStats',
                    'headers' => ['PLAYER_ID', 'PLAYER_NAME', 'TimeFrame', 'PTS', 'AST', 'REB', 'PIE'],
                    'rowSet' => [[203999, 'Nikola Jokic', '2025-26', 28.5, 9.1, 12.2, 0.2]],
                ],
                [
                    'name' => 'AvailableSeasons',
                    'headers' => ['SEASON_ID'],
                    'rowSet' => [['22024'], ['22025']],
                ],
            ],
        ], JSON_THROW_ON_ERROR);

        $mock->register($url, new NbaHttpResponse($url, 200, $body, strlen($body), 0.01, '127.0.0.1'));
        $info = new NBACommonPlayerInfo(203999, $mock);

        $this->assertSame('Nikola Jokic', $info->info['display_name']);
        $this->assertSame(28.5, $info->headline_stats['pts']);
        $this->assertSame(['22024', '22025'], $info->available_seasons);
    }

    public function testScoreboardParsesGamesAndLineScores(): void
    {
        $mock = new MockNbaHttpClient();
        $url = 'https://stats.nba.com/stats/scoreboardv2?DayOffset=0&GameDate=2026-01-15&LeagueID=00';
        $body = json_encode([
            'resultSets' => [
                [
                    'headers' => ['GAME_DATE_EST', 'GAME_SEQUENCE', 'GAME_ID', 'GAME_STATUS_ID', 'GAME_STATUS_TEXT', 'GAMECODE', 'HOME_TEAM_ID', 'VISITOR_TEAM_ID', 'SEASON', 'LIVE_PERIOD', 'LIVE_PC_TIME', 'NATL_TV_BROADCASTER_ABBREVIATION', 'HOME_TV_BROADCASTER_ABBREVIATION', 'AWAY_TV_BROADCASTER_ABBREVIATION', 'ARENA_NAME'],
                    'rowSet' => [['2026-01-15T00:00:00', 1, '0022500999', 3, 'Final', '20260115/INDNYK', 1610612752, 1610612754, '2025', 4, '', 'ESPN', '', '', 'MSG']],
                ],
                [
                    'headers' => ['GAME_ID', 'TEAM_ID', 'TEAM_ABBREVIATION', 'TEAM_CITY_NAME', 'TEAM_NAME', 'TEAM_WINS_LOSSES', 'PTS_QTR1', 'PTS_QTR2', 'PTS_QTR3', 'PTS_QTR4', 'PTS_OT1', 'PTS', 'FG_PCT', 'FT_PCT', 'FG3_PCT', 'AST', 'REB', 'TOV'],
                    'rowSet' => [
                        ['0022500999', 1610612752, 'NYK', 'New York', 'Knicks', '30-12', 28, 30, 27, 25, 0, 110, 0.48, 0.8, 0.37, 24, 44, 12],
                        ['0022500999', 1610612754, 'IND', 'Indiana', 'Pacers', '28-14', 25, 28, 29, 24, 0, 106, 0.46, 0.78, 0.35, 22, 41, 14],
                    ],
                ],
                ['headers' => [], 'rowSet' => []],
                ['headers' => [], 'rowSet' => []],
                [
                    'headers' => ['TEAM_ID', 'LEAGUE_ID', 'SEASON_ID', 'STANDINGSDATE', 'CONFERENCE', 'TEAM', 'G', 'W', 'L', 'W_PCT', 'HOME_RECORD', 'ROAD_RECORD'],
                    'rowSet' => [[1610612752, '00', '22025', '01/15/2026', 'East', 'New York', 42, 30, 12, 0.714, '16-5', '14-7']],
                ],
                [
                    'headers' => ['TEAM_ID', 'LEAGUE_ID', 'SEASON_ID', 'STANDINGSDATE', 'CONFERENCE', 'TEAM', 'G', 'W', 'L', 'W_PCT', 'HOME_RECORD', 'ROAD_RECORD'],
                    'rowSet' => [[1610612747, '00', '22025', '01/15/2026', 'West', 'L.A. Lakers', 42, 25, 17, 0.595, '14-7', '11-10']],
                ],
            ],
        ], JSON_THROW_ON_ERROR);

        $mock->register($url, new NbaHttpResponse($url, 200, $body, strlen($body), 0.01, '127.0.0.1'));
        $board = new NBAScoreboard('2026-01-15', $mock);

        $this->assertCount(1, $board->games);
        $this->assertCount(2, $board->lineScoresForGame('0022500999'));
        $this->assertSame('New York', $board->east_standings[0]['team']);
        $this->assertSame('L.A. Lakers', $board->west_standings[0]['team']);
    }
}
