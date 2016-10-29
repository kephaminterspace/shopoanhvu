<?php
/*
* Standard post Archive
*
*/
  global $virtue_premium; 

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
   if(isset($virtue_premium['category_post_summary']) && $virtue_premium['category_post_summary'] == 'full') {
      $summary = 'full'; 
      $postclass = "single-article fullpost";
   } else if (isset($virtue_premium['category_post_summary']) && $virtue_premium['category_post_summary'] == 'grid'){
      $summary = 'grid'; 
      $postclass = "grid-postlist";
   } else {
      $summary = 'normal'; 
      $postclass = 'postlist';
   } 

   if(isset($virtue_premium['blog_cat_infinitescroll']) && $virtue_premium['blog_cat_infinitescroll'] == 1) {
       if($summary == 'grid') {
         $infinit = 'data-nextselector=".wp-pagenavi a.next" data-navselector=".wp-pagenavi" data-itemselector=".kad_blog_item" data-itemloadselector=".kad_blog_fade_in" data-infiniteloader="'.get_template_directory_uri() . '/assets/img/loader.gif"';
         $scrollclass = 'init-infinit';
      } else {
         $infinit = 'data-nextselector=".wp-pagenavi a.next" data-navselector=".wp-pagenavi" data-itemselector=".post" data-itemloadselector=".kad-animation" data-infiniteloader="'.get_template_directory_uri() . '/assets/img/loader.gif"';
         $scrollclass = 'init-infinit-norm';
      }
   } else {
      $infinit = '';
      $scrollclass = '';
   }
   if(isset($virtue_premium['virtue_animate_in']) && $virtue_premium['virtue_animate_in'] == 1) {
      $animate = 1;
   } else {
      $animate = 0;
   } 
   if(isset($virtue_premium['category_post_grid_column'])) {
      $blog_grid_column = $virtue_premium['category_post_grid_column'];
   } else {
      $blog_grid_column = '3';
   } 
   if ($blog_grid_column == '2') {
      $itemsize = 'tcol-md-6 tcol-sm-6 tcol-xs-12 tcol-ss-12'; 
   } else if ($blog_grid_column == '3'){ 
      $itemsize = 'tcol-md-4 tcol-sm-4 tcol-xs-6 tcol-ss-12'; 
   } else {
      $itemsize = 'tcol-md-3 tcol-sm-4 tcol-xs-6 tcol-ss-12';
   }
?>
<div id="pageheader" class="titleclass">
    <div class="container">
      <?php get_template_part('templates/page', 'header'); ?>
    </div><!--container-->
</div><!--titleclass-->
<div id="content" class="container">
   <div class="row">
      <div class="main <?php echo esc_attr(kadence_main_class()); ?>  <?php echo esc_attr($postclass) .' '. esc_attr($fullclass); ?>" role="main">

      <?php if (!have_posts()) : ?>
         <div class="alert">
          <?php _e('Sorry, no results were found.', 'virtue'); ?>
         </div>
         <?php get_search_form(); ?>
      <?php endif; ?>

      <?php if($summary == 'full'){ ?>
         <div class="kt_archivecontent <?php echo esc_attr($scrollclass); ?>" <?php echo $infinit; ?>> 
              <?php 
               if($display_sidebar){
                  while (have_posts()) : the_post();
                     get_template_part('templates/content', 'fullpost'); 
                  endwhile;
               } else {
                  while (have_posts()) : the_post(); 
                     get_template_part('templates/content', 'fullpostfull');
                  endwhile;
               } ?>
               </div> 
               <?php 
            } else if($summary == 'grid') { ?>
               <div id="kad-blog-grid" class="rowtight archivecontent <?php echo esc_attr($scrollclass); ?> init-isotope" <?php echo $infinit; ?> data-fade-in="<?php echo esc_attr($animate);?>" data-fade-in="<?php echo esc_attr($animate);?>" data-iso-selector=".b_item" data-iso-style="masonry">
                 <?php while (have_posts()) : the_post(); ?>
                     <?php if($blog_grid_column == '2') { ?>
                       <div class="<?php echo esc_attr($itemsize);?> b_item kad_blog_item">
                       <?php get_template_part('templates/content', 'twogrid'); ?>
                       </div>
                     <?php } else {?>
                       <div class="<?php echo esc_attr($itemsize);?> b_item kad_blog_item">
                       <?php get_template_part('templates/content', 'fourgrid');?>
                       </div>
                     <?php } ?>
                   <?php endwhile; ?>
               </div>
                <?php
            } else {
               ?>
               <div class="kt_archivecontent <?php echo esc_attr($scrollclass); ?>" <?php echo $infinit; ?>> 
               <?php
                     while (have_posts()) : the_post();
                          get_template_part('templates/content', get_post_format());
                     endwhile;
                  ?>
               </div> 
               <?php 
            }

            if ($wp_query->max_num_pages > 1) : 
                  kad_wp_pagenavi(); 
            endif; ?>
</div><!-- /.main -->