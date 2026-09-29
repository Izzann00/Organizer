<div class="table-responsive">

    <table class="table table-bordered table-hover bg-white">

        <thead>
            <tr>
                <th>Nom</th>
                <th>Color</th>
                <th>Accions</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($categories as $category)

                <tr>

                    <td>
                        {{ $category->name }}
                    </td>

                    <td>

                        <span class="d-inline-block rounded" style="width: 30px; height: 30px; background-color: {{ $category->color }};" ></span>

                        <span class="ms-2">
                            {{ $category->color }}
                        </span>

                    </td>

                    <td>

                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-primary" title="Editar" >
                            <i class="bi bi-pencil"></i>
                        </a>

                        <button type="button" class="btn btn-sm btn-danger" title="Eliminar" data-bs-toggle="modal" data-bs-target="#deleteCategoryModal{{ $category->id }}" >
                            <i class="bi bi-trash"></i>
                        </button>

                        <div class="modal fade" id="deleteCategoryModal{{ $category->id }}" tabindex="-1" aria-hidden="true" >
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

                                        Estàs segur que vols eliminar la categoria
                                        <strong>{{ $category->name }}</strong>?

                                    </div>

                                    <div class="modal-footer">

                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >
                                            Cancel·lar
                                        </button>

                                        <form method="POST" action="{{ route('categories.destroy', $category->id) }}" >
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