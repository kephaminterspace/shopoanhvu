 <?php 
 global $post, $virtue_premium, $kt_post_with_sidebar, $kt_feat_width;

    if($kt_post_with_sidebar){
        $kt_feat_width = 848;
    } else {
        $kt_feat_width = 1140;
    }

     /**
    * @hooked virtue_single_post_upper_headcontent - 10
    */
    do_action( 'kadence_single_post_begin' ); 

    do_action( 'kadence_single_post_before' ); 
    ?> 
    <article <?php post_class("kad_blog_item"); ?> itemscope="" itemtype="http://schema.org/BlogPosting">
         <?php 
          /**
          * @hooked virtue_single_post_headcontent - 10
          * @hooked virtue_single_post_meta_date - 20
          */
          do_action( 'kadence_single_post_before_header' );
          ?>
        <header>
          <?php 
            /**
            * @hooked virtue_post_full_loop_title - 20
            * @hooked virtue_post_header_meta - 30
            */
            do_action( 'kadence_single_loop_post_header' );
            ?>
        </header>
        <div class="entry-content clearfix" itemprop="articleBody">
        <?php 
            do_action( 'kadence_single_post_content_before' );

            global $more; $more = 0; 
            if(!empty($virtue_premium['post_readmore_text'])) {
                $readmore = $virtue_premium['post_readmore_text'];
            } else { 
                $readmore =  __('Read More', 'virtue') ;
            }
            the_content($readmore); 

            do_action( 'kadence_single_post_content_after' );
        ?>
        </div>
        <footer class="single-footer">
        <?php 
            /**
            * @hooked virtue_post_footer_tags - 20
            */
            do_action( 'kadence_single_loop_post_footer' );

              if ( comments_open() ) :
                echo '<p class="kad_comments_link">';
                  comments_popup_link( 
                    __( 'Leave a Reply', 'virtue' ), 
                    __( '1 Comment', 'virtue' ), 
                    __( '% Comments', 'virtue' ),
                    'comments-link',
                    __( 'Comments are Closed', 'virtue' )
                );
                echo '</p>';
              endif;
          ?>
        </footer>
    </article>

