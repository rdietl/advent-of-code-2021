<?php

use Day9\Oceanfloor;

include 'classes/Oceanfloor.php';
include 'classes/Point.php';
include 'classes/Basin.php';

// DEMO
//$oceanfloor = new Oceanfloor(__DIR__ . '/data/demo.txt');
// ACTUAL
$oceanfloor = new Oceanfloor(__DIR__ . '/data/actual.txt');

$basinSizes = [];
foreach ($oceanfloor->getBasins() as $basin) {
//    echo sprintf("NEW BASIN (size %d)\n", count($basin->getPoints()));
    $basinSizes[] = count($basin->getPoints());
//    foreach ($basin->getPoints() as $point) {
//        echo sprintf("%s/%s/%s\n", $point->x, $point->y, $point->getHeight());
//    }
}
rsort($basinSizes, SORT_NUMERIC);
$resultSet = array_slice($basinSizes, 0, 3);
echo sprintf("Result: %d\n", array_product($resultSet));

