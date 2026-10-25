<?php
/**
 * The template for displaying footer.
 *
 * @package ThemeicHelloMotion
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$is_editor = isset( $_GET['elementor-preview'] );
$site_name = get_bloginfo( 'name' );
$tagline   = get_bloginfo( 'description', 'display' );
$footer_class = did_action( 'elementor/loaded' ) ? themeic_hello_motion_get_footer_layout_class() : '';
$footer_nav_menu = wp_nav_menu( [
	'theme_location' => 'menu-2',
	'menu'           => themeic_hello_motion_get_footer_menu_id(),
	'fallback_cb'    => false,
	'container'      => false,
	'echo'           => false,
] );
$footer_logo = themeic_hello_motion_get_footer_logo_html( $site_name );
$footer_logo_type = themeic_hello_motion_get_setting( 'hello_footer_logo_type' );
$footer_copyright = themeic_hello_motion_get_footer_copyright();

// A logo picked in the Customizer takes precedence over the Site Settings type.
if ( $footer_logo ) {
	$footer_logo_type = 'logo';
}
?>
<footer id="site-footer" class="site-footer dynamic-footer <?php echo esc_attr( $footer_class ); ?>">
	<div class="footer-inner">
		<div class="site-branding show-<?php echo esc_attr( $footer_logo_type ); ?>">
			<?php if ( $footer_logo && ( 'title' !== $footer_logo_type || $is_editor ) ) : ?>
				<div class="site-logo <?php echo esc_attr( themeic_hello_motion_show_or_hide( 'hello_footer_logo_display' ) ); ?>">
					<?php echo $footer_logo; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
			<?php endif;

			if ( $site_name && ( 'logo' !== $footer_logo_type || $is_editor ) ) : ?>
				<div class="site-title <?php echo esc_attr( themeic_hello_motion_show_or_hide( 'hello_footer_logo_display' ) ); ?>">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr__( 'Home', 'hello-motion' ); ?>" rel="home">
						<?php echo esc_html( $site_name ); ?>
					</a>
				</div>
			<?php endif;

			if ( $tagline || $is_editor ) : ?>
				<p class="site-description <?php echo esc_attr( themeic_hello_motion_show_or_hide( 'hello_footer_tagline_display' ) ); ?>">
					<?php echo esc_html( $tagline ); ?>
				</p>
			<?php endif; ?>
		</div>

		<?php if ( $footer_nav_menu ) : ?>
			<nav class="site-navigation <?php echo esc_attr( themeic_hello_motion_show_or_hide( 'hello_footer_menu_display' ) ); ?>" aria-label="<?php echo esc_attr__( 'Footer menu', 'hello-motion' ); ?>">
				<?php
				// PHPCS - escaped by WordPress with "wp_nav_menu"
				echo $footer_nav_menu; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				?>
			</nav>
		<?php endif; ?>

		<?php if ( '' !== $footer_copyright || $is_editor ) : ?>
			<div class="copyright <?php echo esc_attr( themeic_hello_motion_show_or_hide( 'hello_footer_copyright_display' ) ); ?>">
				<p><?php echo wp_kses_post( $footer_copyright ); ?></p>
			</div>
		<?php endif; ?>
	</div>
</footer>
