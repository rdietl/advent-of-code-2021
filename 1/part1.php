<?php

$csv    = file_get_contents(__DIR__ . '/input.csv');
$depths = explode("\n", $csv);

$increases = $decreases = 0;

foreach ($depths as $depth) {
    if (!empty($lastDepth)) {
        if ($depth > $lastDepth) {
            $increases++;
        } else {
            $decreases++;
        }
    }
    $lastDepth = $depth;
}

var_dump([
    'increases' => $increases,
    'decreases' => $decreases,
    'total' => count($depths),
]);
