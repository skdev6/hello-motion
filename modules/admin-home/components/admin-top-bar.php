<?php

namespace ThemeicHelloMotion\Modules\AdminHome\Components;

use ThemeicHelloMotion\Includes\Script;
use ThemeicHelloMotion\Includes\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Admin_Top_Bar {

	const CONFIG_OBJECT_NAME = 'themeicHelloMotionTopBarConfig';
	const UPGRADE_PRO_URL = 'https://go.elementor.com/go-pro-hello-theme-upgrade-top-bar/';

	private function render_admin_top_bar() {
		?>
		<div id="themeic-hello-motion-admin-top-bar-root" style="height: 50px">
		</div>
		<?php
	}

	private function is_top_bar_active() {
		$current_screen = get_current_screen();

		return ( false !== strpos( $current_screen->id ?? '', THEMEIC_HELLO_MOTION_SLUG ) );
	}

	private function enqueue_scripts() {
		$script = new Script(
			'themeic-hello-motion-topbar',
		);

		$script->enqueue();

		if ( Utils::has_pro() ) {
			return;
		}

		wp_localize_script(
			'themeic-hello-motion-topbar',
			self::CONFIG_OBJECT_NAME,
			[ 'upgradeUrl' => self::UPGRADE_PRO_URL ]
		);
	}

	public function __construct() {
		if ( ! is_admin() ) {
			return;
		}

		add_action( 'current_screen', function () {
			if ( ! $this->is_top_bar_active() ) {
				return;
			}

			add_action( 'in_admin_header', function () {
				$this->render_admin_top_bar();
			} );

			add_action( 'admin_enqueue_scripts', function () {
				$this->enqueue_scripts();
			} );

			if ( defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, '3.34.2', '<' ) ) {
				add_action( 'elementor/admin-top-bar/is-active', '__return_false' );
			}
		} );
	}
}
