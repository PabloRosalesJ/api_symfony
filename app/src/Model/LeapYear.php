<?php

namespace Crimsoncircle\Model;

class LeapYear
{
    public function isLeapYear(?int $year): int
    {

        /*
            The year is evenly divisible by 4;
            If the year can be evenly divided by 100, it is NOT a leap year, unless;
            The year is also evenly divisible by 400. Then it is a leap year.
        */

        $steep1 = $year % 4 == 0;
        $steep2 = $year % 100 == 0;
        $steep3 = $year % 400 == 0;

        return $steep1 || $steep3 && !($steep1 && $steep2);
    }
}