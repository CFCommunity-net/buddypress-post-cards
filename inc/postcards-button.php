<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


function pp_pc_button_create( $target_id, $action ) {
	
	return apply_filters( 'pp_pc_button_create',
		bp_get_button( apply_filters( 'pp_pc_button_create_args', array(
			'id'                => 'create_postcard',
			'component'         => 'postcards',
			'must_be_logged_in' => true,
			'block_self'        => true,
			'wrapper_id'        => 'send-postcard',
			'link_href'         => pp_pc_button_link( $target_id, $action ),
			'link_title'        => __( 'Send a Postcard to this member.', 'postcards' ),
			'link_text'         => __( 'Send a Postcard', 'postcards' ),
			'link_class'        => 'send-postcard no-ajax',
		) ) )
	);	
	
}

function pp_pc_button_link( $target_id, $action ) {
	
	return apply_filters( 'pp_pc_button_link', wp_nonce_url( bp_loggedin_user_domain() . 'postcards/create/?r=' . $target_id, 'pc_create', 'pc_nonce' ) );	

}
		
function pp_pc_button() {

	if ( bp_is_my_profile() || ! is_user_logged_in() )
		return; 

	$target_id = bp_displayed_user_id();

	echo pp_pc_button_create( $target_id, 'create-postcard' );
}
add_action( 'bp_member_header_actions', 'pp_pc_button', 55 );  //use 55 so button is last

