<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TaskService;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index()
    {
        return $this->taskService->getAllTasks();
    }

    public function store(Request $request)
    {
        return $this->taskService->createTask($request);
    }

    public function show($id)
    {
        return $this->taskService->getTaskById($id);
    }

    public function update(Request $request, $id)
    {
        return $this->taskService->updateTask($request, $id);
    }

    public function destroy($id)
    {
        return $this->taskService->deleteTask($id);
    }

    public function search(Request $request)
    {
        return $this->taskService->searchTasks($request);
    }
}
