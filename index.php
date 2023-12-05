<?php
require __DIR__ . '/vendor/autoload.php';

use Corbpie\NBALive;

$today = new NBALive\NBALiveStandings();

echo json_encode($today->standings());


exit();

$today->getProcessGames();

echo json_encode($today->gameFormatter($today->completed_games));

exit;

$boxscore = new NBALive\NBALiveBoxScore('0022301202');
$boxscore->process();

echo json_encode($boxscore->home_team);
//echo json_encode($boxscore->home_players);

//echo json_encode($boxscore->away_team);
//echo json_encode($boxscore->away_players);




