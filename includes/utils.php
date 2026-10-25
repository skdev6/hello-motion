<?php

namespace ThemeicHelloMotion\Includes;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * class Utils
 **/
class Utils {

	public static function has_pro(): bool {
		return defined( 'ELEMENTOR_PRO_VERSION' );
	}

	public static function is_builder_plugin_active(): bool {
		static $builder_plugin_active = null;
		if ( null === $builder_plugin_active ) {
			$builder_plugin_active = defined( 'ELEMENTOR_VERSION' );
		}

		return $builder_plugin_active;
	}

	public static function is_builder_plugin_installed(): bool {
		static $builder_plugin_installed = null;
		if ( null === $builder_plugin_installed ) {
			$builder_plugin_installed = file_exists( WP_PLUGIN_DIR . '/elementor/elementor.php' );
		}

		return $builder_plugin_installed;
	}

	public static function get_builder_plugin_activation_link(): string {
		$plugin = 'elementor/elementor.php';

		$url = 'plugins.php?action=activate&plugin=' . $plugin . '&plugin_status=all';

		return add_query_arg( '_wpnonce', wp_create_nonce( 'activate-plugin_' . $plugin ), $url );
	}

	public static function get_action_link_type() {
		$installed_plugins = get_plugins();

		if ( ! isset( $installed_plugins['elementor/elementor.php'] ) ) {
			$action_link_type = 'install-elementor';
		} elseif ( ! defined( 'ELEMENTOR_VERSION' ) ) {
			$action_link_type = 'activate-elementor';
		} elseif ( ! themeic_hello_motion_header_footer_experiment_active() ) {
			$action_link_type = 'activate-header-footer-experiment';
		} else {
			$action_link_type = 'style-header-footer';
		}
		return $action_link_type;
	}
}
