<?php

namespace App\Enums;

enum Status: string
{
    case COMPLETE = "Complete";
    case FAILED = "Failed";
    case PENDING = "Pending";
    case PROCESSING = "Processing";
}
