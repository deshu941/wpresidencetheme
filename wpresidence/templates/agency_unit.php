<?php
global $options;

$thumb_id            =  get_post_thumbnail_id($post->ID);
$preview             =  wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_listings');
$name                =  get_the_title();
$link                =  get_permalink();
$user_id             =  get_post_meta( $post->ID, 'user_meda_id', true);
$user_role           =  get_user_meta( $user_id, 'user_estate_role', true) ; 


if($user_role==3 ){
    $agent_phone       =   esc_html( get_post_meta($post->ID, 'agency_phone', true) );
    $agent_mobile       =   esc_html( get_post_meta($post->ID, 'agency_mobile', true) );
    $agent_email        =   esc_html( get_post_meta($post->ID, 'agency_email', true) );    
    $agent_skype        =   esc_html( get_post_meta($post->ID, 'agency_skype', true) );
    $agent_facebook     =   esc_html( get_post_meta($post->ID, 'agency_facebook', true) );
    $agent_twitter      =   esc_html( get_post_meta($post->ID, 'agency_twitter', true) );
    $agent_linkedin     =   esc_html( get_post_meta($post->ID, 'agency_linkedin', true) );
    $agent_pinterest    =   esc_html( get_post_meta($post->ID, 'agency_pinterest', true) );
    $agent_instagram    =   esc_html( get_post_meta($post->ID, 'agency_instagram', true) );
    $agent_address      =   esc_html(get_post_meta($post->ID,'agency_address',true));
}else{
    $agent_phone       =   esc_html( get_post_meta($post->ID, 'developer_phone', true) );
    $agent_mobile       =   esc_html( get_post_meta($post->ID, 'developer_mobile', true) );
    $agent_email        =   esc_html( get_post_meta($post->ID, 'developer_email', true) );    
    $agent_skype        =   esc_html( get_post_meta($post->ID, 'developer_skype', true) );
    $agent_facebook     =   esc_html( get_post_meta($post->ID, 'developer_facebook ', true) );
    $agent_twitter      =   esc_html( get_post_meta($post->ID, 'developer_twitter', true) );
    $agent_linkedin     =   esc_html( get_post_meta($post->ID, 'developer_linkedin', true) );
    $agent_pinterest    =   esc_html( get_post_meta($post->ID, 'developer_pinterest', true) );
    $agent_instagram    =   esc_html( get_post_meta($post->ID, 'developer_instagram', true) );
    $agent_address      =   esc_html(get_post_meta($post->ID,'developer_address',true));
}






$extra= array(
    'data-original'=>$preview[0],
    'class'	=> 'lazyload img-responsive',    
    );
$thumb_prop    = get_the_post_thumbnail_url($post->ID, 'property_listings',$extra);

if($thumb_prop==''){
    $thumb_prop = get_template_directory_uri().'/img/default_user_agent.gif';
}

$col_class=4;
if($options['content_class']=='col-md-12'){
    $col_class=3;
}


$counter            = '';
$user_for_id = intval(get_post_meta($post->ID,'user_meda_id',true));
if($user_for_id!=0){
$counter            =   count_user_posts($user_for_id,'estate_property',true);
}

           
?>




<div class="agency_unit" data-link="<?php print esc_url($link);?>">

    <?php 
        print '<div class="agency_unit_img"><div class="prop_new_details_back"></div>';
            print '<img src="'.$thumb_prop.'" />';
        print '</div>';
    ?>


    <div class="agency_unit_wrapper">
            <?php
            print '<h4> <a href="' . $link . '">' . $name. '</a></h4>';
            print '<div class="agent_address">'.$agent_address.'</div>';
            ?> 

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

            <div class="agency_social-wrapper"> 
                <?php
                    if ($agent_phone) {
                        print '<div class="agent_detail"><i class="fa fa-phone"></i><a href="tel:'.$agent_phone.'">' . $agent_phone . '</a></div>';
                    }

                    if ($agent_mobile) {
                        print '<div class="agent_detail"><i class="fa fa-mobile"></i><a href="tel:'.$agent_mobile.'">' . $agent_mobile . '</a></div>';
                    }

                    if ($agent_email) {
                        print '<div class="agent_detail"><i class="fa fa-envelope-o"></i><a href="mailto:'.$agent_email.'">' . $agent_email . '</a></div>';
                    }

                ?>
            </div>

            <div class="agency_users">
                <?php 
                $agent_list                     = (array)get_user_meta($user_id,'current_agent_list',true);
               
                if(is_array($agent_list)){
                    $agent_list= array_unique($agent_list);
                    foreach ($agent_list as $agent_user_id){
                       
                       // if( get_post_status( $agent_user_id)=='publish'){
                        
                            $sub_agent_id   =   intval( get_user_meta($agent_user_id,'user_agent_id',true));
                            if($sub_agent_id!=0){
                                $thumb_id       =   get_post_thumbnail_id($sub_agent_id);
                                $preview        =   wp_get_attachment_image_src($thumb_id, 'custom_slider_thumb');

                                if($preview[0]==''){
                                   $preview[0] =  get_template_directory_uri().'/img/default-user_1.png';
                                }

                                print '<a href="'.get_permalink($sub_agent_id).'" class="sub_agent" ><img src="'.$preview[0].'"/></a>';
                            }
                       // }
                    }
                }
                ?>
                
            </div>
            
            <?php if($user_for_id!=0){ ?>
            <div class="agent_card_my_listings">
                <?php 
                    echo $counter.' '; 
                    if($counter!=1){
                        _e('listings','wpestate');
                    }else{
                        _e('listing','wpestate');
                    }
                ?>
               
            </div>
            <?php } ?>
        

    </div>
</div>
