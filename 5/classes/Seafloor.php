<?php
namespace Day5;

class Seafloor
{
    /**
     * @var int[][]
     */
    public array $points = [];

    public function __construct(
        public int $sizeX,
        public int $sizeY
    )
    {
        // Fill seafloor with zeros
        for ($x = 0; $x <= $this->sizeX; ++$x) {
            $this->points[$x] = [];
            for ($y = 0; $y <= $this->sizeY; ++$y) {
                $this->points[$x][$y] = 0;
            }
        }
    }

    /**
     * Increase danger levels along a given line
     *
     * @param Line $line
     */
    public function drawLine(Line $line)
    {
        // Determine number of points to draw
        $deltaX         = abs($line->start->x - $line->end->x);
        $deltaY         = abs($line->start->y - $line->end->y);
        $numberOfPoints = 1 + max($deltaX, $deltaY);

        // Determine in which "direction" the X/Y coordinates increase - use "inverted" spaceship operator
        $stepX          = -($line->start->x <=> $line->end->x);
        $stepY          = -($line->start->y <=> $line->end->y);

        // Draw each point
        for ($pointIndex = 0; $pointIndex < $numberOfPoints; ++$pointIndex) {
            $x = $line->start->x + $stepX * $pointIndex;
            $y = $line->start->y + $stepY * $pointIndex;
            $this->points[$x][$y]++;
        }
    }

    /**
     * Determine the number of points on the seafloor with danger level greater than given limit
     *
     * @param int $limit
     * @return int
     */
    public function getPointsGreaterThan(int $limit): int
    {
        $pointCount = 0;

        for ($x = 0; $x <= $this->sizeX; ++$x) {
            for ($y = 0; $y <= $this->sizeY; ++$y) {
                if ($this->points[$x][$y] > $limit) {
                    $pointCount++;
                }
            }
        }

        return $pointCount;
    }

    public function __toString(): string
    {
        $text = '';

        for ($y = 0; $y <= $this->sizeY; ++$y) {
            for ($x = 0; $x <= $this->sizeX; ++$x) {
                $text .= ' ' . $this->points[$x][$y];
            }
            $text .= "\n";
        }

        return $text;
    }
}
