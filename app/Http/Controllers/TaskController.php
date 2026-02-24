<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::all();

        $query = Task::with('project')->orderBy('priority', 'desc');
        $projectId = $request->query('project');
        if ($projectId) {
            $query->where('project_id', $projectId);
        }

        $tasks = $query->get();

        return view('tasks.index', compact('tasks', 'projects'));
    }

    public function create()
    {
        $projects = Project::all();
        return view('tasks.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'project_id' => 'required|exists:projects,id',
            'priority' => 'required|integer|min:0',
        ]);

        Task::create([
            'title' => $request->title,
            'project_id' => $request->project_id,
            'priority' => $request->priority,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function edit(Task $task)
    {
        $projects = Project::all();
        return view('tasks.edit', compact('task', 'projects'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'project_id' => 'required|exists:projects,id',
            'priority' => 'required|integer|min:0|max:10',
        ]);

        $task->update($request->all());

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    /**
     * @throws Throwable
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'task_ids' => 'required|array',
            'task_ids.*' => 'integer|exists:tasks,id',
        ]);

        $taskIds = $request->input('task_ids', []);
        $count = count($taskIds);
        $priorities = [];

        DB::transaction(function () use ($taskIds, $count, &$priorities) {
            foreach ($taskIds as $index => $taskId) {
                $priority = $count - $index;
                Task::where('id', $taskId)->update(['priority' => $priority]);
                $priorities[$taskId] = $priority;
            }
        });

        return response()->json(['success' => true, 'priorities' => $priorities]);
    }
}
