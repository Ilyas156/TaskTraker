<?php

namespace App\Enums\Task;

enum TaskStatusEnum: int
{
    case NEW = 0;

    case IN_PROGRESS = 1;
    case DONE = 2;

    case DECLINED = 3;
}
