<?php

declare(strict_types=1);

namespace Corbpie\NBALive;

use Corbpie\NBALive\Contracts\FetchableEndpoint;
use Corbpie\NBALive\Dto\TeamStanding;
use Corbpie\NBALive\Http\NbaHttpClientInterface;

/**
 * Retrieve NBA league standings data.
 */
final class NBAStandings extends NBABase implements FetchableEndpoint
{
    /** @var array<string, mixed> Raw API response data */
    public array $data = [];

    /** @var list<array<string, mixed>> All teams standings */
    public array $standings = [];

    /** @var list<TeamStanding> Typed standings entries */
    public array $standingEntries = [];

    /** @var list<array<string, mixed>> Eastern Conference standings */
    public array $east_standings = [];

    /** @var list<array<string, mixed>> Western Conference standings */
    public array $west_standings = [];

    public string $season = self::CURRENT_SEASON;

    public function __construct(string $season = self::CURRENT_SEASON, ?NbaHttpClientInterface $httpClient = null)
    {
        parent::__construct($httpClient);
        $this->season = $season;
        $this->fetch();
    }

    /**
     * @return array<string, mixed> Raw API response data
     */
    public function fetch(): array
    {
        $this->standings = [];
        $this->standingEntries = [];
        $this->east_standings = [];
        $this->west_standings = [];

        $this->data = $this->ApiCall("https://stats.nba.com/stats/leaguestandingsv3?LeagueID=00&Season={$this->season}&SeasonType=Regular+Season&SeasonYear=");

        $league = $east = $west = 0;

        foreach (ResultSetMapper::mapFirstResultSet($this->data) as $row) {
            $league++;
            $entry = TeamStanding::fromResultSetRow($row, $league);
            $baseStanding = $entry->toArray();

            $this->standingEntries[] = $entry;
            $this->standings[] = $baseStanding;

            if ($entry->conference === 'East') {
                $east++;
                $this->east_standings[] = array_merge(
                    ['conference_rank' => $east],
                    $baseStanding,
                );
            } else {
                $west++;
                $this->west_standings[] = array_merge(
                    ['conference_rank' => $west],
                    $baseStanding,
                );
            }
        }

        return $this->data;
    }
}
