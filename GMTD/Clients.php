<?php

/*
*
* @package Give me that data 
* Text Domain: GMTD 
*
*/

namespace GMTD;

if ( ! class_exists( 'Clients' ) ) {
	return null;
}

class Clients
{
		function __construct()
		{
			add_action( 'init', [ $this, 'client_register_post_type' ] );
		}

		function client_register_post_type() 
		{
			$singular = __( 'Client' );
			$plural = __( 'Clients' );

		  	$plural_slug = __('client');
		 
			$labels = array(
				'name' 					=> $plural,
				'singular_name' 		=> $singular,
				'add_new' 				=> 'Add New',
				'add_new_item' 			=> 'Add New ' . $singular,
				'edit'		        	=> 'Edit',
				'edit_item'	        	=> 'Edit ' . $singular,
				'new_item'	        	=> 'New ' . $singular,
				'view' 					=> 'View ' . $singular,
				'view_item' 			=> 'View ' . $singular,
				'search_term'   		=> 'Search ' . $plural,
				'parent' 				=> 'Parent ' . $singular,
				'not_found' 			=> 'No ' . $plural .' found',
				'not_found_in_trash' 	=> 'No ' . $plural .' in Trash'
			);
		  
		  	//Define all the arguments for this post type.
			$args = array(
				'labels' 			  => $labels,
				'public'              => false,
			    'publicly_queryable'  => false,
			    'exclude_from_search' => true,
			    'show_in_nav_menus'   => true,
			    'show_ui'             => true,
			    'show_in_menu'        => true,
			    'show_in_admin_bar'   => true,
			    'menu_position'       => 6,
			    'menu_icon'           => 'dashicons-universal-access',
			    'can_export'          => true,
			    'delete_with_user'    => false,
			    'hierarchical'        => false,
			    'has_archive'         => true,
			    'query_var'           => true,
			    'capability_type'     => 'page',
			    'map_meta_cap'        => true,
			    'rewrite'             => array(
			    	'slug' => strtolower( $plural_slug ),
			    	'with_front' => true,
			    	'pages' => true,
			    	'feeds' => false,
			    ),
			    'supports'            => array(
			    	'title',
						//'thumbnail'
			    )
			);
		        //Create the post type using the above two varaiables.
			register_post_type( 'client', $args);
		}
}