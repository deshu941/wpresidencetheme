<?php
$front_end_register     =   esc_html( get_option('wp_estate_front_end_register','') );
$front_end_login        =   esc_html( get_option('wp_estate_front_end_login ','') );
$facebook_status    =   esc_html( get_option('wp_estate_facebook_login','') );
$google_status      =   esc_html( get_option('wp_estate_google_login','') );
$yahoo_status       =   esc_html( get_option('wp_estate_yahoo_login','') );
$mess='';
$security_nonce=wp_nonce_field( 'forgot_ajax_nonce-topbar', 'security-forgot-topbar',true,false );

?>

<div id="modal_login_wrapper">

    <div class="modal_login_back"></div>
    <div class="modal_login_container">
        
        
        
        
        <div id="login-modal_close"><i class="fa fa-times" aria-hidden="true"></i></div>
        
  
        
            <h3   id="login-div-title-topbar"><?php _e('Sign into your account','wpestate');?></h3>
            
            <div class="login_form" id="login-div_topbar">
                <div class="loginalert" id="login_message_area_topbar" > </div>

                <input type="text" class="form-control" name="log" id="login_user_topbar" placeholder="<?php _e('Username','wpestate');?>"/>
                <input type="password" class="form-control" name="pwd" id="login_pwd_topbar" placeholder="<?php _e('Password','wpestate');?>"/>
                <input type="hidden" name="loginpop" id="loginpop_wd_topbar" value="0">
                <?php //wp_nonce_field( 'login_ajax_nonce_topbar', 'security-login-topbar',true);?>   
                <input type="hidden" id="security-login-topbar" name="security-login-topbar" value="<?php  echo estate_create_onetime_nonce( 'login_ajax_nonce_topbar' );?>">

                <button class="wpresidence_button" id="wp-login-but-topbar"><?php _e('Login','wpestate');?></button>
                <div class="login-links">
                   
                    <?php 
                    if( $facebook_status=='yes' || $google_status=='yes' || $yahoo_status=='yes' ){ 
                        echo '<div class="or_social">'.__('or','wpestate').'</div>';
                    }
                    
                    if($facebook_status=='yes'){ 
                    print '<div id="facebookloginsidebar_topbar" data-social="facebook">'.__('Login with Facebook','wpestate').'</div>';
                    }
                    if($google_status=='yes'){
                        print '<div id="googleloginsidebar_topbar" data-social="google">'.__('Login with Google','wpestate').'</div>';
                    }
                    if($yahoo_status=='yes'){
                        print '<div id="yahoologinsidebar_topbar" data-social="yahoo">'.__('Login with Yahoo','wpestate').'</div>';
                    } 
                    ?>
                </div>    
           </div>

            <h3  id="register-div-title-topbar"><?php _e('Create an account','wpestate');?></h3>
            <div class="login_form" id="register-div-topbar">

                <div class="loginalert" id="register_message_area_topbar" ></div>
                <input type="text" name="user_login_register" id="user_login_register_topbar" class="form-control" placeholder="<?php _e('Username','wpestate');?>"/>
                <input type="text" name="user_email_register" id="user_email_register_topbar" class="form-control" placeholder="<?php _e('Email','wpestate');?>"  />

                <?php
                $enable_user_pass_status= esc_html ( get_option('wp_estate_enable_user_pass','') );
                if($enable_user_pass_status == 'yes'){
                    print ' <input type="password" name="user_password" id="user_password_topbar" class="form-control" placeholder="'.__('Password','wpestate').'"/>
                    <input type="password" name="user_password_retype" id="user_password_topbar_retype" class="form-control" placeholder="'.__('Retype Password','wpestate').'"  />
                    ';
                }
                ?>
                
                <?php
                if(1==1){
                    $user_types = array(
                        __('Select User Type','wpestate'),
                        __('User','wpestate'),
                        __('Single Agent','wpestate'),
                        __('Agency','wpestate'),
                        __('Developer','wpestate'),
                    );
                    
                    $permited_roles             = get_option('wp_estate_visible_user_role',true);
                    $visible_user_role_dropdown = get_option('wp_estate_visible_user_role_dropdown',true);
                
                    
                    if($visible_user_role_dropdown=='yes'){
                        print '<select id="new_user_type_topbar" name="new_user_type_topbar" class="form-control" >';
                        print '<option value="0">'.__('Select User Type','wpestate').'</option>';
                        foreach($user_types as $key=>$name){
                            if(in_array($name, $permited_roles)){
                                print '<option value="'.$key.'">'.$name.'</option>';
                            }
                        }
                        print '</select>';
                    }
                }
                
                ?>
                
                
                <input type="checkbox" name="terms" id="user_terms_register_topbar" />
                <label id="user_terms_register_topbar_label" for="user_terms_register_topbar"><?php _e('I agree with ','wpestate');?><a href="<?php print wpestate_get_template_link('terms_conditions.php');?> " target="_blank" id="user_terms_register_topbar_link"><?php _e('terms & conditions','wpestate');?></a> </label>


                <?php
                if(get_option('wp_estate_use_captcha','')=='yes'){
                    print '<div id="top_register_menu" style="float:left;transform:scale(0.75);-webkit-transform:scale(0.75);transform-origin:0 0;-webkit-transform-origin:0 0;"></div>';
                }
                ?>

                <?php   if($enable_user_pass_status != 'yes'){  ?>
                    <p id="reg_passmail_topbar"><?php _e('A password will be e-mailed to you','wpestate');?></p>
                <?php } ?>

                <?php //wp_nonce_field( 'register_ajax_nonce_topbar', 'security-register-topbar',true );?>   
                <input type="hidden" id="security-register-topbar" name="security-register-topbar" value="<?php  echo estate_create_onetime_nonce( 'register_ajax_nonce_topbar' );?>">
                <button class="wpresidence_button" id="wp-submit-register_topbar" ><?php _e('Register','wpestate');?></button>
              
            </div>

            <h3   id="forgot-div-title-topbar"><?php _e('Reset Password','wpestate');?></h3>
            <div class="login_form" id="forgot-pass-div">
                <div class="loginalert" id="forgot_pass_area_topbar"></div>
                <div class="loginrow">
                        <input type="text" class="form-control" name="forgot_email" id="forgot_email_topbar" placeholder="<?php _e('Enter Your Email Address','wpestate');?>" size="20" />
                </div>
                <?php echo ($security_nonce);?>  
                <input type="hidden" id="postid" value="'.$post_id.'">    
                <button class="wpresidence_button" id="wp-forgot-but-topbar" name="forgot" ><?php _e('Reset Password','wpestate');?></button>
               
            </div>


   
            <div class="login_modal_control">
                <a href="#" id="widget_register_topbar"><?php _e('Register here!','wpestate');?></a>
                <a href="#" id="forgot_pass_topbar"><?php _e('Forgot Password?','wpestate');?></a>
                
                <a href="#" id="widget_login_topbar"><?php _e('Back to Login','wpestate');?></a>  
                <a href="#" id="return_login_topbar"><?php _e('Return to Login','wpestate');?></a>
                 <input type="hidden" name="loginpop" id="loginpop" value="0">
            </div>
            
    </div>
    
</div>