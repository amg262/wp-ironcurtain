<?php

/**
 * WordPress settings API demo class
 *
 * @author Tareq Hasan
 */


class Settings {

	private $settings_api;

	private $wp_irc_settings = [];
	private $cloak = [];
	private $timelimit;


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
				'title' => __( 'Cloak ', 'wedevs' ),
			],
			[
				'id'    => 'wcb_login',
				'title' => __( 'Login Page', 'wedevs' ),
			],
			[
				'id'    => 'wcb_others',
				'title' => __( 'Other Settings', 'wpuf' ),
			],
		];

		return $sections;
	}


	function set_timelimit() {
		$opts = get_option( 'wcb_settings' );

		$this->timelimit = $opts['timelimit'] * HOUR_IN_SECONDS;
		set_transient( 'wcb_timelimit', $this->timelimit, $this->timelimit );

		echo date( 'm/d/y', get_option( '_transient_timeout_wcb_timelimit' ) );

	}

	function get_timelimit() {
		$opts = get_option( 'wcb_settings' );

		if ( $opts['cloak'] === 'On' ) {
			if ( file_exists( __DIR__ . '/tmp' ) ) {
				unlink( __DIR__ . '/tmp' );
			}
		} else {
			file_put_contents( __DIR__ . '/tmp', 'true' );
		}
	}

	/**
	 * Returns all the settings fields
	 *
	 * @return array settings fields
	 */
	function get_settings_fields() {

		$settings_fields = [
			'wcb_settings' => [

				[
					'name'    => 'cloak',
					'label'   => __( 'Cloak Status', 'wedevs' ),
					'desc'    => __( 'Cloak', 'wedevs' ),
					'type'    => 'radio',
					'default' => 'On',
					'options' => [
						'On'  => 'On',
						'Off' => 'Off',
					],
				],
				[
					'name'    => 'key',
					'label'   => __( 'Secret Key', 'wedevs' ),
					'desc'    => __( '<i>http://rbrvs.net/?cloak=on&<b>key=</b> *this field </i>', 'wedevs' ),
					'type'    => 'text',
					'default' => 'stalin',
					//'sanitize_callback' => 'intval',
				],


				[
					'name'  => 'logout',
					'label' => __( 'Logout Action', 'wedevs' ),
					'desc'  => __( 'Enable cloak on logout', 'wedevs' ),
					'type'  => 'radio',
					'default' => 'yes',

					'options' => [
						'yes' => 'Yes',
						'no'  => 'No',
					],
				],
				[
					'name'  => 'Cloak Bypass',
					'label' => __( 'Logout Action', 'wedevs' ),
					'desc'  => __( 'Enable cloak on logout', 'wedevs' ),
					'type'  => 'radio',
					'default' => 'yes',

					'options' => [
						'yes' => 'Yes',
						'no'  => 'No',
					],
				],
				[
					'name'    => 'timelimit',
					'label'   => __( 'Cloak bypass timelimit', 'wedevs' ),
					'desc'    => __( 'Set hours cloak will be bypassed, when time expires automatically enabled', 'wedevs' ),
					'type'    => 'number',
					'default' => '',
				],
				[
					'name'    => 'transient',
					'label'   => __( 'Cloak off for', 'wedevs' ),
					'desc'    => __( 'Set hours for cloak to stay off', 'wedevs' ),
					'type'    => 'text',
					'default' => get_option( '_transient_timeout_wcb_timelimit' ),
					//'sanitize_callback' => 'intval',
				],

			],
			'wcb_login'    => [
				[
					'name'    => 'body',
					'label'   => __( 'Body', 'wedevs' ),
					'desc'    => __( 'Background Color', 'wedevs' ),
					'type'    => 'color',
					'default' => '#f1f1f1',
				],
				[
					'name'    => 'login',
					'label'   => __( 'Login Form', 'wedevs' ),
					'desc'    => __( 'Background Color', 'wedevs' ),
					'type'    => 'color',
					'default' => '#fff',
				],
				[
					'name'    => 'css',
					'label'   => __( 'CSS', 'wedevs' ),
					'desc'    => __( 'CSS styles inserted between <style>  </style> on login error page', 'wedevs' ),
					'type'    => 'wysiwyg',
					'default' => '',
				],
				[
					'name'    => 'html',
					'label'   => __( 'HTML', 'wedevs' ),
					'desc'    => __( 'HTML displayed on login Error page', 'wedevs' ),
					'type'    => 'wysiwyg',
					'default' => '',
				],
				[
					'name'    => 'user',
					'label'   => __( 'Show user info', 'wedevs' ),
					'desc'    => __( 'Multi checkbox description', 'wedevs' ),
					'type'    => 'multicheck',
					'default' => [],
					'options' => [
						'ip'    => 'IP Address',
						'agent' => 'User Agent',
					],
				],
			],

		];
//				[
//					'name'              => 'number_input',
//					'label'             => __( 'Number Input', 'wedevs' ),
//					'desc'              => __( 'Number field with validation callback `intval`', 'wedevs' ),
//					'type'              => 'number',
//					'default'           => 'Title',
//					'sanitize_callback' => 'intval',
//				],
//				[
//					'name'  => 'textarea',
//					'label' => __( 'Textarea Input', 'wedevs' ),
//					'desc'  => __( 'Textarea description', 'wedevs' ),
//					'type'  => 'textarea',
//				],
//				[
//					'name'  => 'checkbox',
//					'label' => __( 'Checkbox', 'wedevs' ),
//					'desc'  => __( 'Checkbox Label', 'wedevs' ),
//					'type'  => 'checkbox',
//				],
//				[
//					'name'    => 'radio',
//					'label'   => __( 'Radio Button', 'wedevs' ),
//					'desc'    => __( 'A radio button', 'wedevs' ),
//					'type'    => 'radio',
//					'options' => [
//						'yes' => 'Yes',
//						'no'  => 'No',
//					],

//				[
//					'name'    => 'selectbox',
//					'label'   => __( 'A Dropdown', 'wedevs' ),
//					'desc'    => __( 'Dropdown description', 'wedevs' ),
//					'type'    => 'select',
//					'default' => 'no',
//					'options' => [
//						//json_encode( $arr )
//						//'yes' => 'Yes',
//						//'no'  => 'No',
//					],
//				],
//				[
//					'name'    => 'password',
//					'label'   => __( 'Password', 'wedevs' ),
//					'desc'    => __( 'Password description', 'wedevs' ),
//					'type'    => 'password',
//					'default' => '',
//				],
//				[
//					'name'    => 'file',
//					'label'   => __( 'File', 'wedevs' ),
//					'desc'    => __( 'File description', 'wedevs' ),
//					'type'    => 'file',
//					'default' => '',
//					'options' => [
//						'button_label' => 'Choose Image',
//					],
//				],
//			],
//				[
//					'name'    => 'color',
//					'label'   => __( 'Color', 'wedevs' ),
//					'desc'    => __( 'Color description', 'wedevs' ),
//					'type'    => 'color',
//					'default' => '',
//				],
//				[
//					'name'    => 'password',
//					'label'   => __( 'Password', 'wedevs' ),
//					'desc'    => __( 'Password description', 'wedevs' ),
//					'type'    => 'password',
//					'default' => '',
//				],

//				[
//					'name'    => 'multicheck',
//					'label'   => __( 'Multile checkbox', 'wedevs' ),
//					'desc'    => __( 'Multi checkbox description', 'wedevs' ),
//					'type'    => 'multicheck',
//					'default' => [ 'one' => 'one', 'four' => 'four' ],
//					'options' => [
//						'one'   => 'One',
//						'two'   => 'Two',
//						'three' => 'Three',
//						'four'  => 'Four',
//					],
//				],
//				[
//					'name'    => 'selectbox',
//					'label'   => __( 'A Dropdown', 'wedevs' ),
//					'desc'    => __( 'Dropdown description', 'wedevs' ),
//					'type'    => 'select',
//					'options' => [
//						'yes' => 'Yes',
//						'no'  => 'No',
//					],
//				],
//				[
//					'name'    => 'password',
//					'label'   => __( 'Password', 'wedevs' ),
//					'desc'    => __( 'Password description', 'wedevs' ),
//					'type'    => 'password',
//					'default' => '',
//				],
//				[
//					'name'    => 'file',
//					'label'   => __( 'File', 'wedevs' ),
//					'desc'    => __( 'File description', 'wedevs' ),
//					'type'    => 'file',
//					'default' => '',
//				],
//			],
//			'wcb_others'   => [
//				[
//					'name'    => 'text',
//					'label'   => __( 'Text Input', 'wedevs' ),
//					'desc'    => __( 'Text input description', 'wedevs' ),
//					'type'    => 'text',
//					'default' => 'Title',
//				],
//				[
//					'name'  => 'textarea',
//					'label' => __( 'Textarea Input', 'wedevs' ),
//					'desc'  => __( 'Textarea description', 'wedevs' ),
//					'type'  => 'textarea',
//				],
//				[
//					'name'  => 'checkbox',
//					'label' => __( 'Checkbox', 'wedevs' ),
//					'desc'  => __( 'Checkbox Label', 'wedevs' ),
//					'type'  => 'checkbox',
//				],
//				[
//					'name'    => 'radio',
//					'label'   => __( 'Radio Button', 'wedevs' ),
//					'desc'    => __( 'A radio button', 'wedevs' ),
//					'type'    => 'radio',
//					'options' => [
//						'yes' => 'Yes',
//						'no'  => 'No',
//					],
//				],
//				[
//					'name'    => 'multicheck',
//					'label'   => __( 'Multile checkbox', 'wedevs' ),
//					'desc'    => __( 'Multi checkbox description', 'wedevs' ),
//					'type'    => 'multicheck',
//					'options' => [
//						'one'   => 'One',
//						'two'   => 'Two',
//						'three' => 'Three',
//						'four'  => 'Four',
//					],
//				],
//				[
//					'name'    => 'selectbox',
//					'label'   => __( 'A Dropdown', 'wedevs' ),
//					'desc'    => __( 'Dropdown description', 'wedevs' ),
//					'type'    => 'select',
//					'options' => [
//						'yes' => 'Yes',
//						'no'  => 'No',
//					],
//				],
//				[
//					'name'    => 'password',
//					'label'   => __( 'Password', 'wedevs' ),
//					'desc'    => __( 'Password description', 'wedevs' ),
//					'type'    => 'password',
//					'default' => '',
//				],
//				[
//					'name'    => 'file',
//					'label'   => __( 'File', 'wedevs' ),
//					'desc'    => __( 'File description', 'wedevs' ),
//					'type'    => 'file',
//					'default' => '',
//				],
//			],


		$this->set_timelimit();

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
