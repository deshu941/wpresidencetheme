<?php



////////////////////////////////////////////////////////////////////////////////////////////
///  shortcode - recent post with picture
////////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_slider_recent_posts_pictures') ):

function wpestate_slider_recent_posts_pictures($attributes, $content = null) {
    global $options;
    global $align;
    global $align_class;
    global $post;
    global $currency;
    global $where_currency;
    global $is_shortcode;
    global $show_compare_only;
    global $row_number_col;
    global $curent_fav;
    global $current_user;
    
    $options            =   wpestate_page_details($post->ID);
    $return_string      =   '';
    $pictures           =   '';
    $button             =   '';
    $class              =   '';
    $category=$action=$city=$area='';
    $title              =   '';
    $currency           =   esc_html( get_option('wp_estate_currency_symbol', '') );
    $where_currency     =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
    $is_shortcode       =   1;
    $show_compare_only  =   'no';
    $row_number_col     =   '';
    $row_number         =   '';       
    $show_featured_only =   '';
    $autoscroll         =   '';
    

    get_currentuserinfo();
    $userID             =   $current_user->ID;
    $user_option        =   'favorites'.$userID;
    $curent_fav         =   get_option($user_option);


    if ( isset($attributes['title']) ){
        $title=$attributes['title'];
    }
    
    if ( isset($attributes['category_ids']) ){
        $category=$attributes['category_ids'];
    }
    
    
    if ( isset($attributes['category_ids']) ){
        $category=$attributes['category_ids'];
    }

    if ( isset($attributes['action_ids']) ){
        $action=$attributes['action_ids'];
    }

    if ( isset($attributes['city_ids']) ){
        $city=$attributes['city_ids'];
    }

    if ( isset($attributes['area_ids']) ){
        $area=$attributes['area_ids'];
    }
     
     if ( isset($attributes['show_featured_only']) ){
        $show_featured_only=$attributes['show_featured_only'];
    }
    if ( isset($attributes['autoscroll']) ){
        $autoscroll=intval ( $attributes['autoscroll'] );
    }    
    
    $post_number_total = $attributes['number'];
    if ( isset($attributes['rownumber']) ){
        $row_number        = $attributes['rownumber']; 
    }
   
    
    if( $row_number == 4 ){
        $row_number_col = 3; // col value is 3 
    }else if( $row_number==3 ){
        $row_number_col = 4; // col value is 4
    }else if ( $row_number==2 ) {
        $row_number_col =  6;// col value is 6
    }else if ($row_number==1) {
        $row_number_col =  12;// col value is 12
    }
    
    $align=''; 
    $align_class='';
    if(isset($attributes['align']) && $attributes['align']=='horizontal'){
        $align="col-md-12";
        $align_class='the_list_view';
        $row_number_col='12';
    }
    
    
    
    if ($attributes['type'] == 'properties') {
        $type = 'estate_property';
        
        $category_array =   '';
        $action_array   =   '';
        $city_array     =   '';
        $area_array     =   '';
        
        // build category array
        if($category!=''){
            $category_of_tax=array();
            $category_of_tax=  explode(',', $category);
            $category_array=array(     
                            'taxonomy'  => 'property_category',
                            'field'     => 'term_id',
                            'terms'     => $category_of_tax
                            );
        }
            
        
        // build action array
        if($action!=''){
            $action_of_tax=array();
            $action_of_tax=  explode(',', $action);
            $action_array=array(     
                            'taxonomy'  => 'property_action_category',
                            'field'     => 'term_id',
                            'terms'     => $action_of_tax
                            );
        }
        
        // build city array
        if($city!=''){
            $city_of_tax=array();
            $city_of_tax=  explode(',', $city);
            $city_array=array(     
                            'taxonomy'  => 'property_city',
                            'field'     => 'term_id',
                            'terms'     => $city_of_tax
                            );
        }
        
        // build city array
        if($area!=''){
            $area_of_tax=array();
            $area_of_tax=  explode(',', $area);
            $area_array=array(     
                            'taxonomy'  => 'property_area',
                            'field'     => 'term_id',
                            'terms'     => $area_of_tax
                            );
        }
        
        
           $meta_query=array();                
            if($show_featured_only=='yes'){
                $compare_array=array();
                $compare_array['key']        = 'prop_featured';
                $compare_array['value']      = 1;
                $compare_array['type']       = 'numeric';
                $compare_array['compare']    = '=';
                $meta_query[]                = $compare_array;
            }
        
            $args = array(
                'post_type'         => $type,
                'post_status'       => 'publish',
                'paged'             => 0,
                'posts_per_page'    => $post_number_total,
                'meta_key'          => 'prop_featured',
                'orderby'           => 'meta_value',
                'order'             => 'DESC',
                'meta_query'        => $meta_query,
                'tax_query'         => array( 
                                        $category_array,
                                        $action_array,
                                        $city_array,
                                        $area_array
                                    )
              
            );
        
       
          
    } else {
        $type = 'post';
        $args = array(
            'post_type'      => $type,
            'post_status'    => 'publish',
            'paged'          => 0,
            'posts_per_page' => $post_number_total,
            'cat'            => $category
        );
    }


    if ( isset($attributes['link']) && $attributes['link'] != '') {
        if ($attributes['type'] == 'properties') {
            $button .= '<div class="listinglink-wrapper">
               <a href="' . $attributes['link'] . '"> <span class="wpb_button  wpb_btn-info wpb_btn-large vc_button">'.__('more listings','wpestate').' </span></a> 
               </div>';
        } else {
            $button .= '<div class="listinglink-wrapper">
               <a href="' . $attributes['link'] . '"> <span class="wpb_button  wpb_btn-info wpb_btn-large vc_button">  '.__('more articles','wpestate').' </span></a> 
               </div>';
        }
    } else {
        $class = "nobutton";
    }


    
  

    if ($attributes['type'] == 'properties') {
        add_filter( 'posts_orderby', 'wpestate_my_order' ); 
        $recent_posts = new WP_Query($args);
        $count = 1;
        remove_filter( 'posts_orderby', 'wpestate_my_order' ); 
    }else{
        $recent_posts = new WP_Query($args);
        $count = 1;
    }
   
    $return_string .= '<div class="article_container slider_container bottom-'.$type.' '.$class.'" >';
    
    $return_string .= '<div class="slider_control_left"><i class="fa fa-angle-left"></i></div>
                       <div class="slider_control_right"><i class="fa fa-angle-right"></i></div>';
    
    if($title!=''){
         $return_string .= '<h2 class="shortcode_title title_slider">'.$title.'</h2>';
    }
    
    $is_autoscroll='';
   
        $is_autoscroll=' data-auto="'.$autoscroll.'" ';
  
    
    $return_string .= '<div class="shortcode_slider_wrapper" '.$is_autoscroll.'><ul class="shortcode_slider_list">';
    
    
    ob_start();  
    while ($recent_posts->have_posts()): $recent_posts->the_post();
        print '<li>';
        if($type == 'estate_property'){
            get_template_part('templates/property_unit');
        } else {
            if(isset($attributes['align']) && $attributes['align']=='horizontal'){
                get_template_part('templates/blog_unit');
            }else{
                get_template_part('templates/blog_unit2');
            }
            
        }
        print '</li>';
    endwhile;

    $templates = ob_get_contents();
    ob_end_clean(); 
    $return_string .=$templates;
    $return_string .=$button;
    
    $return_string .= '</ul></div>';// end shrcode wrapper
    $return_string .= '</div>';
    wp_reset_query();
    $is_shortcode       =   0;
    
    /*if($autoscroll!='' && $autoscroll!=0){
        $autoscroll=$autoscroll*1000;
        $return_string .= '<script type="text/javascript">
                //<![CDATA[
                    setInterval(function(){
                        var element;
                        element= jQuery(".slider_control_right");
                        slider_control_right_function(element);
                        }, '.$autoscroll.'
                    );
                //]]>
            </script>';
    }*/
    
    return $return_string;
    
    
}
endif; // end   wpestate_recent_posts_pictures 













////////////////////////////////////////////////////////////////////////////////////
/// wpestate_icon_container_function
////////////////////////////////////////////////////////////////////////////////////

if ( !function_exists("wpestate_icon_container_function") ):    
function wpestate_icon_container_function($attributes, $content = null) {
    $return_string  =   '';
    $link           =   '';
    $title          =   ''; 
    $image          =   ''; 
    $content_box    =   '';
    $haseffect      =   '';
    
   
    if(isset($attributes['title'])){
        $title=$attributes['title'] ;
    }
    if(isset($attributes['image'])){
        $image=$attributes['image'] ;
    }
    if(isset($attributes['content_box'])){
        $content_box=$attributes['content_box'] ;
    }
    
    if(isset($attributes['link'])){
        $link=$attributes['link'] ;
    }
    
    if(isset($attributes['image_effect'])){
        $haseffect=$attributes['image_effect'] ;
    }
    
    $return_string .= '<div class="iconcol">';
    if($image!=''){
        $return_string .= '<div class="icon_img">';
                        
            if($haseffect=='yes'){
                 $return_string .=  ' <div class="listing-cover"> </div>
                 <a href="'.$link.'"> <span class="listing-cover-plus">+</span> </a>';
            }
            $return_string .= ' <img src="' .$image . '"  class="img-responsive" alt="thumb"/ >
            </div>'; 
    }
   
    $return_string .= '<h3><a href="' . $link . '">' . $title . '</a></h3>';
    $return_string .= '<p>' . do_shortcode($content_box) . '</p>';
    $return_string .= '</div>';

    return $return_string;
}
endif;

////////////////////////////////////////////////////////////////////////////////////
/// spacer
////////////////////////////////////////////////////////////////////////////////////

if ( !function_exists("wpestate_spacer_shortcode_function") ):    
function wpestate_spacer_shortcode_function($attributes, $content = null) {
    $height =   '';
    $type   =   1;
    
    if(isset($attributes['type'])){
        $type=$attributes['type'] ;
    }
    
    if(isset($attributes['height'])){
        $height=$attributes['height'] ;
    }
    
    $return_string='';
    $return_string.= '<div class="spacer" style="height:' .$height. 'px;">';
    if($type==2){
         $return_string.='<span class="spacer_line"></span>';
    }
    $return_string.= '</div>';
    return $return_string;
}
endif;



///////////////////////////////////////////////////////////////////////////////////////////
// font awesome function
///////////////////////////////////////////////////////////////////////////////////////////
if ( !function_exists("wpestate_font_awesome_function") ): 
function wpestate_font_awesome_function($attributes, $content = null){
        $icon = $attributes['icon'];
        $size = $attributes['size'];
        $return_string ='<i class="'.$icon.'" style="'.$size.'"></i>';
        return $return_string;
}
endif;


///////////////////////////////////////////////////////////////////////////////////////////
// advanced search function
///////////////////////////////////////////////////////////////////////////////////////////
if ( !function_exists("wpestate_advanced_search_function") ): 
function wpestate_advanced_search_function($attributes, $content = null){
        $return_string          =   '';
        $random_id              =   '';
        $custom_advanced_search =   get_option('wp_estate_custom_advanced_search','');       
        $actions_select         =   '';
        $categ_select           =   '';
        $title                  =   '';
       
        if ( isset($attributes['title']) ){
            $title=$attributes['title'];    
        }
    
        $args = wpestate_get_select_arguments();
        $action_select_list =   wpestate_get_action_select_list($args);
        $categ_select_list  =   wpestate_get_category_select_list($args);
        $select_city_list   =   wpestate_get_city_select_list($args); 
        $select_area_list   =   wpestate_get_area_select_list($args);
        $select_county_state_list   =   wpestate_get_county_state_select_list($args);


        $adv_submit=get_adv_search_link();
     
        if($title!=''){
            
        }
        
        $return_string .= '<h2 class="shortcode_title_adv">'.$title.'</h2>';
        $return_string .= '<div class="advanced_search_shortcode" id="advanced_search_shortcode">
        <form role="search" method="get"   action="'.$adv_submit.'" >';
        if($custom_advanced_search=='yes'){
                $adv_search_what        =   get_option('wp_estate_adv_search_what','');
                $adv_search_label       =   get_option('wp_estate_adv_search_label','');
                $adv_search_how         =   get_option('wp_estate_adv_search_how','');
                $count=0;
                ob_start();
                foreach($adv_search_what as $key=>$search_field){
                    wpestate_show_search_field('shortcode',$search_field,$action_select_list,$categ_select_list,$select_city_list,$select_area_list,$key,$select_county_state_list);
                } // end foreach
                $templates = ob_get_contents();
                ob_end_clean(); 
                $return_string.=$templates;
        }else{
            $return_string .= wpestate_show_search_field_classic_form('shortcode',$action_select_list,$categ_select_list ,$select_city_list,$select_area_list);
        }
        $extended_search= get_option('wp_estate_show_adv_search_extended','');
        if($extended_search=='yes'){
            ob_start();
            show_extended_search('short');           
            $templates = ob_get_contents();
            ob_end_clean(); 
            $return_string=$return_string.$templates;
        }

          $return_string.='<button class="wpb_button  wpb_btn-info wpb_btn-large" id="advanced_submit_shorcode">'.__('Search','wpestate').'</button>              

    </form>   
</div>';

 return $return_string;
          
}

endif;




///////////////////////////////////////////////////////////////////////////////////////////
// list items by ids function
///////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_list_items_by_id_function') ):

function wpestate_list_items_by_id_function($attributes, $content = null) {
    global $post;
    global $align;
    global $show_compare_only;
    global $currency;
    global $where_currency;
    global $col_class;
    global $is_shortcode;
    global $row_number_col;
    
    $currency           =   esc_html( get_option('wp_estate_currency_symbol', '') );
    $where_currency     =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
    $show_compare_only  =   'no';
    $return_string      =   '';
    $pictures           =   '';
    $button             =   '';
    $class              =   '';
    $rows               =   1;
    $ids                =   '';
    $ids_array          =   array();
    $post_number        =   1;
    $title              =   '';
    $is_shortcode       =   1;
    $row_number         =   '';
    
    global $current_user;
    global $curent_fav;
    get_currentuserinfo();
    $userID             =   $current_user->ID;
    $user_option        =   'favorites'.$userID;
    $curent_fav         =   get_option($user_option);
    
    if ( isset($attributes['ids']) ){
        $ids=$attributes['ids'];
        $ids_array=explode(',',$ids);
    }
    
    if ( isset($attributes['title']) ){
        $title=$attributes['title'];    
    }

    $post_number_total = $attributes['number'];

    
    if ( isset($attributes['rownumber']) ){
        $row_number        = $attributes['rownumber']; 
    }
    
    // max 4 per row
    if($row_number>4){
        $row_number=4;
    }
    
    if( $row_number == 4 ){
        $row_number_col = 3; // col value is 3 
    }else if( $row_number==3 ){
        $row_number_col = 4; // col value is 4
    }else if ( $row_number==2 ) {
        $row_number_col =  6;// col value is 6
    }else if ($row_number==1) {
        $row_number_col =  12;// col value is 12
    }
    
    
    $align=''; 
    if(isset($attributes['align']) && $attributes['align']=='horizontal'){
        $align="col-md-12";
    }
    
    
    
    if ($attributes['type'] == 'properties') {
       $type = 'estate_property';
    } else {
       $type = 'post';
    }

    if ($attributes['link'] != '') {
        if ($attributes['type'] == 'properties') {
            $button .= '<div class="listinglink-wrapper">
                           <a href="' . $attributes['link'] . '"> <span class="wpb_button  wpb_btn-info wpb_btn-large  vc_button">'.__(' more listings','wpestate').' </span></a>
                       </div>';
        } else {
            $button .= '<div class="listinglink-wrapper">
                           <a href="' . $attributes['link'] . '"> <span class="wpb_button  wpb_btn-info wpb_btn-large vc_button">'.__(' more articles','wpestate').'</span></a>
                        </div>';
        }
    } else {
        $class = "nobutton";
    }

    
 
    
   
   $args = array(
        'post_type'         => $type,
        'post_status'       => 'publish',
        'paged'             => 0,
        'posts_per_page'    => $post_number_total, 
        'post__in'          => $ids_array,
        'orderby '          => 'none'
    );
 
    $recent_posts = new WP_Query($args);
   

    $return_string .= '<div class="article_container">';
    if($title!=''){
        $return_string .= '<h2 class="shortcode_title">'.$title.'</h2>';
    }
     
    ob_start();  
    while ($recent_posts->have_posts()): $recent_posts->the_post();
        if($type == 'estate_property'){
            if(isset($attributes['align']) && $attributes['align']=='horizontal'){
               $col_class='col-md-12';
            }
            get_template_part('templates/property_unit');
           
        } else {
            if(isset($attributes['align']) && $attributes['align']=='horizontal'){
                get_template_part('templates/blog_unit');
            }else{
                get_template_part('templates/blog_unit2');
            }
            
        }
    endwhile;

    $templates = ob_get_contents();
    ob_end_clean(); 
    $return_string .=$templates;
    $return_string .=$button;
    $return_string .= '</div>';
    wp_reset_query();
    $is_shortcode       =   0;
    return $return_string;
}
endif; // end   wpestate_list_items_by_id_function 






///////////////////////////////////////////////////////////////////////////////////////////
// login form  function
///////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_login_form_function') ):
  
function wpestate_login_form_function($attributes, $content = null) {
     // get user dashboard link
        global $wpdb;
        $redirect='';
        $mess='';
        $allowed_html   =   array();
        
        
     
  
    $post_id=get_the_ID();
    $login_nonce=wp_nonce_field( 'login_ajax_nonce', 'security-login',true,false );
    $security_nonce=wp_nonce_field( 'forgot_ajax_nonce', 'security-forgot',true,false );
    $return_string='<div class="login_form shortcode-login" id="login-div">
         <div class="loginalert" id="login_message_area" >'.$mess.'</div>
        
                <div class="loginrow">
                    <input type="text" class="form-control" name="log" id="login_user" placeholder="'.__('Username','wpestate').'" size="20" />
                </div>
                <div class="loginrow">
                    <input type="password" class="form-control" name="pwd" id="login_pwd"  placeholder="'.__('Password','wpestate').'" size="20" />
                </div>
                <input type="hidden" name="loginpop" id="loginpop" value="0">
                '.$login_nonce .'   
                <button id="wp-login-but" class="wpb_button  wpb_btn-info wpb_btn-large vc_button">'.__('Login','wpestate').'</button>
                <div class="login-links shortlog">';
    
          
                if(isset($attributes['register_label']) && $attributes['register_label']!=''){
                     $return_string.='<a href="'.$attributes['register_url'].'">'.$attributes['register_label'].'</a> | ';
                }         
                $return_string.='<a href="#" id="forgot_pass">'.__('Forgot Password?','wpestate').'</a>
                </div>';
                $facebook_status    =   esc_html( get_option('wp_estate_facebook_login','') );
                $google_status      =   esc_html( get_option('wp_estate_google_login','') );
                $yahoo_status       =   esc_html( get_option('wp_estate_yahoo_login','') );
               
                
                if($facebook_status=='yes'){
                    $return_string.='<div id="facebooklogin" data-social="facebook"></div>';
                }
                if($google_status=='yes'){
                    $return_string.='<div id="googlelogin" data-social="google"></div>';
                }
                if($yahoo_status=='yes'){
                    $return_string.='<div id="yahoologin" data-social="yahoo"></div>';
                }
                   
         $return_string.='                 
         </div>
         <div class="login_form  shortcode-login" id="forgot-pass-div-sh">
            <div class="loginalert" id="forgot_pass_area"></div>
            <div class="loginrow">
                    <input type="text" class="form-control" name="forgot_email" id="forgot_email" placeholder="'.__('Enter Your Email Address','wpestate').'" size="20" />
            </div>
            '. $security_nonce.'  
            <input type="hidden" id="postid" value="'.$post_id.'">    
            <button class="wpb_button  wpb_btn-info wpb_btn-large  vc_button" id="wp-forgot-but" name="forgot" >'.__('Reset Password','wpestate').'</button>
            <div class="login-links shortlog">
            <a href="#" id="return_login">'.__('Return to Login','wpestate').'</a>
            </div>
         </div>
        
            ';
    return  $return_string;
}
endif; // end   wpestate_login_form_function 



///////////////////////////////////////////////////////////////////////////////////////////
// register form  function
///////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_register_form_function') ):

function wpestate_register_form_function($attributes, $content = null) {
 
     $register_nonce=wp_nonce_field( 'register_ajax_nonce', 'security-register',true,false );
     $return_string='
          <div class="login_form shortcode-login">
               <div class="loginalert" id="register_message_area" ></div>
               
                <div class="loginrow">
                    <input type="text" name="user_login_register" id="user_login_register" class="form-control" placeholder="'.__('Username','wpestate').'" size="20" />
                </div>
                <div class="loginrow">
                    <input type="text" name="user_email_register" id="user_email_register" class="form-control" placeholder="'.__('Email','wpestate').'" size="20" />
                </div>';
                
                $enable_user_pass_status= esc_html ( get_option('wp_estate_enable_user_pass','') );
                if($enable_user_pass_status == 'yes'){
                    $return_string.= '
                    <div class="loginrow">
                        <input type="password" name="user_password" id="user_password" class="form-control" placeholder="'.__('Password','wpestate').'"/>
                    </div>
                    <div class="loginrow">
                        <input type="password" name="user_password_retype" id="user_password_retype" class="form-control" placeholder="'.__('Retype Password','wpestate').'"  />
                    </div>
                    ';
                }


                $return_string.='        
                <input type="checkbox" name="terms" id="user_terms_register_sh">
                <label id="user_terms_register_sh_label" for="user_terms_register_sh">'.__('I agree with ','wpestate').'<a href="'.get_terms_links().'" target="_blank" id="user_terms_register_topbar_link">'.__('terms & conditions','wpestate').'</a> </label>';
                if($enable_user_pass_status != 'yes'){
                    $return_string.='<p id="reg_passmail">'.__('A password will be e-mailed to you','wpestate').'</p>';
                }
                
                $return_string.= $register_nonce .'   
                <p class="submit">
                    <button id="wp-submit-register"  class="wpb_button  wpb_btn-info wpb_btn-large vc_button">'.__('Register','wpestate').'</button>
                </p>
                
        </div>
                     
    ';
     return  $return_string;
}
endif; // end   wpestate_register_form_function   



///////////////////////////////////////////////////////////////////////////////////////////
/// featured article
///////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_featured_article') ):


function wpestate_featured_article($attributes, $content = null) {
    $return_string='';
    $article=0;
    $second_line='';
    
    if(isset($attributes['id'])){
        $article = intval($attributes['id']);
    }
    
    if( isset($attributes['second_line'] )){
        $second_line = $attributes['second_line']; 
    }
    
    $args = array(  'post_type' => 'post',
                    'p'         => $article
            );


    $my_query = new WP_Query($args);
    if ($my_query->have_posts()) {
        while ($my_query->have_posts()) {
            $my_query->the_post();
            $thumb_id   =   get_post_thumbnail_id($article);
            $preview    =   wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_featured');
            $previewh   =   wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_featured');
            $avatar     =   wpestate_get_avatar_url(get_avatar(get_the_author_meta('email'), 55));
            $content    =   get_the_excerpt();
            $title      =   get_the_title();
            $link       =   get_permalink();
// <div class="featured_article_content"> ' . $content . '</div>
         
            $return_string.= '
            <div class="featured_article">
                
                
                <div class="featured_img">
                    <a href="' . $link . '"> <img src="' . $preview[0] . '" data-original="'.$preview[0].'" alt="featured image" class="lazyload img-responsive" /></a>
                    <div class="listing-cover"></div>
                    <a href="'.$link.'"> <span class="listing-cover-plus">+</span></a>
                </div>
                
                <div class="featured_article_title" data-link="'.$link.'">
                    <div class="blog_author_image" style="background-image: url(' . $avatar . ');"></div>    
                    <h2 class="featured_type_2"> <a href="' . $link . '">'; 
                    $title=get_the_title();
                    $return_string .= substr( $title,0,35); 
                    if(strlen($title)>35){
                        $return_string .= '...';   
                    }

                    $return_string .= '</a></h2>
                    <div class="featured_article_secondline">' . $second_line . '</div>
                    <a href="' . $link . '"> <i class="fa fa-angle-right featured_article_right"></i> </a>
                    
                    <div class="featured_article_content">
                    '.$content.'
                    </div>
                </div>
                
             </div>';            
        }
    }

    wp_reset_query();
    return $return_string;
}
endif; // end   featured_article   


if( !function_exists('wpestate_get_avatar_url') ):

function wpestate_get_avatar_url($get_avatar) {
    preg_match("/src='(.*?)'/i", $get_avatar, $matches);
    return $matches[1];
}
endif; // end   wpestate_get_avatar_url   




////////////////////////////////////////////////////////////////////////////////////
/// featured property
////////////////////////////////////////////////////////////////////////////////////


if( !function_exists('wpestate_featured_property') ):
   
function wpestate_featured_property($attributes, $content = null) {
    $return_string='';
    $prop_id    =   '';
    if( isset($attributes['id'])){
        $prop_id=$attributes['id'];
    }
    
    $sale_line='';
    if ( isset($attributes['sale_line'])){
        $sale_line =  $attributes['sale_line'];
    }
    
    $args = array('post_type'   => 'estate_property',
                  'post_status' => 'publish',
                  'p'           => $prop_id
                );

   

    $my_query = new WP_Query($args);
    if ($my_query->have_posts()) {
        while ($my_query->have_posts()) {
            $my_query->the_post();
            $thumb_id       =   get_post_thumbnail_id($prop_id);
            $preview        =   wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_featured');
            $link           =   get_permalink();
            $price          =   floatval( get_post_meta($prop_id, 'property_price', true) );
            $price_label    =   '<span class="price_label">'.esc_html ( get_post_meta($prop_id, 'property_label', true) ).'</span>';
            $currency       =   esc_html( get_option('wp_estate_currency_symbol', '') );
            $where_currency =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
            $content        =   wpestate_strip_words( get_the_excerpt(),30).' ...';
            $gmap_lat       =   esc_html( get_post_meta($prop_id, 'property_latitude', true));
            $gmap_long      =   esc_html( get_post_meta($prop_id, 'property_longitude', true));
            $prop_stat      =   esc_html( get_post_meta($prop_id, 'property_status', true) );
            
            if (function_exists('icl_translate') ){
                $prop_stat     =   icl_translate('wpestate','wp_estate_property_status_sh_'.$prop_stat, $prop_stat ) ;                                      
            }
        
            $featured       =   intval  ( get_post_meta($prop_id, 'prop_featured', true) );
            $agent_id       =   intval  ( get_post_meta($prop_id, 'property_agent', true) );
            $thumb_id       =   get_post_thumbnail_id($agent_id);
            $agent_face     =   wp_get_attachment_image_src($thumb_id, 'agent_picture_thumb');
            $agent_posit    =   esc_html( get_post_meta($agent_id, 'agent_position', true) );
            $agent_permalink=   get_permalink($agent_id);
            $agent_phone    =   esc_html( get_post_meta($agent_id, 'agent_phone', true) );
            $agent_mobile   =   esc_html( get_post_meta($agent_id, 'agent_mobile', true) );
            $agent_email    =   esc_html( get_post_meta($agent_id, 'agent_email', true) );

            if ($price != 0) {
                $price = wpestate_show_price($prop_id,$currency,$where_currency,1);  
            }else{
                $price='';
            }

            $return_string.= '
                <div class="featured_property">
                        <div class="featured_img">
                        <a href="' . $link . '"> <img src="' . $preview[0] . '" data-original="' . $preview[0] . '" class="lazyload img-responsive" alt="featured image"/></a>
                        <div class="listing-cover featured_cover" data-link="'.$link.'"></div>
                        <a href="'.$link.'"> <span class="listing-cover-plus">+</span></a>
                        </div>';
                                
                        $return_string.='';

                        if ($prop_stat != 'normal') {
                            $ribbon_class = str_replace(' ', '-', $prop_stat);
                            $return_string .= '<a href="' . get_permalink() . '"><div class="ribbon-wrapper-default ribbon-wrapper-' . $ribbon_class . '"><div class="ribbon-inside ' . $ribbon_class . '">' . $prop_stat . '</div></div></a>';
                        }

                        $return_string.= ' <div class="featured_secondline" data-link="'.$link.'">';
                        if ($agent_id!=''){
                            $return_string.= '
                            <div class="agent_face">
                            
                                <img src="'.$agent_face[0].'" width="55" height="55" class="img-responsive" alt="agent_face">
                               

                                <div class="agent_face_details">
                                    <img src="'.$agent_face[0].'" width="120" height="120" class="img-responsive" alt="agent_face">
                                    <h4><a href="'.$agent_permalink.'" >'.get_the_title($agent_id).'</a></h4>   
                                    <div class="agent_position">'. $agent_posit .'</div> 
                                    <a class="wpb_button_a see_my_list" href="'.$agent_permalink.'" target="_blank">
                                        <span class="wpb_button  wpb_wpb_button wpb_regularsize wpb_mail  vc_button">'.__('My Listings','wpestate').'</span>
                                    </a>    
                                </div>
                            </div>';
                        }
                     
                        
                        if($featured==1){
                            $return_string .= '<div class="featured_div"></div>';
                        }
                        $return_string .= '<h2><a href="' . $link . '">';
                        
                        $title=get_the_title();
                        $return_string .= substr( $title,0,27); 
                        if(strlen($title)>27){
                            $return_string .= '...';   
                        }
                        
                        $return_string.='</a></h2>
                        <div class="sale_line">' . $sale_line . '</div>
                        <div class="featured_prop_price">'.$price.' </div>
                         
                       
                 </div>';
                    
                     $return_string .='
                </div>';
            
            
        }
    }

    wp_reset_query();
    return $return_string;
}
endif; // end   wpestate_featured_property



////////////////////////////////////////////////////////////////////////////////////
/// featured agent
////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_featured_agent') ):

function wpestate_featured_agent($attributes, $content = null) {
    global $notes;
    $return_string='';
    $notes  =   '';
    $agent_id   =   $attributes['id'];
    
      
    if ( isset($attributes['notes']) ){
        $notes=$attributes['notes'];    
    }
    
    $args = array(
        'post_type' => 'estate_agent',
        'p' => $agent_id
        );
 
    
    
  
    $my_query = new WP_Query($args);
            ob_start(); 
        while ($my_query->have_posts() ): $my_query->the_post();
             get_template_part('templates/agent_unit_featured'); 
        endwhile;
        $return_string = ob_get_contents();
        ob_end_clean();  
    wp_reset_query();
    return $return_string;
}

endif; // end   wpestate_featured_agent   










////////////////////////////////////////////////////////////////////////////////////////////
///  shortcode - recent post with picture
////////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_recent_posts_pictures') ):

function wpestate_recent_posts_pictures($attributes, $content = null) {
    global $options;
    global $align;
    global $align_class;
    global $post;
    global $currency;
    global $where_currency;
    global $is_shortcode;
    global $show_compare_only;
    global $row_number_col;
    
    global $current_user;
    global $curent_fav;
    get_currentuserinfo();
    $userID             =   $current_user->ID;
    $user_option        =   'favorites'.$userID;
    $curent_fav         =   get_option($user_option);

    
    $options            =   wpestate_page_details($post->ID);
    $return_string      =   '';
    $pictures           =   '';
    $button             =   '';
    $class              =   '';
    $category=$action=$city=$area='';
    $title              =   '';
    $currency           =   esc_html( get_option('wp_estate_currency_symbol', '') );
    $where_currency     =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
    $is_shortcode       =   1;
    $show_compare_only  =   'no';
    $row_number_col     =   '';
    $row_number         =   '';       
    $show_featured_only =   '';
    $random_pick        =   '';
    $orderby            =   'meta_value';
    
    if ( isset($attributes['title']) ){
        $title=$attributes['title'];
    }
    
    if ( isset($attributes['category_ids']) ){
        $category=$attributes['category_ids'];
    }
    
    
    if ( isset($attributes['category_ids']) ){
        $category=$attributes['category_ids'];
    }

    if ( isset($attributes['action_ids']) ){
        $action=$attributes['action_ids'];
    }

    if ( isset($attributes['city_ids']) ){
        $city=$attributes['city_ids'];
    }

    if ( isset($attributes['area_ids']) ){
        $area=$attributes['area_ids'];
    }
    
    if ( isset($attributes['show_featured_only']) ){
        $show_featured_only=$attributes['show_featured_only'];
    }

    if (isset($attributes['random_pick'])){
        $random_pick=   $attributes['random_pick'];
        if($random_pick==='yes'){
            $orderby    =   'rand';
        }
    }
    
    $post_number_total = $attributes['number'];
    if ( isset($attributes['rownumber']) ){
        $row_number        = $attributes['rownumber']; 
    }
    
    // max 4 per row
    if($row_number>4){
        $row_number=4;
    }
    
    if( $row_number == 4 ){
        $row_number_col = 3; // col value is 3 
    }else if( $row_number==3 ){
        $row_number_col = 4; // col value is 4
    }else if ( $row_number==2 ) {
        $row_number_col =  6;// col value is 6
    }else if ($row_number==1) {
        $row_number_col =  12;// col value is 12
        if($attributes['align']=='vertical'){
             $row_number_col =  0;
        }
    }
    
    $align=''; 
    $align_class='';
    if(isset($attributes['align']) && $attributes['align']=='horizontal'){
        $align="col-md-12";
        $align_class='the_list_view';
        $row_number_col='12';
    }
    
  
    if ($attributes['type'] == 'properties') {
        $type = 'estate_property';
        
        $category_array =   '';
        $action_array   =   '';
        $city_array     =   '';
        $area_array     =   '';
        
        // build category array
        if($category!=''){
            $category_of_tax=array();
            $category_of_tax=  explode(',', $category);
            $category_array=array(     
                            'taxonomy'  => 'property_category',
                            'field'     => 'term_id',
                            'terms'     => $category_of_tax
                            );
        }
            
        
        // build action array
        if($action!=''){
            $action_of_tax=array();
            $action_of_tax=  explode(',', $action);
            $action_array=array(     
                            'taxonomy'  => 'property_action_category',
                            'field'     => 'term_id',
                            'terms'     => $action_of_tax
                            );
        }
        
        // build city array
        if($city!=''){
            $city_of_tax=array();
            $city_of_tax=  explode(',', $city);
            $city_array=array(     
                            'taxonomy'  => 'property_city',
                            'field'     => 'term_id',
                            'terms'     => $city_of_tax
                            );
        }
        
        // build city array
        if($area!=''){
            $area_of_tax=array();
            $area_of_tax=  explode(',', $area);
            $area_array=array(     
                            'taxonomy'  => 'property_area',
                            'field'     => 'term_id',
                            'terms'     => $area_of_tax
                            );
        }
        
        
            $meta_query=array();                
            if($show_featured_only=='yes'){
                $compare_array=array();
                $compare_array['key']        = 'prop_featured';
                $compare_array['value']      = 1;
                $compare_array['type']       = 'numeric';
                $compare_array['compare']    = '=';
                $meta_query[]                = $compare_array;
            }

        
            $args = array(
                'post_type'         => $type,
                'post_status'       => 'publish',
                'paged'             => 0,
                'posts_per_page'    => $post_number_total,
                'meta_key'          => 'prop_featured',
                'orderby'           => $orderby,
                'order'             => 'DESC',
                'meta_query'        => $meta_query,
                'tax_query'         => array( 
                                        $category_array,
                                        $action_array,
                                        $city_array,
                                        $area_array
                                    )
              
            );
        

          
    } else {
        $type = 'post';
  
       
        
        $args = array(
            'post_type'      => $type,
            'post_status'    => 'publish',
            'paged'          => 0,
            'posts_per_page' => $post_number_total,
            'cat'            => $category
        );
    }


    if ( isset($attributes['link']) && $attributes['link'] != '') {
        if ($attributes['type'] == 'properties') {
            $button .= '<div class="listinglink-wrapper">
               <a href="' . $attributes['link'] . '"> <span class="wpb_button  wpb_btn-info wpb_btn-large vc_button">'.__('more listings','wpestate').' </span></a> 
               </div>';
        } else {
            $button .= '<div class="listinglink-wrapper">
               <a href="' . $attributes['link'] . '"> <span class="wpb_button  wpb_btn-info wpb_btn-large vc_button">  '.__('more articles','wpestate').' </span></a> 
               </div>';
        }
    } else {
        $class = "nobutton";
    }


    if ($attributes['type'] == 'properties') {
        if($random_pick !=='yes'){
            add_filter( 'posts_orderby', 'wpestate_my_order' ); 
            $recent_posts = new WP_Query($args);
            $count = 1;
            remove_filter( 'posts_orderby', 'wpestate_my_order' ); 
        }else{
            $recent_posts = new WP_Query($args); 
            $count = 1;
        }
   
    }else{
        $recent_posts = new WP_Query($args);
        $count = 1;
    }
   
    $return_string .= '<div class="article_container bottom-'.$type.' '.$class.'" >';
    if($title!=''){
         $return_string .= '<h2 class="shortcode_title">'.$title.'</h2>';
    }
  
    ob_start();  
    while ($recent_posts->have_posts()): $recent_posts->the_post();
        if($type == 'estate_property'){
            get_template_part('templates/property_unit');
        } else {
            if(isset($attributes['align']) && $attributes['align']=='horizontal'){
                get_template_part('templates/blog_unit');
            }else{
                get_template_part('templates/blog_unit2');
            }
            
        }
    endwhile;

    $templates = ob_get_contents();
    ob_end_clean(); 
    $return_string .=$templates;
    $return_string .=$button;
    $return_string .= '</div>';
    wp_reset_query();
    $is_shortcode       =   0;
    return $return_string;
    
    
}
endif; // end   wpestate_recent_posts_pictures 



if( !function_exists('wpestate_limit_words') ):

function wpestate_limit_words($string, $max_no) {
    $words_no = explode(' ', $string, ($max_no + 1));

    if (count($words_no) > $max_no) {
        array_pop($words_no);
    }

    return implode(' ', $words_no);
}
endif; // end   wpestate_limit_words  







////////////////////////////////////////////////////////////////////////////////////////////////////////////////..
///  shortcode - testimonials
////////////////////////////////////////////////////////////////////////////////////////////////////////////////..


if( !function_exists('wpestate_testimonial_function') ):
function wpestate_testimonial_function($attributes, $content = null) {
    $return_string='';
    $title_client='';
    $client_name='';
    $imagelinks='';
    $testimonial_text='';
    
    if ( $attributes['client_name'] ){
     $client_name   =   $attributes['client_name'];
    }
    
    if( $attributes['title_client'] ){
        $title_client   =   $attributes['title_client'] ;
    }
    
    if( $attributes['imagelinks'] ){
        $imagelinks   =   $attributes['imagelinks']  ;
    }
    
    if( $attributes['testimonial_text'] ){
        $testimonial_text   =   $attributes['testimonial_text']  ;
    }
    
    $return_string .= ' <div class="testimonial-container">';
    $return_string .= '     <div class="testimonial-image" style="background-image:url(' .$imagelinks . ')"></div>';
    $return_string .= '     <div class="testimonial-text">'.$testimonial_text.'</div>';    
    $return_string .= '     <div class="testimonial-author-line"><span class="testimonial-author">' . $client_name .'</span>, '.$title_client.' </div>';
    $return_string .= ' </div>';

    return $return_string;
}
endif; // end   wpestate_testimonial_function 



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  shortcode - reccent post function
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_recent_posts_function') ):


function wpestate_recent_posts_function($attributes, $heading = null) {
    $return_string='';
    extract(shortcode_atts(array(
        'posts' => 1,
                    ), $attributes));

    query_posts(array('orderby' => 'date', 'order' => 'DESC', 'showposts' => $posts));
    $return_string = '<div id="recent_posts"><ul><h3>' . $heading . '</h3>';
    if (have_posts()) :
        while (have_posts()) : the_post();
            $return_string .= '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
        endwhile;
    endif;

    $return_string.='</div></ul>';
    wp_reset_query();

    return $return_string;
}
endif; // end   wpestate_recent_posts_function   
?>