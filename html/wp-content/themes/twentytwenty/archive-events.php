<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since 1.0.0
 */

function render_calendar() {
  $my_posts = array();
  $dates = array();
	if (have_posts()) {
		while ( have_posts() ) {
			the_post();
			$custom = get_post_custom();
			$date_from = date_create_from_format('Ymd', $custom['date_from'][0]);
			$date_to = date_create_from_format('Ymd', $custom['date_to'][0]);
			$place_id = $custom['place'][0];
			global $post;

			array_push($dates, $date_from);
			array_push($dates, $date_to);

			array_push($my_posts, array(
				'title' => $post->post_title,
				'date_from' => $date_from,
				'date_to' => $date_to,
				'place_id' => $place_id,
			));
		}
	}
	$place_ids = array_unique(array_map(function ($v) { return $v['place_id']; }, $my_posts));
	$places = array();
	$places_query = new WP_Query(array(
		'post_type' => 'places',
		'post__in' => $place_ids
		));
	if ($places_query->have_posts()) {
		while ( $places_query->have_posts() ) {
			$places_query->the_post();
			$places[$post->ID] = $post;
		}
	}
	wp_reset_postdata();

	$min_date = min($dates);
	$max_date = max($dates);

	$min_date_year = date_format($min_date, 'Y');
	$min_date_month = date_format($min_date, 'n');

	$max_date_year = date_format($max_date, 'Y');
	$max_date_month = date_format($max_date, 'n');

	echo $min_date_year.'<br>'.$min_date_month.'<br>';
	echo $max_date_year.'<br>'.$max_date_month.'<br>';

	foreach (range($min_date_year, $max_date_year) as $year) {
		echo "<h3>$year</h3>";
		if ($year == $min_date_year && $year == $max_date_year) {
			foreach (range($min_date_month, $max_date_month) as $month) {
				echo "<b>$month </b>";
			}
		} elseif ($year == $min_date_year) {
			foreach (range($min_date_month, 12) as $month) {
				echo "<b>$month </b>";
			}
		} elseif ($year == $max_date_year) {
			foreach (range(1, $max_date_month) as $month) {
				echo "<b>$month </b>";
			}
		}
	}

	foreach ($my_posts as $key => $value)
		$my_posts[$key]['place'] = $places[$my_posts[$key]['place_id']];

	echo json_encode($my_posts);

}

get_header();
?>

<main id="site-content" role="main">

	<?php

	$archive_title    = '';
	$archive_subtitle = '';

	if ( is_search() ) {
		global $wp_query;

		$archive_title = sprintf(
			'%1$s %2$s',
			'<span class="color-accent">' . __( 'Search:', 'twentytwenty' ) . '</span>',
			'&ldquo;' . get_search_query() . '&rdquo;'
		);

		if ( $wp_query->found_posts ) {
			$archive_subtitle = sprintf(
				/* translators: %s: Number of search results */
				_n(
					'We found %s result for your search.',
					'We found %s results for your search.',
					$wp_query->found_posts,
					'twentytwenty'
				),
				number_format_i18n( $wp_query->found_posts )
			);
		} else {
			$archive_subtitle = __( 'We could not find any results for your search. You can give it another try through the search form below.', 'twentytwenty' );
		}
	} elseif ( ! is_home() ) {
		$archive_title    = get_the_archive_title();
		$archive_subtitle = get_the_archive_description();
	}

	if ( $archive_title || $archive_subtitle ) {
		?>

		<header class="archive-header has-text-align-center header-footer-group">

			<div class="archive-header-inner section-inner medium">

				<?php if ( $archive_title ) { ?>
					<h1 class="archive-title"><?php echo wp_kses_post( $archive_title ); ?></h1>
				<?php } ?>

				<?php if ( $archive_subtitle ) { ?>
					<div class="archive-subtitle section-inner thin max-percentage intro-text"><?php echo wp_kses_post( wpautop( $archive_subtitle ) ); ?></div>
				<?php } ?>

			</div><!-- .archive-header-inner -->

		</header><!-- .archive-header -->

		<?php
	}

	if ( have_posts() ) {
		render_calendar();

	} elseif ( is_search() ) {
		?>

		<div class="no-search-results-form section-inner thin">

			<?php
			get_search_form(
				array(
					'label' => __( 'search again', 'twentytwenty' ),
				)
			);
			?>

		</div><!-- .no-search-results -->

		<?php
	}
	?>

	<?php get_template_part( 'template-parts/pagination' ); ?>

</main><!-- #site-content -->

<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php
get_footer();
