<?php

namespace Corbpie\NBALive;

class NBALeaguePlayerShotLocations extends NBALeagueDashFilters
{

    public array $data = [];

    public array $zone = [];

    public array $range_5ft = [];

    public array $range_8ft = [];

    public function fetch(): array
    {
        $this->data = $this->ApiCall("https://stats.nba.com/stats/leaguedashplayershotlocations?" . $this->build());

        if (isset($this->data['resultSets']['rowSet'][0])) {
            if ($this->distance_range === 'By Zone') {
                foreach ($this->data['resultSets']['rowSet'] as $p) {
                    $this->zone[] = [
                        'player_id' => $p[0],
                        'name' => $p[1],
                        'team_id' => $p[2],
                        'team' => $p[3],
                        'age' => $p[4],
                        'zones' => [
                            'restricted_area' => [
                                'fgm' => $p[6],
                                'fga' => $p[7],
                                'fg_pct' => $p[8]
                            ],
                            'paint' => [
                                'fgm' => $p[9],
                                'fga' => $p[10],
                                'fg_pct' => $p[11]
                            ],
                            'mid' => [
                                'fgm' => $p[12],
                                'fga' => $p[13],
                                'fg_pct' => $p[14]
                            ],
                            'left_corner_3' => [
                                'fgm' => $p[15],
                                'fga' => $p[16],
                                'fg_pct' => $p[17]
                            ],
                            'right_corner_3' => [
                                'fgm' => $p[18],
                                'fga' => $p[19],
                                'fg_pct' => $p[20]
                            ],
                            'above_break_3' => [
                                'fgm' => $p[21],
                                'fga' => $p[22],
                                'fg_pct' => $p[23]
                            ],
                            'back_court' => [
                                'fgm' => $p[24],
                                'fga' => $p[25],
                                'fg_pct' => $p[26]
                            ],
                            'corner_3' => [
                                'fgm' => $p[27],
                                'fga' => $p[28],
                                'fg_pct' => $p[29]
                            ]
                        ]
                    ];
                }
            } elseif ($this->distance_range === '5ft Range') {
                foreach ($this->data['resultSets']['rowSet'] as $p) {
                    $this->range_5ft[] = [
                        'player_id' => $p[0],
                        'name' => $p[1],
                        'team_id' => $p[2],
                        'team' => $p[3],
                        'age' => $p[4],
                        'zones' => [
                            'less_than_5ft' => [
                                'fgm' => $p[6],
                                'fga' => $p[7],
                                'fg_pct' => $p[8]
                            ],
                            '5_9ft' => [
                                'fgm' => $p[9],
                                'fga' => $p[10],
                                'fg_pct' => $p[11]
                            ],
                            '10_14ft' => [
                                'fgm' => $p[12],
                                'fga' => $p[13],
                                'fg_pct' => $p[14]
                            ],
                            '15_19ft' => [
                                'fgm' => $p[15],
                                'fga' => $p[16],
                                'fg_pct' => $p[17]
                            ],
                            '20_24ft' => [
                                'fgm' => $p[18],
                                'fga' => $p[19],
                                'fg_pct' => $p[20]
                            ],
                            '25_29ft' => [
                                'fgm' => $p[21],
                                'fga' => $p[22],
                                'fg_pct' => $p[23]
                            ],
                            '30_34ft' => [
                                'fgm' => $p[24],
                                'fga' => $p[25],
                                'fg_pct' => $p[26]
                            ],
                            '35_39_ft' => [
                                'fgm' => $p[27],
                                'fga' => $p[28],
                                'fg_pct' => $p[29]
                            ],
                            '40ft_plus' => [
                                'fgm' => $p[30],
                                'fga' => $p[31],
                                'fg_pct' => $p[32]
                            ]
                        ]
                    ];
                }
            } elseif ($this->distance_range === '8ft Range') {
                foreach ($this->data['resultSets']['rowSet'] as $p) {
                    $this->range_8ft[] = [
                        'player_id' => $p[0],
                        'name' => $p[1],
                        'team_id' => $p[2],
                        'team' => $p[3],
                        'age' => $p[4],
                        'zones' => [
                            'less_than_8ft' => [
                                'fgm' => $p[6],
                                'fga' => $p[7],
                                'fg_pct' => $p[8]
                            ],
                            '8_16ft' => [
                                'fgm' => $p[9],
                                'fga' => $p[10],
                                'fg_pct' => $p[11]
                            ],
                            '16_24ft' => [
                                'fgm' => $p[12],
                                'fga' => $p[13],
                                'fg_pct' => $p[14]
                            ],
                            '24ft_plus' => [
                                'fgm' => $p[15],
                                'fga' => $p[16],
                                'fg_pct' => $p[17]
                            ],
                            'back_court' => [
                                'fgm' => $p[18],
                                'fga' => $p[19],
                                'fg_pct' => $p[20]
                            ]
                        ]
                    ];
                }
            }
        }

        return $this->data;
    }


}