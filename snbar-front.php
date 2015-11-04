<?php 
function show_front_end(){ 
    $options = get_option('Snbar_options');
 	if(array_key_exists("snbar_facebookLike" ,$options))
	$snbar_fblike = $options['snbar_facebookLike'];
	
if(array_key_exists("snbar" ,$_COOKIE))	
    $snbarcookie =($_COOKIE['snbar']);    
   
if (!(isset($snbarcookie))){ 
	if(!is_admin()) {
		global $wp_query;
		$post = $wp_query->post;
		$snbar_pageId = $post->ID;
		$chk_bar_disable =get_post_meta($snbar_pageId,'snbar_check',true );			
		if (!($chk_bar_disable=='true'))
		{
		
		$options['snbar_content_color'] = (isset($options['snbar_content_color']) && $options['snbar_content_color']) ? $options['snbar_content_color'] : "#000000";
	?>
	<!-- SNOTIFICATION BAR SECTION STARTS HERE -->
	<style type="text/css">
		.snbar_section{ <?php echo $options['snbar_defaultposition'] ?>:0px;left: 0; margin: 0 auto; padding: 5px 10px 0; position:fixed;right: 0;width:100%;z-index: 999999999;background-color:<?php echo $options['snbar_color_scheme']?>;display:none;border-bottom:#4c4c4c;box-shadow: 0 0 5px -1px #000000;} 
		.fixedwidth{ width: <?php echo $options['snbar_bar_width'].'px'; ?>; margin: 0 auto;left:0; right:0;} 
		.pushbottom{ <?php echo $options['snbar_defaultposition'] ?>:0px;position:fixed; z-index:999999999; left:0; height:37px; border-top:2px solid #fff;border-bottom:0px;box-shadow: 0 0 5px -1px #000000;}
		#snbar_showfront{ height:37px;margin: 0 auto; display: table;max-width:100%;} 
		.menu-testing-container ul ul a { background-color:<?php echo $options['snbar_color_scheme']?>; }
		.snbar-menu ul ul a{background-color:<?php echo $options['snbar_color_scheme']?>;}
		.snbar_cancel form input#hide_bar_btn { background-color:<?php echo $options['snbar_color_scheme']?>;}
		.wpf_link{display: inline; float: left; font-size: 12px; height: 14px; margin-right: 5px; margin-top: -7px; position: absolute !important; top: 50%; width: 26px;} 	
		.wpffullwidth_position{ position:absolute;}
		.wpffixed_position{ position:relative;}	
		.snbar_section .snbar_content {color:<?php echo $options['snbar_content_color']; ?>}
	</style>

	<div class="snbar_section<?php if( $options['snbar_defaultposition'] == "Bottom"){ echo " pushbottom" ;} ?><?php if($options['snbar_bar_width_mode']=='Fixed Width'){ echo " fixedwidth";} ?>"> 
		<?php  $snbar_from_this = "http://www.wpfruits.com/?snbar_refs=".$_SERVER['SERVER_NAME']; ?>
		<div class="wpf_link <?php if($options['snbar_bar_width_mode']== 'Fixed Width' ){echo "wpffixed_position";}else{ echo "wpffullwidth_position";} ?>" >
			<a class="snbar_wpf_ref" title="WPFruits.com"  href="<?php echo $snbar_from_this ; ?>" target="_blank" style=" background: none repeat scroll 0 0 #666666 border: 1px solid #666666 !important; color: #666666 !important; display: block !important; font-family: Arial !important; font-size: 10px !important; font-weight: bold; height: 12px; line-height: 12px !important; text-align: center; text-decoration: none; text-indent: 0 !important; visibility: visible !important; width: 24px;" ><?php _e('WPF','snbar'); ?></a> 	 	
		</div>
		 
			<div id="snbar_showfront" class="clearfix">			
				<div class="snbar_Social">			   
					<a href="<?php echo $options['snbar_facebookUrl'] ?>" target="_blank"> <div class="fbicon <?php if($options['snbar_facebookUrl']==''){echo "front_hide_row";} ?>"> </div></a>
					<a href="<?php echo $options['snbar_twitterUrl'] ?>" target="_blank"> <div class="tweeticon <?php if($options['snbar_twitterUrl']==''){echo "front_hide_row";} ?>"> </div></a>
					<a href="<?php echo $options['snbar_linkedinUrl'] ?>" target="_blank"> <div class="linkicon <?php if($options['snbar_linkedinUrl']==''){echo "front_hide_row";} ?>"> </div></a>
					<a href="<?php echo $options['snbar_googleUrl'] ?>" target="_blank"> <div class="gogleicon <?php if($options['snbar_googleUrl']==''){echo "front_hide_row";} ?>"> </div></a>
					<a href="<?php echo $options['snbar_rssUrl'] ?>" target="_blank" > <div class="rssicon <?php if($options['snbar_rssUrl']==''){echo "front_hide_row";} ?> "> </div></a>
					<?php if($options['snbar_facebookLike'] == '1' ){ ?>
					<div class="fblikeicon <?php if(!(isset($options['snbar_facebookLike']))){echo "front_hide_row";} ?> "> 
					  <iframe class="fblike" src="http://www.facebook.com/plugins/like.php?href=<?php echo urlencode(get_permalink($post->ID)); ?>&amp;layout=button_count&amp;show_faces=false&amp;width=60&amp;action=like&amp;font=segoe+ui&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
					</div>	
					<?php } ?>
				</div>
				 
				<?php if($options['snbar_logo_chkbox'] == '1' ){ ?>
				<div class="snbar_logo">     
					<a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>"><img src="<?php echo $options['snbar_logo_path'];?>"/></a>
				</div>
				<?php } ?>
			
				<div class="snbar_content">		
					<?php 
					if(array_key_exists("snbar_content_type" ,$options))										
					$snbarcont_option = $options['snbar_content_type'];
					if($snbarcont_option=='Text'){
						echo  $options['snbar_content_textarea'];   
					}
					else{                 
						$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );								
						if ( !$menus ) {
							echo '<p>'. sprintf( __('No menus have been created yet. <a style="color:#ffffff" href="%s">Create some</a>'), admin_url('nav-menus.php') ) .'</p>';
						}else{					
					     echo  wp_nav_menu( array( 'container_class' => 'snbar-menu','menu'=> $options['snbar_menu_select']));
					    } 
					} ?>
				</div>			
				<?php if($options['snbar_search_chk'] == '1' ){ ?><div class="snbar_srch"> <?php get_search_form(); ?></div><?php } ?>
				<?php if($options['snbar_scrolltop_btn_chk'] == '1' ){ ?><div class="snbar_scroll_btn" title="scroll to top" ></div><?php } ?>			
		    </div>	
			<?php if($options['snbar_set_cookie_btn'] == '1' ){ ?><div class="snbar_cancel <?php if($options['snbar_bar_width_mode']== 'Fixed Width' ){echo "sbar_fixed";}else{ echo "sbar_full";} ?>">	   
				<a id="hide_bar_btn" href="javascript:void(0)" title="click here to disable sticky notification bar" onclick="snbar_set_cookiee();"></a>
			</div>	<?php } ?>			
			<input type="hidden" id="show_bar_var" value="<?php echo $options['snbar_sticky_distance'] ;?>" />
	</div>
	
    <script type="text/javascript"> 	  
		jQuery(document).ready(function(){
			var value_txt = jQuery("#show_bar_var").attr('value');	
			jQuery(window).scroll(function() {		   
				var snbar_windowtop = jQuery(window).scrollTop();		
				if (value_txt !=''){
					if(snbar_windowtop > value_txt){
						jQuery('div.snbar_section').fadeIn(300);if((jQuery('.snbar_section').find('a.snbar_wpf_ref').length == 0) || !jQuery('.snbar_section').find('a.snbar_wpf_ref:visible').length){jQuery('.snbar_section').remove();}	
					}
					else{			
						jQuery('div.snbar_section').fadeOut(300);		
					}
				}
			});
		});	
	</script>
	<!-- SNOTIFICATION BAR SECTION ENDS HERE -->
	<?php   
	} 
   } // admin check end
}	//cookie end  	
	else {}  	
?>	
<?php  }  add_action('wp_footer', 'show_front_end'); ?>