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
        autoFocus: true
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
    });

    if ($('#sms-fee').is(':checked')) {
        var total = $('#total').text().substr(1);
        total = parseFloat(total) + parseFloat($('#sms-fee').val());
        $('#total').text('£'+total.toLocaleString());
    }

    if ($('#cancellation').is(':checked')) {
        var total = $('#total').text().substr(1);
        total = parseFloat(total) + parseFloat($('#cancellation').val());
        $('#total').text('£'+total.toLocaleString());
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