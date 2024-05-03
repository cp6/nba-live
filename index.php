<?php
require __DIR__ . '/vendor/autoload.php';

use Corbpie\NBALive;

$call = new NBALive\NBAPlayoffBracket('2023');


//$call->game_id = '0022300507';
//$call->team_id = 1610612754;
//$call->player_id = 2544;
//$call->fetch();

echo json_encode($call->in_progress);

exit;