<?php

$current_user              =   wp_get_current_user();
$userID                    =   $current_user->ID;
$user_login                =   $current_user->user_login;
$developer_id              =   get_the_author_meta('user_agent_id',$userID);
$developer_title           =   get_the_title($developer_id);
$developer_description     =   get_post_field('post_content', $developer_id);
$developer_email           =   get_the_author_meta( 'user_email' , $userID );
$developer_phone           =   esc_html(get_post_meta($developer_id, 'developer_phone', true));
$developer_mobile          =   esc_html(get_post_meta($developer_id, 'developer_mobile', true));
$developer_skype           =   esc_html(get_post_meta($developer_id, 'developer_skype', true));
$developer_facebook        =   esc_html(get_post_meta($developer_id, 'developer_facebook', true));
$developer_twitter         =   esc_html(get_post_meta($developer_id, 'developer_twitter', true));
$developer_linkedin        =   esc_html(get_post_meta($developer_id, 'developer_linkedin', true));
$developer_pinterest       =   esc_html(get_post_meta($developer_id, 'developer_pinterest', true));
$developer_instagram       =   esc_html(get_post_meta($developer_id, 'developer_instagram', true));
$developer_address         =   esc_html(get_post_meta($developer_id, 'developer_address', true));
$developer_languages       =   esc_html(get_post_meta($developer_id, 'developer_languages', true));     
$developer_license         =   esc_html(get_post_meta($developer_id, 'developer_license', true));
$developer_taxes           =   esc_html(get_post_meta($developer_id, 'developer_taxes', true));    
$developer_lat             =   esc_html(get_post_meta($developer_id, 'developer_lat', true));    
$developer_long            =   esc_html(get_post_meta($developer_id, 'developer_long', true));
$developer_website         =   esc_html(get_post_meta($developer_id, 'developer_website', true));


$developer_city='';
$developer_city_array     =   get_the_terms($developer_id, 'property_city_developer');
if(isset($developer_city_array[0])){
    $developer_city         =   $developer_city_array[0]->name;
}

 $developer_area='';
$developer_area_array     =   get_the_terms($developer_id, 'property_area_developer');
if(isset($developer_area_array[0])){
    $developer_area          =   $developer_area_array[0]->name;
}

$developer_county='';
$developer_county_array     =   get_the_terms($developer_id, 'property_county_state_developer');
if(isset($developer_county_array[0])){
    $developer_county          =   $developer_county_array[0]->name;
}

        
        
$user_custom_picture    =   get_the_post_thumbnail_url($developer_id,'user_picture_profile');
$image_id               =   get_post_thumbnail_id($developer_id);

if($user_custom_picture==''){
    $user_custom_picture=get_template_directory_uri().'/img/default_user.png';
}
$user_agent_id          =   intval( get_user_meta($userID,'user_agent_id',true));
?>

<div class="col-md-12 user_profile_div"> 
    <div id="profile_message">
        </div>
    <?php
    if ( wp_is_mobile() ) {
        echo '<div class="add-estate profile-page profile-onprofile">';

            if ( $user_agent_id!=0 && get_post_status($user_agent_id)=='pending'  ){
                echo '<div class="user_dashboard_app">'.__('Your account is pending approval. Please wait for admin to approve it. ','wpestate').'</div>';
            }
            if ( $user_agent_id!=0 && get_post_status($user_agent_id)=='disabled' ){
                echo '<div class="user_dashboard_app">'.__('Your account is disabled.','wpestate').'</div>';
            }
               
        echo '</div>';

    }
    ?>
<div class="add-estate profile-page profile-onprofile row"> 
    
    <div class="col-md-4 profile_label">
        <div class="user_details_row"><?php _e('Photo','wpestate');?></div> 
        <div class="user_profile_explain"><?php _e('Upload your profile photo.','wpestate')?></div>
    </div>

    <div class="profile_div col-md-4" id="profile-div">
        <?php print '<img id="profile-image" src="'.$user_custom_picture.'" alt="user image" data-profileurl="'.$user_custom_picture.'" data-smallprofileurl="'.$image_id.'" >';

        //print '/ '.$user_small_picture;?>

        <div id="upload-container">                 
            <div id="aaiu-upload-container">                 

                <button id="aaiu-uploader" class="wpresidence_button wpresidence_success"><?php _e('Upload  profile image.','wpestate');?></button>
                <div id="aaiu-upload-imagelist">
                    <ul id="aaiu-ul-list" class="aaiu-upload-list"></ul>
                </div>
            </div>  
        </div>
        <span class="upload_explain"><?php _e('*minimum 500px x 500px','wpestate');?></span>                    
    </div>
</div>

    
    
    
<div class="add-estate profile-page profile-onprofile row"> 
    <div class="col-md-4 profile_label">
        <div class="user_details_row"><?php _e('Developer Details','wpestate');?></div> 
        <div class="user_profile_explain"><?php _e('Add your contact information.','wpestate')?></div>

    </div>
          
    <div class="col-md-4">
        <p>
            <label for="developer_title"><?php _e('Developer Name','wpestate');?></label>
            <input type="text" id="developer_title" class="form-control" value="<?php echo esc_html(stripslashes($developer_title));?>"  name="developer_title">
        </p>

        <p>
            <label for="useremail"><?php _e('Email','wpestate');?></label>
            <input type="text" id="useremail"  class="form-control" value="<?php echo esc_html($developer_email);?>"  name="useremail">
        </p>
        
        <p>
            <label for="userskype"><?php _e('Skype', 'wpestate'); ?></label>
            <input type="text" id="userskype" class="form-control" value="<?php echo esc_html($developer_skype); ?>"  name="userskype">
        </p>
        
        <p>
            <label for="website"><?php _e('Taxes','wpestate');?></label>
            <input type="text" id="developer_taxes" name="developer_taxes" class="form-control" value="<?php echo esc_html($developer_taxes);?>">
        </p>
             
    </div>  

    <div class="col-md-4">
        <p>
            <label for="userphone"><?php _e('Phone', 'wpestate'); ?></label>
            <input type="text" id="userphone" class="form-control" value="<?php echo esc_html($developer_phone); ?>"  name="userphone">
        </p>
        <p>
            <label for="usermobile"><?php _e('Mobile', 'wpestate'); ?></label>
            <input type="text" id="usermobile" class="form-control" value="<?php echo esc_html($developer_mobile); ?>"  name="usermobile">
        </p>
        
        <p>
            <label for="website"><?php _e('Languages','wpestate');?></label>
            <input type="text" id="developer_languages" name="developer_languages" class="form-control" value="<?php echo esc_html($developer_languages);?>"  name="website">
        </p>
        
        <p>
            <label for="website"><?php _e('License ','wpestate');?></label>
            <input type="text" id="developer_license" name="developer_license" class="form-control" value="<?php echo esc_html($developer_license);?>"  name="website">
        </p>

        <?php   wp_nonce_field( 'profile_ajax_nonce', 'security-profile' );   ?>
       
    </div>
</div>
                             
<div class="add-estate profile-page profile-onprofile row">       
    <div class="col-md-4 profile_label">
        <div class="user_details_row"><?php _e('Developer Details','wpestate');?></div> 
        <div class="user_profile_explain"><?php _e('Add your social media information.','wpestate')?></div>

    </div>
    <div class="col-md-4">
        <p>
            <label for="userfacebook"><?php _e('Facebook Url', 'wpestate'); ?></label>
            <input type="text" id="userfacebook" class="form-control" value="<?php echo esc_html($developer_facebook); ?>"  name="userfacebook">
        </p>

        <p>
            <label for="usertwitter"><?php _e('Twitter Url', 'wpestate'); ?></label>
            <input type="text" id="usertwitter" class="form-control" value="<?php echo esc_html($developer_twitter); ?>"  name="usertwitter">
        </p>

        <p>
            <label for="userlinkedin"><?php _e('Linkedin Url', 'wpestate'); ?></label>
            <input type="text" id="userlinkedin" class="form-control"  value="<?php echo esc_html($developer_linkedin); ?>"  name="userlinkedin">
        </p>
    </div>
    <div class="col-md-4">
        <p>
            <label for="userinstagram"><?php _e('Instagram Url','wpestate');?></label>
            <input type="text" id="userinstagram" class="form-control" value="<?php echo esc_html($developer_instagram);?>"  name="userinstagram">
        </p> 

        <p>
            <label for="userpinterest"><?php _e('Pinterest Url','wpestate');?></label>
            <input type="text" id="userpinterest" class="form-control" value="<?php echo esc_html($developer_pinterest);?>"  name="userpinterest">
        </p> 

        <p>
            <label for="website"><?php _e('Website Url (without http)','wpestate');?></label>
            <input type="text" id="developer_website" class="form-control" value="<?php echo esc_html($developer_website);?>"  name="website">
        </p>
    </div> 
</div>
    
    
<div class="add-estate profile-page profile-onprofile row">
    <div class="col-md-4 profile_label">
        <div class="user_details_row"><?php _e('Developer Area/Categories','wpestate');?></div> 
        <div class="user_profile_explain"><?php _e('What kind of listings do you handle?','wpestate')?></div>
    </div>
    
    <div class="col-md-4">
        <p>
            <label for="developer_category"><?php _e('Category','wpestate');?></label>
       
        
        <?php 
            $developer_category_selected='';
            $developer_category_array            =   get_the_terms($developer_id, 'property_category_developer');
            if(isset($developer_category_array[0])){
                $developer_category_selected   =   $developer_category_array[0]->term_id;
            }
            $args=array(
                'class'       => 'select-submit2',
                'hide_empty'  => false,
                'selected'    => $developer_category_selected,
                'name'        => 'developer_category',
                'id'          => 'developer_category_submit',
                'orderby'     => 'NAME',
                'order'       => 'ASC',
                'show_option_none'   => __('None','wpestate'),
                'taxonomy'    => 'property_category_developer',
                'hierarchical'=> true
            );
            wp_dropdown_categories( $args ); ?>
            
        </p>
    </div>
    
    <div class="col-md-4">
          <p>
            <label for="developer_action"><?php _e('Action Category','wpestate');?></label>
            <?php
            $developer_action_selected='';
            $developer_action_array            =   get_the_terms($developer_id, 'property_action_developer');
            if(isset($developer_action_array[0])){
                $developer_action_selected   =   $developer_action_array[0]->term_id;
            }
            
            $args=array(
                'class'       => 'select-submit2',
                'hide_empty'  => false,
                'selected'    => $developer_action_selected,
                'name'        => 'developer_action',
                'id'          => 'developer_action_submit',
                'orderby'     => 'NAME',
                'order'       => 'ASC',
                'show_option_none'   => __('None','wpestate'),
                'taxonomy'    => 'property_action_developer',
                'hierarchical'=> true
            );
            wp_dropdown_categories( $args ); ?>
           
        </p>
    </div>
    
</div>

    
    
    
<div class="add-estate profile-page profile-onprofile row">
    <div class="col-md-4 profile_label">
        <div class="user_details_row"><?php _e('Developer Location','wpestate');?></div> 
        <div class="user_profile_explain"><?php _e('Add some information about you.','wpestate')?></div>
    </div>
    
    <div class="col-md-4">
        <p>
            <label for="developer_city"><?php _e('City','wpestate');?></label>
            <input type="text" id="developer_city" class="form-control" value="<?php echo esc_html($developer_city);?>"  name="developer_city">
        </p>
        <p>
            <label for="developer_area"><?php _e('Area','wpestate');?></label>
            <input type="text" id="developer_area" class="form-control" value="<?php echo esc_html($developer_area);?>"  name="developer_area">
        </p>
    </div>
    
    <div class="col-md-4">
        <p>
            <label for="developer_county"><?php _e('State/County','wpestate');?></label>
            <input type="text" id="developer_county" class="form-control" value="<?php echo esc_html($developer_county);?>"  name="developer_county">
        </p>  
    </div>
    
    
 

    <div class="col-md-8 col-md-push-4">
        
        <p>
            <label for="adress"><?php _e('Address','wpestate');?></label>
            <input type="text" id="developer_address" class="form-control" value="<?php echo $developer_address;?>"  name="website">
        </p>
        
        <p>
            <label for="usertitle"><?php _e('Location','wpestate');?></label>
            <div id="googleMapsubmit" ></div>   
            <input type="hidden" name="developer_lat" id="developer_lat"      value="<?php echo $developer_lat;?>">
            <input type="hidden" name="developer_long" id="developer_long"    value="<?php echo $developer_long;?>">
        </p>  
        
          <p class="fullp-button">
            <button id="google_developer_location"  class="wpresidence_button wpresidence_success"><?php _e('Place Pin with Developer Address','wpestate');?></button>
        </p>
        
        <p>
            <label for="about_me"><?php _e('About Us','wpestate');?></label>
            <textarea id="about_me" class="form-control" name="about_me"><?php echo ($developer_description);?></textarea>
        </p>
        <p class="fullp-button">
            <button class="wpresidence_button" id="update_profile_developer"><?php _e('Update profile', 'wpestate'); ?></button>
        
       
            <?php
            $user_agent_id          =   intval( get_user_meta($userID,'user_agent_id',true));
            if ( $user_agent_id!=0 && get_post_status($user_agent_id)=='publish'  ){
                print'<a href='.get_permalink($user_agent_id).' class="wpresidence_button view_public_profile">'.__('View public profile', 'wpestate').'</a>';
            }
            ?>
            <button class="wpresidence_button" id="delete_profile"><?php _e('Delete profile', 'wpestate'); ?></button>
            
        </p>
    </div>
    
            
</div>
      
<?php   get_template_part('templates/change_pass_template'); ?>
</div>