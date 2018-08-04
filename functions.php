<?php

// Setup
define( 'SPA_PLUGIN_URL', __FILE__ );

// Includes
include( get_template_directory() . '/includes/setup.php' );
include( get_template_directory() . '/includes/front/enqueue.php' );
include( get_template_directory() . '/includes/customizer.php' );
include( get_template_directory() . '/includes/api/api.php' );
include( get_template_directory() . '/includes/api/post.php' );
include( get_template_directory() . '/includes/api/menus.php' );

// Hooks
add_action( 'wp_enqueue_scripts', 'spa_enqueue_scripts' );
add_action( 'after_setup_theme', 'spa_setup' );
add_action( 'customize_register', 'spa_customizer_register' );
add_action( 'rest_api_init', 'spa_rest_api_init' );
add_action('init', function () {
    add_rewrite_rule('^/(.+)/?', "index.php?post_type=page&p='" .get_option( 'page_on_front' ) ."'", 'top');
});
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
// Shortcodes

function remove_img_attr ($html)
{
    return preg_replace('/(width|height)="\d+"\s/', "", $html);
}
add_filter( 'post_thumbnail_html', 'remove_img_attr' );


function get_first_image_id($post_id){
    $temp = get_attached_media( '', $post_id );

    return $temp; //reset($temp);
}

function th_get_fist_by_id($post_id){
    do_action( 'get_first_image_id('. $post_id .')');
}

add_filter( 'query_vars', function( $query_vars ) {
    $query_vars[] = 'post_parent';
    return $query_vars;
});


add_filter('post_gallery','customFormatGallery',10,4);

function customFormatGallery($string,$attr){

    $posts = get_posts(array('include' => $attr['ids'],'post_type' => 'attachment'));

    isset($attr['columns']) ? $columns = $attr['columns'] : $columns = 4;
    isset($attr['grid']) ? $isGrid = $attr['grid'] : $isGrid = false;
        $output = "<div class=\"th-grid\">";
        foreach($posts as $imagePost){
            $output .= "<div class=\"grid-item \">";
            $output .= "<a class=\"th-swipe grid-item-inner\" href='".wp_get_attachment_image_src($imagePost->ID, 'large')[0]."'>";
            $output .= "<img src='".wp_get_attachment_image_src($imagePost->ID, 'large')[0]."'/>";
            $output .= "</a>";
            $output .= "</div>";

       /* $colwidth = 100 / $columns;
        $colwidth .= "%";
        $galleryIndex = 0;
        $imagesPerColumn = ceil(count($posts) / $columns);

        // total number of ids in the gallery / number of columns = number of times to loop in a column. break when we hit the number of columns but keep track of index seperatly

        for($i = 0; $i < $columns; $i++){
            $output .= "<div class=\"column\" style=\"flex: 0 0 $colwidth;max-width:$colwidth;\">";
            for($galleryIndex; $galleryIndex < count($posts) ;) {
                $output .= "<a class=\"th-swipe\" href='".wp_get_attachment_image_src($posts[$galleryIndex]->ID, 'large')[0]."'>";
                $output .= "<img src='".wp_get_attachment_image_src($posts[$galleryIndex]->ID, 'large')[0]."' style=\"width:100%\" />";
                $output .= "</a>";
                ++$galleryIndex;
                if($galleryIndex % $imagesPerColumn == 0) break;
                
            }
            $output .= "</div>";
        } */
       
    } 
    $output .= "</div>";
    return $output;
}


function th_click_video($attr){

    $posts = get_posts(array('include' => $attr['ids'],'post_type' => 'attachment'));
    isset($attr['title']) ? $title = $attr['title'] : $title = "";

    return  '<section class="section section--code" style="position:relative">
            <h1 id="large-video-text">'. $title .'</h1>
            <video class="th-intro-background" id="books-video" loop  preload="auto"><source type="video/mp4" data-src="'. wp_get_attachment_url($posts[0]->ID) .'" src="'. wp_get_attachment_url($posts[0]->ID) .'" > </video>
        </section>';
}

function th_main_header($attr){
    
    isset($attr['title']) ? $title = $attr['title'] : $title = "";
    isset($attr['subtitle']) ? $subtitle = $attr['subtitle'] : $subtitle = "";
    return '<header class="hero">
                    <div class="hero-center">
                        <h1 class="hero__logo aos-init aos-animate" data-aos="zoom-in">'. $title .'</h1>
                    <h2 class="hero__text aos-init aos-animate" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="400">'. $subtitle .'</span></h2>
                </div>
                <span class="hero__scroll aos-init aos-animate" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="800">
                    <span class="chevron bottom"></span>  
                </span>
            </header>';
}

function th_main_section($attr){
    $posts = get_posts(array('include' => $attr['ids'],'post_type' => 'attachment'));
    isset($attr['title']) ? $title = $attr['title'] : $title = "";
    isset($attr['size']) ? $size = $attr['size'] : $size = "medium";
    isset($attr['bg']) ? $bg = wp_get_attachment_url($attr['bg']) : $bg = "";

    $sizestr = "aos-init aos-animate code code--";
    $sizestr .= $size;
    $style = 'background: linear-gradient(rgba(0, 0, 0, 0.45), rgba(0, 0, 0, 0.45)), url('.$bg.') no-repeat center center fixed;background-size:cover'; 
    $output = '<section class="section section--code">
                <div class="section-title-bg">
                    <div class="section-title container" style="'.$style.'">
                        <a class="section-title-link" href="/'.$title.'/"><h2 class="section-title">'. $title .'</h2></a>
                    </div>
                </div>
                <div class="container">';
                    $count = 0;
                    foreach($posts as $imagePost){
                        $count % 2 == 0 ? $side = "code--left" : $side = "code--right";
                        $count % 2 == 0 ? $fade = "fade-right" : $fade = "fade-left";
                        $output .=  '<div class="'. $sizestr .' '. $side  .'" data-aos="'.$fade.'">
                                        <img src="'.wp_get_attachment_image_src($imagePost->ID, 'large')[0].'" class="img-fluid" alt="Thomas Hooper Tattoos">
                                    </div>';
                        ++$count;
                    }
                      
                $output .= '<div class="code code--medium code--left aos-init" data-aos="fade-up" style="background:transparent"></div>
                        </div>
                    </section>';

    return $output;
}

function th_background_video($attr){

    $bg = wp_get_attachment_url($attr['ids']);

    return '<div class="backgrounds overlay">
                <div class="background aos-init aos-animate" data-aos="fade-in" data-aos-duration="1500" data-aos-anchor=".section--hero">
                    <video class="th-intro-background" loop autoplay preload="auto" muted><source type="video/mp4" data-src="' .$bg.'" src="'. $bg .'" > </video>
                </div>
            </div>';
};


function re_carousel($attr){
    $posts = get_posts(array('include' => $attr['ids'],'post_type' => 'attachment'));
        $output = "<div id=\"relicCarousel\" class=\"carousel slide\" data-ride=\"carousel\"> <div class=\"carousel-inner \">";
        $output .= " <ol class=\"carousel-indicators\">";
        $count = 0;
        foreach($posts as $imagePost){
            if($count == 0){
                $output .=  "<li data-target=\"#relicCarousel\" data-slide-to='" .$count. "' class=\"active\"></li>";
            } else{
                $output .=  "<li data-target=\"#relicCarousel\" data-slide-to='" .$count. "' ></li>";
            }
            ++$count;
        }
        $output .= "</ol>";
        $loop = 0;
        foreach($posts as $imagePost){
            if($loop == 0){
                $output .= "<div class=\"carousel-item active\">";
            } else {
                $output .= " <div class=\"carousel-item\">";
            }
            $output .= "<img class=\"d-block w-100\" src='".wp_get_attachment_image_src($imagePost->ID, 'large')[0]."'/>";
            $output .= "</div>";
            ++$loop;
        }

        $output .= "</div>";

      /*  $output .= " <a class=\"carousel-control-prev\" href=\"#relicCarousel\" role=\"button\" data-slide=\"prev\">";
        $output .= "<span class=\"carousel-control-prev-icon\" aria-hidden=\"true\"></span>";
        $output .= "<span class=\"sr-only\">Previous</span>";
        $output .= "</a>";
        $output .= " <a class=\"carousel-control-next\" href=\"#relicCarousel\" role=\"button\" data-slide=\"next\">";
        $output .= "<span class=\"carousel-control-next-icon\" aria-hidden=\"true\"></span>";
        $output .= "<span class=\"sr-only\">Next</span>";
        $output .= "</a>";
        $output .= "</div>"; */

        $output .= "<div id=\"swipebox-bottom-bar\" class=\"visible-bars\" href=\"#relicCarousel\">";
        $output .= "<div id=\"swipebox-arrows\">";
        $output .= "<a class=\"carousel-control-prev\" href=\"#relicCarousel\" role=\"button\" data-slide=\"prev\">";
        $output .= "<span class=\"carousel-control-prev-icon\" aria-hidden=\"true\"></span><span class=\"sr-only\">Previous</span></a>";
        $output .= " <a class=\"carousel-control-next\" href=\"#relicCarousel\" role=\"button\" data-slide=\"next\">";
        $output .= " <span class=\"carousel-control-next-icon\" aria-hidden=\"true\"></span><span class=\"sr-only\">Next</span></a>";
        $output .= "</div></div>";
        $output .= "</div>";

        return $output;
}

function re_team($attr) {
    $posts = get_posts(array('include' => $attr['ids'],'post_type' => 'attachment'));
    isset($attr['name']) ? $name = $attr['name'] : $name = '';
    isset($attr['born']) ? $born = $attr['born'] : $born = '';
    isset($attr['born']) ? $born = $attr['born'] : $born = '';
    isset($attr['birth']) ? $dob = $attr['birth'] : $dob = '';
    isset($attr['sponsors']) ? $sponsors = $attr['sponsors'] : $sponsors = '';
    isset($attr['interests']) ? $interests = $attr['interests'] : $interests = '';
    isset($attr['terrain']) ? $terrain = $attr['terrain'] : $terrain = '';
    isset($attr['motivation']) ? $motivation = $attr['motivation'] : $motivation = '';
    isset($attr['grid']) ? $isGrid = $attr['grid'] : $isGrid = false;
    $panelId = "panel_";
    $firstName = explode(' ', trim($name));
    $panelId .= $firstName[0];
    $openId = $panelId;
       // $output = "<div class=\"th-grid\">";
      //  foreach($posts as $imagePost){
           $output = "";
            $output .= "<div class=\"grid-item \">";
            $output .= "<a class=\"grid-item-inner panel-item\" id=".$panelId." >";
            $output .= "<img src='".wp_get_attachment_image_src($posts[0]->ID, 'large')[0]."'/>";
            $output .= "</a>";
            $output .= "<h2 class=\"text-right\">" .$name. "</h2>";
            $output .= "</div>";
       
   // } 

  //  $output .= "</div>";
    $output .= "<div class=\"panel__container ".$openId."\"> <div class=\"panel\"> <div class=\"panel__inner\">";
    $output .= "<div class=\"panel__header\"> <h2 class=\"panel__title\">" .$name . "</h2> <button class=\"panel__button\"> Close </button> </div>";
    $output .= "<div class=\"imageCover\"><img src='".wp_get_attachment_image_src($posts[0]->ID, 'large')[0]."'/>";
    $output .= "</div>";
    $output .= "<div class=\"team__text\">";
    $output .= "<p><strong>Born:</strong> " . $born . "</p>";
    $output .= "<p><strong>Date of birth:</strong> " . $dob . "</p>";
    $output .= "<p><strong>Sponsors:</strong> " . $sponsors . "</p>";
    $output .= "<p><strong>Interests outside of BMX:</strong> " . $interests . "</p>";
    $output .= "<p><strong>Favorite terrain:</strong> " . $terrain . "</p>";
    $output .= "<p><strong>Motivation:</strong> " . $motivation . "</p>";
    $output .= "</div></div></div></div>";
    return $output;
}


add_shortcode( 'thvideo', 'th_background_video' );
add_shortcode( 'recarousel', 're_carousel' );
add_shortcode( 'thclicktoplay', 'th_click_video' );
add_shortcode( 'thheader', 'th_main_header' );
add_shortcode( 'thsection', 'th_main_section' );
add_shortcode( 'threcentposts', 'th_main_recent_posts' );
add_shortcode( 'reteam', 're_team');