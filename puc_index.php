<?php get_header(); ?>
	<section id="content" class="first clearfix">
		<div class="home-container">
     	    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class('item-list mbottom'); ?>>
        <div class="cthumb">
            <a href="<?php the_permalink(); ?>">
			  <?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'medium');} else { ?>
                <img src="<?php  echo get_template_directory_uri(); ?>/images/default-image.png" alt="<?php the_title_attribute();  ?>" />
              <?php } ?>
            </a>
        </div>
        <div class="cdetail">
        <div class="postmeta">
       		    <p class="vsmall pnone">
     		        <span class="mdate alignright"><?php echo the_time(get_option( 'date_format' )) ?></span></p>
			</div>
		<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
         <div class="catpost"><?php the_excerpt(); ?></div>
            
        </div>
    </article>
<?php endwhile; ?>
    <div class="pagenavi alignright">
	    <?php if ($wp_query->max_num_pages > 1) wiles_wp_pagination(); ?>
		

	</div>
<?php else : get_template_part( 'no-results', 'loop' ); endif; ?>
		</div>
	</section> <!-- end #main -->

<?php get_footer(); ?>