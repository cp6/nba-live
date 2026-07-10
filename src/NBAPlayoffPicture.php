<?php

declare(strict_types=1);

namespace Corbpie\NBALive;

use Corbpie\NBALive\Contracts\FetchableEndpoint;
use Corbpie\NBALive\Http\NbaHttpClientInterface;

final class NBAPlayoffPicture extends NBABase implements FetchableEndpoint
{
    public array $data = [];

    public array $east_conf_playoff_picture = [];

    public array $west_conf_playoff_picture = [];

    public array $east_conf_standings = [];

    public array $west_conf_standings = [];

    public array $east_conf_remaining_games = [];

    public array $west_conf_remaining_games = [];

    public function fetch(string $season = '22025'): array
    {
        $this->east_conf_playoff_picture = [];
        $this->west_conf_playoff_picture = [];
        $this->east_conf_standings = [];
        $this->west_conf_standings = [];
        $this->east_conf_remaining_games = [];
        $this->west_conf_remaining_games = [];

        $this->data = $this->ApiCall("https://stats.nba.com/stats/playoffpicture?LeagueID=00&SeasonID={$season}");

        foreach (ResultSetMapper::mapResultSetAt($this->data, 0) as $row) {
            $this->east_conf_playoff_picture[] = $this->mapPlayoffPictureRow($row);
        }

        foreach (ResultSetMapper::mapResultSetAt($this->data, 1) as $row) {
            $this->west_conf_playoff_picture[] = $this->mapPlayoffPictureRow($row);
        }

        foreach (ResultSetMapper::mapResultSetAt($this->data, 2) as $row) {
            $this->east_conf_standings[] = $this->mapStandingsRow($row);
        }

        foreach (ResultSetMapper::mapResultSetAt($this->data, 3) as $row) {
            $this->west_conf_standings[] = $this->mapStandingsRow($row);
        }

        foreach (ResultSetMapper::mapResultSetAt($this->data, 4) as $row) {
            $this->east_conf_remaining_games[] = $this->mapRemainingGamesRow($row);
        }

        foreach (ResultSetMapper::mapResultSetAt($this->data, 5) as $row) {
            $this->west_conf_remaining_games[] = $this->mapRemainingGamesRow($row);
        }

        return $this->data;
    }

    public function __construct(string $season = '22025', ?NbaHttpClientInterface $httpClient = null)
    {
        parent::__construct($httpClient);
        $this->fetch($season);
    }

    /**
     * @param array<string, mixed> $row
     * @return array<string, mixed>
     */
    private function mapPlayoffPictureRow(array $row): array
    {
        return [
            'conference' => ResultSetMapper::pick($row, 'CONFERENCE', ''),
            'high_seed_rank' => ResultSetMapper::pick($row, 'HIGH_SEED_RANK'),
            'high_seed_team' => ResultSetMapper::pick($row, 'HIGH_SEED_TEAM'),
            'high_seed_team_id' => ResultSetMapper::pick($row, 'HIGH_SEED_TEAM_ID'),
            'low_seed_rank' => ResultSetMapper::pick($row, 'LOW_SEED_RANK'),
            'low_seed_team' => ResultSetMapper::pick($row, 'LOW_SEED_TEAM'),
            'low_seed_team_id' => ResultSetMapper::pick($row, 'LOW_SEED_TEAM_ID'),
            'high_seed_series_w' => ResultSetMapper::pick($row, 'HIGH_SEED_SERIES_W'),
            'high_seed_series_l' => ResultSetMapper::pick($row, 'HIGH_SEED_SERIES_L'),
            'high_seed_series_remaining_g' => ResultSetMapper::pick($row, 'HIGH_SEED_SERIES_REMAINING_G'),
            'high_seed_series_remaining_home_g' => ResultSetMapper::pick($row, 'HIGH_SEED_SERIES_REMAINING_HOME_G'),
            'high_seed_series_remaining_away_g' => ResultSetMapper::pick($row, 'HIGH_SEED_SERIES_REMAINING_AWAY_G'),
        ];
    }

    /**
     * @param array<string, mixed> $row
     * @return array<string, mixed>
     */
    private function mapStandingsRow(array $row): array
    {
        return [
            'conference' => ResultSetMapper::pick($row, 'CONFERENCE', ''),
            'rank' => ResultSetMapper::pick($row, 'RANK'),
            'team' => ResultSetMapper::pick($row, 'TEAM', ''),
            'team_slug' => ResultSetMapper::pick($row, 'TEAM_SLUG', ''),
            'team_id' => ResultSetMapper::pick($row, 'TEAM_ID'),
            'wins' => ResultSetMapper::pick($row, 'WINS'),
            'losses' => ResultSetMapper::pick($row, 'LOSSES'),
            'pct' => ResultSetMapper::pick($row, 'PCT'),
            'div' => ResultSetMapper::pick($row, 'DIV'),
            'conf' => ResultSetMapper::pick($row, 'CONF'),
            'home' => ResultSetMapper::pick($row, 'HOME'),
            'away' => ResultSetMapper::pick($row, 'AWAY'),
            'gb' => ResultSetMapper::pick($row, 'GB'),
            'gr_over_500' => ResultSetMapper::pick($row, 'GR_OVER_500'),
            'gr_over_500_home' => ResultSetMapper::pick($row, 'GR_OVER_500_HOME'),
            'gr_over_500_away' => ResultSetMapper::pick($row, 'GR_OVER_500_AWAY'),
            'gr_under_500' => ResultSetMapper::pick($row, 'GR_UNDER_500'),
            'gr_under_500_home' => ResultSetMapper::pick($row, 'GR_UNDER_500_HOME'),
            'gr_under_500_away' => ResultSetMapper::pick($row, 'GR_UNDER_500_AWAY'),
            'ranking_criteria' => ResultSetMapper::pick($row, 'RANKING_CRITERIA'),
            'clinched_playoffs' => ResultSetMapper::pick($row, 'CLINCHED_PLAYOFFS'),
            'clinched_conference' => ResultSetMapper::pick($row, 'CLINCHED_CONFERENCE'),
            'clinched_division' => ResultSetMapper::pick($row, 'CLINCHED_DIVISION'),
            'clinched_play_in' => ResultSetMapper::pick($row, 'Clinched_Play_In'),
            'eliminated_playoffs' => ResultSetMapper::pick($row, 'ELIMINATED_PLAYOFFS'),
            'sosa_remaining' => ResultSetMapper::pick($row, 'SOSA_REMAINING'),
        ];
    }

    /**
     * @param array<string, mixed> $row
     * @return array<string, mixed>
     */
    private function mapRemainingGamesRow(array $row): array
    {
        return [
            'team' => ResultSetMapper::pick($row, 'TEAM', ''),
            'team_id' => ResultSetMapper::pick($row, 'TEAM_ID'),
            'remaining_g' => ResultSetMapper::pick($row, 'REMAINING_G'),
            'remaining_home_g' => ResultSetMapper::pick($row, 'REMAINING_HOME_G'),
            'remaining_away_g' => ResultSetMapper::pick($row, 'REMAINING_AWAY_G'),
        ];
    }
}
