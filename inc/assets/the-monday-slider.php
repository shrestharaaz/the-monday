<?php
/**
 * Template for header slider
 *
 * @package The Monday
 */

if ( ! function_exists( 'the_monday_slider_template' ) ) :
function the_monday_slider_template() {
    $home_header_type = get_theme_mod( 'front_header_type', 'image' );
    
	if ( $home_header_type == 'slider' && is_front_page() ) {

    //Get the slider options
    $image_speed      = get_theme_mod( 'slider_speed', '4000' );
    $text_speed = get_theme_mod( 'textslider_speed', '4000' );
    $text_slide = get_theme_mod( 'textslider_slide', 0 ) ;
    if ( !$text_slide ) {
        $slide_toggle = true;
    } else {
        $slide_toggle = false;
    }
    $slider_category = get_theme_mod( 'slider_category' );
    if( !empty( $slider_category ) ) {
	?>

	<div id="slideshow" class="header-slider" data-speed="<?php echo esc_attr( $image_speed ); ?>">
	    <div class="slides-container">
		    <?php 
                $sticky_post = get_option( 'sticky_posts' );
                $slider_args = array(
                                  'cat'                 => $slider_category,
                            	  'ignore_sticky_posts' => 1,
                            	  'post__not_in'        => $sticky_post,
                                  'post_status' => 'publish',
                                  'posts_per_page' => -1,
                                  'order'=> 'DESC'  
                                    );
                $slider_image_query = new WP_Query( $slider_args );
                if( $slider_image_query->have_posts() ){
                    while( $slider_image_query->have_posts() ){
                        $slider_image_query->the_post();
                        if( has_post_thumbnail() ) {
                            $slider_image_id = get_post_thumbnail_id();
                            $slider_image = wp_get_attachment_image_src( $slider_image_id, 'full', true );
            ?>
                    <div class="slide-item" style="background-image:url(<?php echo $slider_image[0]; ?>);"><div class="slider-overlay"></div></div>
            <?php
                        }
                    }
                }
                wp_reset_query();
			?>
	    </div>

        <div class="text-slider-section">
            <div class="text-slider" data-speed="<?php echo esc_attr($text_speed); ?>" data-slideshow="<?php echo esc_attr($slide_toggle); ?>">
                <ul class="slide-text slides">
                	<?php 
                        $slider_title_query = new WP_Query( $slider_args );
                        if( $slider_title_query->have_posts() ){
                            while( $slider_title_query->have_posts() ){
                                $slider_title_query->the_post();
                                if( has_post_thumbnail() ) {
                    ?>
                    <li>
                        <div class="contain">
                            <h2 class="maintitle"><?php the_title(); ?></h2>
                        </div>
                        <?php $slider_button = get_theme_mod( 'slider_button_text', "Let's Go" ); ?>
                        <?php if ( !empty( $slider_button ) ) : ?>
                            <span class="static-button button-header-slider"><a href="<?php the_permalink() ; ?>"><?php echo esc_html( $slider_button ); ?></a></span>
                        <?php endif; ?>
                    </li>
               		<?php
                                }
                            }
                        }
                        wp_reset_query();
                    ?>
                </ul>
            </div>
        </div>
        
	</div>
	<?php
    }
	}
    elseif ( get_theme_mod( 'front_header_type', 'image' ) == 'image' && is_front_page() ) {
        $default_front_header_image = THE_MONDAY_IMAGES_URL . '/front-header.jpg';
        $front_header_image_url = get_theme_mod( 'front_header_image', $default_front_header_image );
 ?>
    <div class="header-image-wrapper">
 <?php
        if( !empty( $front_header_image_url ) ) {
           $fh_output = '';
           $fh_output .= '<div class="front-header-image">';
           $fh_output .= '<img src="'. esc_url( $front_header_image_url ) .'" />';
           $fh_output .='<div class="overlay"></div></div>';
           echo $fh_output ;
    	   $front_header_bg_size = get_theme_mod( 'front_header_bg_size', 'cover' );    
           $front_header_height = get_theme_mod( 'front_header_height', '1000' );
 ?>
    <style>
        .front-header-image {
            position: relative;
            background-size: <?php echo esc_attr( $front_header_bg_size );?>;
        }
    </style>
 <?php
        }
    
 ?>
        <div class="banner-nav banner-left-section">                    
            <div class="table-outer">
                <div class="table-inner"> 
                    <nav id="site-navigation" class="main-navigation"> 
                        <?php 
                            if( get_theme_mod( 'single_page_menu_option', '' ) != 1 ) {
                                do_action( 'single_page_menu' ); 
                            } else {
                                wp_nav_menu(array('theme_location' => 'primary', 'fallback_cb' => 't_menu_fallback'));
                            } 
                        ?>
                    </nav>
                </div>
            </div>
        </div>
        <?php if( $home_header_type == 'image') { ?>
        <div class="banner-info banner-right-section">                
            <div class="table-outer">
                <div class="table-inner"> 
                    <?php if (get_header_image()) : ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" title="<?php bloginfo('name'); ?>">
                            <img class="site-logo" src="<?php header_image(); ?>" width="<?php echo esc_attr(get_custom_header()->width); ?>" height="<?php echo esc_attr(get_custom_header()->height); ?>" alt="<?php bloginfo('name'); ?>">
                        </a>
                    <?php else : ?>
                        <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
                        <h2 class="site-description"><?php bloginfo('description'); ?></h2>	        
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php } } ?>
    </div>
 <?php      
}
endif;

if( !function_exists( 'the_monday_innerpage_head_section' ) ):
    function the_monday_innerpage_head_section() {
        $default_inner_header_image = THE_MONDAY_IMAGES_URL . '/inner-header.jpg';
        $inner_header_image_url = get_theme_mod( 'inner_header_image', $default_inner_header_image );
 ?>
    <div class="header-image-wrapper">
 <?php
        if( !empty( $inner_header_image_url ) ) {
            $ih_output = '';
            $ih_output .= '<div class="inner-header-image">';
            $ih_output .= '<img src="'. esc_url( $inner_header_image_url ) .'" />';
            $ih_output .='<div class="overlay"></div></div>';
            echo $ih_output ;
            $inner_header_bg_size = get_theme_mod( 'inner_header_bg_size', 'cover' );    
            $inner_header_height = get_theme_mod( 'inner_header_height', '316' );
 ?>
        <style>
            .inner-header-image {
                position: relative;
                background-size: <?php echo esc_attr( $inner_header_bg_size );?>;
                height: <?php echo intval( $inner_header_height ). 'px'; ?>;
                overflow: hidden;
            }
        </style>
 <?php
        }
 ?>
    </div>
 <?php
    }
endif;
?>