<div class="table-responsive">

    <table class="table table-bordered table-hover bg-white">

        <thead>

            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Accions</th>
            </tr>

        </thead>

        <tbody>

            @foreach ($users as $user)

                <tr>

                    <td>
                        {{ $user->name }}
                    </td>

                    <td>
                        {{ $user->email }}
                    </td>

                    <td>

                        @if ($user->role === 'admin')

                            <span class="badge bg-primary">
                                Administrador
                            </span>

                        @else

                            <span class="badge bg-secondary">
                                Operador
                            </span>

                        @endif

                    </td>

                    <td>

                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary" title="Editar" >
                            <i class="bi bi-pencil"></i>
                        </a>

                        <button type="button" class="btn btn-sm btn-danger" title="Eliminar" data-bs-toggle="modal" data-bs-target="#deleteUserModal{{ $user->id }}" >
                            <i class="bi bi-trash"></i>
                        </button>

                        <div class="modal fade" id="deleteUserModal{{ $user->id }}" tabindex="-1" aria-hidden="true" >
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

                                        Estàs segur que vols eliminar l'usuari
                                        <strong>{{ $user->name }}</strong>?

                                    </div>

                                    <div class="modal-footer">

                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >
                                            Cancel·lar
                                        </button>

                                        <form method="POST" action="{{ route('users.destroy', $user->id) }}" >
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
                </tr>

            @endforeach

        </tbody>
    </table>
</div>