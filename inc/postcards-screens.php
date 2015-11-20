<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;



function pp_pc_profile() {
	add_action( 'bp_template_content', 'pp_pc_profile_screen' );
	bp_core_load_template( 'members/single/plugins' );
}


function pp_pc_profile_screen() {
	bp_get_template_part('members/single/profile-postcards-loop');
}


function pp_pc_profile_create() {
	//require( PP_PC_DIR . '/inc/pp-pc-create-class.php' );
	//add_action( 'bp_template_title', 'pp_pc_profile_create_title' );
	add_action( 'bp_template_content', 'pp_pc_profile_create_screen' );
	bp_core_load_template( 'members/single/plugins' );
}

function pp_pc_profile_create_title() {

	echo __( 'Create a Postcard', 'postcards' );
}


function pp_pc_profile_create_screen() {
	
	if( ! isset( $_GET['pc_nonce'] ) || ! wp_verify_nonce( $_GET['pc_nonce'], 'pc_create') )
		echo 'Came here from Postcards > Create on my profile.<br>How should this case be handled?<br>Should there even be a Create link?';
	else
		bp_get_template_part('members/single/profile-postcards-create');
}


function pp_pc_profile_enqueue() {

	if ( ( bp_is_my_profile() || is_super_admin() ) && 'create' == bp_current_action() && 'postcards' == bp_current_component() ) {

		wp_enqueue_style( 'pc-styles',  plugins_url('/css/postcards.css',__FILE__)  , array() );
		wp_enqueue_script('pc-script', plugin_dir_url(__FILE__) . '/js/postcards.js', array('jquery'));

	}
}
add_action('wp_enqueue_scripts', 'pp_pc_profile_enqueue');

