<?php

/**
 * Wrap site description in <p>
 * Removes the <h1> and <h2> options offered in Genesis
 */

remove_action( 'genesis_site_description', 'genesis_seo_site_description' );
add_action( 'genesis_site_description', 'uci_genesis_site_description' );
function uci_genesis_site_description() {

	//* Set what goes inside the wrapping tags
	$inside = esc_html( get_bloginfo( 'description' ) );

	//* Determine which wrapping tags to use
	$wrap = 'p';

	//* Build the description
	$description  = genesis_html5() ? sprintf( "<{$wrap} %s>", genesis_attr( 'site-description' ) ) : sprintf( '<%s id="description">%s</%s>', $wrap, $inside, $wrap );
	$description .= genesis_html5() ? "{$inside}</{$wrap}>" : '';

	//* Output (filtered)
	$output = $inside ? apply_filters( 'uci_genesis_site_description', $description, $inside, $wrap ) : '';

	echo $output;

}

?>