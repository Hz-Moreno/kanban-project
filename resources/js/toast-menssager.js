export default function menssager(message, type = 'alert') {
    const toastEl = $('#liveToast')
    const toastBody = $('#toast-message')

    toastEl.removeClass('text-bg-success text-bg-danger')
    toastEl.addClass(type === 'success' ? 'text-bg-success' : 'text-bg-danger')

    toastBody.text(message)

    const bootstrapObj = window.bootstrap;

    if (bootstrapObj) {
        const toast = new bootstrapObj.Toast(toastEl);
        toast.show();
    }
}
