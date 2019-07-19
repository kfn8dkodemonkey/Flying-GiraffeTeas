<?php
/**
 * Ticker Widget
 *
 * @package           Hootkit
 * @subpackage        Hootkit/admin
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Class HootKit_Ticker_Widget
 */
class HootKit_Ticker_Widget extends HootKit_WP_Widget {

	function __construct() {

		$settings['id'] = 'hootkit-ticker';
		$settings['name'] = __( 'HootKit > Ticker', 'hootkit' );
		$settings['widget_options'] = array(
			'description'	=> __( 'Animated horizontal scrolling ticker messages', 'hootkit' ),
			// 'classname'		=> 'hoot-ticker-widget', // CSS class applied to frontend widget container via 'before_widget' arg
		);
		$settings['control_options'] = array();
		$settings['form_options'] = array(
			//'name' => can be empty or false to hide the name
			'title' => array(
				'name'		=> __( 'Title (optional)', 'hootkit' ),
				'type'		=> 'text',
			),
			'message' => array(
				'name'		=> __( 'Messages', 'hootkit' ),
				'desc'		=> __('To write multiple messages, start a new message in a new line.', 'hootkit' ),
				'type'		=> 'textarea',
			),
			'speed' => array(
				'name'		=> __( 'Ticker Speed', 'hootkit' ),
				'type'		=> 'smallselect',
				'std'		=> '5',
				'options'	=> array(
					'1'		=> __( '1 (Slowest)', 'hootkit' ),
					'2'		=> __( '2', 'hootkit' ),
					'3'		=> __( '3', 'hootkit' ),
					'4'		=> __( '4', 'hootkit' ),
					'5'		=> __( '5', 'hootkit' ),
					'6'		=> __( '6', 'hootkit' ),
					'7'		=> __( '7', 'hootkit' ),
					'8'		=> __( '8', 'hootkit' ),
					'9'		=> __( '9', 'hootkit' ),
					'10'	=> __( '10 (Fastest)', 'hootkit' ),
				),
			),
			'width' => array(
				'name'		=> __( 'Ticker Width (Optional)', 'hootkit' ),
				'desc'		=> __( '(in pixels) Leave empty for full width', 'hootkit' ),
				'type'		=> 'text',
				'settings'	=> array( 'size' => 9, ),
				'sanitize'	=> 'absint',
			),
			'background' => array(
				'name'		=> __( 'Background (optional)', 'hootkit' ),
				'desc'		=> __( 'Leave empty for no background.', 'hootkit' ),
				// 'std'		=> '#aa0000',
				'type'		=> 'color',
			),
			'fontcolor' => array(
				'name'		=> __( 'Font Color (optional)', 'hootkit' ),
				'desc'		=> __( 'Leave empty to use default font colors.', 'hootkit' ),
				// 'std'		=> '#aa0000',
				'type'		=> 'color',
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

		$settings = apply_filters( 'hootkit_ticker_widget_settings', $settings );

		parent::__construct( $settings['id'], $settings['name'], $settings['widget_options'], $settings['control_options'], $settings['form_options'] );

	}

	/**
	 * Display the widget content
	 */
	function display_widget( $instance, $before_title = '', $title = '', $after_title = '' ) {
		// Allow theme/child-themes to use their own template
		$widget_template = hoot_get_widget( 'ticker', false );
		// Use Hootkit template if theme does not have one
		$widget_template = ( $widget_template ) ? $widget_template : hootkit()->dir . 'template/widget-ticker.php';
		// Fire up the template
		extract( $instance, EXTR_SKIP );
		if ( is_string( $widget_template ) && file_exists( $widget_template ) ) include ( $widget_template );
	}

}

/**
 * Register Widget
 */
function hootkit_ticker_widget_register(){
	register_widget( 'HootKit_Ticker_Widget' );
}
add_action( 'widgets_init', 'hootkit_ticker_widget_register' );