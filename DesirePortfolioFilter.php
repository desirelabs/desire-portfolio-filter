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
define('PLUGIN_NAME', 'Desire Portfolio Filter');
define('DPF_TEXT_DOMAIN', 'desire-portfolio-filter');
define('DPF_PLUGIN_DIR', __DIR__);
define('DPF_PLUGIN_DIR_URL', plugin_dir_url(__FILE__));
define('DPF_OPTIONS', 'desire_portfolio_options');
require_once 'DesirePortfolioFilterAutoload.php';

class DesirePortfolioFilter
{
    public $plugin_options;
    static $options;
    /**
     * Init hooks
     */
    static function init()
    {
        self::$options = [
            'step_one' => [
                'page_title' => __('Portfolio shortcodes', DPF_TEXT_DOMAIN),
                'page_description' => __('Generate your own shortcodes.', DPF_TEXT_DOMAIN),
                'fields' => []
            ],
            'step_two' => [
                'page_title' =>  __('Template parameters', DPF_TEXT_DOMAIN),
                'page_description' => __('If you prefer using the dedicated portfolio template page, you can set its parameters here.', DPF_TEXT_DOMAIN),
                'fields' => [
                    'display_types' => [
                        'label' => __('Display types ?', DPF_TEXT_DOMAIN),
                        'field_type' => 'checkbox',
                        'option_name' => 'display_types',
                        'default' => false,
                        'options' => []
                    ],
                    'display_tags' => [
                        'label' => __('Display tags ?', DPF_TEXT_DOMAIN),
                        'field_type' => 'checkbox',
                        'option_name' => 'display_tags',
                        'default' => false,
                        'options' => []
                    ],
                    'display_content' => [
                        'label' => __('Display content ?', DPF_TEXT_DOMAIN),
                        'field_type' => 'checkbox',
                        'option_name' => 'display_content',
                        'default' => false,
                        'options' => []
                    ],
                    'include_types' => [
                        'label' => __('Include types (seperated by comas)', DPF_TEXT_DOMAIN),
                        'field_type' => 'text',
                        'option_name' => 'include_types',
                        'default' => 'all',
                        'options' => []
                    ],
                    'include_tags' => [
                        'label' => __('Include tags (seperated by comas)', DPF_TEXT_DOMAIN),
                        'field_type' => 'text',
                        'option_name' => 'include_tags',
                        'default' => 'all',
                        'options' => []
                    ],
                    'showposts' => [
                        'label' => __('Number of projects to show (0 for unlimited)', DPF_TEXT_DOMAIN),
                        'field_type' => 'text',
                        'option_name' => 'showposts',
                        'default' => 0,
                        'options' => []
                    ],
                    'order' => [
                        'label' => __('Ascending or descending order ?', DPF_TEXT_DOMAIN),
                        'field_type' => 'select',
                        'option_name' => 'order',
                        'default' => 'desc',
                        'options' => [
                            'asc',
                            'desc'
                        ]
                    ],
                    'orderby' => [
                        'label' => __('Order by', DPF_TEXT_DOMAIN),
                        'field_type' => 'select',
                        'option_name' => 'orderby',
                        'default' => 'date',
                        'options' => [
                            'date',
                            'title'
                        ]
                    ]
                ]
            ]
        ];
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
        load_theme_textdomain('desire-portfolio-filter', DPF_PLUGIN_DIR . '/lang');
    }

    /**
     * Loads css and js
     */
    static function desire_portfolio_scripts()
    {
        wp_register_style('desire-portfolio-filter', DPF_PLUGIN_DIR_URL . 'css/desire-portfolio-filter.css', array(), '0.2', 'all');
        wp_register_script('desire-isotope', DPF_PLUGIN_DIR_URL . 'js/isotope.pkgd.min.js', array('jquery'), '2.2.2', true);
        wp_register_script('desire-images-loaded', DPF_PLUGIN_DIR_URL . 'js/imagesloaded.pkgd.min.js', array('jquery', 'desire-isotope'), '3.2.0', true);
        wp_register_script('desire-portfolio-filter', DPF_PLUGIN_DIR_URL . 'js/desire-portfolio-filter.js', array('jquery', 'desire-isotope', 'desire-images-loaded'), '0.2', true);

        wp_enqueue_style('desire-portfolio-filter');
        wp_enqueue_script('desire-isotope');
        wp_enqueue_script('desire-images-loaded');
        wp_enqueue_script('desire-portfolio-filter');
    }

    /**
     * Check if jetpack is activated
     */
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

    static function getOptions() {
        return self::$options;
    }

    /**
     * Display notice if cannot be activated
     */
    static function disabled_notice()
    {
        $class = "error";
        $message = __('Desire Porfolio Filter requires Jetpack plugin and Custom Post Types Portfolio feature to be activated', DPF_TEXT_DOMAIN);
        echo "<div class=\"$class\"><p>$message</p></div>";
    }
}

DesirePortfolioFilter::init();