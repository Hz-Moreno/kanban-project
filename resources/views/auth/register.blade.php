@extends('auth.layout')

@section('title')
    Cadastro
@endsection

@section('description')
    <p class="text-muted">Criar conta!</p>
@endsection

@section('content')
    <form id="loginForm">
        <div class="mb-3">
            <label for="name" class="form-label text-secondary small fw-bold">NOME</label>
            <input type="name" class="form-control form-control-lg" id="name" name="name" placeholder="seu nome completo" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label text-secondary small fw-bold">E-MAIL</label>
            <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="seu@email.com" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label text-secondary small fw-bold">SENHA</label>
            <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="*****" required>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label text-secondary small fw-bold">CONFIRME SUA SENHA</label>
            <input type="password_confirmation" class="form-control form-control-lg" id="password_confirmation" name="password" placeholder="*****" required>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                Criar conta
            </button>
        </div>
    </form>

    <hr class="my-4 text-muted">

    <div class="text-center">
        <p class="small mb-0">Ja possui uma conta? <a href="/login" class="text-decoration-none fw-bold">Faça o login</a></p>
    </div>
@endsection
