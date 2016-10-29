<?php 

if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
      <div id="pageheader" class="titleclass">
        <div class="container">
          <div class="page-header">
            <div class="row">
              <div class="col-md-6 col-sm-6 woo-archive-pg-title">
                 <?php do_action( 'kt_woocommerce_page_title_left' ); ?>
              </div>
              <div class="col-md-6 col-sm-6 woo-archive-pg-order">
               <?php do_action( 'kt_woocommerce_page_title_right' ); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    
    <?php endif; ?>