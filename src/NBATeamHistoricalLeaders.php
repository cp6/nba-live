<?php

namespace Corbpie\NBALive;

/**
 * Retrieve historical leaders for a specific team.
 */
class NBATeamHistoricalLeaders extends NBABase
{
    /** @var array Raw API response data */
    public array $data = [];

    /** @var array Career leaders */
    public array $career_leaders = [];

    /** @var array Season leaders */
    public array $season_leaders = [];

    /**
     * Fetch team historical leaders.
     *
     * @param int $team_id Team identifier
     * @throws NBAApiException When the API request fails
     */
    public function __construct(int $team_id = 0)
    {
        if ($team_id <= 0) {
            return;
        }

        $this->data = $this->ApiCall("https://stats.nba.com/stats/teamhistoricalleaders?LeagueID=00&SeasonID=&TeamID={$team_id}");

        // Career leaders
        if (isset($this->data['resultSets'][0]['rowSet'])) {
            foreach ($this->data['resultSets'][0]['rowSet'] as $l) {
                $this->career_leaders[] = [
                    'team_id' => $l[0] ?? 0,
                    'player_id' => $l[1] ?? 0,
                    'player_name' => $l[2] ?? '',
                    'season_id' => $l[3] ?? '',
                    'gp' => $l[4] ?? 0,
                    'min' => $l[5] ?? 0,
                    'fgm' => $l[6] ?? 0,
                    'fga' => $l[7] ?? 0,
                    'fg_pct' => $l[8] ?? 0,
                    'fg3m' => $l[9] ?? 0,
                    'fg3a' => $l[10] ?? 0,
                    'fg3_pct' => $l[11] ?? 0,
                    'ftm' => $l[12] ?? 0,
                    'fta' => $l[13] ?? 0,
                    'ft_pct' => $l[14] ?? 0,
                    'oreb' => $l[15] ?? 0,
                    'dreb' => $l[16] ?? 0,
                    'reb' => $l[17] ?? 0,
                    'ast' => $l[18] ?? 0,
                    'stl' => $l[19] ?? 0,
                    'blk' => $l[20] ?? 0,
                    'tov' => $l[21] ?? 0,
                    'pf' => $l[22] ?? 0,
                    'pts' => $l[23] ?? 0,
                ];
            }
        }
    }
}
