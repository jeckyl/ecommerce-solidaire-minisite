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