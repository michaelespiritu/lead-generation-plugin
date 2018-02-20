<?php

/*
*
* @package Give me that data 
* Text Domain: GMTD 
*
*/

namespace GMTD;

if ( ! class_exists( 'AdminColumn' ) ) {
	return null;
}

class AdminColumn{

  function __construct(){

    add_filter('manage_client_posts_columns' , [ $this , 'add_sticky_column' ] );
    add_action( 'manage_client_posts_custom_column' , [ $this , 'display_posts_stickiness' ], 10 , 2 );

  }


  function add_sticky_column($columns) {

    $cols = [
        'title' => __('Name', 'GMTD'),
        'email' => __('Email', 'GMTD'),
        'date' => __('Date Created', 'GMTD'),
      ];

      return $cols;


  }



  function display_posts_stickiness( $column, $post_id ) {

      $client_stored_meta = get_post_meta( $post_id );

      switch ($column) {

        case 'email':

            if( !empty( $client_stored_meta['client_email'][0] ) ){

              echo $client_stored_meta['client_email'][0];

            }

          break;

        case 'date':

            if( !empty( $casa_stored_meta['client_timedate'][0] ) ){

              echo $casa_stored_meta['client_timedate'][0];

            }

          break;

        default:
          # code...
          break;
      }

  }

}