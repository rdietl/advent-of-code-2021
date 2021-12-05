<?php
namespace Day4;

class CardFactory
{
    public static function createFromText(string $text): Card
    {
        $card = new Card();
        $rowsText = explode("\n", $text);
        foreach ($rowsText as $rowText) {
            if (empty($rowText)) continue;
            $row = new Series($card);
            $numbers = preg_split('/ +/', $rowText, -1, PREG_SPLIT_NO_EMPTY);
            foreach ($numbers as $number) {
                $row->addNumber(intval($number));
            }
            $card->addRow($row);
        }

        return $card;
    }
}
