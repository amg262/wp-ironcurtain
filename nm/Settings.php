<?php

/**
 * WordPress settings API demo class
 *
 * @author Tareq Hasan
 */


class Settings {

	private $settings_api;

	function __construct() {

		require __DIR__ . '/SettingsAPI.php';
		$this->settings_api = new SettingsAPI();

		add_action( 'admin_init', [ $this, 'admin_init' ] );
		add_action( 'admin_menu', [ $this, 'admin_menu' ] );
	}

	function admin_init() {

		//set the settings
		$this->settings_api->set_sections( $this->get_settings_sections() );
		$this->settings_api->set_fields( $this->get_settings_fields() );

		//initialize settings
		$this->settings_api->admin_init();

	}

	function get_settings_sections() {

		$sections = [
			[
				'id'    => 'wcb_settings',
				'title' => __( 'Basic Settings', 'wedevs' ),
			],
			[
				'id'    => 'wcb_advanced',
				'title' => __( 'Advanced Settings', 'wedevs' ),
			],
			[
				'id'    => 'wcb_others',
				'title' => __( 'Other Settings', 'wpuf' ),
			],
		];

		return $sections;
	}

	/**
	 * Returns all the settings fields
	 *
	 * @return array settings fields
	 */
	function get_settings_fields() {

		//var_dump( get_option( 'wcb_settings' ) );

		$opt = get_option( 'wcb_settings' );

		$key             = ( $opt['key2'] !== '' ) ? $opt['key2'] : 'stalin';
		$settings_fields = [
			'wcb_settings' => [

				[
					'name'    => 'key2',
					'label'   => __( 'Secret Key', 'wedevs' ),
					'desc'    => __( '<i>http://rbrvs.net/?cloak=on&<b>key=</b> *this field </i>', 'wedevs' ),
					'type'    => 'text',
					'default' => $key,
					//'sanitize_callback' => 'intval',
				],

				[
					'name'    => 'radio',
					'label'   => __( 'Enable Cloak on Log Out', 'wedevs' ),
					'desc'    => __( 'Enable Cloak on Log Out', 'wedevs' ),
					'type'    => 'radio',
					'options' => [
						'yes' => 'Yes',
						'no'  => 'No',
					],
				],

				[
					'name'    => 'email',
					'label'   => __( 'Set emails to get update notifications', 'wedevs' ),
					'desc'    => __( '', 'wedevs' ),
					'type'    => 'text',
					'default' => 'andrewmgunn26@gmail.com',
					//'sanitize_callback' => 'intval',
				],
				[
					'name'    => 'ip',
					'label'   => __( 'Show IP', 'wedevs' ),
					'desc'    => __( '', 'wedevs' ),
					'type'    => 'radio',
					'options' => [
						'yes' => 'Yes',
						'no'  => 'No',
					],
				],
				[
					'name'    => 'css',
					'label'   => __( 'CSS', 'wedevs' ),
					'desc'    => __( 'WP_Editor description', 'wedevs' ),
					'type'    => 'wysiwyg',
					'default' => '',
				],
				[
					'name'    => 'html',
					'label'   => __( 'HTML', 'wedevs' ),
					'desc'    => __( '', 'wedevs' ),
					'type'    => 'wysiwyg',
					'default' => '',
				],


			],
			'wcb_advanced' => [
				[
					'name'    => 'notify',
					'label'   => __( 'Email status change update', 'wedevs' ),
					'desc'    => __( 'DO it', 'wedevs' ),
					'type'    => 'radio',
					'default' => 'No',

					'options' => [
						'yes' => 'Yes',
						'no'  => 'No',
					],
				],
				[
					'name'    => 'email',
					'label'   => __( 'Set emails to get update notifications', 'wedevs' ),
					'desc'    => __( '', 'wedevs' ),
					'type'    => 'text',
					'default' => 'andrewmgunn26@gmail.com',
					//'sanitize_callback' => 'intval',
				],
				[
					'name'    => 'wysiwyg',
					'label'   => __( 'Advanced Editor', 'wedevs' ),
					'desc'    => __( 'WP_Editor description', 'wedevs' ),
					'type'    => 'wysiwyg',
					'default' => '',
				],
				[
					'name'    => 'multicheck',
					'label'   => __( 'Multile checkbox', 'wedevs' ),
					'desc'    => __( 'Multi checkbox description', 'wedevs' ),
					'type'    => 'multicheck',
					'default' => [ 'one' => 'one', 'four' => 'four' ],
					'options' => [
						'one'   => 'One',
						'two'   => 'Two',
						'three' => 'Three',
						'four'  => 'Four',
					],
				],
				[
					'name'    => 'selectbox',
					'label'   => __( 'A Dropdown', 'wedevs' ),
					'desc'    => __( 'Dropdown description', 'wedevs' ),
					'type'    => 'select',
					'options' => [
						'yes' => 'Yes',
						'no'  => 'No',
					],
				],
				[
					'name'    => 'password',
					'label'   => __( 'Password', 'wedevs' ),
					'desc'    => __( 'Password description', 'wedevs' ),
					'type'    => 'password',
					'default' => '',
				],
				[
					'name'    => 'file',
					'label'   => __( 'File', 'wedevs' ),
					'desc'    => __( 'File description', 'wedevs' ),
					'type'    => 'file',
					'default' => '',
				],

			],
		];

		return $settings_fields;
	}

	function admin_menu() {

		echo '';
		add_options_page( 'Iron Curtain', 'Iron Curtain', 'manage_options', 'wp-irc-admin', [
			$this,
			'plugin_page',
		] );
	}

	function plugin_page() {

		echo '<div class="wrap">';

		$this->settings_api->show_navigation();
		$this->settings_api->show_forms();

		echo '</div>';
	}

	/**
	 * Get all the pages
	 *
	 * @return array page names with key value pairs
	 */
	function get_pages() {

		$pages         = get_pages();
		$pages_options = [];
		if ( $pages ) {
			foreach ( $pages as $page ) {
				$pages_options[ $page->ID ] = $page->post_title;
			}
		}

		return $pages_options;
	}

}
