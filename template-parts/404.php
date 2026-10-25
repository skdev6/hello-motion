<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package ThemeicHelloMotion
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<main id="content" class="site-main">

	<?php get_template_part( 'template-parts/page-header' ); ?>

	<div class="page-content">
		<p><?php echo esc_html__( 'It looks like nothing was found at this location.', 'hello-motion' ); ?></p>
	</div>

</main>
