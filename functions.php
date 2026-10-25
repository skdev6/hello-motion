<?php
/**
 * Theme functions and definitions
 *
 * @package ThemeicHelloMotion
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'THEMEIC_HELLO_MOTION_VERSION', '1.0.0' );
define( 'THEMEIC_HELLO_MOTION_SLUG', 'themeic-hello-motion' );

define( 'THEMEIC_HELLO_MOTION_PATH', get_template_directory() );
define( 'THEMEIC_HELLO_MOTION_URL', get_template_directory_uri() );
define( 'THEMEIC_HELLO_MOTION_ASSETS_PATH', THEMEIC_HELLO_MOTION_PATH . '/assets/' );
define( 'THEMEIC_HELLO_MOTION_ASSETS_URL', THEMEIC_HELLO_MOTION_URL . '/assets/' );
define( 'THEMEIC_HELLO_MOTION_SCRIPTS_PATH', THEMEIC_HELLO_MOTION_ASSETS_PATH . 'js/' );
define( 'THEMEIC_HELLO_MOTION_SCRIPTS_URL', THEMEIC_HELLO_MOTION_ASSETS_URL . 'js/' );
define( 'THEMEIC_HELLO_MOTION_STYLE_PATH', THEMEIC_HELLO_MOTION_ASSETS_PATH . 'css/' );
define( 'THEMEIC_HELLO_MOTION_STYLE_URL', THEMEIC_HELLO_MOTION_ASSETS_URL . 'css/' );
define( 'THEMEIC_HELLO_MOTION_IMAGES_PATH', THEMEIC_HELLO_MOTION_ASSETS_PATH . 'images/' );
define( 'THEMEIC_HELLO_MOTION_IMAGES_URL', THEMEIC_HELLO_MOTION_ASSETS_URL . 'images/' );

if ( ! isset( $content_width ) ) {
	$content_width = 800; // Pixels.
}

if ( ! function_exists( 'themeic_hello_motion_setup' ) ) {
	/**
	 * Set up theme support.
	 *
	 * @return void
	 */
	function themeic_hello_motion_setup() {
		if ( is_admin() ) {
			themeic_hello_motion_maybe_update_theme_version_in_db();
		}

		if ( apply_filters( 'themeic_hello_motion_register_menus', true ) ) {
			register_nav_menus( [ 'menu-1' => esc_html__( 'Header', 'hello-motion' ) ] );
			register_nav_menus( [ 'menu-2' => esc_html__( 'Footer', 'hello-motion' ) ] );
		}

		if ( apply_filters( 'themeic_hello_motion_post_type_support', true ) ) {
			add_post_type_support( 'page', 'excerpt' );
		}

		if ( apply_filters( 'themeic_hello_motion_add_theme_support', true ) ) {
			add_theme_support( 'post-thumbnails' );
			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'title-tag' );
			add_theme_support(
				'html5',
				[
					'search-form',
					'comment-form',
					'comment-list',
					'gallery',
					'caption',
					'script',
					'style',
					'navigation-widgets',
				]
			);
			add_theme_support(
				'custom-logo',
				[
					'height'      => 100,
					'width'       => 350,
					'flex-height' => true,
					'flex-width'  => true,
				]
			);
			add_theme_support( 'align-wide' );
			add_theme_support( 'responsive-embeds' );

			/*
			 * Editor Styles
			 */
			add_theme_support( 'editor-styles' );
			add_editor_style( 'assets/css/editor-styles.css' );

			/*
			 * WooCommerce.
			 */
			if ( apply_filters( 'themeic_hello_motion_add_woocommerce_support', true ) ) {
				// WooCommerce in general.
				add_theme_support( 'woocommerce' );
				// Enabling WooCommerce product gallery features (are off by default since WC 3.0.0).
				// zoom.
				add_theme_support( 'wc-product-gallery-zoom' );
				// lightbox.
				add_theme_support( 'wc-product-gallery-lightbox' );
				// swipe.
				add_theme_support( 'wc-product-gallery-slider' );
			}
		}
	}
}
add_action( 'after_setup_theme', 'themeic_hello_motion_setup' );

function themeic_hello_motion_maybe_update_theme_version_in_db() {
	$theme_version_option_name = 'themeic_hello_motion_version';
	// The theme version saved in the database.
	$themeic_hello_motion_db_version = get_option( $theme_version_option_name );

	// If the 'themeic_hello_motion_version' option does not exist in the DB, or the version needs to be updated, do the update.
	if ( ! $themeic_hello_motion_db_version || version_compare( $themeic_hello_motion_db_version, THEMEIC_HELLO_MOTION_VERSION, '<' ) ) {
		update_option( $theme_version_option_name, THEMEIC_HELLO_MOTION_VERSION );
	}
}

if ( ! function_exists( 'themeic_hello_motion_display_header_footer' ) ) {
	/**
	 * Check whether to display header footer.
	 *
	 * @return bool
	 */
	function themeic_hello_motion_display_header_footer() {
		$themeic_hello_motion_header_footer = true;

		return apply_filters( 'themeic_hello_motion_header_footer', $themeic_hello_motion_header_footer );
	}
}

if ( ! function_exists( 'themeic_hello_motion_scripts_styles' ) ) {
	/**
	 * Theme Scripts & Styles.
	 *
	 * @return void
	 */
	function themeic_hello_motion_scripts_styles() {
		if ( apply_filters( 'themeic_hello_motion_enqueue_style', true ) ) {
			wp_enqueue_style(
				'themeic-hello-motion',
				THEMEIC_HELLO_MOTION_STYLE_URL . 'reset.css',
				[],
				THEMEIC_HELLO_MOTION_VERSION
			);
		}

		if ( apply_filters( 'themeic_hello_motion_enqueue_theme_style', true ) ) {
			wp_enqueue_style(
				'themeic-hello-motion-theme-style',
				THEMEIC_HELLO_MOTION_STYLE_URL . 'theme.css',
				[],
				THEMEIC_HELLO_MOTION_VERSION
			);
		}

		if ( themeic_hello_motion_display_header_footer() ) {
			wp_enqueue_style(
				'themeic-hello-motion-header-footer',
				THEMEIC_HELLO_MOTION_STYLE_URL . 'header-footer.css',
				[],
				THEMEIC_HELLO_MOTION_VERSION
			);
		}
	}
}
add_action( 'wp_enqueue_scripts', 'themeic_hello_motion_scripts_styles' );

if ( ! function_exists( 'themeic_hello_motion_register_theme_locations' ) ) {
	/**
	 * Register Elementor Locations.
	 *
	 * @param ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $locations_manager Locations manager.
	 *
	 * @return void
	 */
	function themeic_hello_motion_register_theme_locations( $locations_manager ) {
		if ( apply_filters( 'themeic_hello_motion_register_theme_locations', true ) ) {
			$locations_manager->register_all_core_location();
		}
	}
}
add_action( 'elementor/theme/register_locations', 'themeic_hello_motion_register_theme_locations' );

if ( ! function_exists( 'themeic_hello_motion_content_width' ) ) {
	/**
	 * Set default content width.
	 *
	 * @return void
	 */
	function themeic_hello_motion_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'themeic_hello_motion_content_width', 800 );
	}
}
add_action( 'after_setup_theme', 'themeic_hello_motion_content_width', 0 );

if ( ! function_exists( 'themeic_hello_motion_add_description_meta_tag' ) ) {
	/**
	 * Add description meta tag with excerpt text.
	 *
	 * @return void
	 */
	function themeic_hello_motion_add_description_meta_tag() {
		if ( ! apply_filters( 'themeic_hello_motion_description_meta_tag', true ) ) {
			return;
		}

		if ( ! is_singular() ) {
			return;
		}

		$post = get_queried_object();
		if ( empty( $post->post_excerpt ) ) {
			return;
		}

		echo '<meta name="description" content="' . esc_attr( wp_strip_all_tags( $post->post_excerpt ) ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'themeic_hello_motion_add_description_meta_tag' );

// Settings page
require get_template_directory() . '/includes/settings-functions.php';

// Header & footer styling option, inside Elementor
require get_template_directory() . '/includes/elementor-functions.php';

if ( ! function_exists( 'themeic_hello_motion_customizer' ) ) {
	// Customizer controls
	function themeic_hello_motion_customizer() {
		if ( ! is_customize_preview() ) {
			return;
		}

		if ( ! themeic_hello_motion_display_header_footer() ) {
			return;
		}

		require get_template_directory() . '/includes/customizer-functions.php';
	}
}
add_action( 'init', 'themeic_hello_motion_customizer' );

if ( ! function_exists( 'themeic_hello_motion_get_header_menu_id' ) ) {
	/**
	 * Menu selected for the header in the Customizer (0 = use the Header theme location).
	 *
	 * @return int
	 */
	function themeic_hello_motion_get_header_menu_id() {
		return (int) get_theme_mod( 'themeic-hello-motion-header-menu', 0 );
	}
}

if ( ! function_exists( 'themeic_hello_motion_get_footer_menu_id' ) ) {
	/**
	 * Menu selected for the footer in the Customizer (0 = use the Footer theme location).
	 *
	 * @return int
	 */
	function themeic_hello_motion_get_footer_menu_id() {
		return (int) get_theme_mod( 'themeic-hello-motion-footer-menu', 0 );
	}
}

if ( ! function_exists( 'themeic_hello_motion_get_header_logo_id' ) ) {
	/**
	 * Attachment ID of the header logo uploaded in the Customizer (0 = none).
	 *
	 * @return int
	 */
	function themeic_hello_motion_get_header_logo_id() {
		return (int) get_theme_mod( 'themeic-hello-motion-header-logo', 0 );
	}
}

if ( ! function_exists( 'themeic_hello_motion_get_footer_logo_id' ) ) {
	/**
	 * Attachment ID of the footer logo uploaded in the Customizer (0 = none).
	 *
	 * @return int
	 */
	function themeic_hello_motion_get_footer_logo_id() {
		return (int) get_theme_mod( 'themeic-hello-motion-footer-logo', 0 );
	}
}

if ( ! function_exists( 'themeic_hello_motion_get_footer_copyright' ) ) {
	/**
	 * Copyright text set in the Customizer.
	 *
	 * Falls back to the Elementor Site Settings value when the Customizer
	 * field is empty.
	 *
	 * @return string
	 */
	function themeic_hello_motion_get_footer_copyright() {
		$copyright = (string) get_theme_mod( 'themeic-hello-motion-footer-copyright', '' );

		if ( '' !== trim( $copyright ) ) {
			return $copyright;
		}

		return (string) themeic_hello_motion_get_setting( 'hello_footer_copyright_text' );
	}
}

if ( ! function_exists( 'themeic_hello_motion_get_logo_html' ) ) {
	/**
	 * Markup for a logo, linked to the home page.
	 *
	 * @param int    $logo_id Attachment ID of the logo.
	 * @param string $alt     Alt text fallback.
	 *
	 * @return string Empty string when there is no logo to show.
	 */
	function themeic_hello_motion_get_logo_html( $logo_id, $alt = '' ) {
		if ( $logo_id ) {
			$image = wp_get_attachment_image(
				$logo_id,
				'full',
				false,
				[
					'class' => 'custom-logo themeic-hello-motion-logo',
					'alt'   => $alt,
				]
			);

			if ( $image ) {
				return sprintf(
					'<a href="%1$s" class="custom-logo-link" rel="home">%2$s</a>',
					esc_url( home_url( '/' ) ),
					$image
				);
			}
		}

		if ( has_custom_logo() ) {
			return get_custom_logo();
		}

		return '';
	}
}

if ( ! function_exists( 'themeic_hello_motion_get_header_logo_html' ) ) {
	/**
	 * Markup for the header logo: the Customizer logo, falling back to the
	 * site logo from Site Identity, then to an empty string.
	 *
	 * @param string $alt Alt text fallback.
	 *
	 * @return string
	 */
	function themeic_hello_motion_get_header_logo_html( $alt = '' ) {
		return themeic_hello_motion_get_logo_html( themeic_hello_motion_get_header_logo_id(), $alt );
	}
}

if ( ! function_exists( 'themeic_hello_motion_get_footer_logo_html' ) ) {
	/**
	 * Markup for the footer logo.
	 *
	 * @param string $alt Alt text fallback.
	 *
	 * @return string
	 */
	function themeic_hello_motion_get_footer_logo_html( $alt = '' ) {
		return themeic_hello_motion_get_logo_html( themeic_hello_motion_get_footer_logo_id(), $alt );
	}
}

if ( ! function_exists( 'themeic_hello_motion_check_hide_title' ) ) {
	/**
	 * Check whether to display the page title.
	 *
	 * @param bool $val default value.
	 *
	 * @return bool
	 */
	function themeic_hello_motion_check_hide_title( $val ) {
		if ( defined( 'ELEMENTOR_VERSION' ) ) {
			$current_doc = Elementor\Plugin::instance()->documents->get( get_the_ID() );
			if ( $current_doc && 'yes' === $current_doc->get_settings( 'hide_title' ) ) {
				$val = false;
			}
		}
		return $val;
	}
}
add_filter( 'themeic_hello_motion_page_title', 'themeic_hello_motion_check_hide_title' );

/**
 * BC:
 * In v2.7.0 the theme removed the `themeic_hello_motion_body_open()` from `header.php` replacing it with `wp_body_open()`.
 * The following code prevents fatal errors in child themes that still use this function.
 */
if ( ! function_exists( 'themeic_hello_motion_body_open' ) ) {
	function themeic_hello_motion_body_open() {
		wp_body_open();
	}
}

require THEMEIC_HELLO_MOTION_PATH . '/theme.php';

ThemeicHelloMotion\Theme::instance();
