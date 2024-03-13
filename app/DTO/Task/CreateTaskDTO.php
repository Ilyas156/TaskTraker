<?php

namespace App\DTO\Task;

final class CreateTaskDTO
{
    public function __construct(
        public int $userId,
        public string $title,
        public string $description,
        public string $category
    ) {
    }
}
