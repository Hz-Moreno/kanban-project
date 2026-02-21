import Sortable from 'sortablejs';
import menssager from "../toast-menssager.js";

export function initSortable(board) {
    const el = board[0];

    if (!el) {
        if (typeof menssager === 'function') menssager("Erro ao inicializar sortable!");
        return;
    }

    if (!Sortable.get(el)) {
        new Sortable(el, {
            animation: 150,
            handle: '.column-header',
            draggable: '.kanban-column',
            onEnd: (evt) => {
                import("./column.js").then(m => m.saveNewPositions(evt));
            }
        });
    }

    const taskLists = el.querySelectorAll('.column-body');
    taskLists.forEach(list => {
        if (Sortable.get(list)) return;

        new Sortable(list, {
            group: 'shared-tasks',
            animation: 150,
            ghostClass: 'sortable-ghost',
            onEnd: (evt) => {
                import("./save-task-positions.js").then(m => m.saveNewTaskPositions(evt));
            }
        });
    });
}
