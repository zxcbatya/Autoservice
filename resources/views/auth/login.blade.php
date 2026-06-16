@extends('adminlte-layout.master')

@section('adminlte_css_pre')
    <link rel="stylesheet" href="{{ asset('vendor/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endsection

@section('title', 'Вход в админку')

@section('classes_body', 'login-page')

@section('body')
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ url('/login') }}">
                <img src="{{ asset('vendor/dist/img/AdminLTELogo.png') }}" height="50" alt="">
                <b>Admin</b>LTE
            </a>
        </div>

        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title float-none text-center w-100">Авторизация</h3>
            </div>
            <div class="card-body login-card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form action="{{ url('/login') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" placeholder="Email" autofocus required>
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                               placeholder="Пароль" required>
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-lock"></span></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-7">
                            <div class="icheck-primary">
                                <input type="checkbox" name="remember" id="remember">
                                <label for="remember">Запомнить</label>
                            </div>
                        </div>
                        <div class="col-5">
                            <button type="submit" class="btn btn-primary btn-block">Войти</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop