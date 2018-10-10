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

		//var_dump( get_option( 'wedevs_basics' ) );
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

	/**
	 * Returns all the settings fields
	 *
	 * @return array settings fields
	 */
	function get_settings_fields() {


		$args = [
			'posts_per_page'   => - 1,
			'post_type'        => 'part',
			'post_status'      => 'publish',
			'suppress_filters' => true,
		];

		$posts_array = get_posts( $args );

		foreach ( $posts_array as $post ) {
			$post  = new WP_Post( $post );
			$arr[] = [ $post->post_title => $post->post_title ];
		}


		$day  = date( 'd' );
		$ints = (int) $day;

		$arr = [ $ints, $ints + 1, $ints + 2, $ints + 3 ];


		echo json_encode($arr);
		$settings_fields = [
			'wcb_settings' => [
				[
					'name'    => 'build',
					'label'   => __( 'WP Iron Curtain', 'wedevs' ),
					'desc'    => __( 'Build version to use', 'wedevs' ),
					'type'    => 'select',
					'default' => '2.0',
					'options' => [
						'1.0' => '1.0',
						'2.0' => '2.0',
					],
				],
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
					'default' => 'Title',
					//'sanitize_callback' => 'intval',
				],


				[
					'name'    => 'logout',
					'label'   => __( 'Logout Action', 'wedevs' ),
					'desc'    => __( 'Enable cloak on logout', 'wedevs' ),
					'type'    => 'radio',
					'options' => [
						'yes' => 'Yes',
						'no'  => 'No',
					],
				],
				[
					'name'    => 'expire',
					'label'   => __( 'Cloak Expire', 'wedevs' ),
					'desc'    => __( 't', 'wedevs' ),
					'type'    => 'radio',
					'options' => [
						'Logout'    => 'Logout',
						'Day'       => 'Day',
						'No Expire' => 'None',
					],
				],
				[
					'name'    => 'expire',
					'label'   => __( 'Cloak Expire', 'wedevs' ),
					'desc'    => __( 't', 'wedevs' ),
					'type'    => 'radio',
					'options' => [
						'Logout' => date( 'd' ),
					],
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
