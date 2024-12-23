@extends('layouts.app')

@section('content')

<head>
    <!-- Otros enlaces y metadatos -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.9/css/unicons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}"> <!-- Asegúrate de tener este archivo -->
    <script defer src="https://app.embed.im/snow.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script> <!-- Si tienes algún script JS adicional -->
</head>

<div class="fondo-imagen">
    <img src="{{ asset('img/fondo.jpg') }}">
</div>
<div class="section">
    <div class="container">
        <div class="row full-height justify-content-center">
            <div class="col-12 text-center align-self-center py-5">
                <div class="section pb-5 pt-5 pt-sm-2 text-center">
                    <div class="card-3d-wrap mx-auto">
                        <div class="card-3d-wrapper">
                            <div class="card-3d-wrap mx-auto">
                                <div class="card-3d-wrapper">
                                    <div class="card-login">
                                        <div class="center-wrap">
                                            <h4 class="mb-4 pb-3">Restablecer contraseña</h4>
                                        @if (session('status'))
                                            <div class="alert alert-success" role="alert">
                                                {{"Te hemos enviado un correo electrónico para que puedas restablecer tu contraseña"}}
                                            </div>
                                        @endif
 
                                        <form method="POST" action="{{ route('password.email') }}">
                                            @csrf

                                            <div class="form-group">
                                                <input id="email" type="email" class="form-style @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Correo electrónico" maxlength="80">
                                                <i class="input-icon uil uil-at"></i>
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>No hemos podido encontrar tu Email.</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <button type="submit" class="btn mt-4">Restablecer contraseña</button>
                                        </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
