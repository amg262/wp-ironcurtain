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
		<span><img src="<?php echo plugins_url( 'cage.gif', __FILE__ ); ?>" alt="cage"/></span>
	</div>
	</p>

	<?php
}