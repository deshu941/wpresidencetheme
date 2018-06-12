<<<<<<< HEAD
=======
<?php
$current_user               =   wp_get_current_user();
$user_custom_picture        =   get_the_author_meta( 'small_custom_picture' , $current_user->ID  );
$user_small_picture_id      =   get_the_author_meta( 'small_custom_picture' , $current_user->ID  );
if( $user_small_picture_id == '' ){

    $user_small_picture[0]=get_template_directory_uri().'/img/default_user_small.png';
}else{
    $user_small_picture=wp_get_attachment_image_src($user_small_picture_id,'user_thumb');
    
}
?>

>>>>>>> 64662fd89bea560852792d7203888072d7452d48
<div class="mobilewrapper">
    <div class="snap-drawers">
        <!-- Left Sidebar-->
        <div class="snap-drawer snap-drawer-left">
            <div class="mobilemenu-close"><i class="fa fa-times"></i></div>
            <?php  
<<<<<<< HEAD
   
                wp_nav_menu( array( 
                    'theme_location'  => 'mobile',               
                    'container'       =>  false,
                    'menu_class'      => 'mobilex-menu',
                    'menu_id'    => 'menu-main-menu'
                ) );
=======
            
                $transient_name='wpestate_mobile_menu';
                if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
                    $transient_name.='_'. ICL_LANGUAGE_CODE;
                }

                
                $mobile_menu = get_transient($transient_name);
            
                if($mobile_menu===false){
                    ob_start();
                    wp_nav_menu( array( 
                        'theme_location'    =>  'mobile',               
                        'container'         =>  false,
                        'menu_class'        =>  'mobilex-menu',
                        'menu_id'           =>  'menu-main-menu'
                    ) );
                    $mobile_menu = ob_get_clean();
                    set_transient($transient_name,$mobile_menu,60*60*4);
                    
                }
                echo $mobile_menu;
               
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
     
            ?>
        </div>
    </div>
<<<<<<< HEAD
=======
</div>


<div class="mobilewrapper-user">
    <div class="snap-drawers">
        <!-- Left Sidebar-->
        <div class="snap-drawer snap-drawer-right">
            <div class="mobilemenu-close-user"><i class="fa fa-times"></i></div>
            <?php
            if ( 0 != $current_user->ID  && is_user_logged_in() ) {
                $username               =   $current_user->user_login ;
                $add_link               =   wpestate_get_template_link('user_dashboard_add.php');
                $dash_profile           =   wpestate_get_template_link('user_dashboard_profile.php');
                $dash_favorite          =   wpestate_get_template_link('user_dashboard_favorite.php');
                $dash_link              =   wpestate_get_template_link('user_dashboard.php');
                $dash_searches          =   wpestate_get_template_link('user_dashboard_searches.php');
                $logout_url             =   wp_logout_url();      
                $home_url               =   home_url();
                $dash_invoices          =   wpestate_get_template_link('user_dashboard_invoices.php');
                $activeaddagent         =   wpestate_get_template_link('user_dashboard_add_agent.php');
                $activeagentlist        =   wpestate_get_template_link('user_dashboard_agent_list.php');
                $dash_inbox             =   wpestate_get_template_link('user_dashboard_inbox.php');
                $user_role              =   get_user_meta( $current_user->ID, 'user_estate_role', true) ; 
                $no_unread              =   intval(get_user_meta($current_user->ID,'unread_mess',true));
                $user_agent_id          =   intval( get_user_meta($current_user->ID,'user_agent_id',true));
                ?> 
            
              
                <ul class="  mobile_user_menu mobilex-menu " role="menu" aria-labelledby="user_menu_trigger"> 
                    <?php if($home_url!=$dash_profile){?>
                              <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php print esc_url($dash_profile);?>"  class="active_profile"><i class="fa fa-cog"></i><?php _e('My Profile','wpestate');?></a></li>    
                    <?php   
                    }
                    ?>

                    <?php if($home_url!=$dash_link){
                        if($user_agent_id==0 || ( $user_agent_id!=0 && get_post_status($user_agent_id)!='pending' && get_post_status($user_agent_id)!='disabled') ){?>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php print esc_url($dash_link);?>"     class="active_dash"><i class="fa fa-map-marker"></i><?php _e('My Properties List','wpestate');?></a></li>
                    <?php   
                        }
                    }
                    ?>

                    <?php if($home_url!=$add_link){
                        if($user_agent_id==0 || ( $user_agent_id!=0 && get_post_status($user_agent_id)!='pending' && get_post_status($user_agent_id)!='disabled') ){?>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php print esc_url($add_link);?>"      class="active_add"><i class="fa fa-plus"></i><?php _e('Add New Property','wpestate');?></a></li>
                    <?php   
                        }
                    }
                    ?>
      
                    <?php if($user_role==3 || $user_role ==4){
                        if( $user_agent_id!=0 && get_post_status($user_agent_id)!='pending'){?>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php print esc_url($activeaddagent);?>"      class="active_add"><i class="fa fa-user-plus"></i><?php _e('Add New Agent','wpestate');?></a></li>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php print esc_url($activeagentlist);?>"      class="active_add"><i class="fa fa-user"></i><?php _e('Agent list','wpestate');?></a></li>
                    <?php
                        }                
                    }
                    ?>

                    <?php if($home_url!=$dash_favorite){?>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php print esc_url($dash_favorite);?>" class="active_fav"><i class="fa fa-heart"></i><?php _e('Favorites','wpestate');?></a></li>
                    <?php   
                    }
                    ?>

                    <?php if($home_url!=$dash_searches){?>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php print esc_url($dash_searches);?>" class="active_fav"><i class="fa fa-search"></i><?php _e('Saved Searches','wpestate');?></a></li>
                    <?php   
                    }
                    ?>
                    <?php if($home_url!=$dash_invoices){?>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php print esc_url($dash_invoices);?>" class="active_fav"><i class="fa fa-file-text-o"></i><?php _e('My Invoices','wpestate');?></a></li>
                    <?php   
                    }
                    ?>
                    <?php if($home_url!=$dash_inbox){?>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php print esc_url($dash_inbox);?>" class="active_fav"><i class="fa fa-envelope-o"></i><?php _e('Inbox','wpestate');?></a>
                            <?php 
                            if  ($no_unread>0){
                                echo '<div class="unread_mess">'.$no_unread.'</div>';
                            }
                        ?>  
                        </li>
                    <?php   
                    }
                    ?> 
                        
                    <li role="presentation"><a href="<?php echo wp_logout_url( home_url());?>" title="Logout" class="menulogout"><i class="fa fa-power-off"></i><?php _e('Log Out','wpestate');?></a></li>
                </ul>
    
                <?php
                }else{
              
                    $front_end_register     =   esc_html( get_option('wp_estate_front_end_register','') );
                    $front_end_login        =   esc_html( get_option('wp_estate_front_end_login ','') );
                    $facebook_status    =   esc_html( get_option('wp_estate_facebook_login','') );
                    $google_status      =   esc_html( get_option('wp_estate_google_login','') );
                    $yahoo_status       =   esc_html( get_option('wp_estate_yahoo_login','') );
                    $mess='';
                    $security_nonce=wp_nonce_field( 'forgot_ajax_nonce-mobile', 'security-forgot-mobile',true,false );
                    ?>

                
                        <div class="login_sidebar">
                            <h3  id="login-div-title-mobile"><?php _e('Login','wpestate');?></h3>
                            <div class="login_form" id="login-div_mobile">
                                <div class="loginalert" id="login_message_area_mobile" > </div>

                                <input type="text" class="form-control" name="log" id="login_user_mobile" placeholder="<?php _e('Username','wpestate');?>"/>
                                <input type="password" class="form-control" name="pwd" id="login_pwd_mobile" placeholder="<?php _e('Password','wpestate');?>"/>
                                <input type="hidden" name="loginpop" id="loginpop_wd_mobile" value="0">
                                <?php //wp_nonce_field( 'login_ajax_nonce_mobile', 'security-login-mobile',true);?>   
                                <input type="hidden" id="security-login-mobile" name="security-login-mobile" value="<?php  echo estate_create_onetime_nonce( 'login_ajax_nonce_mobile' );?>">
     
                                <button class="wpresidence_button" id="wp-login-but-mobile"><?php _e('Login','wpestate');?></button>
                                <div class="login-links">
                                    <a href="#" id="widget_register_mobile"><?php _e('Need an account? Register here!','wpestate');?></a>
                                    <a href="#" id="forgot_pass_mobile"><?php _e('Forgot Password?','wpestate');?></a>
                                    <?php 
                                    if($facebook_status=='yes'){ 
                                    print '<div id="facebookloginsidebar_mobile" data-social="facebook">'.__('Login with Facebook','wpestate').'</div>';
                                    }
                                    if($google_status=='yes'){
                                        print '<div id="googleloginsidebar_mobile" data-social="google">'.__('Login with Google','wpestate').'</div>';
                                    }
                                    if($yahoo_status=='yes'){
                                        print '<div id="yahoologinsidebar_mobile" data-social="yahoo">'.__('Login with Yahoo','wpestate').'</div>';
                                    } 
                                    ?>
                                </div>    
                           </div>

                            <h3   id="register-div-title-mobile"><?php _e('Register','wpestate');?></h3>
                            <div class="login_form" id="register-div-mobile">

                                <div class="loginalert" id="register_message_area_mobile" ></div>
                                <input type="text" name="user_login_register" id="user_login_register_mobile" class="form-control" placeholder="<?php _e('Username','wpestate');?>"/>
                                <input type="text" name="user_email_register" id="user_email_register_mobile" class="form-control" placeholder="<?php _e('Email','wpestate');?>"  />

                                <?php
                                $enable_user_pass_status= esc_html ( get_option('wp_estate_enable_user_pass','') );
                                if($enable_user_pass_status == 'yes'){
                                    print ' <input type="password" name="user_password" id="user_password_mobile" class="form-control" placeholder="'.__('Password','wpestate').'"/>
                                    <input type="password" name="user_password_retype" id="user_password_mobile_retype" class="form-control" placeholder="'.__('Retype Password','wpestate').'"  />
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
                                        print '<select id="new_user_type_mobile" name="new_user_type_mobile" class="form-control" >';
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
                                

                                <input type="checkbox" name="terms" id="user_terms_register_mobile" />
                                <label id="user_terms_register_mobile_label" for="user_terms_register_mobile"><?php _e('I agree with ','wpestate');?><a href="<?php print wpestate_get_template_link('terms_conditions.php');?> " target="_blank" id="user_terms_register_mobile_link"><?php _e('terms & conditions','wpestate');?></a> </label>
                                
                                <?php
                                if(get_option('wp_estate_use_captcha','')=='yes'){
                                    print '<div id="mobile_register_menu"  style="float:left;transform:scale(0.75);-webkit-transform:scale(0.75);transform-origin:0 0;-webkit-transform-origin:0 0;"></div>';
                                }
                                ?>
                                
                                <?php   if($enable_user_pass_status != 'yes'){  ?>
                                    <p id="reg_passmail_mobile"><?php _e('A password will be e-mailed to you','wpestate');?></p>
                                <?php } ?>

                                <?php //wp_nonce_field( 'register_ajax_nonce_mobile', 'security-register-mobile',true );?>   
                                <input type="hidden" id="security-register-mobile" name="security-register-mobile" value="<?php  echo estate_create_onetime_nonce( 'register_ajax_nonce_mobile' );?>">
      
                                <button class="wpresidence_button" id="wp-submit-register_mobile" ><?php _e('Register','wpestate');?></button>
                                <div class="login-links">
                                    <a href="#" id="widget_login_mobile"><?php _e('Back to Login','wpestate');?></a>                       
                                </div>   
                            </div>

                            <h3  id="forgot-div-title-mobile"><?php _e('Reset Password','wpestate');?></h3>
                            <div class="login_form" id="forgot-pass-div">
                                <div class="loginalert" id="forgot_pass_area_mobile"></div>
                                <div class="loginrow">
                                        <input type="text" class="form-control" name="forgot_email" id="forgot_email_mobile" placeholder="<?php _e('Enter Your Email Address','wpestate');?>" size="20" />
                                </div>
                                <?php echo ($security_nonce);?>  
                                <input type="hidden" id="postid" value="'.$post_id.'">    
                                <button class="wpresidence_button" id="wp-forgot-but-mobile" name="forgot" ><?php _e('Reset Password','wpestate');?></button>
                                <div class="login-links shortlog">
                                <a href="#" id="return_login_mobile"><?php _e('Return to Login','wpestate');?></a>
                                </div>
                            </div>


                        </div>
                   
                    <?php }?>
            
            
        </div>
    </div>
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
</div>