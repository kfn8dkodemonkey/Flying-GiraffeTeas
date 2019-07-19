<?php
/* Let developers alter slider via global $hoot_data */
do_action( 'hootkit_widgetslider_start', ( ( !isset( $instance ) ) ? array() : $instance ) );

/* Get Slider Data */
$slider = hoot_data( 'slider' );
if ( empty( $slider ) || !is_array( $slider ) )
	return;
$slidersettings = hoot_data( 'slidersettings' );
$slidersettings = ( empty( $slidersettings ) || !is_array( $slidersettings ) ) ? array() : $slidersettings;
$slidersettings['type'] = ( empty( $slidersettings['type'] ) ) ? '' : $slidersettings['type'];

/* Create Data attributes for javascript settings for this slider */
$atts = $class = $widgetclass = '';
if ( isset( $slidersettings['id'] ) ) {
	$atts .= ' id="' . sanitize_html_class( $slidersettings['id'] ) . '"';
	unset( $slidersettings['id'] );
}
if ( isset( $slidersettings['class'] ) ) {
	$class .= ' ' . hoot_sanitize_html_classes( $slidersettings['class'] );
	unset( $slidersettings['class'] );
}
$class .= ' singleSlideView';
foreach ( $slidersettings as $setting => $value )
	$atts .= ' data-' . sanitize_html_class( $setting ) . '="' . esc_attr( $value ) . '"';

/* Widget Class */
if ( isset( $slidersettings['widgetclass'] ) ) {
	$widgetclass .= ' ' . hoot_sanitize_html_classes( $slidersettings['widgetclass'] );
	unset( $slidersettings['widgetclass'] );
}
/* Manage Navigation */
$nav = empty( $nav ) ? 'both' : $nav;
if ( $nav == 'bullets' || $nav == 'none' ) $widgetclass .= ' hidearrows';
if ( $nav == 'arrows' || $nav == 'none' ) $widgetclass .= ' hidebullets';

/* Start Slider Template */
$slide_count = 1;

?>
<div class="hootkitslider-widget<?php echo $widgetclass; ?>">

	<?php
	/* Display Title */
	if ( !empty( $title ) )
		echo wp_kses_post( apply_filters( 'hootkit_widget_title', $before_title . $title . $after_title, 'slider', $title, $before_title, $after_title ) );

	// Template modification Hook
	do_action( 'hootkit_slider_start', $slidersettings['type'], ( ( !isset( $instance ) ) ? array() : $instance ) );
	?>

	<ul class="lightSlider<?php echo $class; ?>"<?php echo $atts; ?>><?php
		foreach ( $slider as $key => $slide ) :

			$slide = wp_parse_args( $slide, array(
				'image'      => '',
				'title'      => '',
				'caption'    => '',
				'caption_bg' => 'dark-on-light',
				'button'     => '',
				'url'        => '',
			) );
			$slide['image'] = intval( $slide['image'] );

			if ( !empty( $slide['image'] ) ) :
				?>

				<li class="lightSlide hootkitslide hootkitslide-<?php echo $slide_count; $slide_count++; ?>">

					<?php
					if ( !empty( $slide['url'] ) && empty( $slide['button'] ) )
						echo '<a href="' . esc_url( $slide['url'] ) . '" ' . hoot_get_attr( 'hootkitslide-link' ) . '>';

					$img_size = apply_filters( 'hootkitslide_imgsize', 'full' );
					echo wp_get_attachment_image( $slide['image'], $img_size, '', array( 'class' => "hootkitslide-img attachment-{$img_size} size-{$img_size}", 'itemprop' => 'image' ) );

					if ( !empty( $slide['url'] ) && empty( $slide['button'] ) )
						echo '</a>';
					?>

					<div class="hootkitslide-content wrap-<?php echo $slide['caption_bg']; ?>">
						<?php
						if ( !empty( $slide['title'] ) || !empty( $slide['caption'] ) ) :
							?>
							<div <?php hoot_attr( 'hootkitslide-caption', '', 'style-' . $slide['caption_bg'] ) ?>>
								<?php
								if ( !empty( $slide['title'] ) )
									echo '<h3 class="hootkitslide-head">' . wp_kses_post( $slide['title'] ) . '</h3>';
								if ( !empty( $slide['caption'] ) )
									echo '<div class="hootkitslide-text">' . wp_kses_post( wpautop( $slide['caption'] ) ) . '</div>';
								?>
							</div>
							<?php
						endif;

						if ( !empty( $slide['url'] ) && !empty( $slide['button'] ) ) :
							?>
							<a href="<?php echo esc_url( $slide['url'] ) ?>" <?php hoot_attr( 'hootkitslide-button', '', 'button button-small' ); ?>>
								<?php echo esc_html( $slide['button'] ) ?>
							</a>
							<?php
						endif;
						?>
					</div>

				</li>
				<?php
			endif;
		endforeach;
		?>
	</ul>

	<?php
	// Template modification Hook
	do_action( 'hootkit_slider_end', $slidersettings['type'], ( ( !isset( $instance ) ) ? array() : $instance ) );
	?>

</div>