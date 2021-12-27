<?php

// DEMO
//$data = [3,4,3,1,2];
//$numDays = 18;
//$numDays = 80;
//$numDays = 256;

// ACTUAL
$data = [3,1,4,2,1,1,1,1,1,1,1,4,1,4,1,2,1,1,2,1,3,4,5,1,1,4,1,3,3,1,1,1,1,3,3,1,3,3,1,5,5,1,1,3,1,1,2,1,1,1,3,1,4,3,2,1,4,3,3,1,1,1,1,5,1,4,1,1,1,4,1,4,4,1,5,1,1,4,5,1,1,2,1,1,1,4,1,2,1,1,1,1,1,1,5,1,3,1,1,4,4,1,1,5,1,2,1,1,1,1,5,1,3,1,1,1,2,2,1,4,1,3,1,4,1,2,1,1,1,1,1,3,2,5,4,4,1,3,2,1,4,1,3,1,1,1,2,1,1,5,1,2,1,1,1,2,1,4,3,1,1,1,4,1,1,1,1,1,2,2,1,1,5,1,1,3,1,2,5,5,1,4,1,1,1,1,1,2,1,1,1,1,4,5,1,1,1,1,1,1,1,1,1,3,4,4,1,1,4,1,3,4,1,5,4,2,5,1,2,1,1,1,1,1,1,4,3,2,1,1,3,2,5,2,5,5,1,3,1,2,1,1,1,1,1,1,1,1,1,3,1,1,1,3,1,4,1,4,2,1,3,4,1,1,1,2,3,1,1,1,4,1,2,5,1,2,1,5,1,1,2,1,2,1,1,1,1,4,3,4,1,5,5,4,1,1,5,2,1,3];
//$numDays = 18;
//$numDays = 80;
$numDays = 256;

// For every possible age of a fish, track how many are this old
$fishAges = array_fill(0, 9, 0);

// Prefill from data
foreach ($data as $fishAge) {
    $fishAges[$fishAge] += 1;
}

// Update the count of fish for every age, every day
for ($day = 0; $day < $numDays; $day += 1) {
    $fishAges = [
        0 => $fishAges[1],
        1 => $fishAges[2],
        2 => $fishAges[3],
        3 => $fishAges[4],
        4 => $fishAges[5],
        5 => $fishAges[6],
        6 => $fishAges[7] + $fishAges[0], // include offspring
        7 => $fishAges[8],
        8 => $fishAges[0],
    ];
}

echo sprintf("There are %d fish after %d days\n", array_sum($fishAges), $numDays);
