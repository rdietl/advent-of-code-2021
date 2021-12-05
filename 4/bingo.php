<?php
namespace Day4;

include 'classes/CardFactory.php';
include 'classes/Card.php';
include 'classes/Series.php';

// ----------------------------------
// Gather data, build cards
// ----------------------------------

// demo:
// $numbers = [7,4,9,5,11,17,23,2,0,14,21,24,10,16,13,6,15,25,12,22,18,20,8,19,3,26,1];
// $txt = file_get_contents(__DIR__ . '/data/demo.txt');

// actual:
$numbers = [93,35,66,15,6,51,49,67,16,77,80,8,1,57,99,92,14,9,13,23,33,11,43,50,60,96,40,25,22,39,56,18,2,7,34,68,26,90,75,41,4,95,71,30,42,5,46,55,27,98,79,12,65,73,29,28,17,48,81,32,59,63,85,91,52,21,38,31,61,83,97,62,44,70,19,69,36,47,74,58,78,24,72,0,10,88,37,87,3,45,82,76,54,84,20,94,86,53,64,89];
$txt = file_get_contents(__DIR__ . '/data/actual.txt');

$cards = [];
$cardsTxt = explode("\n\n", $txt);

foreach ($cardsTxt as $cardTxt) {
    $cards[] = CardFactory::createFromText($cardTxt);
}

// ----------------------------------
// Perform calculation:
// ----------------------------------
$winnerCard = null;
$loserCard = null;

foreach ($numbers as $number) {
    foreach ($cards as $key => $card) {

        $card->hit($number);

        if ($card->isBingo()) {
            // First card to Bingo is winner
            if (is_null($winnerCard)) {
                $winnerCard = $card;
            }
            unset($cards[$key]);
        }

        // No card left - this is the loser
        if (count($cards) < 1) {
            $loserCard = $card;
        }
    }
}

// ----------------------------------
// Output Solution:
// ----------------------------------
echo "Winner Card:\n";
echo "$winnerCard\n";
echo sprintf("Winner solution: %d\n", $winnerCard->getScore() * $winnerCard->getLastNumberHit());
echo "\n";
echo "Loser Card:\n";
echo "$loserCard\n";
echo sprintf("Loser solution: %d\n", $loserCard->getScore() * $loserCard->getLastNumberHit());
