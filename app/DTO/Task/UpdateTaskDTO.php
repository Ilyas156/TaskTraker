<?php

namespace App\DTO\Task;

use App\Enums\Task\TaskStatusEnum;

final class UpdateTaskDTO
{
    public function __construct(
        public string $title,
        public string $description,
        public string $category,
        public TaskStatusEnum $status
    )
    {
    }
}
