import menssager from "../../toast-menssager";

$(document).ready(function () {
    const board = $('.kanban-board');

    board.on('click', '.column-title', function () {
        const span = $(this);
        const header = span.closest('.column-header');
        const actions = header.find('.header-actions');
        const currentName = span.text();
        const columnId = span.closest('.kanban-column').attr('id');

        span.replaceWith(`<input style="width: 80%" type="text" class="form-control form-control-sm edit-column-input" value="${currentName}" data-old-value="${currentName}">`);

        actions.html(`
            <button class="btn btn-sm btn-success btn-confirm-edit" data-id="${columnId}">
                <i class="bi bi-check-lg"></i> OK
            </button>
        `);

        header.find('input').focus().select();
    });


    board.on('click', '.btn-confirm-edit', function () {
        const btn = $(this);
        const header = btn.closest('.column-header');
        const input = header.find('.edit-column-input');
        const newName = input.val().trim().toUpperCase();
        const columnId = btn.data('id');

        if (!newName) {
            menssager("O nome não pode estar vazio.");
            return;
        }

        const formData = {
            board_id: columnId,
            data: {
                title: newName
            }
        }

        $.ajax({
            url: `/board/${columnId}`,
            contentType: 'application/json',
            method: 'PUT',
            data:  JSON.stringify(formData),
            success: function () {
                finishEdit(header, newName, columnId);
                menssager("Nome atualizado!", "success");
            },
            error: function () {
                const oldVal = input.data('old-value');
                finishEdit(header, oldVal, columnId);
                menssager("Erro ao atualizar nome.");
            }
        });
    });

    function finishEdit(header, name, id) {
        header.find('.edit-column-input').replaceWith(`<span class="fw-bold text-secondary text-uppercase small column-title">${name}</span>`);
        header.find('.header-actions').html(`
            <button class="btn btn-sm btn-light border btn-add-task" data-bs-toggle="modal" data-bs-target="#modalTask" data-column-id="${id}">
                +
            </button>
        `);
    }
});
