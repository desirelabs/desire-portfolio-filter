<?php
/**
 * @author: Franck LEBAS
 * @package: desire-portfolio-filter
 */
?>
<div class="container">

    <div id="icon-themes" class="icon32"></div>
    <h2><?php __( 'Manage your portfolio projects here', DPF_TEXT_DOMAIN ); ?></h2>
    <?php settings_errors(); ?>

    <?php
    if (isset($_GET['tab'])) {
        $active_tab = $_GET['tab'];
    } else if (!isset($active_tab) || $active_tab = 'step_one') {
        $active_tab = 'step_one';
    } else if ($active_tab == 'step_two') {
        $active_tab = 'step_two';
    }
    ?>

    <h2 class="nav-tab-wrapper">
        <a href="?page=desire_portfolio_filter&tab=step_one" class="nav-tab <?php echo $active_tab == 'step_one' ? 'nav-tab-active' : ''; ?>"><?php echo __('Portfolio shortcodes', DPF_TEXT_DOMAIN ); ?></a>
        <a href="?page=desire_portfolio_filter&tab=step_two" class="nav-tab <?php echo $active_tab == 'step_two' ? 'nav-tab-active' : ''; ?>"><?php echo __('Parameters', DPF_TEXT_DOMAIN ); ?></a>
    </h2>

    <form method="post" action="options.php">
        <?php
        if ($active_tab == 'step_one') {
            settings_fields('dpf_option_page_step_one');
            do_settings_sections('dpf_option_page_step_one');
        } else {
            settings_fields('dpf_option_page_step_two');
            do_settings_sections('dpf_option_page_step_two');
        }
        ?>

        <p class="submit">
            <?php submit_button(null, 'primary', 'submit', false); ?>
            <?php submit_button('Supprimer les options', 'delete', 'delete', false); ?>
        </p>
    </form>
</div>
