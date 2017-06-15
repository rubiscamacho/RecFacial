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

const BOOTSTRAP_SUCCESS = 0;
const BOOTSTRAP_INFO = 1;
const BOOTSTRAP_WARNING = 2;
const BOOTSTRAP_ERROR = 3;

function bootstrap_message($type = null){
    $classes = [
        BOOTSTRAP_SUCCESS => 'success',
        BOOTSTRAP_INFO => 'info',
        BOOTSTRAP_WARNING => 'warning',
        BOOTSTRAP_ERROR => 'danger',
    ];
    return isset($classes[$type]) ?
        $classes[$type] : $classes[array_rand($classes, 1)];
}
