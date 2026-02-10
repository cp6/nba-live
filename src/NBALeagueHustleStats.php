<?php

namespace Corbpie\NBALive;

/**
 * Retrieve league-wide hustle statistics for players.
 */
class NBALeagueHustleStats extends NBABase
{
    /** @var array Raw API response data */
    public array $data = [];

    /** @var array Player hustle stats */
    public array $players = [];

    /** @var string Season identifier */
    public string $season = NBABase::CURRENT_SEASON;

    /** @var string Per mode */
    public string $per_mode = NBABase::MODE_PER_GAME;

    /** @var string Season type */
    public string $season_type = NBABase::TYPE_REGULAR;

    /**
     * Fetch league hustle stats.
     *
     * @return array Raw API response data
     * @throws NBAApiException When the API request fails
     */
    public function fetch(): array
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/leaguehustlestatsplayer?College=&Conference=&Country=&DateFrom=&DateTo=&Division=&DraftPick=&DraftYear=&Height=&LeagueID=00&Location=&Month=0&OpponentTeamID=0&Outcome=&PORound=0&PerMode={$this->per_mode}&PlayerExperience=&PlayerPosition=&Season={$this->season}&SeasonSegment=&SeasonType={$this->season_type}&TeamID=0&VsConference=&VsDivision=&Weight=");

        if (isset($this->data['resultSets'][0]['rowSet'])) {
            foreach ($this->data['resultSets'][0]['rowSet'] as $p) {
                $this->players[] = [
                    'player_id' => $p[0] ?? 0,
                    'player_name' => $p[1] ?? '',
                    'team_id' => $p[2] ?? 0,
                    'team_abbr' => $p[3] ?? '',
                    'age' => $p[4] ?? 0,
                    'gp' => $p[5] ?? 0,
                    'w' => $p[6] ?? 0,
                    'l' => $p[7] ?? 0,
                    'min' => $p[8] ?? 0,
                    'contested_shots' => $p[9] ?? 0,
                    'contested_shots_2pt' => $p[10] ?? 0,
                    'contested_shots_3pt' => $p[11] ?? 0,
                    'deflections' => $p[12] ?? 0,
                    'charges_drawn' => $p[13] ?? 0,
                    'screen_assists' => $p[14] ?? 0,
                    'screen_assist_pts' => $p[15] ?? 0,
                    'loose_balls_recovered_off' => $p[16] ?? 0,
                    'loose_balls_recovered_def' => $p[17] ?? 0,
                    'loose_balls_recovered' => $p[18] ?? 0,
                    'off_box_outs' => $p[19] ?? 0,
                    'def_box_outs' => $p[20] ?? 0,
                    'box_outs' => $p[21] ?? 0,
                ];
            }
        }

        return $this->data;
    }

    /**
     * Get top hustlers by a specific stat.
     *
     * @param string $stat Stat key
     * @param int $limit Number of players
     * @return array Top hustlers
     */
    public function topHustlers(string $stat = 'deflections', int $limit = 10): array
    {
        $sorted = $this->players;
        usort($sorted, fn($a, $b) => ($b[$stat] ?? 0) <=> ($a[$stat] ?? 0));
        return \array_slice($sorted, 0, $limit);
    }
}
