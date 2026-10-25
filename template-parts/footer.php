<?php
/**
 * The template for displaying footer.
 *
 * @package ThemeicHelloMotion
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$footer_nav_menu = wp_nav_menu( [
	'theme_location' => 'menu-2',
	'menu'           => themeic_hello_motion_get_footer_menu_id(),
	'fallback_cb'    => false,
	'container'      => false,
	'echo'           => false,
] );
?>
<footer id="site-footer" class="site-footer">
	<?php if ( $footer_nav_menu ) : ?>
		<nav class="site-navigation" aria-label="<?php echo esc_attr__( 'Footer menu', 'hello-motion' ); ?>">
			<?php
			// PHPCS - escaped by WordPress with "wp_nav_menu"
			echo $footer_nav_menu; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			?>
		</nav>
	<?php endif; ?>
</footer>
