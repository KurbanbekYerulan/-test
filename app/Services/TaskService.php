<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TaskService
{
    public function getAllTasks()
    {
        return Task::all();
    }

    public function createTask(Request $request)
    {
        $validated = $this->validateTask($request);
        return Task::create($validated);
    }

    public function getTaskById($id)
    {
        return Task::findOrFail($id);
    }

    public function updateTask(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $validated = $this->validateTask($request, true);
        $task->update($validated);
        return $task;
    }

    public function deleteTask($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return response()->noContent();
    }

    public function searchTasks(Request $request)
    {
        $validated = $this->validateSearch($request);
        $query = Task::query();

        if (isset($validated['status'])) {
            $query->where('status', $validated['status']);
        }

        if (isset($validated['deadline'])) {
            $query->where('deadline', $validated['deadline']);
        }

        return $query->get();
    }

    protected function validateTask(Request $request, $isUpdate = false)
    {
        $rules = [
            'title' => $isUpdate ? 'sometimes|required|string|max:255' : 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'sometimes|required|in:pending,in_progress,completed',
            'deadline' => 'nullable|date',
        ];

        return $request->validate($rules);
    }

    protected function validateSearch(Request $request)
    {
        $rules = [
            'status' => 'nullable|in:pending,in_progress,completed',
            'deadline' => 'nullable|date',
        ];

        return $request->validate($rules);
    }
}
