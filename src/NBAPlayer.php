<?php

namespace Corbpie\NBALive;

use DateTime;

/**
 * Retrieve NBA player information and details.
 */
class NBAPlayer extends NBABase
{
    // Player info API array indices
    private const IDX_ID = 0;
    private const IDX_FIRST_NAME = 1;
    private const IDX_LAST_NAME = 2;
    private const IDX_SHORT_NAME = 5;
    private const IDX_SLUG = 6;
    private const IDX_BIRTHDATE = 7;
    private const IDX_SCHOOL = 8;
    private const IDX_COUNTRY = 9;
    private const IDX_LAST_AFF = 10;
    private const IDX_HEIGHT = 11;
    private const IDX_WEIGHT = 12;
    private const IDX_SEASONS = 13;
    private const IDX_JERSEY = 14;
    private const IDX_POSITION = 15;
    private const IDX_STATUS = 16;
    private const IDX_PLAYED_CURRENT = 17;
    private const IDX_TEAM_ID = 18;
    private const IDX_TEAM_NAME = 19;
    private const IDX_TEAM_SHORT = 20;
    private const IDX_FROM_YEAR = 24;
    private const IDX_TO_YEAR = 25;
    private const IDX_DRAFT_YEAR = 29;
    private const IDX_DRAFT_ROUND = 30;
    private const IDX_DRAFT_NUMBER = 31;

    /** @var array Raw API response data */
    public array $data = [];

    /** @var array Player details */
    public array $details = [];

    /** @var array Player's seasons played */
    public array $seasons = [];

    /**
     * Fetch player information by player ID.
     *
     * @param int $player_id NBA player identifier
     * @throws NBAApiException When the API request fails
     */
    public function __construct(int $player_id = 0)
    {
        if (!isset($this->player_id)) {
            $this->player_id = $player_id;
        }

        $this->data = $this->ApiCall("https://stats.nba.com/stats/commonplayerinfo?LeagueID=&PlayerID={$this->player_id}");

        if (isset($this->data['resultSets'][0]['rowSet'][0])) {
            $p = $this->data['resultSets'][0]['rowSet'][0];

            $this->details = [
                'id' => $p[self::IDX_ID],
                'first_name' => $p[self::IDX_FIRST_NAME],
                'last_name' => $p[self::IDX_LAST_NAME],
                'short_name' => $p[self::IDX_SHORT_NAME],
                'slug' => $p[self::IDX_SLUG],
                'birthdate' => str_replace("T00:00:00", "", $p[self::IDX_BIRTHDATE]),
                'age' => (new DateTime('now'))->diff(new DateTime($p[self::IDX_BIRTHDATE]))->y,
                'school' => $p[self::IDX_SCHOOL],
                'last_aff' => $p[self::IDX_LAST_AFF],
                'country' => $p[self::IDX_COUNTRY],
                'height' => $p[self::IDX_HEIGHT],
                'height_cm' => $this->feetInchesToCm($p[self::IDX_HEIGHT]),
                'weight' => (int)$p[self::IDX_WEIGHT],
                'weight_kg' => (int)number_format((int)$p[self::IDX_WEIGHT] * 0.45359237, 0),
                'seasons' => $p[self::IDX_SEASONS],
                'jersey' => (int)$p[self::IDX_JERSEY],
                'position' => $p[self::IDX_POSITION],
                'status' => $p[self::IDX_STATUS],
                'current_team_id' => $p[self::IDX_TEAM_ID],
                'current_team_name' => $p[self::IDX_TEAM_NAME],
                'current_team_short' => $p[self::IDX_TEAM_SHORT],
                'from_year' => $p[self::IDX_FROM_YEAR],
                'to_year' => $p[self::IDX_TO_YEAR],
                'draft_year' => (int)$p[self::IDX_DRAFT_YEAR],
                'draft_round' => (int)$p[self::IDX_DRAFT_ROUND],
                'draft_number' => (int)$p[self::IDX_DRAFT_NUMBER],
                'played_current_season' => $p[self::IDX_PLAYED_CURRENT] === 'Y',
            ];

            // BUG FIX: Changed from string index '2' to numeric index 2
            if (isset($this->data['resultSets'][2]['rowSet'])) {
                foreach ($this->data['resultSets'][2]['rowSet'] as $season) {
                    if (isset($season[0]) && is_string($season[0]) && strlen($season[0]) > 1) {
                        $this->seasons[] = [
                            'type' => (int)$season[0][0],
                            'year' => (int)substr($season[0], 1)
                        ];
                    }
                }
            }
        }
    }
}
