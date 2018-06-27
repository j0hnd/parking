jQuery(document).ready(function($) {
    function scrollToSection(event) {
        event.preventDefault();
        var $section = $($(this).attr('href'));
        $('html, body').animate({
            scrollTop: $section.offset().top
        }, 500);
    }

    $('[data-scroll]').on('click', scrollToSection);
    $('.datepicker').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy',
        todayHighlight: true
    }).on('changeDate', function (e) {
        console.log(e.target.id);
        if (e.target.id == 'drop-off-date') {
            var selected_date = $(this).val().split('/');
            var date = new Date(selected_date[2], selected_date[1], selected_date[0]);
            date.setDate(date.getDate() + 7);

            var return_at = date.getDate() + "/"  + date.getMonth() + "/" + date.getFullYear();
            $('#return-at-date').datepicker('update', return_at);
        }
    });
}(jQuery));

// Get titles from the DOM
var titleMain  = $("#animatedHeading");
var titleMain2  = $("#animatedHeading2");
var titleMain3  = $("#animatedHeading3");
var titleSubs  = titleMain.find("slick-active");

if (titleMain.length || titleMain2.length || titleMain3.length ) {
    titleMain.slick({
        autoplay: false,
        arrows: false,
        dots: false,
        slidesToShow: 3,
        centerPadding: "10px",
        draggable: false,
        infinite: true,
        pauseOnHover: false,
        swipe: false,
        touchMove: false,
        vertical: true,
        speed: 2000,
        autoplaySpeed: 2000,
        useTransform: true,
        cssEase: 'cubic-bezier(0.645, 0.045, 0.355, 1.000)',
        adaptiveHeight: true,
        responsive: [{
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
                infinite: true
            }
        },
        {
            breakpoint: 770,
            settings: {
                slidesToShow: 2,
                infinite: true
            }
        },
         {
            breakpoint: 600,
            settings: {
                slidesToShow: 1,
                infinite: true
            }
        }, {
            breakpoint: 300,
            settings: "unslick" // destroys slick
        }]
    });

    titleMain2.slick({
        autoplay: false,
        arrows: false,
        dots: false,
        slidesToShow: 3,
        centerPadding: "10px",
        draggable: false,
        infinite: true,
        pauseOnHover: false,
        swipe: false,
        touchMove: false,
        vertical: true,
        speed: 2000,
        autoplaySpeed: 2000,
        useTransform: true,
        cssEase: 'cubic-bezier(0.645, 0.045, 0.355, 1.000)',
        adaptiveHeight: true,
        responsive: [{
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
                infinite: true
            }
        },
        {
            breakpoint: 770,
            settings: {
                slidesToShow: 2,
                infinite: true
            }
        },
         {
            breakpoint: 600,
            settings: {
                slidesToShow: 1,
                infinite: true
            }
        }, {
            breakpoint: 300,
            settings: "unslick" // destroys slick
        }]
    });

    titleMain3.slick({
        autoplay: false,
        arrows: false,
        dots: false,
        slidesToShow: 3,
        centerPadding: "10px",
        draggable: false,
        infinite: true,
        pauseOnHover: false,
        swipe: false,
        touchMove: false,
        vertical: true,
        speed: 2000,
        autoplaySpeed: 2000,
        useTransform: true,
        cssEase: 'cubic-bezier(0.645, 0.045, 0.355, 1.000)',
        adaptiveHeight: true,
        responsive: [{
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
                infinite: true
            }
        }, 
            {
            breakpoint: 770,
            settings: {
                slidesToShow: 2,
                infinite: true
            }
        },
        {
            breakpoint: 600,
            settings: {
                slidesToShow: 1,
                infinite: true
            }
        }, {
            breakpoint: 300,
            settings: "unslick" // destroys slick
        }]
    });

    // Manually refresh positioning of slick
    titleMain.slick('slickPlay');
    titleMain2.slick('slickPlay');
    titleMain3.slick('slickPlay');
};

$(document).ready(function() {
setTimeout(function() {
    document.documentElement.scrollTop =
        document.body.scrollTop = 0;
}, 0);
    $(window).scroll(function() {
        if($(this).scrollTop() > 20) {
            $('.navbar').addClass('solid');
            $('nav').removeClass('bg-dark');
            $('.Vl').removeClass('vl');
        } else {
            $('.navbar').removeClass('solid');
            $('nav').addClass('bg-dark');
            $('.Vl').addClass('vl');
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