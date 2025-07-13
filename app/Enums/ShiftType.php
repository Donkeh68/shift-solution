<?php

namespace App\Enums;

enum ShiftType: string
{
    case DAY = "Day";
    case HOLIDAY = "Holiday";
    case NIGHT = "Night";
}
