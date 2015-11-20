<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


// profile templates
function pp_pc_register_template_location() {
    return PP_PC_DIR . '/templates/';
}

function pp_pc_template_start() {

    if( function_exists( 'bp_register_template_stack' ) )
        bp_register_template_stack( 'pp_pc_register_template_location' );

}
add_action( 'bp_init', 'pp_pc_template_start' );

