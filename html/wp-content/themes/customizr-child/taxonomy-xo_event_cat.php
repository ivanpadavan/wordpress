<?php
function doCalendarShortcode() {
	[ $date_from, $date_to ] = getDates();
	[ $year, $month ] = array_map( fn( $s ) => $date_from->format( $s ), [ 'Y', 'm' ] );
	$diff       = $date_from->diff( $date_to );
	$months     = $diff->y * 12 + $diff->m + 1;
	$categories = get_queried_object()->slug;
	echo do_shortcode( "[xo_event_calendar year=$year month=$month months=$months categories=$categories navigation=false]" );
}

add_action( '__before_loop', function () {
	do_action( '__before_pills' );
	?>
  <ul class="nav nav-pills" id="select-view">
    <li class="nav-item active">
      <a class="nav-link" href="#">
        <i class="fa fa-map-marked-alt"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">
        <i class="fa fa-calendar-alt"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">
        <i class="fa fa-th-large"></i>
      </a>
    </li>
  </ul>
  <script>
      var $ = jQuery;
      var s = '#select-view li';
      $(s).on('click', function () {
          $(s).removeClass('active');
          $(this).addClass('active');
      });

      var pill_content_classes = [
          '.posts-map',
          '.posts-calendar',
          '.posts-grid',
      ];
      pill_content_classes.forEach(function (v, i) {
          $(s).eq(i).on('click', function () {
              pill_content_classes.forEach(function (c) {
                  $(c).addClass('d-none');
              })
              $(v).removeClass('d-none');
          })
      })

  </script>
  <div class="posts-grid d-none">
	  <?php
	  } );
	  add_action( '__after_loop', function () {
	  ?>
  </div>
  <div class="posts-calendar d-none">
	  <?php doCalendarShortcode() ?>
  </div>
  <div class="posts-map">
	  <?php
	  function render_map() {
		  if ( have_posts() ) {
			  $shortcode  = '[yamap height="50vh" type="yandex#map" controls="typeSelector;zoomControl" auto-bounds=1]';
			  $placemarks = [];
			  while ( have_posts() ) {
				  the_post();
				  $custom = (array) json_decode( get_field( 'coordinates', get_field( 'place' ) ) );
				  [ 'coords' => [ 0 => $lon, 1 => $lat ], 'icon' => $icon ] = $custom;

				  if ( $lat && $lon ) {
					  $placemarks[] = [
						  'coord'    => $lon . ',' . $lat,
						  'url'      => get_permalink(),
						  'icon'     => $icon,
						  'name'     => get_the_title(),
						  'place_id' => get_field( 'place' )->ID,
					  ];
					  $shortcode    .= '[yaplacemark coord="' . $lon . ',' . $lat . '" url="' . get_permalink() . '" icon="' . $icon . '" name="' . get_the_title() . '"]';
				  }
			  }
			  $shortcode .= '[/yamap]';

			  $group     = array();

			  foreach ( $placemarks as $placemark ) {
				  $group[ $placemark['place_id'] ][] = $placemark;
			  }
			  // print__r( $group );

			  echo do_shortcode( $shortcode );
		  }
	  }

	  rewind_posts();
	  render_map();
	  ?>
  </div>
	<?php
} );

add_filter(
	'xo_event_calendar_month',
	fn( $html, $args, $month_index, $events ) => empty( $events ) ? '' : $html,
	10,
	4,
);

require_once 'archive-xo_event.php';
