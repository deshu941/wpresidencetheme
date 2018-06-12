<?php
global $options;

$thumb_id           = get_post_thumbnail_id($post->ID);
$preview            = wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_listings');
$agent_skype        = esc_html( get_post_meta($post->ID, 'agent_skype', true) );
$agent_phone        = esc_html( get_post_meta($post->ID, 'agent_phone', true) );
$agent_mobile       = esc_html( get_post_meta($post->ID, 'agent_mobile', true) );
$agent_email        = esc_html( get_post_meta($post->ID, 'agent_email', true) );

$agent_posit        = esc_html( get_post_meta($post->ID, 'agent_position', true) );
                    
$agent_facebook     = esc_html( get_post_meta($post->ID, 'agent_facebook', true) );
$agent_twitter      = esc_html( get_post_meta($post->ID, 'agent_twitter', true) );
$agent_linkedin     = esc_html( get_post_meta($post->ID, 'agent_linkedin', true) );
$agent_pinterest    = esc_html( get_post_meta($post->ID, 'agent_pinterest', true) );
$agent_instagram    = esc_html( get_post_meta($post->ID, 'agent_instagram', true) );
$name               = get_the_title();
$link               = get_permalink();
$counter            = '';


$user_for_id = intval(get_post_meta($post->ID,'user_meda_id',true));
if($user_for_id!=0){
$counter            =   count_user_posts($user_for_id,'estate_property',true);
}


$extra= array(
        'data-original'=>$preview[0],
        'class'	=> 'lazyload img-responsive',    
        );
$thumb_prop    = get_the_post_thumbnail($post->ID, 'property_listings',$extra);

if($thumb_prop==''){
    $thumb_prop = '<img src="'.get_template_directory_uri().'/img/default_user.png" alt="agent-images">';
}

$col_class=4;
if($options['content_class']=='col-md-12'){
    $col_class=3;
}


           
?>




    <div class="agent_unit" data-link="<?php print esc_url($link);?>">
        <div class="agent-unit-img-wrapper">
            <?php if($user_for_id!=0){ ?>
            <div class="agent_card_my_listings">
                <?php echo $counter.' '; 
                    if($counter!=1){
                        _e('listings','wpestate');
                    }else{
                        _e('listing','wpestate');
                    }
                ?>
            </div>
            <?php } ?>
            
            
            <div class="prop_new_details_back"></div>
            <?php 
                print $thumb_prop; 
            ?>
        </div>    
            
        <div class="">
            <?php
            print '<h4> <a href="' . $link . '">' . $name. '</a></h4>
            <div class="agent_position">'. $agent_posit .'</div>';
           
            if ($agent_phone) {
                print '<div class="agent_detail"><i class="fa fa-phone"></i><a href="tel:'.$agent_phone.'">'. $agent_phone .'</a></div>';
            }
            if ($agent_mobile) {
                print '<div class="agent_detail"><i class="fa fa-mobile"></i><a href="tel:'.$agent_mobile.'">' . $agent_mobile . '</a></div>';
            }

            if ($agent_email) {
                print '<div class="agent_detail"><i class="fa fa-envelope-o"></i><a href="mailto:'.$agent_email.'">' . $agent_email . '</a></div>';
            }

            if ($agent_skype) {
                print '<div class="agent_detail"><i class="fa fa-skype"></i>' . $agent_skype . '</div>';
            }
            ?>
           
          
        </div> 
          
        <a href="<?php print esc_url($link); ?>"  class=" agent_unit_button agent_unit_contact_me" ><?php _e('Contact me','wpestate');?></a>
        
        <div class="agent_unit_social agent_list">
            <div class="social-wrapper"> 
               
               <?php
               
                if($agent_facebook!=''){
                    print ' <a href="'. $agent_facebook.'"><i class="fa fa-facebook"></i></a>';
                }

                if($agent_twitter!=''){
                    print ' <a href="'.$agent_twitter.'"><i class="fa fa-twitter"></i></a>';
                }
                
                if($agent_linkedin!=''){
                    print ' <a href="'.$agent_linkedin.'"><i class="fa fa-linkedin"></i></a>';
                }
                
                if($agent_pinterest!=''){
                    print ' <a href="'. $agent_pinterest.'"><i class="fa fa-pinterest"></i></a>';
                }
                
                if($agent_instagram!=''){
                    print ' <a href="'. $agent_instagram.'"><i class="fa fa-instagram"></i></a>';
                }
                ?>
            </div>
        </div>
    </div>
<!-- </div>    -->