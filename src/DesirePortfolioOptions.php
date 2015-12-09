<?php

/**
 * @Author: Franck LEBAS
 * @package: desire-portfolio-filter
 */
class DesirePortfolioOptions
{

    public function __construct()
    {
        add_action('admin_menu', array(&$this, 'dpf_add_admin_menu'));
        add_action('admin_init', array(&$this, 'dpf_settings_init'));
    }

    public function dpf_add_admin_menu()
    {
        add_menu_page(
            'Desire Portfolio Filter',
            'Desire Portfolio Filter',
            'manage_options',
            'desire_portfolio_filter',
            array(&$this, 'desire_portfolio_filter_options_page')
        );

    }


    public function dpf_settings_init()
    {
        register_setting('dpf_option_page', 'dpf_settings');

        add_settings_section(
            'dpf_portfolio_query_section',
            __('Parameters to query your portfolio projects', 'desire-portfolio-filter'),
            array(&$this, 'dpf_settings_section_callback'),
            'dpf_option_page'
        );

        add_settings_field(
            'display_types',
            __('Display types ?', 'desire-portfolio-filter'),
            array(&$this, 'dpf_checkbox_field_render'),
            'dpf_option_page',
            'dpf_portfolio_query_section',
            array(
                'option_name' => 'display_types'
            )
        );

        add_settings_field(
            'display_tags',
            __('Display tags ?', 'desire-portfolio-filter'),
            array(&$this, 'dpf_checkbox_field_render'),
            'dpf_option_page',
            'dpf_portfolio_query_section',
            array(
                'option_name' => 'display_tags'
            )
        );

        add_settings_field(
            'display_content',
            __('Display content ?', 'desire-portfolio-filter'),
            array(&$this, 'dpf_checkbox_field_render'),
            'dpf_option_page',
            'dpf_portfolio_query_section',
            array(
                'option_name' => 'display_content'
            )
        );

        add_settings_field(
            'include_types',
            __('Include types (seperated by comas)', 'desire-portfolio-filter'),
            array(&$this, 'dpf_text_field_render'),
            'dpf_option_page',
            'dpf_portfolio_query_section',
            array(
                'option_name' => 'include_types'
            )
        );

        add_settings_field(
            'include_tags',
            __('Include tags (seperated by comas)', 'desire-portfolio-filter'),
            array(&$this, 'dpf_text_field_render'),
            'dpf_option_page',
            'dpf_portfolio_query_section',
            array(
                'option_name' => 'include_tags'
            )
        );

        add_settings_field(
            'showposts',
            __('Number of projects to show (0 for unlimited)', 'desire-portfolio-filter'),
            array(&$this, 'dpf_text_field_render'),
            'dpf_option_page',
            'dpf_portfolio_query_section',
            array(
                'option_name' => 'showposts'
            )
        );

        add_settings_field(
            'order',
            __('Ascending or descending order ?', 'desire-portfolio-filter'),
            array(&$this, 'dpf_select_field_render'),
            'dpf_option_page',
            'dpf_portfolio_query_section',
            array(
                'option_name' => 'order',
                'options' => array(
                    'asc',
                    'desc'
                )
            )
        );

        add_settings_field(
            'orderby',
            __('Order by', 'desire-portfolio-filter'),
            array(&$this, 'dpf_select_field_render'),
            'dpf_option_page',
            'dpf_portfolio_query_section',
            array(
                'option_name' => 'orderby',
                'options' => array(
                    'date',
                    'title'
                )
            )
        );


    }


    public function dpf_checkbox_field_render($args)
    {
        $options = get_option('dpf_settings');
        ?>
        <input type='checkbox'
               name='dpf_settings[<?php echo $args['option_name'] ?>]' <?php echo isset($options[$args['option_name']]) ? checked($options[$args['option_name']], 1) : "" ?>
               value='1'>
    <?php

    }


    public function dpf_text_field_render($args)
    {

        $options = get_option('dpf_settings');
        ?>
        <input type='text' name='dpf_settings[<?php echo $args['option_name'] ?>]'
               value='<?php echo isset($options[$args['option_name']]) ? $options[$args['option_name']] : ""; ?>'>
    <?php

    }


    public function dpf_select_field_render($args)
    {

        $options = get_option('dpf_settings');
        ?>
        <select name='dpf_settings[<?php echo $args['option_name'] ?>]'>
            <?php foreach ($args['options'] as $key => $val): ?>
                <option <?php isset($options[$args['option_name']]) ? selected($options['option_name'], 1) : "" ?>
                    value='<?php echo $val; ?>'><?php echo $val ?></option>
            <?php endforeach; ?>>
        </select>

    <?php

    }


    public function dpf_settings_section_callback()
    {

        echo __('This section description', 'desire-portfolio-filter');

    }


    public function desire_portfolio_filter_options_page()
    {

        ?>
        <form action='options.php' method='post'>

            <h2>Desire Portfolio Filter</h2>

            <?php
            settings_fields('dpf_option_page');
            do_settings_sections('dpf_option_page');
            submit_button();
            ?>

        </form>
    <?php

    }
}