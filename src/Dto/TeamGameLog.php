<?php

declare(strict_types=1);

namespace Corbpie\NBALive\Dto;

/**
 * Normalized team game log entry.
 */
final readonly class TeamGameLog
{
    public function __construct(
        public string $gameId,
        public string $gameDate,
        public string $matchup,
        public bool $wasWin,
        public int|float $wins,
        public int|float $losses,
        public int|float $winPct,
        public int|float $min,
        public int|float $fgm,
        public int|float $fga,
        public int|float $fgPct,
        public int|float $fg3m,
        public int|float $fg3a,
        public int|float $fg3Pct,
        public int|float $ftm,
        public int|float $fta,
        public int|float $ftPct,
        public int|float $oreb,
        public int|float $dreb,
        public int|float $reb,
        public int|float $ast,
        public int|float $stl,
        public int|float $blk,
        public int|float $tov,
        public int|float $pf,
        public int|float $pts,
    ) {
    }

    /**
     * @param array<string, mixed> $row
     */
    public static function fromResultSetRow(array $row): self
    {
        $gameDate = (string) ($row['GAME_DATE'] ?? '');

        return new self(
            gameId: (string) ($row['Game_ID'] ?? $row['GAME_ID'] ?? ''),
            gameDate: $gameDate !== '' ? date('Y-m-d', strtotime($gameDate)) : '',
            matchup: (string) ($row['MATCHUP'] ?? ''),
            wasWin: ($row['WL'] ?? '') === 'W',
            wins: (int) ($row['W'] ?? 0),
            losses: (int) ($row['L'] ?? 0),
            winPct: (float) ($row['W_PCT'] ?? 0),
            min: (int) ($row['MIN'] ?? 0),
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
            pts: (int) ($row['PTS'] ?? 0),
        );
    }

    /**
     * @return array<string, bool|float|int|string>
     */
    public function toArray(): array
    {
        return [
            'game_id' => $this->gameId,
            'game_date' => $this->gameDate,
            'matchup' => $this->matchup,
            'was_win' => $this->wasWin,
            'wins' => $this->wins,
            'losses' => $this->losses,
            'win_pct' => $this->winPct,
            'min' => $this->min,
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
            'pts' => $this->pts,
        ];
    }
}
