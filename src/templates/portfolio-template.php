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
			$taxonomy  = 'jetpack-portfolio-type';
			$tax_terms = get_terms( $taxonomy );
			if ( count( $tax_terms ) != 0 ):
				?>
				<div class="button-group filter-button-group">
					<button data-filter="*"><?php printf( __( 'Show all', 'desire-portfolio-filter' ) ); ?></button>
					<?php foreach ( $tax_terms as $tax_term ): ?>
						<button
							data-filter=".type-<?php echo $tax_term->slug; ?>"><?php echo $tax_term->name; ?></button>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<div class="page-content">
				<div class="portfolio">
					<div class="grid-sizer"></div>
					<div class="gutter-sizer"></div>
					<?php
					if ( get_query_var( 'paged' ) ) :
						$paged = get_query_var( 'paged' );
					elseif ( get_query_var( 'page' ) ) :
						$paged = get_query_var( 'page' );
					else :
						$paged = -1;
					endif;

					$posts_per_page = get_option( 'jetpack_portfolio_posts_per_page', '-1' );

					$args = array(
						'post_type'      => 'jetpack-portfolio',
						'paged'          => $paged,
						'posts_per_page' => $posts_per_page,
					);

					$project_query = new WP_Query ( $args );

					if ( post_type_exists( 'jetpack-portfolio' ) && $project_query -> have_posts() ) :

						while ( $project_query -> have_posts() ) : $project_query -> the_post();
							$taxonomies = wp_get_post_terms($post->ID, 'jetpack-portfolio-type');
							$types = "";
							foreach ( $taxonomies as $type ) {
								$types .= $type->slug." ";
							}
							?>
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
							<div class="portfolio-item type-<?php echo $types; ?>">
								<div class="portfolio-thumb"><?php the_post_thumbnail('large'); ?></div>
								<div class="portfolio-title"><h3><?php the_title(); ?></h3></div>
							</div>
							</a>
						<?php
						endwhile;

						wp_reset_postdata();

					else :
						?>

						<section class="no-results not-found">
							<header class="page-header">
								<h1 class="page-title"><?php _e( 'No Project Found', 'wds_portfolio' ); ?></h1>
							</header><!-- .page-header -->

							<div class="page-content">
								<?php if ( current_user_can( 'publish_posts' ) ) : ?>

									<p><?php printf( __( 'Ready to publish your first project? <a href="%1$s">Get started here</a>.', 'wds_portfolio' ), esc_url( admin_url( 'post-new.php?post_type=jetpack-portfolio' ) ) ); ?></p>

								<?php else : ?>

									<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'wds_portfolio' ); ?></p>

								<?php endif; ?>
							</div><!-- .page-content -->
						</section><!-- .no-results -->
					<?php endif; ?>
				</div><!-- .portfolio -->
				<?php
/*				// Display Jetpack portfolios as set in shortcode, no less, no more
				if ( have_posts() ):
					while ( have_posts() ) : the_post();
						the_content();
					endwhile;
				else: */?><!--
					<p><?php /*printf( __( 'No portfolio found.', 'desire-portfolio-filter' ) ); */?></p>
				--><?php /*endif; */?>
			</div>
		</div>
	</div>

<?php get_footer(); ?>