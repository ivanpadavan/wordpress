<?php

add_action( 'widgets_init', fn() => register_widget( NearestEventsWidget::class ) );

class NearestEventsWidget extends WP_Widget {
	protected static $defaults = [ 'title' => 'Ближайшие события' ];

	//process our new widget
	function __construct() {

		$widget_ops = array(
			'classname'   => 'prowp_widget_class',
			'description' => 'Example widget that displays
 a user\'s bio.'
		);
		parent::__construct( 'prowp_widget', 'Bio Widget', array_merge( self::$defaults, $widget_ops ) );
	}

	//build our widget settings form
	function form( $instance ) {
		global $xo_event_calendar;

		$instance = wp_parse_args( $instance, self::$defaults );
		$title    = $instance['title'];

		echo '<ul>';
		$termslist = wp_terms_checklist(0, [
			'taxonomy' => XO_EVENT_CALENDAR_EVENT_TAXONOMY,
			'selected_cats' => $instance['terms'],
			'echo' => false,
		]);
		$name='name="widget-'.$this->id_base.'['.$this->number.'][terms][]"';
		echo preg_replace('/name="(.*?)"/', $name, $termslist);
		echo '</ul>';

		?><p>Title:
      <input class="widefat" name="<?php
	  echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>"/>
      </p>
		<?php
	}

	//save our widget settings
	function update( $new_instance, $old_instance ) {
		$instance = array_merge( self::$defaults, $new_instance );
		return $instance;
	}

	//display our widget
	function widget( $args, $instance ) {
		global $xo_event_calendar;

		[
			'before_widget' => $before_widget,
			'before_title'  => $before_title,
			'after_title'   => $after_title,
			'after_widget'  => $after_widget,
		] = $args;


		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $before_widget;
		if ( ! empty( $title ) ) {
			echo $before_title . esc_html( $title ) . $after_title;
		}
		$events = $xo_event_calendar->get_nearest_events(new DateTime(), 5, $instance['terms']);
		echo "<p><ul>";
		foreach ( $events as ['title' => $title, 'permalink' => $permalink] ) {
			echo "<li><a href='$permalink'>$title</a></li>";
		}
		echo "</ul></p>";
		echo $after_widget;
	}

}
