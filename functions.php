<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Genesis UCI Theme' );
define( 'CHILD_THEME_URL', 'http://sites.uci.edu/' );
define( 'CHILD_THEME_VERSION', '1.0.1' );

//* Enqueue custom assets
add_action( 'wp_enqueue_scripts', 'custom_assets' );
function custom_assets() {
	wp_enqueue_script( 'genesis-uci-menu-toggle', get_stylesheet_directory_uri().'/js/genesis-uci-menu-toggle.js', array('jquery'), CHILD_THEME_VERSION, true );
	wp_enqueue_style( 'font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css', array(), '4.0.3' );
	//wp_enqueue_style( 'asset-handle', 'asset-uri', array('depencies'), CHILD_THEME_VERSION );
}

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for 4-column footer widgets
add_theme_support( 'genesis-footer-widgets', 4 );

//* Use standard WordPress search because the Genesis variant isn't accessible
remove_filter( 'get_search_form', 'genesis_search_form' );


//* UCI theme customizations
require_once('functions_post_title.php');
require_once('functions_menu_levels.php');
require_once('functions_widget_title.php');
require_once('functions_logo.php');
require_once('functions_site_description.php');
require_once('functions_footer_credits.php');
require_once('functions_contact_widget.php');
require_once('fucntions_social_media_list_widget.php');
require_once('functions_featured_image.php');
require_once('functions_footer_widget_always_display.php');


