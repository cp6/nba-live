# NBA CDN API Wrapper

A PHP wrapper for getting live NBA game data from the CDN API endpoint. This wrapper formats a lot of the returned data
so you only get what you need but also in a handy manner.

---

## Table of contents

- [Installing](#installing)
- [Todays games](#todays-games)
- [Boxscore](#boxscore)
- [Play by play](#play-by-play)
- [Rotations](#game-rotations)
- [Game summary](#game-summary)
- [Standings](#standings)
- [Schedule](#schedule)
- [Player](#player-data)
- [Team](#team)
- [League leaders](#league-leaders)

---

### Installing

Install with composer:

```
composer require corbpie/nba-live
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

### Boxscore

```php
$boxscore = new NBALive\NBABoxScore('0022301214');

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

### Game rotations

```php
$rotations = new NBALive\NBARotations("0022301203");

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

### Game summary

```php
$sum = new NBALive\NBAGameSummary("0022301203");

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

### Player data

```php
$player = new NBALive\NBAPlayer(202331);

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

### 5th December 2023

One game is live

```json
[
  {
    "status": 2,
    "starting_in": null,
    "game_id": "0022301201",
    "game_code": "20231205\/NYKMIL",
    "margin": 2,
    "home_score": 2,
    "away_score": 4,
    "time_left_string": "Q1 10:29",
    "time_left": "10:29",
    "seconds_left": 629,
    "period": 1,
    "home_team": {
      "id": 1610612749,
      "name": "Bucks",
      "short": "MIL",
      "in_bonus": false,
      "timeouts_remaining": 7,
      "wins": 14,
      "losses": 6,
      "seed": 1
    },
    "away_team": {
      "id": 1610612752,
      "name": "Knicks",
      "short": "NYK",
      "in_bonus": false,
      "timeouts_remaining": 7,
      "wins": 12,
      "losses": 7,
      "seed": 4
    },
    "periods": {
      "one": [
        {
          "home_score": 2,
          "away_score": 4
        }
      ],
      "two": [
        {
          "home_score": 0,
          "away_score": 0
        }
      ],
      "three": [
        {
          "home_score": 0,
          "away_score": 0
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
    "game_series": "East Quarterfinal",
    "game_type": "in-season-knockout",
    "game_time_utc": "2023-12-06 00:30:00",
    "game_time_et": "2023-12-05 19:30:00"
  },
  {
    "status": 1,
    "starting_in": "02:22",
    "game_id": "0022301203",
    "game_code": "20231205\/PHXLAL",
    "margin": null,
    "home_score": null,
    "away_score": null,
    "time_left_string": null,
    "time_left": null,
    "seconds_left": 0,
    "period": null,
    "home_team": {
      "id": 1610612747,
      "name": "Lakers",
      "short": "LAL",
      "in_bonus": false,
      "timeouts_remaining": null,
      "wins": 12,
      "losses": 9,
      "seed": 1
    },
    "away_team": {
      "id": 1610612756,
      "name": "Suns",
      "short": "PHX",
      "in_bonus": false,
      "timeouts_remaining": null,
      "wins": 12,
      "losses": 8,
      "seed": 4
    },
    "periods": [],
    "game_series": "West Quarterfinal",
    "game_type": "in-season-knockout",
    "game_time_utc": "2023-12-06 03:00:00",
    "game_time_et": "2023-12-05 22:00:00"
  }
]
```

Both games are still upcoming:

```json
[
  {
    "status": 1,
    "starting_in": "00:03",
    "game_id": "0022301201",
    "game_code": "20231205\/NYKMIL",
    "margin": null,
    "home_score": null,
    "away_score": null,
    "time_left_string": null,
    "time_left": null,
    "seconds_left": 0,
    "period": null,
    "home_team": {
      "id": 1610612749,
      "name": "Bucks",
      "short": "MIL",
      "in_bonus": false,
      "timeouts_remaining": null,
      "wins": 14,
      "losses": 6,
      "seed": 1
    },
    "away_team": {
      "id": 1610612752,
      "name": "Knicks",
      "short": "NYK",
      "in_bonus": false,
      "timeouts_remaining": null,
      "wins": 12,
      "losses": 7,
      "seed": 4
    },
    "periods": [],
    "game_series": "East Quarterfinal",
    "game_type": "in-season-knockout",
    "game_time_utc": "2023-12-06 00:30:00",
    "game_time_et": "2023-12-05 19:30:00"
  },
  {
    "status": 1,
    "starting_in": "02:33",
    "game_id": "0022301203",
    "game_code": "20231205\/PHXLAL",
    "margin": null,
    "home_score": null,
    "away_score": null,
    "time_left_string": null,
    "time_left": null,
    "seconds_left": 0,
    "period": null,
    "home_team": {
      "id": 1610612747,
      "name": "Lakers",
      "short": "LAL",
      "in_bonus": false,
      "timeouts_remaining": null,
      "wins": 12,
      "losses": 9,
      "seed": 1
    },
    "away_team": {
      "id": 1610612756,
      "name": "Suns",
      "short": "PHX",
      "in_bonus": false,
      "timeouts_remaining": null,
      "wins": 12,
      "losses": 8,
      "seed": 4
    },
    "periods": [],
    "game_series": "West Quarterfinal",
    "game_type": "in-season-knockout",
    "game_time_utc": "2023-12-06 03:00:00",
    "game_time_et": "2023-12-05 22:00:00"
  }
]
```
