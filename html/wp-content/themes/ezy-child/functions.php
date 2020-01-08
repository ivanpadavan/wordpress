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

$image_ids = [];
add_filter( 'the_content', 'replace_wp_gallery' );
function replace_wp_gallery( $content ) {
	$hasWpGallery = strpos($content, "wp-block-gallery");
	$hasCollageGallery = strpos($content, '[collage_gallery]');

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

add_filter( 'tribe_events_register_venue_type_args', 'archive_page_venue' );
function archive_page_venue($post_type_args) {
	return array_merge($post_type_args, [
		'has_archive' => 'places',
	]);
}
