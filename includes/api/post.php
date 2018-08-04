<?php

function th_get_additional_post_data( $arr, $field_name, $request ){
	$user_id                        =   absint($arr['author']);
	$array_data                     =   [];


	// Author Data
	$array_data['user_nicename']    =   get_the_author_meta( 'user_nicename', $user_id );

	// Featured Image
	$array_data['thumbnail']        =   get_the_post_thumbnail_url( $arr['id'], 'full' );

	$array_data['post_id']			= 	$arr['id'];
	
	return $array_data;
}

function ws_get_images_urls( $arr, $field_name, $request ) {
	$first_img = '';
	ob_start();
	ob_end_clean();
	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $arr['content']['rendered'], $matches);
	//$first_img = $matches [1] [0];
  
	if(isset($matches[1][0])){
		$first_img = $matches [1] [0];
	}
	//Defines a default image
	if(empty($first_img)){ 
	  $first_img = "/images/default.jpg";
	}
	return $first_img;
}

function th_post_contact_form(WP_REST_Request $request){

	$param = $request['userEmail'];


	return $param;
}

