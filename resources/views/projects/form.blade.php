<!DOCTYPE html>
<html lang="ca">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>
            Organizer - {{ isset($project) ? 'Editar projecte' : 'Nou projecte' }}
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
                <div class="col-12 col-lg-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4 p-md-5">
                            <div class="mb-4">

                                @if (isset($project))

                                    <h1 class="fw-bold mb-1">
                                        <i class="bi bi-pencil me-2"></i>
                                        Editar projecte
                                    </h1>

                                    <p class="text-muted mb-0">
                                        Modifica les dades del projecte.
                                    </p>

                                @else

                                    <h1 class="fw-bold mb-1">
                                        <i class="bi bi-folder-plus me-2"></i>
                                        Nou projecte
                                    </h1>

                                    <p class="text-muted mb-0">
                                        Crea un nou projecte per començar a treballar.
                                    </p>

                                @endif

                            </div>

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

                            @if (isset($project))
                                <form method="POST" action="{{ route('projects.update', $project->id) }}">
                            @else
                                <form method="POST" action="{{ route('projects.store') }}">
                            @endif

                                @csrf

                                <div class="mb-3">

                                    <label for="code" class="form-label fw-semibold">
                                        <i class="bi bi-hash me-1"></i>
                                        Codi
                                    </label>

                                    <input type="text" class="form-control" id="code" name="code" maxlength="255" value="{{ old('code', $project->code ?? '') }}" required>

                                    <div class="form-text text-end">
                                        <span id="code-counter">0</span> / 255
                                    </div>
                                </div>

                                <div class="mb-3">

                                    <label for="name" class="form-label fw-semibold">
                                        <i class="bi bi-pencil me-1"></i>
                                        Nom
                                    </label>

                                    <input type="text" class="form-control" id="name" name="name" maxlength="255" value="{{ old('name', $project->name ?? '') }}" required>

                                    <div class="form-text text-end">
                                        <span id="name-counter">0</span> / 255
                                    </div>

                                </div>

                                <div class="mb-3">

                                    <label for="description" class="form-label fw-semibold">
                                        <i class="bi bi-card-text me-1"></i>
                                        Descripció
                                    </label>

                                    <textarea class="form-control" id="description" name="description" rows="5" maxlength="500" required >{{ old('description', $project->description ?? '') }}</textarea>

                                    <div class="form-text text-end">
                                        <span id="description-counter">0</span> / 500
                                    </div>
                                </div>

                                <div class="mb-4">

                                    <label for="category_id" class="form-label fw-semibold">
                                        <i class="bi bi-tag me-1"></i>
                                        Categoria
                                    </label>

                                    <select class="form-select" id="category_id" name="category_id" required >

                                        <option value="">
                                            Selecciona una categoria
                                        </option>

                                        @foreach ($categories as $category)

                                            <option value="{{ $category->id }}" @selected(old('category_id', $project->category_id ?? '') == $category->id) >
                                                {{ $category->name }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>

                                <div class="d-flex flex-column flex-sm-row gap-2">
                                    @if (isset($project))
                                        <a href="{{ route('projects.show', $project->id) }}" class="btn btn-secondary">
                                            <i class="bi bi-x-lg me-1"></i>
                                            Cancel·lar
                                        </a>

                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-check-lg me-1"></i>
                                            Guardar canvis
                                        </button>
                                    @else
                                        <a href="{{ route('projects.index') }}" class="btn btn-secondary">
                                            <i class="bi bi-x-lg me-1"></i>
                                            Cancel·lar
                                        </a>

                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-plus-lg me-1"></i>
                                            Crear projecte
                                        </button>

                                    @endif
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </main>
        <script>
            function updateCounter(inputId, counterId) {
                const input = document.getElementById(inputId);
                const counter = document.getElementById(counterId);

                counter.textContent = input.value.length;

                input.addEventListener('input', function () {
                    counter.textContent = input.value.length;
                });
            }

            updateCounter('code', 'code-counter');
            updateCounter('name', 'name-counter');
            updateCounter('description', 'description-counter');
        </script>
    </body>
</html>