<?php
/**
 * Hello_Motion_Customaizer
 *
 * A small helper for adding WordPress Customizer panels, sections and
 * fields with very little code. Sanitization is applied automatically
 * based on the field type.
 *
 * ---------------------------------------------------------------------
 * USAGE (in functions.php or a plugin)
 * ---------------------------------------------------------------------
 *
 * require_once get_template_directory() . '/inc/hello-motion-customaizer.php';
 *
 * $c = new Hello_Motion_Customaizer( 'mytheme_' );   // prefix for every setting ID
 *
 * $c->add_panel( 'theme_options', [ 'title' => 'Theme Options' ] );
 *
 * $c->add_section( 'header', [
 *     'title' => 'Header',
 *     'panel' => 'theme_options',
 * ] );
 *
 * $c->add_field( 'header', 'show_search', [
 *     'type'    => 'checkbox',
 *     'label'   => 'Show search icon',
 *     'default' => true,
 * ] );
 *
 * $c->add_field( 'header', 'logo', [
 *     'type'  => 'image',
 *     'label' => 'Logo',
 * ] );
 *
 * $c->add_field( 'header', 'bg_color', [
 *     'type'    => 'color',
 *     'label'   => 'Background colour',
 *     'default' => '#ffffff',
 * ] );
 *
 * $c->add_field( 'header', 'layout', [
 *     'type'    => 'select',
 *     'label'   => 'Layout',
 *     'default' => 'left',
 *     'choices' => [ 'left' => 'Left', 'center' => 'Centered' ],
 * ] );
 *
 * Reading a value in a template:
 *
 * echo esc_html( $c->get( 'tagline', 'Default tagline' ) );
 * // or, anywhere, without the object:
 * echo Hello_Motion_Customaizer::value( 'mytheme_', 'tagline', 'Default tagline' );
 *
 * ---------------------------------------------------------------------
 * SUPPORTED FIELD TYPES
 * ---------------------------------------------------------------------
 * text, textarea, url, email, password, number, range, date, checkbox,
 * select, radio, color, image, media, upload, dropdown-pages
 *
 * Common field args:
 *   label, description, default, choices, input_attrs, priority,
 *   transport ('refresh'|'postMessage'), capability, active_callback,
 *   sanitize (custom sanitize callback, overrides the automatic one)
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Hello_Motion_Customaizer' ) ) :

class Hello_Motion_Customaizer {

	/** @var string Prefix added to every setting ID. */
	protected $prefix;

	/** @var array */
	protected $panels = array();

	/** @var array */
	protected $sections = array();

	/** @var array */
	protected $fields = array();

	/**
	 * @param string $prefix Prefix for setting IDs, e.g. 'mytheme_'.
	 */
	public function __construct( $prefix = '' ) {
		$this->prefix = $prefix;
		add_action( 'customize_register', array( $this, 'register' ) );
	}

	/* ------------------------------------------------------------------
	 * Public API
	 * ---------------------------------------------------------------- */

	/**
	 * Add a panel.
	 *
	 * @param string $id   Panel ID.
	 * @param array  $args Standard WP_Customize_Panel args (title, description, priority...).
	 * @return $this
	 */
	public function add_panel( $id, $args = array() ) {
		$this->panels[ $id ] = $args;
		return $this;
	}

	/**
	 * Add a section.
	 *
	 * @param string $id   Section ID.
	 * @param array  $args Standard WP_Customize_Section args (title, panel, description, priority...).
	 * @return $this
	 */
	public function add_section( $id, $args = array() ) {
		$this->sections[ $id ] = $args;
		return $this;
	}

	/**
	 * Add a field (setting + control in one go).
	 *
	 * @param string $section Section ID.
	 * @param string $key     Setting key (the prefix is added automatically).
	 * @param array  $args    Field args, see class docblock.
	 * @return $this
	 */
	public function add_field( $section, $key, $args = array() ) {
		$args['section']   = $section;
		$this->fields[ $key ] = $args;
		return $this;
	}

	/**
	 * Get a saved value.
	 *
	 * @param string $key     Setting key without prefix.
	 * @param mixed  $default Fallback. If null, the field's registered default is used.
	 * @return mixed
	 */
	public function get( $key, $default = null ) {
		if ( null === $default && isset( $this->fields[ $key ]['default'] ) ) {
			$default = $this->fields[ $key ]['default'];
		}
		return get_theme_mod( $this->prefix . $key, $default );
	}

	/**
	 * Static shortcut to read a value without the object.
	 */
	public static function value( $prefix, $key, $default = false ) {
		return get_theme_mod( $prefix . $key, $default );
	}

	/* ------------------------------------------------------------------
	 * Registration
	 * ---------------------------------------------------------------- */

	/**
	 * Hooked to customize_register.
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	public function register( $wp_customize ) {

		foreach ( $this->panels as $id => $args ) {
			$wp_customize->add_panel( $id, $args );
		}

		foreach ( $this->sections as $id => $args ) {
			$wp_customize->add_section( $id, $args );
		}

		foreach ( $this->fields as $key => $field ) {
			$this->register_field( $wp_customize, $key, $field );
		}
	}

	protected function register_field( $wp_customize, $key, $field ) {

		$field = wp_parse_args( $field, array(
			'type'              => 'text',
			'label'             => '',
			'description'       => '',
			'default'           => '',
			'choices'           => array(),
			'input_attrs'       => array(),
			'priority'          => 10,
			'transport'         => 'refresh',
			'capability'        => 'edit_theme_options',
			'active_callback'   => null,
			'sanitize'          => null,
		) );

		$id       = $this->prefix . $key;
		$type     = $field['type'];
		$sanitize = $field['sanitize'] ? $field['sanitize'] : $this->get_sanitizer( $field );

		// Setting.
		$wp_customize->add_setting( $id, array(
			'default'           => $field['default'],
			'transport'         => $field['transport'],
			'capability'        => $field['capability'],
			'sanitize_callback' => $sanitize,
		) );

		// Control args shared by all control types.
		$control_args = array(
			'label'       => $field['label'],
			'description' => $field['description'],
			'section'     => $field['section'],
			'settings'    => $id,
			'priority'    => $field['priority'],
			'input_attrs' => $field['input_attrs'],
		);

		if ( $field['active_callback'] ) {
			$control_args['active_callback'] = $field['active_callback'];
		}

		// Controls that need a dedicated class.
		switch ( $type ) {
			case 'color':
				$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id, $control_args ) );
				return;

			case 'image':
				$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $id, $control_args ) );
				return;

			case 'media':
				$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, $id, $control_args ) );
				return;

			case 'upload':
				$wp_customize->add_control( new WP_Customize_Upload_Control( $wp_customize, $id, $control_args ) );
				return;
		}

		// Standard controls.
		$control_args['type'] = $type;

		if ( in_array( $type, array( 'select', 'radio' ), true ) ) {
			$control_args['choices'] = $field['choices'];
		}

		$wp_customize->add_control( $id, $control_args );
	}

	/* ------------------------------------------------------------------
	 * Sanitization
	 * ---------------------------------------------------------------- */

	/**
	 * Return a sanitize callback appropriate for the field type.
	 */
	protected function get_sanitizer( $field ) {

		$choices = isset( $field['choices'] ) ? $field['choices'] : array();
		$attrs   = isset( $field['input_attrs'] ) ? $field['input_attrs'] : array();
		$default = isset( $field['default'] ) ? $field['default'] : '';

		switch ( $field['type'] ) {

			case 'textarea':
				return 'sanitize_textarea_field';

			case 'url':
			case 'image':
			case 'upload':
				return 'esc_url_raw';

			case 'email':
				return 'sanitize_email';

			case 'checkbox':
				return array( $this, 'sanitize_checkbox' );

			case 'color':
				return 'sanitize_hex_color';

			case 'media':
			case 'dropdown-pages':
				return 'absint';

			case 'number':
			case 'range':
				return function ( $value ) use ( $attrs, $default ) {
					if ( ! is_numeric( $value ) ) {
						return $default;
					}
					$value = $value + 0; // int or float.
					if ( isset( $attrs['min'] ) && $value < $attrs['min'] ) {
						$value = $attrs['min'];
					}
					if ( isset( $attrs['max'] ) && $value > $attrs['max'] ) {
						$value = $attrs['max'];
					}
					return $value;
				};

			case 'select':
			case 'radio':
				return function ( $value ) use ( $choices, $default ) {
					$value = sanitize_text_field( $value );
					return array_key_exists( $value, $choices ) ? $value : $default;
				};

			case 'text':
			case 'password':
			case 'date':
			default:
				return 'sanitize_text_field';
		}
	}

	public function sanitize_checkbox( $value ) {
		return ( isset( $value ) && true == $value ) ? true : false;
	}
}

endif;