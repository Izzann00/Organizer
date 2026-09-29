<div class="table-responsive">

    <table class="table table-bordered table-hover">

        <thead>

            <tr>
                <th>Nom</th>
                <th>Descripció</th>
                <th>Creat per</th>
                <th>Data d'inserció</th>
                <th>Data límit</th>
                <th>Estat</th>

                @if (!$isClosed)
                    <th>Accions</th>
                @endif

            </tr>

        </thead>

        <tbody>

            @foreach ($project->tasks as $task)

                <tr>

                    <td>
                        {{ $task->name }}
                    </td>

                    <td>
                        {{ $task->description }}
                    </td>

                    <td>
                        {{ $task->user->name }}
                    </td>

                    <td>
                        {{ $task->created_at->format('d/m/Y H:i') }}
                    </td>

                    <td>

                        @if ( $task->status === 'open' && $task->due_date < now()->toDateString() )
                            <span class="text-danger fw-bold">
                                {{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') }}
                            </span>
                        @else
                            {{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') }}
                        @endif

                    </td>

                    <td>

                        @if ($task->status === 'closed')

                            <span class="badge bg-success">
                                Tancada
                            </span>

                        @else

                            <span class="badge bg-warning text-dark">
                                Oberta
                            </span>

                        @endif

                    </td>

                    @if (!$isClosed)

                        <td>

                            <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-primary" title="Editar" >
                                <i class="bi bi-pencil"></i>
                            </a>

                            <button type="button" class="btn btn-sm btn-danger" title="Eliminar" data-bs-toggle="modal" data-bs-target="#deleteTaskModal{{ $task->id }}" >
                                <i class="bi bi-trash"></i>
                            </button>

                            <div class="modal fade" id="deleteTaskModal{{ $task->id }}" tabindex="-1" aria-hidden="true" >
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">

                                        <div class="modal-header">

                                            <h5 class="modal-title">
                                                <i class="bi bi-exclamation-triangle text-danger me-2"></i>
                                                Confirmar eliminació
                                            </h5>

                                            <button type="button" class="btn-close" data-bs-dismiss="modal" ></button>

                                        </div>

                                        <div class="modal-body">

                                            Està segur que vol eliminar la tasca
                                            <strong>{{ $task->name }}</strong>?

                                        </div>

                                        <div class="modal-footer">

                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >
                                                Cancel·lar
                                            </button>

                                            <form method="POST" action="{{ route('tasks.destroy', $task->id) }}" >
                                                @csrf

                                                <button type="submit" class="btn btn-danger" >
                                                    <i class="bi bi-trash me-1"></i>
                                                    Eliminar
                                                </button>

                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </td>
                    @endif
                </tr>

            @endforeach

        </tbody>
    </table>
</div>