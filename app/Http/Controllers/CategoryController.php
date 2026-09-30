<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use App\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    private CategoryRepository $categoryRepository;
    private AdminService $adminService;

    public function __construct(
        CategoryRepository $categoryRepository,
        AdminService $adminService
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->adminService = $adminService;
    }

    public function index()
    {
        if (!$this->adminService->isAdmin(Auth::user())) {
            abort(403);
        }

        $categories = $this->categoryRepository->getAll();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        if (!$this->adminService->isAdmin(Auth::user())) {
            abort(403);
        }

        return view('categories.form');
    }

    public function store(Request $request)
    {
        if (!$this->adminService->isAdmin(Auth::user())) {
            abort(403);
        }

        $data = $request->validate(
            [
                'name' => 'required|string|max:255|regex:/^[\p{L}\s]+$/u',
                'color' => 'required|string|max:50',
            ],
            [
                'name.required' => 'El nom de la categoria és obligatori.',
                'name.string' => 'El nom de la categoria ha de ser text.',
                'name.max' => 'El nom de la categoria no pot superar els 255 caràcters.',
                'name.regex' => 'El nom de la categoria només pot contenir lletres i espais.',

                'color.required' => 'El color és obligatori.',
                'color.string' => 'El color ha de ser vàlid.',
                'color.max' => 'El color no pot superar els 50 caràcters.',
            ]
        );

        $this->categoryRepository->create($data);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Categoria creada correctament.');
    }

    public function edit(int $id)
    {
        if (!$this->adminService->isAdmin(Auth::user())) {
            abort(403);
        }

        $category = $this->categoryRepository->findById($id);

        return view('categories.form', compact('category'));
    }

    public function update(Request $request, int $id)
    {
        if (!$this->adminService->isAdmin(Auth::user())) {
            abort(403);
        }

        $data = $request->validate(
            [
                'name' => 'required|string|max:255|regex:/^[\p{L}\s]+$/u',
                'color' => 'required|string|max:50',
            ],
            [
                'name.required' => 'El nom de la categoria és obligatori.',
                'name.string' => 'El nom de la categoria ha de ser text.',
                'name.max' => 'El nom de la categoria no pot superar els 255 caràcters.',
                'name.regex' => 'El nom de la categoria només pot contenir lletres i espais.',

                'color.required' => 'El color és obligatori.',
                'color.string' => 'El color ha de ser vàlid.',
                'color.max' => 'El color no pot superar els 50 caràcters.',
            ]
        );

        $this->categoryRepository->update($id, $data);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Categoria actualitzada correctament.');
    }

    public function destroy(int $id)
    {
        if (!$this->adminService->isAdmin(Auth::user())) {
            abort(403);
        }

        $this->categoryRepository->delete($id);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Categoria eliminada correctament.');
    }
}