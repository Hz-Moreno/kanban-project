<!DOCTYPE html>
<html lang="pt-br">
    @include('panel.layouts.head')
<body>

    @include('panel.layouts.navbar')

    <main class="kanban-board">
        @yield('content')
    </main>

    @include('panel.modals.create-task-modal')
    @include('panel.modals.create-column-modal')

</body>
</html>
