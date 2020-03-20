window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

//window.Popper = require('popper.js').default;
window.$ = window.jQuery = require('jquery');

// Load needs validation form
(function() {
    'use strict';
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        let forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        let validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                } else {
                    form.classList.add('is-validate');
                }
                form.classList.add('was-validated');
            }, false);
        });


    }, false);
})();

$(document).ready(function () {
    $("#form-container").on('submit', '#contact-form.is-validate', function (e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = $(this);
        var url = form.attr('action');

        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(), // serializes the form's elements.
            success: function (msg) {
                if (msg === 'success') {
                    $('#submit').text('Le formulaire a été envoyé').addClass('btn-success');
                } else {
                    $('#submit').text('Une erreur est survenue').addClass('btn-danger');
                    alert(data); // show response from the php script.
                }
            }
        });
    });
});