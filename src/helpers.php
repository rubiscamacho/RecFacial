<?php
declare(strict_types=1);

function dateParse($date)
{
    //DD/MM/AAAA -> AAAA-MM-DD
    $dateArray = explode('/', $date);
    //[dd,mm,aaaa]
    $dateArray = array_reverse($dateArray);
    //[aaaa-mm-dd]
    return implode('-', $dateArray);
}

function numberParse($number)
{
    //1.000,50 -> 1000.50
    $newNumber = str_replace('.', '', $number);
    $newNumber = str_replace(',', '.', $newNumber);
    return $newNumber;

}

