<?php

namespace App\Http\Controllers\Task;

use App\Entity\Task\Task;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\UseCases\Task\TaskService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class TaskController extends Controller
{

    public function __construct(
        private TaskService $service
    ) {
    }

    /**
     * @param Request $request
     * @return View|Factory
     */
    public function index(Request $request): View|Factory
    {
        $query = Task::forUser(Auth::user())->orderByDesc('created_at')->paginate(20);

        $tasks = $query->paginate(20);

        return view('tasks.index', compact('tasks'));
    }

    public function store(CreateTaskRequest $request): RedirectResponse
    {
        try {
            $task = $this->service->createTask(Auth::id(), $request);
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('task.show', $task);

    }

    public function edit(UpdateTaskRequest $request, Task $task): RedirectResponse
    {
        try {
            $this->service->updateTask($task->id, $request);
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('task.show', $task);
    }

    public function show(Task $task): View|Factory
    {
        return view('task.show', compact('task'));
    }

    public function create(): View|Factory
    {
        return view('task.create');
    }
}
