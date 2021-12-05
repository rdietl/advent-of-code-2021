<?php

$csv    = file_get_contents(__DIR__ . '/input.csv');
//$csv    = file_get_contents(__DIR__ . '/demodata.csv');
$rowsBackup = array_filter(explode("\n", $csv), function($row) {
    return !empty($row);
});

$result = [];
$columnCount = strlen($rowsBackup[0]);
foreach (['oxygen', 'co2'] as $ratingName) {
    $rows = $rowsBackup;
    for ($columnIndex = 0; $columnIndex < $columnCount; ++$columnIndex) {
        // find bit counts
        $counts = ['0' => 0, '1' => 0];
        foreach ($rows as $rowIndex => $row) {
            $bitInCell = $rows[$rowIndex][$columnIndex];
            $counts[$bitInCell]++;
        }
        // find out which rows to drop
        if ($ratingName === 'oxygen') {
            // "determine the most common value (0 or 1)"
            // "If 0 and 1 are equally common, keep values with a 1"
            if ($counts['1'] >= $counts['0']) {
                $bitToKeep = '1';
            } else {
                $bitToKeep = '0';
            }
        } elseif ($ratingName === 'co2') {
            // "determine the least common value (0 or 1)"
            if ($counts['1'] < $counts['0']) {
                $bitToKeep = '1';
            // "If 0 and 1 are equally common, keep values with a 0"
            } else {
                $bitToKeep = '0';
            }
        }

        // drop them
        foreach ($rows as $rowIndex => $row) {
            if ($rows[$rowIndex][$columnIndex] != $bitToKeep) {
                unset($rows[$rowIndex]);
            }
            if (count($rows) == 1) {
                break 2;
            }
        }
    }
    $result[$ratingName] = array_values($rows)[0];
    $result[$ratingName.'int'] = bindec(array_values($rows)[0]);
}

$result['solution'] = $result['oxygenint'] * $result['co2int'];
var_dump($result);
