<?php
global $price;
global $price_label_before;
global $price_label;

$crop_images_lightbox       =   esc_html ( get_option('wp_estate_crop_images_lightbox','') );
$show_lightbox_contact      =   esc_html ( get_option('wp_estate_show_lightbox_contact','') );
$class_image_wrapper        =   'col-md-10';
$class_image_wrapper_global =   '';

if($show_lightbox_contact   ==  'no'){
    $class_image_wrapper        =   'col-md-12 lightbox_no_contact ';    
    $class_image_wrapper_global .=   ' lightbox_wrapped_no_contact ';
}


if($crop_images_lightbox=='no'){
      $class_image_wrapper_global .=   ' ligtbox_no_crop ';
}

?>


<div class="lightbox_property_wrapper">
    
    <div class="lightbox_property_wrapper_level2 <?php echo $class_image_wrapper_global; ?>">
        
        
       

        <div class="lightbox_property_content row">

            <div class="lightbox_property_slider <?php echo $class_image_wrapper; ?>">
                <div  id="owl-demo" class="owl-carousel owl-theme">
                    
                    
                    
                    <?php
                    $featured_id        =   get_post_thumbnail_id($post->ID);
                    $attachment_meta    =   wp_get_attachment($featured_id);
                   
                    if($crop_images_lightbox=='yes'){
                        $full_img           =   wp_get_attachment_image_src($featured_id, 'listing_full_slider_1');
                        echo '<div class="item" style="background-image:url('.$full_img[0].')">';
                          
                            if(trim($attachment_meta['caption'])!=''){
                               echo '<div class="owl_caption"> '. $attachment_meta['caption'].'</div>'; 
                            }
                         echo'</div>';
                    
                    }else{
                        $full_img           =   wp_get_attachment_image_src($featured_id, 'full');
                        echo '<div class="item">';
                            echo '<img src="'.$full_img[0].'" alt="slider" >';
                            if(trim($attachment_meta['caption'])!=''){
                               echo '<div class="owl_caption"> '. $attachment_meta['caption'].'</div>'; 
                            }
                         echo'</div>';
                    }
                  
                        
                  
                        
                        
                        
                    $arguments      = array(
                            'numberposts' => -1,
                            'post_type' => 'attachment',
                            'post_mime_type' => 'image',
                            'post_parent' => $post->ID,
                            'post_status' => null,
                            'exclude' => $featured_id,
                            'orderby' => 'menu_order',
                            'order' => 'ASC'
                        );

                    $post_attachments   = get_posts($arguments);
                    foreach ($post_attachments as $attachment) {
                        

                        $full_img           = wp_get_attachment_image_src($attachment->ID, 'listing_full_slider_1');
                        $attachment_meta    = wp_get_attachment($attachment->ID);
                        if( $crop_images_lightbox=='yes'){
                            echo '<div class="item" style="background-image:url('.$full_img[0].')">';
                                if(trim($attachment_meta['caption'])!=''){
                                    echo '<div class="owl_caption"> '. $attachment_meta['caption'].'</div>'; 
                                }
                            echo'</div>';
                        }else{
                            $full_img           = wp_get_attachment_image_src($attachment->ID, 'full');
                            echo '<div class="item">';
                                echo '<img src="'.$full_img[0].'" alt="slider" >';
                                if(trim($attachment_meta['caption'])!=''){
                                   echo '<div class="owl_caption"> '. $attachment_meta['caption'].'</div>'; 
                                }
                             echo'</div>';
                        }
                    }
                    ?>
                </div>
            </div>

            <?php if($show_lightbox_contact=='yes'){ ?>
                <div class="lightbox_property_sidebar col-md-2">
                    <div class="lightbox_property_header">
                        <h1 class="entry-title entry-prop"><?php the_title(); ?></h1>  
                    </div>
                    <h4 class="lightbox_enquire"><?php _e('Want to find out more?','wpestate');?></h4>
                    <?php  get_template_part ('/templates/agent_area'); ?>
                </div>
            <?php } ?>

        </div>


       
        <div class="lighbox-image-close">
                <i class="fa fa-times" aria-hidden="true"></i>
        </div>
    </div>
    
    <div class="lighbox_overlay">
    </div>    
</div>