<?php// Scheduled Action Hook

var_dump(wp_get_scheduled_event('cron_name'));

function cron_name( $param1 = 'cron_args' ) {

	$opts = get_option( 'wcb_settings' );
	$data = get_option( 'wcb_data' );

	if ( file_exists( __DIR__ . '/tmp' ) ) {
		unlink( __DIR__ . '/tmp' );

		update_option( 'wcb_data', 'on' );

	} else {
		update_option( 'wcb_data', 'off' );

	}
}
add_action( 'cron_name', 'cron_name' );

// Schedule Cron Job Event
function custom_cron_job() {

	$opts = get_option( 'wcb_settings' );

	$num = $opts['number_input2'];
	if ( ! wp_next_scheduled( 'cron_name' ) ) {
		wp_schedule_event( current_time( 'timestamp' ), 'hourly', 'cron_name', array( 'cron_args' ) );
	}
}
add_action( 'wp', 'custom_cron_job' );
var_dump(wp_get_scheduled_event('cron_name'));
