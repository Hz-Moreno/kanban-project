import { columnTemplate } from "../column";
import menssager from "../../toast-menssager";

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json',
        }
    })

    const columnForm = $('#columnForm');
    const board = $('.kanban-board');

    columnForm.on('submit', function (e) {
        e.preventDefault();

        const form = $(this);
        const input = form.find('input');
        const columnName = input.val().trim().toUpperCase();
        const btn = form.find('button[type="submit"]');
        const position = $('.kanban-board .kanban-column').length;

        if (!columnName) {
            menssager("O nome da coluna é obrigatório.");
            return;
        }

        const formData = form.serializeArray();
        formData.push({ name: "position", value: position });

        btn.prop('disabled', true).text('Salvando...');
        console.log(position);
        $.ajax({
            url: '/board',
            method: 'POST',
            data: formData,
            success: function (response) {

                const columnData = response.data;

                const html = columnTemplate(columnData.id, columnData.title, position);

                board.append(html);

                form[0].reset();
                const modalInstance = bootstrap.Modal.getInstance(document.getElementById('modalColumn'));
                modalInstance?.hide();

                menssager("Coluna criada com sucesso!", "success");
            },
            error: function (err) {
                const errorMsg = err.responseJSON?.message || "Erro ao criar coluna.";
                menssager(errorMsg);
            },
            complete: function() {
                btn.prop('disabled', false).text('Adicionar');
            }
        });
    });
});
