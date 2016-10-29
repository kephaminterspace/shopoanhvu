<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}
  global $virtue_premium;

        if(isset($virtue_premium['slider_size'])) {
          $slideheight = $virtue_premium['slider_size'];
        } else {
          $slideheight = 400;
        }
        if(isset($virtue_premium['slider_size_width'])) {
          $slidewidth = $virtue_premium['slider_size_width'];
        } else {
          $slidewidth = 400;
        }
        if(isset($virtue_premium['home_slider'])) {
          $slides = $virtue_premium['home_slider'];
        } else {
          $slides = '';
        }
        if(isset($virtue_premium['slider_autoplay']) && $virtue_premium['slider_autoplay'] == "1" ) {
          $autoplay ='true';
        } else {
          $autoplay = 'false';
        }
        if(isset($virtue_premium['slider_pausetime'])) {
          $pausetime = $virtue_premium['slider_pausetime'];
        } else {
          $pausetime = '7000';
        }
        if(isset($virtue_premium['slider_captions'])) { 
          $captions = $virtue_premium['slider_captions']; 
        } else {
          $captions = '';
        }
                ?>
    <div class="sliderclass carousel_outerrim loading">
      <div id="home-img-carousel-gallery" class="fredcarousel fadein-carousel" style="overflow:hidden; height: <?php echo esc_attr($slideheight);?>px">
        <div class="gallery-carousel initimagecarousel" data-carousel-container="#home-img-carousel-gallery" data-carousel-transition="300" data-carousel-auto="<?php echo esc_attr($autoplay); ?>" data-carousel-speed="<?php echo esc_attr($pausetime);?>" data-carousel-id="imgcarousel">
          <?php foreach ($slides as $slide) {
                if(!empty($slide['target']) && $slide['target'] == 1) {
                    $target = '_blank';
                } else {
                    $target = '_self';
                }
                $image = aq_resize($slide['url'], null, $slideheight, false, false, false, $slide['attachment_id']);
                if(empty($image[0])) {
                  $image = array();
                  $image[0] = $slide['url'];
                  $image[1] = 400;
                  $image[2] = $slideheight;
                } ?>
                <div class="carousel_gallery_item" style="float:left; margin: 0 5px; width:<?php echo esc_attr($image[1]);?>px; height:<?php echo esc_attr($image[2]);?>px;">
                <?php if(!empty($slide['link'])){
                   echo '<a href="'.esc_url($slide['link']).'" class="homepromolink" target="'.esc_attr($target).'">'; 
                   } ?>
                <img src="<?php echo esc_url($image[0]);?>" width="<?php echo esc_attr($image[1]);?>" height="<?php echo esc_attr($image[2]);?>"  alt="<?php echo esc_attr($slide['title']); ?>" />
                      <?php if ($captions == '1') { ?> 
                                <div class="ic-caption">
                                <?php 
                                if ( !empty($slide['title']) ) {
                                  echo '<div class="captiontitle headerfont">'.$slide['title'].'</div>'; 
                                }
                                if ( !empty($slide['description']) ){ 
                                    echo '<div><div class="captiontext headerfont"><p>'.$slide['description'].'</p></div></div>'; 
                                } ?>
                                </div> 
                        <?php } ?>
                <?php if(!empty($slide['link'])) {
                   echo '</a>'; 
                  }?>
                </div>
          <?php } ?>         
              </div> <!--post gallery carousel-->
            <div class="clearfix"></div>
              <a id="prevport-imgcarousel" class="prev_carousel icon-arrow-left" href="#"></a>
              <a id="nextport-imgcarousel" class="next_carousel icon-arrow-right" href="#"></a>
          </div> <!--fredcarousel-->
          </div> <!--sliderclass -->