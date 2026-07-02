<?php

declare(strict_types=1);

namespace Corbpie\NBALive;

use Corbpie\NBALive\Contracts\FetchableEndpoint;
use Corbpie\NBALive\Dto\LeagueGameEntry;
use Corbpie\NBALive\Http\NbaHttpClientInterface;

/**
 * Search for games by various criteria.
 */
final class NBALeagueGameFinder extends NBABase implements FetchableEndpoint
{
    /** @var array<string, mixed> Raw API response data */
    public array $data = [];

    /** @var list<array<string, mixed>> Matching games */
    public array $games = [];

    /** @var list<LeagueGameEntry> Typed game entries */
    public array $gameEntries = [];

    public string $season = NBABase::CURRENT_SEASON;

    public string $season_type = NBABase::TYPE_REGULAR;

    /** @var string|null Date from filter (YYYY-MM-DD) */
    public ?string $date_from = null;

    /** @var string|null Date to filter (YYYY-MM-DD) */
    public ?string $date_to = null;

    /** @var string|null Outcome filter (W or L) */
    public ?string $outcome = null;

    public function __construct(?NbaHttpClientInterface $httpClient = null)
    {
        parent::__construct($httpClient);
    }

    /**
     * @return array<string, mixed> Raw API response data
     */
    public function fetch(): array
    {
        $teamFilter = $this->team_id > 0 ? "&TeamID={$this->team_id}" : '&TeamID=';
        $playerFilter = $this->player_id > 0 ? "&PlayerID={$this->player_id}" : '&PlayerID=';
        $dateFromFilter = $this->date_from ?? '';
        $dateToFilter = $this->date_to ?? '';
        $outcomeFilter = $this->outcome ?? '';

        $this->games = [];
        $this->gameEntries = [];

        $this->data = $this->ApiCall("https://stats.nba.com/stats/leaguegamefinder?Conference=&DateFrom={$dateFromFilter}&DateTo={$dateToFilter}&Division=&DraftNumber=&DraftRound=&DraftYear=&EqAST=&EqBLK=&EqDD=&EqDREB=&EqFG3A=&EqFG3M=&EqFG3_PCT=&EqFGA=&EqFGM=&EqFG_PCT=&EqFTA=&EqFTM=&EqFT_PCT=&EqMINUTES=&EqOREB=&EqPF=&EqPTS=&EqREB=&EqSTL=&EqTD=&EqTOV=&GameID=&GtAST=&GtBLK=&GtDD=&GtDREB=&GtFG3A=&GtFG3M=&GtFG3_PCT=&GtFGA=&GtFGM=&GtFG_PCT=&GtFTA=&GtFTM=&GtFT_PCT=&GtMINUTES=&GtOREB=&GtPF=&GtPTS=&GtREB=&GtSTL=&GtTD=&GtTOV=&LeagueID=00&Location=&LtAST=&LtBLK=&LtDD=&LtDREB=&LtFG3A=&LtFG3M=&LtFG3_PCT=&LtFGA=&LtFGM=&LtFG_PCT=&LtFTA=&LtFTM=&LtFT_PCT=&LtMINUTES=&LtOREB=&LtPF=&LtPTS=&LtREB=&LtSTL=&LtTD=&LtTOV=&Outcome={$outcomeFilter}{$playerFilter}&PlayerOrTeam=T&RookieYear=&Season={$this->season}&SeasonSegment=&SeasonType={$this->season_type}{$teamFilter}&VsConference=&VsDivision=&VsTeamID=");

        foreach (ResultSetMapper::mapFirstResultSet($this->data) as $row) {
            $entry = LeagueGameEntry::fromResultSetRow($row);
            $this->gameEntries[] = $entry;
            $this->games[] = $entry->toArray();
        }

        return $this->data;
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function highScoringGames(int $min_pts = 120): array
    {
        return array_values(array_filter($this->games, fn ($g) => ($g['pts'] ?? 0) >= $min_pts));
    }
}
