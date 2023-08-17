<?php

namespace Crimsoncircle\Model;

class LeapYear
{
    public function isLeapYear(?int $year): int
    {
        return $year % 4 == 0;
    }
}