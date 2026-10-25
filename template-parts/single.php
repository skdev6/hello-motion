<?php
/**
 * The template for displaying singular post-types: posts, pages and user-defined custom post types.
 *
 * @package ThemeicHelloMotion
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

while ( have_posts() ) :
	the_post();
	?>

<main id="content" <?php post_class( 'site-main' ); ?>>

	<?php get_template_part( 'template-parts/page-header' ); ?>

	<div class="page-content">
		<?php the_content(); ?>

		<?php wp_link_pages(); ?>

		<?php if ( has_tag() ) : ?>
		<div class="post-tags">
			<?php the_tags( '<span class="tag-links">' . esc_html__( 'Tagged ', 'hello-motion' ), ', ', '</span>' ); ?>
		</div>
		<?php endif; ?>
	</div>

	<?php comments_template(); ?>

</main>

	<?php
endwhile;
