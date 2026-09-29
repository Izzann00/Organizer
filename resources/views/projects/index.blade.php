<!DOCTYPE html>
<html lang="ca">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Organizer - Projectes</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

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
            @if (Auth::user()->role === 'admin')

                <div class="container pt-4">

                    <div class="d-flex justify-content-end gap-2">

                        <a href="{{ route('users.index') }}" class="btn btn-primary">
                            <i class="bi bi-people me-1"></i>
                            Usuaris
                        </a>

                        <a href="{{ route('categories.index') }}" class="btn btn-primary">
                            <i class="bi bi-tags me-1"></i>
                            Categories
                        </a>

                    </div>

                </div>

            @endif        
        <main class="container py-4 py-md-5">

            @include('partials.alerts')

            <div class="mb-4">

                <h1 class="fw-bold mb-1">
                    <i class="bi bi-folder2-open me-2"></i>
                    Projectes
                </h1>

                <p class="text-muted mb-0">
                    Gestiona els teus projectes.
                </p>

            </div>

            @if ($projects->isEmpty())

                <div class="row g-4">
                    <div class="col-12 col-sm-6 col-lg-4">
                        <a href="{{ route('projects.create') }}" class="text-decoration-none" >
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center text-center py-5">

                                    <i class="bi bi-plus-circle display-4 text-primary"></i>

                                    <h4 class="mt-3 text-dark">
                                        Nou projecte
                                    </h4>

                                    <p class="text-muted mb-0">
                                        Crea un nou projecte.
                                    </p>

                                </div>
                            </div>
                        </a>
                    </div>
                </div>

            @else

                <div class="row g-4">

                    @foreach ($projects as $project)

                        <div class="col-12 col-md-6 col-xl-4">
                            <div class="card border-0 shadow-sm h-100" style="border-left: 5px solid {{ $project->category->color }} !important;" >
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>

                                            <h4 class="fw-bold mb-1">
                                                {{ $project->name }}
                                            </h4>

                                            <span class="badge text-dark" style="background-color: {{ $project->category->color }};">
                                                {{ $project->category->name }}
                                            </span>

                                        </div>

                                        <span class="badge bg-light text-dark border">
                                            {{ $project->code }}
                                        </span>

                                    </div>

                                    <p class="text-muted flex-grow-1">
                                        {{ $project->description }}
                                    </p>

                                    <div class="mb-3">

                                        <small class="text-muted">
                                            <i class="bi bi-person me-1"></i>
                                            Propietari:
                                            <strong>{{ $project->owner->name }}</strong>
                                        </small>

                                    </div>

                                    <a href="{{ route('projects.show', $project->id) }}" class="btn btn-primary w-100" >
                                        <i class="bi bi-eye me-1"></i>
                                        Veure projecte
                                    </a>

                                </div>
                            </div>
                        </div>

                    @endforeach

                    <div class="col-12 col-md-6 col-xl-4">
                        <a href="{{ route('projects.create') }}" class="text-decoration-none" >
                            <div class="card border-0 shadow-sm h-100" style="border: 2px dashed #adb5bd !important;" >

                                <div class="card-body d-flex flex-column justify-content-center align-items-center text-center py-5">

                                    <i class="bi bi-plus-circle display-4 text-primary"></i>

                                    <h4 class="mt-3 text-dark">
                                        Nou projecte
                                    </h4>

                                    <p class="text-muted mb-0">
                                        Crea un nou projecte.
                                    </p>

                                </div>
                            </div>
                        </a>
                    </div>

                </div>

            @endif

        </main>

    </body>
</html>