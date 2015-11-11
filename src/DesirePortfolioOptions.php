<?php
/**
 * @Author: Franck LEBAS
 * @package: desire-portfolio-filter
 */


class DesirePortfolioOptions {

	public function __construct() {

		add_action( 'admin_menu', array( &$this, 'dpf_add_admin_menu' ) );
		add_action( 'admin_init', array( &$this, 'dpf_settings_init' ) );
	}

	public function dpf_add_admin_menu(  ) {

		add_menu_page(
			'Desire Portfolio Filter',
			'Desire Portfolio Filter',
			'manage_options',
			'desire_portfolio_filter',
			array( &$this, 'desire_portfolio_filter_options_page' )
		);

	}


	public function dpf_settings_init(  ) {

		register_setting( 'pluginPage', 'dpf_settings' );

		add_settings_section(
			'dpf_pluginPage_section',
			__( 'Your section description', 'desire-portfolio-filter' ),
			array( &$this, 'dpf_settings_section_callback' ),
			'pluginPage'
		);

		add_settings_field(
			'dpf_checkbox_field_0',
			__( 'Settings field description', 'desire-portfolio-filter' ),
			array( &$this, 'dpf_checkbox_field_0_render' ),
			'pluginPage',
			'dpf_pluginPage_section'
		);

		add_settings_field(
			'dpf_checkbox_field_1',
			__( 'Settings field description', 'desire-portfolio-filter' ),
			array( &$this, 'dpf_checkbox_field_1_render' ),
			'pluginPage',
			'dpf_pluginPage_section'
		);

		add_settings_field(
			'dpf_checkbox_field_2',
			__( 'Settings field description', 'desire-portfolio-filter' ),
			array( &$this, 'dpf_checkbox_field_2_render' ),
			'pluginPage',
			'dpf_pluginPage_section'
		);

		add_settings_field(
			'dpf_text_field_3',
			__( 'Settings field description', 'desire-portfolio-filter' ),
			array( &$this, 'dpf_text_field_3_render' ),
			'pluginPage',
			'dpf_pluginPage_section'
		);

		add_settings_field(
			'dpf_text_field_4',
			__( 'Settings field description', 'desire-portfolio-filter' ),
			array( &$this, 'dpf_text_field_4_render' ),
			'pluginPage',
			'dpf_pluginPage_section'
		);

		add_settings_field(
			'dpf_text_field_5',
			__( 'Settings field description', 'desire-portfolio-filter' ),
			array( &$this, 'dpf_text_field_5_render' ),
			'pluginPage',
			'dpf_pluginPage_section'
		);

		add_settings_field(
			'dpf_select_field_6',
			__( 'Settings field description', 'desire-portfolio-filter' ),
			array( &$this, 'dpf_select_field_6_render' ),
			'pluginPage',
			'dpf_pluginPage_section'
		);

		add_settings_field(
			'dpf_select_field_7',
			__( 'Settings field description', 'desire-portfolio-filter' ),
			array( &$this, 'dpf_select_field_7_render' ),
			'pluginPage',
			'dpf_pluginPage_section'
		);


	}


	public function dpf_checkbox_field_0_render(  ) {

		$options = get_option( 'dpf_settings' );
		?>
		<input type='checkbox' name='dpf_settings[dpf_checkbox_field_0]' <?php isset($options['dpf_checkbox_field_0']) ? checked( $options['dpf_checkbox_field_0'], 1 ) : "" ?> value='1'>
	<?php

	}


	public function dpf_checkbox_field_1_render(  ) {

		$options = get_option( 'dpf_settings' );
		?>
		<input type='checkbox' name='dpf_settings[dpf_checkbox_field_1]' <?php isset($options['dpf_checkbox_field_1']) ? checked( $options['dpf_checkbox_field_1'], 1 ) : "" ?> value='1'>
	<?php

	}


	public function dpf_checkbox_field_2_render(  ) {

		$options = get_option( 'dpf_settings' );
		?>
		<input type='checkbox' name='dpf_settings[dpf_checkbox_field_2]' <?php isset($options['dpf_checkbox_field_2']) ? checked( $options['dpf_checkbox_field_2'], 1 ) : "" ?> value='1'>
	<?php

	}


	public function dpf_text_field_3_render(  ) {

		$options = get_option( 'dpf_settings' );
		?>
		<input type='text' name='dpf_settings[dpf_text_field_3]' value='<?php echo $options['dpf_text_field_3']; ?>'>
	<?php

	}


	public function dpf_text_field_4_render(  ) {

		$options = get_option( 'dpf_settings' );
		?>
		<input type='text' name='dpf_settings[dpf_text_field_4]' value='<?php echo $options['dpf_text_field_4']; ?>'>
	<?php

	}


	public function dpf_text_field_5_render(  ) {

		$options = get_option( 'dpf_settings' );
		?>
		<input type='text' name='dpf_settings[dpf_text_field_5]' value='<?php echo $options['dpf_text_field_5']; ?>'>
	<?php

	}


	public function dpf_select_field_6_render(  ) {

		$options = get_option( 'dpf_settings' );
		?>
		<select name='dpf_settings[dpf_select_field_6]'>
			<option value='1' <?php selected( $options['dpf_select_field_6'], 1 ); ?>>Option 1</option>
			<option value='2' <?php selected( $options['dpf_select_field_6'], 2 ); ?>>Option 2</option>
		</select>

	<?php

	}


	public function dpf_select_field_7_render(  ) {

		$options = get_option( 'dpf_settings' );
		?>
		<select name='dpf_settings[dpf_select_field_7]'>
			<option value='1' <?php selected( $options['dpf_select_field_7'], 1 ); ?>>Option 1</option>
			<option value='2' <?php selected( $options['dpf_select_field_7'], 2 ); ?>>Option 2</option>
		</select>

	<?php

	}


	public function dpf_settings_section_callback(  ) {

		echo __( 'This section description', 'desire-portfolio-filter' );

	}


	public function desire_portfolio_filter_options_page(  ) {

		?>
		<form action='options.php' method='post'>

			<h2>Desire Portfolio Filter</h2>

			<?php
			settings_fields( 'pluginPage' );
			do_settings_sections( 'pluginPage' );
			submit_button();
			?>

		</form>
	<?php

	}
}