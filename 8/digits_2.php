<?php

// DEMO
//$rawData = file_get_contents(__DIR__ . '/data/demo.txt');

// ACTUAL
$rawData = file_get_contents(__DIR__ . '/data/actual.txt');

$rows = explode("\n", $rawData);

$data = [];
$matchCount = 0;
$solution = 0;

foreach ($rows as $row) {
    // skip empty lines
    if (!stristr($row, '|')) continue;

    // split by "|" symbol
    list($signalPatterns, $outputValues) = explode('|', $row);

    // Extract signal patterns
    preg_match_all('/([a-g]+)/i', trim($signalPatterns), $signals);
    $signals = $signals[1];
    array_walk($signals, 'sortString');
    // Extract outputs
    preg_match_all('/([a-g]+)/i', trim($outputValues), $outputs);
    $outputs = $outputs[1];
    array_walk($outputs, 'sortString');

    // -----------------------------------------------
    // Step 1a: strings to numbers - easy finds
    // -----------------------------------------------
    $one = [];
    $four  = [];
    $seven = [];
    $eight = [];
    $twoOrThreeOrFive = [];
    $zeroOrSixOrNine = [];
    foreach ($signals as $signal) {
        $candidate = str_split($signal);
        if       (count($candidate) == 2) { // "1"
            $one = $candidate;
        } elseif (count($candidate) == 3) { // "7"
            $seven = $candidate;
        } elseif (count($candidate) == 4) { // "4"
            $four = $candidate;
        } elseif (count($candidate) == 7) { // "8"
            $eight = $candidate;
        } elseif (count($candidate) == 5) { // "2" "3" "5"
            $twoOrThreeOrFive[] = $candidate;
        } elseif (count($candidate) == 6) { // "0" "6" "9"
            $zeroOrSixOrNine[] = $candidate;
        }
    }
    // -----------------------------------------------
    // Step 1b: strings to numbers - more tricky finds
    // -----------------------------------------------
    $zero = [];
    $six = [];
    $nine = [];
    foreach ($zeroOrSixOrNine as $candidate) {
        if (count(array_intersect($candidate, $one)) != 2) {
            // Out of "0" "6" "9", only number "6" does not intersect "1"
            $six = $candidate;
        } elseif (count(array_intersect($candidate, $four)) == 4) {
            // Out of "0" "6" "9", only number "9" fully intersects "4"
            $nine = $candidate;
        } else {
            $zero = $candidate;
        }
    }
    unset($zeroOrSixOrNine);

    $two = [];
    $three = [];
    $five = [];
    foreach ($twoOrThreeOrFive as $candidate) {
        if (count(array_intersect($candidate, $seven)) == 3) {
            // Out of "2" "3" "5", only number "3" fully intersects "7"
            $three = $candidate;
        } elseif (count(array_intersect($candidate, $six)) == 5) {
            // Out of "2" "3" "5", only number "5" fully intersects "6"
            $five = $candidate;
        } else {
            $two = $candidate;
        }
    }
    unset($twoOrThreeOrFive);

    // -----------------------------------------------
    // Step 2: deduct signal to segment mapping
    // -----------------------------------------------
    //  1111
    // 2    3
    // 2    3
    //  4444
    // 5    6
    // 5    6
    //  7777
    $signalMapping = [];

    // Segment "1" is the part of "7" that is not found in "1"
    foreach (array_diff($seven, $one) as $diff) {
        $signalMapping[$diff] = 1;
    }
    // Segment "2" is the part of "8" that is not found in "2" or "3"
    foreach (array_diff($eight, $two, $three) as $diff) {
        $signalMapping[$diff] = 2;
    }
    // Segment "3" is the part of "8" that is not found in "6"
    foreach (array_diff($eight, $six) as $diff) {
        $signalMapping[$diff] = 3;
    }
    // Segment "4" is the part of "8" that is not found in "0"
    foreach (array_diff($eight, $zero) as $diff) {
        $signalMapping[$diff] = 4;
    }
    // Segment "5" is the part of "8" that is not found in "9"
    foreach (array_diff($eight, $nine) as $diff) {
        $signalMapping[$diff] = 5;
    }
    // Segment "6" is the part of "7" that is not found in "2"
    foreach (array_diff($seven, $two) as $diff) {
        $signalMapping[$diff] = 6;
    }
    // Segment "7" is what remains from "8" when deducting all the others
    foreach (array_diff($eight, array_keys($signalMapping)) as $diff) {
        $signalMapping[$diff] = 7;
    }

    // -----------------------------------------------
    // Step 3: translate outputs to actual numbers
    // -----------------------------------------------
    //  1111
    // 2    3
    // 2    3
    //  4444
    // 5    6
    // 5    6
    //  7777
    $numbers = [
        '123567' => 0,
        '36' => 1,
        '13457' => 2,
        '13467' => 3,
        '2346' => 4,
        '12467' => 5,
        '124567' => 6,
        '136' => 7,
        '1234567' => 8,
        '123467' => 9,
    ];

    $digits = '';
    foreach ($outputs as $output) {
        $segments = '';
        foreach (str_split($output) as $character) {
            $segments .= $signalMapping[$character];
        }
        sortString($segments);
        $digits .= $numbers[$segments];
    }
    echo implode(" ", $outputs) . ": " . $digits."\n";
    $solution += intval($digits);
}

echo sprintf('Solution is: %d', $solution);

function sortString(&$string) {
    $stringParts = str_split($string);
    sort($stringParts);
    $string = implode($stringParts);
}
