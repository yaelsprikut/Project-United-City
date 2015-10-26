<?php /**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 *
 * @subpackage Travel Stories
 * @since      Travel Stories 1.0
 */
get_header(); ?>
	<div class="travel-stories-container">
		<div class="travel-stories-content">
			<?php if ( have_posts() ) {
				while ( have_posts() ) {
					the_post(); ?>
					<article class="travel-stories-post">
						
						<a href="<?php echo get_site_url().'/index.php?pid='.$post->ID.'&popup=Y'; ?>" width="500" height="500" title="<?php echo the_title_attribute(); ?>" rel="lightbox[63]" 
						title="Lighthouse" class="cboxElement"><div class="travel-stories-post-blackout"></div></a>

						<p class="travel-stories-category">
							<?php $category = get_the_category();
							if ( $category ) {
								echo '<a href="' . get_category_link( $category[0]->term_id ) . '">' . $category[0]->cat_name . '</a>';
							} ?>
						</p>

						<h1>
								<a href="<?php echo get_site_url().'/index.php?pid='.$post->ID.'&popup=Y'; ?>" width="500" height="500" title="<?php echo the_title_attribute(); ?>" rel="lightbox[63]" class="cboxElement">
								<?php echo travel_stories_short_title( 70 ); ?>
							</a>
						</h1>

						<div class="travel-stories-post-line"></div>
						<?php $date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>', esc_url( get_permalink() ), esc_attr( sprintf( __( 'Permalink to %s', 'travel-stories' ), the_title_attribute( 'echo=0' ) ) ), esc_attr( get_the_date( 'c' ) ), esc_html( get_the_date( 'F j, Y' ) ) ); ?>
						<p class="travel-stories-post-date"><?php echo $date; ?></p>

						<!--- post author name removed by Yael --->
						<?php if ( has_post_thumbnail() ) {
							the_post_thumbnail( 'travel_stories_post' );
						} ?>
					</article><!-- #post -->
				<?php } ?>
				<div class="clear"></div>
				<nav class="travel-stories-single-block-previous-next-story">
					<div class="travel-stories-single-previous-story">
						<?php previous_posts_link( '&laquo;&nbsp;' . __( 'previous posts', 'travel-stories' ) ); ?>
					</div>
					<div class="travel-stories-single-next-story">
						<?php next_posts_link( __( 'next posts', 'travel-stories' ) . '&nbsp;&raquo;' ); ?>
					</div>
				</nav>
			<?php } ?>
			<div class="clear"></div>
			<?php $travel_stories_posts_line = new WP_Query( array(
				'posts_per_page'		=> 1,
				'post_type'				=> 'post',
				'meta_key'				=> '_travel_stories_featured',
				'meta_value'			=> 1,
				'ignore_sticky_posts'	=> 1
				) );		
			if( $travel_stories_posts_line->have_posts() ) { ?>
				<article class="travel-stories-featured-post">
					<?php $travel_stories_posts_line->the_post(); ?>
					<div class="travel-stories-featured-post-banner">
						<?php if ( has_post_thumbnail() ) {
							the_post_thumbnail( 'travel_stories_featured' );
						} ?>
						<div class="travel-stories-featured-post-blackout"></div>
					</div>
					<div class="travel-stories-featured-post-column">
						<p class="travel-stories-featured-category"> <?php the_category( ',' ) ?></p>
						<h5>
							<a href="<?php echo get_site_url().'/index.php?pid='.$post->ID.'&popup=Y'; ?>" width="500" height="500" title="<?php echo the_title_attribute(); ?>" rel="lightbox[63]" class="cboxElement">
								<?php the_title(); ?>
							</a></h5>

						<div class="travel-stories-featured-content">
							<?php the_excerpt(); ?>
						</div>
						<a href="<?php echo get_site_url().'/index.php?pid='.$post->ID.'&popup=Y'; ?>" width="500" height="500" title="<?php echo the_title_attribute(); ?>" rel="lightbox[63]" class="cboxElement"></a>

					</div>
				</article>
			<?php }
			wp_reset_postdata(); ?>
		</div>
	</div>
	<aside class="travel-stories-sidebar-widget">
		<?php get_sidebar(); ?>
		<div class="clear"></div>
	</aside>
<?php get_footer(); ?>