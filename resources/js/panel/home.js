import { saveNewPositions, columnTemplate } from "./column.js";
import menssager from "../toast-menssager.js";


export function initSortable(board) {
    const el = board[0];
    if (el) {
        import('sortablejs').then((Sortable) => {
            new Sortable.default(el, {
                animation: 150,
                handle: '.column-header',
                onEnd: saveNewPositions
            });
        });
    }
}

export function loadColumns(board) {
    $.ajax({
        url: '/board',
        method: 'GET',
        success: function (response) {
            console.log(response)
            if (response.data && response.data.length > 0) {
                board.empty();

                response.data.forEach(column => {
                    const html = columnTemplate(column.id, column.title, column.position);
                    board.append(html);
                });
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
    console.log('carregado cols')
    loadColumns(board);
});
