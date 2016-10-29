<?php
/*
Template Name: Blog
*/

global $post, $virtue_premium;
?>
<div id="pageheader" class="titleclass">
	<div class="container">
		<?php get_template_part('templates/page', 'header'); ?>
	</div><!--container-->
</div><!--titleclass-->
	
<div id="content" class="container">
		<div class="row">
			<?php
			if(kadence_display_sidebar()) {
				$display_sidebar = true;
				$fullclass = '';
				global $kt_post_with_sidebar; 
				$kt_post_with_sidebar = true;
			} else {
				$display_sidebar = false;
				$fullclass = 'fullwidth';
				global $kt_post_with_sidebar; 
				$kt_post_with_sidebar = false;
			}
			if(get_post_meta( $post->ID, '_kad_blog_summery', true ) == 'full') {
				$summery = 'full';
				$postclass = "single-article fullpost";
			} else {
				$summery = 'normal';
				$postclass = 'postlist';
			} 
			if(isset($virtue_premium['blog_infinitescroll']) && $virtue_premium['blog_infinitescroll'] == 1) {
				$infinit = 'data-nextselector=".wp-pagenavi a.next" data-navselector=".wp-pagenavi" data-itemselector=".post" data-itemloadselector=".post" data-infiniteloader="'.get_template_directory_uri() . '/assets/img/loader.gif"';
				$scrollclass = 'init-infinit-norm';
			} else {
				$infinit = '';
				$scrollclass = '';
			}
			$blog_category 	= get_post_meta( $post->ID, '_kad_blog_cat', true );
			$blog_order 	= get_post_meta( $post->ID, '_kad_blog_order', true );
			$blog_items 	= get_post_meta( $post->ID, '_kad_blog_items', true );
			$blog_cat 		= get_term_by ('id',$blog_category,'category');
			if($blog_category == '-1' || $blog_category == '') {
					$blog_cat_slug = '';
			} else {
				$blog_cat = get_term_by ('id',$blog_category,'category');
				$blog_cat_slug = $blog_cat -> slug;
			} 
			if($blog_items == 'all') {
				$blog_items = '-1';
			} 
			if(isset($blog_order)) {
	   			$b_orderby = $blog_order;
		   	} else {
		   		$b_orderby = 'date';
		   	}
			if($b_orderby == 'menu_order' || $b_orderby == 'title') {
				$b_order = 'ASC';
			} else {
				$b_order = 'DESC';
			}
			?>
  			<div class="main <?php echo esc_attr(kadence_main_class());?> <?php echo esc_attr($postclass) .' '. esc_attr($fullclass).' '.esc_attr($scrollclass); ?>" <?php echo $infinit;?> id="ktmain" role="main">
	  			<div class="entry-content" itemprop="mainContentOfPage">
					<?php get_template_part('templates/content', 'page'); ?>
				</div>
	  				<?php				
					$temp = $wp_query; 
					$wp_query = null; 
					$wp_query = new WP_Query();
					$wp_query->query(array(
						'paged'		 	 => $paged,
						'orderby' => $b_orderby,
						'order' => $b_order,
						'category_name'	 => $blog_cat_slug,
						'posts_per_page' => $blog_items
						)
					);
					if ( $wp_query ) : while ( $wp_query->have_posts() ) : $wp_query->the_post(); 
					 	if($summery == 'full') {
								get_template_part('templates/content', 'fullpost'); 
						} else {
						 	get_template_part('templates/content', get_post_format()); 
						} 
	                endwhile; else: ?>
						<li class="error-not-found"><?php _e('Sorry, no blog entries found.', 'virtue'); ?></li>
					<?php endif; 
            
					if ($wp_query->max_num_pages > 1) : 
		    				kad_wp_pagenavi();   
					endif; 
					$wp_query = null;
					$wp_query = $temp;  // Reset 
					wp_reset_query(); 

					if(isset($virtue_premium['page_comments']) && $virtue_premium['page_comments'] == '1') { comments_template('/templates/comments.php');} ?>					
			</div><!-- /.main -->