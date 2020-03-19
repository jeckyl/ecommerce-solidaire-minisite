import 'bootstrap/js/src/util';
import 'bootstrap/js/src/modal';

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
                }
                form.classList.add('was-validated');
            }, false);
        });


    }, false);
})();

$("#contact-form").submit(function(e) {

    e.preventDefault(); // avoid to execute the actual submit of the form.

    var form = $(this);
    var url = form.attr('action');

    $.ajax({
        type: "POST",
        url: url,
        data: form.serialize(), // serializes the form's elements.
        success: function(msg)
        {
            if (msg === 'success') {
                $('#submit').text('Le formulaire a été envoyé').addClass('btn-success');
            } else {
                $('#submit').text('Une erreur est survenue').addClass('btn-danger');
                alert(data); // show response from the php script.
            }
        }
    });


});