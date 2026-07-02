<?php

declare(strict_types=1);

namespace Corbpie\NBALive;

use Corbpie\NBALive\Contracts\FetchableEndpoint;
use Corbpie\NBALive\Http\NbaHttpClientInterface;
final class NBAPlayByPlayClips extends NBABase implements FetchableEndpoint
{

    public array $data = [];

    public array $media = [];

    public array $details = [];

    public function fetch(string $game_id = '', int $event_number = 0): array
    {

        if ($game_id === '' || $event_number <= 0) {
            throw new \InvalidArgumentException('game_id and event_number are required');
        }

        $this->data = $this->ApiCall("https://stats.nba.com/stats/videoeventsasset?GameEventID={$event_number}&GameID={$game_id}");

        if (isset($this->data['resultSets']['Meta']['videoUrls'][0])) {
            $this->media = $this->data['resultSets']['Meta']['videoUrls'][0];
        }

        if (isset($this->data['resultSets']['playlist'][0])) {
            $this->details = $this->data['resultSets']['playlist'][0];
        }

        return $this->data;
    }

    public function __construct(string $game_id, int $event_number, ?NbaHttpClientInterface $httpClient = null)
    {
        parent::__construct($httpClient);
        $this->fetch($game_id, $event_number);
    }

}
