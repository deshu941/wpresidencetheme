<?php
class Login_widget extends WP_Widget {
<<<<<<< HEAD
	
	function Login_widget(){
		$widget_ops = array('classname' => 'loginwd_sidebar', 'description' => 'Put the login & register form on sidebar');
		$control_ops = array('id_base' => 'login_widget');
		$this->WP_Widget('login_widget', 'Wp Estate: Login & Register', $widget_ops, $control_ops);
=======
	function __construct(){
	//function Login_widget(){
		$widget_ops = array('classname' => 'loginwd_sidebar boxed_widget', 'description' => 'Put the login & register form on sidebar');
		$control_ops = array('id_base' => 'login_widget');
		//$this->WP_Widget('login_widget', 'Wp Estate: Login & Register', $widget_ops, $control_ops);
                parent::__construct('login_widget', 'Wp Estate: Login & Register', $widget_ops, $control_ops);
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
	}
	
	function form($instance){
		$defaults = array();
		$instance = wp_parse_args((array) $instance, $defaults);
		$display='';
		print $display;
	}


	function update($new_instance, $old_instance){
		$instance = $old_instance;
		return $instance;
	}



	function widget($args, $instance){
		extract($args);
                $display='';
		global $post;
              
		print $before_widget;
                $facebook_status    =   esc_html( get_option('wp_estate_facebook_login','') );
                $google_status      =   esc_html( get_option('wp_estate_google_login','') );
                $yahoo_status       =   esc_html( get_option('wp_estate_yahoo_login','') );
		$mess='';
		$display.='
                <div class="login_sidebar">
                    <h3 class="widget-title-sidebar"  id="login-div-title">'.__('Login','wpestate').'</h3>
                    <div class="login_form" id="login-div">
                        <div class="loginalert" id="login_message_area_wd" >'.$mess.'</div>
                            
                        <input type="text" class="form-control" name="log" id="login_user_wd" placeholder="'.__('Username','wpestate').'"/>
                        <input type="password" class="form-control" name="pwd" id="login_pwd_wd" placeholder="'.__('Password','wpestate').'"/>                       
                        <input type="hidden" name="loginpop" id="loginpop_wd" value="0">
<<<<<<< HEAD
                        '. wp_nonce_field( 'login_ajax_nonce', 'security-login',false,false ).'   

                       
                        <button class="wpb_button  wpb_btn-info wpb_btn-large" id="wp-login-but-wd" >'.__('Login','wpestate').'</button>
=======
                      
                        <input type="hidden" id="security-login" name="security-login" value="'. estate_create_onetime_nonce( 'login_ajax_nonce' ).'">
       
                   
                        <button class="wpresidence_button" id="wp-login-but-wd" >'.__('Login','wpestate').'</button>
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
                        
                        <div class="login-links">
                            <a href="#" id="widget_register_sw">'.__('Need an account? Register here!','wpestate').'</a>
                            <a href="#" id="forgot_pass_widget">'.__('Forgot Password?','wpestate').'</a>';
                        if($facebook_status=='yes'){
<<<<<<< HEAD
                            $display.='<div id="facebookloginsidebar" data-social="facebook"></div>';
                        }
                        if($google_status=='yes'){
                            $display.='<div id="googleloginsidebar" data-social="google"></div>';
                        }
                        if($yahoo_status=='yes'){
                            $display.='<div id="yahoologinsidebar" data-social="yahoo"></div>';
=======
                            $display.='<div id="facebookloginsidebar" data-social="facebook">'.__('Login with Facebook','wpestate').'</div>';
                        }
                        if($google_status=='yes'){
                            $display.='<div id="googleloginsidebar" data-social="google">'.__('Login with Google','wpestate').'</div>';
                        }
                        if($yahoo_status=='yes'){
                            $display.='<div id="yahoologinsidebar" data-social="yahoo">'.__('Login with Yahoo','wpestate').'</div>';
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
                        }
                
                   
                    $display.='
                        </div>    
                    </div>
                
              <h3 class="widget-title-sidebar"  id="register-div-title">'.__('Register','wpestate').'</h3>
                <div class="login_form" id="register-div">
                    <div class="loginalert" id="register_message_area_wd" ></div>
                    <input type="text" name="user_login_register" id="user_login_register_wd" class="form-control" placeholder="'.__('Username','wpestate').'"/>
                    <input type="text" name="user_email_register" id="user_email_register_wd" class="form-control" placeholder="'.__('Email','wpestate').'"  />';
                    
                    $enable_user_pass_status= esc_html ( get_option('wp_estate_enable_user_pass','') );
                    if($enable_user_pass_status == 'yes'){
                        $display.= ' <input type="password" name="user_password_wd" id="user_password_wd" class="form-control" placeholder="'.__('Password','wpestate').'"/>
                        <input type="password" name="user_password_retype_wd" id="user_password_wd_retype" class="form-control" placeholder="'.__('Retype Password','wpestate').'"  />
                        ';
                    }
                    
<<<<<<< HEAD
                    $display.='
                    <input type="checkbox" name="terms" id="user_terms_register_wd"><label id="user_terms_register_wd_label" for="user_terms_register_wd">'.__('I agree with ','wpestate').'<a href="'.get_terms_links().'" target="_blank" id="user_terms_register_topbar_link">'.__('terms & conditions','wpestate').'</a> </label>';
=======
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
                            $display.= '<select id="new_user_type_wd" name="new_user_type_wd" class="form-control" >';
                            $display.= '<option value="0">'.__('Select User Type','wpestate').'</option>';
                            foreach($user_types as $key=>$name){
                                if(in_array($name, $permited_roles)){
                                    $display.= '<option value="'.$key.'">'.$name.'</option>';
                                }
                            }
                            $display.= '</select>';
                        }
                              
                        
                    }

                    $display.='<input type="checkbox" name="terms" id="user_terms_register_wd"><label id="user_terms_register_wd_label" for="user_terms_register_wd">'.__('I agree with ','wpestate').'<a href="'.wpestate_get_template_link('terms_conditions.php').'" target="_blank" id="user_terms_register_topbar_link">'.__('terms & conditions','wpestate').'</a> </label>';
                    
                    if(get_option('wp_estate_use_captcha','')=='yes'){
                        $display.= '<div id="widget_register_menu"  style="float:left;transform:scale(0.75);-webkit-transform:scale(0.75);transform-origin:0 0;-webkit-transform-origin:0 0;"></div>';
                    }
                                
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
                    
                    if($enable_user_pass_status != 'yes'){ 
                        $display.='<p id="reg_passmail">'.__('A password will be e-mailed to you','wpestate').'</p>';
                    }
                    
<<<<<<< HEAD
                    $display.= wp_nonce_field( 'register_ajax_nonce', 'security-register',false,false ).'   
                    <button class="wpb_button  wpb_btn-info wpb_btn-large" id="wp-submit-register_wd">'.__('Register','wpestate').'</button>
=======
                    //wp_nonce_field( 'register_ajax_nonce', 'security-register',false,false ).'
                    $display.= '  
                    <input type="hidden" id="security-register" name="security-register" value="'.estate_create_onetime_nonce( 'register_ajax_nonce' ).'">
           
                    <button class="wpresidence_button" id="wp-submit-register_wd">'.__('Register','wpestate').'</button>
>>>>>>> 64662fd89bea560852792d7203888072d7452d48

                    <div class="login-links">
                        <a href="#" id="widget_login_sw">'.__('Back to Login','wpestate').'</a>                       
                    </div>   
                 </div>
                </div>
                <h3 class="widget-title-sidebar"  id="forgot-div-title_shortcode">'. __('Reset Password','wpestate').'</h3>
                <div class="login_form" id="forgot-pass-div_shortcode">
                    <div class="loginalert" id="forgot_pass_area_shortcode"></div>
                    <div class="loginrow">
                            <input type="text" class="form-control" name="forgot_email" id="forgot_email_shortcode" placeholder="'.__('Enter Your Email Address','wpestate').'" size="20" />
                    </div>
                    '. wp_nonce_field( 'login_ajax_nonce_forgot_wd', 'security-login-forgot_wd',true).'  
                    <input type="hidden" id="postid" value="0">    
<<<<<<< HEAD
                    <button class="wpb_button  wpb_btn-info wpb_btn-large  vc_button" id="wp-forgot-but_shortcode" name="forgot" >'.__('Reset Password','wpestate').'</button>
=======
                    <button class="wpresidence_button" id="wp-forgot-but_shortcode" name="forgot" >'.__('Reset Password','wpestate').'</button>
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
                    <div class="login-links shortlog">
                    <a href="#" id="return_login_shortcode">'.__('Return to Login','wpestate').'</a>
                    </div>
                </div>
            ';
                
                
<<<<<<< HEAD
                global $current_user;  
                get_currentuserinfo();  
                $userID                 =   $current_user->ID;
                $user_login             =   $current_user->user_login;
                $user_email             =   get_the_author_meta( 'user_email' , $userID );
                
                $activeprofile= $activedash = $activeadd = $activefav ='';
                
                $add_link               =   get_dasboard_add_listing();
                $dash_profile           =   get_dashboard_profile_link(); 
                $dash_link              =   get_dashboard_link();
                $dash_favorite          =   get_dashboard_favorites();
                $dash_searches          =   get_searches_link();
                $home_url               =   home_url();
                $dash_invoices          =   wpestate_get_invoice_link();
=======
                $current_user = wp_get_current_user();
                $userID                 =   $current_user->ID;
                $user_login             =   $current_user->user_login;
                $user_email             =   get_the_author_meta( 'user_email' , $userID );
                $activeprofile          =   $activedash = $activeadd = $activefav ='';
                $activeaddagent         =   wpestate_get_template_link('user_dashboard_add_agent.php');
                $activeagentlist        =   wpestate_get_template_link('user_dashboard_agent_list.php');
                $user_role              =   get_user_meta( $current_user->ID, 'user_estate_role', true) ; 
                $add_link               =   wpestate_get_template_link('user_dashboard_add.php');
                $dash_profile           =   wpestate_get_template_link('user_dashboard_profile.php');
                $dash_link              =   wpestate_get_template_link('user_dashboard.php');
                $dash_favorite          =   wpestate_get_template_link('user_dashboard_favorite.php');
                $dash_searches          =   wpestate_get_template_link('user_dashboard_searches.php');
                $home_url               =   home_url();
                $dash_invoices          =   wpestate_get_template_link('user_dashboard_invoices.php');
                $dash_inbox             =   wpestate_get_template_link('user_dashboard_inbox.php');
                $no_unread              =   intval(get_user_meta($current_user->ID,'unread_mess',true));
                $no_unread_wd           =   '';
                if( $no_unread>0 ){
                    $no_unread_wd ='<div class="unread_mess">'.$no_unread.'</div>';
                }
                
                $user_agent_id          =   intval( get_user_meta($current_user->ID,'user_agent_id',true));
                
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
                $logged_display='
                    <h3 class="widget-title-sidebar" >'.__('Hello ','wpestate'). ' '. $user_login .'  </h3>
                    
                    <ul class="wd_user_menu">';
                    if($home_url!=$dash_profile){
<<<<<<< HEAD
                        $logged_display.='<li> <a href="'.$dash_profile.'"  class="'.$activeprofile.'"><i class="fa fa-cogs"></i>  '.__('My Profile','wpestate').'</a> </li>';
                    }
                    if($home_url!=$dash_link){
                        $logged_display.=' <li> <a href="'.$dash_link.'"     class="'.$activedash.'"><i class="fa fa-map-marker"></i>'.__('My Properties List','wpestate').'</a> </li>';
                    }
                    if($home_url!=$add_link){
                        $logged_display.=' <li> <a href="'.$add_link.'"      class="'.$activeadd.'"><i class="fa fa-plus"></i>'. __('Add New Property','wpestate').'</a> </li>';
                    }
=======
                        $logged_display.='<li> <a href="'.$dash_profile.'"  class="'.$activeprofile.'"><i class="fa fa-cogs"></i>'.__('My Profile','wpestate').'</a> </li>';
                    }
                    
                    if($home_url!=$dash_link){
                        if($user_agent_id==0 || ( $user_agent_id!=0 && get_post_status($user_agent_id)!='pending' && get_post_status($user_agent_id)!='disabled') ){
                            $logged_display.=' <li> <a href="'.$dash_link.'"     class="'.$activedash.'"><i class="fa fa-map-marker"></i>'.__('My Properties List','wpestate').'</a> </li>';
                        }
                    }
                    if($home_url!=$add_link){
                        if($user_agent_id==0 || ( $user_agent_id!=0 && get_post_status($user_agent_id)!='pending' && get_post_status($user_agent_id)!='disabled') ){
                            $logged_display.=' <li> <a href="'.$add_link.'"      class="'.$activeadd.'"><i class="fa fa-plus"></i>'. __('Add New Property','wpestate').'</a> </li>';
                        }      
                    }
                    
                    if($user_role==3 || $user_role ==4){
                        if( $user_agent_id!=0 && get_post_status($user_agent_id)!='pending'){
                            $logged_display.=' <li> <a href="'.$activeaddagent.'"      class="'.$activeadd.'"><i class="fa fa-user-plus"></i>'. __('Add New Agent','wpestate').'</a> </li>';
                            $logged_display.=' <li> <a href="'.$activeagentlist.'"      class="'.$activeadd.'"><i class="fa fa-user"></i>'. __('Agent list','wpestate').'</a> </li>';
                        }
                        
                    }

>>>>>>> 64662fd89bea560852792d7203888072d7452d48
                    if($home_url!=$dash_favorite){
                        $logged_display.=' <li> <a href="'.$dash_favorite.'" class="'.$activefav.'"><i class="fa fa-heart"></i>'.__('Favorites','wpestate').'</a> </li>';
                    }
                    if($home_url!=$dash_searches){
                        $logged_display.=' <li> <a href="'.$dash_searches.'" class="'.$activefav.'"><i class="fa fa-search"></i>'.__('Saved Searches','wpestate').'</a> </li>';
                    } 
                    if($home_url!=$dash_invoices){
                        $logged_display.=' <li> <a href="'.$dash_invoices.'" class="'.$activefav.'"><i class="fa fa-file-text-o"></i>'.__('My Invoices','wpestate').'</a> </li>';
                    }
<<<<<<< HEAD
                       
                        $logged_display.=' <li> <a href="'.wp_logout_url().'" title="Logout"><i class="fa fa-power-off"></i>'.__('Log Out','wpestate').'</a> </li>   
=======
                    if($home_url!=$dash_inbox){
                        $logged_display.=' <li> <a href="'.$dash_inbox.'" class="'.$activefav.'"><i class="fa fa-envelope-o"></i>'.__('Inbox','wpestate').'</a>'.$no_unread_wd.'</li>';  
                    }
                       
                        $logged_display.=' <li> <a href="'.wp_logout_url( home_url()).'" title="Logout"><i class="fa fa-power-off"></i>'.__('Log Out','wpestate').'</a> </li>   
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
                    </ul>
                ';
                
               if ( is_user_logged_in() ) {                   
                  print $logged_display;
               }else{
                  print $display; 
               }
               print $after_widget;
	}

}

?>