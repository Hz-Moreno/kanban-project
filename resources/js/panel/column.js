import menssager from "../toast-menssager.js";
import Sortable from "sortablejs";

export function saveNewPositions() {
    const movementData = [];

    $('.kanban-column').each(function (index) {
        const columnId = $(this).attr('id');
        $(this).attr('data-position', index);

        movementData.push({
            board_id: columnId,
            position: index
        });
    });

    $.ajax({
        url: '/board/move',
        method: 'PUT',
        contentType: 'application/json',
        data: JSON.stringify({data: movementData}),
        success: function (response) { },
        error: function (err) {
            menssager('Error ao processar movimento de colunas')
        }
    })
}

export function columnTemplate(id, columnName, position) {
    return `
        <div id="${id}" class="kanban-column shadow-sm" data-position="${position}">
            <div class="column-header d-flex justify-content-between align-items-center p-2" style="cursor: grab;">
                <span class="fw-bold text-secondary text-uppercase small column-title">${columnName}</span>

                <div class="header-actions">
                    <button  class="del-column-btn btn btn-sm btn-danger border btn-add-task" data-column-id="${id}">
                        -
                    </button>
                </div>
            </div>
            <div class="column-body p-2" style="min-height: 10px;">
            </div>
        </div>
    `;
}
