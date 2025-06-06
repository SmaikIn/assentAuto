<?php

namespace App\Domains\Task\Enum;

enum TaskStatus: string
{
    case Waiting = 'waiting';
    case Pending = 'pending';
    case Success = 'success';
}
