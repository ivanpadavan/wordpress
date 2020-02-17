<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ezy
 */
get_header();
global $ezy_theme_options;

$designlayout = $ezy_theme_options['ezy-layout'];

$side_col = 'right-s-bar ';

if( 'left-sidebar' == $designlayout ){

	$side_col = 'left-s-bar';
}
?>
	<div id="primary" class="content-area col-sm-8 col-md-8 <?php echo esc_attr( $side_col );?>">
		<main id="main" class="site-main" role="main">

			<div class="archive-heading-wrapper">
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</div><!-- .page-header -->
      <div class="post-wrapper mb">
			<?php

      render_map();

			do_action('ezy_action_navigation');
	?>
      </div>
		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_sidebar();
get_footer();

