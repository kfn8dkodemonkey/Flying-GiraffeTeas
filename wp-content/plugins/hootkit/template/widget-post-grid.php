<?php
// Get total columns and set column counter
$columns = ( intval( $columns ) >= 1 && intval( $columns ) <= 5 ) ? intval( $columns ) : 4;

// Create a custom WP Query
$count = intval( $count );
$query_args = array();
$query_args['posts_per_page'] = ( empty( $count ) ) ? 7 : $count;
if ( !empty( $category ) ) // undefined if none selected in multiselect
	$query_args['category'] = ( is_array( $category ) ) ? implode( ',', $category ) : $category; // Pre 1.0.10 compatibility with 'select' type
$query_args['meta_query'] = array(
	array(
		'key' => '_thumbnail_id',
		'compare' => 'EXISTS'
	),
);
$query_args = apply_filters( 'hootkit_post_grid_query', $query_args, ( ( !isset( $instance ) ) ? array() : $instance ) );
$post_grid_query = get_posts( $query_args );

// Add Pagination
if ( !function_exists( 'hootkit_post_grid_pagination' ) ) :
	function hootkit_post_grid_pagination( $post_grid_query, $query_args ) {
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
		add_action( 'hootkit_post_grid_start', 'hootkit_post_grid_pagination', 10, 2 );
		remove_action( 'hootkit_post_grid_end', 'hootkit_post_grid_pagination', 10, 2 );
	} elseif ( !empty( $viewall ) && $viewall == 'bottom' ) {
		add_action( 'hootkit_post_grid_end', 'hootkit_post_grid_pagination', 10, 2 );
		remove_action( 'hootkit_post_grid_start', 'hootkit_post_grid_pagination', 10, 2 );
	} else {
		remove_action( 'hootkit_post_grid_start', 'hootkit_post_grid_pagination', 10, 2 );
		remove_action( 'hootkit_post_grid_end', 'hootkit_post_grid_pagination', 10, 2 );
	}
endif;

// Template modification Hook
do_action( 'hootkit_post_grid_wrap', $post_grid_query, $query_args, ( ( !isset( $instance ) ) ? array() : $instance ) );
?>

<div class="post-grid-widget">

	<?php
	/* Display Title */
	if ( !empty( $title ) )
		echo wp_kses_post( apply_filters( 'hootkit_widget_title', $before_title . $title . $after_title, 'post-grid', $title, $before_title, $after_title ) );

	// Template modification Hook
	do_action( 'hootkit_post_grid_start', $post_grid_query, $query_args, ( ( !isset( $instance ) ) ? array() : $instance ) );
	?>

	<div class="post-grid-columns">
		<?php
		global $post;
		$postcount = 1;

		foreach ( $post_grid_query as $post ) :

				// Init
				setup_postdata( $post );
				$visual = ( has_post_thumbnail() ) ? 1 : 0;
				$metadisplay = array();

				if ( $visual ) :

					if ( $postcount == 1 ) {
						$factor = ( $columns == 1 || !empty( $firstpost['standard'] ) ) ? '1' : '2';
						if ( !empty( $firstpost['author'] ) ) $metadisplay[] = 'author';
						if ( !empty( $firstpost['date'] ) ) $metadisplay[] = 'date';
						if ( !empty( $firstpost['comments'] ) ) $metadisplay[] = 'comments';
						if ( !empty( $firstpost['cats'] ) ) $metadisplay[] = 'cats';
						if ( !empty( $firstpost['tags'] ) ) $metadisplay[] = 'tags';
					} else {
						$factor = '1';
						if ( !empty( $show_author ) ) $metadisplay[] = 'author';
						if ( !empty( $show_date ) ) $metadisplay[] = 'date';
						if ( !empty( $show_comments ) ) $metadisplay[] = 'comments';
						if ( !empty( $show_cats ) ) $metadisplay[] = 'cats';
						if ( !empty( $show_tags ) ) $metadisplay[] = 'tags';
					}

					// $img_size = hootkit_thumbnail_size( "column-{$factor}-{$columns}" );
					$img_size = 'hoot-preview-large';
					$img_size = apply_filters( 'hootkit_post_grid_imgsize', $img_size, $columns, $postcount, $factor );
					$default_img_size = apply_filters( 'hoot_notheme_post_grid_imgsize', ( ( $factor == 2 ) ? 'full' : 'thumbnail' ), $columns, $postcount, $factor );

					// Start Block Display
					$gridunit_attr = array();
					$gridunit_attr['class'] = "post-gridunit hcolumn-{$factor}-{$columns} post-gridunit-size{$factor}";
					$gridunit_attr['class'] .= ($visual) ? ' visual-img' : ' visual-none';
					$gridunit_attr['data-unitsize'] = $factor;
					$gridunit_attr['data-columns'] = $columns;

					// Set Grid Height
					$gridunit_height = ( empty( $unitheight ) ) ? 0 : ( intval( $unitheight ) );
					$gridunit_style = ( $gridunit_height && $factor == 2 ) ? 'style="height:' . esc_attr( $gridunit_height ) . 'px;"' : '';
					?>

					<div <?php echo hoot_get_attr( 'post-gridunit', '', $gridunit_attr ) ?> <?php echo $gridunit_style; ?>>

						<?php
						$gridimg_attr = array( 'style' => '' );
						$thumbnail_size = hootkit_thumbnail_size( $img_size, NULL, $default_img_size );
						$thumbnail_url = get_the_post_thumbnail_url( null, $thumbnail_size );
						if ( $thumbnail_url ) $gridimg_attr['style'] .= "background-image:url('" . esc_url($thumbnail_url) . "');";
						if ( $gridunit_height ) $gridimg_attr['style'] .= 'height:' . esc_attr( $gridunit_height * $factor ) . 'px;';
						?>
						<div <?php echo hoot_get_attr( 'post-gridunit-image', '', $gridimg_attr ) ?>>
							<?php hootkit_post_thumbnail( 'post-gridunit-img', $img_size, false, '', NULL, $default_img_size ); // Redundant, but we use it for SEO (related images) ?>
						</div>

						<div class="post-gridunit-bg"><?php echo '<a href="' . esc_url( get_permalink() ) . '" ' . hoot_get_attr( 'post-gridunit-imglink', 'permalink' ) . '></a>'; ?></div>
						<div class="post-gridunit-content">
							<?php if ( !empty( $show_title ) ) : ?>
								<h4 class="post-gridunit-title"><?php echo '<a href="' . esc_url( get_permalink() ) . '" ' . hoot_get_attr( 'post-gridunit-link', 'permalink' ) . '>';
									the_title();
									echo '</a>'; ?></h4>
							<?php endif; ?>
							<?php
							hootkit_display_meta_info( array(
								'display' => $metadisplay,
								'context' => 'post-gridunit-' . $postcount,
								'editlink' => false,
								'wrapper' => 'div',
								'wrapper_class' => 'post-gridunit-subtitle small',
								'empty' => '',
							) );
							?>
						</div>

					</div><?php
					$postcount++;

				endif;

		endforeach;

		wp_reset_postdata();

		echo '<div class="clearfix"></div>';
		?>
	</div>

	<?php
	// Template modification Hook
	do_action( 'hootkit_post_grid_end', $post_grid_query, $query_args, ( ( !isset( $instance ) ) ? array() : $instance ) );
	?>

</div>