<?php

/**
 * Customize the footer credits area
 */
remove_action( 'genesis_footer', 'genesis_do_footer' );
add_action( 'genesis_footer', 'uci_genesis_footer' );
function uci_genesis_footer() {
	
	$output = '<p>[footer_copyright] UC Regents</p>';
	echo apply_filters( 'genesis_footer_output', $output );

}

?>