<!DOCTYPE html>
<html lang="ca">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>
            Organizer - {{ isset($user) ? 'Editar usuari' : 'Nou usuari' }}
        </title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" >

        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" >

    </head>

    <body class="bg-light">
        <nav class="navbar navbar-dark bg-primary shadow-sm">
            <div class="container">

                <a href="{{ route('projects.index') }}" class="navbar-brand fw-bold">
                    <i class="bi bi-kanban me-2"></i>
                    Organizer
                </a>

                <div class="d-flex align-items-center gap-2">

                    <span class="text-white d-none d-sm-inline">
                        {{ Auth::user()->name }}
                    </span>

                    <form method="POST" action="{{ route('logout') }}">

                        @csrf

                        <button type="submit" class="btn btn-light btn-sm">
                            <i class="bi bi-box-arrow-right me-1"></i>
                            Tancar sessió
                        </button>

                    </form>
                </div>
            </div>
        </nav>

        <main class="container py-4 py-md-5">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4 p-md-5">

                            @if (isset($user))
                                <h1 class="fw-bold mb-1">
                                    <i class="bi bi-person-gear me-2"></i>
                                    Editar usuari
                                </h1>

                                <p class="text-muted mb-4">
                                    Modifica les dades de l'usuari.
                                </p>

                                <form method="POST" action="{{ route('users.update', $user->id) }}">
                            @else
                                <h1 class="fw-bold mb-1">
                                    <i class="bi bi-person-plus me-2"></i>
                                    Nou usuari
                                </h1>

                                <p class="text-muted mb-4">
                                    Crea un nou usuari per a Organizer.
                                </p>

                                <form method="POST" action="{{ route('users.store') }}">
                            @endif

                                @csrf

                                @if ($errors->any())

                                    <div class="alert alert-danger">

                                        <div class="fw-bold mb-2">
                                            <i class="bi bi-exclamation-triangle me-1"></i>
                                            Hi ha errors en el formulari
                                        </div>

                                        <ul class="mb-0">

                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach

                                        </ul>

                                    </div>

                                @endif

                                <div class="mb-3">

                                    <label for="name" class="form-label fw-semibold">
                                        <i class="bi bi-person me-1"></i>
                                        Nom d'usuari
                                    </label>

                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name ?? '') }}" required>

                                </div>

                                <div class="mb-3">

                                    <label for="email" class="form-label fw-semibold">
                                        <i class="bi bi-envelope me-1"></i>
                                        Email
                                    </label>

                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" required>

                                </div>

                                <div class="mb-3">

                                    <label for="password" class="form-label fw-semibold">
                                        <i class="bi bi-lock me-1"></i>
                                        Contrasenya
                                    </label>

                                    <input type="password" class="form-control" id="password" name="password" {{ isset($user) ? '' : 'required' }} >

                                    @if (isset($user))

                                        <div class="form-text">
                                            Deixa aquest camp buit per mantenir la contrasenya actual.
                                        </div>

                                    @endif

                                </div>

                                <div class="mb-4">

                                    <label for="role" class="form-label fw-semibold">
                                        <i class="bi bi-person-badge me-1"></i>
                                        Rol
                                    </label>

                                    <select class="form-select" id="role" name="role" required>

                                        <option value="">
                                            Selecciona un rol
                                        </option>

                                        <option value="admin" @selected(old('role', $user->role ?? '') === 'admin')>
                                            Administrador
                                        </option>

                                        <option value="operator" @selected(old('role', $user->role ?? '') === 'operator')>
                                            Operador
                                        </option>

                                    </select>

                                </div>

                                <div class="d-flex flex-column flex-sm-row gap-2">

                                    <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                        <i class="bi bi-x-lg me-1"></i>
                                        Cancel·lar
                                    </a>

                                    <button type="submit" class="btn btn-primary">

                                        @if (isset($user))
                                            <i class="bi bi-check-lg me-1"></i>
                                            Guardar canvis
                                        @else
                                            <i class="bi bi-person-plus me-1"></i>
                                            Crear usuari
                                        @endif

                                    </button>

                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </main>
    </body>
</html>