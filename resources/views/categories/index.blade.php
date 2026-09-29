<!DOCTYPE html>
<html lang="ca">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Organizer - Categories</title>

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
                        Categories
                    </h1>

                    <p class="text-muted mb-0">
                        Gestiona les categories dels projectes.
                    </p>

                </div>

                <div class="d-flex flex-column flex-sm-row gap-2">

                    <a href="{{ route('projects.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i>
                        Tornar
                    </a>

                    <a href="{{ route('categories.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-1"></i>
                        Nova categoria
                    </a>

                </div>

            </div>

            @if ($categories->isEmpty())
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">

                        <i class="bi bi-tags display-4 text-muted"></i>

                        <h4 class="mt-3">
                            No hi ha categories
                        </h4>

                        <p class="text-muted mb-4">
                            Encara no hi ha cap categoria creada.
                        </p>

                        <a href="{{ route('categories.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-lg me-1"></i>
                            Crear categoria
                        </a>

                    </div>

                </div>
            @else
                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        @include('partials.categories.table')

                    </div>
                </div>
            @endif

        </main>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    </body>
</html>