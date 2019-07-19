<?php
/**
 * Helper functions for HootKit
 * Limited library available for all active installations (non-conditional)
 *
 * @package           Hootkit
 * @subpackage        Hootkit/include
 * 
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}


/**
 * Reorder menu items
 * Need to find a better home for this function in the plugin structure
 *
 * @since 1.0.3
 * @access public
 * @param array $attr
 * @param string $context
 * @return array
 */
function hootkit_reorder_custom_options_page() {
	global $submenu;
	$themelist = hootkit()->get_config( 'themelist' );
	foreach ( $themelist as &$tlval )
		$tlval = $tlval . '-welcome';
	$indexes = array();
	if ( !isset( $submenu['themes.php'] ) )
		return;
	foreach ( $submenu['themes.php'] as $key => $sm ) {
		if ( $sm[2] == 'tgmpa-install-plugins' ) {
			$indexes[] = $key; break;
	} }
	foreach ( $submenu['themes.php'] as $key => $sm ) {
		if ( $sm[2] == 'hootkit-content-install' ) {
			$indexes[] = $key; break;
	} }
	foreach ( $submenu['themes.php'] as $key => $sm ) {
		if ( in_array( $sm[2], $themelist ) ) {
			$indexes[] = $key; break;
	} }

	foreach ( $indexes as $index ) { if ( ! empty( $index ) ) {
		//$item = $submenu['themes.php'][ $index ];
		//unset( $submenu['themes.php'][ $index ] );
		//array_splice( $submenu['themes.php'], 1, 0, array($item) );
		/* array_splice does not preserve numeric keys, so instead we do our own rearranging. */
		$smthemes = array();
		foreach ( $submenu['themes.php'] as $key => $sm ) {
			if ( $key != $index ) {
				$setkey = $key;
				// Find next available position if current one is taken
				for ( $i = $key; $i < 1000; $i++ ) {
					if( !isset( $smthemes[$i] ) ) {
						$setkey = $i;
						break;
					}
				}
				$smthemes[ $setkey ] = $sm;
				if ( $sm[1] == 'customize' ) { // if ( $sm[2] == 'themes.php' ) {
					$smthemes[ $setkey + 1 ] = $submenu['themes.php'][ $index ];
				}
			}
		}
		$submenu['themes.php'] = $smthemes;
	} }

}
add_action( 'admin_menu', 'hootkit_reorder_custom_options_page', 9990 );