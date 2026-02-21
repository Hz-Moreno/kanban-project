<!DOCTYPE html>
<html lang="pt-br">
    @include('panel.layouts.head')
<body class="d-flex flex-column vh-100 overflow-hidden">
    @include('messages.toast')

    <header class="flex-shrink-0">
        @include('panel.layouts.navbar')
    </header>

    <main class="kanban-board flex-grow-1">
        @yield('content')
    </main>

    @include('panel.modals.create-task-modal')
    @include('panel.modals.create-column-modal')

    <footer class="footer mt-auto py-3 bg-light border-top flex-shrink-0">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between small">
                <div class="text-muted">
                    made with ❤️ | by Hezrai Moreno
                </div>
                <div>
                    <a href="https://www.linkedin.com/in/hezrai-moreno-665008391/" class="text-decoration-none text-muted me-3">Linkedin</a>
                    <a href="https://github.com/Hz-Moreno?tab=repositories" class="text-decoration-none text-muted">Git Hub</a>
                </div>
                <div class="d-none d-md-inline">
                    <a href="https://portifolio-omega-tan-iq1slmh9p4.vercel.app/" target="_blank" class="text-decoration-none">
                        <span class="badge badge-rainbow">Ver Portfólio</span>
                    </a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
