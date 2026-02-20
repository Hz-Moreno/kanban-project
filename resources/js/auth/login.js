import menssager from "../toast-menssager.js"

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json',
        }
    })

    $('#loginForm').on('submit', function (e) {
        e.preventDefault()

        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        const btn = $('#submit-btn')
        btn.prop('disabled', true).text('Processando...')

        const formData = $(this).serialize()

        $.ajax({
            url: '/login/create',
            method: 'POST',
            data: formData,
            success: function (response) {
                menssager('Login completo! Redirecionando para o painel...', 'success')
                setTimeout(() => {
                    window.location.href = '/panel'
                }, 2400)
            },
            error: function (err) {

                btn.prop('disabled', false).text('Login')

                if (err.status === 422) {
                    const errors = err.responseJSON.errors
                    $.each(errors, function (field, messages) {
                        const input = $(`#${field}`)
                        input.addClass('is-invalid')
                        input.after(`<div class="invalid-feedback">${messages[0]}</div>`)
                    })
                } else if(err.status === 401) {
                    menssager('Credenciais inválidas!')
                } else {
                    menssager('Internal Error!')
                }
            }
        })
    })
})
