<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery.min.js" type="text/javascript"></script>
<script src="{{ asset('/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src='{{ asset('/js/slick.min.js') }}' type="text/javascript"></script>
<script type="text/javascript">
    // var today = new Date();
    // var dd = today.getDate();
    // var mm = today.getMonth()+1; //January is 0!
    // var yyyy = today.getFullYear();
    //
    // if(dd<10){
    //     dd='0'+dd
    // }
    //
    // if(mm<10){
    //     mm='0'+mm
    // }
    //
    // today = yyyy+'-'+mm+'-'+dd;
    // document.getElementById("datefield").setAttribute("min", today);

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
            format: 'mm/dd/yyyy',
            todayHighlight: true
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
            }, {
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
            }, {
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
            }, {
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
    }
</script>
