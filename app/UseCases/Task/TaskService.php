<?php

namespace App\UseCases\Task;

use App\DTO\Task\CreateTaskDTO;
use App\DTO\Task\UpdateTaskDTO;
use App\Entity\Task\Task;
use App\Enums\Task\TaskStatusEnum;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

final class TaskService
{
    public function createTask(int $userId, CreateTaskRequest $request): Task
    {
        $dto = new CreateTaskDTO(
            userId: $userId,
            title: $request['title'],
            description: $request['description'],
            category: $request['category']
        );
        return Task::new($dto);
    }

    public function updateTask(int $id, UpdateTaskRequest $request): void
    {
        $task = $this->getTask($id);

        $dto = new UpdateTaskDTO(
            title: $request['title'],
            description: $request['description'],
            category: $request['category'],
            status: TaskStatusEnum::tryFrom($request['status'])
        );

        $task->edit($dto);
    }

    private function getTask(int $id): Task
    {
        return Task::findOrFail($id);
    }
}
