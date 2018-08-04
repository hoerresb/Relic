jQuery(function($) { 


AOS.init({
    easing: 'ease-in-out-sine'
  });

  $('.hero__scroll').on('click', function(e) {
    $('html, body').animate({
      scrollTop: $('.hero').height() 
    }, 1200);
  });


});