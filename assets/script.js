jQuery(document).ready(function ($) {
    $('#newsletter-form').submit(function (e) {
        e.preventDefault();

        let email = $('#newsletter-email').val();
        let submitButton = $('#newsletter-submit');
        let spinner = $('.spinner');

        // Show spinner and disable button
        spinner.show();
        submitButton.prop('disabled', true);

        $.ajax({
            type: 'POST',
            url: newsletter_ajax.ajaxurl,
            data: { action: 'newsletter_submit', email: email },
            success: function (response) {
                $('#newsletter-message').html(response);
                $('#newsletter-email').val('');

                // Hide spinner and enable button
                spinner.hide();
                submitButton.prop('disabled', false);
            }
        });
    });


    $('#contactForm').submit(function (e) {
        e.preventDefault();
        let spinner = $('.spinner');

        // Show spinner and disable button
        let submitButton = $('#contactFormSubmit');
        spinner.show();
        submitButton.prop('disabled', true);

        $.post(newsletter_ajax.ajaxurl, {
            action: 'submit_contact_form',
            name: $('#contact_name').val(),
            email: $('#contact_email').val(),
            phone: $('#contact_phone').val(),
            message: $('#contact_message').val()
        }, function (response) {
            // alert(response.data.message);
            $('#contact-message').html(response.data.message);

            $('#contact_name').val('');
            $('#contact_email').val('');
            $('#contact_phone').val('');
            $('#contact_message').val('');
            // Hide spinner and enable button
            spinner.hide();
            submitButton.prop('disabled', false);
        });
    });
});
