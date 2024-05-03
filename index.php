<?php
require __DIR__ . '/vendor/autoload.php';

use Corbpie\NBALive;

$call = new NBALive\NBATeamGameLogs();

$call->team_id = 1610612754;
$call->fetch();

return json_encode($call->data);