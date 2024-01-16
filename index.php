<?php
require __DIR__ . '/vendor/autoload.php';

use Corbpie\NBALive;

$yoy = new NBALive\NBATeamGameLogs();
//$yoy->game_id = '0022300507';

$yoy->team_id = 1610612754;



/*$yoy->range_type = 1;
$yoy->start_period = 4;
$yoy->start_range = 0;
$yoy->end_range = 28800;
$yoy->end_period = 4;*/
//$yoy->filters = $yoy->buildH1();
$yoy->fetch();

//https://stats.nba.com/stats/boxscoretraditionalv3?GameID=0022300372&LeagueID=00&endPeriod=1&endRange=28800&rangeType=1&startPeriod=1&startRange=0
//https://stats.nba.com/stats/boxscoretraditionalv3?GameID=0022300372&LeagueID=00&endPeriod=2&endRange=28800&rangeType=1&startPeriod=2&startRange=0
//https://stats.nba.com/stats/boxscoretraditionalv3?GameID=0022300372&LeagueID=00&endPeriod=3&endRange=28800&rangeType=1&startPeriod=3&startRange=0
//https://stats.nba.com/stats/boxscoretraditionalv3?GameID=0022300372&LeagueID=00&endPeriod=4&endRange=28800&rangeType=1&startPeriod=4&startRange=0



echo json_encode($yoy->lastXGames(2));
exit;




//https://stats.nba.com/stats/leaguedashplayershotlocations?College=&Conference=&Country=&DateFrom=&DateTo=&DistanceRange=By+Zone&Division=&DraftPick=&DraftYear=&GameScope=&GameSegment=&Height=&LastNGames=0&LeagueID=&Location=&MeasureType=Base&Month=0&OpponentTeamID=0&Outcome=&PORound=&PaceAdjust=N&PerMode=Totals&Period=0&PlayerExperience=&PlayerPosition=&PlusMinus=N&Rank=N&Season=2019-20&SeasonSegment=&SeasonType=Regular+Season&ShotClockRange=&StarterBench=&TeamID=&VsConference=&VsDivision=&Weight=
//https:\/\/stats.nba.com\/stats\/leaguedashplayershotlocations?DateFrom=&DateTo=&GameSegment=&LastNGames=0&LeagueID=&Location=&MeasureType=Base&Month=0&OpponentTeamID=0&Outcome=&PaceAdjust=N&PerMode=Totals&Period=0&PlusMinus=&Rank=&Season=2023-24&SeasonSegment=&SeasonType=Regular+Season&VsConference=&VsDivision=&Weight=&StarterBench=&ShotClockRange=&PlayerPosition=&PlayerExperience=&PORound=&Height=&GameScope=&DraftYear=&DraftPick=&Division=&DistanceRange=By+Zone&Country=&College=&Conference="