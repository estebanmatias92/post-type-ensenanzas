<?php
/**
 * Post Type Enseñanzas.
 *
 * @package   Post_Type_Ensenanzas
 * @author    Matias Esteban <estebanmatias92@gmail.com>
 * @license   MIT License
 * @link      http://example.com
 * @copyright 2013 Matias Esteban
 */

// Includes
require_once( 'includes/helpers.php' );
require_once( 'includes/class-ensenanzas-get-templates.php' );

/**
 * Post_Type_Ensenanzas.
 *
 * Plugin class, creates a new post-type.
 *
 * @package Post_Type_Ensenanzas
 * @author  Matias Esteban <estebanmatias92@gmail.com>
 */
class Post_Type_Ensenanzas {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   0.1.0
	 *
	 * @var     string
	 */
	protected $version = '0.1.0';

	/**
	 * Unique identifier for your plugin.
	 *
	 * Use this value (not the variable name) as the text domain when internationalizing strings of text. It should
	 * match the Text Domain file header in the main plugin file.
	 *
	 * @since    0.1.0
	 *
	 * @var      string
	 */
	protected static $plugin_slug = 'post_type_ensenanzas';

	/**
	 * Instance of this class.
	 *
	 * @since    0.1.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    0.1.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Plugin default post type and tax values.
	 */
	protected static $post_type     = 'ensenanzas';

	protected static $type_singular = 'Enseñanza';

	protected static $type_name     = 'Enseñanzas';

	protected static $taxonomy      = 'categoria-ensenanza';

	protected static $tax_singular  = 'Categoría enseñanza';

	protected static $tax_name      = 'Categorías enseñanzas';

	/**
	 * Name for the post type page and menu item.
	 *
	 * @var string
	 */
	protected static $page_name = '';


	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since     0.1.0
	 */
	private function __construct() {

		// Create post type, taxonomies and meta boxes
		add_action( 'after_setup_theme', array( $this, 'create_type_tax_and_meta' ) );

		// Update values
		self::$page_name = self::$type_name;

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Get the post type templates
		add_filter( 'template_include', array( $this, 'template_chooser' ), 10, 2 );

	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     0.1.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since    0.1.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog.
	 */
	public static function activate( $network_wide ) {

	    // Insert the page (views)
	    add_page_and_menu( self::$page_name, PTE_PLUGIN_ROOT . 'views/templates/archive.php' );

	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    0.1.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Deactivate" action, false if WPMU is disabled or plugin is deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {

		// Delete archive page and menu
	    remove_page_and_menu( self::$page_name, true );

	}

	/**
	 * Fired when the plugin is uninstalled.
	 *
	 * @since  0.1.0
	 */
	public static function uninstall() {

		// Delete archive page and menu
	    remove_page_and_menu( self::$page_name, true );

		// Delete all post-type terms, and taxonomies
		add_action( 'unregister_post_type', 'delete_post_type_taxonomies', 10 );

		// Delete all related posts and his attachments
		delete_post_type_posts( self::$post_type, true, true );

		// Remove post-type from Wordpress
		unregister_post_type( self::$post_type );

	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    0.1.0
	 */
	public function load_plugin_textdomain() {

		$domain = self::$plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
	}

	/**
	 * Function to create the plugin post type and taxonomy.
	 *
	 * @since  0.1.0
	 *
	 * @return null      The post type and tax registered when the call him.
	 */
	public function create_type_tax_and_meta() {

		if ( ! class_exists( 'Super_Custom_Post_Type' ) )
			return;

		// Add post type
		$post_type_labels =  array(
    		'supports' => array( 'title', 'editor', 'thumbnail' ),
    		);
	    $post_type = new Super_Custom_Post_Type( self::$post_type, self::$type_singular, self::$type_name, $post_type_labels );

	    // Add taxonomy
		$taxonomy_labels = array(
			'show_admin_column' => true,
			);
	    $taxonomy = new Super_Custom_Taxonomy( self::$taxonomy, self::$tax_singular, self::$tax_name, 'cat', $taxonomy_labels );

	    // Connect post type and taxes
		connect_types_and_taxes( $post_type, array( $taxonomy ) );

	}

	/**
	 * Get the custom post-type templates.
	 *
	 * @since 0.1.0
	 *
	 * @param string    $template Default wordpress hierarchy template to use.
	 *
	 * @return string    The current template file that will be use.
	 */
	public function template_chooser( $template ) {

		$file = new Ensenanzas_Get_Templates();

		return $file->get_template( $template );

	}

}
