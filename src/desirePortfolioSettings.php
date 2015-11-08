<?php
/**
 * @author: Franck LEBAS
 * @package desire-portfolio-filter
 */

class desirePortfolioSettings {

	private $portfolio_options;

	public function __construct() {

		$this->$portfolio_options = array(
			"display_types"     => true,
			"display_tags"      => true,
			"display_content"   => true,
			"include_type"      => "all", // display specific Project Types. Defaults to all. (comma-separated list of Project Type slugs)
			"include_tag"       => "all", // display specific Project Tags. Defaults to all. (comma-separated list of Project Tag slugs)
			"columns"           => "2", // number of columns in shortcode. Defaults to 2. (number, 1-6)
			"showposts"         => "all", // number of projects to display. Defaults to all. (number)
			"order"             => "ASC", // display projects in ascending or descending order. Defaults to ASC for sorting in ascending order, but you can reverse the order by using DESC to display projects in descending order instead. (ASC/DESC)
			"orderby"           => "date" // sort projects by different criteria, including author name, project title, and even rand to display in a random order. Defaults to sorting by date. (author, date, title, rand)
		);
	}
}