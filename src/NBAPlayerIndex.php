<?php

namespace Corbpie\NBALive;

/**
 * Search and filter all NBA players.
 */
class NBAPlayerIndex extends NBABase
{
    /** @var array Raw API response data */
    public array $data = [];

    /** @var array All players matching criteria */
    public array $players = [];

    /** @var string Season filter */
    public string $season = NBABase::CURRENT_SEASON;

    /** @var int|null Team ID filter */
    public ?int $team_id = null;

    /** @var string|null Country filter */
    public ?string $country = null;

    /** @var string|null College filter */
    public ?string $college = null;

    /** @var string|null Draft year filter */
    public ?string $draft_year = null;

    /** @var string Historical filter (Y/N) */
    public string $historical = 'N';

    /**
     * Fetch players matching the criteria.
     *
     * @return array Raw API response data
     * @throws NBAApiException When the API request fails
     */
    public function fetch(): array
    {
        $teamFilter = $this->team_id ? "&TeamID={$this->team_id}" : "&TeamID=0";
        $countryFilter = $this->country ? "&Country={$this->country}" : "&Country=";
        $collegeFilter = $this->college ? "&College={$this->college}" : "&College=";
        $draftFilter = $this->draft_year ? "&DraftYear={$this->draft_year}" : "&DraftYear=";

        $this->data = $this->ApiCall("https://stats.nba.com/stats/playerindex?Active=&AllStar=&College={$collegeFilter}&Country={$countryFilter}&DraftPick=&DraftRound=&DraftYear={$draftFilter}&Height=&Historical={$this->historical}&LeagueID=00&Season={$this->season}&SeasonType=Regular+Season{$teamFilter}&Weight=");

        if (isset($this->data['resultSets'][0]['rowSet'])) {
            foreach ($this->data['resultSets'][0]['rowSet'] as $p) {
                $this->players[] = [
                    'player_id' => $p[0] ?? 0,
                    'last_name' => $p[1] ?? '',
                    'first_name' => $p[2] ?? '',
                    'player_slug' => $p[3] ?? '',
                    'team_id' => $p[4] ?? 0,
                    'team_slug' => $p[5] ?? '',
                    'is_defunct' => ($p[6] ?? 0) === 1,
                    'team_city' => $p[7] ?? '',
                    'team_name' => $p[8] ?? '',
                    'team_abbr' => $p[9] ?? '',
                    'jersey' => $p[10] ?? '',
                    'position' => $p[11] ?? '',
                    'height' => $p[12] ?? '',
                    'weight' => $p[13] ?? '',
                    'college' => $p[14] ?? '',
                    'country' => $p[15] ?? '',
                    'draft_year' => $p[16] ?? null,
                    'draft_round' => $p[17] ?? null,
                    'draft_number' => $p[18] ?? null,
                    'roster_status' => $p[19] ?? 0,
                    'from_year' => $p[21] ?? null,
                    'to_year' => $p[22] ?? null,
                    'stats_timeframe' => $p[23] ?? '',
                ];
            }
        }

        return $this->data;
    }

    /**
     * Search players by name.
     *
     * @param string $name Name to search for
     * @return array Matching players
     */
    public function searchByName(string $name): array
    {
        $name = strtolower($name);
        return array_filter($this->players, function ($p) use ($name) {
            $fullName = strtolower(($p['first_name'] ?? '') . ' ' . ($p['last_name'] ?? ''));
            return str_contains($fullName, $name);
        });
    }
}
