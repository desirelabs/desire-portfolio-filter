<?php
/**
 * Plugin Name: Desire Portfolio Filter
 * Plugin URI: http://wordpress.org/plugins/desire-portfolio-filter/
 * Description: Add the ability to filter Jetpack Portfolios by type.
 * Author: Franck LEBAS
 * Author URI: http://desirelabs.fr
 * Version: 0.1
 * Licence: Apache
 * http://www.apache.org/licenses/LICENSE-2.0
 * Text Domain: desire-portfolio-filter
 * Domaine Path: /lang
 */

define( 'DESIRE_PORTFOLIO_FILTER_PLUGIN_DIR', plugin_dir_url( __FILE__ ) );

/**
 * First check if jetpack is activated
 * Else, Desire Portfolio Filter cannot be
 */
function is_jetpack() {
	if ( is_admin() && current_user_can( 'activate_plugins' ) && ! is_plugin_active( 'jetpack/jetpack.php' ) ) {
		add_action( 'admin_notices', 'disabled_notice' );

		deactivate_plugins( plugin_basename( __FILE__ ) );

		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
	}
}

add_action( 'admin_init', 'is_jetpack' );

/**
 * Message shown if Jetpack not activated
 */
function disabled_notice() {
	$class   = "error";
	$message = __( 'Desire Porfolio Filter requires <a href="https://fr.wordpress.org/plugins/jetpack/" target="_blank">jetpack to installed and be activated</a>.', 'desire-portfolio-filter' );
	echo "<div class=\"$class\"> <p>$message</p></div>";
}

require_once 'DesirePortfolioFilterAutoload.php';

class DesirePortfolioFilter {

	static function init() {
		// Language
		load_theme_textdomain( 'desire-portfolio-filter', DESIRE_PORTFOLIO_FILTER_PLUGIN_DIR . '/lang' );

		// Hooks and actions init
		add_theme_support( 'jetpack-portfolio' );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'desire_scripts' ) );

		// Loads portfolio template
		add_action( 'plugins_loaded', array( 'DesirePortfolioTemplate', 'get_instance' ) );
	}


	static function desire_scripts() {

		wp_register_script( 'desire-isotope', plugin_dir_url( __FILE__ ) . 'js/isotope.pkgd.min.js', array( 'jquery' ), '2.2.2', true );
		wp_enqueue_style( 'desire', plugin_dir_url( __FILE__ ) . 'css/desire-portfolio-filter.css', array(), '1.0', 'all' );
		wp_register_script( 'desire-portfolio-filter', plugin_dir_url( __FILE__ ) . 'js/desire-portfolio-filter.js', array( 'jquery' ), '1.0', true );

		wp_enqueue_script( 'desire-isotope' );
		wp_enqueue_script( 'desire-portfolio-filter' );
	}
}

DesirePortfolioFilter::init();

