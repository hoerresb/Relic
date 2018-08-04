<?php

function spa_enqueue_scripts(){
	wp_register_script(
		'spa_bootstrap',
		get_template_directory_uri() . '/assets/js/bootstrap.min.js',
		array(),
		false,
		true
	);

	wp_register_script(
		'spa_moment',
		get_template_directory_uri() . '/assets/js/moment.js',
		array(),
		false,
		true
	);

	wp_register_script(
		'spa_bundle',
		get_template_directory_uri() . '/app/dist/build.js',
		[],
		false,
		true
	);

	wp_localize_script( 'spa_bundle', 'wp_rest_api', [
		'base_url'          =>  rest_url( '/wp/v2/' ),
		'spa_url'           =>  rest_url( '/spa/v1/' ),
		'site_name'         =>  get_bloginfo( 'name' ),
		'footer_text'       =>  get_theme_mod('spa_footer_text' ),
		'nonce'             =>  wp_create_nonce( 'wp_rest' )
	]);


	wp_register_style('th_font_awesome', get_template_directory_uri() .'/assets/css/font-awesome.min.css');
	wp_register_style('th_tether', get_template_directory_uri() . '/assets/css/tether.min.css');
	wp_register_style('th_bootstrap_css', get_template_directory_uri() . '/assets/css/bootstrap.min.css');
	wp_register_style('th_swipebox_css', get_template_directory_uri() . '/assets/css/swipebox.css');
	wp_register_style('th_main', get_template_directory_uri() .'/assets/css/main.css?v=1');
	wp_register_style('th_scroller', get_template_directory_uri() .'/assets/css/aos.css');

	wp_enqueue_style('th_font_awesome');
	wp_enqueue_style('th_bootstrap_css');
	wp_enqueue_style( 'th_swipebox_css');
	wp_enqueue_style('th_main');
	wp_enqueue_style('th_scroller');

	wp_register_script('th_tether_js', get_template_directory_uri() .'/assets/js/tether.min.js', array(), false, true);
	wp_register_script('th_bootstrap_js', get_template_directory_uri() .'/assets/js/bootstrap.min.js', array(), false, true);
	wp_register_script('re_popper_js', get_template_directory_uri() .'/assets/js/popper.min.js', array(), false, true);
	wp_register_script('th_masonry_js', get_template_directory_uri() .'/assets/js/masonry.min.js', array(), false, true);
	wp_register_script('th_imageloader_js', get_template_directory_uri() .'/assets/js/imageloader.js', array(), false, true);
	wp_register_script('th_swipebox_js', get_template_directory_uri() .'/assets/js/swipebox.js', array(), false, true);
	wp_register_script('th_main_js', get_template_directory_uri() .'/assets/js/main.js?v=1', array(), false, true);
	wp_register_script('th_load_previous_js', get_template_directory_uri() .'/assets/js/load-previous.js', array(), false, true);
	wp_register_script('th_scroller_js', get_template_directory_uri() .'/assets/js/aos.js', array(), false, true);
	wp_register_script('th_aos_scroll_js', get_template_directory_uri() .'/assets/js/th_aos_scroll.js', array(), false, true);
	wp_register_script('th_scroll_js', get_template_directory_uri() .'/assets/js/scroll.js', array(), false, true);


	wp_enqueue_script('jquery');
	wp_enqueue_script('re_popper_js');
	wp_enqueue_script('th_tether_js');
	wp_enqueue_script('th_bootstrap_js');
	wp_enqueue_script('th_masonry_js');
	wp_enqueue_script('th_imageloader_js');
	wp_enqueue_script( 'th_swipebox_js');
	wp_enqueue_script('th_main_js');
	wp_enqueue_script( 'th_scroller_js' );
	wp_enqueue_script('th_aos_scroll_js');
	wp_enqueue_script( 'th_scroll_js');
	wp_enqueue_script( 'spa_moment' );
	wp_enqueue_script( 'spa_bundle' );
}