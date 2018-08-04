<?php

function spa_setup(){
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
	add_theme_support( 'woocommerce' );
	register_nav_menu( 'primary', __( 'Primary Menu', 'thomashooper' ) );
}