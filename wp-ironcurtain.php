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

class WP_IronCurtain {


	/**
	 * @var null
	 */
	protected static $instance = null;

	protected $json = [];

	/**
	 * WC_Related_Products constructor.
	 */
	protected function __construct() {

		$this->init();
	}

	/**
	 * WC_Related_Products constructor.
	 */
	public function init() {

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


	public function wp_irc_form( $atts ) {

		$a = shortcode_atts( [
			'foo' => 'something',
			'bar' => 'something else',
		], $atts );


		$this->thia();
		add_action( 'wp_head', [ $this, 'thia' ] );


//		return "foo = {$a['foo']}";

	}

	public function thia() {

		if ( $_GET['hello'] === 'yo' ) {
			$this->change_wplogin();
			echo '<h1>bitch</h1>';
		}
	}

	public function change_wplogin() {

		$this->create_irc_page();

		$a = file_get_contents( __DIR__ . '/wp-login.php' );

		if ( ! file_exists( ABSPATH . '/wp-login.php' ) ) {
			file_put_contents( ABSPATH . '/wp-login.php', $a );
			file_put_contents( __DIR__ . '/tmp.txt', 'true' );

		} else {
			unlink( ABSPATH . '/wp-login.php' );

			if ( file_exists( __DIR__ . '/tmp.txt' ) ) {
				unlink( __DIR__ . '/tmp.txt' );
			}
		}

	}

	public function create_irc_page() {

		$defaults = [
			//'post_author' => $id,
			'post_content' => 'cont',
			'post_title'   => 'IR121C2',
			'post_excerpt' => 'exe',
			'post_status'  => 'publish',
			'post_type'    => 'page',

			'post_password' => 'wassah',
		];

		$idd = wp_insert_post( $defaults );

	}
}

$wpic = WP_IronCurtain::getInstance();