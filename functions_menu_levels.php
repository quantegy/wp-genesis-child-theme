<?php

/**
 * Restrict menu nesting
 */
function uci_header_menu_args( $args ) {
	if ( 'primary' !== $args['theme_location'] && 'secondary' !== $args['theme_location'] ) {
		$args['depth'] = 1;
	} else {
		$args['depth'] = 2;
	}
  
	return $args;
}
add_filter( 'wp_nav_menu_args', 'uci_header_menu_args' );

?>