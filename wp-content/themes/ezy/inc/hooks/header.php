<?php
/*
* Header Hook Section 
* @since 1.0.0
*/
/* ------------------------------
* Doctype hook of the theme
* @since 1.0.0
* @package Ezy
------------------------------ */
if ( ! function_exists( 'ezy_doctype_action' ) ) :
    /**
     * Doctype declaration of the theme.
     *
     * @since 1.0.0
     */
    function ezy_doctype_action() {
    ?>
    <!DOCTYPE html>
		<html <?php language_attributes(); ?> class="boxed">
    <?php
    }
endif;
add_action( 'ezy_doctype', 'ezy_doctype_action', 10 );

/* --------------------------
* Header hook of the theme.
* @since 1.0.0
* @package Ezy
-------------------------- */
if ( ! function_exists( 'ezy_head_action' ) ) :
    /**
     * Header hook of the theme.
     *
     * @since 1.0.0
     */
    function ezy_head_action() {
    ?>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
    <?php
    }
endif;
add_action( 'ezy_head', 'ezy_head_action', 10 );

/* -----------------------
* Header skip link hook of the theme.
* @since 1.0.0
* @package Ezy
----------------------- */
if ( ! function_exists( 'ezy_skip_link_head' ) ) :
    /**
     * Header skip link hook of the theme.
     *
     * @since 1.0.0
     */
    function ezy_skip_link_head() {
    ?>
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'ezy' ); ?></a>
	<?php
    }
	endif;
add_action( 'ezy_skip_link_action', 'ezy_skip_link_head', 10 );

/* -------------------------
* Header section start wrapper theme.
* @since 1.0.0
* @package Ezy
------------------------- */
if ( ! function_exists( 'ezy_header_start_wrapper' ) ) :
    /**
     * Header section start wrapper theme.
     *
     * @since 1.0.0
     */
    function ezy_header_start_wrapper() {
    ?>
		<div id="page">
	<?php
    }
	endif;
add_action( 'ezy_header_start_wrapper_action', 'ezy_header_start_wrapper', 10 );


/* -------------------------
* Header section hook of the theme.
* @since 1.0.0
* @package Ezy
------------------------- */
if ( ! function_exists( 'ezy_header_section' ) ) :
    /**
     * Header section hook of the theme.
     *
     * @since 1.0.0
     */
    function ezy_header_section() {
    ?>

<header role="header">
	<?php
	global $ezy_theme_options;
	$ezy_theme_options        = ezy_get_theme_options();
	$ezy_header_search        = $ezy_theme_options['ezy-header-search'];
	$ezy_header_social        = $ezy_theme_options['ezy-header-social'];
	?>
		<div class="top-header-logo">
			<div class="container">
				<div class="row">
					<div class="col-sm-8">
						<div class="logo-header-inner col-sm-12">
		                   <?php
		                      if (has_custom_logo()) { ?>
		                   
		                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>"> 
		                    	<?php  the_custom_logo();?>
		                    </a>
		                  <?php } 
		                  	else {
		                  ?>  
		                    <div class="togo-text">
		                    	<?php
								if ( is_front_page() && is_home() ) : ?>
									<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
								<?php else : ?>
									<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
									<?php
								endif;
								$description = get_bloginfo( 'description', 'display' );
								if ( $description || is_customize_preview() ) : ?>
									<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
									<?php
								endif; ?>
		                    </div>
		                 <?php } ?>   
						</div>
					</div>
					<div class="col-sm-4">
						<div class="social-links">
							<?php 
							if (has_nav_menu('social') && $ezy_header_social == 1 )
							 {
							wp_nav_menu( array( 'theme_location' => 'social', 'menu_class
									' => 'nav navbar-social' ) ); 
							 }
							?>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>
	<?php
    }
	endif;
add_action( 'ezy_header_section_action', 'ezy_header_section', 10 );


/* ----------------------
* Header Lower section hook of the theme.
* @since 1.0.0
* @package Ezy
----------------------- */
if ( ! function_exists( 'ezy_header_lower_section' ) ) :
    /**
     * Header section hook of the theme.
     *
     * @since 1.0.0
     */
    function ezy_header_lower_section() {
    ?>

	<div class="header-lower">
    	<div class="container">
    		<!-- Main Menu -->
            <nav class="main-menu">
            	<div class="navbar-header">
                    <!-- Toggle Button -->    	
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    	<span class="sr-only"><?php _e('Toggle navigation', 'ezy');?></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="navbar-collapse collapse clearfix">
					<?php 
						if ( has_nav_menu('primary'))
							{
								wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'navigation ' ) ); 
							}
						  else
						  { ?>
						  	<ul class="navigation">
			                    <li class="menu-item">
			                        <a href="<?php echo esc_url(admin_url( 'nav-menus.php' )); ?> "> <?php esc_html_e('Add a menu','ezy'); ?></a>
			                    </li>
			                </ul>
					<?php }		
					?>
				</div><!-- /.navbar-collapse -->
				<?php
					global $ezy_theme_options;
					$ezy_theme_options  = ezy_get_theme_options();
					$ezy_header_search  = $ezy_theme_options['ezy-header-search'];
					if ($ezy_header_search == 1 ): 
				?>
				<div class="search-icon">
				    <a href="#search"><i class="fa fa-search"></i></a>
				</div>
				<div id="search">
					<div class="top-search-wrapper">
				        <button type="button" class="close"><?php esc_html_e('×','ezy'); ?></button>
				        <?php 
							get_search_form();
						?>
					</div>
			    </div>
			<?php endif; ?>
			</nav>
		</div>
	</div>
	<?php
    }
	endif;
add_action( 'ezy_header_lower_section_action', 'ezy_header_lower_section', 10 );

/* -----------------------
* Header Lower section hook of the theme.
* @since 1.0.0
* @package Ezy
----------------------- */
if ( ! function_exists( 'ezy_header_slider_action' ) ) :
    /**
     * Header section hook of the theme.
     *
     * @since 1.0.0
     */
    function ezy_header_slider_action() {
    	global $ezy_theme_options;
		$ezy_theme_options  = ezy_get_theme_options();
		$ezy_category_cat   = $ezy_theme_options['ezy-feature-cat'];
		if( $ezy_category_cat > 0 ){ ?>
			<section  class="slider clearfix">
				<div class="container">
					<div class="row">
						<div id="main-slider">
							<?php if(is_home() || is_front_page () ) {
								 ezy_slider_images_selection();
								}
							?>
						</div>
					</div>
				</div>
			</section>
		<?php
    	}
    }
	endif;
add_action( 'ezy_header_slider_section_action', 'ezy_header_slider_action', 10 );


/* -----------------------
* Header Lower section hook of the theme.
* @since 1.0.0
* @package Ezy
----------------------- */
if ( ! function_exists( 'ezy_header_promo_action' ) ) :
    /**
     * Header section hook of the theme.
     *
     * @since 1.0.0
     */
    function ezy_header_promo_action() {
    	global $ezy_theme_options;
		$ezy_theme_options  = ezy_get_theme_options();
		$category_id          = $ezy_theme_options['ezy-promo-cat'];
		if( $category_id > 0 && is_home() ){ ?>
			<section class="promo-area">
			  <?php if ( is_front_page() && is_home() )
			   {  ?>
					<div class="container">
						<div class="row">
								<?php
								$args = array( 'cat' => $category_id , 'posts_per_page' => 3,'order'=> 'DESC' );

								  $query = new WP_Query($args);

								  if($query->have_posts()):

									while($query->have_posts()):

									 $query->the_post();
							?>

									<div class="col-md-4">
										<div class="promo-wrapper">
										<a href="<?php the_permalink(); ?>">
											<div class="promo-wrapper-content">
												<h2 class="pro_post_title"><?php the_title(); ?></h2>
												<div class="category-tag">
													<?php $posttags = wp_get_post_tags( get_the_ID() );												

													if( !empty( $posttags ))
													{
													?>
														<span>
															<?php
																$count = 0;
																if ( $posttags ) 
																{
																  foreach( $posttags as $tag )
																   {
																		$count++;
																		if ( 1 == $count )
																		  {
																		   echo $tag->name;
																	      }
																    }
											                    } ?>
														</span>

												<?php   } ?>
												</div>
												<div class="post-date">
				                                	<?php echo get_the_date(); ?>
				                                </div>
											</div>
											<?php if(has_post_thumbnail()){
												 $image_id  = get_post_thumbnail_id();
												 $image_url = wp_get_attachment_image_src($image_id,'ezy-promo-post',true);
	                                        ?>

											<figure>
												<img src="<?php echo esc_url($image_url[0]);?>">
											</figure>
											<?php   } ?>

											
										</a>
									</div>
								</div>
							<?php    endwhile; endif; wp_reset_postdata(); ?>

						</div>
					</div>
		      <?php } ?>
			</section>
		<?php
    	}
    }
	endif;
add_action( 'ezy_header_promo_section_action', 'ezy_header_promo_action', 10 );




/* ----------------------
* Header end wrapper section hook of the theme.
* @since 1.0.0
* @package Ezy
---------------------- */
if ( ! function_exists( 'ezy_header_end_wrapper' ) ) :
    /**
     * Header end wrapper section hook of the theme.
     *
     * @since 1.0.0
     */
    function ezy_header_end_wrapper() { ?>
	<div id="content" class="site-content">
		<?php if( !is_page_template('elementor_header_footer') ){ ?>
			<div class="container">
			<div class="row">
		
		<?php
		}
    }
	endif;
add_action( 'ezy_header_end_wrapper_action', 'ezy_header_end_wrapper', 10 );