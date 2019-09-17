<?php
/**
 * @package Zoospas
 */

get_header();

$zs_options = ZoospasVars::$options;
?>
    <div class="zoospas_container">

        <?php
        while ( have_posts() ) :
            the_post();
            global $post;
            $is_left_button = has_shortcode( $post->post_content, 'zs_button_left' );
            $is_right_button = has_shortcode( $post->post_content, 'zs_button_right' );
        ?>
        
  <div class="about">
    <div class="about__container">
      <div class="about__desc-container">
        <div class="card__image big" style="background-image: url('<?php do_action('zs_sp_thumbnail_url'); ?>');"></div>
        <div class="about__info-container">
          <div class="div-block">
            <div class="card__title-big"><?php do_action('zs_sp_title');?></div>
            
            <?php if ( has_shortcode( $post->post_content, 'zs_button_left' ) ) {?>
            <a href="<?php echo $zs_options['buttons']['left']['url'];?>" data-w-id="ddaa9b6a-026f-2b69-aa55-191ec8b88f65" class="card__like-big">
              <div class="heart-img w-embed"><svg width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill="currentColor" d="M11.9998 21C11.8682 21.0008 11.7377 20.9756 11.6159 20.9258C11.4941 20.876 11.3833 20.8027 11.2898 20.71L3.51982 12.93C2.54518 11.9452 1.99848 10.6156 1.99848 9.23002C1.99848 7.84445 2.54518 6.51484 3.51982 5.53002C4.50208 4.55053 5.83265 4.00049 7.21982 4.00049C8.60699 4.00049 9.93756 4.55053 10.9198 5.53002L11.9998 6.61002L13.0798 5.53002C14.0621 4.55053 15.3926 4.00049 16.7798 4.00049C18.167 4.00049 19.4976 4.55053 20.4798 5.53002C21.4545 6.51484 22.0012 7.84445 22.0012 9.23002C22.0012 10.6156 21.4545 11.9452 20.4798 12.93L12.7098 20.71C12.6164 20.8027 12.5056 20.876 12.3837 20.9258C12.2619 20.9756 12.1314 21.0008 11.9998 21ZM7.21982 6.00002C6.79649 5.9981 6.377 6.0802 5.98563 6.24155C5.59425 6.40291 5.23879 6.64031 4.93982 6.94002C4.33588 7.54714 3.99685 8.36866 3.99685 9.22502C3.99685 10.0814 4.33588 10.9029 4.93982 11.51L11.9998 18.58L19.0598 11.51C19.6638 10.9029 20.0028 10.0814 20.0028 9.22502C20.0028 8.36866 19.6638 7.54714 19.0598 6.94002C18.4435 6.35773 17.6277 6.03331 16.7798 6.03331C15.9319 6.03331 15.1162 6.35773 14.4998 6.94002L12.7098 8.74002C12.6169 8.83374 12.5063 8.90814 12.3844 8.95891C12.2625 9.00968 12.1318 9.03581 11.9998 9.03581C11.8678 9.03581 11.7371 9.00968 11.6152 8.95891C11.4934 8.90814 11.3828 8.83374 11.2898 8.74002L9.49982 6.94002C9.20085 6.64031 8.84538 6.40291 8.45401 6.24155C8.06264 6.0802 7.64314 5.9981 7.21982 6.00002V6.00002Z"></path>
</svg></div>
            </a>
            <?php }?>
          </div>
          <?php do_action('zs_p_cardmeta_v2_div'); ?>
          <?php if ( $is_left_button || $is_right_button ) {?>
          <div class="about__btn-container">
          	 <?php if ( $is_left_button ) {
          	 	echo do_shortcode('[zs_button_left]');
             }?>
             
             <?php if ( $is_left_button && $is_right_button ) {?>
             <div class="spacer _32w"></div>
             <?php }?>
             
             <?php if ( $is_right_button ) {
             	echo do_shortcode('[zs_button_right]');
             }?>
          </div>
          <?php }?>
        </div>
      </div>
      <div class="card__txt-descrp"><?php do_action('zs_sp_content_strip_buttons'); ?></div>
    </div>
  </div>        

        <?php endwhile; // End of the loop.
        ?>
        
    </div>

<?php

get_footer();