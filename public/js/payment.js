$(document).ready(function(){
    var hh = $('#top').outerHeight();
    var fh = $('footer').outerHeight();

    $('#sidebar').affix({
        offset:{
            top: hh + 250,
            bottom: fh + 95
        }
    });

    $("#payment_wizard").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        autoFocus: true,
        excluded: ':disabled',
        onStepChanging: function (e, currentIndex, newIndex) {
            var fv = $('#payment_wizard').data('formValidation'),

            // The current step container
            $container = $('#payment_wizard').find('section[data-step="' + currentIndex +'"]');

            // Validate the container
            fv.validateContainer($container);

            var isValidStep = fv.isValidContainer($container);

            if (isValidStep === false || isValidStep === null) {
                // Do not jump to the next step
                return false;
            }

            if (currentIndex == 1) {
                var url = $('#booking-details-form').data('url');

                $('#drop_off_at').val($('#drop-off-date-src').val() + ' ' + $('#drop-off-time-src').val());
                $('#return_at').val($('#return-at-date-src').val() + ' ' + $('#return-at-time-src').val());
                $('#flight_no_going').val($('#departure-src').val());
                $('#flight_no_return').val($('#arrival-src').val());
                $('#no_of_passengers_in_vehicle').val($('#no-of-passengers-in-vehicle-src').val());

                var with_oversize_baggage = $('#with-oversize-baggage').is('checked') ? 1 : 0;
                var with_children_pwd = $('#with-children-pwd').is('checked') ? 1 : 0;

                $('#with_oversize_baggage').val(with_oversize_baggage);
                $('#with_children_pwd').val(with_children_pwd);

                $.ajax({
                    url: url,
                    type: 'post',
                    data: $('#booking-details-form').serialize(),
                    dataType: 'json',
                    success: function (response) {

                    }
                });
            }

            return true;
        },
        // Triggered when clicking the Finish button
        onFinishing: function(e, currentIndex) {
            var fv         = $('#payment_wizard').data('formValidation'),
                $container = $('#payment_wizard').find('section[data-step="' + currentIndex +'"]');

            // Validate the last step container
            fv.validateContainer($container);

            var isValidStep = fv.isValidContainer($container);
            if (isValidStep === false || isValidStep === null) {
                return false;
            }

            return true;
        },
        onFinished: function(e, currentIndex) {
            // Uncomment the following line to submit the form using the defaultSubmit() method
            // $('#profileForm').formValidation('defaultSubmit');

            // For testing purpose
            // $('#welcomeModal').modal();
        }
    })
    .formValidation({
        framework: 'bootstrap',
        fields: {
            firstname: {
                validators: {
                    notEmpty: {
                        message: 'The first name is a required field'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9\-]+$/,
                        message: 'The first name can only consist of alphabetical, number and hyphen'
                    }
                }
            },
            lastname: {
                validators: {
                    notEmpty: {
                        message: 'The last name is a required field'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9\-]+$/,
                        message: 'The last name can only consist of alphabetical, number and hyphen'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'The email address is required'
                    },
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    }
                }
            },
            confirm_email: {
                validators: {
                    notEmpty: {
                        message: 'The confirm email is required'
                    },
                    identical: {
                        field: 'email',
                        message: 'The confirm email must be the same as the value in email field'
                    }
                }
            },
            phone: {
                validators: {
                    phone: {
                        country: 'country_code',
                        message: 'The value is not valid %s phone number'
                    }
                }
            },
            card_number: {
                validators: {
                    creditCard: {
                        message: 'The credit card number is not valid'
                    }
                }
            },
            cv_code: {
                validators: {
                    cvv: {
                        creditCardField: 'card_number',
                        message: 'The CVV number is not valid'
                    }
                }
            },
            expiration : {
                validators: {
                    date: {
                        format: 'MM/YYYY',
                        message: 'The value is not a valid credit card expiration date'
                    }
                }
            },
            drop_off_date: {
                validators: {
                    notEmpty: {
                        message: 'The drop off date is a required field'
                    },
                    date: {
                        format: 'MM/DD/YYYY',
                        message: 'The value is not a valid date'
                    }
                }
            },
            return_at_date: {
                validators: {
                    notEmpty: {
                        message: 'The return at date is a required field'
                    },
                    date: {
                        format: 'MM/DD/YYYY',
                        message: 'The value is not a valid date'
                    }
                }
            },
            flight_no_going: {
                validators: {
                    notEmpty: {
                        message: 'The departure flight no is a required field'
                    }
                }
            },
            flight_no_return: {
                validators: {
                    notEmpty: {
                        message: 'The arrival flight no is a required field'
                    }
                }
            }
        }
    });

    $("#payment_choice").steps({
        headerTag: "h4",
        bodyTag: "fieldset",
        transitionEffect: "slideLeft",
        enableFinishButton: false,
        enablePagination: false,
        enableAllSteps: true,
        titleTemplate: "#title#",
        cssClass: "tabcontrol"
    });

    $(document).on('click', '#sms-fee', function () {
        var total = $('#total').text().substr(1);
        if ($(this).is(':checked')) {
            total = parseFloat(total) + parseFloat($(this).val());
        } else {
            if ($('#total').data('value') < total) {
                total = parseFloat(total) - parseFloat($(this).val());
            }
        }

        $('#total').text('£'+total.toLocaleString());
        $('#total-amount').val(total.toLocaleString());
    });

    $(document).on('click', '#cancellation-fee', function () {
        console.log('xxx');
        var total = $('#total').text().substr(1);
        if ($(this).is(':checked')) {
            total = parseFloat(total) + parseFloat($(this).val());
        } else {
            if ($('#total').data('value') < total) {
                total = parseFloat(total) - parseFloat($(this).val());
            }
        }

        $('#total').text('£'+total.toLocaleString());
        $('#total-amount').val(total.toLocaleString());
    });

    $(document).on('click', '#toggle-paypal', function (e) {
        e.preventDefault();
        $('#firstname').val($('#firstname-src').val());
        $('#lastname').val($('#lastname-src').val());
        $('#email').val($('#email-src').val());
        $('#phoneno').val($('#phone-src').val());
        $('#sms').val($('#sms-fee').val());
        $('#cancellation').val($('#cancellation-fee').val());
        $('#car-registration-no').val($('#car-registration-no-src').val());
        $('#vehicle-color').val($('#vehicle-color-src').val());
        $('#vehicle-model').val($('#vehicle-model-src').val());
        $('#order-form').submit();
    });

    if ($('#sms-fee').is(':checked')) {
        var total = $('#total').text().substr(1);
        total = parseFloat(total) + parseFloat($('#sms-fee').val());
        $('#total').text('£'+total.toLocaleString());
        $('#total-amount').val(total.toLocaleString());
    }

    if ($('#cancellation').is(':checked')) {
        var total = $('#total').text().substr(1);
        total = parseFloat(total) + parseFloat($('#cancellation').val());
        $('#total').text('£'+total.toLocaleString());
        $('#total-amount').val(total.toLocaleString());
    }
});

$(document).ready(function() {
    $(window).scroll(function() {
      if($(this).scrollTop() > 50) {
          $('.navbar').addClass('solid');
          $('#sidebar').addClass('sidebar-mar');
          $('nav').removeClass('bg-dark');
          $('.Vl').removeClass('vl');
      } else {
          $('.navbar').removeClass('solid');
          $('nav').addClass('bg-dark');
          $('.Vl').addClass('vl');
          $('#sidebar').removeClass('sidebar-mar');
      }
    });
});

$(document).ready(function() {
    $(window).scroll(function() {
      if($(this).scrollTop() > 250) {
          $('#sidebar').addClass('sidebar-mar');
      } else {
          $('#sidebar').removeClass('sidebar-mar');
      }
    });
});

function openNav() {
    document.getElementById("mobileNav").style.width = "100%";
    $('.nav-icon').hide();
}

function closeNav() {
    document.getElementById("mobileNav").style.width = "0%";
    $('.nav-icon').show();

}