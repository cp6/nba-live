# NBA API Wrapper

A PHP wrapper for accessing NBA API endpoints including live games. This wrapper formats a lot of the returned data
so you only get what you need but also in a handy and readable manner.

[![Generic badge](https://img.shields.io/badge/version-1.2-blue.svg)]()


---

## Table of contents

- [Installing](#installing)
- [Debugging](#debugging)
- [Today's games](#todays-games)
- [Game time seconds formatted](#game-time-seconds-formatted)
- [Box score](#boxscore)
- [Play by play](#play-by-play)
- [Play by play V3](#play-by-play-v3)
- [Play by play V2](#play-by-play-v2)
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
- [Standings](#standings)
- [Team year over year](#team-year-over-year)
- [Team roster](#team-roster)
- [Schedule](#schedule)
- [Player on off](#player-on-off)
- [Player year over year](#player-year-over-year)
- [Player shooting](#player-shooting)
- [Player](#player-data)
- [Team](#team)
- [League leaders](#league-leaders)

---

### Installing

Install with composer:

```
composer require corbpie/nba-live
```

### Debugging

Anytime an API call is made you can access debug parameters for the request

```php
$this->url;
$this->response_code;
$this->response_size;
$this->connect_time;
$this->ip;
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

Will return:

```json
[
  {
    "status": 2,
    "starting_in": null,
    "game_id": "0022301214",
    "game_code": "20231206\/PORGSW",
    "margin": 10,
    "home_score": 58,
    "away_score": 68,
    "time_left_string": "Q3 7:16",
    "time_left": "07:16",
    "seconds_left": 436,
    "period": 3,
    "home_team": {
      "id": 1610612744,
      "name": "Warriors",
      "short": "GSW",
      "in_bonus": false,
      "timeouts_remaining": 4,
      "wins": 9,
      "losses": 11,
      "seed": null
    },
    "away_team": {
      "id": 1610612757,
      "name": "Trail Blazers",
      "short": "POR",
      "in_bonus": false,
      "timeouts_remaining": 5,
      "wins": 6,
      "losses": 13,
      "seed": null
    },
    "periods": {
      "one": [
        {
          "home_score": 22,
          "away_score": 26
        }
      ],
      "two": [
        {
          "home_score": 26,
          "away_score": 29
        }
      ],
      "three": [
        {
          "home_score": 10,
          "away_score": 13
        }
      ],
      "four": [
        {
          "home_score": 0,
          "away_score": 0
        }
      ],
      "five": [
        {
          "home_score": null,
          "away_score": null
        }
      ],
      "six": [
        {
          "home_score": null,
          "away_score": null
        }
      ],
      "seven": [
        {
          "home_score": null,
          "away_score": null
        }
      ]
    },
    "game_series": "",
    "game_type": "",
    "game_time_utc": "2023-12-07 03:00:00",
    "game_time_et": "2023-12-06 22:00:00"
  },
  {
    "status": 2,
    "starting_in": null,
    "game_id": "0022301215",
    "game_code": "20231206\/DENLAC",
    "margin": 5,
    "home_score": 67,
    "away_score": 72,
    "time_left_string": "Q3 7:18",
    "time_left": "07:18",
    "seconds_left": 438,
    "period": 3,
    "home_team": {
      "id": 1610612746,
      "name": "Clippers",
      "short": "LAC",
      "in_bonus": false,
      "timeouts_remaining": 4,
      "wins": 9,
      "losses": 10,
      "seed": null
    },
    "away_team": {
      "id": 1610612743,
      "name": "Nuggets",
      "short": "DEN",
      "in_bonus": false,
      "timeouts_remaining": 4,
      "wins": 14,
      "losses": 7,
      "seed": null
    },
    "periods": {
      "one": [
        {
          "home_score": 21,
          "away_score": 36
        }
      ],
      "two": [
        {
          "home_score": 40,
          "away_score": 21
        }
      ],
      "three": [
        {
          "home_score": 6,
          "away_score": 15
        }
      ],
      "four": [
        {
          "home_score": 0,
          "away_score": 0
        }
      ],
      "five": [
        {
          "home_score": null,
          "away_score": null
        }
      ],
      "six": [
        {
          "home_score": null,
          "away_score": null
        }
      ],
      "seven": [
        {
          "home_score": null,
          "away_score": null
        }
      ]
    },
    "game_series": "",
    "game_type": "",
    "game_time_utc": "2023-12-07 03:00:00",
    "game_time_et": "2023-12-06 22:00:00"
  }
]
```

### Game time seconds formatted

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

Player example:

```json
[
  {
    "status": "ACTIVE",
    "order": 1,
    "personId": 203952,
    "jerseyNum": "22",
    "position": "SF",
    "starter": "1",
    "oncourt": "0",
    "played": "1",
    "statistics": {
      "assists": 1,
      "blocks": 0,
      "blocksReceived": 1,
      "fieldGoalsAttempted": 9,
      "fieldGoalsMade": 2,
      "fieldGoalsPercentage": 0.222222222222222,
      "foulsOffensive": 0,
      "foulsDrawn": 2,
      "foulsPersonal": 1,
      "foulsTechnical": 0,
      "freeThrowsAttempted": 3,
      "freeThrowsMade": 3,
      "freeThrowsPercentage": 1,
      "minus": 49,
      "minutes": "PT21M56.00S",
      "minutesCalculated": "PT22M",
      "plus": 47,
      "plusMinusPoints": -2,
      "points": 7,
      "pointsFastBreak": 0,
      "pointsInThePaint": 2,
      "pointsSecondChance": 0,
      "reboundsDefensive": 1,
      "reboundsOffensive": 0,
      "reboundsTotal": 1,
      "steals": 0,
      "threePointersAttempted": 1,
      "threePointersMade": 0,
      "threePointersPercentage": 0,
      "turnovers": 1,
      "twoPointersAttempted": 8,
      "twoPointersMade": 2,
      "twoPointersPercentage": 0.25
    },
    "name": "Andrew Wiggins",
    "nameI": "A. Wiggins",
    "firstName": "Andrew",
    "familyName": "Wiggins"
  },
  {
    "status": "ACTIVE",
    "order": 2,
    "personId": 203110,
    "jerseyNum": "23",
    "position": "PF",
    "starter": "1",
    "oncourt": "0",
    "played": "1",
    "statistics": {
      "assists": 5,
      "blocks": 2,
      "blocksReceived": 0,
      "fieldGoalsAttempted": 7,
      "fieldGoalsMade": 3,
      "fieldGoalsPercentage": 0.428571428571429,
      "foulsOffensive": 1,
      "foulsDrawn": 2,
      "foulsPersonal": 3,
      "foulsTechnical": 0,
      "freeThrowsAttempted": 4,
      "freeThrowsMade": 4,
      "freeThrowsPercentage": 1,
      "minus": 56,
      "minutes": "PT23M12.08S",
      "minutesCalculated": "PT23M",
      "plus": 50,
      "plusMinusPoints": -6,
      "points": 10,
      "pointsFastBreak": 0,
      "pointsInThePaint": 6,
      "pointsSecondChance": 6,
      "reboundsDefensive": 4,
      "reboundsOffensive": 6,
      "reboundsTotal": 10,
      "steals": 0,
      "threePointersAttempted": 2,
      "threePointersMade": 0,
      "threePointersPercentage": 0,
      "turnovers": 4,
      "twoPointersAttempted": 5,
      "twoPointersMade": 3,
      "twoPointersPercentage": 0.6
    },
    "name": "Draymond Green",
    "nameI": "D. Green",
    "firstName": "Draymond",
    "familyName": "Green"
  },
  {
    "status": "ACTIVE",
    "order": 3,
    "personId": 1626172,
    "jerseyNum": "5",
    "position": "C",
    "starter": "1",
    "oncourt": "0",
    "played": "1",
    "statistics": {
      "assists": 0,
      "blocks": 0,
      "blocksReceived": 0,
      "fieldGoalsAttempted": 6,
      "fieldGoalsMade": 2,
      "fieldGoalsPercentage": 0.333333333333333,
      "foulsOffensive": 0,
      "foulsDrawn": 3,
      "foulsPersonal": 2,
      "foulsTechnical": 0,
      "freeThrowsAttempted": 2,
      "freeThrowsMade": 2,
      "freeThrowsPercentage": 1,
      "minus": 34,
      "minutes": "PT16M01.00S",
      "minutesCalculated": "PT16M",
      "plus": 27,
      "plusMinusPoints": -7,
      "points": 6,
      "pointsFastBreak": 0,
      "pointsInThePaint": 4,
      "pointsSecondChance": 0,
      "reboundsDefensive": 6,
      "reboundsOffensive": 2,
      "reboundsTotal": 8,
      "steals": 1,
      "threePointersAttempted": 0,
      "threePointersMade": 0,
      "threePointersPercentage": 0,
      "turnovers": 0,
      "twoPointersAttempted": 6,
      "twoPointersMade": 2,
      "twoPointersPercentage": 0.333333333333333
    },
    "name": "Kevon Looney",
    "nameI": "K. Looney",
    "firstName": "Kevon",
    "familyName": "Looney"
  },
  {
    "status": "ACTIVE",
    "order": 4,
    "personId": 202691,
    "jerseyNum": "11",
    "position": "SG",
    "starter": "1",
    "oncourt": "0",
    "played": "1",
    "statistics": {
      "assists": 1,
      "blocks": 0,
      "blocksReceived": 0,
      "fieldGoalsAttempted": 9,
      "fieldGoalsMade": 1,
      "fieldGoalsPercentage": 0.111111111111111,
      "foulsOffensive": 0,
      "foulsDrawn": 1,
      "foulsPersonal": 0,
      "foulsTechnical": 0,
      "freeThrowsAttempted": 2,
      "freeThrowsMade": 2,
      "freeThrowsPercentage": 1,
      "minus": 58,
      "minutes": "PT21M31.00S",
      "minutesCalculated": "PT21M",
      "plus": 42,
      "plusMinusPoints": -16,
      "points": 4,
      "pointsFastBreak": 0,
      "pointsInThePaint": 2,
      "pointsSecondChance": 0,
      "reboundsDefensive": 5,
      "reboundsOffensive": 0,
      "reboundsTotal": 5,
      "steals": 0,
      "threePointersAttempted": 6,
      "threePointersMade": 0,
      "threePointersPercentage": 0,
      "turnovers": 0,
      "twoPointersAttempted": 3,
      "twoPointersMade": 1,
      "twoPointersPercentage": 0.333333333333333
    },
    "name": "Klay Thompson",
    "nameI": "K. Thompson",
    "firstName": "Klay",
    "familyName": "Thompson"
  },
  {
    "status": "ACTIVE",
    "order": 5,
    "personId": 201939,
    "jerseyNum": "30",
    "position": "PG",
    "starter": "1",
    "oncourt": "1",
    "played": "1",
    "statistics": {
      "assists": 1,
      "blocks": 0,
      "blocksReceived": 0,
      "fieldGoalsAttempted": 13,
      "fieldGoalsMade": 6,
      "fieldGoalsPercentage": 0.461538461538462,
      "foulsOffensive": 0,
      "foulsDrawn": 6,
      "foulsPersonal": 2,
      "foulsTechnical": 0,
      "freeThrowsAttempted": 11,
      "freeThrowsMade": 10,
      "freeThrowsPercentage": 0.9090909090909091,
      "minus": 56,
      "minutes": "PT24M58.00S",
      "minutesCalculated": "PT25M",
      "plus": 60,
      "plusMinusPoints": 4,
      "points": 26,
      "pointsFastBreak": 1,
      "pointsInThePaint": 2,
      "pointsSecondChance": 3,
      "reboundsDefensive": 2,
      "reboundsOffensive": 0,
      "reboundsTotal": 2,
      "steals": 0,
      "threePointersAttempted": 9,
      "threePointersMade": 4,
      "threePointersPercentage": 0.444444444444444,
      "turnovers": 2,
      "twoPointersAttempted": 4,
      "twoPointersMade": 2,
      "twoPointersPercentage": 0.5
    },
    "name": "Stephen Curry",
    "nameI": "S. Curry",
    "firstName": "Stephen",
    "familyName": "Curry"
  },
  {
    "status": "ACTIVE",
    "order": 6,
    "personId": 1630541,
    "jerseyNum": "4",
    "starter": "0",
    "oncourt": "1",
    "played": "1",
    "statistics": {
      "assists": 0,
      "blocks": 1,
      "blocksReceived": 0,
      "fieldGoalsAttempted": 7,
      "fieldGoalsMade": 5,
      "fieldGoalsPercentage": 0.714285714285714,
      "foulsOffensive": 0,
      "foulsDrawn": 4,
      "foulsPersonal": 1,
      "foulsTechnical": 0,
      "freeThrowsAttempted": 1,
      "freeThrowsMade": 1,
      "freeThrowsPercentage": 1,
      "minus": 38,
      "minutes": "PT16M46.00S",
      "minutesCalculated": "PT17M",
      "plus": 46,
      "plusMinusPoints": 8,
      "points": 12,
      "pointsFastBreak": 4,
      "pointsInThePaint": 8,
      "pointsSecondChance": 5,
      "reboundsDefensive": 1,
      "reboundsOffensive": 2,
      "reboundsTotal": 3,
      "steals": 1,
      "threePointersAttempted": 2,
      "threePointersMade": 1,
      "threePointersPercentage": 0.5,
      "turnovers": 1,
      "twoPointersAttempted": 5,
      "twoPointersMade": 4,
      "twoPointersPercentage": 0.8
    },
    "name": "Moses Moody",
    "nameI": "M. Moody",
    "firstName": "Moses",
    "familyName": "Moody"
  },
  {
    "status": "ACTIVE",
    "order": 7,
    "personId": 203967,
    "jerseyNum": "20",
    "starter": "0",
    "oncourt": "1",
    "played": "1",
    "statistics": {
      "assists": 0,
      "blocks": 0,
      "blocksReceived": 0,
      "fieldGoalsAttempted": 2,
      "fieldGoalsMade": 2,
      "fieldGoalsPercentage": 1,
      "foulsOffensive": 1,
      "foulsDrawn": 3,
      "foulsPersonal": 2,
      "foulsTechnical": 0,
      "freeThrowsAttempted": 2,
      "freeThrowsMade": 2,
      "freeThrowsPercentage": 1,
      "minus": 29,
      "minutes": "PT12M16.92S",
      "minutesCalculated": "PT12M",
      "plus": 36,
      "plusMinusPoints": 7,
      "points": 7,
      "pointsFastBreak": 0,
      "pointsInThePaint": 2,
      "pointsSecondChance": 0,
      "reboundsDefensive": 2,
      "reboundsOffensive": 1,
      "reboundsTotal": 3,
      "steals": 0,
      "threePointersAttempted": 1,
      "threePointersMade": 1,
      "threePointersPercentage": 1,
      "turnovers": 4,
      "twoPointersAttempted": 1,
      "twoPointersMade": 1,
      "twoPointersPercentage": 1
    },
    "name": "Dario Saric",
    "nameI": "D. Saric",
    "firstName": "Dario",
    "familyName": "Saric"
  },
  {
    "status": "ACTIVE",
    "order": 8,
    "personId": 1641764,
    "jerseyNum": "2",
    "starter": "0",
    "oncourt": "1",
    "played": "1",
    "statistics": {
      "assists": 1,
      "blocks": 0,
      "blocksReceived": 1,
      "fieldGoalsAttempted": 3,
      "fieldGoalsMade": 0,
      "fieldGoalsPercentage": 0,
      "foulsOffensive": 0,
      "foulsDrawn": 1,
      "foulsPersonal": 0,
      "foulsTechnical": 0,
      "freeThrowsAttempted": 2,
      "freeThrowsMade": 0,
      "freeThrowsPercentage": 0,
      "minus": 30,
      "minutes": "PT13M58.00S",
      "minutesCalculated": "PT14M",
      "plus": 33,
      "plusMinusPoints": 3,
      "points": 0,
      "pointsFastBreak": 0,
      "pointsInThePaint": 0,
      "pointsSecondChance": 0,
      "reboundsDefensive": 2,
      "reboundsOffensive": 1,
      "reboundsTotal": 3,
      "steals": 0,
      "threePointersAttempted": 0,
      "threePointersMade": 0,
      "threePointersPercentage": 0,
      "turnovers": 0,
      "twoPointersAttempted": 3,
      "twoPointersMade": 0,
      "twoPointersPercentage": 0
    },
    "name": "Brandin Podziemski",
    "nameI": "B. Podziemski",
    "firstName": "Brandin",
    "familyName": "Podziemski"
  },
  {
    "status": "ACTIVE",
    "order": 9,
    "personId": 101108,
    "jerseyNum": "3",
    "starter": "0",
    "oncourt": "0",
    "played": "1",
    "statistics": {
      "assists": 3,
      "blocks": 0,
      "blocksReceived": 0,
      "fieldGoalsAttempted": 2,
      "fieldGoalsMade": 1,
      "fieldGoalsPercentage": 0.5,
      "foulsOffensive": 0,
      "foulsDrawn": 0,
      "foulsPersonal": 1,
      "foulsTechnical": 0,
      "freeThrowsAttempted": 0,
      "freeThrowsMade": 0,
      "freeThrowsPercentage": 0,
      "minus": 35,
      "minutes": "PT12M48.00S",
      "minutesCalculated": "PT13M",
      "plus": 29,
      "plusMinusPoints": -6,
      "points": 2,
      "pointsFastBreak": 0,
      "pointsInThePaint": 0,
      "pointsSecondChance": 0,
      "reboundsDefensive": 2,
      "reboundsOffensive": 0,
      "reboundsTotal": 2,
      "steals": 0,
      "threePointersAttempted": 1,
      "threePointersMade": 0,
      "threePointersPercentage": 0,
      "turnovers": 2,
      "twoPointersAttempted": 1,
      "twoPointersMade": 1,
      "twoPointersPercentage": 1
    },
    "name": "Chris Paul",
    "nameI": "C. Paul",
    "firstName": "Chris",
    "familyName": "Paul"
  },
  {
    "status": "ACTIVE",
    "order": 10,
    "personId": 1630228,
    "jerseyNum": "00",
    "starter": "0",
    "oncourt": "1",
    "played": "1",
    "statistics": {
      "assists": 0,
      "blocks": 0,
      "blocksReceived": 0,
      "fieldGoalsAttempted": 1,
      "fieldGoalsMade": 1,
      "fieldGoalsPercentage": 1,
      "foulsOffensive": 0,
      "foulsDrawn": 0,
      "foulsPersonal": 0,
      "foulsTechnical": 0,
      "freeThrowsAttempted": 0,
      "freeThrowsMade": 0,
      "freeThrowsPercentage": 0,
      "minus": 0,
      "minutes": "PT01M48.00S",
      "minutesCalculated": "PT02M",
      "plus": 10,
      "plusMinusPoints": 10,
      "points": 2,
      "pointsFastBreak": 2,
      "pointsInThePaint": 2,
      "pointsSecondChance": 0,
      "reboundsDefensive": 0,
      "reboundsOffensive": 0,
      "reboundsTotal": 0,
      "steals": 1,
      "threePointersAttempted": 0,
      "threePointersMade": 0,
      "threePointersPercentage": 0,
      "turnovers": 0,
      "twoPointersAttempted": 1,
      "twoPointersMade": 1,
      "twoPointersPercentage": 1
    },
    "name": "Jonathan Kuminga",
    "nameI": "J. Kuminga",
    "firstName": "Jonathan",
    "familyName": "Kuminga"
  },
  {
    "status": "ACTIVE",
    "order": 11,
    "personId": 1631218,
    "jerseyNum": "32",
    "starter": "0",
    "oncourt": "0",
    "played": "0",
    "statistics": {
      "assists": 0,
      "blocks": 0,
      "blocksReceived": 0,
      "fieldGoalsAttempted": 0,
      "fieldGoalsMade": 0,
      "fieldGoalsPercentage": 0,
      "foulsOffensive": 0,
      "foulsDrawn": 0,
      "foulsPersonal": 0,
      "foulsTechnical": 0,
      "freeThrowsAttempted": 0,
      "freeThrowsMade": 0,
      "freeThrowsPercentage": 0,
      "minus": 0,
      "minutes": "PT00M00.00S",
      "minutesCalculated": "PT00M",
      "plus": 0,
      "plusMinusPoints": 0,
      "points": 0,
      "pointsFastBreak": 0,
      "pointsInThePaint": 0,
      "pointsSecondChance": 0,
      "reboundsDefensive": 0,
      "reboundsOffensive": 0,
      "reboundsTotal": 0,
      "steals": 0,
      "threePointersAttempted": 0,
      "threePointersMade": 0,
      "threePointersPercentage": 0,
      "turnovers": 0,
      "twoPointersAttempted": 0,
      "twoPointersMade": 0,
      "twoPointersPercentage": 0
    },
    "name": "Trayce Jackson-Davis",
    "nameI": "T. Jackson-Davis",
    "firstName": "Trayce",
    "familyName": "Jackson-Davis"
  },
  {
    "status": "ACTIVE",
    "order": 12,
    "personId": 202709,
    "jerseyNum": "1",
    "starter": "0",
    "oncourt": "0",
    "played": "0",
    "statistics": {
      "assists": 0,
      "blocks": 0,
      "blocksReceived": 0,
      "fieldGoalsAttempted": 0,
      "fieldGoalsMade": 0,
      "fieldGoalsPercentage": 0,
      "foulsOffensive": 0,
      "foulsDrawn": 0,
      "foulsPersonal": 0,
      "foulsTechnical": 0,
      "freeThrowsAttempted": 0,
      "freeThrowsMade": 0,
      "freeThrowsPercentage": 0,
      "minus": 0,
      "minutes": "PT00M00.00S",
      "minutesCalculated": "PT00M",
      "plus": 0,
      "plusMinusPoints": 0,
      "points": 0,
      "pointsFastBreak": 0,
      "pointsInThePaint": 0,
      "pointsSecondChance": 0,
      "reboundsDefensive": 0,
      "reboundsOffensive": 0,
      "reboundsTotal": 0,
      "steals": 0,
      "threePointersAttempted": 0,
      "threePointersMade": 0,
      "threePointersPercentage": 0,
      "turnovers": 0,
      "twoPointersAttempted": 0,
      "twoPointersMade": 0,
      "twoPointersPercentage": 0
    },
    "name": "Cory Joseph",
    "nameI": "C. Joseph",
    "firstName": "Cory",
    "familyName": "Joseph"
  },
  {
    "status": "ACTIVE",
    "notPlayingReason": "DNP_INJURY",
    "notPlayingDescription": "Right Calf; Strain",
    "order": 13,
    "personId": 1627780,
    "jerseyNum": "0",
    "starter": "0",
    "oncourt": "0",
    "played": "0",
    "statistics": {
      "assists": 0,
      "blocks": 0,
      "blocksReceived": 0,
      "fieldGoalsAttempted": 0,
      "fieldGoalsMade": 0,
      "fieldGoalsPercentage": 0,
      "foulsOffensive": 0,
      "foulsDrawn": 0,
      "foulsPersonal": 0,
      "foulsTechnical": 0,
      "freeThrowsAttempted": 0,
      "freeThrowsMade": 0,
      "freeThrowsPercentage": 0,
      "minus": 0,
      "minutes": "PT00M00.00S",
      "minutesCalculated": "PT00M",
      "plus": 0,
      "plusMinusPoints": 0,
      "points": 0,
      "pointsFastBreak": 0,
      "pointsInThePaint": 0,
      "pointsSecondChance": 0,
      "reboundsDefensive": 0,
      "reboundsOffensive": 0,
      "reboundsTotal": 0,
      "steals": 0,
      "threePointersAttempted": 0,
      "threePointersMade": 0,
      "threePointersPercentage": 0,
      "turnovers": 0,
      "twoPointersAttempted": 0,
      "twoPointersMade": 0,
      "twoPointersPercentage": 0
    },
    "name": "Gary Payton II",
    "nameI": "G. Payton II",
    "firstName": "Gary",
    "familyName": "Payton II"
  },
  {
    "status": "INACTIVE",
    "notPlayingReason": "INACTIVE_GLEAGUE_TWOWAY",
    "order": 14,
    "personId": 1630586,
    "jerseyNum": "12",
    "starter": "0",
    "oncourt": "0",
    "played": "0",
    "statistics": {
      "assists": 0,
      "blocks": 0,
      "blocksReceived": 0,
      "fieldGoalsAttempted": 0,
      "fieldGoalsMade": 0,
      "fieldGoalsPercentage": 0,
      "foulsOffensive": 0,
      "foulsDrawn": 0,
      "foulsPersonal": 0,
      "foulsTechnical": 0,
      "freeThrowsAttempted": 0,
      "freeThrowsMade": 0,
      "freeThrowsPercentage": 0,
      "minus": 0,
      "minutes": "PT00M00.00S",
      "minutesCalculated": "PT00M",
      "plus": 0,
      "plusMinusPoints": 0,
      "points": 0,
      "pointsFastBreak": 0,
      "pointsInThePaint": 0,
      "pointsSecondChance": 0,
      "reboundsDefensive": 0,
      "reboundsOffensive": 0,
      "reboundsTotal": 0,
      "steals": 0,
      "threePointersAttempted": 0,
      "threePointersMade": 0,
      "threePointersPercentage": 0,
      "turnovers": 0,
      "twoPointersAttempted": 0,
      "twoPointersMade": 0,
      "twoPointersPercentage": 0
    },
    "name": "Usman Garuba",
    "nameI": "U. Garuba",
    "firstName": "Usman",
    "familyName": "Garuba"
  },
  {
    "status": "INACTIVE",
    "notPlayingReason": "INACTIVE_GLEAGUE_TWOWAY",
    "order": 15,
    "personId": 1631311,
    "jerseyNum": "25",
    "starter": "0",
    "oncourt": "0",
    "played": "0",
    "statistics": {
      "assists": 0,
      "blocks": 0,
      "blocksReceived": 0,
      "fieldGoalsAttempted": 0,
      "fieldGoalsMade": 0,
      "fieldGoalsPercentage": 0,
      "foulsOffensive": 0,
      "foulsDrawn": 0,
      "foulsPersonal": 0,
      "foulsTechnical": 0,
      "freeThrowsAttempted": 0,
      "freeThrowsMade": 0,
      "freeThrowsPercentage": 0,
      "minus": 0,
      "minutes": "PT00M00.00S",
      "minutesCalculated": "PT00M",
      "plus": 0,
      "plusMinusPoints": 0,
      "points": 0,
      "pointsFastBreak": 0,
      "pointsInThePaint": 0,
      "pointsSecondChance": 0,
      "reboundsDefensive": 0,
      "reboundsOffensive": 0,
      "reboundsTotal": 0,
      "steals": 0,
      "threePointersAttempted": 0,
      "threePointersMade": 0,
      "threePointersPercentage": 0,
      "turnovers": 0,
      "twoPointersAttempted": 0,
      "twoPointersMade": 0,
      "twoPointersPercentage": 0
    },
    "name": "Lester Quinones",
    "nameI": "L. Quinones",
    "firstName": "Lester",
    "familyName": "Quinones"
  },
  {
    "status": "INACTIVE",
    "notPlayingReason": "INACTIVE_GLEAGUE_TWOWAY",
    "order": 16,
    "personId": 1629010,
    "jerseyNum": "18",
    "starter": "0",
    "oncourt": "0",
    "played": "0",
    "statistics": {
      "assists": 0,
      "blocks": 0,
      "blocksReceived": 0,
      "fieldGoalsAttempted": 0,
      "fieldGoalsMade": 0,
      "fieldGoalsPercentage": 0,
      "foulsOffensive": 0,
      "foulsDrawn": 0,
      "foulsPersonal": 0,
      "foulsTechnical": 0,
      "freeThrowsAttempted": 0,
      "freeThrowsMade": 0,
      "freeThrowsPercentage": 0,
      "minus": 0,
      "minutes": "PT00M00.00S",
      "minutesCalculated": "PT00M",
      "plus": 0,
      "plusMinusPoints": 0,
      "points": 0,
      "pointsFastBreak": 0,
      "pointsInThePaint": 0,
      "pointsSecondChance": 0,
      "reboundsDefensive": 0,
      "reboundsOffensive": 0,
      "reboundsTotal": 0,
      "steals": 0,
      "threePointersAttempted": 0,
      "threePointersMade": 0,
      "threePointersPercentage": 0,
      "turnovers": 0,
      "twoPointersAttempted": 0,
      "twoPointersMade": 0,
      "twoPointersPercentage": 0
    },
    "name": "Jerome Robinson",
    "nameI": "J. Robinson",
    "firstName": "Jerome",
    "familyName": "Robinson"
  },
  {
    "status": "INACTIVE",
    "notPlayingReason": "INACTIVE_GLEAGUE_ON_ASSIGNMENT",
    "order": 17,
    "personId": 1630611,
    "jerseyNum": "15",
    "starter": "0",
    "oncourt": "0",
    "played": "0",
    "statistics": {
      "assists": 0,
      "blocks": 0,
      "blocksReceived": 0,
      "fieldGoalsAttempted": 0,
      "fieldGoalsMade": 0,
      "fieldGoalsPercentage": 0,
      "foulsOffensive": 0,
      "foulsDrawn": 0,
      "foulsPersonal": 0,
      "foulsTechnical": 0,
      "freeThrowsAttempted": 0,
      "freeThrowsMade": 0,
      "freeThrowsPercentage": 0,
      "minus": 0,
      "minutes": "PT00M00.00S",
      "minutesCalculated": "PT00M",
      "plus": 0,
      "plusMinusPoints": 0,
      "points": 0,
      "pointsFastBreak": 0,
      "pointsInThePaint": 0,
      "pointsSecondChance": 0,
      "reboundsDefensive": 0,
      "reboundsOffensive": 0,
      "reboundsTotal": 0,
      "steals": 0,
      "threePointersAttempted": 0,
      "threePointersMade": 0,
      "threePointersPercentage": 0,
      "turnovers": 0,
      "twoPointersAttempted": 0,
      "twoPointersMade": 0,
      "twoPointersPercentage": 0
    },
    "name": "Gui Santos",
    "nameI": "G. Santos",
    "firstName": "Gui",
    "familyName": "Santos"
  }
]
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

### Schedule

```php
$schedule = new NBALive\NBASchedule('2023-12-20');

//Creates the array
$schedule->schedule;


//Get tomorrow's games
$tomorrow = (new DateTimeImmutable('tomorrow', new DateTimeZone('America/New_York')))->format('Y-m-d');

$schedule = new NBALive\NBASchedule($tomorrow);
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

Seasons:

```json
[
  {
    "type": 1,
    "year": 2010
  },
  {
    "type": 2,
    "year": 2010
  },
  {
    "type": 4,
    "year": 2010
  },
  {
    "type": 1,
    "year": 2011
  },
  {
    "type": 2,
    "year": 2011
  },
  {
    "type": 4,
    "year": 2011
  },
  {
    "type": 1,
    "year": 2012
  },
  {
    "type": 2,
    "year": 2012
  },
  {
    "type": 3,
    "year": 2012
  },
  {
    "type": 4,
    "year": 2012
  },
  {
    "type": 1,
    "year": 2013
  },
  {
    "type": 2,
    "year": 2013
  },
  {
    "type": 3,
    "year": 2013
  },
  {
    "type": 4,
    "year": 2013
  },
  {
    "type": 2,
    "year": 2014
  },
  {
    "type": 1,
    "year": 2015
  },
  {
    "type": 2,
    "year": 2015
  },
  {
    "type": 3,
    "year": 2015
  },
  {
    "type": 4,
    "year": 2015
  },
  {
    "type": 1,
    "year": 2016
  },
  {
    "type": 2,
    "year": 2016
  },
  {
    "type": 3,
    "year": 2016
  },
  {
    "type": 4,
    "year": 2016
  },
  {
    "type": 1,
    "year": 2017
  },
  {
    "type": 2,
    "year": 2017
  },
  {
    "type": 3,
    "year": 2017
  },
  {
    "type": 4,
    "year": 2017
  },
  {
    "type": 1,
    "year": 2018
  },
  {
    "type": 2,
    "year": 2018
  },
  {
    "type": 3,
    "year": 2018
  },
  {
    "type": 4,
    "year": 2018
  },
  {
    "type": 1,
    "year": 2019
  },
  {
    "type": 2,
    "year": 2019
  },
  {
    "type": 4,
    "year": 2019
  },
  {
    "type": 1,
    "year": 2020
  },
  {
    "type": 2,
    "year": 2020
  },
  {
    "type": 3,
    "year": 2020
  },
  {
    "type": 4,
    "year": 2020
  },
  {
    "type": 1,
    "year": 2021
  },
  {
    "type": 2,
    "year": 2021
  },
  {
    "type": 5,
    "year": 2021
  },
  {
    "type": 1,
    "year": 2022
  },
  {
    "type": 2,
    "year": 2022
  },
  {
    "type": 3,
    "year": 2022
  },
  {
    "type": 1,
    "year": 2023
  },
  {
    "type": 2,
    "year": 2023
  }
]
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