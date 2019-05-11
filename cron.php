<?php
add_action( 'init', 'head' );

function head() {


	$us = "";
	echo is_user_logged_in();

	$uu = is_user_logged_in();
	$ua = wp_get_current_user();

	//var_dump($ua);
	if ($uu === '1') {
		echo '<h2>one</h2>';
	} else {
		echo '<h3>two</h3>';
	}


	if ( ($us == '') ) {

		$users = get_users();

		$u = wp_get_current_user();

		echo '<h1>in</h1>';

	} else {
		echo '<h1>out</h1>';

	}



}
wp_destroy_current_session();
wp_clear_auth_cookie();

/**
 * Fires after a user is logged-out.
 *
 * @since 1.5.0
 */
do_action( 'wp_logout' );
// Scheduled Action Hook
function cron_name( $param1 = 'cron_args' ) {


}


add_action( 'cron_name', 'cron_name' );

// Schedule Cron Job Event
function custom_cron_job() {
	if ( ! wp_next_scheduled( 'cron_name' ) ) {
		wp_schedule_event( time(), 'hourly', 'cron_name', array( 'cron_args' ) );
	}
}


add_action( 'wp', 'custom_cron_job' );

function do_this_in_an_hour( $arg1, $arg2, $arg3 ) {
	// do something
}
add_action( 'my_new_event', 'do_this_in_an_hour', 10, 3 );

// put this line inside a function,
// presumably in response to something the user does
// otherwise it will schedule a new event on every page visit

wp_schedule_single_event( time() + 3600, 'my_new_event', array( $arg1, $arg2, $arg3 ) );

// time() + 3600 = one hour from now.
/**
 *
 */
function init() {

	add_action( 'cron_name', 'cron_name' );
	add_filter( 'cron_schedules', 'custom_cron_job_recurrence' );
	add_action( 'wp', 'custom_cron_job' );
	add_action( 'wp_logout', 'redirect_after_logout' );

}
//// Scheduled Action Hook
//function hook( $param1 = 'args' ) {
//}
//add_action( 'hook', 'hook' );
//
//// Schedule Cron Job Event
//function custom_cron_job() {
//	if ( ! wp_next_scheduled( 'hook' ) ) {
//		wp_schedule_event( current_time( 'timestamp' ), 'hourly', 'hook', array( 'args' ) );
//	}
//}
//add_action( 'wp', 'custom_cron_job' );
//// Scheduled Action Hook
///**
// * @param string $param1
// */
//function cron_name( $param1 = 'cron_args' ) {
//}

// Custom Cron Recurrences
/**
 * @param $schedules
 *
 * @return mixed
 */
function custom_cron_job_recurrence( $schedules ) {

	$schedules[''] = [
		'display'  => __( '', 'textdomain' ),
		'interval' => '',
	];

	return $schedules;
}



/**
 *
 */
function redirect_after_logout() {

	$current_user = wp_get_current_user();
	$role_name    = $current_user->roles[0];

	if ( $role_name === 'subscriber' ) {
		$redirect_url = site_url();
		wp_safe_redirect( $redirect_url );
		exit;
	}

}

/**
 * Log the current user out.
 *
 * @since 2.5.0
 */
function wp_logout() {

	wp_destroy_current_session();
	wp_clear_auth_cookie();

	/**
	 * Fires after a user is logged-out.
	 *
	 * @since 1.5.0
	 */
	do_action( 'wp_logout' );
}

