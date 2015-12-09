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

define('DESIRE_PORTFOLIO_FILTER_PLUGIN_DIR', __DIR__);
define('DESIRE_PORTFOLIO_FILTER_PLUGIN_DIR_URL', plugin_dir_url(__FILE__));
require_once 'DesirePortfolioFilterAutoload.php';
define( 'DESIRE_PORTFOLIO_OPTIONS', 'desire_portfolio_options');

class DesirePortfolioFilter
{

    /**
     * Init hooks
     */
    static function init()
    {

        // Theme setup
        add_action('admin_init', array(__CLASS__, 'is_jetpack'));
        add_action('after_setup_theme', array(__CLASS__, 'desire_theme_setup'));

        // Hooks and actions init
        add_theme_support('jetpack-portfolio');
        add_action('wp_enqueue_scripts', array(__CLASS__, 'desire_portfolio_scripts'));

        // Loads portfolio template
        add_action('plugins_loaded', array('DesirePortfolioTemplate', 'get_instance'));
    }


    static function desire_theme_setup()
    {
        load_theme_textdomain('desire-portfolio-filter', DESIRE_PORTFOLIO_FILTER_PLUGIN_DIR . '/lang');
    }


    static function desire_portfolio_scripts()
    {

        wp_register_script('desire-isotope', DESIRE_PORTFOLIO_FILTER_PLUGIN_DIR_URL . 'js/isotope.pkgd.min.js', array('jquery'), '2.2.2', true);
        wp_register_script('desire-images-loaded', DESIRE_PORTFOLIO_FILTER_PLUGIN_DIR_URL . 'js/imagesloaded.pkgd.min.js', array('jquery', 'desire-isotope'), '3.2.0', true);
        wp_register_style('desire-portfolio-filter', DESIRE_PORTFOLIO_FILTER_PLUGIN_DIR_URL . 'css/desire-portfolio-filter.css', array(), '0.2', 'all');
        wp_register_script('desire-portfolio-filter', DESIRE_PORTFOLIO_FILTER_PLUGIN_DIR_URL . 'js/desire-portfolio-filter.js', array('jquery', 'desire-isotope', 'desire-images-loaded'), '0.2', true);

        wp_enqueue_style('desire-portfolio-filter');
        wp_enqueue_script('desire-isotope');
        wp_enqueue_script('desire-images-loaded');
        wp_enqueue_script('desire-portfolio-filter');
    }


    static function is_jetpack()
    {
        if (is_admin() && current_user_can('activate_plugins') && !is_plugin_active('jetpack/jetpack.php')) {
            add_action('admin_notices', array(__CLASS__, 'disabled_notice'));

            deactivate_plugins(plugin_basename(__FILE__));

            if (isset($_GET['activate'])) {
                unset($_GET['activate']);
            }
        }
    }


    static function disabled_notice()
    {
        $class = "error";
        $message = __('Desire Porfolio Filter requires Jetpack plugin and Custom Post Types Portfolio feature to be activated', 'desire-portfolio-filter');
        echo "<div class=\"$class\"><p>$message</p></div>";
    }
}

DesirePortfolioFilter::init();