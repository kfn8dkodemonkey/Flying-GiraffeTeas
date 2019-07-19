<?php
// Return if no message to show
if ( empty( $message ) && empty ( $icon ) )
	return;

if ( $background || $fontcolor ) {
	$styleclass = 'announce-userstyle';
	$inlinestyle = ' style="';
	$inlinestyle .= ( $background ) ? 'background:' . sanitize_hex_color( $background ) . ';' : '';
	$inlinestyle .= ( $fontcolor ) ? 'color:' . sanitize_hex_color( $fontcolor ) . ';' : '';
	$inlinestyle .= '" ';
} else $inlinestyle = $styleclass = '';
$styleclass .= ( $background ) ? ' announce-withbg' : '';
$styleclass .= ( !$message ) ? ' announce-nomsg' : '';
$styleclass .= ( !$icon ) ? ' announce-noicon' : '';
if ( $iconcolor ) {
	$iconclass = ' icon-userstyle';
	$iconstyle = ' style="color:' . sanitize_hex_color( $iconcolor ) . ';"';
} else $iconstyle = $iconclass = '';
?>

<div class="announce-widget <?php echo $styleclass; ?>" <?php echo $inlinestyle;?>>
	<?php if ( !empty( $url ) ) echo '<a href="' . esc_url( $url ) . '" ' . hoot_get_attr( 'announce-link' ) . '><span>' . __( 'Click Here', 'hootkit' ) . '</span></a>'; ?>
	<div class="announce-box table">
		<?php if ( !empty( $icon ) ) : ?>
			<div class="announce-box-icon table-cell-mid"><i class="<?php echo hoot_sanitize_fa( $icon ) . $iconclass; ?>"<?php echo $iconstyle ?>></i></div>
		<?php endif; ?>
		<?php if ( !empty( $message ) ) : ?>
			<div class="announce-box-content table-cell-mid">
				<?php echo do_shortcode( wp_kses_post( $message ) ); ?>
			</div>
		<?php endif; ?>
	</div>
</div>