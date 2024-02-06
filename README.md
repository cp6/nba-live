# NBA API Wrapper

A PHP wrapper for accessing the many various NBA API endpoints including live games. This API wrapper formats a lot of the returned data
so you only get what you need but also in a handy, easily readable and accessible manner.

[![Generic badge](https://img.shields.io/badge/Version-1.4-blue.svg)]()

[![Generic badge](https://img.shields.io/badge/Updated-06.02.2024-green.svg)]()

---

## Table of contents / index

- [Installing](#installing)
- [Debugging](#debugging)
- [Today's games](#todays-games)
- [Game time seconds formatted](#game-time-seconds-formatted)
- [Box score](#boxscore)
- [Play by play](#play-by-play)
- [Play by play V3](#play-by-play-v3)
- [Play by play V2](#play-by-play-v2)
- [Play by play V1](#play-by-play-v1)
- [Play by play clips](#play-by-play-clips)
- [Rotations](#game-rotations)
- [Game summary](#game-summary)
- [Tradition box score](#traditional-box-score)
- [Scoring box score](#scoring-box-score)
- [Defensive box score](#defensive-box-score)
- [Hustle box score](#hustle-box-score)
- [Game matchups](#box-score-matchups)
- [Usage box score](#usage-box-score)
- [4 factors box score](#4-factors-box-score)
- [Advanced box score](#advanced-box-score)
- [Tracking box score](#tracking-box-score)
- [Team lineups](#team-lineups)
- [Team shots dash](#team-dash-pts-shots)
- [Standings](#standings)
- [Team year over year](#team-year-over-year)
- [Team roster](#team-roster)
- [Team info](#team-info)
- [Team game logs](#team-game-logs)
- [Team franchise players](#team-franchise-players)
- [Schedule](#schedule)
- [Player on off](#player-on-off)
- [Player year over year](#player-year-over-year)
- [Player shooting](#player-shooting)
- [Player](#player-data)
- [Player awards](#player-awards)
- [Player career](#player-career)
- [Playoff picture](#playoff-picture)
- [Team](#team)
- [League leaders](#league-leaders)
- [League player match ups](#league-player-match-ups)
- [League player shot locations](#league-player-shot-locations)
- [League player shots](#league-player-shots)
- [Video events](#video-events)

---

### Installing

Install easily with composer:

```
composer require corbpie/nba-live
```

### Debugging

Anytime an API call is made you can access debug parameters for the request

```php
$this->url;//The final compiled URL used in the call
$this->response_code;//Returned HTTP response code
$this->response_size;//The size of the response
$this->connect_time;//Time it took to connect
$this->ip;//The IP of the API endpoint that was connected to
```

### Todays games

```php
$today = new NBALive\NBAToday();

//Creates the arrays
$today->all_games;
$today->live_games;
$today->upcoming_games;
$today->completed_games;

//Format this data
$formatted = $today->gameFormatter($today->live_games);
```


### Game time seconds formatted (Helper function)

```php
$game_time = new NBALive\NBABase();
$game_time->secondsToFormattedGameTime(800);
```

Outputs

```json
{
  "period": 2,
  "period_string": "Q2",
  "seconds": 800,
  "seconds_period": 80,
  "seconds_period_string": "10:40",
  "full_string": "Q2 10:40"
}
```

### Boxscore

NBA API Live CDN box score version

```php
$boxscore = new NBALive\NBABoxScore('0022301214');

//Or set game id with
$boxscore->game_id = "0022301214";

//Creates the arrays
$boxscore->home_team;
$boxscore->away_team;

$boxscore->home_players;
$boxscore->away_players;

$boxscore->sortAsc($boxscore->home_players, 'points');
$boxscore->sortDesc($boxscore->home_players, 'points');
```

Team example:

```json
{
  "assists": 12,
  "assistsTurnoverRatio": 0.857142857142857,
  "benchPoints": 23,
  "biggestLead": 0,
  "biggestScoringRun": 9,
  "biggestScoringRunScore": "77-75",
  "blocks": 3,
  "blocksReceived": 2,
  "fastBreakPointsAttempted": 6,
  "fastBreakPointsMade": 3,
  "fastBreakPointsPercentage": 0.5,
  "fieldGoalsAttempted": 59,
  "fieldGoalsEffectiveAdjusted": 0.440677966101695,
  "fieldGoalsMade": 23,
  "fieldGoalsPercentage": 0.38983050847457595,
  "foulsOffensive": 2,
  "foulsDrawn": 22,
  "foulsPersonal": 12,
  "foulsTeam": 10,
  "foulsTechnical": 0,
  "foulsTeamTechnical": 0,
  "freeThrowsAttempted": 26,
  "freeThrowsMade": 23,
  "freeThrowsPercentage": 0.8846153846153839,
  "leadChanges": 0,
  "minutes": "PT165M15.00S",
  "minutesCalculated": "PT165M",
  "points": 75,
  "pointsAgainst": 77,
  "pointsFastBreak": 7,
  "pointsFromTurnovers": 14,
  "pointsInThePaint": 28,
  "pointsInThePaintAttempted": 30,
  "pointsInThePaintMade": 14,
  "pointsInThePaintPercentage": 0.466666666666667,
  "pointsSecondChance": 14,
  "reboundsDefensive": 25,
  "reboundsOffensive": 12,
  "reboundsPersonal": 37,
  "reboundsTeam": 9,
  "reboundsTeamDefensive": 4,
  "reboundsTeamOffensive": 5,
  "reboundsTotal": 46,
  "secondChancePointsAttempted": 12,
  "secondChancePointsMade": 6,
  "secondChancePointsPercentage": 0.5,
  "steals": 3,
  "threePointersAttempted": 22,
  "threePointersMade": 6,
  "threePointersPercentage": 0.272727272727273,
  "timeLeading": "PT00M00.00S",
  "timesTied": 2,
  "trueShootingAttempts": 70.44,
  "trueShootingPercentage": 0.53236797274276,
  "turnovers": 14,
  "turnoversTeam": 0,
  "turnoversTotal": 14,
  "twoPointersAttempted": 37,
  "twoPointersMade": 17,
  "twoPointersPercentage": 0.45945945945946
}
```

### Play by play

```php
$pbp = new NBALive\NBAPlayByPlay('0022301214');

//Or set game id with
$pbp->game_id = "0022301214";

//Creates the arrays
$pbp->all_plays;
$pbp->plays_count;
$pbp->last_10_plays;

//Player only plays
$pbp->playerOnly(202331);

//Team only plays
$pbp->teamOnly(1610612746);

//Get a score line/worm
$pbp->scoreLine();
```

### Play by play V3

```php
$game_id = '0022300372';
$start_qtr = 1;
$end_qtr = 1;

$pbp_v3 = new NBALive\NBAPlayByPlayV3($game_id, $start_qtr, $end_qtr);

//Creates the arrays
$pbp_v3->all_plays;
$pbp_v3->plays_count;
$pbp_v3->last_10_plays;

//Player only plays
$pbp_v3->playerOnly(202331);

//Team only plays
$pbp_v3->teamOnly(1610612746);

//Scored only plays
$pbp_v3->scoredOnly();

//Get a score streaks for both teams
$pbp_v3->scoreStreaks();
```

### Play by play V2

```php
$game_id = '0022300372';
$start_qtr = 1;
$end_qtr = 1;

$pbp_v2 = new NBALive\NBAPlayByPlayV2($game_id, $start_qtr, $end_qtr);

//Creates the arrays
$pbp_v2->all_plays;
$pbp_v2->plays_count;
$pbp_v2->last_10_plays;

//Player only plays
$pbp_v2->playerOnly(202331);

//Team only plays
$pbp_v2->teamOnly(1610612746);

//Scored only plays
$pbp_v2->scoredOnly();

```


### Play by play V1

```php
$game_id = '0022300372';
$start_qtr = 1;
$end_qtr = 1;

$pbp_v1 = new NBALive\NBAPlayByPlayV1($game_id, $start_qtr, $end_qtr);

//Creates the arrays
$pbp_v1->all_plays;
$pbp_v1->plays_count;
$pbp_v1->last_10_plays;

//Scored only plays
$pbp_v1->scoredOnly();

```

### Play by play clips

```php
$game_id = '0022300372';
$event_number = 89;

$play_clip = new NBALive\NBAPlayByPlayClips($game_id, $event_number);

//Creates the arrays
$play_clip->media;
$play_clip->details;
```

### Traditional box score

```php
$bs = new NBALive\NBABoxScoreTraditional();
//Whole game
$bs->game_id = '0022300372';
$bs->fetch();

//Preset filter (Qtr 4)
$bs->game_id = '0022300372';
$bs->filter = $bs->buildQ4();//buildQ1(), buildQ2(), buildH1() etc.
$bs->fetch();

//Custom filter
$bs->game_id = '0022300372';
$bs->range_type = 1;
$bs->start_period = 4;
$bs->start_range = 0;
$bs->end_range = 28800;
$bs->end_period = 4;
$bs->filter = $bs->build();
$bs->fetch();

//Creates the arrays
$bs->teams;
$bs->teams_starters;
$bs->teams_bench;

$bs->home_team;
$bs->home_players;
$bs->home_starters;
$bs->home_bench;

$bs->away_team;
$bs->away_players;
$bs->away_starters;
$bs->away_bench;

$bs->sortAsc($bs->home_players, 'fieldGoalsAttempted');
$bs->sortDesc($bs->home_players, 'fieldGoalsMade');
```

### Defensive box score

```php
$defensive = new NBALive\NBABoxScoreDefensive("0022301203");

//Or set game id with
$defensive->game_id = "0022301203";

//Creates the arrays
$defensive->home_players;
$defensive->away_players;
```

### Box score matchups

```php
$matchups = new NBALive\NBABoxScoreMatchups("0022301203");

//Or set game id with
$matchups->game_id = "0022301203";

//Creates the arrays
$matchups->home_players;
$matchups->away_players;

//Get just a certain players matchups
$matchups->playerOnly(1629684);

//Get all matchups for a player
$matchups->playerMatchedWith(201935);
```

### Scoring box score

```php
$scoring = new NBALive\NBABoxScoreScoring();
//Whole game
$scoring->game_id = '0022300372';
$scoring->fetch();

//Preset filter (Qtr 4)
$scoring->game_id = '0022300372';
$scoring->filter = $bs->buildQ4();//buildQ1(), buildQ2(), buildH1() etc.
$scoring->fetch();

//Custom filter
$scoring->game_id = '0022300372';
$scoring->range_type = 1;
$scoring->start_period = 4;
$scoring->start_range = 0;
$scoring->end_range = 28800;
$scoring->end_period = 4;
$scoring->filter = $bs->build();
$scoring->fetch();

//Creates the arrays
$scoring->home_players;
$scoring->away_players;

$scoring->home_team;
$scoring->away_team;
```

### Misc box score

```php
$misc = new NBALive\NBABoxScoreMisc();
//Whole game
$misc->game_id = '0022300372';
$misc->fetch();

//Preset filter (Qtr 4)
$misc->game_id = '0022300372';
$misc->filter = $bs->buildQ4();//buildQ1(), buildQ2(), buildH1() etc.
$misc->fetch();

//Custom filter
$misc->game_id = '0022300372';
$misc->range_type = 1;
$misc->start_period = 4;
$misc->start_range = 0;
$misc->end_range = 28800;
$misc->end_period = 4;
$misc->filter = $bs->build();
$misc->fetch();

//Creates the arrays
$misc->home_players;
$misc->away_players;

$misc->home_team;
$misc->away_team;
```

### Usage box score

```php
$usage = new NBALive\NBABoxScoreUsage();
//Whole game
$usage->game_id = '0022300372';
$usage->fetch();

//Preset filter (Qtr 4)
$usage->game_id = '0022300372';
$usage->filter = $bs->buildQ4();//buildQ1(), buildQ2(), buildH1() etc.
$usage->fetch();

//Custom filter
$usage->game_id = '0022300372';
$usage->range_type = 1;
$usage->start_period = 4;
$usage->start_range = 0;
$usage->end_range = 28800;
$usage->end_period = 4;
$usage->filter = $bs->build();
$usage->fetch();

//Creates the arrays
$usage->home_players;
$usage->away_players;

$usage->home_team;
$usage->away_team;
```

### 4 factors box score

```php
$fourfactors = new NBALive\NBABoxScore4Factors("0022301203");
//Whole game
$fourfactors->game_id = '0022300372';
$fourfactors->fetch();

//Preset filter (Qtr 4)
$fourfactors->game_id = '0022300372';
$fourfactors->filter = $bs->buildQ4();//buildQ1(), buildQ2(), buildH1() etc.
$fourfactors->fetch();

//Custom filter
$fourfactors->game_id = '0022300372';
$fourfactors->range_type = 1;
$fourfactors->start_period = 4;
$fourfactors->start_range = 0;
$fourfactors->end_range = 28800;
$fourfactors->end_period = 4;
$fourfactors->filter = $bs->build();
$fourfactors->fetch();

//Creates the arrays
$fourfactors->home_players;
$fourfactors->away_players;

$fourfactors->home_team;
$fourfactors->away_team;
```

### Advanced box score

```php
$adv = new NBALive\NBABoxScoreAdvanced();
//Whole game
$adv->game_id = '0022300372';
$adv->fetch();

//Preset filter (Qtr 4)
$adv->game_id = '0022300372';
$adv->filter = $bs->buildQ4();//buildQ1(), buildQ2(), buildH1() etc.
$adv->fetch();

//Custom filter
$adv->game_id = '0022300372';
$adv->range_type = 1;
$adv->start_period = 4;
$adv->start_range = 0;
$adv->end_range = 28800;
$adv->end_period = 4;
$adv->filter = $bs->build();
$adv->fetch();

//Creates the arrays
$adv->home_players;
$adv->away_players;

$adv->home_team;
$adv->away_team;
```

### Tracking box score

```php
$tracking = new NBALive\NBABoxScoreTracking();
//Whole game
$tracking->game_id = '0022300372';
$tracking->fetch();

//Preset filter (Qtr 4)
$tracking->game_id = '0022300372';
$tracking->filter = $bs->buildQ4();//buildQ1(), buildQ2(), buildH1() etc.
$tracking->fetch();

//Custom filter
$tracking->game_id = '0022300372';
$tracking->range_type = 1;
$tracking->start_period = 4;
$tracking->start_range = 0;
$tracking->end_range = 28800;
$tracking->end_period = 4;
$tracking->filter = $bs->build();
$tracking->fetch();

//Creates the arrays
$tracking->home_players;
$tracking->away_players;

$tracking->home_team;
$tracking->away_team;
```

### Team lineups

```php
$lineups = new NBALive\NBATeamLineups();

$lineups->team_id = 1610612746;
$lineups->season = '2019-20';//Optional if NOT set will just be current season
$lineups->players_amount = 5;
$lineups->fetch();

//Creates the array
$lineups->details;

//Get lineups that contain a certain player only
$lineups->playerOnly(202695)
```

### Team Dash pts shots

```php
$team_shots = new NBALive\NBATeamDashPtShots();

$team_shots->team_id = 1610612746;
$team_shots->season = '2019-20';//Optional if NOT set will just be current season
$team_shots->fetch();

//Creates the arrays
$team_shots->general_shooting;
$team_shots->shot_clock_shooting;
$team_shots->dribble_shooting;
$team_shots->closest_defender_shooting;
$team_shots->closest_defender_10ft_shooting;
$team_shots->touch_time_shooting;
```

### Game rotations

```php
$rotations = new NBALive\NBARotations("0022301203");

//Or set game id with
$rotations->game_id = "0022301203";

//Creates the array
$pbp->details;

//Player only rotation
$pbp->playerOnly(202331);

//Team only rotation
$pbp->teamOnly(1610612746);
```

Outputs

```json
[
  {
    "team_id": 1610612756,
    "team_short": "Suns",
    "player_id": 201142,
    "player_name": "K.Durant",
    "in_period": 1,
    "in": "00:00",
    "in_time_left": "12:00",
    "out_period": 1,
    "out": "09:38",
    "out_time_left": "02:22",
    "total_time": "09:38",
    "pts": 4,
    "pts_diff": -4,
    "usg_pct": 0.174
  },
  {
    "team_id": 1610612756,
    "team_short": "Suns",
    "player_id": 201142,
    "player_name": "K.Durant",
    "in_period": 2,
    "in": "14:50",
    "in_time_left": "09:10",
    "out_period": 3,
    "out": "34:13",
    "out_time_left": "01:47",
    "total_time": "19:23",
    "pts": 17,
    "pts_diff": 12,
    "usg_pct": 0.304
  },
  {
    "team_id": 1610612756,
    "team_short": "Suns",
    "player_id": 201142,
    "player_name": "K.Durant",
    "in_period": 4,
    "in": "38:23",
    "in_time_left": "09:37",
    "out_period": 4,
    "out": "47:52",
    "out_time_left": "00:08",
    "total_time": "09:29",
    "pts": 10,
    "pts_diff": -2,
    "usg_pct": 0.278
  },
  {
    "team_id": 1610612756,
    "team_short": "Suns",
    "player_id": 201142,
    "player_name": "K.Durant",
    "in_period": 4,
    "in": "47:53",
    "in_time_left": "00:07",
    "out_period": 4,
    "out": "48:00",
    "out_time_left": "00:00",
    "total_time": "00:07",
    "pts": 0,
    "pts_diff": 0,
    "usg_pct": 0.5
  }
]
```

### Team year over year

```php
$team_yoy = new NBALive\NBATeamYearOverYear(1610612746);

//Creates the arrays
$team_yoy->details;
$team_yoy->latest;
```

### Standings

```php
$standings = new NBALive\NBAStandings('2023-24');

//Creates the arrays
$standings->standings;
$standings->east_standings;
$standings->west_standings;
```

### Team info

```php
$team = new NBALive\NBATeamInfo(1610612746);

//Creates the arrays
$team->info;
$team->ranks;
$team->seasons;
```

### Team game logs

```php
$logs = new NBALive\NBATeamGameLogs();
$logs->team_id = 1610612746;
$logs->season = '2023-24';//Optional
$logs->fetch();

//Creates the array
$logs->games;

//Last X games
$logs->lastXGames(10);//Last 10 games only
```

### Team franchise players

```php
$players = new NBALive\NBAFranchisePlayers(1610612746);

//Creates the array
$players->players;
```

### Schedule

```php
$schedule = new NBALive\NBASchedule('2023-12-20');

//Creates the array
$schedule->schedule;


//Get tomorrow's games
$tomorrow = (new DateTimeImmutable('tomorrow', new DateTimeZone('America/New_York')))->format('Y-m-d');

$schedule = new NBALive\NBASchedule($tomorrow);

//Get upcoming games for a team in next 7 days
$schedule->upcomingGames(1610612746);
```

Output

```json
[
  {
    "game_id": "0022300364",
    "game_sequence": 1,
    "game_status": 1,
    "game_status_text": "7:00 pm ET",
    "game_code": "20231220\/UTACLE",
    "home_tid": 1610612739,
    "away_tid": 1610612762,
    "arena": "Rocket Mortgage FieldHouse",
    "live_period": null,
    "date_time_et": "2023-12-20 19:00:00",
    "date_time_utc": "2023-12-21 00:00:00"
  },
  {
    "game_id": "0022300365",
    "game_sequence": 2,
    "game_status": 1,
    "game_status_text": "7:00 pm ET",
    "game_code": "20231220\/CHAIND",
    "home_tid": 1610612754,
    "away_tid": 1610612766,
    "arena": "Gainbridge Fieldhouse",
    "live_period": null,
    "date_time_et": "2023-12-20 19:00:00",
    "date_time_utc": "2023-12-21 00:00:00"
  },
  {
    "game_id": "0022300366",
    "game_sequence": 3,
    "game_status": 1,
    "game_status_text": "7:00 pm ET",
    "game_code": "20231220\/MIAORL",
    "home_tid": 1610612753,
    "away_tid": 1610612748,
    "arena": "Amway Center",
    "live_period": null,
    "date_time_et": "2023-12-20 19:00:00",
    "date_time_utc": "2023-12-21 00:00:00"
  },
  {
    "game_id": "0022300367",
    "game_sequence": 4,
    "game_status": 1,
    "game_status_text": "7:00 pm ET",
    "game_code": "20231220\/MINPHI",
    "home_tid": 1610612755,
    "away_tid": 1610612750,
    "arena": "Wells Fargo Center",
    "live_period": null,
    "date_time_et": "2023-12-20 19:00:00",
    "date_time_utc": "2023-12-21 00:00:00"
  },
  {
    "game_id": "0022300368",
    "game_sequence": 5,
    "game_status": 1,
    "game_status_text": "7:30 pm ET",
    "game_code": "20231220\/NYKBKN",
    "home_tid": 1610612751,
    "away_tid": 1610612752,
    "arena": "Barclays Center",
    "live_period": null,
    "date_time_et": "2023-12-20 19:30:00",
    "date_time_utc": "2023-12-21 00:30:00"
  },
  {
    "game_id": "0022300369",
    "game_sequence": 6,
    "game_status": 1,
    "game_status_text": "7:30 pm ET",
    "game_code": "20231220\/DENTOR",
    "home_tid": 1610612761,
    "away_tid": 1610612743,
    "arena": "Scotiabank Arena",
    "live_period": null,
    "date_time_et": "2023-12-20 19:30:00",
    "date_time_utc": "2023-12-21 00:30:00"
  },
  {
    "game_id": "0022300370",
    "game_sequence": 7,
    "game_status": 1,
    "game_status_text": "8:00 pm ET",
    "game_code": "20231220\/LALCHI",
    "home_tid": 1610612741,
    "away_tid": 1610612747,
    "arena": "United Center",
    "live_period": null,
    "date_time_et": "2023-12-20 20:00:00",
    "date_time_utc": "2023-12-21 01:00:00"
  },
  {
    "game_id": "0022300371",
    "game_sequence": 8,
    "game_status": 1,
    "game_status_text": "8:00 pm ET",
    "game_code": "20231220\/ATLHOU",
    "home_tid": 1610612745,
    "away_tid": 1610612737,
    "arena": "Toyota Center",
    "live_period": null,
    "date_time_et": "2023-12-20 20:00:00",
    "date_time_utc": "2023-12-21 01:00:00"
  },
  {
    "game_id": "0022300372",
    "game_sequence": 9,
    "game_status": 1,
    "game_status_text": "8:30 pm ET",
    "game_code": "20231220\/LACDAL",
    "home_tid": 1610612742,
    "away_tid": 1610612746,
    "arena": "American Airlines Center",
    "live_period": null,
    "date_time_et": "2023-12-20 20:30:00",
    "date_time_utc": "2023-12-21 01:30:00"
  },
  {
    "game_id": "0022300373",
    "game_sequence": 10,
    "game_status": 1,
    "game_status_text": "10:00 pm ET",
    "game_code": "20231220\/BOSSAC",
    "home_tid": 1610612758,
    "away_tid": 1610612738,
    "arena": "Golden 1 Center",
    "live_period": null,
    "date_time_et": "2023-12-20 22:00:00",
    "date_time_utc": "2023-12-21 03:00:00"
  }
]
```

### Hustle box score

```php
$hustle = new NBALive\NBABoxScoreHustle("0022301203");

//Or set game id with
$hustle->game_id = "0022301203";

//Creates these arrays
$hustle->home_players;
$hustle->away_team;
$hustle->home_team;
$hustle->away_team;
```

Team array output

```json
{
  "minutes": "240.000000:00",
  "points": 106,
  "contestedShots": 33,
  "contestedShots2pt": 21,
  "contestedShots3pt": 12,
  "deflections": 17,
  "chargesDrawn": 0,
  "screenAssists": 9,
  "screenAssistPoints": 20,
  "looseBallsRecoveredOffensive": 4,
  "looseBallsRecoveredDefensive": 0,
  "looseBallsRecoveredTotal": 4,
  "offensiveBoxOuts": 2,
  "defensiveBoxOuts": 3,
  "boxOutPlayerTeamRebounds": 5,
  "boxOutPlayerRebounds": 4,
  "boxOuts": 5
}
```

### Game summary

```php
$sum = new NBALive\NBAGameSummary("0022301203");

//Or set game id with
$sum->game_id = "0022301203";

//Creates these arrays
$sum->home;
$sum->away;
$sum->refs;
$sum->inactive;
$sum->home_line_score;
$sum->away_line_score;
$sum->last_meeting;
$sum->statuses;

//Int
$sum->attendance;
```

Output for `$sum->away`

```json
{
  "team_id": 1610612756,
  "team_name_short": "PHX",
  "pts_paint": 42,
  "pts_second_chance": 10,
  "pts_fast_break": 27,
  "largest_lead": 3,
  "lead_changes": 14,
  "times_tied": 11,
  "team_turnovers": 2,
  "total_turnovers": 22,
  "team_rebounds": 11,
  "pts_off_to": 25
}
```

### Team roster

```php
$roster = new NBALive\NBARosters(1610612754, '2014-15');

//Creates the array
$roster->players;
$roster->coaches;
```

### League leaders

```php
$stat = 'PTS';
$mode = 'Totals'
$season = '2023-24'
$type = 'Regular+Season'

$ll = new NBALive\NBALeagueLeaders($stat, $mode, $season, $type);

//Creates the array
$ll->details;
```

### Player year over year

```php
$yoy = new NBALive\NBAPlayerYearOverYear();
$yoy->player_id = 202331;//Required
$yoy->per_mode = 'PerGame';
//Set this if you want to get a specific season:
$yoy->season = '2019-20';

//Must run fetch()
$yoy->fetch();

//Creates the arrays
$yoy->details;
//For the specific season
$yoy->season_array;
```

### Player on off

```php
$on_off = new NBALive\NBATeamPlayerOnOff();
$on_off->team_id = 1610612746;
$on_off->season = '2023-24';

//Must run fetch()
$yoy->fetch();

//Creates the arrays
$yoy->on;
$yoy->off;

//Get a specific player on and off
$on_off->player(201587);

//This build and returns:
$on_off->player_only;
```

Output for `$on_off->player_only`

```json
{
  "on": {
    "player_id": 202331,
    "player": "George, Paul",
    "team_id": 1610612746,
    "team": "LAC",
    "season": "2023-24",
    "season_type": "Regular Season",
    "per_mode": "Totals",
    "status": "ON",
    "gp": 26,
    "w": 15,
    "l": 11,
    "w_pct": 0.577,
    "min": 899.96,
    "fgm": 826,
    "fga": 1638,
    "fg_pct": 0.504,
    "fg3m": 244,
    "fg3a": 591,
    "fg3_pct": 0.413,
    "ftm": 353,
    "fta": 443,
    "ft_pct": 0.797,
    "oreb": 179,
    "dreb": 635,
    "reb": 814,
    "ast": 504,
    "pf": 363,
    "pfd": 393,
    "stl": 162,
    "tov": 236,
    "blk": 95,
    "blka": 85,
    "pts": 2249,
    "plus_minus": 184,
    "gp_rank": 5,
    "w_rank": 5,
    "l_rank": 18,
    "w_pct_rank": 17,
    "min_rank": 2,
    "fgm_rank": 2,
    "fga_rank": 2,
    "fg_pct_rank": 2,
    "fg3m_rank": 1,
    "fg3a_rank": 2,
    "fg3_pct_rank": 5,
    "ftm_rank": 2,
    "fta_rank": 2,
    "ft_pct_rank": 9,
    "oreb_rank": 2,
    "dreb_rank": 2,
    "reb_rank": 2,
    "ast_rank": 2,
    "pf_rank": 21,
    "pfd_rank": 2,
    "stl_rank": 2,
    "tov_rank": 20,
    "blk_rank": 2,
    "blka_rank": 21,
    "pts_rank": 2,
    "plus_minus_rank": 2
  },
  "off": {
    "player_id": 202331,
    "player": "George, Paul",
    "team_id": 1610612746,
    "team": "LAC",
    "season": "2023-24",
    "season_type": "Regular Season",
    "per_mode": "Totals",
    "status": "OFF",
    "gp": 28,
    "w": 17,
    "l": 11,
    "w_pct": 0.607,
    "min": 449.04,
    "fgm": 370,
    "fga": 822,
    "fg_pct": 0.45,
    "fg3m": 107,
    "fg3a": 327,
    "fg3_pct": 0.327,
    "ftm": 180,
    "fta": 223,
    "ft_pct": 0.807,
    "oreb": 118,
    "dreb": 299,
    "reb": 417,
    "ast": 207,
    "pf": 202,
    "pfd": 175,
    "stl": 72,
    "tov": 135,
    "blk": 55,
    "blka": 46,
    "pts": 1027,
    "plus_minus": -30,
    "gp_rank": 1,
    "w_rank": 1,
    "l_rank": 9,
    "w_pct_rank": 7,
    "min_rank": 16,
    "fgm_rank": 16,
    "fga_rank": 16,
    "fg_pct_rank": 22,
    "fg3m_rank": 17,
    "fg3a_rank": 16,
    "fg3_pct_rank": 22,
    "ftm_rank": 16,
    "fta_rank": 16,
    "ft_pct_rank": 5,
    "oreb_rank": 16,
    "dreb_rank": 16,
    "reb_rank": 16,
    "ast_rank": 16,
    "pf_rank": 7,
    "pfd_rank": 16,
    "stl_rank": 16,
    "tov_rank": 7,
    "blk_rank": 16,
    "blka_rank": 5,
    "pts_rank": 16,
    "plus_minus_rank": 21
  }
}
```

### Player shooting

```php
$player = new NBALive\NBAPlayerShooting();

//Or set player id with
$player->player_id = 202331;
$player->season = '2019-20';

//Creates the arrays
$player->shot_5ft = [];
$player->shot_8ft = [];
$player->shot_area = [];
$player->assisted = [];
$player->shot_types_summary = [];
$player->shot_types = [];
$player->assisted_by = [];
```

### Player data

```php
$player = new NBALive\NBAPlayer(202331);

//Or set player id with
$player->player_id = 202331;

//Creates the arrays
$player->details;
$player->seasons;
```

Details:

```json
{
  "id": 202331,
  "first_name": "Paul",
  "last_name": "George",
  "short_name": "P. George",
  "slug": "paul-george",
  "birthdate": "1990-05-02",
  "age": 33,
  "school": "Fresno State",
  "last_aff": "Fresno State\/USA",
  "country": "USA",
  "height": "6-8",
  "height_cm": 203,
  "weight": 220,
  "weight_kg": 100,
  "seasons": 13,
  "jersey": 13,
  "position": "Forward",
  "status": "Active",
  "current_team_id": 1610612746,
  "current_team_name": "Clippers",
  "current_team_short": "LAC",
  "from_year": 2010,
  "to_year": 2023,
  "draft_year": 2010,
  "draft_round": 1,
  "draft_number": 10,
  "played_current_season": true
}
```

### Player awards

```php
$awards = new NBALive\NBAPlayerAwards(202331);

//Creates the array
$player->awards;
```

### Player career

```php
$awards = new NBALive\NBAPlayerCareer(202331, 'Totals');

//Creates the arrays
$player->season_totals_regular;
$player->career_totals_regular;
$player->season_totals_post;
$player->career_totals_post;
$player->season_totals_all_star;
$player->career_totals_all_star;
$player->season_totals_college;
$player->career_totals_college;
$player->season_totals_showcase;
$player->career_totals_showcase;
$player->season_rankings_regular;
$player->season_rankings_post;
```

### Playoff picture

```php
$playoffs = new NBALive\NBAPlayoffPicture('22019');

```

### Team

```php
$team = new NBALive\NBATeam(1610612757);


//Or set team id with
$team->team_id = 1610612757;

//Creates the array
$team->details;
```

Outputs

```json
{
  "id": 1610612757,
  "name": "Trail Blazers",
  "short_name": "POR",
  "city": "Portland",
  "arena": "Moda Center",
  "year_founded": 1970
}
```

### League player match ups

```php
$match_ups = new NBALive\NBAMatchups();
$match_ups->season = '2023-24';

//Get only players from a team with
$match_ups->off_team_id = 1610612757;

//Get only certain player
$match_ups->off_player_id = 202331;

//Call fetch
$match_ups->fetch();

//Creates the array
$match_ups->details;
```


### League player shot locations

```php
$shots = new NBALive\NBALeaguePlayerShotLocations();
$shots->season = '2023-24';

//Get only players from a team with
$shots->team_id = 1610612757;

//Choose location/range type
$shots->distance_range = 'By Zone';
$shots->distance_range = '5ft Range';
$shots->distance_range = '8ft Range';

//Creates the arrays depending on distance_range
$shots->zone;
$shots->range_5ft;
$shots->range_8ft;
```

### League player shots

```php
$shots = new NBALive\NBALeaguePlayerShotPts();
$shots->season = '2023-24';

//Get only players from a team with
$shots->team_id = 1610612757;

//Creates the array
$shots->details;
```

### Video events

```php
$ve = new NBALive\NBAVideoEvents(1, '0022300568');

//Creates the array
$ve->details;
```
