<?php
/**
 * Created by PhpStorm.
 * User: mint
 * Date: 10/9/18
 * Time: 5:53 PM
 * Template Name: Login Page
 */
$opts = get_option( 'wcb_settings' );


function myplugin_add_login_fields() {

	//Get and set any values already sent
	$user_extra = ( isset( $_POST['user_extra'] ) ) ? $_POST['user_extra'] : '';
	$opts       = get_option( 'wcb_settings' );
	$opts2      = get_option( 'wcb_login' );
	?>

    <div>
        <style>body {
                background: <?php echo $opts2['body'];?>
            }</style>
        <style>.login form {
                background: <?php echo $opts2['login'];?>
            }</style>
        <style>.login form {
                background: <?php echo $opts2['color'];?>
            }</style>
        <style><?php echo $opts2['css']; ?></style>
		<?php echo $opts2['html']; ?>
		<?php echo $opts2['user']; ?>
		<?php if ( in_array( 'ip', $opts2['user'] ) ) {
			echo '<p><h2 id="irc_addr">' . $_SERVER['REMOTE_ADDR'] . '</h2></p>';
		}; ?>
		<?php if ( in_array( 'agent', $opts2['user'] ) ) {
			echo '<p><h6 id="htp_ua">' . $_SERVER['HTTP_USER_AGENT'] . '</h6></p>';
		}; ?>
		<?php echo '<h6>' . $_SERVER['REMOTE_ADDR'] . '</h6>'; ?>

    </div>
    </p>

	<?php
}