jQuery(function($){
    var previousPost = $('.previous a');
    var previousScroll = $('.previous-scroll a')
    var textAnimationCount = 0;
	$(window).scroll(function(){
        var leftRail = $('#left-rail');
		if  (leftRail.length && $(window).scrollTop() + window.innerHeight == $(document).height()){
            //window.location.href = previousPost[0].href;
        }
        if  (leftRail.length && textAnimationCount == 0 && $(document).height() - ($(window).scrollTop() + window.innerHeight) < 150){
            console.log(previousPost);
            previousScroll.animate({ fontSize : '1.9rem'},400);
            previousScroll.animate({ lineHeight : '1.9rem'},400);
            textAnimationCount = 1;
        }else if(textAnimationCount === 1 && $(document).height() - ($(window).scrollTop() + window.innerHeight) >= 150){
            previousScroll.animate({ fontSize : '1.2rem'},400);
            previousScroll.animate({ lineHeight : '1.2rem'},400);
            textAnimationCount = 0;
        }
    }); 
});