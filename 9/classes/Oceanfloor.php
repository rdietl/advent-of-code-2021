<?php

namespace Day9;

class Oceanfloor {

    /**
     * @var Point[][]
     */
    protected array $heightMap = [];

    /**
     * @var Point[]
     */
    protected array $lowpoints = [];

    /**
     * @var Basin[]
     */
    protected array $basins;

    protected int $xSize = 0;
    protected int $ySize = 0;

    public function __construct($dataFile)
    {
        $this->populateHeightmap($dataFile);
        $this->findLowpoints();
        $this->findBasins();
    }

    private function populateHeightmap($dataFile): void
    {
        $rawData = file_get_contents($dataFile);

        $rows = explode("\n", $rawData);

        foreach ($rows as $y => $row) {
            if (!strlen($row)) {
                continue;
            }
            $this->ySize = max($this->ySize, $y);
            foreach (str_split($row) as $x => $height) {
                $this->xSize = max($this->xSize, $x);
                if (!isset($this->heightMap[$x])) {
                    $this->heightMap[$x] = [];
                }
                $this->heightMap[$x][$y] = new Point($x,$y, $height);
            }
        }
    }

    private function findLowpoints(): void
    {
        // Find lowpoints
        foreach ($this->heightMap as $x => $column) {
            foreach ($column as $y => $height) {
                $point = $this->heightMap[$x][$y];
                if ($x > 0) {
                    $point->setNeighbor(Point::DIR_WEST, $this->heightMap[$x-1][$y]);
                }
                if ($y > 0) {
                    $point->setNeighbor(Point::DIR_NORTH, $this->heightMap[$x][$y-1]);
                }
                if ($x < $this->xSize) {
                    $point->setNeighbor(Point::DIR_EAST, $this->heightMap[$x+1][$y]);
                }
                if ($y < $this->ySize) {
                    $point->setNeighbor(Point::DIR_SOUTH, $this->heightMap[$x][$y+1]);
                }
                if ($point->getHeight() < min($point->getNeighborHeights())) {
                    $this->lowpoints[] = $point;
                    echo sprintf("Lowpoint found at %d/%d: %d\n", $x, $y, $point->getHeight());
                }
            }
        }
    }

    private function findBasins()
    {
        foreach ($this->getLowpoints() as $lowpoint) {
            if (!$lowpoint->hasBasin()) {
                $basin = new Basin();
                $basin->gatherPointsFrom($lowpoint);
                $this->basins[] = $basin;
            }
        }
    }

    public function getLowpoints(): array
    {
        return $this->lowpoints;
    }

    /**
     * @return Basin[]
     */
    public function getBasins(): array
    {
        return $this->basins;
    }

}
