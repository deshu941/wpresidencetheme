<?php
global $property_unit_slider;
global $sale_line;
    
$prop_id        =   $post->ID;
$return_string  =   '';    

$preview        =   wp_get_attachment_image_src(get_post_thumbnail_id($prop_id), 'full');
$return_string.= '<div class="featured_article_type2 featured_prop_type4">
                       <div class="featured_img_type2" style="background-image:url('.$preview[0] .')">
                           
                            <div class="featured_gradient"></div>
                            <div class="featured_article_type2_title_wrapper">
                                <div class="featured_article_label">'.__('Featured Property','wpestate').'</div>
                                <h2>'.get_the_title($prop_id).'</h2>
                                <div class="featured_read_more"><a href="'.get_permalink($prop_id).'">'.__('discover more','wpestate').'</a> <i class="fa fa-angle-right"></i></div>    
                            </div>        
                        </div>
                    </div>';

echo $return_string;