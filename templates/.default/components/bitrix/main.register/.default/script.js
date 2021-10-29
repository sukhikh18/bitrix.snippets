document.addEventListener('DOMContentLoaded', () => {
    const formEl = document.querySelector('.form-main-register')
    if (!formEl) return;

    const submitEl = formEl.querySelector('[type="submit"]')

    !formEl || formEl.querySelector('[name="privacy_accept"]').addEventListener('input', e => {
        if (e.target.checked) {
            submitEl.classList.remove('disabled')
            submitEl.removeAttribute('disabled')
        } else {
            submitEl.classList.add('disabled')
            submitEl.setAttribute('disabled', 'true')
        }
    });

    window.cloneValue = (passwordSelector, confirmSelector) => {
        const password = form.querySelector(passwordSelector)
        const confirm = form.querySelector(confirmSelector)

        if (password && confirm) {
            password.addEventListener('keyup', function(e) {
                confirm.value = e.target.value;
            })

            confirm.removeAttribute('readonly')
        }
    }
});
