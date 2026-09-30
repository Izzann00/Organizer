<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private UserRepository $userRepository;
    private AdminService $adminService;

    public function __construct(
        UserRepository $userRepository,
        AdminService $adminService
    ) {
        $this->userRepository = $userRepository;
        $this->adminService = $adminService;
    }

    public function index()
    {
        if (!$this->adminService->isAdmin(Auth::user())) {
            abort(403);
        }

        $users = $this->userRepository->getAll();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        if (!$this->adminService->isAdmin(Auth::user())) {
            abort(403);
        }

        return view('users.form');
    }

    public function store(Request $request)
    {
        if (!$this->adminService->isAdmin(Auth::user())) {
            abort(403);
        }

        $data = $request->validate(
            [
                'name' => 'required|string|max:255|regex:/^[\p{L}\s]+$/u',
                'email' => 'required|email|max:255|unique:users,email',
                'password' => 'required|string|min:6',
                'role' => 'required|in:admin,operator',
            ],
            [
                'name.required' => 'El nom de l\'usuari és obligatori.',
                'name.string' => 'El nom de l\'usuari ha de ser text.',
                'name.max' => 'El nom de l\'usuari no pot superar els 255 caràcters.',
                'name.regex' => 'El nom de l\'usuari només pot contenir lletres i espais.',

                'email.required' => 'El correu electrònic és obligatori.',
                'email.email' => 'El correu electrònic no és vàlid.',
                'email.max' => 'El correu electrònic no pot superar els 255 caràcters.',
                'email.unique' => 'Aquest correu electrònic ja està registrat.',

                'password.required' => 'La contrasenya és obligatòria.',
                'password.string' => 'La contrasenya ha de ser text.',
                'password.min' => 'La contrasenya ha de tenir com a mínim 6 caràcters.',

                'role.required' => 'El rol és obligatori.',
                'role.in' => 'El rol seleccionat no és vàlid.',
            ]
        );

        $data['password'] = Hash::make($data['password']);

        $this->userRepository->create($data);

        return redirect()
            ->route('users.index')
            ->with('success', 'Usuari creat correctament.');
    }

    public function edit(int $id)
    {
        if (!$this->adminService->isAdmin(Auth::user())) {
            abort(403);
        }

        $user = $this->userRepository->findById($id);

        return view('users.form', compact('user'));
    }

    public function update(Request $request, int $id)
    {
        if (!$this->adminService->isAdmin(Auth::user())) {
            abort(403);
        }

        $data = $request->validate(
            [
                'name' => 'required|string|max:255|regex:/^[\p{L}\s]+$/u',
                'email' => 'required|email|max:255|unique:users,email,' . $id,
                'role' => 'required|in:admin,operator',
            ],
            [
                'name.required' => 'El nom de l\'usuari és obligatori.',
                'name.string' => 'El nom de l\'usuari ha de ser text.',
                'name.max' => 'El nom de l\'usuari no pot superar els 255 caràcters.',
                'name.regex' => 'El nom de l\'usuari només pot contenir lletres i espais.',

                'email.required' => 'El correu electrònic és obligatori.',
                'email.email' => 'El correu electrònic no és vàlid.',
                'email.max' => 'El correu electrònic no pot superar els 255 caràcters.',
                'email.unique' => 'Aquest correu electrònic ja està registrat.',

                'role.required' => 'El rol és obligatori.',
                'role.in' => 'El rol seleccionat no és vàlid.',
            ]
        );

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $this->userRepository->update($id, $data);

        return redirect()
            ->route('users.index')
            ->with('success', 'Usuari actualitzat correctament.');
    }

    public function destroy(int $id)
    {
        if (!$this->adminService->isAdmin(Auth::user())) {
            abort(403);
        }

        $this->userRepository->delete($id);

        return redirect()
            ->route('users.index')
            ->with('success', 'Usuari eliminat correctament.');
    }
}