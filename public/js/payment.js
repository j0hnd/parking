$(document).ready(function(){
    var hh = $('#top').outerHeight();
    var fh = $('footer').outerHeight();

    $('#sidebar').affix({
        offset:{
            top: hh + 250,
            bottom: fh + 90
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
                $container = $('#payment_wizard').find('section[data-step="' + currentIndex +'"]');

            // Validate the container
            fv.validateContainer($container);

            var isValidStep = fv.isValidContainer($container);

            if (isValidStep === false || isValidStep === null) {
                // Do not jump to the next step
                return false;
            }

            if (newIndex == 0) {
                setTimeout(function () {
                    $('#payment_choice-p-0').show();
                    $('#payment_choice-p-0').css('left', '0px');

                    $('#payment_choice-p-1').hide();
                    $('#payment_choice-p-2').hide();
                }, 500);
            }

            if (newIndex == 1 && $('#stripe-container').is(':visible')) {
                $('#payment_wizard-p-1').show();
                $('#payment_wizard-p-1').css('left', '0px');
            } else {
                $('#payment_wizard-p-1').hide();
            }

            if ($('#sms-fee').is(':checked')) {
                var total = $('#total').text().substr(1);
                total = parseFloat(total) + parseFloat($('#sms-fee').val());
                $('#total').text('£'+total.toLocaleString());
                $('#total-amount').val(total.toLocaleString());
                $('#sms-fee-wrapper').text($('#sms-fee').val());
                $('#sms-confirmation').val(1);
                $('#sms').val($('#sms-fee').val());
            } else {
                $('#sms-confirmation').val(0);
                $('#sms').val(0);
            }

            if ($('#cancellation-fee').is(':checked')) {
                var total = $('#total').text().substr(1);
                total = parseFloat(total) + parseFloat($('#cancellation').val());
                $('#total').text('£'+total.toLocaleString());
                $('#total-amount').val(total.toLocaleString());
                $('#cancellation').val($('#cancellation-fee').val());
            } else {
                $('#cancellation').val(0);
            }

            if (currentIndex == 1 && $('#paypal-container').is(':visible')) {
                var url = $('#booking-details-form').data('url');

                $('#drop_off_at').val($('#drop-off-date-src').val() + ' ' + $('#drop-off-time-src').val());
                $('#return_at').val($('#return-at-date-src').val() + ' ' + $('#return-at-time-src').val());
                $('#flight_no_going').val($('#departure-src').val());
                $('#flight_no_return').val($('#arrival-src').val());
                $('#no_of_passengers_in_vehicle').val($('#no-of-passengers-in-vehicle-src').val());

                var with_oversize_baggage = $('#with-oversize-baggage').is(':checked') ? 1 : 0;
                var with_children_pwd = $('#with-children-pwd').is(':checked') ? 1 : 0;

                $('#with_oversize_baggage').val(with_oversize_baggage);
                $('#with_children_pwd').val(with_children_pwd);

                $.ajax({
                    url: url,
                    type: 'post',
                    data: $('#booking-details-form').serialize(),
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            $('#booking-id-wrapper').html("<strong>"+ response.data +"</strong>");
                        }
                    }
                });
            }

            if (currentIndex == 1 && newIndex == 0) {
                $('#payment_wizard-p-2').hide();
            }

            if (currentIndex == 0 && $('#stripe-container').is(':visible')) {
                $('#firstname').val($('#firstname-src').val());
                $('#lastname').val($('#lastname-src').val());
                $('#email').val($('#email-src').val());
                $('#phoneno').val($('#phone-src').val());
                // $('#sms').val($('#sms-fee').val());
                // $('#cancellation').val($('#cancellation').val());
                $('#car-registration-no').val($('#car-registration-no-src').val());
                $('#vehicle-color').val($('#vehicle-color-src').val());
                $('#vehicle-model').val($('#vehicle-model-src').val());
                $('#other-vehicle-model-model').val($('#other-vehicle-model-src').val());
                $('#vehicle-make').val($('#vehicle-make-src').val());
                $('#coupon').val($('#coupon-src').val());
                $('#card-name').val($('#card-name-src').val());
                $('#card-number').val($('#card-number-src').val());
                $('#expiration-month').val($('#expiration-month-src').val());
                $('#expiration-year').val($('#expiration-year-src').val());
                $('#cv-code').val($('#cv-code-src').val());

                if ($('#sms-fee').is(':checked')) {
                    $('#sms').val($('#sms-fee').val());
                } else {
                    $('#sms').val(0);
                }

                if ($('#cancellation-fee').is(':checked')) {
                    $('#cancellation').val($('#cancellation-fee').val());
                } else {
                    $('#cancellation').val(0);
                }

                var orderForm = $('#order-form').serialize();
                var move = false;

                $.ajax({
                    url: '/stripe/payment',
                    type: 'post',
                    data: orderForm,
                    dataType: 'json',
                    async: false,
                    cache: false,
                    beforeSend: function () {
                        $('#payment_wizard-p-0').show();
                        $('#payment_wizard-p-1').hide();
                        $('#payment_wizard-p-2').hide();
                        $('#payment_choice').find('#stripe-payment-loader').removeClass('d-none');
                        $('#payment_choice').find('#stripe-container').addClass('d-none');
                    },
                    success: function (response) {
                        $('#payment_choice').find('#stripe-payment-loader').addClass('d-none');
                        $('#payment_choice').find('#stripe-container').removeClass('d-none');

                        $('#payment_wizard-p-0').hide();
                        $('#payment_wizard-p-2').hide();
                        $('#payment_wizard-p-1').show();

                        if (response.success) {
                            $('#bid').val(response.data);
                            move = true;
                        } else {
                            alert(response.message);
                            $('#payment_wizard-p-0').show();
                            $('#payment_wizard-p-1').hide();
                            $('#payment_wizard-p-2').hide();
                        }
                    },
                    error: function(jqXHR, error, errorThrown) {
                        if (jqXHR.status&&jqXHR.status == 400) {
                            alert(jqXHR.responseText);
                        } else {
                            alert("Something went wrong");
                        }
                    }
                });

                return move;
            }

            if (currentIndex == 1 && newIndex == 2 && $('#bid').val()) {
                var bid = $('#bid').val();
                $('#drop_off_at').val($('#drop-off-date-src').val() + ' ' + $('#drop-off-time-src').val());
                $('#return_at').val($('#return-at-date-src').val() + ' ' + $('#return-at-time-src').val());
                $('#flight_no_going').val($('#departure-src').val());
                $('#flight_no_return').val($('#arrival-src').val());
                $('#no_of_passengers_in_vehicle').val($('#no-of-passengers-in-vehicle-src').val());

                var with_oversize_baggage = $('#with-oversize-baggage').is(':checked') ? 1 : 0;
                var with_children_pwd = $('#with-children-pwd').is(':checked') ? 1 : 0;

                $('#with_oversize_baggage').val(with_oversize_baggage);
                $('#with_children_pwd').val(with_children_pwd);

                setTimeout(function () {
                    $('#payment_wizard-p-2').show();
                    $('#payment_wizard-p-2').css('left', '0px');
                }, 500);

                var move = false;

                $.ajax({
                    url: '/booking/details/'+ bid +'/update',
                    type: 'post',
                    data: $('#booking-details-form').serialize(),
                    dataType: 'json',
                    async: false,
                    cache: false,
                    success: function (response) {
                        if (response.success) {
                            $('#finish-wrapper').removeClass('d-none');
                            $('#booking-id-wrapper').html("<strong>"+ response.data.id +"</strong>");
                            $('#customer-name').html(response.data.name);
                            $('#order-title').html(response.data.order);
                            $('#drop-off').html(response.data.drop_off);
                            $('#return-at').html(response.data.return_at);
                            move = true;
                        } else {
                            $('#payment_wizard-p-1').show();
                            $('#payment_wizard-p-2').hide();
                            $('#confirmation-wrapper').addClass('d-none');
                            alert(response.message);
                        }
                    }
                });

                return move;
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
            $('body').find('a[href="#previous"]').off('click');
            $('body').find('a[href="#previous"]').parent().addClass('disabled');

            $('#finish-wrapper').removeClass('d-none');
            $('#confirmation-wrapper').remove();

            $.ajax({
                url: '/booking/destroy',
                data: {
                    bid: $('#bid').val(),
                    send_sms: $('#sms-confirmation').val() == "1"
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        window.location = '/';
                    } else {
                        alert(response.message);
                    }
                }
            });
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
                        regexp: /^[a-zA-Z0-9\- ]+$/,
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
                        regexp: /^[a-zA-Z0-9\- ]+$/,
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
            // card_number: {
            //     validators: {
            //         creditCard: {
            //             message: 'The credit card number is not valid'
            //         }
            //     }
            // },
            // cv_code: {
            //     validators: {
            //         cvv: {
            //             creditCardField: 'card_number',
            //             message: 'The CVV number is not valid'
            //         }
            //     }
            // },
            // expiration_month : {
            //     validators: {
            //         numeric: {
            //             message: 'The value is not a value'
            //         }
            //     }
            // },
            // expiration_year : {
            //     validators: {
            //         numeric: {
            //             message: 'The value is not a value'
            //         }
            //     }
            // },
            drop_off_date: {
                validators: {
                    notEmpty: {
                        message: 'The drop off date is a required field'
                    },
                    date: {
                        format: 'DD/MM/YYYY',
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
                        format: 'DD/MM/YYYY',
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
        enableFinishButton: true,
        enablePagination: false,
        enableAllSteps: true,
        titleTemplate: "#title#",
        cssClass: "tabcontrol"
    });

    $.fn.steps.setStep = function (step) {
        var currentIndex = $(this).steps('getCurrentIndex');
        console.log($(this));
        console.log('step: ' + step);
        console.log('current index: ' + currentIndex);
        for(var i = 0; i < Math.abs(step - currentIndex); i++){
            if(step > currentIndex) {
                $(this).steps('next');
            }
            else{
                $(this).steps('previous');
            }
        }
    };

    $(document).on('click', '#sms-fee', function () {
        var total = $('#total').text().substr(1);
        if ($(this).is(':checked')) {
            total = parseFloat(total) + parseFloat($(this).val());
            $('#sms-confirmation-container').removeClass('d-none');
            $('#sms-fee-wrapper').text($(this).val());
            $('#sms-confirmation').val(1);
        } else {
            if ($('#total').data('value') < total) {
                total = parseFloat(total) - parseFloat($(this).val());
            }

            $('#sms-fee-wrapper').text(0);
            $('#sms-confirmation-container').addClass('d-none');
            $('#sms-confirmation').val(0);
        }

        $('#total').text('£'+total.toLocaleString());
        $('#total-amount').val(total.toLocaleString());
    });

    $(document).on('click', '#cancellation-fee', function () {
        var total = $('#total').text().substr(1);
        if ($(this).is(':checked')) {
            total = parseFloat(total) + parseFloat($(this).val());
            $('#cancellation-waiver-container').removeClass('d-none');
            $('#cancellation-waiver-wrapper').text($(this).val());
            $('#cancellation').text($(this).val());
        } else {
            if ($('#total').data('value') < total) {
                total = parseFloat(total) - parseFloat($(this).val());
            }

            $('#cancellation').text(0);
            $('#cancellation-waiver-wrapper').text(0);
            $('#cancellation-waiver-container').addClass('d-none');
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
        $('#car-registration-no').val($('#car-registration-no-src').val());
        $('#vehicle-color').val($('#vehicle-color-src').val());
        $('#vehicle-make').val($('#vehicle-make-src').val());
        $('#vehicle-model').val($('#vehicle-model-src').val());
        $('#coupon').val($('#coupon-src').val());

        if ($('#sms-fee').is(':checked')) {
            $('#sms').val($('#sms-fee').val());
        } else {
            $('#sms').val(0);
        }

        if ($('#cancellation-fee').is(':checked')) {
            $('#cancellation').val($('#cancellation-fee').val());
        } else {
            $('#cancellation').val(0);
        }

        var fv = $('#payment_wizard').data('formValidation'),

            // The current step container
            $container = $('#payment_wizard').find('section[data-step="0"]');

        // Validate the container
        fv.validateContainer($container);

        var isValidStep = fv.isValidContainer($container);

        if (isValidStep === false || isValidStep === null) {
            // Do not jump to the next step
            return false;
        } else {
            $('#order-form').submit();
        }

    });

    $(document).on('blur', '#coupon-src', function (e) {
        var el = $(this);
        $.ajax({
            url: '/get/coupon',
            type: 'post',
            data: { _token: $('input[name="_token"]').val(), total: $('#total').data('value'), coupon: el.val() },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('#coupon-container').removeClass('d-none');
                    $('#coupon-wrapper').html(response.data.discount_value);
                    $('#coupon-discount').html(response.data.percent);
                    $('#total').text('£' + response.data.total);
                } else {
                    if ($('#coupon-src').val() == "") {
                        $('#total').text('£' + $('#total').data('value'));
                        $('#coupon-container').addClass('d-none');
                    } else {
                        $('#coupon-error').removeClass('d-none');
                    }
                }
            }
        });
    });

    $(document).on('change', '#vehicle-make-src', function () {
        var index = $("#vehicle-make-src option:selected").data('index');
        var make = $(this).val();

        $.ajax({
            url: '/get/vehicle/model',
            data: { make: make, index: index },
            dataType: 'json',
            success: function (response) {
                $('#vehicle-model-src')
                    .empty()
                    .append(response.options);
            }
        });
    });

    $(document).on('change', '#vehicle-make-src', function () {
        $('#vehicle-model-src').removeClass('d-none');
        $('#other-vehicle-model-src').val('');
        $('#other-vehicle-model-src').addClass('d-none');
    });

    $(document).on('change', '#vehicle-model-src', function () {
        var txt = $("#vehicle-model-src option:selected").text();
        if (txt.indexOf('Other') != -1) {
            $(this).addClass('d-none');
            $('#other-vehicle-model-src').removeClass('d-none');
            $('#other-vehicle-model-src').focus();
        } else {
            $(this).removeClass('d-none');
            $('#other-vehicle-model-src').addClass('d-none');
        }
    });

    if ($('#sms-fee').is(':checked')) {
        var total = $('#total').text().substr(1);
        total = parseFloat(total) + parseFloat($('#sms-fee').val());
        $('#total').text('£'+total.toLocaleString());
        $('#total-amount').val(total.toLocaleString());
        $('#sms-fee-wrapper').text($('#sms-fee').val());
        $('#sms-confirmation').val(1);
        $('#sms').val($('#sms-fee').val());
    } else {
        $('#sms-confirmation').val(0);
        $('#sms').val(0);
    }

    if ($('#cancellation-fee').is(':checked')) {
        var total = $('#total').text().substr(1);
        total = parseFloat(total) + parseFloat($('#cancellation').val());
        $('#total').text('£'+total.toLocaleString());
        $('#total-amount').val(total.toLocaleString());
        $('#cancellation').val($('#cancellation-fee').val());
    } else {
        $('#cancellation').val(0);
    }

    setTimeout(function() {
        document.documentElement.scrollTop =
            document.body.scrollTop = 0;
    }, 0);

    $(window).scroll(function() {
        if($(this).scrollTop() > 20) {
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
