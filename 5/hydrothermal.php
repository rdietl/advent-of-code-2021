<?php
namespace Day5;

include 'classes/Coordinate.php';
include 'classes/Line.php';
include 'classes/Seafloor.php';

// ----------------------------------
// Gather data
// ----------------------------------

// demo:
//$txt = file_get_contents(__DIR__ . '/data/demo.txt');

// actual:
$txt = file_get_contents(__DIR__ . '/data/actual.txt');

$allowDiagonals = true;

$linesTxt = array_filter(explode("\n", $txt), function($row) {
    return !empty($row);
});

$lines = [];
$seafloorSizeX = $seafloorSizeY = 0;

foreach ($linesTxt as $lineTxt) {
    if (preg_match('/(\d+),(\d+) -> (\d+),(\d+)/', $lineTxt, $matches)) {
        $startX = intval($matches[1]);
        $startY = intval($matches[2]);
        $endX =   intval($matches[3]);
        $endY =   intval($matches[4]);
        if ($allowDiagonals || $startX == $endX || $startY == $endY) {
            $lines[] = new Line(
                new Coordinate($startX, $startY),
                new Coordinate($endX, $endY)
            );
            $seafloorSizeX = max($seafloorSizeX, $startX, $endX);
            $seafloorSizeY = max($seafloorSizeY, $startY, $endY);
        } else {
            // skip diagonals
        }
    } else {
        throw new \InvalidArgumentException(sprintf("Invalid line $lineTxt"));
    }
}

// ----------------------------------
// Build Seafloor
// ----------------------------------

$seafloor = new Seafloor($seafloorSizeX, $seafloorSizeY);
foreach ($lines as $line) {
    $seafloor->drawLine($line);
}

// ----------------------------------
// Print solution
// ----------------------------------
echo $seafloor . "\n\n";

var_dump([
    'solution' => $seafloor->getPointsGreaterThan(1),
]);

