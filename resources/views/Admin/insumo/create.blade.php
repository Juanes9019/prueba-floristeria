@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<h2 class="text-center mb-5">Crear insumo</h2>
    

    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <form id="formulario_crear" method="POST" action="{{ route('Admin.insumo.store') }}" novalidate >
                @csrf
                <div class="card card-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="id_categoria_insumo">Categoria insumo <strong style="color: red;">*</strong></label>
                                <select name="id_categoria_insumo" id="id_categoria_insumo"
                                    class="form-control @error('id_categoria_insumo') is-invalid  @enderror">
                                    <option selected disabled>Seleccione una categoria...</option>
                                    @foreach ($categoria_insumo as $id => $nombre)
                                        <option value="{{ $id }}" {{ old('id_categoria_insumo') == $id ? 'selected' : '' }}>
                                            {{ $nombre }} </option>
                                    @endforeach
                                </select>

                                @error('id_categoria_insumo')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="nombre">Nombre <strong style="color: red;">*</strong></label>
                                <input type="text" name="nombre" class="form-control  @error('nombre') is-invalid  @enderror" id="nombre" placeholder="Nombre..." value="{{ old('nombre') }}">

                                @error('nombre')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label for="nombre">Descripción <strong style="color: red;">*</strong></label>
                                <input type="text" name="color" class="form-control  @error('color') is-invalid  @enderror" id="color" placeholder="Descripción..." value="{{ old('color') }}">

                                @error('color')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </div>    

                            <div class="col-md-6">
                                <label for="costo_unitario">Costo Unitario <strong style="color: red;">*</strong></label>
                                <input type="number" name="costo_unitario" class="form-control  @error('costo_unitario') is-invalid  @enderror" id="costo_unitario" placeholder="$$$" value="{{ old('costo_unitario') }}">

                                @error('costo_unitario')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="imagen">Imagen <strong style="color: red;">*</strong></label>
                                <input type="file" id="imagen" name="imagen" class="form-control  @error('imagen') is-invalid  @enderror"
                                placeholder="imagen">

                                @error('imagen')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{$message}}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <br>
                        <input type="button" class="btn btn-primary" value="Agregar" onclick="agregar()">
                        <a href="{{ route('Admin.insumo') }}" class="btn btn-danger ">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div> 
<script>
function agregar() {
    Swal.fire({
        title: "¡Estas seguro!",
        text: "¿Deseas agregar este insumo?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, agregar"
    }).then((result) => {
        if (result.isConfirmed) {
            event.preventDefault();

            document.getElementById('formulario_crear').submit();
        }
    });
}
</script>

@stop
