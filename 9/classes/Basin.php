<?php

namespace Day9;

use JetBrains\PhpStorm\Pure;

class Basin {

    /**
     * @var Point[]
     */
    protected array $points;

    public function addPoint(Point $point)
    {
        if (!$this->hasPoint($point)) {
            $this->points[$this->getPointKey($point)] = $point;
            $point->setBasin($this);
        }
    }

    private function getPointKey(Point $point): string
    {
        return sprintf('%s/%s', $point->x, $point->y);
    }

    #[Pure] public function hasPoint(Point $point): bool
    {
        return isset($this->points[$this->getPointKey($point)]);
    }

    public function gatherPointsFrom(Point $point)
    {
        if (!$point->hasBasin() && $point->getHeight() < 9) {
            $this->addPoint($point);
            foreach ($point->getNeighbors() as $neighbor) {
                $this->gatherPointsFrom($neighbor);
            }
        }
    }

    /**
     * @return Point[]
     */
    public function getPoints(): array
    {
        return $this->points;
    }
}
