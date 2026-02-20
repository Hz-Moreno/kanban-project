import menssager from "../../toast-menssager";

export function deleteColumn(board, id) {
    const column = $(`#${id}`)

    column.fadeOut(300, function () {
        $(this).remove();
    })
}

$(document).ready(function () {
    const board = $('.kanban-board')

    board.on('click', '.del-column-btn', function () {
        const btn = $(this)
        const columnId = btn.data('column-id')

        btn.prop('disabled', true)

        $.ajax({
            url: `/board/${columnId}`,
            contentType: 'application/json',
            method: 'DELETE',
            data: {},
            success: function () {
                menssager("Quadro deletado!", "success")
                deleteColumn(board, columnId)
            },
            error: function () {
                menssager("Erro ao deletar quadro!")
                btn.prop('disabled', false)
            }
        })
    })
})
