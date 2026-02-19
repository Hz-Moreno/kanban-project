<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | Kanban System</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('scripts')

    <style>
        body {
            background: #f8f9fa;
            height: 100vh;
        }
        .auth-container {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body>
@include('messages.toast')

<div class="container auth-container">
    <div class="row w-100 justify-content-center">
        <div class="col-10 col-sm-8 col-md-6 col-lg-4">

            <div class="card p-4">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-primary">Kanban</h2>
                        @yield('description')
                    </div>

                    @yield('content')
                </div>
            </div>

            <p class="text-center text-muted mt-4 small">made with ❤️ | by <a href="https://portifolio-omega-tan-iq1slmh9p4.vercel.app/" target="_blank">Hezrai Moreno</a> </p>

        </div>
    </div>
</div>

</body>
</html>
