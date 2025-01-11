<?php

namespace App\Enums;

enum JobTypeEnum: string
{
    case FullTime = 'full-time';
    case PartTime = 'part-time';
    case Temporary = 'temporary';
}

