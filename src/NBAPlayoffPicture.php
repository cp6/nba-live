<?php

namespace Corbpie\NBALive;

class NBAPlayoffPicture extends NBABase
{

    public array $data = [];

    public array $east_conf_playoff_picture = [];
    public array $west_conf_playoff_picture = [];

    public array $east_conf_standings = [];
    public array $west_conf_standings = [];

    public array $east_conf_remaining_games = [];
    public array $west_conf_remaining_games = [];

    public function __construct(string $season = '22019')
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/playoffpicture?LeagueID=00&SeasonID=$season");


    }

}