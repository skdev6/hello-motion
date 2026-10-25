<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require_once get_template_directory() . '/includes/customizer/hello-motion-customaizer.php';

/**
 * Register the Header & Footer customizer section.
 *
 * @param WP_Customize_Manager $wp_customize Customizer bootstrap instance.
 *
 * @return void
 */
function themeic_hello_motion_customizer_register( $wp_customize ) {
	$wp_customize->add_section(
		'themeic-hello-motion-options',
		[
			'title' => esc_html__( 'Header & Footer', 'hello-motion' ),
			'capability' => 'edit_theme_options',
		]
	);
}
add_action( 'customize_register', 'themeic_hello_motion_customizer_register' );

if ( ! function_exists( 'themeic_hello_motion_get_menu_choices' ) ) {
	/**
	 * Build the choices for the header/footer menu customizer dropdowns.
	 *
	 * @return array<int, string>
	 */
	function themeic_hello_motion_get_menu_choices() {
		$choices = [
			0 => esc_html__( 'Default', 'hello-motion' ),
		];

		foreach ( (array) wp_get_nav_menus() as $menu ) {
			$choices[ (int) $menu->term_id ] = $menu->name;
		}

		return $choices;
	}
}

/**
 * Theme customizer fields (Header & Footer section).
 *
 * Fields are registered through the Hello_Motion_Customaizer helper, which
 * takes care of the setting, its sanitize callback and the control.
 * The setting IDs are `themeic-hello-motion-` . <key>.
 *
 * @return Hello_Motion_Customaizer
 */
function themeic_hello_motion_customaizer() {
	static $customaizer = null;

	if ( null === $customaizer ) {
		$customaizer = new Hello_Motion_Customaizer( 'themeic-hello-motion-' );

		$customaizer
			->add_field(
				'themeic-hello-motion-options',
				'header-menu',
				[
					'type'        => 'select',
					'label'       => esc_html__( 'Header menu', 'hello-motion' ),
					'description' => esc_html__( 'Choose which menu is displayed in the site header. Choose "Default" to use the menu assigned to the Header location.', 'hello-motion' ),
					'default'     => 0,
					'choices'     => themeic_hello_motion_get_menu_choices(),
					'priority'    => 10,
				]
			)
			->add_field(
				'themeic-hello-motion-options',
				'header-logo',
				[
					'type'        => 'media',
					'label'       => esc_html__( 'Header logo', 'hello-motion' ),
					'description' => esc_html__( 'Upload an image to use as the header logo. It replaces the site title.', 'hello-motion' ),
					'priority'    => 15,
				]
			)
			->add_field(
				'themeic-hello-motion-options',
				'footer-menu',
				[
					'type'        => 'select',
					'label'       => esc_html__( 'Footer menu', 'hello-motion' ),
					'description' => esc_html__( 'Choose which menu is displayed in the site footer. Choose "Default" to use the menu assigned to the Footer location.', 'hello-motion' ),
					'default'     => 0,
					'choices'     => themeic_hello_motion_get_menu_choices(),
					'priority'    => 20,
				]
			)
			->add_field(
				'themeic-hello-motion-options',
				'footer-logo',
				[
					'type'        => 'media',
					'label'       => esc_html__( 'Footer logo', 'hello-motion' ),
					'description' => esc_html__( 'Upload an image to use as the footer logo. It replaces the site title.', 'hello-motion' ),
					'priority'    => 25,
				]
			)
			->add_field(
				'themeic-hello-motion-options',
				'footer-copyright',
				[
					'type'        => 'textarea',
					'label'       => esc_html__( 'Footer copyright text', 'hello-motion' ),
					'description' => esc_html__( 'Text shown at the bottom of the footer. Leave empty to use the value from the Elementor Site Settings.', 'hello-motion' ),
					'default'     => '',
					'priority'    => 30,
				]
			);
	}

	return $customaizer;
}

// Instantiate at load time so the helper hooks into customize_register.
themeic_hello_motion_customaizer();

/**
 * Register Customizer controls for Elementor Pro upsell.
 *
 * @return void
 */
function themeic_hello_motion_customizer_register_pro_upsell( $wp_customize ) {
	if ( function_exists( 'elementor_pro_load_plugin' ) ) {
		return;
	}

	require_once get_template_directory() . '/includes/customizer/customizer-upsell.php';

	$wp_customize->add_section(
		new ThemeicHelloMotion\Includes\Customizer\Hello_Motion_Customizer_Upsell(
			$wp_customize,
			'themeic-hello-motion-upsell-elementor-pro',
			[
				'heading' => esc_html__( 'Customize your entire website with Elementor Pro', 'hello-motion' ),
				'description' => esc_html__( 'Build and customize every part of your website, including Theme Parts with Elementor Pro.', 'hello-motion' ),
				'button_text' => esc_html__( 'Upgrade Now', 'hello-motion' ),
				'button_url' => 'https://elementor.com/pro/?utm_source=hello-motion-customize&utm_campaign=gopro&utm_medium=wp-dash',
				'priority' => 999999,
			]
		)
	);
}
add_action( 'customize_register', 'themeic_hello_motion_customizer_register_pro_upsell' );

/**
 * Enqueue Customizer CSS.
 *
 * @return void
 */
function themeic_hello_motion_customizer_styles() {
	wp_enqueue_style(
		'themeic-hello-motion-customizer',
		THEMEIC_HELLO_MOTION_STYLE_URL . 'customizer.css',
		[],
		THEMEIC_HELLO_MOTION_VERSION
	);
}
add_action( 'admin_enqueue_scripts', 'themeic_hello_motion_customizer_styles' );
