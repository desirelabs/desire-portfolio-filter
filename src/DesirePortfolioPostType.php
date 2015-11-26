<?php
/**
 * Class to generate custom post type and related taxonomy
 * @Author: Franck LEBAS
 * @package: desire-flick-slider
 */

class DesirePortfolioPostType {


	/**
	 * Generate desire portfolio taxonomies
	 */
	static function desire_portfolio_taxonomies() {
		// generate types hierarchical (like cats)
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
		register_taxonomy( 'desire-portfolio-type', array( 'desire_portfolio' ), $args );

		// Generate tags
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
		register_taxonomy( 'desire-portfolio-tag', array( 'desire-portfolio' ), $args );
	}



	/**
	 * Create desire portfolio custom post type
	 */
	static function desire_portfolio_post_type() {
		// Register the desire portfolio post type
		$labels = array(
			'name'               => _x( 'Desire portfolio', 'post type general name', 'desire portfolio-filter' ),
			'singular_name'      => _x( 'Desire portfolio', 'post type singular name', 'desire portfolio-filter' ),
			'menu_name'          => _x( 'Desire portfolio', 'admin menu', 'desire portfolio-filter' ),
			'name_admin_bar'     => _x( 'Desire portfolio', 'add new on admin bar', 'desire portfolio-filter' ),
			'add_new'            => _x( 'Add New', 'book', 'desire portfolio-filter' ),
			'add_new_item'       => __( 'Add New Desire portfolio', 'desire portfolio-filter' ),
			'new_item'           => __( 'New Desire portfolio', 'desire portfolio-filter' ),
			'edit_item'          => __( 'Edit Desire portfolio', 'desire portfolio-filter' ),
			'view_item'          => __( 'View Desire portfolio', 'desire portfolio-filter' ),
			'all_items'          => __( 'All Desire portfolio', 'desire portfolio-filter' ),
			'search_items'       => __( 'Search Desire portfolio', 'desire portfolio-filter' ),
			'parent_item_colon'  => __( 'Parent Desire portfolio:', 'desire portfolio-filter' ),
			'not_found'          => __( 'No desire portfolio found.', 'desire portfolio-filter' ),
			'not_found_in_trash' => __( 'No desire portfolio found in Trash.', 'desire portfolio-filter' )
		);
		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Description.', 'desire-portfolio-filter' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'desire-portfolio' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'comments' ),
			'taxonomies'         => array( 'jetpack-portfolio-type', 'jetpack-portfolio-tag', 'desire-portfolio-type', 'desire-portfolio-tag' )
		);
		register_post_type( 'desire-portfolio', $args );
	}
}