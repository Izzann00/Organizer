<!DOCTYPE html>
<html lang="ca">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>
            Organizer - {{ isset($category) ? 'Editar categoria' : 'Nova categoria' }}
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
                            @if (isset($category))

                                <h1 class="fw-bold mb-1">
                                    <i class="bi bi-pencil me-2"></i>
                                    Editar categoria
                                </h1>

                                <p class="text-muted mb-4">
                                    Modifica les dades de la categoria.
                                </p>

                                <form method="POST" action="{{ route('categories.update', $category->id) }}">

                            @else

                                <h1 class="fw-bold mb-1">
                                    <i class="bi bi-tag me-2"></i>
                                    Nova categoria
                                </h1>

                                <p class="text-muted mb-4">
                                    Crea una categoria per als teus projectes.
                                </p>

                                <form method="POST" action="{{ route('categories.store') }}">

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
                                        <i class="bi bi-tag me-1"></i>
                                        Nom
                                    </label>

                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $category->name ?? '') }}" required>

                                </div>

                                <div class="mb-4">

                                    <label for="color" class="form-label fw-semibold">
                                        <i class="bi bi-palette me-1"></i>
                                        Color
                                    </label>

                                    <div>
                                        <input type="color" class="form-control form-control-color" id="color" name="color" value="{{ old('color', $category->color ?? '#0d6efd') }}" required >
                                    </div>

                                </div>

                                <div class="d-flex flex-column flex-sm-row gap-2">

                                    <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                                        <i class="bi bi-x-lg me-1"></i>
                                        Cancel·lar
                                    </a>

                                    <button type="submit" class="btn btn-primary">

                                        @if (isset($category))
                                            <i class="bi bi-check-lg me-1"></i>
                                            Guardar canvis
                                        @else
                                            <i class="bi bi-plus-lg me-1"></i>
                                            Crear categoria
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