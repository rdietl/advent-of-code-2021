<?php

$csv    = file_get_contents(__DIR__ . '/input.csv');
//$csv    = file_get_contents(__DIR__ . '/demodata.csv');
$rows = array_filter(explode("\n", $csv), function($row) {
    return !empty($row);
});

$bitCounts = [];
for ($rowIndex = 0; $rowIndex < count($rows); ++$rowIndex) {
    $row = $rows[$rowIndex];
    for ($columnIndex = 0; $columnIndex < strlen($row); ++$columnIndex) {
        if (!isset($bitCounts[$columnIndex])) {
            $bitCounts[$columnIndex] = ['0' => 0, '1' => 0];
        }
        $bitInCell = $row[$columnIndex];
        $bitCounts[$columnIndex][$bitInCell]++;
    }
}

$gamma = '';
$epsilon = '';
foreach ($bitCounts as $columnIndex => $counts) {
    if ($counts['1'] > $counts['0']) {
        $gamma .= '1';
        $epsilon .= '0';
    } else {
        $gamma .= '0';
        $epsilon .= '1';
    }
}
var_dump([
   'gamma' => $gamma,
   'gammaInt' => bindec($gamma),
   'epsilon' => $epsilon,
   'epsilonInt' => bindec($epsilon),
   'solution' => bindec($gamma) * bindec($epsilon),
]);
