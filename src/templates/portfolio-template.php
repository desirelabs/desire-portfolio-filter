<?php
/*
 * Template Name: Portfolio Template
 * @author: Franck LEBAS
 * @package desire-portfolio-filter
*/

get_header();
?>
    <div id="page" class="portfolio-page">

        <header class="page-header">
            <h1 class="page-title"><?php the_title(); ?></h1>
        </header>

        <div id="main" class="site-main">

            <?php
            // Retreive portfolio types to build filter buttons
            do_action('get_portfolio_filters'); ?>

            <div class="page-content">
                <div class="portfolio">
                    <div class="grid-sizer"></div>
                    <div class="gutter-sizer"></div>
                    <?php do_action('get_portfolio_projects'); ?>
	                <div class="crearfix"></div>
                </div>
            </div>
        </div>
    </div>

<?php get_footer(); ?>