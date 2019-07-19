<?php
/**
 * General Variables available: $name, $params, $args, $content
 * $args has been 'extract'ed
 */

/* Do nothing if we dont have a template to show */
if ( !is_string( $slider_template ) || !file_exists( $slider_template ) )
	return;

/* Prevent errors : do not overwrite existing values */
$defaults = array( 'category' => '', 'count' => '', 'offset' => '', 'caption_bg' => '', 'fullcontent' => '', 'excerptlength' => '', );
extract( $defaults, EXTR_SKIP );

/* Reset any previous slider */
global $hoot_data;
hoot_set_data( 'slider', array(), true );
hoot_set_data( 'slidersettings', array(), true );

/* Create slider settings object */
$slidersettings = array();
$slidersettings['type'] = 'postimage';
$slidersettings['source'] = 'slider-postimage.php';
$slidersettings['widgetclass'] = ( !empty( $style ) ) ? ' slider-' . esc_attr( $style ) : ' slider-style1';
$slidersettings['class'] = 'hootkitslider-postimage';
$slidersettings['adaptiveheight'] = 'true'; // Default Setting else adaptiveheight = false and class .= fixedheight
// https://github.com/sachinchoolur/lightslider/issues/118
// https://github.com/sachinchoolur/lightslider/issues/119#issuecomment-93283923
$slidersettings['slidemove'] = '1';
$pause = empty( $pause ) ? 5 : absint( $pause );
$pause = ( $pause < 1 ) ? 1 : ( ( $pause > 15 ) ? 15 : $pause );
$slidersettings['pause'] = $pause * 1000;

// Create a custom WP Query
$query_args = array();
$count = intval( $count );
$query_args['posts_per_page'] = ( empty( $count ) || $count > 4 ) ? 4 : $count;
$offset = intval( $offset );
if ( $offset )
	$query_args['offset'] = $offset;
if ( !empty( $category ) ) // undefined if none selected in multiselect
	$query_args['category'] = ( is_array( $category ) ) ? implode( ',', $category ) : $category; // Pre 1.0.10 compatibility with 'select' type
$query_args['meta_query'] = array(
	array(
		'key' => '_thumbnail_id',
		'compare' => 'EXISTS'
	),
);
$query_args = apply_filters( 'hootkit_slider_postimage_query', $query_args, ( ( !isset( $instance ) ) ? array() : $instance ) );
$slider_posts_query = get_posts( $query_args );

/* Create Slides */
$slider = array();
$counter = 0;
global $post;
foreach ( $slider_posts_query as $post ) :
	setup_postdata( $post );
	$key = 'g' . $counter;
	$counter++;
	$slider[$key]['image']      = ( has_post_thumbnail( $post->ID ) ) ? get_post_thumbnail_id( $post->ID ) : '';
	$slider[$key]['rawtitle']   = get_the_title( $post->ID );
	/*if ( $fullcontent === 'content' ) {
		$slider[$key]['caption'] = get_the_content();
	} else*/
	if( $fullcontent === 'excerpt' ) {
		$excerptlength = intval( $excerptlength );
		if ( function_exists( 'hoot_remove_readmore_link' ) ) hoot_remove_readmore_link();
		if( !empty( $excerptlength ) )
			$slider[$key]['caption'] = hoot_get_excerpt( $excerptlength );
		else
			$slider[$key]['caption'] = apply_filters( 'the_excerpt', get_the_excerpt() );
		if ( function_exists( 'hoot_reinstate_readmore_link' ) ) hoot_reinstate_readmore_link();
	}
	$slider[$key]['caption_bg'] = $caption_bg;
	// $slider[$key]['button']     = ( function_exists( 'hoot_get_mod' ) ) ? hoot_get_mod('read_more') : __( 'Know More', 'hootkit' );
	$slider[$key]['url']        = esc_url( get_permalink( $post->ID ) );
	$slider[$key]['title']      = '<a href="' . $slider[$key]['url'] . '">' . $slider[$key]['rawtitle'] . '</a>';
endforeach;
wp_reset_postdata();

/* Set Slider */
hoot_set_data( 'slider', $slider, true );
hoot_set_data( 'slidersettings', $slidersettings, true );

// Add Pagination
if ( !function_exists( 'hootkit_slider_postimage_pagination' ) ) :
	function hootkit_slider_postimage_pagination( $type, $instance = array() ) {
		if ( !is_string( $type ) || $type != 'postimage' ) return;
		global $hoot_data;
		if ( !empty( $hoot_data->currentwidget['instance'] ) )
			extract( $hoot_data->currentwidget['instance'], EXTR_SKIP );
		if ( !empty( $viewall ) ) {
			if ( !empty( $category ) && is_array( $category ) && count( $category ) == 1 ) { // If more than 1 cat selected, show blog url
				$base_url = esc_url( get_category_link( $category[0] ) );
			} elseif ( !empty( $category ) && !is_array( $category ) ) { // Pre 1.0.10 compatibility with 'select' type
				$base_url = esc_url( get_category_link( $category ) );
			} else {
				$base_url = ( get_option( 'page_for_posts' ) ) ?
							esc_url( get_permalink( get_option( 'page_for_posts' ) ) ) :
							esc_url( home_url('/') );
			}
			$class = sanitize_html_class( 'view-all-' . $viewall );
			if ( $viewall == 'top' )
				$class .= ( !empty( $title ) ) ? ' view-all-withtitle' : '';
			echo '<div class="view-all ' . $class . '"><a href="' . $base_url . '">' . __( 'View All', 'hootkit' ) . '</a></div>';
		}
	}
endif;
if ( !empty( $viewall ) ) :
	if ( !empty( $viewall ) && $viewall == 'top' ) {
		add_action( 'hootkit_slider_start', 'hootkit_slider_postimage_pagination', 10, 2 );
		remove_action( 'hootkit_slider_end', 'hootkit_slider_postimage_pagination', 10, 2 );
	} elseif ( !empty( $viewall ) && $viewall == 'bottom' ) {
		add_action( 'hootkit_slider_end', 'hootkit_slider_postimage_pagination', 10, 2 );
		remove_action( 'hootkit_slider_start', 'hootkit_slider_postimage_pagination', 10, 2 );
	} else {
		remove_action( 'hootkit_slider_start', 'hootkit_slider_postimage_pagination', 10, 2 );
		remove_action( 'hootkit_slider_end', 'hootkit_slider_postimage_pagination', 10, 2 );
	}
endif;

/* Let developers alter slider */
do_action( 'hootkit_slider_loaded', 'postimage', ( ( !isset( $instance ) ) ? array() : $instance ) );

/* Finally get Slider Template HTML */
include ( $slider_template );