<?php
/**
 * Slider (Carousel) Widget
 *
 * @package           Hootkit
 * @subpackage        Hootkit/admin
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Class HootKit_Slider_Carousel_Widget
 */
class HootKit_Slider_Carousel_Widget extends HootKit_WP_Widget {

	function __construct() {

		$settings['id'] = 'hootkit-slider-carousel';
		$settings['name'] = __( 'HootKit > Carousel Slider', 'hootkit' );
		$settings['widget_options'] = array(
			'description'	=> __( 'Display Images in a Carousel', 'hootkit' ),
			// 'classname'		=> 'hoot-slider-carousel-widget', // CSS class applied to frontend widget container via 'before_widget' arg
		);
		$settings['control_options'] = array();
		$settings['form_options'] = array(
			//'name' => can be empty or false to hide the name
			'title' => array(
				'name'		=> __( 'Title (optional)', 'hootkit' ),
				'type'		=> 'text',
			),
			'items' => array(
				'name'		=> __( 'Carousel Items', 'hootkit' ),
				'desc'		=> __( 'Number of items visible in carousel.', 'hootkit' ),
				'type'		=> 'text',
				'std'		=> 4,
				'settings'	=> array( 'size' => 3, ),
				'sanitize'	=> 'absint',
			),
			'imagesize' => array(
				'name'		=> __( 'Image Size', 'hootkit' ),
				'type'		=> 'smallselect',
				'std'		=> 'vertical',
				'options'	=> array(
					'rectangle' => __( 'Rectangle (cropped)', 'hootkit' ),
					'vertical'  => __( 'Vertical (cropped)', 'hootkit' ),
					'full'      => __( 'Full (no cropping)', 'hootkit' ),
				),
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
			'slides' => array(
				'name'		=> __( 'Items', 'hootkit' ),
				'type'		=> 'group',
				'options'	=> array(
					'item_name'	=> __( 'Item', 'hootkit' ),
					'maxlimit'	=> 4,
					'limitmsg'	=> ( ( hootkit()->get_config( 'nohoot' ) ) ? __( 'Only 4 carousel items allowed. Please use a wpHoot theme to add more carousel items.', 'hootkit' ) : __( 'Only 4 carousel items available in the Free version of the theme.', 'hootkit' ) ),
					'sortable'	=> true,
				),
				'fields'	=> array(
					'image' => array(
						'name'		=> __( 'Image', 'hootkit' ),
						'type'		=> 'image',
					),
					'title' => array(
						'name'		=> __( 'Title', 'hootkit' ),
						'type'		=> 'text',
					),
					'caption' => array(
						'name'		=> __( 'Description', 'hootkit' ),
						'type'		=> 'textarea',
					),
					'button' => array(
						'name'		=> __( 'Link Text (optional)', 'hootkit' ),
						'type'		=> 'text',
						'std'		=> __( 'Know More', 'hootkit' ),
					),
					'url' => array(
						'name'		=> __( 'Link URL (optional)', 'hootkit' ),
						'type'		=> 'text',
						'sanitize'	=> 'url',
					),
				),
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

		$settings = apply_filters( 'hootkit_slider_carousel_widget_settings', $settings );

		parent::__construct( $settings['id'], $settings['name'], $settings['widget_options'], $settings['control_options'], $settings['form_options'] );

	}

	/**
	 * Display the widget content
	 */
	function display_widget( $instance, $before_title = '', $title = '', $after_title = '' ) {
		// Allow theme/child-themes to use their own template
		$slider_template = hoot_get_widget( 'slider-carousel', false );
		// Fire up the template
		extract( $instance, EXTR_SKIP );
		if ( is_string( $slider_template ) && file_exists( $slider_template ) ) include ( hootkit()->dir . 'include/slider-carousel.php' );
	}

}

/**
 * Register Widget
 */
function hootkit_slider_carousel_widget_register(){
	register_widget( 'HootKit_Slider_Carousel_Widget' );
}
add_action( 'widgets_init', 'hootkit_slider_carousel_widget_register' );