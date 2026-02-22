import { organizeBoards } from "./organize-boards";

export function saveNewTaskPositions() {
    setTimeout(() => {
        organizeBoards();
    }, 100);
}
