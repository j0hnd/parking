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
});