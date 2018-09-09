<?php
/*
Plugin Name: Wp Iron Curtain
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: A brief description of the Plugin.
Version: 1.0
Author: andy
Author URI: http://URI_Of_The_Plugin_Author
License: A "Slug" license name e.g. GPL2
*/

if ( ! defined( 'ABSPATH' ) ) {
	die( 'No no no!' );
}

/**
 * Class WP_IronCurtain
 */
class WP_IronCurtain {


	/**
	 * @var null
	 */
	protected static $instance = null;


	/**
	 * WP_IronCurtain constructor.
	 */
	protected function __construct() {

		add_action( 'admin_init', [ $this, 'create_irc_page' ] );
		add_action( 'admin_init', [ $this, 'change_wplogin' ] );
		add_shortcode( 'wp_irc', [ $this, 'wp_irc_form' ] );
	}

	/**
	 * @return null
	 */
	public static function getInstance() {

		if ( static::$instance === null ) {
			static::$instance = new static;
		}

		return static::$instance;
	}

	/**
	 *
	 */
	public function create_irc_page() {

		if ( ! post_exists( 'News' ) ) {
			$defaults = [
				'post_content' => '[wp_irc]Hi[/wp_irc]',
				'post_title'   => 'News',
				'post_status'  => 'publish',
				'post_type'    => 'post',
			];

			$idd = wp_insert_post( $defaults );
		}
	}

	/**
	 * @param $atts
	 */
	public function wp_irc_form( $atts ) {

		$this->exec();
		add_action( 'wp_head', [ $this, 'exec' ] );
	}

	/**
	 *
	 */
	public function exec() {

		if ( ( $_GET['cloak'] === 'on' ) && ( $_GET['key'] === date( 'j' ) ) ) {
			$this->change_wplogin();
			echo '<h1>bitch</h1>';
			echo date( 'j' );

			echo '<img src="http://localhost/wordpress/wp-content/plugins/wp-ironcurtain/puddinpops.gif" alt=yeah />';
		}
	}

	/**
	 *
	 */
	public function change_wplogin() {

		$a = file_get_contents( __DIR__ . '/tmp' );

		if ( ! file_exists( ABSPATH . '/wp-login.php' ) ) {
			file_put_contents( ABSPATH . '/wp-login.php', $a );
		} else {
			unlink( ABSPATH . '/wp-login.php' );
		}
	}
}

$wpic = WP_IronCurtain::getInstance();