<div class="modal fade" id="modalTask" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Nova Tarefa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formTask">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">TÍTULO</label>
                        <input name="title" type="text" class="form-control" placeholder="O que precisa ser feito?">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">DESCRIÇÃO</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="taskColumnSelect" class="form-label small fw-bold">Selecione a Coluna</label>
                        <select class="form-select form-select-sm" id="taskColumnSelect" name="board_id"></select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Criar Task</button>
                </form>
            </div>
        </div>
    </div>
</div>
