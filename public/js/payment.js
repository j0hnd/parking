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
            console.log($container);


            // Validate the container
            fv.validateContainer($container);

            var isValidStep = fv.isValidContainer($container);

            if (isValidStep === false || isValidStep === null) {
                // Do not jump to the next step
                return false;
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

    $(document).on('click', '#cancellation', function () {
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

    $(document).on('click', '#toggle-paypal', function () {
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