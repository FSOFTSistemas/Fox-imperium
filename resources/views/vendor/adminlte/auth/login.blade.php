@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])
@laravelPWA

@php( $login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login') )
@php( $register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register') )
@php( $password_reset_url = View::getSection('password_reset_url') ?? config('adminlte.password_reset_url', 'password/reset') )

@if (config('adminlte.use_route_url', false))
    @php( $login_url = $login_url ? route($login_url) : '' )
    @php( $register_url = $register_url ? route($register_url) : '' )
    @php( $password_reset_url = $password_reset_url ? route($password_reset_url) : '' )
@else
    @php( $login_url = $login_url ? url($login_url) : '' )
    @php( $register_url = $register_url ? url($register_url) : '' )
    @php( $password_reset_url = $password_reset_url ? url($password_reset_url) : '' )
@endif

{{-- Adicione o CSS aqui --}}
@section('css')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');
        .login-page {
            background: url('/images/login-backgound.jpg') no-repeat center center fixed;
            background-size: cover;

            /* Cria um overlay escuro */
            position: relative;
        }

        /* Adiciona o overlay escuro */
        .login-page::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Fundo preto semitransparente */
            z-index: 1;
        }

        /* Garante que o conteúdo esteja acima do overlay */
        .login-box, .login-logo {
            position: relative;
            z-index: 2;
        }

        .login-box .card {
            border-radius: 15px;
            overflow: hidden;
        }

        /* Texto branco e fonte personalizada */
        body, .login-box, .login-logo, .login-box input, .login-box label, .login-box a {
            color: #fff !important;
            font-family: 'Poppins', sans-serif;
        }

        .form-control {
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
            border: 1px solid #000;
        }

        .form-control::placeholder {
            color: #000;
        }

        .input-group-text {
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
            border: 1px solid #000;
        }
    </style>
@endsection

@section('auth_header', __('adminlte::adminlte.login_message'))

@section('auth_body')
    <form action="{{ $login_url }}" method="post">
        @csrf

        {{-- Email field --}}
        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" placeholder="Digite seu e-mail" autofocus>

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Password field --}}
        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                   placeholder="Digite sua senha">

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Login field --}}
        <div class="row">
            <div class="col-12">
                <button type=submit class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
                    <span class="fas fa-sign-in-alt"></span>
                    {{ __('adminlte::adminlte.sign_in') }}
                </button>
            </div>
        </div>
    </form>
@stop

@section('auth_footer')
    {{-- Password reset link --}}
    @if($password_reset_url)
        <p class="my-0">
            <a href="{{ $password_reset_url }}">
                {{ __('adminlte::adminlte.i_forgot_my_password') }}
            </a>
        </p>
    @endif

    {{-- Register link --}}
    @if($register_url)
        <p class="my-0">
            <a href="{{ $register_url }}">
                {{ __('adminlte::adminlte.register_a_new_membership') }}
            </a>
        </p>
    @endif
@stop
