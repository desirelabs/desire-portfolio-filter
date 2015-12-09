<?php

/**
 * @Author: Franck LEBAS
 * @package: desire-portfolio-filter
 */
class DesirePortfolioOptions
{
    public $options;

    public function __construct()
    {
        add_action('admin_menu', array(&$this, 'dpf_add_admin_page'));
        add_action('admin_init', array(&$this, 'dpf_settings_init'));
    }

    public function dpf_add_admin_page()
    {
        add_menu_page(
            'Desire Portfolio Filter',
            'Desire Portfolio Filter',
            'manage_options',
            'desire_portfolio_filter',
            array(&$this, 'desire_portfolio_filter_options_page')
        );
    }

    /**
     * Initiate options from options array
     */
    public function dpf_settings_init()
    {
        $this->options = DesirePortfolioFilter::getOptions();
        /**
         * todo set default values
         * $options = get_option('dpf_settings');
         * */

        foreach ( $this->options as $step => $props ) {
            register_setting('dpf_option_page_'.$step, 'dpf_settings');
            add_settings_section(
                strtolower( str_replace( ' ', '_', $props['page_title'] ) ),
                $props['page_description'],
                $this->dpf_settings_section_callback(),
                'dpf_option_page_'.$step
            );

            /**
             * Use options array to build DPF options
             */
            foreach( $props['fields'] as $key => $value ) {

                /**
                 * todo set default values
                 * if ( !isset( $options[$value['option_name']] ) )
                 * add_option( $value['option_name'], $value['default']);
                 * */
                add_settings_field(
                    $key,
                    $value['label'],
                    array(&$this, 'dpf_'.$value['field_type'].'_field_render'), // returns the right filed rendering callback (checkbox, text...)
                    'dpf_option_page_'.$step,
                    strtolower( str_replace( ' ', '_', $props['page_title'] ) ),
                    array(
                        'option_name' => $value['option_name'],
                        'options' => $value['options']
                    )
                );
            }
        }
    }

    /**
     * Render checkbox field
     * @param $args
     * @return checkbox field
     */
    public function dpf_checkbox_field_render($args)
    {
        $options = get_option('dpf_settings');
        ?>
        <input type='checkbox'
               name='dpf_settings[<?php echo $args['option_name'] ?>]' <?php echo isset($options[$args['option_name']]) ? checked($options[$args['option_name']], 1) : "" ?>
               value='1'>
        <?php
    }

    /**
     * Render text field
     * @param $args
     * @return text field
     */
    public function dpf_text_field_render($args)
    {
        $options = get_option('dpf_settings');
        ?>
        <input type='text' name='dpf_settings[<?php echo $args['option_name'] ?>]'
               value='<?php echo isset($options[$args['option_name']]) ? $options[$args['option_name']] : ""; ?>'>
        <?php
    }

    /**
     * Render textarea field
     * @param $args
     * @return textarea field
     */
    public function dpf_textarea_field_render($args)
    {
        $options = get_option('dpf_settings');
        ?>
        <textarea name='dpf_settings[<?php echo $args['option_name'] ?>]' value=''>
            <?php echo isset($options[$args['option_name']]) ? $options[$args['option_name']] : ""; ?>
        </textarea>
        <?php
    }

    /**
     * Render select field
     * @param $args
     * @return select field
     */
    public function dpf_select_field_render($args)
    {
        $options = get_option('dpf_settings');
        ?>
        <select name='dpf_settings[<?php echo $args['option_name'] ?>]'>
            <?php foreach ( $args['options'] as $key => $val ): ?>
                <option <?php selected($options[$args['option_name']], $val, 1); ?> value="<?php echo $val; ?>"><?php echo $val ?></option>
            <?php endforeach; ?>>
        </select>
        <?php
    }


    public function dpf_settings_section_callback()
    {
        echo __('This section description', DPF_TEXT_DOMAIN);
    }


    public function desire_portfolio_filter_options_page()
    {
        include_once('templates/admin-template.php');
    }
}