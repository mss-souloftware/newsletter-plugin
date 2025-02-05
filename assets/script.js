jQuery(document).ready(function ($) {
    $('#newsletter-form').submit(function (e) {
        e.preventDefault();

        var email = $('#newsletter-email').val();
        var submitButton = $('#newsletter-submit');
        var spinner = $('.spinner');

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
});
