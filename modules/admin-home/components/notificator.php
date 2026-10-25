<?php
namespace ThemeicHelloMotion\Modules\AdminHome\Components;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Notificator {
	private ?\Elementor\WPNotificationsPackage\V120\Notifications $notificator = null;

	public function get_notifications_by_conditions( $force_request = false ) {
		if ( null === $this->notificator ) {
			return [];
		}

		return $this->notificator->get_notifications_by_conditions( $force_request );
	}

	public function __construct() {
		if ( ! $this->ensure_notifications_class_loaded() ) {
			return;
		}

		$this->notificator = new \Elementor\WPNotificationsPackage\V120\Notifications( [
			'app_name' => 'hello-motion',
			'app_version' => THEMEIC_HELLO_MOTION_VERSION,
			'short_app_name' => 'hello-motion',
			'app_data' => [
				'theme_name' => 'hello-motion',
			],
		] );
	}

	private function ensure_notifications_class_loaded(): bool {
		if ( class_exists( 'Elementor\WPNotificationsPackage\V120\Notifications' ) ) {
			return true;
		}

		$builder_plugin_autoload = defined( 'ELEMENTOR_PATH' )
			? ELEMENTOR_PATH . 'vendor/autoload.php'
			: WP_PLUGIN_DIR . '/elementor/vendor/autoload.php';

		if ( file_exists( $builder_plugin_autoload ) ) {
			require_once $builder_plugin_autoload;
		}

		if ( class_exists( 'Elementor\WPNotificationsPackage\V120\Notifications' ) ) {
			return true;
		}

		$themeic_hello_motion_autoload = THEMEIC_HELLO_MOTION_PATH . '/vendor/autoload.php';
		if ( file_exists( $themeic_hello_motion_autoload ) ) {
			require_once $themeic_hello_motion_autoload;
		}

		return class_exists( 'Elementor\WPNotificationsPackage\V120\Notifications' );
	}
}
