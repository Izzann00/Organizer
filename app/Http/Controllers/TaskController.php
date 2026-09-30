<?php

namespace App\Http\Controllers;

use App\Repositories\ProjectRepository;
use App\Repositories\TaskRepository;
use App\Services\ProjectService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    private TaskRepository $taskRepository;
    private ProjectRepository $projectRepository;
    private ProjectService $projectService;

    public function __construct(
        TaskRepository $taskRepository,
        ProjectRepository $projectRepository,
        ProjectService $projectService
    ) {
        $this->taskRepository = $taskRepository;
        $this->projectRepository = $projectRepository;
        $this->projectService = $projectService;
    }

    public function create(int $projectId)
    {
        $project = $this->projectRepository->findById($projectId);

        if (!$this->projectService->canAccess($project, Auth::id())) {
            abort(403);
        }

        if ($this->projectService->isClosed($project)) {
            return redirect()
                ->route('projects.show', $projectId)
                ->with('error', 'Aquest projecte està tancat.');
        }

        return view('tasks.form', compact('project'));
    }

    public function store(Request $request, int $projectId)
    {
        $project = $this->projectRepository->findById($projectId);

        if (!$this->projectService->canAccess($project, Auth::id())) {
            abort(403);
        }

        if ($this->projectService->isClosed($project)) {
            return redirect()
                ->route('projects.show', $projectId)
                ->with('error', 'Aquest projecte està tancat.');
        }

        $data = $request->validate(
            [
                'name' => 'required|string|max:255|regex:/^[\p{L}\s]+$/u',
                'description' => 'required|string|max:500',
                'due_date' => 'required|date',
            ],
            [
                'name.required' => 'El nom de la tasca és obligatori.',
                'name.string' => 'El nom de la tasca ha de ser text.',
                'name.max' => 'El nom de la tasca no pot superar els 255 caràcters.',
                'name.regex' => 'El nom de la tasca només pot contenir lletres i espais.',

                'description.required' => 'La descripció de la tasca és obligatòria.',
                'description.string' => 'La descripció de la tasca ha de ser text.',
                'description.max' => 'La descripció no pot superar els 500 caràcters.',

                'due_date.required' => 'La data límit és obligatòria.',
                'due_date.date' => 'La data límit no és vàlida.',
            ]
        );

        $data['project_id'] = $projectId;
        $data['user_id'] = Auth::id();
        $data['status'] = 'open';

        $this->taskRepository->create($data);

        return redirect()
            ->route('projects.show', $projectId)
            ->with('success', 'Tasca creada correctament.');
    }

    public function edit(int $id)
    {
        $task = $this->taskRepository->findById($id);

        if (!$this->projectService->canAccess($task->project, Auth::id())) {
            abort(403);
        }

        if ($this->projectService->isClosed($task->project)) {
            return redirect()
                ->route('projects.show', $task->project_id)
                ->with('error', 'Aquest projecte està tancat.');
        }

        return view('tasks.form', [
            'task' => $task,
            'project' => $task->project,
        ]);
    }

    public function update(Request $request, int $id)
    {
        $task = $this->taskRepository->findById($id);

        if (!$this->projectService->canAccess($task->project, Auth::id())) {
            abort(403);
        }

        if ($this->projectService->isClosed($task->project)) {
            return redirect()
                ->route('projects.show', $task->project_id)
                ->with('error', 'Aquest projecte està tancat.');
        }

        $data = $request->validate(
            [
                'name' => 'required|string|max:255|regex:/^[\p{L}\s]+$/u',
                'description' => 'required|string|max:500',
                'due_date' => 'required|date',
                'status' => 'required|in:open,closed',
            ],
            [
                'name.required' => 'El nom de la tasca és obligatori.',
                'name.string' => 'El nom de la tasca ha de ser text.',
                'name.max' => 'El nom de la tasca no pot superar els 255 caràcters.',
                'name.regex' => 'El nom de la tasca només pot contenir lletres i espais.',

                'description.required' => 'La descripció de la tasca és obligatòria.',
                'description.string' => 'La descripció de la tasca ha de ser text.',
                'description.max' => 'La descripció no pot superar els 500 caràcters.',

                'due_date.required' => 'La data límit és obligatòria.',
                'due_date.date' => 'La data límit no és vàlida.',

                'status.required' => 'L\'estat de la tasca és obligatori.',
                'status.in' => 'L\'estat de la tasca no és vàlid.',
            ]
        );

        $this->taskRepository->update($id, $data);

        return redirect()
            ->route('projects.show', $task->project_id)
            ->with('success', 'Tasca actualitzada correctament.');
    }

    public function destroy(int $id)
    {
        $task = $this->taskRepository->findById($id);

        if (!$this->projectService->canAccess($task->project, Auth::id())) {
            abort(403);
        }

        if ($this->projectService->isClosed($task->project)) {
            return redirect()
                ->route('projects.show', $task->project_id)
                ->with('error', 'Aquest projecte està tancat.');
        }

        $projectId = $task->project_id;

        $this->taskRepository->delete($id);

        return redirect()
            ->route('projects.show', $projectId)
            ->with('success', 'Tasca eliminada correctament.');
    }
}