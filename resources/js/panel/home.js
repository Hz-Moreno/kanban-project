import { saveNewPositions, columnTemplate } from "./column.js";
import menssager from "../toast-menssager.js";
import { populateBoard } from "./task.js"
import { panel_boards } from "./global-board.js"
import { initSortable } from "./init-sortable.js"



function organizeBoards() {
    const payload = {
        tasks: []
    };

    $('.kanban-column').each(function () {
        const columnId = $(this).attr('id');

        $(this).find('.task-card').each(function (index) {
            payload.tasks.push({
                id: $(this).attr('id'),
                position: index,
                board_id: columnId
            });
        });
    });

    $.ajax({
        url: '/boards/organize',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(payload),
        success: function (response) {
            console.log('Board sincronizado com sucesso');
        },
        error: function (err) {
            console.error('Erro ao sincronizar board', err);
        }
    });
}

export function loadColumns(board, callback) {
    $.ajax({
        url: '/board',
        method: 'GET',
        success: function (response) {
            panel_boards.content = response.data || [];
            console.log("INIT: ", panel_boards.content)
            if (response.data && response.data.length > 0) {
                board.empty();

                response.data.forEach(column => {
                    const html = columnTemplate(column.id, column.title, column.position);
                    board.append(html);
                });

                if (callback) callback();
            }

            initSortable(board)
        },
        error: function () {
            menssager("Erro ao carregar os quadros.");
        }
    });
}

$(document).ready(function () {
    let board = $('.kanban-board');
    loadColumns(board, function () {
        setTimeout(() => {
            loadTasks();
        }, 1000)
    });
});

export function loadTasks() {
    $.ajax({
        url: '/task',
        method: 'GET',
        data: {},
        success: function (response) {
            response.data.forEach(t => {
                console.log('ai', t)
            })
            populateBoard(response.data);
        },
        error: function (err) {
            menssager("Erro ao buscar tarefas!")
        }
    })
}
