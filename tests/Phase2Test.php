<?php

declare(strict_types=1);

namespace Corbpie\NBALive\Tests;

use Corbpie\NBALive\Dto\LeagueGameEntry;
use Corbpie\NBALive\Dto\TeamGameLog;
use Corbpie\NBALive\Dto\TeamStanding;
use Corbpie\NBALive\Http\CachingNbaHttpClient;
use Corbpie\NBALive\Http\NbaHttpResponse;
use Corbpie\NBALive\NBABoxScore;
use PHPUnit\Framework\TestCase;

final class Phase2Test extends TestCase
{
    public function testCachesSuccessfulResponses(): void
    {
        $inner = new MockNbaHttpClient();
        $url = 'https://example.test/cached';
        $response = new NbaHttpResponse($url, 200, '{"ok":true}', 10, 0.01, '127.0.0.1');
        $inner->register($url, $response);

        $cache = new InMemoryCache();
        $client = new CachingNbaHttpClient($inner, $cache, 60);

        $first = $client->get($url);
        $second = $client->get($url);

        $this->assertSame('{"ok":true}', $first->body);
        $this->assertSame($first->body, $second->body);
        $this->assertSame(1, $cache->writes);
    }

    public function testTeamGameLogFromRow(): void
    {
        $entry = TeamGameLog::fromResultSetRow([
            'Game_ID' => '0022500123',
            'GAME_DATE' => '2026-01-15',
            'MATCHUP' => 'IND @ BOS',
            'WL' => 'W',
            'W' => 30,
            'L' => 12,
            'W_PCT' => 0.714,
            'MIN' => 240,
            'FGM' => 40,
            'FGA' => 85,
            'FG_PCT' => 0.471,
            'FG3M' => 12,
            'FG3A' => 32,
            'FG3_PCT' => 0.375,
            'FTM' => 18,
            'FTA' => 22,
            'FT_PCT' => 0.818,
            'OREB' => 10,
            'DREB' => 35,
            'REB' => 45,
            'AST' => 25,
            'STL' => 8,
            'BLK' => 5,
            'TOV' => 12,
            'PF' => 18,
            'PTS' => 110,
        ]);

        $this->assertSame('0022500123', $entry->gameId);
        $this->assertTrue($entry->wasWin);
        $this->assertSame(110, $entry->pts);
        $this->assertSame('0022500123', $entry->toArray()['game_id']);
    }

    public function testTeamStandingFromRow(): void
    {
        $standing = TeamStanding::fromResultSetRow([
            'TeamID' => 1610612754,
            'TeamName' => 'Pacers',
            'Conference' => 'East',
            'Division' => 'Central',
            'WINS' => 30,
            'LOSSES' => 15,
            'WinPCT' => 0.667,
        ], 3);

        $this->assertSame(3, $standing->leagueRank);
        $this->assertSame('East', $standing->conference);
        $this->assertSame(45, $standing->gp);
    }

    public function testLeagueGameEntryFromRow(): void
    {
        $game = LeagueGameEntry::fromResultSetRow([
            'SEASON_ID' => '22025',
            'TEAM_ID' => 1610612754,
            'TEAM_ABBREVIATION' => 'IND',
            'TEAM_NAME' => 'Pacers',
            'GAME_ID' => '0022500123',
            'GAME_DATE' => '2026-01-15',
            'MATCHUP' => 'IND @ BOS',
            'WL' => 'W',
            'MIN' => 240,
            'PTS' => 110,
            'FGM' => 40,
            'FGA' => 85,
            'FG_PCT' => 0.471,
            'FG3M' => 12,
            'FG3A' => 32,
            'FG3_PCT' => 0.375,
            'FTM' => 18,
            'FTA' => 22,
            'FT_PCT' => 0.818,
            'OREB' => 10,
            'DREB' => 35,
            'REB' => 45,
            'AST' => 25,
            'STL' => 8,
            'BLK' => 5,
            'TOV' => 12,
            'PF' => 18,
            'PLUS_MINUS' => 7,
        ]);

        $this->assertSame('IND', $game->teamAbbr);
        $this->assertSame(110, $game->toArray()['pts']);
    }

    public function testBoxScoreFetchWithoutConstructorSideEffect(): void
    {
        $mock = new MockNbaHttpClient();
        $mock->register(
            'https://cdn.nba.com/static/json/liveData/boxscore/boxscore_0022500123.json',
            new NbaHttpResponse(
                url: 'https://cdn.nba.com/static/json/liveData/boxscore/boxscore_0022500123.json',
                statusCode: 200,
                body: '{"game":{"homeTeam":{"teamId":1,"statistics":{},"players":[]},"awayTeam":{"teamId":2,"statistics":{},"players":[]}}}',
                size: 100,
                connectTime: 0.01,
                ip: '127.0.0.1',
            ),
        );

        $boxScore = new NBABoxScore(httpClient: $mock);
        $this->assertSame([], $boxScore->data);

        $boxScore->fetch('0022500123');
        $this->assertArrayHasKey('game', $boxScore->data);
        $this->assertSame(1, $boxScore->home_tid);
    }
}
