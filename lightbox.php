<?php

if($_REQUEST['popup']!=''){
	
	$postObj = get_post( $_REQUEST['pid'] );
	$img ='';
	if (function_exists('get_the_post_thumbnail')) {
		$img = get_the_post_thumbnail($_REQUEST['pid'],'large' );
	}
	if(!empty($img)) $img = "<div class='featuredImg' align='center'>".$img."</div>";

	echo '<h2>'.$postObj->post_title.'</h2>';
	echo '<div class="ostContent">'.$img.$postObj->post_content.'</div>';
	exit;
}

class spbc_showPostsWidget extends WP_Widget{

	function spbc_showPostsWidget() {
                $options = array('description' => 'Show posts from selected categories.');
				parent::WP_Widget(false, $name = 'Show Posts By Category', $options);
	}
	/*-----------------------------------------------------------*/
	function widget($args, $instance) {
				extract($args, EXTR_SKIP);

                $ost_title				= empty($instance['ost_title']) ? ' ' : apply_filters('widget_title', $instance['ost_title']);
                $ost_limit				= (is_numeric($instance['ost_limit'])) ? $instance['ost_limit'] : 5;
                $ost_orderby			= ($instance['ost_orderby']) ? $instance['ost_orderby'] : 'date';
                $ost_order				= ($instance['ost_order']) ? $instance['ost_order'] : 'desc';
                $ost_exclude			= ($instance['ost_exclude'] != '') ? $instance['ost_exclude'] : 0;
                $ost_excludeposts		= ($instance['ost_excludeposts'] != '') ? $instance['ost_excludeposts'] : 0;
                $ost_category_id		= $instance['ost_categoryid'];
                $ost_showdate			= ($instance['ost_show_date'] == 'on') ? 'yes' : 'no';
                $ost_thumbnail			= ($instance['ost_thumbnail'] == 'on') ? 'yes' : 'no';
                $ost_thumbnail_size		= ($instance['ost_thumbnail_size']) ? $instance['ost_thumbnail_size'] : 'thumbnail';

                echo $before_widget;
                echo $before_title . $ost_title . $after_title;
				$this->spbc_showWidget($instance);
				echo $after_widget;
	}
	/*-----------------------------------------------------------*/
	public static function get_UrlFromText($content,$url='Y'){
		
		if($url=='Y'){
			$imgpattern = '/src=[\'"]?([^\'" >]+)[\'" >]/';
			preg_match($imgpattern, $content, $article_image);
		}else{
			preg_match_all('/<img[^>]+>/i',$content, $article_image); 
		}
		return $article_image;
	}

	/*-----------------------------------------------------------*/
	function spbc_showWidget($instance){
				global $post;
				$query    = array(
					'posts_per_page' => $instance['ost_limit'],
					'cat' => $instance['ost_categoryid'],
					'orderby' => $instance['ost_orderby'],
					'order' => $instance['ost_order'],
					'category__not_in' => array($instance['ost_exclude']),
					'post__not_in' => array($instance['ost_excludeposts'])
				);

				$wp_query = new WP_Query($query);

				 if ($wp_query->have_posts()):
						
					     echo '
							<div class="list-posts-by-category">                                   
								<ul>';
									while ($wp_query->have_posts()):
										$wp_query->the_post();
										$image_id = get_post_thumbnail_id();
										
										
										if(!empty($instance['ost_thumbnail'])){
											if ( in_array($instance['ost_thumbnail_size'],array('thumbnail', 'medium', 'large', 'full'))) {
												$ost_thumb_size = $instance['ost_thumbnail_size'];
											}elseif ($instance['ost_thumbnail_size']){
												$ost_thumb_size = array($instance['ost_thumbnail_size']);
											}else {
												$ost_thumb_size = 'thumbnail';
											}
											$ost_thumbnail = get_the_post_thumbnail($post->ID, $ost_thumb_size);
										}else{
											$ost_thumbnail = "";
										}
									?>

									<li>
										<?php echo $ost_thumbnail; ?>
										<a class="ostlightbox"  href="<?php echo get_site_url().'/index.php?pid='.$post->ID.'&popup=Y'; ?>" title="<?php echo the_title_attribute(); ?>">
									
										<?php
										if (strlen($post->post_title) > 50) {
											echo substr(the_title($before = '', $after = '', FALSE), 0, 55) . '...';
										} else {
											the_title();
										} ?>
										</a>
										<?php if(!empty($instance['ost_show_date'])){ ?><span><?php echo get_the_time('F jS, Y'); ?></span><?php } ?>
									  </li><?php
									endwhile;
									echo '
								</ul>
							</div>';
				 endif;
	}
	/*-----------------------------------------------------------*/
	/* OST Widget Update WP_Widget::update */
	function update($new_instance, $old_instance) {
					$instance = $old_instance;
					$instance['ost_title']			= strip_tags($new_instance['ost_title']);
					$instance['ost_limit']			= strip_tags($new_instance['ost_limit']);
					$instance['ost_orderby']		= strip_tags($new_instance['ost_orderby']);
					$instance['ost_order']			= strip_tags($new_instance['ost_order']);
					$instance['ost_exclude']		= strip_tags($new_instance['ost_exclude']);
					$instance['ost_excludeposts']	= strip_tags($new_instance['ost_excludeposts']);
					$instance['ost_categoryid']		= strip_tags($new_instance['ost_categoryid']);
					$instance['ost_show_date']		= strip_tags($new_instance['ost_show_date']);
					$instance['ost_thumbnail']		= strip_tags($new_instance['ost_thumbnail']);
					$instance['ost_thumbnail_size'] = strip_tags($new_instance['ost_thumbnail_size']);
					return $instance;
		}
		/*-----------------------------------------------------------*/
		/* OST Widget Form */
		function form($instance) {
					$default = array (
						'ost_title' => '',
						'ost_categoryid' => '',
						'ost_limit' => '',
						'ost_orderby'=>'',
						'ost_order'=>'',
						'ost_exclude'=>'',
						'ost_excludeposts'=>'',
						'ost_thumbnail' =>''
						);
					$instance		= wp_parse_args( (array) $instance, $default);

					$ost_title			= strip_tags($instance['ost_title']);
					$ost_limit			= strip_tags($instance['ost_limit']);
					$ost_orderby		= strip_tags($instance['ost_orderby']);
					$ost_order			= strip_tags($instance['ost_order']);
					$ost_showdate		= strip_tags($instance['ost_show_date']);
					$ost_showauthor		= strip_tags($instance['ost_show_author']);
					$ost_exclude		= strip_tags($instance['ost_exclude']);
					$ost_excludeposts	= strip_tags($instance['ost_excludeposts']);
					$ost_categoryid		= strip_tags($instance['ost_categoryid']);
					$ost_thumbnail		= strip_tags($instance['ost_thumbnail']);
					$ost_thumbnail_size = strip_tags($instance['ost_thumbnail_size']);

					?>
						
						<ul>
							</li>
								<label for="<?php echo $this->get_field_id('ost_title'); ?>"><?php _e("Title", 'list-posts-by-category')?></label>
								<br/>
								<input class="widefat" id="<?php echo $this->get_field_id('ost_title'); ?>" name="<?php echo $this->get_field_name('ost_title'); ?>" type="text" 
								value="<?php echo esc_attr($ost_title); ?>" />
							</li>
							</li>
								<label for="<?php echo $this->get_field_id('ost_categoryid'); ?>"><?php _e("Category", 'list-posts-by-category')?></label>
								<br/>
								<select id="<?php echo $this->get_field_id('ost_categoryid'); ?>" name="<?php echo $this->get_field_name('ost_categoryid'); ?>">
									<?php 
											$categories=  get_categories();
											foreach ($categories as $cat) :
													$option = '<option value="' . $cat->cat_ID . '" ';
													if ($cat->cat_ID == $ost_categoryid) :
															$option .= ' selected = "selected" ';
													endif;
													$option .=  '">';
													$option .= $cat->cat_name;
													$option .= '</option>';
													echo $option;
											endforeach;
									?>
								</select>
							</li>
							</li>
								<br/>
								<label for="<?php echo $this->get_field_id('ost_limit'); ?>"><?php _e("Number of posts", 'list-posts-by-category')?></label>
								<br/>
								<input size="2" id="<?php echo $this->get_field_id('ost_limit'); ?>" name="<?php echo $this->get_field_name('ost_limit'); ?>" type="text" 					value="<?php echo esc_attr($ost_limit); ?>" />
							</li>

							 <li>
								<label for="<?php echo $this->get_field_id('ost_orderby'); ?>"><?php _e("Order by", 'list-posts-by-category')?></label> <br/>
								<select  id="<?php echo $this->get_field_id('ost_orderby'); ?>" 
										name="<?php echo $this->get_field_name('ost_orderby'); ?>" type="text" >
										<option value='date'><?php _e("Date", 'list-posts-by-category')?></option>
										<option value='title'><?php _e("Post title", 'list-posts-by-category')?></option>
										<option value='author'><?php _e("Author", 'list-posts-by-category')?></option>
										<option value='rand'><?php _e("Random", 'list-posts-by-category')?></option>
								</select>
							</li>
							<li>
								<label for="<?php echo $this->get_field_id('ost_order'); ?>"><?php _e("Order", 'list-posts-by-category')?></label><br/>
								<select id="<?php echo $this->get_field_id('ost_order'); ?>" 
										name="<?php echo $this->get_field_name('ost_order'); ?>" type="text">
										<option value='desc'><?php _e("Descending", 'list-category-posts')?></option>
										<option value='asc'><?php _e("Ascending", 'list-category-posts')?></option>
								</select>
							</li>
							<li>
								<label for="<?php echo $this->get_field_id('ost_exclude'); ?>"><?php _e("Exclude categories (id's)", 'list-posts-by-category')?></label><br/>
								<input id="<?php echo $this->get_field_id('ost_exclude'); ?>" name="<?php echo $this->get_field_name('ost_exclude'); ?>" type="text"
								value="<?php echo esc_attr($ost_exclude); ?>" />
							</li>
							<li>
								<label for="<?php echo $this->get_field_id('ost_excludeposts'); ?>"><?php _e("Exclude posts (id's)", 'list-posts-by-category')?></label><br/>
								<input id="<?php echo $this->get_field_id('ost_excludeposts'); ?>" name="<?php echo $this->get_field_name('ost_excludeposts'); ?>" type="text"
								value="<?php echo esc_attr($ost_excludeposts); ?>" />
							</li>
							<li>
								 <input class="checkbox"  type="checkbox" <?php checked($instance['ost_show_date'], true ); ?>  name="<?php echo $this->get_field_name( 'ost_show_date' ); ?>" /> <?php _e("Date", 'list-posts-by-category')?>
							</li>
							<li>
								<input type="checkbox" <?php checked( (bool) $instance['ost_thumbnail'], true ); ?>
								name="<?php echo $this->get_field_name( 'ost_thumbnail'); ?>" /> <?php _e("Thumbnail - size", 'list-category-posts')?> 
								<select id="<?php echo $this->get_field_id('ost_thumbnail_size'); ?>" name="<?php echo $this->get_field_name( 'ost_thumbnail_size' ); ?>" type="text">
									<option value='350,350'>350,350</option>
									<option value='45,45'>45,45</option>
									<option value='40,40'>40,40</option>
									<option value='35,35'>35,35</option>
									<option value='30,30'>30,30</option>
									<option value='25,25'>25,25</option>
									<option value='thumbnail'>thumbnail</option>
									<option value='medium'>medium</option>
									<option value='large'>large</option>
									<option value='full'>full</option>
								</select>
							</li>
						</ul>
					<?php
		}
}

add_action('widgets_init', create_function('', 'return register_widget("spbc_showPostsWidget");'));



function spbc_showpostbycat_func( $atts ) {
	extract( shortcode_atts( array(
		'catid' => '',
		'orderby' => '',
		'order' => '',
		'catnotin' => '',
		'postnotin' => '',
		'showdate' => 'N',
		'showthumbnail' => '',
		'limit' => '10'
		
	), $atts ) );


				$ost_cat_id				= "{$catid}";
				$ost_orderby			= "{$orderby}";
				$ost_order				= "{$order}";
				$ost_catnotin			= explode(",","{$catnotin}");
				$ost_postnotin			= explode(",","{$postnotin}");
				$ost_showdate			= "{$showdate}";
				$ost_showthumbnail		= "{$showthumbnail}";
				$ost_limit				= "{$limit}";

				global $post;
				$query    = array(
					'posts_per_page' => $ost_limit,
					'cat' => $ost_cat_id,
					'orderby' => $ost_orderby,
					'order' => $ost_order,
					'category__not_in' => $ost_catnotin,
					'post__not_in' => $ost_postnotin
				);


				
				$return_data = '';
				$wp_query = new WP_Query($query);

				 if ($wp_query->have_posts()):
						
					     $return_data .= '
							<div class="list-posts-by-category">                                   
								<ul>';
									while ($wp_query->have_posts()):
										$wp_query->the_post();
										$image_id = get_post_thumbnail_id();
										
										
										if(!empty($ost_showthumbnail)){
											if ( in_array($ost_showthumbnail,array('thumbnail', 'medium', 'large', 'full'))) {
												$ost_thumb_size = $ost_showthumbnail;
											}else{
												$ost_thumb_size = explode(",",$ost_showthumbnail);
											}
											$ost_thumbnail = get_the_post_thumbnail($post->ID, $ost_thumb_size);
										}else{
											$ost_thumbnail = "";
										}


										$return_data .= "<li>".$ost_thumbnail;
										$return_data .= '<a class="ostlightbox"  href="'.get_site_url().'/index.php?pid='.$post->ID.'&popup=Y'.'" title="'.the_title_attribute('echo=0').'">';

										if (strlen($post->post_title) > 50) {
											$return_data .= substr(the_title($before = '', $after = '', FALSE), 0, 55) . '...';
										} else {
											$return_data .= get_the_title();
										} 

										$return_data .= "</a>";

										if($ost_showdate!='N'){
											$return_data .= "<span>".get_the_time('F jS, Y')."</span>";
										}
										
										$return_data .= "</li>";

										endwhile;

										$return_data .= '</ul></div>';

									 endif;
									

	return $return_data;
}
add_shortcode( 'ostlist', 'spbc_showpostbycat_func' );

?>
