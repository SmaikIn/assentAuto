<?php

namespace App\Domains\Task\Enum;

enum UserStatus:string
{
    case Working = 'working';
    case Vacation = 'vacation';
}
