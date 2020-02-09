<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );

if ( !function_exists( 'chld_thm_cfg_parent_css' ) ):
    function chld_thm_cfg_parent_css() {
        wp_enqueue_style( 'chld_thm_cfg_parent', trailingslashit( get_template_directory_uri() ) . 'style.css', array( 'font-awesome','bootstrap','owl-carousel','owl-transitions','fancybox' ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'chld_thm_cfg_parent_css', 10 );

// END ENQUEUE PARENT ACTION

add_filter( 'qm/output/file_path_map', function( $map ) {
	$map['/var/www/html'] = '/Users/user/Developer/wordpress/html';
	return $map;
} );

if (!function_exists('print__r')) {
	function print__r($any) {
		print '<pre>' . print_r($any, 1) . '</pre>';
	}
}

$image_ids = [];
add_filter( 'the_content', 'replace_wp_gallery' );
function replace_wp_gallery( $content ) {
	$hasWpGallery = strpos($content, "wp-block-gallery");
	$hasCollageGallery = has_shortcode($content, 'collage_gallery');

	if ($hasWpGallery && $hasCollageGallery) {
		global $image_ids;
		$matches = [];
		preg_match_all('/data-id="(\d+?)"/', $content, $matches);
		$image_ids = array_map(function($it) { return intval($it); }, $matches[1]);

		$contentWithoutWpGallery = preg_replace('/<figure class="wp-block-gallery.*<\\/figure>/', '', $content);
		return $contentWithoutWpGallery;
	}
	return $content;
}
add_filter( 'ug_shortcode_images', 'use_images_from_wp_gallery', 10, 4 );
function use_images_from_wp_gallery( $images, $meta_id, $type, $atts ) {
	global $image_ids;
	if ( count( $image_ids ) > 0 ) {
		$images = get_posts( array(
			'post__in' => $image_ids,
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'numberposts'    => 999,
		) );

		$images_order = array_flip($image_ids);
		usort($images, fn($a, $b) => $images_order[$a->ID] <=> $images_order[$b->ID]);
	}
	$image_ids = [];
	return $images;
}

add_filter( 'evc_vk_albums_get_photos', 'remove_info', 91 );
function remove_info( $photos ) {
	foreach ( $photos as $photo ) {
		$photo->post_content = '';
	}
	return $photos;
}


add_filter( 'tribe_events_register_venue_type_args', 'archive_page_venue' );
function archive_page_venue($post_type_args) {
	return array_merge($post_type_args, [
		'has_archive' => 'places',
	]);
}

require_once 'nearest-events-widget.php';

if( function_exists('acf_add_local_field_group') ):
	acf_add_local_field_group(array(
		'key' => 'group_5e15bc813966c',
		'title' => 'xo-place',
		'fields' => array(
			array(
				'key' => 'field_5e15c02333ae8',
				'label' => 'coordinates',
				'name' => 'coordinates',
				'type' => 'yandex',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'xo_place',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => true,
		'description' => '',
	));
	function render_map() {
		if (have_posts()) {
			$shortcode = '[yamap height="50vh" type="yandex#map" controls="typeSelector;zoomControl" auto-bounds=1]';

			while ( have_posts() ) {
				the_post();
				$custom = (array) json_decode(get_field('coordinates', $post));
				[coords => [0 => $lon, 1 => $lat], icon => $icon] = $custom;
				if ($lat && $lon) {
					$shortcode .= '[yaplacemark coord="'.$lon.','.$lat.'" url="'.get_permalink().'" icon="'.$icon.'" color="#ff751f" name="'.get_the_title().'"]';
				}
			}
			$shortcode.='[/yamap]';
			echo do_shortcode($shortcode);
		}
	}
endif;
