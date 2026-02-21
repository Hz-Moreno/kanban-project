import menssager from "../toast-menssager.js";
import { panel_boards } from "./global-board.js"

$(document).ready(function () {
    const modalTask = document.getElementById('modalTask');
    const columnSelect = $('#taskColumnSelect');

    if (modalTask) {
        modalTask.addEventListener('show.bs.modal', function () {
            columnSelect.empty();

            if (panel_boards.content && panel_boards.content.length > 0) {
                columnSelect.append('<option value="" selected disabled>Escolha uma coluna...</option>');
                panel_boards.content.forEach(column => {
                    columnSelect.append(`
                        <option value="${column.id}">
                            ${column.title}
                        </option>
                    `);
                });
            } else {
                columnSelect.append('<option value="">Nenhuma coluna encontrada</option>');
            }
        });
    }
});

export function checkBoardAvailability() {
    const btnAddTask = $('[data-bs-target="#modalTask"]');

    if (panel_boards.content.length === 0) {
        btnAddTask.addClass('disabled').attr('title', 'Crie uma coluna primeiro!');
        btnAddTask.css('cursor', 'not-allowed');
    } else {
        btnAddTask.removeClass('disabled').removeAttr('title');
        btnAddTask.css('cursor', 'pointer');
    }
}

$(document).ready(function () {
    const modalTask = document.getElementById('modalTask');

    if (modalTask) {
        modalTask.addEventListener('show.bs.modal', function (event) {
            if (panel_boards.content.length === 0) {
                event.preventDefault();
                menssager("Você precisa criar pelo menos uma coluna antes de adicionar tarefas!", "error");
            }
        });
    }
});



export function taskTemplate(content) {
    return `
    <div class="task-card p-3 mb-2 bg-white rounded shadow-sm border-start border-4 border-primary" id="${content.id}" draggable="true" data-positon="${content.position}">
            <p class="mb-1 fw-bold text-dark">${content.title}</p>
            <p class="mb-0 small text-muted text-truncate" style="max-height: 50px; overflow: hidden;">
                ${content.description}
            </p>

            <div class="mt-2 d-flex justify-content-end align-items-center">
                <button type="button"
                        data-id="${content.id}"
                        class="btn-delete-task btn btn-sm p-0 text-danger"
                        title="Excluir tarefa">
                    <small>Remover</small>
                </button>
            </div>
        </div>
    `;
}

export function populateBoard(tasks) {
    tasks.forEach(task => {
        let html = taskTemplate(task)
        $(`#${task.board_id} .column-body`).append(html);
    })
}
