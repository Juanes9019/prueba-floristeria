<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            <b>Control de usuarios</b>
                        </span>
                    </div>
                </div>
                

                @if (session('success'))
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: '{{ session('success') }}',
                            position: 'top-end',
                            toast: true,
                            showConfirmButton: false,
                            timer: 5000
                        });
                    </script>
                @elseif (session('error'))
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: '{{ session('error') }}',
                            position: 'top-end',
                            toast: true,
                            showConfirmButton: false,
                            timer: 5000
                        });
                    </script>
                @endif

                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="col-md-6">
                            <input wire:model.live.debounce.300ms="buscar" type="text" class="form-control" placeholder="Buscar...">
                        </div>
                
                        <div class="d-flex">
                            <div class="dropdown mr-2">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="exportDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Exportar
                                </button>
                                <div class="dropdown-menu" aria-labelledby="exportDropdown">
                                    <a class="dropdown-item" href="{{ route('Admin.users.export', ['format' => 'xlsx']) }}">
                                    {{ __('Exportar a Excel') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('Admin.users.export', ['format' => 'pdf']) }}">
                                    {{ __('Exportar a PDF') }}
                                    </a>
                                </div>
                            </div>
                            <a href="{{ route('Admin.users.create') }}" class="btn btn-primary btn-sm float-right" data-placement="left">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff"><path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    
                                    <th scope="col" class="text-center" wire:click="sortBy('name')">
                                        Nombre
                                        @if ($ordenarColumna === 'name')
                                        @if ($ordenarForma === 'asc')
                                        <svg width="16" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5"></path>
                                        </svg>
                                        @else
                                        <svg width="16" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                                        </svg>
                                        @endif
                                        @else
                                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"></path>
                                        </svg>
                                        @endif
                                    </th>
                                    <th scope="col" class="text-center">
                                        Tipo de documento
                                    </th>
                                    <th scope="col" class="text-center" wire:click="sortBy('documento')">
                                        Documento
                                        @if ($ordenarColumna === 'documento')
                                        @if ($ordenarForma === 'asc')
                                        <svg width="16" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5"></path>
                                        </svg>
                                        @else
                                        <svg width="16" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                                        </svg>
                                        @endif
                                        @else
                                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"></path>
                                        </svg>
                                        @endif
                                    </th>
                                    <th scope="col" class="text-center">
                                        Correo electrónico
                                    </th>
                                    <th scope="col" class="text-center">
                                        Rol
                                    </th>
                                    <th scope="col" class="text-center" wire:click="sortBy('estado')">
                                        Estado
                                        @if ($ordenarColumna === 'estado')
                                        @if ($ordenarForma === 'asc')
                                        <svg width="16" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5"></path>
                                        </svg>
                                        @else
                                        <svg width="16" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                                        </svg>
                                        @endif
                                        @else
                                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"></path>
                                        </svg>
                                        @endif
                                    </th>
                                    <th scope="col" class="text-center" colspan="2">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($usuarios as $user)
                                <tr>
                                    <td class="text-center">{{ $user->name }}</td>
                                    <td class="text-center">{{ $user->tipo_documento }}</td>
                                    <td class="text-center">{{ $user->documento }}</td>
                                    <td class="text-center">{{ $user->email }}</td>
                                    <td class="text-center">{{ $user->Role->nombre }}</td>
                                    <td class="text-center">
                                        <a class="btn btn-sm {{ $user->estado == 1 ? 'btn-success' : 'btn-danger' }}"
                                            wire:click="changeStatus({{ $user->id }})"
                                            style="cursor: pointer;">
                                            {{ $user->estado == 1 ? 'Activo' : 'Inactivo' }}
                                            <i class="fas fa-toggle-{{ $user->estado == 1 ? 'on' : 'off' }}"></i>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-sm btn-warning" href="{{ route('Admin.users.edit', ['id' => $user->id]) }}">
                                            <i class="fa fa-fw fa-edit"></i></a>
                                    </td>
                                    <td>
                                        <form id="form_eliminar_{{ $user->id }}" action="{{ route('Admin.users.destroy', $user->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm" onclick="eliminar('{{ $user->id }}')">
                                                <i class="fa fa-fw fa-trash"></i> 
                                            </button>
                                        </form>
                                    </td>
                                    
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <label>Páginas</label>
                        <select wire:model.live="porPagina">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                        </select>
                        <div class="mt-3">
                            {{ $usuarios->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function eliminar(userId) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'No podrás revertir esta acción',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form_eliminar_' + userId).submit();
            }
        });
    }
</script>