import menssager from "../../toast-menssager"
import {taskTemplate} from "../task.js"
import { initSortable } from "../init-sortable.js"

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json'
        }
    })
    const formTask = $('#formTask');

    formTask.on('submit', function (e) {
        e.preventDefault();

        const form = $(this);
        const boardId = $('#taskColumnSelect').val();
        const position = $(`#${boardId} .kanban-task`).length;

        const formData = form.serializeArray();
        formData.push({ name: "position", value: position });

        $.ajax({
            url: '/task',
            method: 'POST',
            data: formData,
            success: function(response) {
                setTimeout(() => {
                    const content = response.data;
                    const html = taskTemplate(content);

                    $(`#${boardId} .column-body`).append(html);

                    form[0].reset();
                    const modalEl = document.getElementById('modalTask');
                    const modalInstance = bootstrap.Modal.getInstance(modalEl);
                    modalInstance?.hide();
                    initSortable($('.kanban-board'));

                    menssager("Tarefa criada com sucesso!", "success");
                }, 100)
            },
            error: function (err) {
                const errorMsg = err.responseJSON?.message || "Erro ao criar task.";
                menssager(errorMsg);
            }
        });
    });
});
