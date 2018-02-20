<?php
/*
* Plugin Name: Give me that data
* Author: Michael Espiritu
* Author URI: 
* Description: Lead Generation plugin
* Version: 1.0
*
*
* Text Domain: GMTD
*
*/

//Exit if access directly
if( !defined('ABSPATH') )
{
  exit;
}


if( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) )
{
	require_once dirname( __FILE__ ) . '/vendor/autoload.php' ;
}

use GMTD\Clients;
use GMTD\Activate;
use GMTD\Shortcode;
use GMTD\AdminColumn;
use GMTD\MetaboxAndFields;


$Clients = new Clients();
$Activate = new Activate();
$Shortcode = new Shortcode();
$AdminColumn = new AdminColumn();
$MetaboxAndFields = new MetaboxAndFields();


function client_plugin_deactivate()
{

  flush_rewrite_rules();

}

register_deactivation_hook( __FILE__, 'client_plugin_deactivate' );
