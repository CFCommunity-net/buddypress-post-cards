<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

function pp_pc_create_postcard() {
	
	if( bp_is_my_profile() || is_super_admin() )
		$sender_id = bp_displayed_user_id();
	else {
		bp_core_add_message( __( 'Please use your own profile to create or edit Events.', 'bp-simple-events' ), 'error' );
		return;
	}

	if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['pc_creator'] ) &&  $_POST['pc_creator'] == "2") {
	
		require( PP_PC_DIR . '/lob/vendor/autoload.php' );
		
		$lob = new \Lob\Lob('test_d9621a2ff5985fcb7654ad9d9c500a32151');
		
		$to_address = $lob->addresses()->create(array(
		  'name'            => $_POST['pc_to_name'],
		  'address_line1'   => $_POST['pc_to_address'],
		  'address_line2'   => '',
		  'address_city'    => $_POST['pc_to_city'],
		  'address_state'   => $_POST['pc_to_state'],
		  'address_zip'     => $_POST['pc_to_zip'],
		  'address_country' => $_POST['pc_from_country']
		));
		$from_address = $lob->addresses()->create(array(
		  'name'            => $_POST['pc_from_name'],
		  'address_line1'   => $_POST['pc_from_address'],
		  'address_line2'   => '',
		  'address_city'    => $_POST['pc_from_city'],
		  'address_state'   => $_POST['pc_from_state'],
		  'address_zip'     => $_POST['pc_from_zip'],
		  'address_country' => $_POST['pc_from_country']
		));
		$postcard = $lob->postcards()->create(array(
		  'to'      => $to_address['id'],
		  'from'    => $from_address['id'],
		  'message' => stripslashes( $_POST['pc_message'] ),
		  'front'   => 'https://lob.com/postcardfront.pdf',
		  //'back'    => 'https://lob.com/postcardback.pdf' // not used if message field is present
		//Optional Parameters
		//'template' => 1 // set to 1 if you are customizing the back of the postcard (defaults to 0)
		//'full_bleed' => 1 // set to 1 to allow use of the 1/8 inch border around postcard (defaults to 0)
		));
				
		print_r($postcard);
		
		//echo '<br>after $postcard response';
				
				
	
	}

}
add_action( 'pp_pc_after_create_postcard', 'pp_pc_create_postcard' );