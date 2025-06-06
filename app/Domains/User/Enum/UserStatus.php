<?php

namespace App\Domains\User\Enum;

enum UserStatus:string
{
    case Working = 'working';
    case Vacation = 'vacation';
}
