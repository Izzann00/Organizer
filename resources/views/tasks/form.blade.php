<!DOCTYPE html>
<html lang="ca">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>
            Organizer - {{ isset($task) ? 'Editar tasca' : 'Nova tasca' }}
        </title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" >

        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" >

    </head>

    <body class="bg-light">

        <nav class="navbar navbar-dark bg-primary shadow-sm">

            <div class="container">

                <a href="{{ route('projects.show', $project->id) }}" class="navbar-brand fw-bold">
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

                            @if (isset($task))

                                <h1 class="fw-bold mb-1">
                                    <i class="bi bi-pencil me-2"></i>
                                    Editar tasca
                                </h1>

                                <p class="text-muted mb-4">
                                    Modifica les dades de la tasca.
                                </p>

                                <form method="POST" action="{{ route('tasks.update', $task->id) }}">

                            @else

                                <h1 class="fw-bold mb-1">
                                    <i class="bi bi-list-task me-2"></i>
                                    Nova tasca
                                </h1>

                                <p class="text-muted mb-4">
                                    Crea una nova tasca per al projecte.
                                </p>

                                <form method="POST" action="{{ route('tasks.store', $project->id) }}">

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
                                        <i class="bi bi-list-check me-1"></i>
                                        Nom
                                    </label>

                                    <input type="text" class="form-control" id="name" name="name" maxlength="255" value="{{ old('name', $task->name ?? '') }}" required>

                                    <div class="form-text text-end">
                                        <span id="name-counter">0</span> / 255
                                    </div>
                                </div>

                                <div class="mb-3">

                                    <label for="description" class="form-label fw-semibold">
                                        <i class="bi bi-card-text me-1"></i>
                                        Descripció
                                    </label>

                                    <textarea class="form-control" id="description" name="description" rows="5" maxlength="500" required >{{ old('description', $task->description ?? '') }}</textarea>

                                    <div class="form-text text-end">
                                        <span id="description-counter">0</span> / 500
                                    </div>
                                </div>

                                <div class="mb-3">

                                    <label for="due_date" class="form-label fw-semibold">
                                        <i class="bi bi-calendar-event me-1"></i>
                                        Data límit
                                    </label>

                                    <input type="date" class="form-control" id="due_date" name="due_date" value="{{ old('due_date', $task->due_date ?? '') }}" required>

                                </div>

                                @if (isset($task))

                                    <div class="mb-4">

                                        <label for="status" class="form-label fw-semibold">
                                            <i class="bi bi-circle-half me-1"></i>
                                            Estat
                                        </label>

                                        <select class="form-select" id="status" name="status" required>

                                            <option value="open" @selected(old('status', $task->status) === 'open')>
                                                Oberta
                                            </option>

                                            <option value="closed" @selected(old('status', $task->status) === 'closed')>
                                                Tancada
                                            </option>

                                        </select>

                                    </div>

                                @else

                                    <div class="mb-4"></div>

                                @endif

                                <div class="d-flex flex-column flex-sm-row gap-2">

                                    <a href="{{ route('projects.show', $project->id) }}" class="btn btn-secondary">
                                        <i class="bi bi-x-lg me-1"></i>
                                        Cancel·lar
                                    </a>

                                    @if (isset($task))

                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-check-lg me-1"></i>
                                            Guardar canvis
                                        </button>

                                    @else

                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-plus-lg me-1"></i>
                                            Crear tasca
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
            updateCounter('name', 'name-counter');
            updateCounter('description', 'description-counter');
            
        </script>
    </body>
</html>