<?php
require __DIR__ . '/vendor/autoload.php';

use Corbpie\NBALive;

$call = new NBALive\NBATeamGameLogs();

$call->team_id = 1610612754;
$call->fetch();

echo json_encode($call->data);