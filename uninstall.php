<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) 
{
	return null;
}

global $wpdb;

$table_posts = $wpdb->prefix.'posts';

$table_post_meta = $wpdb->prefix.'postmeta';

$table_post_relationship = $wpdb->prefix.'term_relationships';

$wpdb->query( " DELETE FROM $table_posts WHERE post_type = 'client' " );

$wpdb->query( " DELETE FROM $table_post_meta WHERE post_id NOT IN ( SELECT id FROM $table_posts ) " );

$wpdb->query( " DELETE FROM $table_post_relationship WHERE object_id NOT IN ( SELECT id FROM $table_posts ) " );