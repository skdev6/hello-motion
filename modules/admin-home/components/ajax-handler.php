<?php

namespace ThemeicHelloMotion\Modules\AdminHome\Components;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Ajax_Handler {

	public function __construct() {
		add_action( 'wp_ajax_themeic_hello_motion_install_builder_plugin', [ $this, 'install_builder_plugin' ] );
	}

	public function install_builder_plugin() {
		wp_ajax_install_plugin();
	}
}
