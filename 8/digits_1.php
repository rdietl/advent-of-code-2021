<?php

// DEMO
//$rawData = file_get_contents(__DIR__ . '/data/demo.txt');

// ACTUAL
$rawData = file_get_contents(__DIR__ . '/data/actual.txt');

$rows = explode("\n", $rawData);
$data = [];
$matchCount = 0;
foreach ($rows as $row) {
    if (!stristr($row, '|')) continue;
    list($signalPatterns, $outputValues) = explode('|', $row);
    preg_match('/ ?([a-z]+) ([a-z]+) ([a-z]+) ([a-z]+)/i', $outputValues, $matches);

    // Part 1:
    for ($key = 1; $key <= 4; ++$key) {
        $output = $matches[$key];
        if (in_array(strlen($output), [2, 3, 4, 7])) {
            $matchCount++;
        }
    }
}

echo sprintf('Found %d "simple" matches', $matchCount);
