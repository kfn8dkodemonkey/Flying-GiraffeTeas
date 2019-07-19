<?php

// Get border classes
$top_class = hootkit_widget_borderclass( $border, 0, 'topborder-');
$bottom_class = hootkit_widget_borderclass( $border, 1, 'bottomborder-');

// Link Text
$button_text = ( !empty( $button_text ) ) ? $button_text : ( ( function_exists( 'hoot_get_mod' ) ) ? hoot_get_mod('read_more') : __( 'Know More', 'hootkit' ) );
$button_text = ( empty( $button_text ) ) ? sprintf( __( 'Read More %s', 'hootkit' ), '&rarr;' ) : $button_text;

// Widget Class
$class = '';
$class .= ( !empty( $align ) ) ? ' cta-' . esc_attr( $align ) : ' cta-center';
$class .= ( !empty( $content_bg ) ) ? ' cta-' . esc_attr( $content_bg ) : '';
$class .= ( !empty( $content_bg ) && $content_bg !== 'default' ) ? ' cta-background' : ' cta-transparent';
$class .= ( !empty( $titlesize ) ) ? ' cta-title-' . esc_attr( $titlesize ) : '';
$class .= ( !empty( $style ) ) ? ' cta-' . esc_attr( $style ) : ' cta-style1';
?>

<div class="cta-widget-wrap <?php echo hoot_sanitize_html_classes( "{$top_class} {$bottom_class}" ); ?>">
	<div class="cta-widget <?php echo $class; ?>">

		<div class="cta-content">

			<?php if ( !empty( $headline ) ) { ?>
				<h3 class="cta-headline"><?php echo do_shortcode( esc_html( $headline ) ); ?></h3>
			<?php } ?>

			<?php if ( !empty( $subtitle ) ) { ?>
				<div class="cta-subtitle"><?php echo do_shortcode( wp_kses_post( $subtitle ) ) ?></div>
			<?php } ?>

			<?php if ( !empty( $description ) ) { ?>
				<div class="cta-description"><?php echo do_shortcode( wp_kses_post( wpautop( $description ) ) ); ?></div>
			<?php } ?>

		</div>

		<?php if ( !empty( $url ) ) { ?>
			<?php if ( !empty( $link_type ) && $link_type == 'text' ) { ?>
				<div class="cta-link cta-textlink more-link">
					<a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $button_text ); ?></a>
				</div>
			<?php } else { ?>
				<div class="cta-link cta-buttonlink">
					<a href="<?php echo esc_url( $url ); ?>" <?php hoot_attr( 'cta-button', 'widget', 'button button-medium border-box ' ); ?>><?php echo esc_html( $button_text ); ?></a>
				</div>
			<?php } ?>
		<?php } ?>

	</div>
</div>