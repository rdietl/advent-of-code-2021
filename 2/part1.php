<?php

$csv    = file_get_contents(__DIR__ . '/instructions.csv');
$instructions = array_filter(explode("\n", $csv), function($instruction) {
    return !empty($instruction);
});

$position = $depth = 0;

foreach ($instructions as $instruction) {
    list($direction, $amount) = explode(' ', $instruction);
    $amount = intval($amount);
    switch ($direction) {
        case 'forward':
            $position += $amount;
            break;
        case 'up':
            $depth -= $amount;
            break;
        case 'down':
            $depth += $amount;
            break;
        default:
            throw new \RuntimeException(sprintf('Cannot interpret direction instruction "%s"', $direction));
    }
}

var_dump([
    'position' => $position,
    'depth' => $depth,
    'solution' => $position * $depth,
]);

