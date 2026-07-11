<?php

declare(strict_types=1);

namespace Corbpie\NBALive;

use Corbpie\NBALive\Contracts\FetchableEndpoint;
use Corbpie\NBALive\Http\NbaHttpClientInterface;

/**
 * Common player biographical information and headline stats.
 */
final class NBACommonPlayerInfo extends NBABase implements FetchableEndpoint
{
    /** @var array<string, mixed> */
    public array $data = [];

    /** @var array<string, mixed> */
    public array $info = [];

    /** @var array<string, mixed> */
    public array $headline_stats = [];

    /** @var list<string> */
    public array $available_seasons = [];

    public int $player_id = 0;

    public function __construct(int $player_id = 0, ?NbaHttpClientInterface $httpClient = null)
    {
        parent::__construct($httpClient);

        if ($player_id > 0) {
            $this->player_id = $player_id;
            $this->fetch();
        }
    }

    public function fetch(): array
    {
        $this->validatePositiveInt($this->player_id, 'player_id');

        $this->info = [];
        $this->headline_stats = [];
        $this->available_seasons = [];

        $params = http_build_query([
            'LeagueID' => '00',
            'PlayerID' => $this->player_id,
        ], '', '&');

        $this->data = $this->ApiCall("https://stats.nba.com/stats/commonplayerinfo?{$params}");

        $infoRows = ResultSetMapper::mapResultSetByName($this->data, 'CommonPlayerInfo');
        if ($infoRows === []) {
            $infoRows = ResultSetMapper::mapResultSetAt($this->data, 0);
        }
        if ($infoRows !== []) {
            $row = $infoRows[0];
            $this->info = [
                'player_id' => ResultSetMapper::pick($row, 'PERSON_ID'),
                'first_name' => ResultSetMapper::pick($row, 'FIRST_NAME', ''),
                'last_name' => ResultSetMapper::pick($row, 'LAST_NAME', ''),
                'display_name' => ResultSetMapper::pick($row, 'DISPLAY_FIRST_LAST', ''),
                'slug' => ResultSetMapper::pick($row, 'PLAYER_SLUG', ''),
                'birthdate' => ResultSetMapper::pick($row, 'BIRTHDATE', ''),
                'school' => ResultSetMapper::pick($row, 'SCHOOL', ''),
                'country' => ResultSetMapper::pick($row, 'COUNTRY', ''),
                'height' => ResultSetMapper::pick($row, 'HEIGHT', ''),
                'weight' => ResultSetMapper::pick($row, 'WEIGHT', ''),
                'season_exp' => ResultSetMapper::pick($row, 'SEASON_EXP'),
                'jersey' => ResultSetMapper::pick($row, 'JERSEY', ''),
                'position' => ResultSetMapper::pick($row, 'POSITION', ''),
                'roster_status' => ResultSetMapper::pick($row, 'ROSTERSTATUS', ''),
                'team_id' => ResultSetMapper::pick($row, 'TEAM_ID'),
                'team_name' => ResultSetMapper::pick($row, 'TEAM_NAME', ''),
                'team_abbr' => ResultSetMapper::pick($row, 'TEAM_ABBREVIATION', ''),
                'team_city' => ResultSetMapper::pick($row, 'TEAM_CITY', ''),
                'from_year' => ResultSetMapper::pick($row, 'FROM_YEAR'),
                'to_year' => ResultSetMapper::pick($row, 'TO_YEAR'),
                'draft_year' => ResultSetMapper::pick($row, 'DRAFT_YEAR', ''),
                'draft_round' => ResultSetMapper::pick($row, 'DRAFT_ROUND', ''),
                'draft_number' => ResultSetMapper::pick($row, 'DRAFT_NUMBER', ''),
            ];
        }

        $headlineRows = ResultSetMapper::mapResultSetByName($this->data, 'PlayerHeadlineStats');
        if ($headlineRows === []) {
            $headlineRows = ResultSetMapper::mapResultSetAt($this->data, 1);
        }
        if ($headlineRows !== []) {
            $row = $headlineRows[0];
            $this->headline_stats = [
                'player_id' => ResultSetMapper::pick($row, 'PLAYER_ID'),
                'player_name' => ResultSetMapper::pick($row, 'PLAYER_NAME', ''),
                'time_frame' => ResultSetMapper::pick($row, 'TimeFrame', ''),
                'pts' => ResultSetMapper::pick($row, 'PTS'),
                'ast' => ResultSetMapper::pick($row, 'AST'),
                'reb' => ResultSetMapper::pick($row, 'REB'),
                'pie' => ResultSetMapper::pick($row, 'PIE'),
            ];
        }

        $seasonRows = ResultSetMapper::mapResultSetByName($this->data, 'AvailableSeasons');
        if ($seasonRows === []) {
            $seasonRows = ResultSetMapper::mapResultSetAt($this->data, 2);
        }
        foreach ($seasonRows as $row) {
            $season = ResultSetMapper::pick($row, 'SEASON_ID');
            if ($season !== null && $season !== '') {
                $this->available_seasons[] = (string) $season;
            }
        }

        return $this->data;
    }
}
