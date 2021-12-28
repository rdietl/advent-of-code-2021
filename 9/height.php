<?php

use Day9\Oceanfloor;

include 'classes/Oceanfloor.php';
include 'classes/Point.php';
include 'classes/Basin.php';

// DEMO
//$oceanfloor = new Oceanfloor(__DIR__ . '/data/demo.txt');
// ACTUAL
$oceanfloor = new Oceanfloor(__DIR__ . '/data/actual.txt');

$riskLevel = 0;
foreach ($oceanfloor->getLowpoints() as $lowpoint) {
    $riskLevel += $lowpoint->getHeight() + 1;
}

echo sprintf("Solution: risk level %d\n", $riskLevel);
