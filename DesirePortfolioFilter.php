<?php
/**
 * Plugin Name: Desire Portfolio Filter
 * Plugin URI: http://wordpress.org/plugins/desire-portfolio-filter/
 * Description: Desire Portfolio Filter is designed to allow visitors to filter Jetpack portfolio by type.
 * Author: Franck LEBAS
 * Author URI: http://desirelabs.fr
 * Version: 0.2.4
 * Licence: GPLv3
 * Text Domain: desire-portfolio-filter
 * Domaine Path: /lang
 */

define( 'DESIRE_PORTFOLIO_FILTER_PLUGIN_DIR', __DIR__ );
define( 'DESIRE_PORTFOLIO_FILTER_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
require_once 'DesirePortfolioFilterAutoload.php';

class DesirePortfolioFilter {
	/**
	 * Init hooks
	 */
	static function init() {
		// Theme setup
		add_action( 'admin_init', array( __CLASS__, 'is_jetpack' ) );
		add_action( 'after_setup_theme', array( __CLASS__, 'desire_plugin_setup' ) );
		add_action( 'init', array( __CLASS__, 'desire_portfolio_taxonomies'), 0  );
		add_action( 'init', array( __CLASS__, 'desire_portfolio_post_type' ) );

		// Hooks and actions init
		add_theme_support( 'jetpack-portfolio' );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'desire_portfolio_scripts' ) );

		// Loads portfolio template
		add_action( 'plugins_loaded', array( 'DesirePortfolioTemplate', 'get_instance' ) );
	}

	/**
	 * Plugin theme
	 */
	static function desire_plugin_setup() {
		load_theme_textdomain( 'desire-portfolio-filter', DESIRE_PORTFOLIO_FILTER_PLUGIN_DIR . '/lang' );
	}

	/**
	 * Add css & scripts
	 */
	static function desire_portfolio_scripts() {
		wp_register_script( 'desire-isotope', DESIRE_PORTFOLIO_FILTER_PLUGIN_DIR_URL . 'js/isotope.pkgd.min.js', array( 'jquery' ), '2.2.2', true );
		wp_register_script( 'desire-images-loaded', DESIRE_PORTFOLIO_FILTER_PLUGIN_DIR_URL . 'js/imagesloaded.pkgd.min.js', array(
			'jquery',
			'desire-isotope'
		), '3.2.0', true );
		wp_register_style( 'desire-portfolio-filter', DESIRE_PORTFOLIO_FILTER_PLUGIN_DIR_URL . 'css/desire-portfolio-filter.css', array(), '0.2', 'all' );
		wp_register_script( 'desire-portfolio-filter', DESIRE_PORTFOLIO_FILTER_PLUGIN_DIR_URL . 'js/desire-portfolio-filter.js', array(
			'jquery',
			'desire-isotope',
			'desire-images-loaded'
		), '0.2', true );

		wp_enqueue_style( 'desire-portfolio-filter' );
		wp_enqueue_script( 'desire-isotope' );
		wp_enqueue_script( 'desire-images-loaded' );
		wp_enqueue_script( 'desire-portfolio-filter' );
	}

	/**
	 * Check if jetpack is activated
	 */
	static function is_jetpack() {
		if ( is_admin() && current_user_can( 'activate_plugins' ) && ! is_plugin_active( 'jetpack/jetpack.php' ) ) {
			add_action( 'admin_notices', array( __CLASS__, 'disabled_notice' ) );

			deactivate_plugins( plugin_basename( __FILE__ ) );

			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}
		}
	}

	/**
	 * Show notices
	 */
	static function disabled_notice() {
		$class   = "error";
		$message = __( 'Desire Porfolio Filter requires Jetpack plugin and Custom Post Types Portfolio feature to be activated', 'desire-portfolio-filter' );
		echo "<div class=\"$class\"><p>$message</p></div>";
	}

	static function desire_portfolio_taxonomies() {
		// Add new taxonomy, make it hierarchical (like categories)
		$labels = array(
			'name'              => _x( 'Desire portfolio types', 'taxonomy general name' ),
			'singular_name'     => _x( 'Desire portfolio type', 'taxonomy singular name' ),
			'search_items'      => __( 'Search Desire portfolio types' ),
			'all_items'         => __( 'All Desire portfolio types' ),
			'parent_item'       => __( 'Parent Desire portfolio type' ),
			'parent_item_colon' => __( 'Parent Desire portfolio type:' ),
			'edit_item'         => __( 'Edit Desire portfolio type' ),
			'update_item'       => __( 'Update Desire portfolio type' ),
			'add_new_item'      => __( 'Add New Desire portfolio type' ),
			'new_item_name'     => __( 'New Desire portfolio type Name' ),
			'menu_name'         => __( 'Desire portfolio type' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'genre' ),
		);

		register_taxonomy( 'desire_portfolio_type', array( 'desire_portfolio' ), $args );

		// Add new taxonomy, NOT hierarchical (like tags)
		$labels = array(
			'name'                       => _x( 'Desire portfolio tags', 'taxonomy general name' ),
			'singular_name'              => _x( 'Desire portfolio tag', 'taxonomy singular name' ),
			'search_items'               => __( 'Search Desire portfolio tags' ),
			'popular_items'              => __( 'Popular Desire portfolio tags' ),
			'all_items'                  => __( 'All Desire portfolio tags' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Desire portfolio tag' ),
			'update_item'                => __( 'Update Desire portfolio tag' ),
			'add_new_item'               => __( 'Add New Desire portfolio tag' ),
			'new_item_name'              => __( 'New Desire portfolio tag Name' ),
			'separate_items_with_commas' => __( 'Separate writers with commas' ),
			'add_or_remove_items'        => __( 'Add or remove writers' ),
			'choose_from_most_used'      => __( 'Choose from the most used writers' ),
			'not_found'                  => __( 'No writers found.' ),
			'menu_name'                  => __( 'Desire portfolio tags' ),
		);

		$args = array(
			'hierarchical'          => false,
			'labels'                => $labels,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var'             => true,
			'rewrite'               => array( 'slug' => 'writer' ),
		);

		register_taxonomy( 'desire_portfolio_tag', array( 'desire_portfolio' ), $args );
	}

	/**
	 * Create desire portfolio custom post type
	 */
	static function desire_portfolio_post_type() {
		// Register the desire portfolio post type
		$labels = array(
			'name'               => _x( 'Desire portfolio', 'post type general name', 'desire portfolio-filter' ),
			'singular_name'      => _x( 'Book', 'post type singular name', 'desire portfolio-filter' ),
			'menu_name'          => _x( 'Desire portfolio', 'admin menu', 'desire portfolio-filter' ),
			'name_admin_bar'     => _x( 'Book', 'add new on admin bar', 'desire portfolio-filter' ),
			'add_new'            => _x( 'Add New', 'book', 'desire portfolio-filter' ),
			'add_new_item'       => __( 'Add New Book', 'desire portfolio-filter' ),
			'new_item'           => __( 'New Book', 'desire portfolio-filter' ),
			'edit_item'          => __( 'Edit Book', 'desire portfolio-filter' ),
			'view_item'          => __( 'View Book', 'desire portfolio-filter' ),
			'all_items'          => __( 'All Desire portfolio', 'desire portfolio-filter' ),
			'search_items'       => __( 'Search Desire portfolio', 'desire portfolio-filter' ),
			'parent_item_colon'  => __( 'Parent Desire portfolio:', 'desire portfolio-filter' ),
			'not_found'          => __( 'No desire portfolio found.', 'desire portfolio-filter' ),
			'not_found_in_trash' => __( 'No desire portfolio found in Trash.', 'desire portfolio-filter' )
		);
		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Description.', 'your-plugin-textdomain' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'book' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', '', 'comments' )
		);
		register_post_type( 'desire_portfolio', $args );
	}
}

DesirePortfolioFilter::init();