'use strict'
// Obtém todos os formulários com a classe needs-validation
var forms = document.querySelectorAll('.needs-validation')

// Loop sobre cada formulário e previne o envio se for inválido
Array.prototype.slice.call(forms)
    .forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
    })