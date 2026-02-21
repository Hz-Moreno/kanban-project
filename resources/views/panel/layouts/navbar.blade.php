<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold text-primary" href="#">Kanban</a>
        <div class="d-flex">
            <button id="addColumnBtn" class="btn btn-sm btn-outline-primary me-2">Novo Quadro</button>
            <button class="btn btn-sm btn-outline-danger me-2" data-bs-toggle="modal" data-bs-target="#modalTask">
                <i class="bi bi-folder-plus"></i> Nova Tarefa
            </button>
            <div class="dropdown">
                <img src="https://ui-avatars.com/api/?name=User" class="rounded-circle dropdown-toggle" width="35" role="button" data-bs-toggle="dropdown">
                <ul class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item text-danger"
                        href="#"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Sair
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </ul>
            </div>
        </div>
    </div>
</nav>
