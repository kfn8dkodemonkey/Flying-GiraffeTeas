<?php
/**
 * Tabs Widget
 *
 * @package           Hootkit
 * @subpackage        Hootkit/admin
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Class HootKit_Tabs_Widget
 */
class HootKit_Tabs_Widget extends HootKit_WP_Widget {

	function __construct() {

		$settings['id'] = 'hootkit-tabs';
		$settings['name'] = __( 'HootKit > Tabs', 'hootkit' );
		$settings['widget_options'] = array(
			'description'	=> __( 'Display Tabs', 'hootkit' ),
			// 'classname'		=> 'hoot-tabs-widget', // CSS class applied to frontend widget container via 'before_widget' arg
		);
		$settings['control_options'] = array();
		$settings['form_options'] = array(
			//'name' => can be empty or false to hide the name
			'title' => array(
				'name'		=> __( 'Title (optional)', 'hootkit' ),
				'type'		=> 'text',
			),
			'boxes' => array(
				'name'		=> __( 'Tab Boxes', 'hootkit' ),
				'type'		=> 'group',
				'options'	=> array(
					'item_name'	=> __( 'Tab', 'hootkit' ),
					'maxlimit'	=> 4,
					'limitmsg'	=> ( ( hootkit()->get_config( 'nohoot' ) ) ? __( 'Only 4 tabs allowed. Please use a wpHoot theme to add more tabs.', 'hootkit' ) : __( 'Only 4 tabs available in the Free version of the theme.', 'hootkit' ) ),
					'sortable'	=> true,
				),
				'fields'	=> array(
					'title' => array(
						'name'		=> __( 'Tab Heading', 'hootkit' ),
						'type'		=> 'text',
					),
					'content' => array(
						'name'		=> __( 'Tab Content', 'hootkit' ),
						'type'		=> 'textarea',
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

		$settings = apply_filters( 'hootkit_tabs_widget_settings', $settings );

		parent::__construct( $settings['id'], $settings['name'], $settings['widget_options'], $settings['control_options'], $settings['form_options'] );

	}

	/**
	 * Display the widget content
	 */
	function display_widget( $instance, $before_title = '', $title = '', $after_title = '' ) {
		// Allow theme/child-themes to use their own template
		$widget_template = hoot_get_widget( 'tabs', false );
		// Fire up the template
		extract( $instance, EXTR_SKIP );
		if ( is_string( $widget_template ) && file_exists( $widget_template ) ) include ( $widget_template );
	}

}

/**
 * Register Widget
 */
function hootkit_tabs_register(){
	register_widget( 'HootKit_Tabs_Widget' );
}
add_action( 'widgets_init', 'hootkit_tabs_register' );