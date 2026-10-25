<?php
/**
 * The shared page header: the title block shown at the top of every page.
 *
 * Called from the single, archive, search and 404 template parts with
 * `get_template_part( 'template-parts/page-header' )`.
 *
 * Whether the block is printed is controlled by the
 * `themeic_hello_motion_page_title` filter (see themeic_hello_motion_check_hide_title()).
 *
 * @package ThemeicHelloMotion
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! apply_filters( 'themeic_hello_motion_page_title', true ) ) {
	return;
}
?>

<div class="page-header">
	<?php
	if ( is_404() ) {
		echo '<h1 class="entry-title">' . esc_html__( 'The page can&rsquo;t be found.', 'hello-motion' ) . '</h1>';
	} elseif ( is_search() ) {
		?>
		<h1 class="entry-title">
			<?php echo esc_html__( 'Search results for: ', 'hello-motion' ); ?>
			<span><?php echo get_search_query(); ?></span>
		</h1>
		<?php
	} elseif ( is_archive() || is_home() ) {
		the_archive_title( '<h1 class="entry-title">', '</h1>' );
		the_archive_description( '<p class="archive-description">', '</p>' );
	} else {
		the_title( '<h1 class="entry-title">', '</h1>' );
	}
	?>
</div>