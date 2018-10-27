<?php
// If uninstall not called from WordPress exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
  exit();

delete_option( 'bom_example_setting' );
/*

public function delete_options() {
	$sections = [
		'wpb_settings',
		'wpb_advanced',
		'wpb_others',
		'wpb_io',
		'wpb_support',
		'wp_bom',
		'wp_bom_data',
	];

	foreach ( $sections as $val ) {
		delete_option( $val );

	}
}

public function delete_posts( $options ) {

	$i = 0;
	$j = 0;

	$defaults = [
		'on'    => true,
		'types' => [ 'part', 'assembly', 'requisition' ],
		//'taxs'  => [ 'item-category', 'item-tag', 'vendor', 'requisition-type' ],
	];
	$args = wp_parse_args( $options, $defaults );
	$types = $args['types'];

	foreach ( $types as $type ) {

		$posts_array = get_posts( [ 'posts_per_page' => - 1, 'post_type' => $type, ] );

		foreach ( $posts_array as $post ) {
			wp_delete_post( $post->ID );
			$i ++;
		}
	}
	return $i;
}



public function delete_db() {
	global $wpdb;

	$table_name = $wpdb->prefix . WP_BOM_VERSION;

	//$q = "SELECT * FROM " . $table_name . " WHERE id > 0  ;";
	$wpdb->query( "DROP TABLE IF EXISTS $table_name ;" );
}