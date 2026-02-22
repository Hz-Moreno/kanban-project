export function organizeBoards() {
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
            //
        },
        error: function (err) {
            console.error('Erro ao sincronizar board', err);
        }
    });
}
