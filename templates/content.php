<?php
/*
* Post loop contnet
*
*
*/
global $post, $virtue_premium, $kt_post_with_sidebar;

 if($kt_post_with_sidebar){
    $kt_feat_width = 846;
    $kt_portraittext = 'col-md-7';
    $kt_portraitimg_size = 'col-md-5';
 } else {
    $kt_feat_width = 1140;
    $kt_portraittext = 'col-md-8';
    $kt_portraitimg_size = 'col-md-4';
 }

  $postsummery  = get_post_meta( $post->ID, '_kad_post_summery', true );
  $height       = get_post_meta( $post->ID, '_kad_posthead_height', true ); 
  $swidth       = get_post_meta( $post->ID, '_kad_posthead_width', true ); 
  // get_width
  if (!empty($height)) {
    $slideheight = $height;
  } else {
    $slideheight = apply_filters('kt_post_excerpt_image_height', 400);
  }
  // get height
  if (!empty($swidth)) {
    $slidewidth = $swidth; 
  } else {
    $slidewidth = apply_filters('kt_post_excerpt_image_width', $kt_feat_width);
  }
  // get post summary
  if(empty($postsummery) || $postsummery == 'default') {
    if(!empty($virtue_premium['post_summery_default'])) {
      $postsummery = $virtue_premium['post_summery_default'];
    } else {
      $postsummery = 'img_portrait';
    }
  }

?>
<article id="post-<?php the_ID(); ?>" <?php post_class('kad_blog_item kad-animation'); ?> data-animation="fade-in" data-delay="0" itemscope="" itemtype="http://schema.org/BlogPosting">
     <div class="row">
          <?php 
          if($postsummery == 'img_landscape') { 
               $textsize = 'col-md-12'; 
               if (has_post_thumbnail( $post->ID ) ) {
                    $image_id =  get_post_thumbnail_id( $post->ID );
                    $image_url = wp_get_attachment_image_src( $image_id, 'full' ); 
                    $thumbnailURL = $image_url[0];
                    $image = aq_resize($thumbnailURL, $slidewidth, $slideheight, true, false, false, $image_id);
               } else {
                    $thumbnailURL = virtue_post_default_placeholder();
                    $image_url = array($thumbnailURL, $slidewidth, $slideheight);
                    $image = aq_resize($thumbnailURL, $slidewidth, $slideheight, true, false, false);
               }
               if(empty($image[0])) { $image = array($thumbnailURL,$image_url[1],$image_url[2]);}
               // Lazy Load
               if( kad_lazy_load_filter() ) {
                  $image_src_output = 'src="data:image/gif;base64,R0lGODdhAQABAPAAAP///wAAACwAAAAAAQABAEACAkQBADs=" data-lazy-src="'.esc_url($image[0]).'" '; 
               } else {
                  $image_src_output = 'src="'.esc_url($image[0]).'"'; 
               }
                    ?>
                    <div class="col-md-12 post-land-image-container">
                         <div class="imghoverclass img-margin-center">
                              <a href="<?php the_permalink()  ?>" title="<?php the_title(); ?>">
                                   <img <?php echo $image_src_output; ?> alt="<?php the_title(); ?>" class="iconhover" width="<?php echo esc_attr($image[1]);?>" height="<?php echo esc_attr($image[2]);?>" <?php echo kt_get_srcset_output($image[1], $image[2], $thumbnailURL, $image_id);?>>
                              </a> 
                         </div>
                    </div>
               <?php // clear
               $image = null; $thumbnailURL = null; 
          
          } elseif($postsummery == 'img_portrait') { 
               $textsize = $kt_portraittext;
               $portraitwidth = apply_filters('kt_post_excerpt_image_width_portrait', 365);
               $portraitheight = apply_filters('kt_post_excerpt_image_height_portrait', 365);
               if (has_post_thumbnail( $post->ID ) ) {
                    $image_id =  get_post_thumbnail_id( $post->ID );
                    $image_url = wp_get_attachment_image_src( $image_id, 'full' ); 
                    $thumbnailURL = $image_url[0];
                    $image = aq_resize($thumbnailURL, $portraitwidth, $portraitheight, true, false, false, $image_id);
               } else {
                    $thumbnailURL = virtue_post_default_placeholder();
                    $image_url = array($thumbnailURL, $portraitwidth, $portraitheight);
                    $image = aq_resize($thumbnailURL, $portraitwidth, $portraitheight, true, false, false);
               }
               if(empty($image[0])) { $image = array($thumbnailURL,$image_url[1],$image_url[2]);}
               // Lazy Load
               if( kad_lazy_load_filter() ) {
                  $image_src_output = 'src="data:image/gif;base64,R0lGODdhAQABAPAAAP///wAAACwAAAAAAQABAEACAkQBADs=" data-lazy-src="'.esc_url($image[0]).'" '; 
               } else {
                  $image_src_output = 'src="'.esc_url($image[0]).'"'; 
               }
                    ?>
                    <div class="<?php echo esc_attr($kt_portraitimg_size);?> post-image-container">
                         <div class="imghoverclass img-margin-center">
                              <a href="<?php the_permalink()  ?>" title="<?php the_title(); ?>">
                                   <img <?php echo $image_src_output; ?> alt="<?php the_title(); ?>" class="iconhover" width="<?php echo esc_attr($image[1]);?>" height="<?php echo esc_attr($image[2]);?>" <?php echo kt_get_srcset_output($image[1], $image[2], $thumbnailURL, $image_id);?>>
                              </a> 
                         </div>
                    </div>
               <?php // clear
               $image = null; $thumbnailURL = null; 
          
          } elseif($postsummery == 'slider_landscape') {
               $textsize = 'col-md-12'; ?>
               <div class="col-md-12 post-land-image-container">
                    <div class="flexslider kt-flexslider loading" style="max-width:<?php echo esc_attr($slidewidth);?>px;" data-flex-speed="7000" data-flex-initdelay="0" data-flex-anim-speed="400" data-flex-animation="fade" data-flex-auto="true">
                         <ul class="slides">
                         <?php 
                         $image_gallery = get_post_meta( $post->ID, '_kad_image_gallery', true );
                         if(!empty($image_gallery)) {
                              $attachments = array_filter( explode( ',', $image_gallery ) );
                              if ($attachments) {
                                   foreach ($attachments as $attachment) {
                                        $attachment_src = wp_get_attachment_image_src($attachment , 'full');
                                        $attachment_url =  $attachment_src[0];
                                        $image = aq_resize($attachment_url, $slidewidth, $slideheight, true, false, false, $attachment);
                                        if(empty($image[0])) { $image = array($attachment_url,$attachment_src[1],$attachment_src[2]);}
                                        if( kad_lazy_load_filter() ) {
                                           $image_src_output = 'src="data:image/gif;base64,R0lGODdhAQABAPAAAP///wAAACwAAAAAAQABAEACAkQBADs=" data-lazy-src="'.esc_url($image[0]).'" '; 
                                        } else {
                                           $image_src_output = 'src="'.esc_url($image[0]).'"'; 
                                        }
                                             ?>
                                        <li>
                                             <a href="<?php the_permalink() ?>" alt="<?php the_title(); ?>">
                                                  <img <?php echo $image_src_output; ?> alt="<?php the_title(); ?>" class="iconhover" width="<?php echo esc_attr($image[1]);?>" height="<?php echo esc_attr($image[2]);?>" <?php echo kt_get_srcset_output($image[1], $image[2], $attachment_url, $attachment);?>>
                                             </a>
                                        </li>
                                      <?php 
                                   }
                              }
                         } ?>                                   
                         </ul>
                    </div> <!--Flex Slides-->
               </div>
               <?php 
          
          } elseif($postsummery == 'slider_portrait') { 
               $textsize = $kt_portraittext; 
               $portraitwidth = apply_filters('kt_post_excerpt_image_width_portrait', 365);
               $portraitheight = apply_filters('kt_post_excerpt_image_height_portrait', 365); ?>
               <div class="<?php echo esc_attr($kt_portraitimg_size);?> post-image-container">
                   <div class="flexslider kt-flexslider loading" data-flex-speed="7000" data-flex-initdelay="0" data-flex-anim-speed="400" data-flex-animation="fade" data-flex-auto="true">
                         <ul class="slides">
                          <?php
                         $image_gallery = get_post_meta( $post->ID, '_kad_image_gallery', true );
                         if(!empty($image_gallery)) {
                              $attachments = array_filter( explode( ',', $image_gallery ) );
                              if ($attachments) {
                                   foreach ($attachments as $attachment) {
                                        $attachment_src = wp_get_attachment_image_src($attachment , 'full');
                                        $attachment_url =  $attachment_src[0];
                                        $image = aq_resize($attachment_url, $portraitwidth, $portraitheight, true, false, false, $attachment);
                                        if(empty($image[0])) { $image = array($attachment_url,$attachment_src[1],$attachment_src[2]);}
                                        if( kad_lazy_load_filter() ) {
                                           $image_src_output = 'src="data:image/gif;base64,R0lGODdhAQABAPAAAP///wAAACwAAAAAAQABAEACAkQBADs=" data-lazy-src="'.esc_url($image[0]).'" '; 
                                        } else {
                                           $image_src_output = 'src="'.esc_url($image[0]).'"'; 
                                        }
                                        ?>
                                        <li>
                                            <a href="<?php the_permalink() ?>" alt="<?php the_title(); ?>">
                                                  <img <?php echo $image_src_output; ?> alt="<?php the_title(); ?>" class="iconhover" width="<?php echo esc_attr($image[1]);?>" height="<?php echo esc_attr($image[2]);?>" <?php echo kt_get_srcset_output($image[1], $image[2], $attachment_url, $attachment);?>>
                                            </a>
                                        </li>
                                        <?php 
                                   }
                              }
                         } ?>
                         </ul>
                    </div> <!--Flex Slides-->
               </div>
               <?php 

          } elseif($postsummery == 'video') {
               $textsize = 'col-md-12'; ?>
               <div class="col-md-12 post-land-image-container">
                    <div class="videofit">
                         <?php 
                         $video = get_post_meta( $post->ID, '_kad_post_video', true ); 
                              echo do_shortcode($video); 
                         ?>
                    </div>
               </div>
               <?php 

          } else { 
               $textsize = 'col-md-12 kttextpost'; 
          } ?>

          <div class="<?php echo esc_attr($textsize);?> post-text-container postcontent">
               <?php 
                /**
                * @hooked virtue_post_before_header_meta_date - 20
                */
                do_action( 'kadence_post_excerpt_before_header' );
                ?>
               <header>
                    <?php 
                    /**
                    * @hooked virtue_post_excerpt_header_title - 10
                    * @hooked virtue_post_header_meta - 20
                    */
                    do_action( 'kadence_post_excerpt_header' );
                    ?>
               </header>
               <div class="entry-content" itemprop="articleBody">
                    <?php 
                         do_action( 'kadence_post_excerpt_content_before' );

                         the_excerpt();

                         do_action( 'kadence_post_excerpt_content_after' );
                    ?>
               </div>
               <footer>
                    <?php 
                    /**
                    * @hooked virtue_post_footer_tags - 10
                    */
                    do_action( 'kadence_post_excerpt_footer' );
                    ?>
               </footer>
               <?php 
               /**
               * 
               */
               do_action( 'kadence_post_excerpt_after_footer' );
               ?>
          </div><!-- Text size -->
     </div><!-- row-->
</article> <!-- Article -->