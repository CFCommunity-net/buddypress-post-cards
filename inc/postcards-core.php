<?php

if ( ! defined( 'ABSPATH' ) ) exit;


class Postcards_Component extends BP_Component {

	function __construct() {
		global $bp;
		parent::start('postcards',	__('Postcards', 'postcards'), PP_PC_DIR);
		$this->includes();
		$bp->active_components[$this->id] = '1';
	}

	function includes( $includes = array() ) {

		if( ! is_admin() ) {

			$includes = array(
				'inc/postcards-functions.php',
				'inc/postcards-templates.php',
				'inc/postcards-screens.php',
				'inc/postcards-button.php',
			);

		}
		else {
			/*
			$includes = array(
		        'inc/admin/postcards-admin.php',
				'inc/admin/postcards-admin-settings.php',
				'inc/postcards-functions.php',
			);
			*/
		}

		parent::includes( $includes );

	}

	function setup_globals( $args = array() ) {

		$bp = buddypress();

		if ( !defined( 'POSTCARDS_SLUG' ) )
			define( 'POSTCARDS_SLUG', $this->id );

		$globals = array(
			'slug'                  => POSTCARDS_SLUG,
			'root_slug'             => isset( $bp->pages->{$this->id}->slug ) ? $bp->pages->{$this->id}->slug : POSTCARDS_SLUG,
			'has_directory'         => false,
			//'directory_title'       => __( 'Postcards', 'postcards' ),
			//'search_string'         => sprintf(__( 'Search %s...', 'Postcards' ),__('Postcards','postcards')),
		);

		parent::setup_globals( $globals );

	}

	function setup_nav( $main_nav = array(), $sub_nav = array() ) {
		
		if ( bp_displayed_user_domain() ) {
			$user_domain = bp_displayed_user_domain();
		} elseif ( bp_loggedin_user_domain() ) {
			$user_domain = bp_loggedin_user_domain();
		} else {
			return;
		}
		
		$user_has_access = false;
		if( bp_is_my_profile() || is_super_admin() )
			$user_has_access = true;

		//$tab_position = get_option( 'pp_postcards_tab_position' );
		//$count        = pp_postcards_count_profile();
		//$class        = ( 0 === $count ) ? 'no-count' : 'count';


		bp_core_new_nav_item( array(
			'name'                => __( 'Postcards', 'postcards' ),
			'slug'                => 'postcards',
			//'position'            => $tab_position,
			'screen_function'     => 'pp_pc_profile',
			'default_subnav_slug' => 'sent',
			'item_css_id'         => 'member-postcards'
		) );

		bp_core_new_subnav_item( array(
			'name'              => 'Sent',
			'slug'              => 'sent',
			'parent_url'        => trailingslashit( $user_domain . 'postcards' ),
			'parent_slug'       => 'events',
			'screen_function'   => 'pp_pc_profile',
			'position'          => 20,
			'item_css_id'       => 'member-postcards-sent'
			)
		);		
		
		bp_core_new_subnav_item( array(
			'name'              => 'Create',
			'slug'              => 'create',
			'parent_url'        => trailingslashit( $user_domain . 'postcards' ),
			'parent_slug'       => 'postcards',
			'screen_function'   => 'pp_pc_profile_create',
			'position'          => 30,
			'item_css_id'       => 'member-postcards-create',
			'user_has_access'   => $user_has_access
			)
		);		

		parent::setup_nav( $main_nav, $sub_nav );

	}

	function setup_admin_bar( $wp_admin_nav = array() ) {
		$bp = buddypress();

		if ( is_user_logged_in() ) {
			$user_domain = bp_loggedin_user_domain();
			$item_link = trailingslashit( $user_domain . 'postcards' );

			$wp_admin_nav[] = array(
				'parent' => $bp->my_account_menu_id,
				'id'     => 'my-account-postcards',
				'title'  => __( 'Postcards',  'postcards' ),
				'href'   => trailingslashit( $item_link ),
				'meta'   => array( 'class' => 'menupop' )
			);

			// submenu
			$wp_admin_nav[] = array(
				'parent' => 'my-account-postcards',
				'id'     => 'my-account-postcards-sent',
				'title'  => __( 'Sent', 'postcards' ),
				'href'   => trailingslashit( $item_link ) . 'sent'
			);

			// submenu
			$wp_admin_nav[] = array(
				'parent' => 'my-account-postcards',
				'id'     => 'my-account-postcards-create',
				'title'  => __( 'Create', 'postcards' ),
				'href'   => trailingslashit( $item_link ) . 'create'
			);		
		
		}

		parent::setup_admin_bar( $wp_admin_nav );
	}

}
function pp_pc_load_core_component() {
	global $bp;
	$bp->postcards = new Postcards_Component();
}
add_action( 'bp_loaded', 'pp_pc_load_core_component' );