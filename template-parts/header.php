<?php
/**
 * The template for displaying header.
 *
 * @package ThemeicHelloMotion
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$site_name = get_bloginfo( 'name' );
$tagline   = get_bloginfo( 'description', 'display' );
$header_nav_menu = wp_nav_menu( [
	'theme_location' => 'menu-1',
	'menu'           => themeic_hello_motion_get_header_menu_id(),
	'fallback_cb'    => false,
	'container'      => false,
	'echo'           => false,
] );
$header_logo = themeic_hello_motion_get_header_logo_html( $site_name );
?>

<header id="hm-site-header" class="hm-site-header">

	<div class="site-branding">
		<?php
		if ( $header_logo ) {
			echo $header_logo; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		} elseif ( $site_name ) {
			?>
			<div class="site-title">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr__( 'Home', 'hello-motion' ); ?>" rel="home">
					<?php echo esc_html( $site_name ); ?>
				</a>
			</div>
			<?php if ( $tagline ) : ?>
			<p class="site-description">
				<?php echo esc_html( $tagline ); ?>
			</p>
			<?php endif; ?>
		<?php } ?>
	</div>

	<?php if ( $header_nav_menu ) : ?>
		<nav class="site-navigation" aria-label="<?php echo esc_attr__( 'Main menu', 'hello-motion' ); ?>">
			<?php
			// PHPCS - escaped by WordPress with "wp_nav_menu"
			echo $header_nav_menu; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			?>
		</nav>
	<?php endif; ?>
</header>
