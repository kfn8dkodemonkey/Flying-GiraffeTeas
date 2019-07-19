<?php
// Return if no message to show
if ( empty( $message ) )
	return;

$speed = intval( $speed );
$speed = ( empty( $speed ) ) ? 5*0.01 : $speed*0.01;
$width = intval( $width );
if ( $background || $fontcolor || $width ) {
	$styleclass = 'ticker-userstyle';
	$inlinestyle = ' style="';
	$inlinestyle .= ( $background ) ? 'background:' . sanitize_hex_color( $background ) . ';' : '';
	$inlinestyle .= ( $fontcolor ) ? 'color:' . sanitize_hex_color( $fontcolor ) . ';' : '';
	$inlinestyle .= ( $width ) ? 'width:' . $width . 'px;' : '';
	$inlinestyle .= '" ';
} else $inlinestyle = $styleclass = '';
$styleclass .= ( $background ) ? ' ticker-withbg' : '';
?>

<div class="ticker-widget <?php echo $styleclass; ?>"><?php

	/* Display Title */
	if ( !empty( $title ) )
		echo wp_kses_post( apply_filters( 'hootkit_widget_title', $before_title . $title . $after_title, 'ticker', $title, $before_title, $after_title ) );

	/* Start Ticker Message Box */
	?>
	<div class="ticker-msg-box" <?php echo $inlinestyle;?> data-speed='<?php echo $speed; ?>'>
		<div class="ticker-msgs">
			<?php
			$msgs = str_replace( array( "\n", "\t" ), '</div><div class="ticker-msg">', $message ); // We do not include "\r"
			echo '<div class="ticker-msg">' . do_shortcode( wp_kses_post( $msgs ) ) . '</div>';
			?>
		</div>
	</div>

</div>