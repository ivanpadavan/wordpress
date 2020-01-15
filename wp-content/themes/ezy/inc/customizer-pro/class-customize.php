<?php
/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class Ezy_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function sections( $manager ) {

		// Load custom sections.
		require_once get_template_directory() . '/inc/customizer-pro/section-pro.php';

		// Register custom section types.
		$manager->register_section_type( 'Ezy_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section(
			new Ezy_Customize_Section_Pro(
				$manager,
				'ezy',
				array(
					'title'    => esc_html__( 'Premium Verison', 'ezy' ),
					'pro_text' => esc_html__( 'Upgrade To Pro',  'ezy' ),
					'pro_url'  => 'https://www.templatesell.com/item/ezy-pro/',
					'priority' => 0
				)
			)
		);
	}


	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {
		require_once get_template_directory() . '/inc/customizer-pro/section-pro.php';


		wp_enqueue_script( 'ezy-customize-controls', trailingslashit( get_template_directory_uri() ) . '/inc/customizer-pro/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'ezy-customize-controls', trailingslashit( get_template_directory_uri() ) . '/inc/customizer-pro/customize-controls.css' );
	}
}

// Doing this customizer thang!
Ezy_Customize::get_instance();


if ( ! class_exists( 'Ezy_Customize_Static_Text_Control' ) ){
if ( ! class_exists( 'WP_Customize_Control' ) )
    return NULL;
class Ezy_Customize_Static_Text_Control extends WP_Customize_Control {
	/**
	 * Control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'static-text';

	public function __construct( $manager, $id, $args = array() ) {
		parent::__construct( $manager, $id, $args );
	}

	protected function render_content() {
			?>
		<div class="description customize-control-description">
			
			<h2><?php esc_html_e('About Ezy', 'ezy')?></h2>
			<p><?php esc_html_e('Ezy is simple, clean and elegant WordPress Theme for your blog site.', 'ezy')?> </p>
			<p>
				<a href="<?php echo esc_url('http://demo.canyonthemes.com/ezy'); ?>" target="_blank"><?php esc_html_e( 'Ezy Demo', 'ezy' ); ?></a>
			</p>
			<h3><?php esc_html_e('Documentation', 'ezy')?></h3>
			<p><?php esc_html_e('Read documentation to learn more about theme.', 'ezy')?> </p>
			<p>
				<a href="<?php echo esc_url('http://doc.canyonthemes.com/ezy/'); ?>" target="_blank"><?php esc_html_e( 'Ezy Documentation', 'ezy' ); ?></a>
			</p>
			
			<h3><?php esc_html_e('Support', 'ezy')?></h3>
			<p><?php esc_html_e('For support, Kindly contact us and we would be happy to assist!', 'ezy')?> </p>
			
			<p>
				<a href="<?php echo esc_url('https://canyonthemes.com/supports/'); ?>" target="_blank"><?php esc_html_e( 'Ezy Support', 'ezy' ); ?></a>
			</p>
			<h3><?php esc_html_e( 'Rate This Theme', 'ezy' ); ?></h3>
			<p><?php esc_html_e('If you like Ezy Kindly Rate this Theme', 'ezy')?> </p>
			<p>
				<a href="<?php echo esc_url('https://wordpress.org/support/theme/ezy/reviews/#new-post'); ?>" target="_blank"><?php esc_html_e( 'Add Your Review', 'ezy' ); ?></a>
			</p>
			</div>
			
		<?php
	}

}
}
