<?php
/**
 * WP-Reactivate
 *
 *
 * @package   WP-Reactivate
 * @author    Pangolin
 * @license   GPL-3.0
 * @link      https://gopangolin.com
 * @copyright 2017 Pangolin (Pty) Ltd
 */

namespace Netraa\IRC;

/**
 * @subpackage Plugin
 */
class Post {


	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;


	/**
	 * Setup instance attributes
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		add_action( 'init', [ $this, 'register_part' ] );
		add_action( 'init', [ $this, 'register_prod' ] );
		add_action( 'init', [ $this, 'register_assembly' ] );
		add_action( 'init', [ $this, 'register_requisition' ] );
		add_action( 'init', [ $this, 'register_ecn' ] );

		add_action( 'init', [ $this, 'register_material' ] );
		add_action( 'init', [ $this, 'register_vendor' ] );
		add_action( 'init', [ $this, 'register_location' ] );
		add_action( 'init', [ $this, 'register_keyword' ] );
		add_action( 'init', [ $this, 'register_ecn' ] );

//		add_action( 'save_post_assembly', [ $this, 'save_post' ] );
//		add_action( 'save_post_product', [ $this, 'save_post' ] );
	}


	/**
	 * @return \Netraa\IRC\Post|object
	 */
	public static function get_instance() {

		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}


	/**
	 *
	 */
	public function register_part() {

		$labels = [
			'name'          => __( 'Parts', 'wc-bom' ),
			'singular_name' => __( 'Part', 'wc-bom' ),
			'menu_name'     => __( 'Parts', 'wc-bom' ),
		];

		$args = [
			'label'                 => __( 'Parts', 'wc-bom' ),
			"labels"                => $labels,
			"description"           => "",
			"public"                => true,
			"publicly_queryable"    => true,
			"show_ui"               => true,
			"show_in_rest"          => true,
			'rest_base'             => 'parts-api',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
			"has_archive"           => true,
			"show_in_menu"          => true,
			"show_in_nav_menus"     => true,
			"exclude_from_search"   => false,
			'capability_type'       => 'post',
			"map_meta_cap"          => true,
			"hierarchical"          => true,
			"rewrite"               => [ "slug" => 'part', "with_front" => true ],
			"query_var"             => true,
			'menu_icon'             => 'dashicons-hammer',
			"supports"              => [
				"title",
				"editor",
				"thumbnail",
				"excerpt",
				"trackbacks",
				"custom-fields",
				"comments",
				"revisions",
				"author",
				"page-attributes",
				"post-formats",
			],
		];

		register_post_type( 'part', $args );
	}

	public function register_prod() {

		$labels = [
			'name'          => __( 'Products', 'wc-bom' ),
			'singular_name' => __( 'Product', 'wc-bom' ),
			'menu_name'     => __( 'Products', 'wc-bom' ),

		];

		$args = [
			'label'                 => __( 'Products', 'wc-bom' ),
			"labels"                => $labels,
			"description"           => "",
			"public"                => true,
			"publicly_queryable"    => true,
			"show_ui"               => true,
			"show_in_rest"          => true,
			'rest_base'             => 'prod-api',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
			"has_archive"           => true,
			"show_in_menu"          => true,
			"show_in_nav_menus"     => true,
			"exclude_from_search"   => false,
			'capability_type'       => 'post',
			"map_meta_cap"          => true,
			"hierarchical"          => true,
			"rewrite"               => [ "slug" => 'product', "with_front" => true ],
			"query_var"             => true,
			'menu_icon'             => 'dashicons-hammer',
			"supports"              => [
				"title",
				"editor",
				"thumbnail",
				"excerpt",
				"trackbacks",
				"custom-fields",
				"comments",
				"revisions",
				"author",
				"page-attributes",
				"post-formats",
			],
		];

		register_post_type( 'products', $args );
	}

	/**
	 * @return bool
	 */

	public function register_assembly() {

		$labels = [
			'name'          => __( 'Assembly', 'wp-bom' ),
			'singular_name' => __( 'Assembly', 'wp-bom' ),
			'menu_name'     => __( 'Assembly', 'wp-bom' ),
		];
		$args   = [
			'label'                 => __( 'Assembly', 'wc-bom' ),
			"labels"                => $labels,
			"description"           => "",
			"public"                => true,
			"publicly_queryable"    => true,
			"show_ui"               => true,
			"show_in_rest"          => true,
			'rest_base'             => 'assembly-api',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
			"has_archive"           => true,
			"show_in_menu"          => true,
			"show_in_nav_menus"     => true,
			"exclude_from_search"   => false,
			'capability_type'       => 'post',
			"map_meta_cap"          => true,
			"hierarchical"          => true,
			"rewrite"               => [ "slug" => 'assembly', "with_front" => true ],
			"query_var"             => true,
			'menu_icon'             => 'dashicons-hammer',
			"supports"              => [
				"title",
				"editor",
				"thumbnail",
				"excerpt",
				"trackbacks",
				"custom-fields",
				"comments",
				"revisions",
				"author",
				"page-attributes",
				"post-formats",
			],
		];
		register_post_type( 'assembly', $args );
	}

	public function register_requisition() {

		/**
		 * Post Type: Requisitions.
		 */

		$labels = [
			"name"          => __( "Requisitions", "storefront" ),
			"singular_name" => __( "Requisition", "storefront" ),
			'menu_name'     => __( 'Req', 'wc-bom' ),

		];

		$args = [
			'label'                 => __( 'Reqs', 'wc-bom' ),
			"labels"                => $labels,
			"description"           => "",
			"public"                => true,
			"publicly_queryable"    => true,
			"show_ui"               => true,
			"show_in_rest"          => true,
			'rest_base'             => 'req-api',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
			"has_archive"           => true,
			"show_in_menu"          => true,
			"show_in_nav_menus"     => true,
			"exclude_from_search"   => false,
			'capability_type'       => 'post',
			"map_meta_cap"          => true,
			"hierarchical"          => true,
			"rewrite"               => [ "slug" => 'req', "with_front" => true ],
			"query_var"             => true,
			'menu_icon'             => 'dashicons-hammer',
			"supports"              => [
				"title",
				"editor",
				"thumbnail",
				"excerpt",
				"trackbacks",
				"custom-fields",
				"comments",
				"revisions",
				"author",
				"page-attributes",
				"post-formats",
			],
		];

		register_post_type( "requisition", $args );
	}

	public function register_ecn() {

		$labels = [
			'name'          => __( 'ECN', 'wc-bom' ),
			'singular_name' => __( 'ECN', 'wc-bom' ),
			'menu_name'     => __( 'ECN', 'wc-bom' ),
		];

		$args = [
			'label'                 => __( 'ECN', 'wc-bom' ),
			"labels"                => $labels,
			"description"           => "",
			"public"                => true,
			"publicly_queryable"    => true,
			"show_ui"               => true,
			"show_in_rest"          => true,
			'rest_base'             => 'ecn',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
			"has_archive"           => true,
			"show_in_menu"          => true,
			"show_in_nav_menus"     => true,
			"exclude_from_search"   => false,
			'capability_type'       => 'post',
			"map_meta_cap"          => true,
			"hierarchical"          => true,
			"rewrite"               => [ "slug" => 'ecn', "with_front" => true ],
			"query_var"             => true,
			'menu_icon'             => 'dashicons-hammer',
			"supports"              => [
				"title",
				"editor",
				"thumbnail",
				"excerpt",
				"trackbacks",
				"custom-fields",
				"comments",
				"revisions",
				"author",
				"page-attributes",
				"post-formats",
			],
		];

		register_post_type( 'ecn', $args );
	}


	/**
	 *
	 */
	public function register_material() {

		/**
		 * Taxonomy: Materials.
		 */

		$labels = [
			"name"          => __( "Materials", "wp-bom" ),
			"singular_name" => __( "Material", "wp-bom" ),
		];

		$args = [
			"label"                 => __( "Materials", "wp-bom" ),
			"labels"                => $labels,
			"public"                => true,
			"hierarchical"          => true,
			"label"                 => "Materials",
			"show_ui"               => true,
			"show_in_menu"          => true,
			"show_in_nav_menus"     => true,
			"query_var"             => true,
			"rewrite"               => [ 'slug' => 'material', 'with_front' => true, 'hierarchical' => true, ],
			"show_admin_column"     => true,
			"show_in_rest"          => true,
			"rest_base"             => "material-api",
			'rest_controller_class' => 'WP_REST_Terms_Controller',
			"show_in_quick_edit"    => true,
			"description"           => "",
			"publicly_queryable"    => true,
			"has_archive"           => true,
			"exclude_from_search"   => false,


		];
		register_taxonomy( "material", [ "part", "assembly" ], $args );
	}

	/**
	 *
	 */
	public function register_vendor() {

		$labels = [
			'name'          => __( 'Vendors', 'wp-bom' ),
			'singular_name' => __( 'Vendor', 'wp-bom' ),
			'menu_name'     => __( 'Vendor', 'wp-bom' ),
		];

		$args = [
			'label'                 => __( 'Vendors', 'wp-bom' ),
			'labels'                => $labels,
			'public'                => true,
			'hierarchical'          => true,
			//'label' => 'Inventory Types',
			'show_ui'               => true,
			'show_in_menu'          => true,
			'show_in_nav_menus'     => true,
			'query_var'             => true,
			'show_admin_column'     => true,
			'show_in_rest'          => true,
			'show_in_quick_edit'    => true,
			"rewrite"               => [ 'slug' => 'vendor', 'with_front' => true, 'hierarchical' => true, ],
			"rest_base"             => "vendor-api",
			'rest_controller_class' => 'WP_REST_Terms_Controller',
			"description"           => "",
			"publicly_queryable"    => true,
			"has_archive"           => true,
			"exclude_from_search"   => false,
		];
		register_taxonomy( 'vendor', [ 'part', 'assembly', 'requisition' ], $args );


	}

	/**
	 *
	 */
	public function register_location() {

		$labels = [
			'name'          => __( 'Location', 'wp-bom' ),
			'singular_name' => __( 'Location', 'wp-bom' ),
			'menu_name'     => __( 'Locations', 'wp-bom' ),
		];

		$args = [
			'label'                 => __( 'Locations', 'wp-bom' ),
			'labels'                => $labels,
			'public'                => true,
			'hierarchical'          => true,
			//'label' => 'Inventory Types',
			"show_ui"               => true,
			"show_in_menu"          => true,
			"show_in_nav_menus"     => true,
			"query_var"             => true,
			"rewrite"               => [ 'slug' => 'location', 'with_front' => true, 'hierarchical' => true, ],
			"show_admin_column"     => true,
			"show_in_rest"          => true,
			"rest_base"             => "location-api",
			'rest_controller_class' => 'WP_REST_Terms_Controller',
			"show_in_quick_edit"    => true,
			"description"           => "",
			"publicly_queryable"    => true,
			"has_archive"           => true,
			"exclude_from_search"   => false,
		];
		register_taxonomy( 'location', [ 'part', 'assembly', 'requisition' ], $args );


	}

	/**
	 *
	 */
	public function register_keyword() {

		/**
		 * Taxonomy: Item Tags.
		 */

		$labels = [
			"name"          => __( "Keyword", "wp-bom" ),
			"singular_name" => __( "Keyword", "wp-bom" ),
			"menu_name"     => __( "Keywords", "wp-bom" ),
		];

		$args = [
			"label"                 => __( "Keywords", "wp-bom" ),
			"labels"                => $labels,
			"public"                => true,
			"hierarchical"          => false,
			"label"                 => "Keywords",
			"show_ui"               => true,
			"show_in_menu"          => true,
			"show_in_nav_menus"     => true,
			"query_var"             => true,
			"rewrite"               => [ 'slug' => 'keyword', 'with_front' => true, 'hierarchical' => true, ],
			"show_admin_column"     => true,
			"show_in_rest"          => true,
			"rest_base"             => "keyword",
			"show_in_quick_edit"    => true,
			'rest_controller_class' => 'WP_REST_Terms_Controller',
			"description"           => "",
			"publicly_queryable"    => true,
			"has_archive"           => true,
			"exclude_from_search"   => false,

		];
		register_taxonomy( "keyword", [ "product", "part", "assembly", "requisition" ], $args );
	}
}
