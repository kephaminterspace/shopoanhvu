<?php 
global $post, $kt_portfolio_loop;

$postsummery = get_post_meta( $post->ID, '_kad_post_summery', true );
?>
		<div class="portfolio_item grid_item postclass kad-light-gallery kt_item_fade_in kad_portfolio_fade_in">
            <?php if ($postsummery == 'slider') {
            $image_gallery = get_post_meta( $post->ID, '_kad_image_gallery', true );
            if(!empty($image_gallery)) {
            	$attachments = array_filter( explode( ',', $image_gallery ) );
                if ($attachments) { 
                		$firstthumbnailURL = wp_get_attachment_url($attachments[0] , 'full');
                        $firstimage = aq_resize($firstthumbnailURL, $kt_portfolio_loop['slidewidth'], $kt_portfolio_loop['slideheight'], true, false, false, $attachments[0]);
                        ?>
                <div class="flexslider kt-flexslider loading kt-intrinsic imghoverclass clearfix"  style="padding-bottom:<?php echo ($firstimage[2]/$firstimage[1]) * 100;?>%;" data-flex-speed="7000" data-flex-initdelay="<?php echo (rand(10,2000));?>" data-flex-anim-speed="400" data-flex-animation="fade" data-flex-auto="true">
                    <ul class="slides kad-light-gallery">
                        <?php 	foreach ($attachments as $attachment) {
		                                $thumbnail_src = wp_get_attachment_image_src($attachment , 'full');
                          				$thumbnailURL = $thumbnail_src[0];
		                                if(empty($kt_portfolio_loop['slideheight'])) {$slide_height = $kt_portfolio_loop['slidewidth'];} else {$slide_height = $kt_portfolio_loop['slideheight'];}
		                                $image = aq_resize($thumbnailURL, $kt_portfolio_loop['slidewidth'],$slide_height, true, false, false, $attachment);
		                                if(empty($image[0])) {$image = array($thumbnailURL,$thumbnail_src[1],$thumbnail_src[2]);} 
									        // Lazy Load
					                        if( kad_lazy_load_filter() ) {
					                          $image_src_output = 'src="data:image/gif;base64,R0lGODdhAQABAPAAAP///wAAACwAAAAAAQABAEACAkQBADs=" data-lazy-src="'.esc_url($image[0]).'" '; 
					                        } else {
					                          $image_src_output = 'src="'.esc_url($image[0]).'"'; 
					                        }?>
	                                  	<li>
	                                  		<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
	                                  			<img <?php echo $image_src_output; ?> alt="<?php the_title(); ?>" width="<?php echo esc_attr($image[1]);?>" height="<?php echo esc_attr($image[2]);?>"  <?php echo kt_get_srcset_output($image[1], $image[2], $thumbnailURL, $attachment);?> class="" />
	                                  		</a>
											
											<?php if($kt_portfolio_loop['lightbox'] == 'true') {?>
												<a href="<?php echo esc_url($thumbnailURL); ?>" class="kad_portfolio_lightbox_link" title="<?php the_title();?>" data-rel="lightbox">
													<i class="icon-search"></i>
												</a>
											<?php }?>
	                                  </li>
	                                <?php }
	                            }
	                        }?>                            
					</ul>
              	</div> <!--Flex Slides-->
           	<?php } else if($postsummery == 'videolight') {
					if (has_post_thumbnail( $post->ID ) ) {
						$image_id = get_post_thumbnail_id( $post->ID );
						$image_url = wp_get_attachment_image_src($image_id, 'full' ); 
						$thumbnailURL = $image_url[0];
						$image = aq_resize($thumbnailURL, $kt_portfolio_loop['slidewidth'], $kt_portfolio_loop['slideheight'], true, false, false, $image_id);
						$video_string = get_post_meta( $post->ID, '_kad_post_video_url', true );
                  		if(!empty($video_string)) {$video_url = $video_string;} else {$video_url = $thumbnailURL;}
						if(empty($image[0])) {$image = array($thumbnailURL,$image_url[1],$image_url[2]);} 
				        // Lazy Load
                        if( kad_lazy_load_filter() ) {
                          $image_src_output = 'src="data:image/gif;base64,R0lGODdhAQABAPAAAP///wAAACwAAAAAAQABAEACAkQBADs=" data-lazy-src="'.esc_url($image[0]).'" '; 
                        } else {
                          $image_src_output = 'src="'.esc_url($image[0]).'"'; 
                        }
                        ?>
							<div class="imghoverclass">
	                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="kt-intrinsic" style="padding-bottom:<?php echo ($image[2]/$image[1]) * 100;?>%;">
	                                <img <?php echo $image_src_output; ?> alt="<?php the_title(); ?>" width="<?php echo esc_attr($image[1]);?>" height="<?php echo esc_attr($image[2]);?>" <?php echo kt_get_srcset_output($image[1], $image[2], $thumbnailURL, $image_id);?> class="lightboxhover" style="display: block;">
	                            </a> 
	                        </div>
	                                <?php if($kt_portfolio_loop['lightbox'] == 'true') {?>
												<a href="<?php echo esc_url($video_url); ?>" class="kad_portfolio_lightbox_link pvideolight" title="<?php the_title();?>" data-rel="lightbox">
													<i class="icon-search"></i>
												</a>
									<?php }?>
                        <?php $image = null; $thumbnailURL = null;?>
                    <?php } 
            } else {
					if (has_post_thumbnail( $post->ID ) ) {
						$image_id = get_post_thumbnail_id( $post->ID );
						$image_url = wp_get_attachment_image_src($image_id, 'full' ); 
						$thumbnailURL = $image_url[0]; 
						$image = aq_resize($thumbnailURL, $kt_portfolio_loop['slidewidth'], $kt_portfolio_loop['slideheight'], true, false, false, $image_id);
						if(empty($image[0])) {$image = array($thumbnailURL,$image_url[1],$image_url[2]);}
				        // Lazy Load
                        if( kad_lazy_load_filter() ) {
                          $image_src_output = 'src="data:image/gif;base64,R0lGODdhAQABAPAAAP///wAAACwAAAAAAQABAEACAkQBADs=" data-lazy-src="'.esc_url($image[0]).'" '; 
                        } else {
                          $image_src_output = 'src="'.esc_url($image[0]).'"'; 
                        }
		        		?>
							<div class="imghoverclass">
	                            <a href="<?php the_permalink();?>" title="<?php the_title(); ?>" class="kt-intrinsic" style="padding-bottom:<?php echo ($image[2]/$image[1]) * 100;?>%;">
	                                <img <?php echo $image_src_output; ?> alt="<?php the_title(); ?>" width="<?php echo esc_attr($image[1]);?>" height="<?php echo esc_attr($image[2]);?>" <?php echo kt_get_srcset_output($image[1], $image[2], $thumbnailURL, $image_id);?> class="lightboxhover" style="display: block;">
	                            </a> 
	                        </div>
                            <?php if($kt_portfolio_loop['lightbox'] == 'true') {?>
										<a href="<?php echo esc_url($thumbnailURL); ?>" class="kad_portfolio_lightbox_link" title="<?php the_title();?>" data-rel="lightbox">
											<i class="icon-search"></i>
										</a>
							<?php }?>
                        <?php $image = null; $thumbnailURL = null;?>
                    <?php } 
            } ?>
              	
              	<a href="<?php the_permalink() ?>" class="portfoliolink">
					<div class="piteminfo">   
                        <h5><?php the_title();?></h5>
                        <?php if($kt_portfolio_loop['showtypes'] == 'true') {
                        	$terms = get_the_terms( $post->ID, 'portfolio-type' ); 
                        	if ($terms) {?> 
                        		<p class="cportfoliotag">
                        			<?php $output = array(); foreach($terms as $term){ $output[] = $term->name;} echo implode(', ', $output); ?>
                        		</p>
                        <?php } 
                       	} 
                       	if($kt_portfolio_loop['showexcerpt'] == 'true') { ?> 
                       		<p><?php echo virtue_excerpt(16); ?></p> 
                       	<?php } ?>
                    </div>
                </a>
        </div>

