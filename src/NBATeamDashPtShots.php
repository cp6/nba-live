<?php

namespace Corbpie\NBALive;

class NBATeamDashPtShots extends NBATeamDashFilters
{
    public array $data = [];

    public function fetch(): void
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/teamdashptshots?" . $this->build());

        if (isset($this->data['resultSets']['1']['rowSet'])) {

        }

    }

}