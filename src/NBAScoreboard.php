<?php

declare(strict_types=1);

namespace Corbpie\NBALive;

use Corbpie\NBALive\Contracts\FetchableEndpoint;
use Corbpie\NBALive\Http\NbaHttpClientInterface;
use DateTime;
use DateTimeZone;

/**
 * Daily scoreboard with games, line scores, and conference standings snapshots.
 */
final class NBAScoreboard extends NBABase implements FetchableEndpoint
{
    /** @var array<string, mixed> */
    public array $data = [];

    /** @var list<array<string, mixed>> */
    public array $games = [];

    /** @var list<array<string, mixed>> */
    public array $line_scores = [];

    /** @var list<array<string, mixed>> */
    public array $east_standings = [];

    /** @var list<array<string, mixed>> */
    public array $west_standings = [];

    public string $game_date = '';

    public int $day_offset = 0;

    public function __construct(?string $game_date = null, ?NbaHttpClientInterface $httpClient = null)
    {
        parent::__construct($httpClient);

        if ($game_date !== null) {
            $this->game_date = $game_date;
            $this->fetch();
        }
    }

    public function fetch(): array
    {
        $this->games = [];
        $this->line_scores = [];
        $this->east_standings = [];
        $this->west_standings = [];

        if ($this->game_date === '') {
            $this->game_date = (new DateTime('now', new DateTimeZone('America/New_York')))->format('Y-m-d');
        }

        $params = http_build_query([
            'DayOffset' => $this->day_offset,
            'GameDate' => $this->game_date,
            'LeagueID' => '00',
        ], '', '&');

        $this->data = $this->ApiCall("https://stats.nba.com/stats/scoreboardv2?{$params}");

        foreach (ResultSetMapper::mapResultSetAt($this->data, 0) as $row) {
            $this->games[] = [
                'game_date_est' => ResultSetMapper::pick($row, 'GAME_DATE_EST', ''),
                'game_sequence' => ResultSetMapper::pick($row, 'GAME_SEQUENCE'),
                'game_id' => ResultSetMapper::pick($row, 'GAME_ID', ''),
                'game_status_id' => ResultSetMapper::pick($row, 'GAME_STATUS_ID'),
                'game_status_text' => ResultSetMapper::pick($row, 'GAME_STATUS_TEXT', ''),
                'game_code' => ResultSetMapper::pick($row, 'GAMECODE', ''),
                'home_team_id' => ResultSetMapper::pick($row, 'HOME_TEAM_ID'),
                'visitor_team_id' => ResultSetMapper::pick($row, 'VISITOR_TEAM_ID'),
                'season' => ResultSetMapper::pick($row, 'SEASON', ''),
                'live_period' => ResultSetMapper::pick($row, 'LIVE_PERIOD'),
                'live_pc_time' => ResultSetMapper::pick($row, 'LIVE_PC_TIME', ''),
                'natl_tv_broadcaster' => ResultSetMapper::pick($row, 'NATL_TV_BROADCASTER_ABBREVIATION', ''),
                'home_tv_broadcaster' => ResultSetMapper::pick($row, 'HOME_TV_BROADCASTER_ABBREVIATION', ''),
                'away_tv_broadcaster' => ResultSetMapper::pick($row, 'AWAY_TV_BROADCASTER_ABBREVIATION', ''),
                'arena' => ResultSetMapper::pick($row, 'ARENA_NAME', ''),
            ];
        }

        foreach (ResultSetMapper::mapResultSetAt($this->data, 1) as $row) {
            $this->line_scores[] = [
                'game_id' => ResultSetMapper::pick($row, 'GAME_ID', ''),
                'team_id' => ResultSetMapper::pick($row, 'TEAM_ID'),
                'team_abbr' => ResultSetMapper::pick($row, 'TEAM_ABBREVIATION', ''),
                'team_city' => ResultSetMapper::pick($row, 'TEAM_CITY_NAME', ''),
                'team_name' => ResultSetMapper::pick($row, 'TEAM_NAME', ''),
                'team_wins_losses' => ResultSetMapper::pick($row, 'TEAM_WINS_LOSSES', ''),
                'pts_qtr1' => ResultSetMapper::pick($row, 'PTS_QTR1'),
                'pts_qtr2' => ResultSetMapper::pick($row, 'PTS_QTR2'),
                'pts_qtr3' => ResultSetMapper::pick($row, 'PTS_QTR3'),
                'pts_qtr4' => ResultSetMapper::pick($row, 'PTS_QTR4'),
                'pts_ot1' => ResultSetMapper::pick($row, 'PTS_OT1'),
                'pts' => ResultSetMapper::pick($row, 'PTS'),
                'fg_pct' => ResultSetMapper::pick($row, 'FG_PCT'),
                'ft_pct' => ResultSetMapper::pick($row, 'FT_PCT'),
                'fg3_pct' => ResultSetMapper::pick($row, 'FG3_PCT'),
                'ast' => ResultSetMapper::pick($row, 'AST'),
                'reb' => ResultSetMapper::pick($row, 'REB'),
                'tov' => ResultSetMapper::pick($row, 'TOV'),
            ];
        }

        foreach (ResultSetMapper::mapResultSetAt($this->data, 4) as $row) {
            $this->east_standings[] = $this->mapStandingRow($row);
        }

        foreach (ResultSetMapper::mapResultSetAt($this->data, 5) as $row) {
            $this->west_standings[] = $this->mapStandingRow($row);
        }

        return $this->data;
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function lineScoresForGame(string $gameId): array
    {
        return array_values(array_filter(
            $this->line_scores,
            static fn (array $row): bool => ($row['game_id'] ?? '') === $gameId
        ));
    }

    /**
     * @param array<string, mixed> $row
     * @return array<string, mixed>
     */
    private function mapStandingRow(array $row): array
    {
        return [
            'team_id' => ResultSetMapper::pick($row, 'TEAM_ID'),
            'league_id' => ResultSetMapper::pick($row, 'LEAGUE_ID', ''),
            'season_id' => ResultSetMapper::pick($row, 'SEASON_ID', ''),
            'standings_date' => ResultSetMapper::pick($row, 'STANDINGSDATE', ''),
            'conference' => ResultSetMapper::pick($row, 'CONFERENCE', ''),
            'team' => ResultSetMapper::pick($row, 'TEAM', ''),
            'g' => ResultSetMapper::pick($row, 'G'),
            'w' => ResultSetMapper::pick($row, 'W'),
            'l' => ResultSetMapper::pick($row, 'L'),
            'w_pct' => ResultSetMapper::pick($row, 'W_PCT'),
            'home_record' => ResultSetMapper::pick($row, 'HOME_RECORD', ''),
            'road_record' => ResultSetMapper::pick($row, 'ROAD_RECORD', ''),
        ];
    }
}
