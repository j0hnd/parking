$(document).ready(function() {
  setTimeout(function() {
    document.documentElement.scrollTop =
        document.body.scrollTop = 500;
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
      $(document).ready(function(){
     $('.contact').addClass('active');
     $('.terms').addClass('active-term');
     $('.privacy').addClass('active-privacy');
    });