import menssager from '../toast-menssager.js'

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json',
        }
    })

    $('#registerForm').on('submit', function (e) {
        e.preventDefault()

        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()

        const btn = $('#submit-btn')
        btn.prop('disabled', true).text('Processando...')

        const formData = $(this).serialize()

        $.ajax({
            url: '/register/create',
            method: 'POST',
            data: formData,
            success: function (response) {
                menssager('Consta criada com successo! Por favor faça o login!', 'success')
                setTimeout(() => {
                    window.location.href = '/login'
                }, 2400)
            },
            error: function (err) {

                btn.prop('disabled', false).text('Criar conta')

                if (err.status === 422) {
                    const errors = err.responseJSON.errors
                    $.each(errors, function (field, messages) {
                        const input = $(`#${field}`)
                        input.addClass('is-invalid')
                        input.after(`<div class="invalid-feedback">${messages[0]}</div>`)
                    })
                } else {
                    menssager('Internal Error!')
                }
            }
        })
    })
})
