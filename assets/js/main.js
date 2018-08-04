
jQuery(function($) { 
  $('.grid').css({background: 'white'});
  var leftRail = $('.left-rail');
  var leftRailContents = $('#left-rail-contents');
  var imageGrid = $('#image-grid');
  var toggleMenu = $('#menu-toggle .fa.fa-navicon');
  /* $('#menu-toggle').toggle(function(){
    leftRail.animate({width: '20%'},600);
    leftRail.css({background: 'white'});
    leftRailContents.css({display:'block'});
  }, function(){
     leftRail.animate({width:'150px'}, 600);
     leftRailContents.delay(500).queue(function(next){ $(this).css({display:'none'}); leftRail.css({background: 'transparent'}); next();});
  }); */


  $( '.th-swipe' ).swipebox({loopAtEnd:true, hideBarsDelay:0});


   $('.grid').show();
   var $grid = $('.th-grid').masonry({
    itemSelector: '.grid-item'
  });
  $grid.imagesLoaded(function(){
    $grid.masonry();
  })



 var carousel = document.getElementById('thCarousel');

 if(!!carousel){
  var isSliding = false;
  
  $('.carousel').carousel({
    interval: 0
  });

  $('#thCarousel').on('slide.bs.carousel', function () {
    isSliding = true;
  })

  $('#thCarousel').on('slid.bs.carousel', function () {
    isSliding = false;
  })

  $('#thCarousel').bind('mousewheel', function(e){
    if(!isSliding){
      if(e.originalEvent.wheelDelta /120 > 0) {
        $(this).carousel('prev');
      }
      else{
          $(this).carousel('next');
      }
    }
  });

 }

});
