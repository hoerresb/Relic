var total = '<?php echo $wp_query->max_num_pages; ?>';
jQuery(function($){
	var count = 2;
	var testResponse = true;
	$(window).scroll(function(){
		if  ($(window).scrollTop() == $(document).height() - $(window).height()){
			if (count > total){
				return false;
			}else{
				loadArticle(count);
			}
			count++;
		}
		function loadArticle(pageNumber){
			$('#spinner').show();
			var ajaxurl = "/thomashooper/wp-admin/admin-ajax.php";  
			var data = {
				'action': 'infinite_scroll',
				'page': pageNumber
				//'security': '<?php echo wp_create_nonce("load_more_posts"); ?>'
			};
	
			if(testResponse){
				$.post(ajaxurl, data, function(response) {
					testResponse = response;
					$('#posts').append(response);
					$('#spinner').hide();
				});
			}else{
				$('#spinner').hide();
			}
		}
		
	});
	
	
});