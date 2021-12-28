<?php

namespace Day9;

class Point {

    const DIR_NORTH = 1;
    const DIR_EAST  = 2;
    const DIR_SOUTH = 3;
    const DIR_WEST  = 4;

    /**
     * @var Point[]
     */
    public array $neighbors = [];

    protected ?Basin $basin = null;

    public function setNeighbor(int $direction, Point $neighbor)
    {
        switch ($direction) {
            case static::DIR_NORTH:
            case static::DIR_EAST:
            case static::DIR_SOUTH:
            case static::DIR_WEST:
                $this->neighbors[$direction] = $neighbor;
                break;
            default:
                throw new \InvalidArgumentException(sprintf('Invalid direction: "%s"', $direction));
        }

    }

    public function __construct(
        public int $x,
        public int $y,
        public int $height
    )
    {

    }

    /**
     * @return Point[]
     */
    public function getNeighbors(): array
    {
        return $this->neighbors;
    }

    /**
     * @return int[]
     */
    public function getNeighborHeights(): array
    {
        $heights = [];

        foreach ($this->neighbors as $direction => $neighbor) {
            $heights[$direction] = $neighbor->getHeight();
        }

        return  $heights;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getBasin(): ?Basin
    {
        return $this->basin;
    }

    public function setBasin(Basin $basin): void
    {
        $this->basin = $basin;
    }

    public function hasBasin(): bool
    {
        return !is_null($this->basin);
    }

}
