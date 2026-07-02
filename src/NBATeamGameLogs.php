<?php

declare(strict_types=1);

namespace Corbpie\NBALive;

use Corbpie\NBALive\Contracts\FetchableEndpoint;
use Corbpie\NBALive\Dto\TeamGameLog;
use Corbpie\NBALive\Http\NbaHttpClientInterface;

/**
 * Retrieve NBA team game logs for a season.
 */
final class NBATeamGameLogs extends NBABase implements FetchableEndpoint
{
    /** @var array<string, mixed> Raw API response data */
    public array $data = [];

    /** @var list<array<string, mixed>> Processed game logs */
    public array $games = [];

    /** @var list<TeamGameLog> Typed game log entries */
    public array $gameLogs = [];

    public int $team_id;

    public string $season = NBABase::CURRENT_SEASON;

    public string $season_type = NBABase::TYPE_REGULAR;

    public string $date_from = '';

    public string $date_to = '';

    public function __construct(?NbaHttpClientInterface $httpClient = null)
    {
        parent::__construct($httpClient);
    }

    /**
     * @return array<string, mixed> Raw API response data
     */
    public function fetch(): array
    {
        if ($this->team_id <= 0) {
            throw new \InvalidArgumentException('team_id must be set before calling fetch()');
        }

        $this->games = [];
        $this->gameLogs = [];

        $this->data = $this->ApiCall("https://stats.nba.com/stats/teamgamelog?DateFrom={$this->date_from}&DateTo={$this->date_to}&LeagueID=&Season={$this->season}&SeasonType={$this->season_type}&TeamID={$this->team_id}");

        foreach (ResultSetMapper::mapFirstResultSet($this->data) as $row) {
            $entry = TeamGameLog::fromResultSetRow($row);
            $this->gameLogs[] = $entry;
            $this->games[] = $entry->toArray();
        }

        return $this->data;
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function lastXGames(int $games = 10): array
    {
        return array_slice($this->games, 0, $games);
    }
}
