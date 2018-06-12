<?php
global $options;
global $agent_wid;

if($agent_wid!=0){
    $thumb_id           = get_post_thumbnail_id($agent_wid);
    $preview            = wp_get_attachment_image_src(get_post_thumbnail_id($agent_wid), 'property_listings');
<<<<<<< HEAD
    $agent_skype        = esc_html( get_post_meta($agent_wid, 'agent_skype', true) );
    $agent_phone        = esc_html( get_post_meta($agent_wid, 'agent_phone', true) );
    $agent_mobile       = esc_html( get_post_meta($agent_wid, 'agent_mobile', true) );
    $agent_email        = esc_html( get_post_meta($agent_wid, 'agent_email', true) );

    $agent_posit        = esc_html( get_post_meta($agent_wid, 'agent_position', true) );
    $agent_facebook     = esc_html( get_post_meta($agent_wid, 'agent_facebook', true) );
    $agent_twitter      = esc_html( get_post_meta($agent_wid, 'agent_twitter', true) );
    $agent_linkedin     = esc_html( get_post_meta($agent_wid, 'agent_linkedin', true) );
    $agent_pinterest    = esc_html( get_post_meta($agent_wid, 'agent_pinterest', true) );
    $agent_urlc         = esc_html( get_post_meta($agent_wid, 'agent_website', true) );
    $name               = get_the_title($agent_wid);
    $link               = get_permalink($agent_wid);

=======
    $name               = get_the_title($agent_wid);
    $link               = get_permalink($agent_wid);
    $type=get_post_type($agent_wid);
    
    if( $type=='estate_agent' ){
        $agent_skype        = esc_html( get_post_meta($agent_wid, 'agent_skype', true) );
        $agent_phone        = esc_html( get_post_meta($agent_wid, 'agent_phone', true) );
        $agent_mobile       = esc_html( get_post_meta($agent_wid, 'agent_mobile', true) );
        $agent_email        = esc_html( get_post_meta($agent_wid, 'agent_email', true) );

        $agent_posit        = esc_html( get_post_meta($agent_wid, 'agent_position', true) );
        $agent_facebook     = esc_html( get_post_meta($agent_wid, 'agent_facebook', true) );
        $agent_twitter      = esc_html( get_post_meta($agent_wid, 'agent_twitter', true) );
        $agent_linkedin     = esc_html( get_post_meta($agent_wid, 'agent_linkedin', true) );
        $agent_pinterest    = esc_html( get_post_meta($agent_wid, 'agent_pinterest', true) );
        $agent_instagram    = esc_html( get_post_meta($agent_wid, 'agent_instagram', true) );
        $agent_urlc         = esc_html( get_post_meta($agent_wid, 'agent_website', true) );
    }else if( $type=='estate_agency' ){
        $agent_skype        = esc_html( get_post_meta($agent_wid, 'agency_skype', true) );
        $agent_phone        = esc_html( get_post_meta($agent_wid, 'agency_phone', true) );
        $agent_mobile       = esc_html( get_post_meta($agent_wid, 'agency_mobile', true) );
        $agent_email        = esc_html( get_post_meta($agent_wid, 'agency_email', true) );

        $agent_posit        = esc_html( get_post_meta($agent_wid, 'agency_position', true) );
        $agent_facebook     = esc_html( get_post_meta($agent_wid, 'agency_facebook', true) );
        $agent_twitter      = esc_html( get_post_meta($agent_wid, 'agency_twitter', true) );
        $agent_linkedin     = esc_html( get_post_meta($agent_wid, 'agency_linkedin', true) );
        $agent_pinterest    = esc_html( get_post_meta($agent_wid, 'agency_pinterest', true) );
        $agent_instagram    = esc_html( get_post_meta($agent_wid,  'agency_instagram', true) );
        $agent_urlc         = esc_html( get_post_meta($agent_wid, 'agency_website', true) );
    }else if($type=='estate_developer'){
        $agent_skype        = esc_html( get_post_meta($agent_wid, 'developer_skype', true) );
        $agent_phone        = esc_html( get_post_meta($agent_wid, 'developer_phone', true) );
        $agent_mobile       = esc_html( get_post_meta($agent_wid, 'developer_mobile', true) );
        $agent_email        = esc_html( get_post_meta($agent_wid, 'developer_email', true) );

        $agent_posit        = esc_html( get_post_meta($agent_wid, 'developer_position', true) );
        $agent_facebook     = esc_html( get_post_meta($agent_wid, 'developer_facebook', true) );
        $agent_twitter      = esc_html( get_post_meta($agent_wid, 'developer_twitter', true) );
        $agent_linkedin     = esc_html( get_post_meta($agent_wid, 'developer_linkedin', true) );
        $agent_pinterest    = esc_html( get_post_meta($agent_wid, 'developer_pinterest', true) );
        $agent_instagram    = esc_html( get_post_meta($agent_wid, ' developer_instagram', true) );
        $agent_urlc         = esc_html( get_post_meta($agent_wid, 'developer_website', true) );
    }
    
    
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    $extra= array(
            'data-original'=>$preview[0],
            'class'	=> 'lazyload img-responsive',    
            );
    $thumb_prop    = get_the_post_thumbnail($agent_wid, 'property_listings',$extra);

    if($thumb_prop==''){
        $thumb_prop = '<img src="'.get_template_directory_uri().'/img/default_user.png" alt="agent-images">';
    }
    
}else{
    
    $thumb_prop    =   get_the_author_meta( 'custom_picture',$agent_wid  );
    if($thumb_prop==''){
        $thumb_prop=get_template_directory_uri().'/img/default-user.png';
    }
    
    $thumb_prop = '<img src="'.$thumb_prop.'" alt="agent-images">';
    
    $agent_skype         = get_the_author_meta( 'skype' ,$agent_wid );
    $agent_phone         = get_the_author_meta( 'phone'  ,$agent_wid);
    $agent_mobile        = get_the_author_meta( 'mobile'  ,$agent_wid);
    $agent_email         = get_the_author_meta( 'user_email' ,$agent_wid );
    $agent_pitch         = '';
    $agent_posit         = get_the_author_meta( 'title' ,$agent_wid );
    $agent_facebook      = get_the_author_meta( 'facebook',$agent_wid  );
    $agent_twitter       = get_the_author_meta( 'twitter' ,$agent_wid );
    $agent_linkedin      = get_the_author_meta( 'linkedin'  ,$agent_wid);
    $agent_pinterest     = get_the_author_meta( 'pinterest',$agent_wid  );
<<<<<<< HEAD
    $agent_urlc          = get_the_author_meta( 'website' ,$agent_wid );
    $link                = get_permalink();
    $name                = get_the_author_meta( 'first_name' ).' '.get_the_author_meta( 'last_name');

}

=======
    $agent_instagram     = get_the_author_meta( 'instagram',$agent_wid  );
    $agent_urlc          = get_the_author_meta( 'website' ,$agent_wid );
    $link                = get_permalink();
    $name                = get_the_author_meta( 'first_name' ).' '.get_the_author_meta( 'last_name');
    
}

$counter            = '';


$user_for_id = intval(get_post_meta($agent_wid,'user_meda_id',true));
if($user_for_id!=0){
$counter            =   count_user_posts($user_for_id,'estate_property',true);
}


>>>>>>> 64662fd89bea560852792d7203888072d7452d48
$col_class=4;
if($options['content_class']=='col-md-12'){
    $col_class=3;
}
           
?>

<<<<<<< HEAD


<!-- <div class="col-md-<?php //print $col_class;?> listing_wrapper"> -->
    <div class="agent_unit" data-link="<?php print $link;?>">
        <div class="agent-unit-img-wrapper">
            <?php 
            print $thumb_prop; 
            print '<div class="listing-cover"></div>
                   <a href="'.$link.'"> <span class="listing-cover-plus">+</span></a>';
=======
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
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
            ?>
        </div>    
            
        <div class="">
            <?php
            print '<h4> <a href="' . $link . '">' . $name. '</a></h4>
            <div class="agent_position">'. $agent_posit .'</div>';
           
            if ($agent_phone) {
<<<<<<< HEAD
                print '<div class="agent_detail"><i class="fa fa-phone"></i>' . $agent_phone . '</div>';
            }
            if ($agent_mobile) {
                print '<div class="agent_detail"><i class="fa fa-mobile"></i>' . $agent_mobile . '</div>';
            }

            if ($agent_email) {
                print '<div class="agent_detail"><i class="fa fa-envelope-o"></i>' . $agent_email . '</div>';
=======
                print '<div class="agent_detail"><i class="fa fa-phone"></i><a href="tel:'.$agent_phone.'">'. $agent_phone .'</a></div>';
            }
            if ($agent_mobile) {
                print '<div class="agent_detail"><i class="fa fa-mobile"></i><a href="tel:'.$agent_mobile.'">' . $agent_mobile . '</a></div>';
            }

            if ($agent_email) {
                print '<div class="agent_detail"><i class="fa fa-envelope-o"></i><a href="mailto:'.$agent_email.'">' . $agent_email . '</a></div>';
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
            }

            if ($agent_skype) {
                print '<div class="agent_detail"><i class="fa fa-skype"></i>' . $agent_skype . '</div>';
            }
            
            if ($agent_urlc) {
                print '<div class="agent_detail"><i class="fa fa-desktop"></i><a href="http://'.$agent_urlc.'" target="_blank">'.$agent_urlc.'</a></div>';
            }
            
            
            ?>
<<<<<<< HEAD
=======
            <a href="<?php print esc_url($link); ?>"  class=" agent_unit_button agent_unit_contact_me" ><?php _e('Contact me','wpestate');?></a>
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        </div> 
    
        
        <div class="agent_unit_social">
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
<<<<<<< HEAD

=======
                if($agent_instagram!=''){
                    print ' <a href="'. $agent_instagram.'"><i class="fa fa-instagram"></i></a>';
                }
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
               
               ?>
              
            </div>
        </div>
    </div>
<!-- </div>    -->