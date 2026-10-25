<?php

namespace ThemeicHelloMotion\Modules\AdminHome\Components;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Admin_Menu_Controller {

	const MENU_PAGE_ICON = 'dashicons-plus-alt';
	const MENU_PAGE_POSITION = 59.9;

	public function admin_menu(): void {
		$page_hook = add_menu_page(
			__( 'Hello Motion', 'hello-motion' ),
			__( 'Hello Motion', 'hello-motion' ),
			'manage_options',
			THEMEIC_HELLO_MOTION_SLUG,
			'__return_null',
			self::MENU_PAGE_ICON,
			self::MENU_PAGE_POSITION
		);

		add_action( 'load-' . $page_hook, [ $this, 'redirect_to_settings' ] );

		do_action( 'themeic-hello-motion/admin-menu', THEMEIC_HELLO_MOTION_SLUG );
	}

	public function redirect_to_settings(): void {
		wp_safe_redirect( admin_url( 'admin.php?page=' . Settings_Controller::SETTINGS_PAGE_SLUG ) );
		exit;
	}

	public function remove_duplicated_parent_submenu(): void {
		remove_submenu_page( THEMEIC_HELLO_MOTION_SLUG, THEMEIC_HELLO_MOTION_SLUG );
	}

	public function __construct() {
		add_action( 'admin_menu', [ $this, 'admin_menu' ] );
		add_action( 'admin_menu', [ $this, 'remove_duplicated_parent_submenu' ], 999 );
	}
}
