/**
 * Contact Form Gmail - AJAX Handler
 * Handles form submission without page reload
 */

jQuery(document).ready(function($) {
    'use strict';

    // Handle form submission
    $('#contact-form-gmail').on('submit', function(e) {
        e.preventDefault();

        var form = $(this);
        var submitBtn = form.find('.submit-btn');
        var spinner = form.find('.loading-spinner');
        var messageDiv = form.find('.form-messages');

        // Get form data
        var formData = {
            action: 'submit_contact_form',
            nonce: contactFormAjax.nonce,
            contact_name: form.find('#contact-name').val(),
            contact_email: form.find('#contact-email').val(),
            contact_message: form.find('#contact-message').val()
        };

        // Clear previous messages
        messageDiv.html('').removeClass('success error');

        // Disable submit button and show spinner
        submitBtn.prop('disabled', true);
        spinner.show();

        // Send AJAX request
        $.ajax({
            url: contactFormAjax.ajax_url,
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                // Hide spinner and enable button
                spinner.hide();
                submitBtn.prop('disabled', false);

                if (response.success) {
                    // Show success message
                    messageDiv.html('<div class="alert alert-success">' + response.data.message + '</div>')
                              .addClass('success');
                    
                    // Reset form
                    form[0].reset();
                    
                    // Scroll to message
                    $('html, body').animate({
                        scrollTop: messageDiv.offset().top - 100
                    }, 500);
                } else {
                    // Show error message
                    messageDiv.html('<div class="alert alert-error">' + response.data.message + '</div>')
                              .addClass('error');
                    
                    // Scroll to message
                    $('html, body').animate({
                        scrollTop: messageDiv.offset().top - 100
                    }, 500);
                }
            },
            error: function(xhr, status, error) {
                // Hide spinner and enable button
                spinner.hide();
                submitBtn.prop('disabled', false);

                // Show error message
                messageDiv.html('<div class="alert alert-error">An unexpected error occurred. Please try again.</div>')
                          .addClass('error');
                
                console.error('AJAX Error:', error);
            }
        });
    });

    // Real-time email validation
    $('#contact-email').on('blur', function() {
        var email = $(this).val();
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (email && !emailRegex.test(email)) {
            $(this).addClass('invalid');
        } else {
            $(this).removeClass('invalid');
        }
    });

    // Remove invalid class on focus
    $('.form-control').on('focus', function() {
        $(this).removeClass('invalid');
    });
});
