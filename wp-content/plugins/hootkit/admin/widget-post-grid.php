<?php
/**
 * Post Grid Widget
 *
 * @package           Hootkit
 * @subpackage        Hootkit/admin
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Class HootKit_Post_Grid_Widget
 */
class HootKit_Post_Grid_Widget extends HootKit_WP_Widget {

	function __construct() {

		$settings['id'] = 'hootkit-posts-grid';
		$settings['name'] = __( 'HootKit > Posts Grid', 'hootkit' );
		$settings['widget_options'] = array(
			'description'	=> __( 'Display Posts in a Grid', 'hootkit' ),
			// 'classname'		=> 'hoot-post-grid-widget', // CSS class applied to frontend widget container via 'before_widget' arg
		);
		$settings['control_options'] = array();
		$settings['form_options'] = array(
			//'name' => can be empty or false to hide the name
			'title' => array(
				'name'		=> __( 'Title (sptional)', 'hootkit' ),
				'type'		=> 'text',
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
			'columns' => array(
				'name'		=> __( 'No. Of Columns', 'hootkit' ),
				'desc'		=> __( 'First post takes up 2 columns by default. (You can change this in options below)', 'hootkit' ),
				'type'		=> 'smallselect',
				'std'		=> '5',
				'options'	=> array(
					'1'	=> __( '1', 'hootkit' ),
					'2'	=> __( '2', 'hootkit' ),
					'3'	=> __( '3', 'hootkit' ),
					'4'	=> __( '4', 'hootkit' ),
					'5'	=> __( '5', 'hootkit' ),
				),
			),
			'count' => array(
				'name'		=> __( 'Number of Posts to show', 'hootkit' ),
				'desc'		=> __( 'Default: 7 (posts without a featured image are skipped)', 'hootkit' ),
				'type'		=> 'text',
				'settings'	=> array( 'size' => 3, ),
				'sanitize'	=> 'absint',
			),
			'show_title' => array(
				'name'		=> __( 'Display Post Titles', 'hootkit' ),
				'type'		=> 'checkbox',
				'std'		=> 1,
			),
			'unitheight' => array(
				'name'		=> __( 'Grid Unit (Post Image) Size', 'hootkit' ),
				'desc'		=> __( 'Default: 215 (in pixels)', 'hootkit' ),
				'type'		=> 'text',
				'settings'	=> array( 'size' => 3, ),
				'sanitize'	=> 'absint',
			),
			'seppost' => array(
				'name'		=> __( 'Individual Posts:', 'hootkit' ),
				// 'desc'		=> __( 'INDIVIDUAL POSTS', 'hootkit' ),
				'type'		=> 'separator',
			),
			'show_author' => array(
				'name'		=> __( 'Show Author', 'hootkit' ),
				'type'		=> 'checkbox',
			),
			'show_date' => array(
				'name'		=> __( 'Show Post Date', 'hootkit' ),
				'type'		=> 'checkbox',
			),
			'show_comments' => array(
				'name'		=> __( 'Show number of comments', 'hootkit' ),
				'type'		=> 'checkbox',
			),
			'show_cats' => array(
				'name'		=> __( 'Show Categories', 'hootkit' ),
				'type'		=> 'checkbox',
			),
			'show_tags' => array(
				'name'		=> __( 'Show tags', 'hootkit' ),
				'type'		=> 'checkbox',
			),
			'firstpost' => array(
				'name'		=> __( 'First Post', 'hootkit' ),
				'type'		=> 'collapse',
				'settings'	=> array( 'state' => 'open' ),
				'fields'	=> array(
					'standard' => array(
						'name'		=> __( 'Display as Standard Size', 'hootkit' ),
						'desc'		=> __( 'By default, first post is displayed bigger in size compared to other posts.', 'hootkit' ),
						'type'		=> 'checkbox',
					),
					'author' => array(
						'name'		=> __( 'Show Author', 'hootkit' ),
						'type'		=> 'checkbox',
						'std'		=> 1,
					),
					'date' => array(
						'name'		=> __( 'Show Post Date', 'hootkit' ),
						'type'		=> 'checkbox',
						'std'		=> 1,
					),
					'comments' => array(
						'name'		=> __( 'Show number of comments', 'hootkit' ),
						'type'		=> 'checkbox',
					),
					'cats' => array(
						'name'		=> __( 'Show Categories', 'hootkit' ),
						'type'		=> 'checkbox',
					),
					'tags' => array(
						'name'		=> __( 'Show tags', 'hootkit' ),
						'type'		=> 'checkbox',
					),
					'fix' => array(
						'type'		=> '<input type="hidden" name="%name%" id="%id%" value="na" class="%class%">',
						// Bugfix: This field is added since all the fields in collapsible are checkboxes. So when all checkbox are unchecked, value for "widget-hoot-post-grid-widget[N][firstpost]" in the instance is returned as false by the browsers instead of an array with all emements = 0 (empty string value is ok, but we still add a dummy value)
					),
				),
			),
			'sepcss' => array(
				'type'		=> 'separator',
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

		$settings = apply_filters( 'hootkit_post_grid_widget_settings', $settings );

		parent::__construct( $settings['id'], $settings['name'], $settings['widget_options'], $settings['control_options'], $settings['form_options'] );

	}

	/**
	 * Display the widget content
	 */
	function display_widget( $instance, $before_title = '', $title = '', $after_title = '' ) {
		// Allow theme/child-themes to use their own template
		$widget_template = hoot_get_widget( 'post-grid', false );
		// Use Hootkit template if theme does not have one
		$widget_template = ( $widget_template ) ? $widget_template : hootkit()->dir . 'template/widget-post-grid.php';
		// Fire up the template
		extract( $instance, EXTR_SKIP );
		if ( is_string( $widget_template ) && file_exists( $widget_template ) ) include ( $widget_template );
	}

}

/**
 * Register Widget
 */
function hootkit_post_grid_widget_register(){
	register_widget( 'HootKit_Post_Grid_Widget' );
}
add_action( 'widgets_init', 'hootkit_post_grid_widget_register' );