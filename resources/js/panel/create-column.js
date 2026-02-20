import menssager from "../toast-menssager.js"

export function columnTemplate(id, columnName) {
    return `
        <div id=${id} class="kanban-column">
            <div class="column-header">
                <span class="fw-bold text-secondary uppercase small">${columnName}</span>
                <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#modalTask">
                    <i class="bi bi-plus-lg"></i>
                </button>
            </div>
            <div class="column-body">
            </div>
        </div>
    `;
}


$(document).ready(function () {
    $('#columnForm').on('submit', function(e) {
        e.preventDefault();

        const columnName = $(this).find('input').val().toUpperCase();

        if (columnName.trim() === "") {
            menssager("Por favor, digite um nome para a coluna.");
            return;
        }

        const formData = $(this).serialize();

        $.ajax({
            url: '/boards',
            method: 'POST',
            data: formData,
            success: function (response) {
                const html = columnTemplate(id, columnName)

                $('.kanban-board').append(html);

                this.reset();
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalColumn'));
                modal.hide();

                if (typeof reativarSortable === "function") {
                    reativarSortable();
                }
            },
            error: function (err) {

            }
        })


    });
});
