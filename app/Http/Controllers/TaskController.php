<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class TaskController extends Controller
{
    /**
     * @return Collection<int, Task>
     */
    public function index(): Collection
    {
        return Task::all();
    }

    public function create(CreateTaskRequest $request): JsonResponse
    {
        $task = new Task();
        $task::new($request);

        return response()->json([
            'result' => 'ok',
            'task' => $task
        ]);

    }

    public function update(UpdateTaskRequest $request): bool
    {
        /** @var Task $task */
        $task = Task::findOrFail($request->get('id'));
        $task->edit($request);

        return true;
    }


    /**
     * @throws Throwable
     */
    public function destroy(int $id, Request $request): true
    {
        /** @var Task $task */
        $task = Task::findOrFail($id);
        $task->deleteOrFail();

        return true;
    }
}
