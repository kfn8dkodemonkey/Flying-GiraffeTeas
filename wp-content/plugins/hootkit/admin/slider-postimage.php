<?php
/**
 * Slider (PostImage) Widget
 *
 * @package           Hootkit
 * @subpackage        Hootkit/admin
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Class HootKit_Slider_Postimage_Widget
 */
class HootKit_Slider_Postimage_Widget extends HootKit_WP_Widget {

	function __construct() {

		$settings['id'] = 'hootkit-slider-postimage';
		$settings['name'] = __( 'HootKit > Posts Slider', 'hootkit' );
		$settings['widget_options'] = array(
			'description'	=> __( 'Display Posts Slider', 'hootkit' ),
			// 'classname'		=> 'hoot-slider-posts-widget', // CSS class applied to frontend widget container via 'before_widget' arg
		);
		$settings['control_options'] = array();
		$settings['form_options'] = array(
			//'name' => can be empty or false to hide the name
			'description' => array(
				// 'name'		=> __( '', 'hootkit' ),
				'type'		=> __( "<strong>Note:</strong> Only Posts with a 'Featured Image' will be displayed.", 'hootkit' ),
			),
			'title' => array(
				'name'		=> __( 'Title (optional)', 'hootkit' ),
				'type'		=> 'text',
			),
			'style' => array(
				'name'		=> __( 'Slider Style', 'hootkit' ),
				'type'		=> 'images',
				'std'		=> 'style1',
				'options'	=> array(
					'style1'	=> hootkit()->uri . 'assets/images/slider-style-1.png',
					'style2'	=> hootkit()->uri . 'assets/images/slider-style-2.png',
				),
			),
			'count' => array(
				'name'		=> __( 'Number of Posts to show', 'hootkit' ),
				'desc'		=> ( ( hootkit()->get_config( 'nohoot' ) ) ? __( '<strong>Only 4 posts allowed. Please use a wpHoot theme to add more posts.</strong>', 'hootkit' ) : __( '<strong>Only 4 posts available in the Free version of the theme.</strong>', 'hootkit' ) ),
				'type'		=> 'smallselect',
				'std'		=> '4',
				'options'	=> array(
					'1' => __( '1', 'hootkit' ),
					'2' => __( '2', 'hootkit' ),
					'3' => __( '3', 'hootkit' ),
					'4' => __( '4', 'hootkit' ),
				),
			),
			'offset' => array(
				'name'		=> __( 'Offset', 'hootkit' ),
				'desc'		=> __( 'Number of posts to skip from the start. Leave empty to start from the latest post.', 'hootkit' ),
				'type'		=> 'text',
				'settings'	=> array( 'size' => 3, ),
				'sanitize'	=> 'absint',
			),
			'viewall' => array(
				'name'		=> __( "'View All Posts' link", 'hootkit' ),
				'desc'		=> __( 'Links to your Blog page. If you have a Category selected below, then this will link to the Category Archive page.', 'hootkit' ),
				'type'		=> 'select',
				'std'		=> 'none',
				'options'	=> array(
					'none'		=> __( 'Do not display', 'hootkit' ),
					'top'		=> __( 'Show at Top', 'hootkit' ),
					'bottom'	=> __( 'Show at Bottom', 'hootkit' ),
				),
			),
			'category' => array(
				'name'		=> __( 'Category (Optional)', 'hootkit' ),
				'desc'		=> __( 'Leave empty to display posts from all categories.', 'hootkit' ),
				'type'		=> 'multiselect',
				'options'	=> (array)Hoot_List::categories('category'),
			),
			'caption_bg' => array(
				'name'		=> __( 'Text Styling', 'hootkit' ),
				'type'		=> 'select',
				'std'		=> 'light-on-dark',
				'options'	=> array(
					'dark'			=> __( 'Dark Font', 'hootkit' ),
					'light'			=> __( 'Light Font', 'hootkit' ),
					'dark-on-light'	=> __( 'Dark Font / Light Background', 'hootkit' ),
					'light-on-dark'	=> __( 'Light Font / Dark Background', 'hootkit' ),
				),
			),
			'fullcontent' => array(
				'name'		=> __( 'Content', 'hootkit' ),
				'type'		=> 'select',
				'std'		=> 'excerpt',
				'options'	=> array(
					'excerpt'	=> __( 'Display Excerpt', 'hootkit' ),
					// 'content'	=> __( 'Display Full Content', 'hootkit' ),
					'none'		=> __( 'None', 'hootkit' ),
				),
			),
			'excerptlength' => array(
				'name'		=> __( 'Custom Excerpt Length', 'hootkit' ),
				'desc'		=> __( 'Select \'Display Excerpt\' in option above. Leave empty for default excerpt length.', 'hootkit' ),
				'type'		=> 'text',
				'settings'	=> array( 'size' => 3, ),
				'sanitize'	=> 'absint',
			),
			'nav' => array(
				'name'		=> __( 'Navigation', 'hootkit' ),
				'type'		=> 'smallselect',
				'std'		=> 'both',
				'options'	=> array(
					'both'    => __( 'Arrows + Bullets', 'hootkit' ),
					'arrows'  => __( 'Arrows', 'hootkit' ),
					'bullets' => __( 'Bullets', 'hootkit' ),
					'none'    => __( 'None', 'hootkit' ),
				),
			),
			'pause' => array(
				'name'		=> __( 'Pause Time (1-15)', 'hootkit' ),
				'desc'		=> __( 'Seconds to pause on each slide.', 'hootkit' ),
				'type'		=> 'text',
				'std'		=> 5,
				'settings'	=> array( 'size' => 3, ),
				'sanitize'	=> 'absint',
			),
			'customcss' => array(
				'name'		=> __( 'Widget Options', 'hootkit' ),
				'type'		=> 'collapse',
				'fields'	=> array(
					'class' => array(
						'name'		=> __( 'Custom CSS Class', 'hootkit' ),
						'desc'		=> __( 'Give this widget a custom css classname', 'hootkit' ),
						'type'		=> 'text',
					),
					'mt' => array(
						'name'		=> __( 'Margin Top', 'hootkit' ),
						'desc'		=> __( '(in pixels) Leave empty to load default margins', 'hootkit' ),
						'type'		=> 'text',
						'settings'	=> array( 'size' => 3 ),
						'sanitize'	=> 'integer',
					),
					'mb' => array(
						'name'		=> __( 'Margin Bottom', 'hootkit' ),
						'desc'		=> __( '(in pixels) Leave empty to load default margins', 'hootkit' ),
						'type'		=> 'text',
						'settings'	=> array( 'size' => 3 ),
						'sanitize'	=> 'integer',
					),
					'widgetid' => array(
						'name'		=> __( 'Widget ID', 'hootkit' ),
						'type'		=> '<span class="widgetid" data-baseid="' . $settings['id'] . '">' . __( 'Save this widget to view its ID', 'hootkit' ) . '</span>',
					),
				),
			),
		);

		if ( !in_array( 'slider-styles', hootkit()->get_config( 'supports' ) ) )
			unset( $settings['form_options']['style'] );

		$settings = apply_filters( 'hootkit_slider_postimage_widget_settings', $settings );

		parent::__construct( $settings['id'], $settings['name'], $settings['widget_options'], $settings['control_options'], $settings['form_options'] );

	}

	/**
	 * Display the widget content
	 */
	function display_widget( $instance, $before_title = '', $title = '', $after_title = '' ) {
		// Allow theme/child-themes to use their own template
		$slider_template = hoot_get_widget( 'slider-postimage', false );
		// Use Hootkit template if theme does not have one
		$slider_template = ( $slider_template ) ? $slider_template : hootkit()->dir . 'template/widget-slider.php';
		// Fire up the template
		extract( $instance, EXTR_SKIP );
		if ( is_string( $slider_template ) && file_exists( $slider_template ) ) include ( hootkit()->dir . 'include/slider-postimage.php' );
	}

}

/**
 * Register Widget
 */
function hootkit_slider_postimage_widget_register(){
	register_widget( 'HootKit_Slider_Postimage_Widget' );
}
add_action( 'widgets_init', 'hootkit_slider_postimage_widget_register' );