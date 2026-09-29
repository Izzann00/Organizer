<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\UserRepository;
use App\Services\ProjectService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    private ProjectRepository $projectRepository;
    private CategoryRepository $categoryRepository;
    private UserRepository $userRepository;
    private ProjectService $projectService;

    public function __construct(
        ProjectRepository $projectRepository,
        CategoryRepository $categoryRepository,
        UserRepository $userRepository,
        ProjectService $projectService
    ) {
        $this->projectRepository = $projectRepository;
        $this->categoryRepository = $categoryRepository;
        $this->userRepository = $userRepository;
        $this->projectService = $projectService;
    }

    public function index()
    {
        $projects = $this->projectRepository->getByUser(Auth::id());

        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $categories = $this->categoryRepository->getAll();
        $users = $this->userRepository->getAll();

        return view('projects.form', compact('categories', 'users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'category_id' => 'required|exists:categories,id',
        ]);

        $data['owner_id'] = Auth::id();

        $this->projectRepository->create($data);

        return redirect()
            ->route('projects.index')
            ->with('success', 'Projecte creat correctament.');
    }

    public function show(int $id)
    {
        $project = $this->projectRepository->findById($id);

        if (!$this->projectService->canAccess($project, Auth::id())) {
            abort(403);
        }

        $isClosed = $this->projectService->isClosed($project);
        $users = $this->userRepository->getAll();

        return view(
            'projects.show',
            compact('project', 'isClosed', 'users')
        );
    }

    public function edit(int $id)
    {
        $project = $this->projectRepository->findById($id);

        if (!$this->projectService->canAccess($project, Auth::id())) {
            abort(403);
        }

        if ($this->projectService->isClosed($project)) {
            return redirect()
                ->route('projects.show', $id)
                ->with('error', 'Aquest projecte està tancat.');
        }

        $categories = $this->categoryRepository->getAll();
        $users = $this->userRepository->getAll();

        return view('projects.form', compact('project', 'categories', 'users'));
    }

    public function update(Request $request, int $id)
    {
        $project = $this->projectRepository->findById($id);

        if (!$this->projectService->canAccess($project, Auth::id())) {
            abort(403);
        }

        if ($this->projectService->isClosed($project)) {
            return redirect()
                ->route('projects.show', $id)
                ->with('error', 'Aquest projecte està tancat.');
        }

        $data = $request->validate([
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'category_id' => 'required|exists:categories,id',
        ]);

        $this->projectRepository->update($id, $data);

        return redirect()
            ->route('projects.show', $id)
            ->with('success', 'Projecte actualitzat correctament.');
    }

    public function addUser(Request $request, int $id)
    {
        $project = $this->projectRepository->findById($id);

        if (!$this->projectService->isOwner($project, Auth::id())) {
            abort(403);
        }

        if ($this->projectService->isClosed($project)) {
            return redirect()
                ->route('projects.show', $id)
                ->with('error', 'Aquest projecte està tancat.');
        }

        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $this->projectRepository->addUser($id, $data['user_id']);

        return redirect()
            ->route('projects.show', $id)
            ->with('success', 'Usuari afegit al projecte.');
    }

    public function removeUser(int $id, int $userId)
    {
        $project = $this->projectRepository->findById($id);

        if (!$this->projectService->isOwner($project, Auth::id())) {
            abort(403);
        }

        if ($this->projectService->isClosed($project)) {
            return redirect()
                ->route('projects.show', $id)
                ->with('error', 'Aquest projecte està tancat.');
        }

        $this->projectRepository->removeUser($id, $userId);

        return redirect()
            ->route('projects.show', $id)
            ->with('success', 'Usuari eliminat del projecte.');
    }
}