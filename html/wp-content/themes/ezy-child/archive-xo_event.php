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
			<?php

			function try_set_date($date_string, $fallback) {
				if (isset($date_string)) {
					try {
						return new DateTime( $date_string );
					} catch ( Exception $e ) {}
				}
				return new DateTime( $fallback );
			}

			$date_from = try_set_date($_GET['from'] ?? null, 'first day of january');
			$date_to = try_set_date($_GET['to'] ?? null, 'first day of december');

			if ($date_from > $date_to) {
				$date_to = new DateTime('now');
			}

			[$year, $month] = array_map(fn($s) => $date_from->format($s), ['Y', 'm']);
  		$diff = $date_from->diff($date_to);
			$months = $diff->y * 12 + $diff->m + 1;
			echo '<article class="post"><div class="post-wrapper px pb mb">';
			echo do_shortcode("[xo_event_calendar year=$year month=$month months=$months navigation=false]");
			echo '</div></article>';

			do_action('ezy_action_navigation');
	?>

		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_sidebar();
get_footer();

