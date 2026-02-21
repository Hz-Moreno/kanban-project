import menssager from "../../toast-menssager.js";

$(document).on('click', '.btn-delete-task', function() {
    const taskId = $(this).data('id');
    const cardElement = $(this).closest('.task-card');

    $.ajax({
        url: `/task/${taskId}`,
        method: 'DELETE',
        data: { task_id: taskId },
        success: function (response) {
            cardElement.fadeOut(300, function() {
                $(this).remove();
            });

            menssager("Tarefa deletada!", "success")
        },
        error: function (err) {
            menssager("erro ao deletar tarefa!")
        }
    })
})
