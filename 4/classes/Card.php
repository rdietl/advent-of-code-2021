<?php
namespace Day4;

use JetBrains\PhpStorm\Pure;

class Card
{
    /**
     * @var Series[]
     */
    protected array $rows = [];
    /**
     * @var Series[]
     */
    protected array $columns = [];

    protected ?int $lastNumberHit = null;

    public function addRow(Series $row)
    {
        if (count($this->rows) >= Series::$maxNumbers) {
            throw new \Exception('No more rows allowed');
        }
        $this->rows[] = $row;

        // Every row we add affects the columns as well
        if (empty($this->columns)) {
            for ($i=0; $i < Series::$maxNumbers; ++$i) {
                $this->columns[$i] = new Series($this);
            }
        }
        foreach ($row->getNumbers() as $key => $number) {
            $this->columns[$key]->addNumber($number);
        }
    }

    public function hit($number)
    {
        $this->lastNumberHit = $number;

        $candidates = array_merge($this->rows,$this->columns);
        foreach ($candidates as $candidateSeries) {
            $candidateSeries->hit($number);
        }
    }

    #[Pure]
    public function isBingo(): bool
    {
        $candidates = array_merge($this->rows,$this->columns);
        foreach ($candidates as $candidateSeries) {
            if ($candidateSeries->isBingo()) {
                return true;
            }
        }

        return false;
    }

    public function getLastNumberHit(): int
    {
        return $this->lastNumberHit;
    }

    public function getScore(): int
    {
        $score = 0;

        foreach ($this->rows as $row) {
            $rowScore = $row->getScore();
            $score += $rowScore;
        }

        return $score;
    }

    public function __toString(): string
    {
        return implode(separator: "\n", array: $this->rows);
    }
}
