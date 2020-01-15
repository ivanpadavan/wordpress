<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package ezy
 */
get_header();
?>
	<section id="primary" class="content-area col-sm-12 col-md-12">
		<main id="main" class="site-main" role="main">
		<?php
		
		if ( have_posts() ) : ?>

			<div>
				<h3 class="page-title">
					<?php printf( esc_html__( 'New Serach For : %s', 'ezy' ), '<span>' . get_search_query() . '</span>' ); ?>
				</h3>
			</div><!-- .page-header -->

			<?php

			/* Start the Loop */

			while ( have_posts() ) : the_post();
				/**

				 * Run the loop for the search to output the results.

				 * If you want to overload this in a child theme then include a file

				 * called content-search.php and that will be used instead.

				 */

				get_template_part( 'template-parts/content', 'search' );

			endwhile;
			
			do_action('ezy_action_navigation');

		else :
			get_template_part( 'template-parts/content', 'none' );
		endif; ?>
		</main><!-- #main -->

	</section><!-- #primary -->
<?php
get_footer();

