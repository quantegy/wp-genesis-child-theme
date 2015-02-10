<?php

/**
 * Strip h4 tags from widget titles
 */
add_filter( 'dynamic_sidebar_params', 'uci_genesis_wrap_widget_titles', 20 );
function uci_genesis_wrap_widget_titles( array $params ) {

	$params[0]['before_title'] = '<header class="widget-title widgettitle"><h2>';
	$params[0]['after_title'] = '</h2></header>';

	return $params;
}

?>