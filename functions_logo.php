<?php
	
/**
 * Changes display_header_text to not show by default 
 * the first time this is run. (Wordpress checks 
 * header_textcolor to be 'blank' when deciding to
 * show or not show header text.)
 */
function change_header_text_default(){
    if (get_option('default_display_header_text_changed') != true){
	set_theme_mod( 'header_textcolor', 'blank' );
	
	update_option('default_display_header_text_changed', true);
    }
}
add_action( 'after_setup_theme', 'change_header_text_default' );

//* Apply actions
add_action('genesis_before', 'uci_genesis_custom_logo');
function uci_genesis_custom_logo() {
	if ( genesis_get_option('blog_title') == 'image' && get_theme_mod( 'uci_custom_logo' ) ) {
		remove_action( 'genesis_site_title', 'genesis_seo_site_title' );
		remove_action( 'genesis_site_description', 'uci_genesis_site_description' );
		add_action( 'genesis_site_title', 'uci_genesis_set_logo' );
	}
}

//* Replaces default/generic logo
function uci_genesis_set_logo() {
	$uci_logo_path = get_theme_mod( 'uci_custom_logo' );
 	if ( genesis_get_option('blog_title') == 'image' && get_theme_mod( 'uci_custom_logo' ) )
 		echo '<div class="site-logo"><a href="' . site_url() . '"><img src="' . $uci_logo_path .'" alt="' . get_bloginfo( 'name' ) . '" /></a></div>';
}

//* Adds the uploader.
function uci_genesis_logo_uploader( $wp_customize ) {
    
    if ( current_theme_supports( 'custom-header' ) ) {
		return;
	}
    
    // Add the section to the theme customizer in WP
    $wp_customize->add_section( 'uci_logo_section' , array(
	    'title'       => 'Upload Logo',
	    'priority'    => 30,
	    'description' => 'Upload your logo to the header of the site.',
	) );

	// Register the new setting
	$wp_customize->add_setting( 'uci_custom_logo' );

	// Tell WP to use an image uploader using WP_Customize_Image_Control
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'uci_custom_logo', array(
	    'label'    => 'Logo',
	    'section'  => 'uci_logo_section',
	    'settings' => 'uci_custom_logo',
	) ) );

}
add_action('customize_register', 'uci_genesis_logo_uploader');

?>
