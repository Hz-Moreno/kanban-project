@extends('auth.layout')

@section('title')
    Login
@endsection

@section('description')
    <p class="text-muted">Bem-vindo de volta!</p>
@endsection

@push('scripts')
    @vite(['resources/js/auth/login.js'])
@endpush

@section('content')
    <form id="loginForm">
        <div class="mb-3">
            <label for="email" class="form-label text-secondary small fw-bold">E-MAIL</label>
            <input autocomplete="off" type="email" class="form-control form-control-lg" id="email" name="email" placeholder="seu@email.com" required>
        </div>

        <div class="mb-3">
            <div class="d-flex justify-content-between">
                <label for="password" class="form-label text-secondary small fw-bold">SENHA</label>
                <!--<a href="#" class="text-decoration-none small">Esqueceu a senha?</a>-->
            </div>
            <input type="password" class="form-control form-control-lg" id="password" name="password" required>
        </div>

        <div class="d-grid gap-2">
            <button id="submit-btn" type="submit" class="btn btn-primary btn-lg shadow-sm">
                Entrar
            </button>
        </div>
    </form>

    <hr class="my-4 text-muted">

    <div class="text-center">
        <p class="small mb-0">Não tem uma conta? <a href="/register" class="text-decoration-none fw-bold">Cadastre-se</a></p>
    </div>
@endsection
