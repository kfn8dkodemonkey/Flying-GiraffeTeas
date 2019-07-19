<?php
// Get border classes
$top_class = hootkit_widget_borderclass( $border, 0, 'topborder-');
$bottom_class = hootkit_widget_borderclass( $border, 1, 'bottomborder-');

// Get total columns and set column counter
$columns = ( intval( $columns ) >= 1 && intval( $columns ) <= 5 ) ? intval( $columns ) : 3;
$column = $counter = 1;

// Set clearfix to avoid error if there are no boxes
$clearfix = 1;

// Set user defined style for content boxes
$userstyle = $style;

// Create a custom WP Query
$query_args = array();
$count = intval( $count );
$query_args['posts_per_page'] = ( empty( $count ) ) ? 4 : $count;
$offset = intval( $offset );
if ( $offset )
	$query_args['offset'] = $offset;
if ( !empty( $category ) ) // undefined if none selected in multiselect
	$query_args['category'] = ( is_array( $category ) ) ? implode( ',', $category ) : $category; // Pre 1.0.10 compatibility with 'select' type
$query_args = apply_filters( 'hootkit_content_posts_blocks_query', $query_args, ( ( !isset( $instance ) ) ? array() : $instance ) );
$content_blocks_query = get_posts( $query_args );

// Temporarily remove read more links from excerpts
if ( function_exists( 'hoot_remove_readmore_link' ) )
	hoot_remove_readmore_link();

$excerptlength = intval( $excerptlength );

// Add Pagination
if ( !function_exists( 'hootkit_content_blocks_pagination' ) ) :
	function hootkit_content_blocks_pagination( $context, $content_blocks_query, $query_args ) {
		if ( $context != 'posts' ) return;
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
		add_action( 'hootkit_content_blocks_start', 'hootkit_content_blocks_pagination', 10, 3 );
		remove_action( 'hootkit_content_blocks_end', 'hootkit_content_blocks_pagination', 10, 3 );
	} elseif ( !empty( $viewall ) && $viewall == 'bottom' ) {
		add_action( 'hootkit_content_blocks_end', 'hootkit_content_blocks_pagination', 10, 3 );
		remove_action( 'hootkit_content_blocks_start', 'hootkit_content_blocks_pagination', 10, 3 );
	} else {
		remove_action( 'hootkit_content_blocks_start', 'hootkit_content_blocks_pagination', 10, 3 );
		remove_action( 'hootkit_content_blocks_end', 'hootkit_content_blocks_pagination', 10, 3 );
	}
endif;

// Template modification Hook
do_action( 'hootkit_content_blocks_wrap', 'posts', $content_blocks_query, $query_args, ( ( !isset( $instance ) ) ? array() : $instance ) );
?>

<div class="content-blocks-widget-wrap content-blocks-posts <?php echo hoot_sanitize_html_classes( "{$top_class} {$bottom_class}" ); ?>">
	<div class="content-blocks-widget">

		<?php
		/* Display Title */
		if ( !empty( $title ) )
			echo wp_kses_post( apply_filters( 'hootkit_widget_title', $before_title . $title . $after_title, 'content-posts-blocks', $title, $before_title, $after_title ) );

		// Template modification Hook
		do_action( 'hootkit_content_blocks_start', 'posts', $content_blocks_query, $query_args, ( ( !isset( $instance ) ) ? array() : $instance ) );
		?>

		<div class="flush-columns">
			<?php
					global $post;
					// $fullcontent = ( empty( $fullcontent ) ) ? 'excerpt' :
					// 				( ( $fullcontent === 1 ) ? 'content' : $fullcontent ); // Backward Compatible

					foreach ( $content_blocks_query as $post ) :

							// Init
							setup_postdata( $post );
							$visual = $visualtype = '';

							// Refresh user style (to add future op of diff styles for each block)
							$style = $userstyle;
							// Style 5,6 exceptions: doesnt work great with non images (no visual). So revert to Style 1 for this scenario
							$style = ( ( $style == 'style5' || $style == 'style6' ) && !has_post_thumbnail() ) ? 'style1' : $style;

							$style = apply_filters( 'hootkit_content_posts_block_style', $style, $userstyle, $post, ( ( !isset( $instance ) ) ? array() : $instance ) );

							// Set image or icon
							if ( has_post_thumbnail() ) {
								$visualtype = 'image';
								if ( $style == 'style4' ) {
									switch ( $columns ) {
										case 1: $img_size = 2; break;
										case 2: $img_size = 4; break;
										default: $img_size = 5;
									}
								} else {
									$img_size = $columns;
								}
								$default_img_size = apply_filters( 'hootkit_nohoot_content_posts_block_imgsize', ( ( $style != 'style4' ) ? 'full' : 'thumbnail' ), $columns, $style );
								$img_size = hootkit_thumbnail_size( 'column-1-' . $img_size, NULL, $default_img_size );
								$img_size = apply_filters( 'hootkit_content_posts_block_imgsize', $img_size, $columns, $style );
								$visual = 1;
							}

							// Set Block Class (if no visual for style 2/3, then dont highlight)
							$column_class = ( !empty( $visualtype ) ) ? "hasvisual visual-{$visualtype}" : 'visual-none';

							// Set URL
							$linktag = '<a href="' . esc_url( get_permalink() ) . '" ' . hoot_get_attr( 'content-block-link', 'permalink' ) . '>';
							$linktagend = '</a>';
							$linktext = ( function_exists( 'hoot_get_mod' ) ) ? hoot_get_mod('read_more') : __( 'Know More', 'hootkit' );
							$linktext = ( empty( $linktext ) ) ? sprintf( __( 'Read More %s', 'hootkit' ), '&rarr;' ) : $linktext;
							$linktext = '<p class="more-link">' . $linktag . esc_html( $linktext ) . $linktagend . '</p>';

							// Start Block Display
							if ( $column == 1 ) echo '<div class="content-block-row">';
							?>

							<div class="content-block-column <?php echo hoot_sanitize_html_classes( "hcolumn-1-{$columns} content-block-{$counter} content-block-{$style} {$column_class}" ); ?>">
								<div <?php hoot_attr( 'content-block',
													  array( 'visual' => $visual, 'visualtype' => $visualtype, 'style' => $style ),
													  'no-highlight'
													); ?>>

									<?php if ( $visualtype == 'image' ) : ?>
										<div class="content-block-visual content-block-image">
											<?php echo $linktag;
											hootkit_post_thumbnail( 'content-block-img', $img_size, false, '', NULL, $default_img_size );
											echo $linktagend; ?>
										</div>
									<?php endif; ?>

									<div class="content-block-content<?php
										if ( $visualtype == 'image' ) echo ' content-block-content-hasimage';
										else echo ' no-visual';
										?>">
										<h4 class="content-block-title"><?php echo $linktag;
											the_title();
											echo $linktagend; ?></h4>
										<?php $metadisplay = array(); $metacontext = '';
										if ( !empty( $show_author ) ) $metadisplay[] = 'author';
										if ( !empty( $show_date ) ) $metadisplay[] = 'date';
										if ( !empty( $show_comments ) ) $metadisplay[] = 'comments';
										if ( !empty( $show_cats ) ) { $metadisplay[] = 'cats'; $metacontext .= 'cats,'; }
										if ( !empty( $show_tags ) ) { $metadisplay[] = 'tags'; $metacontext .= 'tags,'; }
										hootkit_display_meta_info( array(
											'display' => $metadisplay,
											'context' => 'content-block-' . $counter,
											'wrapper' => 'div',
											'wrapper_class' => 'content-block-subtitle small',
											'empty' => '',
										) ); ?>
										<?php
										if ( $fullcontent === 'content' ) {
											echo '<div class="content-block-text">';
											the_content();
											echo '</div>';
										} elseif( $fullcontent === 'excerpt' ) {
											echo '<div class="content-block-text">';
											if( !empty( $excerptlength ) )
												echo hoot_get_excerpt( $excerptlength );
											else
												the_excerpt();
											echo '</div>';
											if ( function_exists( 'hoot_remove_readmore_link' ) && ( $style == 'style5' || $style == 'style6' ) )
												echo $linktext;
										}
										?>
									</div>

								</div>
								<?php
								if ( $fullcontent === 'excerpt' && function_exists( 'hoot_remove_readmore_link' ) && $style != 'style5' && $style != 'style6' )
									echo $linktext;
								?>
							</div><?php

							$counter++;
							if ( $column == $columns ) {
								echo '</div>';
								$column = $clearfix = 1;
							} else {
								$clearfix = false;
								$column++;
							}

					endforeach;

					wp_reset_postdata();

			if ( !$clearfix ) echo '</div>';
			?>
		</div>

		<?php
		// Template modification Hook
		do_action( 'hootkit_content_blocks_end', 'posts', $content_blocks_query, $query_args, ( ( !isset( $instance ) ) ? array() : $instance ) );
		?>

	</div>
</div>

<?php
// Reinstate read more links to excerpts
if ( function_exists( 'hoot_reinstate_readmore_link' ) )
	hoot_reinstate_readmore_link();