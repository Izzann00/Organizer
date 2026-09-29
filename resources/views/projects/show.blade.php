<!DOCTYPE html>
<html lang="ca">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Organizer - {{ $project->name }}</title>

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

            @include('partials.alerts')

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

                <div>

                    <h1 class="fw-bold mb-1">
                        {{ $project->name }}
                    </h1>

                    <p class="text-muted mb-0">
                        <i class="bi bi-hash"></i>
                        {{ $project->code }}
                    </p>

                </div>

                <a href="{{ route('projects.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Tornar
                </a>

            </div>

            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-white py-3" style="border-left: 6px solid {{ $project->category->color }}" >

                    <div class="d-flex align-items-center gap-2">

                        <i class="bi bi-tag"></i>

                        <strong>
                            {{ $project->category->name }}
                        </strong>

                    </div>

                </div>

                <div class="card-body">

                    <div class="mb-3">

                        <h6 class="fw-bold">
                            <i class="bi bi-card-text me-1"></i>
                            Descripció
                        </h6>

                        <p class="text-muted mb-0">
                            {{ $project->description }}
                        </p>

                    </div>

                    <div class="mb-3">

                        <h6 class="fw-bold">
                            <i class="bi bi-person me-1"></i>
                            Propietari
                        </h6>

                        <p class="text-muted mb-0">
                            {{ $project->owner->name }}
                        </p>

                    </div>

                    <div>

                        <h6 class="fw-bold">
                            <i class="bi bi-circle-half me-1"></i>
                            Estat
                        </h6>

                        @if ($isClosed)

                            <span class="badge bg-secondary">
                                Tancat
                            </span>

                        @else

                            <span class="badge bg-success">
                                Obert
                            </span>

                        @endif

                    </div>

                </div>

            </div>

            @if (!$isClosed)

                <div class="mb-4">

                    <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-primary">
                        <i class="bi bi-pencil me-1"></i>
                        Editar projecte
                    </a>

                </div>

            @endif

            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">

                    <h4 class="mb-0 fw-bold">
                        <i class="bi bi-people me-2"></i>
                        Usuaris convidats
                    </h4>

                </div>

                <div class="card-body">

                    @if ($project->users->isEmpty())

                        <p class="text-muted mb-0">
                            No hi ha usuaris convidats.
                        </p>

                    @else

                        @include('partials.projects.users')

                    @endif

                    @if (Auth::id() === $project->owner_id && !$isClosed)

                        <form method="POST" action="{{ route('projects.users.add', $project->id) }}" class="mt-4">

                            @csrf

                            <div class="row g-2 align-items-end">

                                <div class="col-12 col-md-8">

                                    <label for="user_id" class="form-label fw-semibold">
                                        Afegir usuari
                                    </label>

                                    <select name="user_id" id="user_id" class="form-select" required>

                                        <option value="">
                                            Selecciona un usuari
                                        </option>

                                        @foreach ($users as $user)

                                            @if ($user->id !== $project->owner_id)

                                                <option value="{{ $user->id }}">
                                                    {{ $user->name }}
                                                </option>

                                            @endif

                                        @endforeach

                                    </select>

                                </div>

                                <div class="col-12 col-md-4">

                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="bi bi-person-plus me-1"></i>
                                        Afegir usuari
                                    </button>

                                </div>

                            </div>

                        </form>

                    @endif

                </div>

            </div>

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">

                    <h4 class="mb-0 fw-bold">
                        <i class="bi bi-list-check me-2"></i>
                        Tasques
                    </h4>

                    @if (!$isClosed)

                        <a href="{{ route('tasks.create', $project->id) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-lg me-1"></i>
                            Nova tasca
                        </a>

                    @endif

                </div>

                <div class="card-body">

                    @if ($project->tasks->isEmpty())

                        <p class="text-muted mb-0">
                            No hi ha tasques en aquest projecte.
                        </p>

                    @else
                        @include('partials.tasks.table')
                    @endif

                </div>
            </div>

        </main>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    </body>
</html>