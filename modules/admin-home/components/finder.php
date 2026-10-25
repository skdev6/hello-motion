<?php

namespace ThemeicHelloMotion\Modules\AdminHome\Components;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Finder {

	public function add_theme_style_finder_entry( $categories_data ) {
		if ( isset( $categories_data['site'] ) && isset( $categories_data['site']['items'] ) ) {
			$categories_data['site']['items']['themeic-hello-motion-settings'] = [
				'title' => esc_html__( 'Hello Motion Settings', 'hello-motion' ),
				'icon' => 'paint-brush',
				'url' => admin_url( 'admin.php?page=themeic-hello-motion-settings' ),
				'keywords' => [ 'theme', 'hello', 'motion', 'home', 'settings' ],
			];
		}

		return $categories_data;
	}

	public function __construct() {
		add_filter( 'elementor/finder/categories', [ $this, 'add_theme_style_finder_entry' ] );
	}
}
