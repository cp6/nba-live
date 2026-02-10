<?php

namespace Corbpie\NBALive;

/**
 * Retrieve upcoming games for a specific player.
 */
class NBAPlayerNextGames extends NBABase
{
    /** @var array Raw API response data */
    public array $data = [];

    /** @var array Upcoming games */
    public array $games = [];

    /**
     * Fetch upcoming games for a player.
     *
     * @param int $player_id Player identifier
     * @param int $num_games Number of upcoming games to retrieve
     * @param string $season Season identifier
     * @throws NBAApiException When the API request fails
     */
    public function __construct(int $player_id = 0, int $num_games = 5, string $season = self::CURRENT_SEASON)
    {
        if ($player_id <= 0) {
            return;
        }

        $this->data = $this->ApiCall("https://stats.nba.com/stats/playernextngames?LeagueID=00&NumberOfGames={$num_games}&PlayerID={$player_id}&Season={$season}&SeasonType=Regular+Season");

        if (isset($this->data['resultSets'][0]['rowSet'])) {
            foreach ($this->data['resultSets'][0]['rowSet'] as $g) {
                $this->games[] = [
                    'game_id' => $g[0] ?? '',
                    'game_date' => $g[1] ?? '',
                    'home_team_id' => $g[2] ?? 0,
                    'visitor_team_id' => $g[3] ?? 0,
                    'home_team_name' => $g[5] ?? '',
                    'home_team_abbr' => $g[6] ?? '',
                    'visitor_team_name' => $g[8] ?? '',
                    'visitor_team_abbr' => $g[9] ?? '',
                    'home_wl' => $g[10] ?? '',
                    'visitor_wl' => $g[11] ?? '',
                ];
            }
        }
    }
}
