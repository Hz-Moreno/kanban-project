import { saveNewPositions, columnTemplate } from "./column.js";
import menssager from "../toast-menssager.js";
import { populateBoard } from "./task.js"
import { panel_boards } from "./global-board.js"
import { initSortable } from "./init-sortable.js"

export function loadColumns(board, callback) {
    $.ajax({
        url: '/board',
        method: 'GET',
        success: function (response) {
            panel_boards.content = response.data || [];
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
                //
            })
            populateBoard(response.data);
        },
        error: function (err) {
            menssager("Erro ao buscar tarefas!")
        }
    })
}
