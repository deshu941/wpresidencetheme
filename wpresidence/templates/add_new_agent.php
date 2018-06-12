<?php
$current_user = wp_get_current_user();
$userID                 =   $current_user->ID;
$user_login             =   $current_user->user_login;
$agent_id               =   get_the_author_meta('user_agent_id',$userID);
$user_custom_picture    =   get_template_directory_uri().'/img/default_user.png';
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
        <?php print '<img id="profile-image" src="'.$user_custom_picture.'" alt="user image" data-profileurl="'.$user_custom_picture.'" data-smallprofileurl="" >';

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
        <div class="user_details_row"><?php _e('User Details','wpestate');?></div> 
        <div class="user_profile_explain"><?php _e('Add your contact information.','wpestate')?></div>

    </div>
          
    <div class="col-md-4">
        <p>
            <label for="firstname"><?php _e('First Name','wpestate');?></label>
            <input type="text" id="firstname" class="form-control" value="<?php echo esc_html($first_name);?>"  name="firstname">
        </p>

        <p>
            <label for="secondname"><?php _e('Last Name','wpestate');?></label>
            <input type="text" id="secondname" class="form-control" value="<?php echo esc_html($last_name);?>"  name="firstname">
        </p>
        <p>
            <label for="useremail"><?php _e('Email','wpestate');?></label>
            <input type="text" id="useremail"  class="form-control" value="<?php echo esc_html($user_email);?>"  name="useremail">
        </p>
    </div>  

    <div class="col-md-4">
        <p>
            <label for="userphone"><?php _e('Phone', 'wpestate'); ?></label>
            <input type="text" id="userphone" class="form-control" value="<?php echo esc_html($user_phone); ?>"  name="userphone">
        </p>
        <p>
            <label for="usermobile"><?php _e('Mobile', 'wpestate'); ?></label>
            <input type="text" id="usermobile" class="form-control" value="<?php echo esc_html($user_mobile); ?>"  name="usermobile">
        </p>

        <p>
            <label for="userskype"><?php _e('Skype', 'wpestate'); ?></label>
            <input type="text" id="userskype" class="form-control" value="<?php echo esc_html($user_skype); ?>"  name="userskype">
        </p>
        <?php   wp_nonce_field( 'profile_ajax_nonce', 'security-profile' );   ?>
       
    </div>
</div>
                             
<div class="add-estate profile-page profile-onprofile row">       
    <div class="col-md-4 profile_label">
        <div class="user_details_row"><?php _e('User Details','wpestate');?></div> 
        <div class="user_profile_explain"><?php _e('Add your social media information.','wpestate')?></div>

    </div>
    <div class="col-md-4">
        <p>
            <label for="userfacebook"><?php _e('Facebook Url', 'wpestate'); ?></label>
            <input type="text" id="userfacebook" class="form-control" value="<?php echo esc_html($facebook); ?>"  name="userfacebook">
        </p>

        <p>
            <label for="usertwitter"><?php _e('Twitter Url', 'wpestate'); ?></label>
            <input type="text" id="usertwitter" class="form-control" value="<?php echo esc_html($twitter); ?>"  name="usertwitter">
        </p>

        <p>
            <label for="userlinkedin"><?php _e('Linkedin Url', 'wpestate'); ?></label>
            <input type="text" id="userlinkedin" class="form-control"  value="<?php echo esc_html($linkedin); ?>"  name="userlinkedin">
        </p>
    </div>
    <div class="col-md-4">
        <p>
            <label for="userinstagram"><?php _e('Instagram Url','wpestate');?></label>
            <input type="text" id="userinstagram" class="form-control" value="<?php echo esc_html($userinstagram);?>"  name="userinstagram">
        </p> 

        <p>
            <label for="userpinterest"><?php _e('Pinterest Url','wpestate');?></label>
            <input type="text" id="userpinterest" class="form-control" value="<?php echo esc_html($pinterest);?>"  name="userpinterest">
        </p> 

        <p>
            <label for="website"><?php _e('Website Url (without http)','wpestate');?></label>
            <input type="text" id="website" class="form-control" value="<?php echo esc_html($website);?>"  name="website">
        </p>
    </div> 
</div>

    
        
<div class="add-estate profile-page profile-onprofile row">
    <div class="col-md-4 profile_label">
        <div class="user_details_row"><?php _e('Agent Area/Categories','wpestate');?></div> 
        <div class="user_profile_explain"><?php _e('What kind of listings do you handle?','wpestate')?></div>
    </div>
    
    <div class="col-md-4 ">
        <p>
            <label for="agent_city"><?php _e('Category','wpestate');?></label>
       
        
        <?php 
            $agent_category_selected='';
            $agent_category_array            =   get_the_terms($agent_id, 'property_category_agent');
            if(isset($agent_category_array[0])){
                $agent_category_selected   =   $agent_category_array[0]->term_id;
            }
            $args=array(
                'class'       => 'select-submit2',
                'hide_empty'  => false,
                'selected'    => $agent_category_selected,
                'name'        => 'agent_category_submit',
                'id'          => 'agent_category_submit',
                'orderby'     => 'NAME',
                'order'       => 'ASC',
                'show_option_none'   => __('None','wpestate'),
                'taxonomy'    => 'property_category_agent',
                'hierarchical'=> true
            );
            wp_dropdown_categories( $args ); ?>
            
        </p>
    </div>
    
    <div class="col-md-4 ">
          <p>
            <label for="agent_city"><?php _e('Action Category','wpestate');?></label>
           <?php
           $agent_action_selected='';
            $agent_action_array            =   get_the_terms($agent_id, 'property_action_category_agent');
            if(isset($agent_action_array[0])){
                $agent_action_selected   =   $agent_action_array[0]->term_id;
            }
            
            $args=array(
                'class'       => 'select-submit2',
                'hide_empty'  => false,
                'selected'    => $agent_action_selected,
                'name'        => 'agent_action_submit',
                'id'          => 'agent_action_submit',
                'orderby'     => 'NAME',
                'order'       => 'ASC',
                'show_option_none'   => __('None','wpestate'),
                'taxonomy'    => 'property_action_category_agent',
                'hierarchical'=> true
            );
            wp_dropdown_categories( $args ); ?>
           
        </p>
    </div>
    
</div>



<div class="add-estate profile-page profile-onprofile row">
    <div class="col-md-4 profile_label">
        <div class="user_details_row"><?php _e('Agent Custom Data','wpestate');?></div> 
        <div class="user_profile_explain"><?php _e('Any custom parameters for agent','wpestate')?></div>
    </div>

	<div class="col-md-12">
		<input type="button" class="wpresidence_button" value="<?php _e('Add Custom Field','wpestate');?>" />
	</div>
	
    <div class="col-md-4 ">
        <p>
            <label for="user_custom_param"><?php _e('User Param 1','wpestate');?></label>
            <input type="text" id="agent_custom_data" class="form-control" value="<?php echo esc_html($agent_custom_data);?>"  name="agent_custom_data">
        </p>
    </div>
    
    
    
</div>


        
<div class="add-estate profile-page profile-onprofile row">
    <div class="col-md-4 profile_label">
        <div class="user_details_row"><?php _e('Location','wpestate');?></div> 
        <div class="user_profile_explain"><?php _e('In what area are your properties','wpestate')?></div>
    </div>
    
    <div class="col-md-4">
        <p>
            <label for="agent_city"><?php _e('City','wpestate');?></label>
            <input type="text" id="agent_city" class="form-control" value="<?php echo esc_html($agent_city);?>"  name="agent_city">
        </p>
        <p>
            <label for="agent_area"><?php _e('Area','wpestate');?></label>
            <input type="text" id="agent_area" class="form-control" value="<?php echo esc_html($agent_area);?>"  name="agent_area">
        </p>
    </div>
    
    <div class="col-md-4">
        <p>
            <label for="agent_county"><?php _e('State/County','wpestate');?></label>
            <input type="text" id="agent_county" class="form-control" value="<?php echo esc_html($agent_county);?>"  name="agent_county">
        </p>  
    </div>
</div>
    
<div class="add-estate profile-page profile-onprofile row">
    <div class="col-md-4 profile_label">
        <div class="user_details_row"><?php _e('User Details','wpestate');?></div> 
        <div class="user_profile_explain"><?php _e('Add some information about yourself.','wpestate')?></div>
    </div>
    <div class="col-md-8">
         <p>
            <label for="usertitle"><?php _e('Title/Position','wpestate');?></label>
            <input type="text" id="usertitle" class="form-control" value="<?php echo esc_html($user_title);?>"  name="usertitle">
        </p>

         <p>
            <label for="about_me"><?php _e('About Me','wpestate');?></label>
            <textarea id="about_me" class="form-control" name="about_me"><?php echo ($about_me);?></textarea>
        </p>
        <p class="fullp-button">
            <button class="wpresidence_button" id="update_profile"><?php _e('Update profile', 'wpestate'); ?></button>
            <button class="wpresidence_button" id="delete_profile"><?php _e('Delete profile', 'wpestate'); ?></button>
        </p>
    </div>
    
            
</div>
      
<?php   get_template_part('templates/change_pass_template'); ?>
</div>