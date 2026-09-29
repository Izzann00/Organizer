<div class="table-responsive">
    <table class="table table-bordered">

        <thead>

            <tr>

                <th>Usuari</th>

                <th>Email</th>

                @if (Auth::id() === $project->owner_id && !$isClosed)
                    <th>Accions</th>
                @endif

            </tr>

        </thead>

        <tbody>

            @foreach ($project->users as $user)

                <tr>

                    <td>
                        {{ $user->name }}
                    </td>

                    <td>
                        {{ $user->email }}
                    </td>

                    @if (Auth::id() === $project->owner_id && !$isClosed)

                        <td>

                            <form method="POST" action="{{ route('projects.users.remove', [$project->id, $user->id]) }}" class="d-inline" >
                                @csrf

                                <button type="submit" class="btn btn-sm btn-danger" >
                                    Eliminar
                                </button>

                            </form>
                        </td>
                    @endif
                </tr>
            @endforeach

        </tbody>
    </table>
</div>