<?php
namespace Day4;

class Series
{
    public static $maxNumbers = 5;

    /**
     * @var Card
     */
    protected Card $card;

    /**
     * @var int[]
     */
    protected array $numbers = [];

    /**
     * @var []
     */
    protected array $hitKeys = [];

    /**
     * @param Card $card
     */
    public function __construct(Card $card)
    {
        $this->card = $card;
    }

    public function addNumber(int $number)
    {
        if (count($this->numbers) >= self::$maxNumbers) {
            throw new \Exception('Series size exceeded');
        }
        $this->numbers[] = $number;
    }

    public function getNumbers(): array
    {
        return $this->numbers;
    }

    public function hit(int $number)
    {
        $location = array_search($number, $this->numbers);
        if (false !== $location) {
            $this->hitKeys[$location] = true;
        }
    }

    public function isBingo(): bool
    {
        return count($this->hitKeys) >= self::$maxNumbers;
    }

    public function getScore(): int
    {
        $score = 0;
        foreach ($this->numbers as $location => $number) {
            if (!isset($this->hitKeys[$location])) {
                $score += $number;
            }
        }

        return $score;
    }

    public function __toString(): string
    {
        $series = '';
        foreach ($this->numbers as $location => $number) {
            $number = str_pad($number, 2);
            if (isset($this->hitKeys[$location])) {
                $number = '[' . $number . ']';
            } else {
                $number = ' ' . $number . ' ';
            }
            $series .= $number . ' ';
        }

        return $series;
    }
}
