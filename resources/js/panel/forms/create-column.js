import { columnTemplate } from "../column";
import menssager from "../../toast-menssager";
import { panel_boards } from "../global-board.js"
import { initSortable } from "../init-sortable.js";


$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json',
        }
    })

    const addColumnBtn = $('#addColumnBtn');
    const board = $('.kanban-board');

    addColumnBtn.on('click', function (e) {
        e.preventDefault();

        const position = $('.kanban-board .kanban-column').length;
        const formData = {
            name: 'Novo quadro!',
            position: position,
        }

        $.ajax({
            url: '/board',
            method: 'POST',
            data: formData,
            success: function (response) {
                const columnData = response.data;
                const html = columnTemplate(columnData.id, columnData.title, position);

                board.append(html);
                const modalInstance = bootstrap.Modal.getInstance(document.getElementById('modalColumn'));
                modalInstance?.hide();

                panel_boards.content.push(response.data)
                console.log("PUSH: ", panel_boards.content)
                initSortable($('.kanban-board'));
                menssager("Coluna criada com sucesso!", "success");
            },
            error: function (err) {
                const errorMsg = err.responseJSON?.message || "Erro ao criar coluna.";
                menssager(errorMsg);
            },
            complete: function() {

            }
        });
    });
});
