<?php


/**
* Select Images according to Category saved.
* @since Ezy 1.0.0
*
* @param null
* @return null
*
*/
if ( !function_exists('ezy_slider_images_selection') ) :
  function ezy_slider_images_selection() 
  { 
        global $ezy_theme_options;

        $category_id = $ezy_theme_options['ezy-feature-cat'];
                     
        $args = array( 'cat' =>$category_id , 'posts_per_page' => -1 );

        $query = new WP_Query($args);

        if($query->have_posts()):

          while($query->have_posts()):

           $query->the_post();
           if(has_post_thumbnail())
              {

                   $image_id = get_post_thumbnail_id();
                   $image_url = wp_get_attachment_image_src( $image_id,'',true );
                   ?>
                   <div class="col-sm-12">
                    <div class="feature-area">
                      <a href="<?php the_permalink(); ?>">
                         <div class="feature-description">
                                <h2><?php the_title(); ?></h2>
                                <span class="category-tag">
                                  <?php 
                                    $categories = get_the_category();
                                    if ( ! empty( $categories ) ) {
                                        echo esc_html( $categories[0]->name );   
                                    }
                                  ?>
                                </span>
                                <div class="post-date">
                                 <?php echo get_the_date(); ?>
                               </div>
                         </div>
                         <img src="<?php echo esc_url($image_url[0]);?>" class="lazyOwl" alt="">
                       </a>
                    </div>
                  </div>        
                <?php 
              }
          endwhile; endif;wp_reset_postdata();
 }
endif;

/**
 * Goto Top functions
 *
 * @since Ezy 1.0.0
 *
 */
if (!function_exists('ezy_go_to_top')) :
    function ezy_go_to_top()
    {
        ?>
        <a id="toTop" href="#" class="scrolltop" title="<?php esc_attr_e('Go to Top', 'ezy'); ?>">
            <i class="fa fa-angle-double-up"></i>
        </a>
    <?php
    } endif;

/**
 * Exclude category in blog page
 *
 * @since Ezy 1.0.0
 *
 * @param null
 * @return int
 */

  global $ezy_theme_options;
  $ezy_theme_options  = ezy_get_theme_options();
	$showpost = $ezy_theme_options['ezy-exclude-slider-category'];	
if( $showpost != 1 )
{
 if (!function_exists('ezy_exclude_category_in_blog_page')) :
    function ezy_exclude_category_in_blog_page($query)
    {   	

        if ($query->is_home && $query->is_main_query()  ) {
        	$ezy_theme_options    = ezy_get_theme_options();
            $catid = $ezy_theme_options['ezy-feature-cat'];
            $exclude_categories = $catid;
            if (!empty($exclude_categories)) {
                $cats = explode(',', $exclude_categories);
                $cats = array_filter($cats, 'is_numeric');
                $string_exclude = '';
                echo $string_exclude;
                if (!empty($cats)) {
                    $string_exclude = '-' . implode(',-', $cats);
                    $query->set('cat', $string_exclude);
                }
            }
        }
        return $query;
    }
endif;
}
add_filter('pre_get_posts', 'ezy_exclude_category_in_blog_page');

/**
 * Post Navigation Function
 *
 * @since Ezy 1.0.0
 *
 * @param null
 * @return void
 *
 */
if ( !function_exists('ezy_posts_navigation') ) :
    function ezy_posts_navigation() {
        global $ezy_theme_options;
        $ezy_pagination_option = $ezy_theme_options['ezy-blog-pagination-type-options'];
        if( 'default' == $ezy_pagination_option ){
            the_posts_navigation();
        }
        else{
            echo"<div class='pagination'>";
            global $wp_query;
            $big = 999999999; // need an unlikely integer
            echo paginate_links(array(
                'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                'format' => '?paged=%#%',
                'current' => max(1, get_query_var('paged')),
                'total' => $wp_query->max_num_pages,
                'prev_text' => __('&laquo; Prev', 'ezy'),
                'next_text' => __('Next &raquo;', 'ezy'),
            ));
            echo "<div>";
        }
    }
endif;
add_action( 'ezy_action_navigation', 'ezy_posts_navigation', 10 );




/*
* Remove [...] from default fallback excerpt content
*
*/
function placid_excerpt_more( $more ) {
  if(is_admin())
  {
    return $more;
  }
  return '...';
}
add_filter( 'excerpt_more', 'placid_excerpt_more');



if (!function_exists('ezy_widgets_backend_enqueue')) : 
function ezy_widgets_backend_enqueue($hook){  

  if ( 'widgets.php' != $hook )
   {
            return;
        
   }

    wp_register_script( 'ezy-custom-widgets', get_template_directory_uri().'/assets/js/widgets.js', array( 'jquery' ), true );
    wp_enqueue_media();
    wp_enqueue_script( 'ezy-custom-widgets' );
}

add_action( 'admin_enqueue_scripts', 'ezy_widgets_backend_enqueue' );

endif;


