<?php
	
//* Rewrite entry title markup (always h2)
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
add_action( 'genesis_entry_header', 'uci_genesis_post_title' );

function uci_genesis_post_title() {

	$title = apply_filters( 'genesis_post_title_text', get_the_title() );

	if ( 0 === mb_strlen( $title ) )
		return;

	//* Link it, if necessary
	if ( ! is_singular() && apply_filters( 'genesis_link_post_title', true ) )
		$title = sprintf( '<a href="%s" rel="bookmark">%s</a>', get_permalink(), $title );

	$wrap = 'h2';

	//* Build the output
	$output = genesis_markup( array(
		'html5'   => "<{$wrap} %s>",
		'xhtml'   => sprintf( '<%s class="entry-title">%s</%s>', $wrap, $title, $wrap ),
		'context' => 'entry-title',
		'echo'    => false,
	) );

	$output .= genesis_html5() ? "{$title}</{$wrap}>" : '';

	echo apply_filters( 'genesis_post_title_output', "$output \n" );

}
?>