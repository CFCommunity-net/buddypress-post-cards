<?php
/*
Plugin Name: BuddyPress PostCards
Description: Creates and sends a physical PostCard
Version: 1.0
Author: shanebp
Author URI: http://philopress.com/
*/

if ( !defined( 'ABSPATH' ) ) exit;

 
function pp_pc_bp_check() {

	if ( !class_exists('BuddyPress') )
		add_action( 'admin_notices', 'pp_pc_install_buddypress_notice' );

}
add_action('plugins_loaded', 'pp_pc_bp_check', 999);

function pp_pc_install_buddypress_notice() {
	echo '<div id="message" class="error fade"><p style="line-height: 150%">';
	_e('<strong>BuddyPress PostCards</strong></a> requires the BuddyPress plugin. Please <a href="http://buddypress.org/download">install BuddyPress</a> first, or <a href="plugins.php">deactivate BuddyPress PostCards</a>.');
	echo '</p></div>';
}

function pp_pc_init() {

	if( ! is_admin() ) {
	
		define( 'PP_PC_DIR', dirname( __FILE__ ) );
	
		load_plugin_textdomain( 'postcards', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	
		require( PP_PC_DIR . '/inc/postcards-core.php' );
	}
}
add_action( 'bp_include', 'pp_pc_init' );

