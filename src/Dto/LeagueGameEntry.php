<?php

declare(strict_types=1);

namespace Corbpie\NBALive\Dto;

/**
 * Normalized league game finder entry.
 */
final readonly class LeagueGameEntry
{
    public function __construct(
        public string $seasonId,
        public int $teamId,
        public string $teamAbbr,
        public string $teamName,
        public string $gameId,
        public string $gameDate,
        public string $matchup,
        public string $wl,
        public int|float $min,
        public int|float $pts,
        public int|float $fgm,
        public int|float $fga,
        public float $fgPct,
        public int|float $fg3m,
        public int|float $fg3a,
        public float $fg3Pct,
        public int|float $ftm,
        public int|float $fta,
        public float $ftPct,
        public int|float $oreb,
        public int|float $dreb,
        public int|float $reb,
        public int|float $ast,
        public int|float $stl,
        public int|float $blk,
        public int|float $tov,
        public int|float $pf,
        public int|float $plusMinus,
    ) {
    }

    /**
     * @param array<string, mixed> $row
     */
    public static function fromResultSetRow(array $row): self
    {
        return new self(
            seasonId: (string) ($row['SEASON_ID'] ?? ''),
            teamId: (int) ($row['TEAM_ID'] ?? 0),
            teamAbbr: (string) ($row['TEAM_ABBREVIATION'] ?? ''),
            teamName: (string) ($row['TEAM_NAME'] ?? ''),
            gameId: (string) ($row['GAME_ID'] ?? ''),
            gameDate: (string) ($row['GAME_DATE'] ?? ''),
            matchup: (string) ($row['MATCHUP'] ?? ''),
            wl: (string) ($row['WL'] ?? ''),
            min: (int) ($row['MIN'] ?? 0),
            pts: (int) ($row['PTS'] ?? 0),
            fgm: (int) ($row['FGM'] ?? 0),
            fga: (int) ($row['FGA'] ?? 0),
            fgPct: (float) ($row['FG_PCT'] ?? 0),
            fg3m: (int) ($row['FG3M'] ?? 0),
            fg3a: (int) ($row['FG3A'] ?? 0),
            fg3Pct: (float) ($row['FG3_PCT'] ?? 0),
            ftm: (int) ($row['FTM'] ?? 0),
            fta: (int) ($row['FTA'] ?? 0),
            ftPct: (float) ($row['FT_PCT'] ?? 0),
            oreb: (int) ($row['OREB'] ?? 0),
            dreb: (int) ($row['DREB'] ?? 0),
            reb: (int) ($row['REB'] ?? 0),
            ast: (int) ($row['AST'] ?? 0),
            stl: (int) ($row['STL'] ?? 0),
            blk: (int) ($row['BLK'] ?? 0),
            tov: (int) ($row['TOV'] ?? 0),
            pf: (int) ($row['PF'] ?? 0),
            plusMinus: (int) ($row['PLUS_MINUS'] ?? 0),
        );
    }

    /**
     * @return array<string, float|int|string>
     */
    public function toArray(): array
    {
        return [
            'season_id' => $this->seasonId,
            'team_id' => $this->teamId,
            'team_abbr' => $this->teamAbbr,
            'team_name' => $this->teamName,
            'game_id' => $this->gameId,
            'game_date' => $this->gameDate,
            'matchup' => $this->matchup,
            'wl' => $this->wl,
            'min' => $this->min,
            'pts' => $this->pts,
            'fgm' => $this->fgm,
            'fga' => $this->fga,
            'fg_pct' => $this->fgPct,
            'fg3m' => $this->fg3m,
            'fg3a' => $this->fg3a,
            'fg3_pct' => $this->fg3Pct,
            'ftm' => $this->ftm,
            'fta' => $this->fta,
            'ft_pct' => $this->ftPct,
            'oreb' => $this->oreb,
            'dreb' => $this->dreb,
            'reb' => $this->reb,
            'ast' => $this->ast,
            'stl' => $this->stl,
            'blk' => $this->blk,
            'tov' => $this->tov,
            'pf' => $this->pf,
            'plus_minus' => $this->plusMinus,
        ];
    }
}
