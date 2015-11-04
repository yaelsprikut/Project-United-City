<?php /**
 * The header template for Travel Stories theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @subpackage Travel Stories
 * @since      Travel Stories 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta name="viewport" content="width=device-width" />
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<!-- use jssor.slider.mini.js (40KB) or jssor.sliderc.mini.js (32KB, with caption, no slideshow) or jssor.sliders.mini.js (28KB, no caption, no slideshow) instead for release -->
<!-- jssor.slider.mini.js = jssor.sliderc.mini.js = jssor.sliders.mini.js = (jssor.js + jssor.slider.js) -->
	<?php if ( is_front_page() ) {
		$posts_in_slider = new WP_Query( array(
			'posts_per_page'		=> -1,
			'post_type'				=> 'post',
			'meta_key'				=> '_travel_stories_slider',
			'meta_value'			=> 1,
			'ignore_sticky_posts'	=> 1
			) );		
		if( $posts_in_slider->have_posts() ) { ?>
			<div id="travel_stories_wrapper">
				<header>
					<div class="travel-stories-header-wrapper">
						<div class="travel-stories-logo-text travel-stories-alignleft" role="banner">
							<h1>
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo( 'name' ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
							</h1>

							<h2 id="site-description" class="wrap"><?php bloginfo( 'description' ) ?></h2>
						</div>
						<div class="clear"></div>
						<div class="travel-stories-search-toggle">
							<div class="travel-stories-image-toggle">
								<a href="#travel_stories_search_container"></a>
							</div>
						</div>
						<div id="travel_stories_search_container">
							<?php get_search_form(); ?>
						</div>
					</div>
					<div class="slider" id="slider">
						<div u="slides" id="slides">
							<?php while( $posts_in_slider->have_posts() ) {
								$posts_in_slider->the_post();
								$date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>', esc_url( get_permalink() ), esc_attr( sprintf( __( 'Permalink to %s', 'travel-stories' ), the_title_attribute( 'echo=0' ) ) ), esc_attr( get_the_date( 'c' ) ), esc_html( get_the_date( 'F j, Y' ) ) ); ?>
								<div id="travel_stories_img_mountains">
									<?php if ( has_post_thumbnail() ) {
										$image_attributes = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'travel_stories_slider' ); ?>
										<img src="<?php echo $image_attributes[0]; ?>" u="image" />
									<?php } ?>
									<div class="travel-stories-blackout"></div>
									<h6>
										<a class="travel-stories-header-text" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e( 'Permanent Link to ', 'travel-stories' ); the_title_attribute(); ?>">
											<?php the_title(); ?>
										</a>
									</h6>

									<div class="travel-stories-header-line">
										<hr>
									</div>
									<div id="travel_stories_header_block">
										<div class="travel-stories-header-block_1">
											<p class="travel-stories-header-text-block-1-1"><?php _e( 'POSTED BY', 'travel-stories' ); ?></p>

											<p class="travel-stories-header-text-block-1-2"><?php the_author_posts_link(); ?></p>
										</div>
										<div class="travel-stories-header-block-2">
											<p class="travel-stories-header-text-block-2-1"><?php _e( 'DATE', 'travel-stories' ); ?></p>

											<p class="travel-stories-header-text-block-2-2"><?php echo $date; ?></p>
										</div>
										<a class="travel-stories-more-slider" href="<?php echo get_permalink(); ?>"><?php _e( 'Learn More', 'travel-stories' ); ?></a>
									</div>
								</div>
							<?php } ?>
							<span u="arrowleft" class="travel-stories-header-block-4-left jssora03l"></span>
							<span u="arrowright" class="travel-stories-header-block-4-right jssora03r"></span>
						</div>
					</div>
				</header>
				<?php wp_reset_postdata();
		} else { ?>
			<div id="travel_stories_single_wrapper">
				<header>
					<div class="travel-stories-header-head">
						<div class="travel-stories-logo-text-post travel-stories-alignleft" role="banner">
							<h1>
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo( 'name' ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
							</h1>
							<h2 id="site-description" class="wrap"><?php bloginfo( 'description' ) ?></h2>
						</div>
						<div class="travel-stories-search-toggle">
							<div class="travel-stories-image-toggle">
								<a href="#travel_stories_search_container"></a>
							</div>
						</div>
						<div id="travel_stories_search_container">
							<?php get_search_form(); ?>
						</div>
					</div>
				</header>
				<div class="clear"></div>
		<?php } ?>
	<?php } else { ?>
		<?php if ( is_singular() ) { ?>
			<div id="travel_stories_single_wrapper">
		<?php } else { ?>
			<div id="travel_stories_page_wrapper">
		<?php } ?>
		<header>
			<div class="travel-stories-header-head">
				<div class="travel-stories-logo-text-post travel-stories-alignleft" role="banner">
					<h1>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo( 'name' ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
					</h1>

					<h2 id="site-description" class="wrap"><?php bloginfo( 'description' ) ?></h2>
				</div>
				<div class="travel-stories-search-toggle">
					<div class="travel-stories-image-toggle">
						<a href="#travel_stories_search_container"></a>
					</div>
				</div>
				<div id="travel_stories_search_container">
					<?php get_search_form(); ?>
				</div>
			</div>
			<h6 class="travel-stories-page-name">
				<?php if ( is_category() ) {
					printf( __( 'Category:', 'travel-stories' ) . '&nbsp;' . '%s', single_cat_title( '', false ) ); ?>
					<div class="travel-stories-page-line"></div>
				<?php } elseif ( is_search() ) {
					printf( __( 'Search for:', 'travel-stories' ) . '&nbsp;' . '%s' . '?', get_search_query() ); ?>
					<div class="travel-stories-page-line"></div>
				<?php } elseif ( is_tag() ) {
					printf( __( 'Tags:', 'travel-stories' ) . '&nbsp;' . '%s', single_tag_title( '', false ) ); ?>
					<div class="travel-stories-page-line"></div>
				<?php } elseif ( is_author() ) {
					printf( __( 'Author:', 'travel-stories' ) . '&nbsp;' . '%s', get_the_author() ); ?>
					<div class="travel-stories-page-line"></div>
				<?php } elseif ( is_archive() ) {
					if ( is_day() ) :
						printf( __( 'Daily Archives:', 'travel-stories' ) . '&nbsp;' . '%s', get_the_date() );
					elseif ( is_month() ) :
						printf( __( 'Monthly Archives:', 'travel-stories' ) . '&nbsp;' . '%s', get_the_date( _x( 'F Y', 'monthly archives date format', 'travel-stories' ) ) );
					elseif ( is_year() ) :
						printf( __( 'Yearly Archives:', 'travel-stories' ) . '&nbsp;' . '%s', get_the_date( _x( 'Y', 'yearly archives date format', 'travel-stories' ) ) );
					else :
						_e( 'etc.:', 'travel-stories' );
					endif; ?>
					<div class="travel-stories-page-line"></div>
				<?php } ?>
			</h6>
		</header>
	<?php } ?>
