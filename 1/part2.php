<?php

$csv    = file_get_contents(__DIR__ . '/input.csv');
$depths = array_filter(explode("\n", $csv), function($depth) {
    return !empty($depth);
});

$increases = $decreases = 0;

$windows = [];

for ($index = 0; $index < count($depths) - 2; ++$index) {
    $windows[$index] = [
        $depths[$index],
        $depths[$index+1],
        $depths[$index+2],
    ];
    $currentWindowSum = array_sum($windows[$index]);
    if (!empty($lastWindowSum)) {
        if ($currentWindowSum > $lastWindowSum) {
            $increases++;
        } else {
            $decreases++;
        }
    }
    $lastWindowSum = $currentWindowSum;
}

var_dump([
    'increases' => $increases,
    'decreases' => $decreases,
    'total' => count($depths),
]);
