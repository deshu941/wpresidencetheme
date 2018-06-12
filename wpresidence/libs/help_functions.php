<?php
add_action( 'admin_post_wpestate_purge_cache', 'wpestate_purge_cache' );

function wpestate_purge_cache(){
    if ( isset( $_GET['action'], $_GET['_wpnonce'] ) ) {

            if ( ! wp_verify_nonce( $_GET['_wpnonce'], 'theme_purge_cache' ) ) {
                    wp_nonce_ays( '' );
            }
  
            wpestate_delete_cache();
            wp_redirect( wp_get_referer() );
            die();
	}
}





if( !function_exists('kriesi_pagination_ajax_directory') ):

function kriesi_pagination_ajax_directory($pages = '', $range = 2,$paged,$where,$order){  
    $showitems = ($range * 2)+1;  
    
    if(1 != $pages){
        echo '<ul class="pagination c '.$where.'">';
        if($paged!=1){
            $prev_page=$paged-1;
        }else{
            $prev_page=1;
        }
         
        $prev_link= get_pagenum_link($paged - 1);
        $prev_link = add_query_arg( 'order', $order,$prev_link );
        
        echo "<li class=\"roundleft\"><a href=\"#\" data-future='".$prev_page."'><i class=\"fa fa-angle-left\"></i></a></li>";
      
        for ($i=1; $i <= $pages; $i++){
            $page_link=get_pagenum_link($i); 
            $page_link = add_query_arg( 'order', $order,$page_link );
            if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )){
                if ($paged == $i){
                    print '<li class="active"><a href="#" data-future="'.$i.'">'.$i.'</a><li>';
                }else{
                    print '<li><a href="#" data-future="'.$i.'">'.$i.'</a><li>';
                }
            }
         }
         
        $next_page= get_pagenum_link($paged + 1);
        if ( ($paged +1) > $pages){
            $next_page= get_pagenum_link($paged );
            $next_page = add_query_arg( 'order', $order,$next_page );
            echo "<li class=\"roundright\"><a href='#' data-future='".$paged."'><i class=\"fa fa-angle-right\"></i></a><li>"; 
        }else{
            $next_page= get_pagenum_link($paged + 1);
            $next_page = add_query_arg( 'order', $order,$next_page );
            echo "<li class=\"roundright\"><a href='#' data-future='".($paged+1)."'><i class=\"fa fa-angle-right\"></i></a><li>"; 
        }
     
        echo "</ul>\n";
     }
}
endif; // end   kriesi_pagination  

if( !function_exists('wpestate_delete_cache') ):
function wpestate_delete_cache(){
    global $wpdb;
    $sql = "SELECT `option_name` AS `name`, `option_value` AS `value`
            FROM  $wpdb->options
            WHERE `option_name` LIKE '%transient_%'
            ORDER BY `option_name`";

    $results = $wpdb->get_results( $sql );
    $transients = array();

    foreach ( $results as $result ){
        if ( 0 === strpos( $result->name, '_transient_wpestate' ) ){
            $transient_name = str_replace('_transient_', '', $result->name);
            delete_transient($transient_name);
        }
    }
}
endif;

if( !function_exists('wpestate_delete_cache_for_links') ):
function wpestate_delete_cache_for_links(){
    global $wpdb;
    $sql = "SELECT `option_name` AS `name`, `option_value` AS `value`
            FROM  $wpdb->options
            WHERE `option_name` LIKE '%wpestate_get_template_link_%'
            ORDER BY `option_name`";

    $results = $wpdb->get_results( $sql );
    foreach ( $results as $result ){
      
        if ( 0 === strpos( $result->name, '_transient_wpestate_get_template_link_' ) ){
      
            $transient_name = str_replace('_transient_', '', $result->name);
            delete_transient($transient_name);
           
        }
    }
}
endif;


if(!function_exists('wpestate_convert_meta_to_postin')):
function wpestate_convert_meta_to_postin($meta_query){
    global $table_prefix;
   
    $searched=0;
   
    $feature_list_array =   array();
    $allowed_html       =   array();
    
    

    
    
    
    foreach($meta_query as  $checker =>$query ){
        if($value!=''){
            $searched       =   1;
        }
        
      
        $input_name     =   wpestate_limit45(sanitize_title( $query['key'] ));
        $input_name     =   sanitize_key($input_name);
        
        
       
        if( $query['compare'] == 'BETWEEN'){
            if(trim($input_name)!=''){
                $min=0;
                if($query['value'][0]!=0){
                  $min =  $query['value'][0];
                }
                $potential_ids[$checker]=array_unique(wpestate_get_ids_by_query("
                    SELECT DISTINCT post_id
                    FROM ".$table_prefix."postmeta
                    WHERE meta_key = '".$input_name."'
                    AND CAST(meta_value AS SIGNED) BETWEEN '".$min."' AND '".$query['value'][1]."' "));//a
             
            
            }
        }else if($query['compare'] == 'LIKE'){
            if(trim($input_name)!=''){
              
                $potential_ids[$checker]=array_unique(wpestate_get_ids_by_query("
                    SELECT DISTINCT post_id
                    FROM ".$table_prefix."postmeta
                    WHERE meta_key LIKE '".$input_name."'
                    AND meta_value = '". esc_sql($query['value'])."' ") );//a
                 
            }
        }
        
        
    }
    
    $ids=[];
  
    foreach($potential_ids as $key=>$temp_ids){
        if(count($ids)==0){
            $ids=$temp_ids;
        }else{
            $ids=array_intersect($ids,$temp_ids);
        }
    }
    
      
    if(empty($ids) && $searched==1 ){
        $ids[]=0;
    }
    return $ids;
    
    
}
endif;




////////////////////////////////// reviews
add_action( 'wp_ajax_wpestate_edit_review', 'wpestate_edit_review' );
if (!function_exists('wpestate_edit_review')):
    function wpestate_edit_review(){
        $current_user       =   wp_get_current_user();
        $userID             =   $current_user->ID;
        $allowed_html       =   array(); 
        
        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }
        $comment_ID     =   intval($_POST['coment']);
        $coment         =   get_comment( $comment_ID );
        echo $userID .'/ '.$coment->user_id;
        if($coment->user_id != $userID){
            exit('no');
        }
         
   
        $listing_id     =   intval($_POST['listing_id']);
        $stars          =   intval($_POST['stars']);
        $content        =   wp_kses($_POST['content'],$allowed_html);
        $title          =   wp_kses($_POST['title'],$allowed_html);   
   
       
      
        update_comment_meta( $comment_ID, 'review_title',$title  );
        update_comment_meta( $comment_ID, 'review_stars',$stars  );
        update_comment_meta( $comment_ID, 'comment_content',$content  );
       
        $commentarr = array();
        $commentarr['comment_ID'] = $comment_ID;
        $commentarr['comment_content' ]              = $content;
        $comment_approved=0;       
        if( get_option('wp_estate_admin_approves_reviews','')=='no' ){
            $comment_approved=1;
        }
        $commentarr['comment_approved'] = $comment_approved;
        wp_update_comment( $commentarr );
     
        die();
    }
endif;






add_action( 'wp_ajax_wpestate_post_review', 'wpestate_post_review' );
if (!function_exists('wpestate_post_review')):
    function wpestate_post_review(){
        $current_user       =   wp_get_current_user();
        $userID             =   $current_user->ID;
        $allowed_html       =   array(); 
        
        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }
       

        
        $userID         =   $current_user->ID;
        $user_login     =   $current_user->user_login;
        $user_email     =   $current_user->user_email;
        $listing_id     =   intval($_POST['listing_id']);
          
        $stars          =   intval($_POST['stars']);
        $content        =   wp_kses($_POST['content'],$allowed_html);
        $title          =   wp_kses($_POST['title'],$allowed_html);   
        $time           =   time();
        $time           =   current_time('mysql');
        
        $comment_approved=0;       
        if( get_option('wp_estate_admin_approves_reviews','')=='no' ){
            $comment_approved=1;
        }
            
            
        $data = array(
            'comment_post_ID'           => $listing_id,
            'comment_author'            => $user_login,
            'comment_author_email'      => $user_email,
            'comment_author_url'        => '',
            'comment_content'           => $content,
            'comment_type'              => 'comment',
            'comment_parent'            => 0,
            'user_id'                   => $userID,
            'comment_author_IP'         => '127.0.0.1',
            'comment_agent'             => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10 (.NET CLR 3.5.30729)',
            'comment_date'              => $time,
            'comment_approved'          => $comment_approved,
        );
        

       
        $comment_id =    wp_insert_comment($data);
        add_comment_meta( $comment_id, 'review_title',$title  );
        add_comment_meta( $comment_id, 'review_stars',$stars  );

        die();
    }
endif;




if(!function_exists('wpestate_splash_page_header')):
function wpestate_splash_page_header(){
    
    $spash_header_type  = get_option('wp_estate_spash_header_type','');
    
    if($spash_header_type=='image'){
        wpestate_header_image(''); 
    }else if($spash_header_type=='video'){
        wpestate_video_header();
    }else if($spash_header_type=='image slider'){
        wpestate_splash_slider();
    }
   
}
endif;


if(!function_exists('wpestate_splash_slider')):
function wpestate_splash_slider(){
    $splash_slider_gallery      =   esc_html( get_option('wp_estate_splash_slider_gallery','') );
    $splash_slider_transition   =   esc_html ( get_option('wp_estate_splash_slider_transition','') );
  
    $splash_slider_gallery_array= explode(',', $splash_slider_gallery);
   
    $slider='<div id="splash_slider_wrapper" class="carousel slide" data-ride="carousel" data-interval="'.$splash_slider_transition.'">';
    $i=0;
    if(is_array($splash_slider_gallery_array)){
        foreach ($splash_slider_gallery_array as $image_id) {
            $image_id=intval($image_id);
            if($image_id!='' && $image_id!=0){
                $i++;
                if($i==1){
                    $class_active =' active ';
                }else{
                     $class_active ='  ';
                }
                $preview            =   wp_get_attachment_image_src($image_id, 'full');
                $slider.= '<div class="item splash_slider_item'; 
                $slider.=$class_active.' "  style="background-image:url('.$preview[0].');" >
                  
                   
                </div>';
            }
        }
    }
    
    $slider.='</div>';
    
    $page_header_overlay_val            =   esc_html ( get_option('wp_estate_splash_overlay_opacity','') );
    $page_header_overlay_color          =   esc_html ( get_option('wp_estate_splash_overlay_color','') );
    $wp_estate_splash_overlay_image     =   esc_html ( get_option('wp_estate_splash_overlay_image','') );
    $page_header_title_over_image       =   stripslashes( esc_html ( get_option('wp_estate_splash_page_title','') ) );
    $page_header_subtitle_over_image    =   stripslashes( esc_html ( get_option('wp_estate_splash_page_subtitle','') ) );
            
            
    if($page_header_overlay_color!='' || $wp_estate_splash_overlay_image!=''){
        $slider.= '<div class="wpestate_header_image_overlay" style="background-color:#'.$page_header_overlay_color.';opacity:'.$page_header_overlay_val.';background-image:url('.$wp_estate_splash_overlay_image.');"></div>';
    }

    if($page_header_title_over_image!=''){
        $slider.= '<div class="heading_over_image_wrapper" >';
        $slider.= '<h1 class="heading_over_image">'.$page_header_title_over_image.'</h1>';

        if($page_header_subtitle_over_image!=''){
            $slider.= '<div class="subheading_over_image">'.$page_header_subtitle_over_image.'</div>';
        }

        $slider.= '</div>';
    }
            

        $slider .=  '<a class="left  carousel-control"  href="#splash_slider_wrapper"  data-slide="prev">
            <i class="demo-icon icon-left-open-big"></i>
        </a>

        <a class="right  carousel-control"  href="#splash_slider_wrapper" data-slide="next">
            <i class="demo-icon icon-right-open-big"></i>
        </a>';
                       
                        
    echo $slider;
}
endif;

if(!function_exists('wpestate_video_header')):
function wpestate_video_header(){
  
    global $post;
    $paralax_header = get_option('wp_estate_paralax_header','');
    if( isset($post->ID)){
        if( is_page_template( 'splash_page.php' ) ){
            $page_custom_video                  =   esc_html ( get_option('wp_estate_splash_video_mp4','') );
            $page_custom_video_webm             =   esc_html ( get_option('wp_estate_splash_video_webm','') );
            $page_custom_video_ogv              =   esc_html ( get_option('wp_estate_splash_video_ogv','') );
            $page_custom_video_cover_image      =   esc_html ( get_option('wp_estate_splash_video_cover_img','') );
            $img_full_screen                    =   'no';
            $page_header_title_over_video       =   stripslashes( esc_html ( get_option('wp_estate_splash_page_title','') ) );
            $page_header_subtitle_over_video    =   stripslashes( esc_html ( get_option('wp_estate_splash_page_subtitle','') ) );
            $page_header_video_height           =   '';
            $page_header_overlay_color_video    =   esc_html ( get_option('wp_estate_splash_overlay_color','') );
            $page_header_overlay_val_video      =   esc_html ( get_option('wp_estate_splash_overlay_opacity','') );
            $wp_estate_splash_overlay_image     =    esc_html ( get_option('wp_estate_splash_overlay_image','') );
        }else{
            $page_custom_video                  =   esc_html ( get_post_meta($post->ID, 'page_custom_video', true) );
            $page_custom_video_webm             =   esc_html ( get_post_meta($post->ID, 'page_custom_video_webbm', true) );
            $page_custom_video_ogv              =   esc_html ( get_post_meta($post->ID, 'page_custom_video_ogv', true) );
            $page_custom_video_cover_image      =   esc_html ( get_post_meta($post->ID, 'page_custom_video_cover_image', true) );
            $img_full_screen                    =   esc_html ( get_post_meta($post->ID, 'page_header_video_full_screen', true) );
            $page_header_title_over_video       =   stripslashes( esc_html ( get_post_meta($post->ID, 'page_header_title_over_video', true) ) ) ;
            $page_header_subtitle_over_video    =   stripslashes( esc_html ( get_post_meta($post->ID, 'page_header_subtitle_over_video', true) ) );
            $page_header_video_height           =   floatval ( get_post_meta($post->ID, 'page_header_video_height', true) );
            $page_header_overlay_color_video    =   esc_html ( get_post_meta($post->ID, 'page_header_overlay_color_video', true) );
            $page_header_overlay_val_video      =   esc_html ( get_post_meta($post->ID, 'page_header_overlay_val_video', true) );
            $wp_estate_splash_overlay_image     =   '';
        }
       
    
        if($page_header_overlay_val_video==''){
            $page_header_overlay_val_video=1;
        }
        if($page_header_video_height==0){
            $page_header_video_height=580;
        }
        
        
        print '<div class="wpestate_header_video full_screen_'.$img_full_screen.' parallax_effect_'.$paralax_header.'" style="'; 
        print ' height:'.$page_header_video_height.'px; ';
        print '">';

        
            print '<video id="hero-vid" class="header_video" poster="'.$page_custom_video_cover_image.'" width="100%" height="100%" autoplay ';
            if( wp_is_mobile() ){
                print ' controls ';
            }
            print' muted loop>
			<source src="'.$page_custom_video.'" type="video/mp4" />
			<source src="'.$page_custom_video_webm.'" type="video/webm" />
                        <source src="'.$page_custom_video_ogv.'" type="video/ogg"/>
    
		</video>';
        
            if($page_header_overlay_color_video!='' || $wp_estate_splash_overlay_image!=''){
                print '<div class="wpestate_header_video_overlay" style="background-color:#'.$page_header_overlay_color_video.';opacity:'.$page_header_overlay_val_video.';background-image:url('.$wp_estate_splash_overlay_image.');"></div>';
            }

            if($page_header_title_over_video!=''){
                print '<div class="heading_over_video_wrapper" >';
                print '<h1 class="heading_over_video">'.$page_header_title_over_video.'</h1>';
                 
                if($page_header_subtitle_over_video!=''){
                    print '<div class="subheading_over_video">'.$page_header_subtitle_over_video.'</div>';
                }
                
                print '</div>';
            }
            
           
        print'</div>';
        
    }
}
endif;










if(!function_exists('wpestate_header_image')):
function wpestate_header_image($image){
    global $post;
    $paralax_header = get_option('wp_estate_paralax_header','');
    if( isset($post->ID)){
        
        if( is_page_template( 'splash_page.php' ) ){
            $header_type=20;
            $image =esc_html( get_option('wp_estate_splash_image','') );
            $img_full_screen                    =  'no';
            $img_full_back_type                 =   '';
            $page_header_title_over_image       =   stripslashes( esc_html ( get_option('wp_estate_splash_page_title','') ) );
            $page_header_subtitle_over_image    =   stripslashes( esc_html ( get_option('wp_estate_splash_page_subtitle','') ) ) ;
            $page_header_image_height           =   600;
            $page_header_overlay_val            =   esc_html ( get_option('wp_estate_splash_overlay_opacity','') );
            $page_header_overlay_color          =   esc_html ( get_option('wp_estate_splash_overlay_color','') );
            $wp_estate_splash_overlay_image     =   esc_html ( get_option('wp_estate_splash_overlay_image','') );
            
        }else{
            $header_type                =   get_post_meta ( $post->ID, 'header_type', true);
            
            if($header_type == 0){ 
                $img_full_screen                    = esc_html ( get_option('wp_estate_global_header','') );
                $img_full_back_type                 = ''; 
                $page_header_title_over_image       = ''; 
                $page_header_subtitle_over_image    = ''; 
                $page_header_image_height           = ''; 
                $page_header_overlay_val            = ''; 
                $page_header_overlay_color          = ''; 
                $wp_estate_splash_overlay_image     = '';
            }else{
                $img_full_screen                    = esc_html ( get_post_meta($post->ID, 'page_header_image_full_screen', true) );
                $img_full_back_type                 = esc_html ( get_post_meta($post->ID, 'page_header_image_back_type', true) );  
                $page_header_title_over_image       = stripslashes( esc_html ( get_post_meta($post->ID, 'page_header_title_over_image', true) ) );
                $page_header_subtitle_over_image    = stripslashes( esc_html ( get_post_meta($post->ID, 'page_header_subtitle_over_image', true) ) );
                $page_header_image_height           = floatval ( get_post_meta($post->ID, 'page_header_image_height', true) );
                $page_header_overlay_val            = esc_html ( get_post_meta($post->ID, 'page_header_overlay_val', true) );
                $page_header_overlay_color          = esc_html ( get_post_meta($post->ID, 'page_header_overlay_color', true) );
                $wp_estate_splash_overlay_image     =   '';
            }
        }


   
        
        if($page_header_overlay_val==''){
            $page_header_overlay_val=1;
        }
        if($page_header_image_height==0){
            $page_header_image_height=580;
        }
        
        print '<div class="wpestate_header_image full_screen_'.$img_full_screen.' parallax_effect_'.$paralax_header.'" style="background-image:url('.$image.');'; 
            if($page_header_image_height!=0){
                print ' height:'.$page_header_image_height.'px; ';
            }
            if($img_full_back_type=='contain'){
                print '  background-size: contain; ';
            }
        print '">';

            if($page_header_overlay_color!='' || $wp_estate_splash_overlay_image!=''){
                print '<div class="wpestate_header_image_overlay" style="background-color:#'.$page_header_overlay_color.';opacity:'.$page_header_overlay_val.';background-image:url('.$wp_estate_splash_overlay_image.');"></div>';
            }

            if($page_header_title_over_image!=''){
                print '<div class="heading_over_image_wrapper" >';
                print '<h1 class="heading_over_image">'.$page_header_title_over_image.'</h1>';
                 
                if($page_header_subtitle_over_image!=''){
                    print '<div class="subheading_over_image">'.$page_header_subtitle_over_image.'</div>';
                }
                
                print '</div>';
            }
            
           
        print'</div>';
        
        
        
    }else{
        
        print '<div class="wpestate_header_image " style="background-image:url('.$image.')"></div>';
    }
    
    
    
}
endif;

if(!function_exists('wpestate_show_advanced_search')):
function wpestate_show_advanced_search($post_id){
  
    if( !wpestate_float_search_placement($post_id) && !wpestate_half_map_conditions ($post_id)   ){
        if( !wpestate_is_user_dashboard()  ){
          
            get_template_part( 'templates/advanced_search' );           
        }
           
    }   

}

endif;


if(!function_exists('wpestate_float_search_placement')):
function wpestate_float_search_placement($post_id){
    global $post;
    $float_form_top_local   =   '';
    $float_search_form      =   esc_html ( get_option('wp_estate_use_float_search_form','') );
    $search_float_type      =   0;
  
    
    if ( isset($post->ID)){  
        $search_float_type          =   intval (get_post_meta ( $post->ID, 'use_float_search_form_local_set', true));
    }
    
    if( wpestate_half_map_conditions($post_id) ){
        return false;
    }
    
    if( $search_float_type==0 && $float_search_form=='yes'){
        return true;
    }else if($search_float_type==2){
        return true;
    }else{
        return false;
    }
    
    
    
}

endif;





if(!function_exists('wpestate_show_poi_onmap')):
function wpestate_show_poi_onmap($where=''){
    global $post;
    if( !is_singular('estate_property') ){
        return;
    }
    $points=array(
        'transport'         =>  __('Transport','wpestate'),
        'supermarkets'      =>  __('Supermarkets','wpestate'),
        'schools'           =>  __('Schools','wpestate'),
        'restaurant'        =>  __('Restaurants','wpestate'),
        'pharma'            =>  __('Pharmacies','wpestate'),
        'hospitals'         =>  __('Hospitals','wpestate'),
    );
    
    $return_value = '<div class="google_map_poi_marker">';
        foreach($points as $key=>$value){
            $return_value .= '<div class="google_poi'.$where.'" id="'.$key.'"><img src="'.get_template_directory_uri().'/css/css-images/poi/'.$key.'_icon.png" class="dashboad-tooltip"  data-placement="right"  data-original-title="'.$value.'" ></div>';
        }
    $return_value .= '</div>';
    return $return_value;
}
endif;




if(!function_exists('wpestate_price_pin_converter')):
    function wpestate_price_pin_converter($pin_price,$where_currency,$currency){
    
        $custom_fields  = get_option( 'wp_estate_multi_curr', true);
        if( !empty($custom_fields) && isset($_COOKIE['my_custom_curr']) &&  isset($_COOKIE['my_custom_curr_pos']) &&  isset($_COOKIE['my_custom_curr_symbol']) && $_COOKIE['my_custom_curr_pos']!=-1){
            $i=intval($_COOKIE['my_custom_curr_pos']);
            $custom_fields = get_option( 'wp_estate_multi_curr', true);
            if ($pin_price != 0) {

                $pin_price      = $pin_price * $custom_fields[$i][2];


               // $price      = number_format($price,2,'.',$th_separator);

                $currency       =   $custom_fields[$i][0];
                $where_currency =   $custom_fields[$i][3];
              
            }else{
                $pin_price='';
            }
        }
    
        $pin_price=floatval($pin_price);
        if(  10000 < $pin_price && $pin_price < 1000000 ){
            $pin_price  =   round( $pin_price / 1000 ,1);
            $pin_price  =   $pin_price.''.__('K','wpestate');
            
        }
        if ( $pin_price >= 1000000 ){
            $pin_price  =  round ( $pin_price / 1000000,1 );
            $pin_price  =   $pin_price.''.__('M','wpestate');
           
        }
        
        
        
        
        if($where_currency=='before'){
            $pin_price=$currency.' '.$pin_price;
        }else{
            $pin_price=$pin_price.' '.$currency;
        }
        return $pin_price;
    }
endif;

if(!function_exists('wpestate_add_allowed_tags')):
function wpestate_add_allowed_tags($tags) {

    $allowed_html_desc=array(
        'a' => array(
            'href' => array(),
            'title' => array()
        ),
        'br'        =>  array(),
        'em'        =>  array(),
        'strong'    =>  array(),
        'ul'        =>  array('li'),
        'li'        =>  array(),
        'code'      =>  array(),
        'ol'        =>  array('li'),
        'del'       =>  array(
                        'datetime'=>array()
                        ),
        'blockquote'=> array(),
        'ins'       =>  array(),


    );
    return   $allowed_html_desc;
}
endif;



if(!function_exists('wpestate_strip_array') ):
function wpestate_strip_array($key){
    
    $string =htmlspecialchars(stripslashes( ($key) ), ENT_QUOTES);
          
    return   htmlspecialchars_decode($string);
}
endif;


if(!function_exists('wpestate_return_all_fields') ):
function wpestate_return_all_fields($is_mandatory=0){
    
    $submission_page_fields     =   ( get_option('wp_estate_submission_page_fields','') );
   
   
    
    $all_submission_fields=$all_mandatory_fields=array(
        'wpestate_description'          =>  __('Description','wpestate'),
        'property_price'                =>  __('Property Price','wpestate'),
        'property_label'                =>  __('Property Price Label','wpestate'),
        'property_label_before'         =>  __('Property Price Label Before','wpestate'),
        'prop_category'                 =>  __('Property Category Submit','wpestate'),
        'prop_action_category'          =>  __('Property Action Category','wpestate'),
        'attachid'                      =>  __('Property Media','wpestate'),
        'property_address'              =>  __('Property Address','wpestate'),
        'property_city'                 =>  __('Property City','wpestate'),
        'property_area'                 =>  __('Property Area','wpestate'),
        'property_zip'                  =>  __('Property Zip','wpestate'),
        'property_county'               =>  __('Property County','wpestate'),
        'property_country'              =>  __('Property Country','wpestate'),
        'property_map'                  =>  __('Property Map','wpestate'),
        'property_latitude'             =>  __('Property Latitude','wpestate'),
        'property_longitude'            =>  __('Property Longitude','wpestate'),
        'google_camera_angle'           =>  __('Google Camera Angle','wpestate'),
        'property_google_view'          =>  __('Property Google View','wpestate'),    
        'property_size'                 =>  __('property Size','wpestate'),
        'property_lot_size'             =>  __('Property Lot Size','wpestate'),
        'property_rooms'                =>  __('Property Rooms','wpestate'),
        'property_bedrooms'             =>  __('Property Bedrooms','wpestate'),
        'property_bathrooms'            =>  __('Property Bathrooms','wpestate'),
        'owner_notes'                   =>  __('Owner Notes','wpestate'),
        'property_status'               =>  __('property status','wpestate'),
        'embed_video_id'                =>  __('Embed Video Id','wpestate'),
        'embed_video_type'              =>  __('Embed Video Type','wpestate'),
        'embed_virtual_tour'            =>  __('Embed Virtual Tour','wpestate'),
        'property_subunits_list'        =>  __('Property Subunits','wpestate'),
	'energy_class'                  =>  __('Energy Class','wpestate'),
        'energy_index'                  =>  __('Energy Index','wpestate'),
    );
    
    $i=0;
    $custom_fields = get_option( 'wp_estate_custom_fields', true);

    if( !empty($custom_fields)){  
        while($i< count($custom_fields) ){
            $name               =   stripslashes($custom_fields[$i][0]);
            $slug               =   str_replace(' ','_',$name);
            if($is_mandatory==1){
                $slug           =   str_replace(' ','-',$name);
                unset($all_submission_fields['property_map']);
            }          
            $label              =  stripslashes( $custom_fields[$i][1] );
           
            $slug = htmlspecialchars ( $slug ,ENT_QUOTES);
            
            $all_submission_fields[$slug]=$label;
            $i++;
       }
    }

    $feature_list       =   esc_html( get_option('wp_estate_feature_list') );
    $feature_list_array =   explode( ',',$feature_list);
       
    foreach ($feature_list_array as $key=>$checker) {
        $checker            =   stripslashes($checker);
        $post_var_name      =  ( str_replace(' ','_', trim($checker)) );
        $all_submission_fields[$post_var_name]=trim($checker);     
    }
    return $all_submission_fields;
}
endif;




if( !function_exists('wpestate_yelp_details') ):
function wpestate_yelp_details($post_id) {
    
  
    $yelp_terms_array = 
            array (
                'active'            =>  array( 'category' => __('Active Life','wpestate'),
                                                'category_sign' => 'fa fa-bicycle'),
                'arts'              =>  array( 'category' => __('Arts & Entertainment','wpestate'), 
                                               'category_sign' => 'fa fa-music') ,
                'auto'              =>  array( 'category' => __('Automotive','wpestate'), 
                                                'category_sign' => 'fa fa-car' ),
                'beautysvc'         =>  array( 'category' => __('Beauty & Spas','wpestate'), 
                                                'category_sign' => 'fa fa-female' ),
                'education'         => array(  'category' => __('Education','wpestate'),
                                                'category_sign' => 'fa fa-graduation-cap' ),
                'eventservices'     => array(  'category' => __('Event Planning & Services','wpestate'), 
                                                'category_sign' => 'fa fa-birthday-cake' ),
                'financialservices' => array(  'category' => __('Financial Services','wpestate'), 
                                                'category_sign' => 'fa fa-money' ),                
                'food'              => array(  'category' => __('Food','wpestate'), 
                                                'category_sign' => 'fa fa fa-cutlery' ),
                'health'            => array(  'category' => __('Health & Medical','wpestate'), 
                                                'category_sign' => 'fa fa-medkit' ),
                'homeservices'      => array(  'category' =>__('Home Services ','wpestate'), 
                                                'category_sign' => 'fa fa-wrench' ),
                'hotelstravel'      => array(  'category' => __('Hotels & Travel','wpestate'), 
                                                'category_sign' => 'fa fa-bed' ),
                'localflavor'       => array(  'category' => __('Local Flavor','wpestate'), 
                                                'category_sign' => 'fa fa-coffee' ),
                'localservices'     => array(  'category' => __('Local Services','wpestate'), 
                                                'category_sign' => 'fa fa-dot-circle-o' ),
                'massmedia'         => array(  'category' => __('Mass Media','wpestate'),
                                                'category_sign' => 'fa fa-television' ),
                'nightlife'         => array(  'category' => __('Nightlife','wpestate'),
                                                'category_sign' => 'fa fa-glass' ),
                'pets'              => array(  'category' => __('Pets','wpestate'),
                                                'category_sign' => 'fa fa-paw' ),
                'professional'      => array(  'category' => __('Professional Services','wpestate'), 
                                                'category_sign' => 'fa fa-suitcase' ),
                'publicservicesgovt'=> array(  'category' => __('Public Services & Government','wpestate'),
                                                'category_sign' => 'fa fa-university' ),
                'realestate'        => array(  'category' => __('Real Estate','wpestate'), 
                                                'category_sign' => 'fa fa-building-o' ),
                'religiousorgs'     => array(  'category' => __('Religious Organizations','wpestate'), 
                                                'category_sign' => 'fa fa-cloud' ),
                'restaurants'       => array(  'category' => __('Restaurants','wpestate'),
                                                'category_sign' => 'fa fa-cutlery' ),
                'shopping'          => array(  'category' => __('Shopping','wpestate'),
                                                'category_sign' => 'fa fa-shopping-bag' ),
                'transport'         => array(  'category' => __('Transportation','wpestate'),
                                                'category_sign' => 'fa fa-bus' )
    );
    
    $yelp_terms             = get_option('wp_estate_yelp_categories','');
    $yelp_results_no        = get_option('wp_estate_yelp_results_no','');
    $yelp_dist_measure      = get_option('wp_estate_yelp_dist_measure','');
   
    $yelp_client_id         =   get_option('wp_estate_yelp_client_id','');
    $yelp_client_secret     =   get_option('wp_estate_yelp_client_secret','');
    $yelp_client_api_key_2018  =   get_option('wp_estate_yelp_client_api_key_2018','');
    if($yelp_client_id=='' || $yelp_client_api_key_2018=='' ){
        return;
    }
        
    //$location= "times square";
    $property_address           =   esc_html( get_post_meta($post_id, 'property_address', true) );
    $property_city_array        =   get_the_terms($post_id, 'property_city') ;
   
    if(empty($property_city_array)){
        return;
    }
  
    $property_city              =   $property_city_array[0]->name;
    $location                   =   $property_address.','.$property_city;
    
    $start_lat  =   get_post_meta($post_id,'property_latitude',true);
    $start_long =   get_post_meta($post_id,'property_longitude',true);
 
    
    $yelp_to_display='';
    
    $stored_yelp        =   get_post_meta($post_id,'stored_yelp',true);
    $stored_yelp_date   =   get_post_meta($post_id,'stored_yelp_data',true);
    $now                =   time();
    if(  $stored_yelp_date!='' && $stored_yelp_date+24*60*60 > $now){
        print $stored_yelp;
    }else{
        foreach ( $yelp_terms as $key=>$term ) {
    
            $category_name      =   $yelp_terms_array[$term]['category'];
            $category_icon      =   $yelp_terms_array[$term]['category_sign'];
           
            $args = array(
                'term'     => $term,
                'limit'    => $yelp_results_no,
                'location'      => $location
            );
           
            $details = wpestate_query_api($term,$location);
                     
            if( isset($details->businesses) ){
                $category=$details->businesses;
               


                $yelp_to_display.= '<div class="yelp_bussines_wrapper"><div class="yelp_icon"><i class="'.$category_icon.'"></i></div> <h4 class="yelp_category">'.$category_name.'</h4>';
                    foreach($category as $unit){
                    

                        $yelp_to_display.= '<div class="yelp_unit">';
                            $yelp_to_display.= '<h5 class="yelp_unit_name">'.$unit->name.'</h5>';
                        
                            if(isset($unit->coordinates->latitude) && isset($unit->coordinates->longitude)){
                                $yelp_to_display.= ' <span class="yelp_unit_distance"> '.wpestate_calculate_distance_geo($unit->coordinates->latitude,$unit->coordinates->longitude,$start_lat,$start_long,$yelp_dist_measure).'</span>';
                            }
                            
                            $image_path=(string)$unit->rating;
                            $image_path= str_replace('.5', '_half', $image_path);
                            $yelp_to_display.= '<img class="yelp_stars" src="'.get_template_directory_uri().'/img/yelp_small/small_'.$image_path.'.png" alt="'.$unit->name.'">';

                        $yelp_to_display.='</div>';

                    }
                $yelp_to_display.= '</div>';
            }
        }// end forearch
         
        print $yelp_to_display;
        update_post_meta($post_id,'stored_yelp',$yelp_to_display);
        update_post_meta($post_id,'stored_yelp_data',$now);
    }
        
      

    
           
           
       
    
    
}
endif;


if( !function_exists('wpestate_calculate_distance_geo') ):
function wpestate_calculate_distance_geo($lat,$long,$start_lat,$start_long,$yelp_dist_measure){
    
    $angle          = $start_long - $long;
    $distance       = sin( deg2rad( $start_lat ) ) * sin( deg2rad( $lat ) ) +  cos( deg2rad( $start_lat ) ) * cos( deg2rad( $lat ) ) * cos( deg2rad( $angle ) );
    $distance       = acos( $distance );
    $distance       = rad2deg( $distance );
    
    if ($yelp_dist_measure=='miles'){
        $distance_miles = $distance * 60 * 1.1515;
        return  '('.round( $distance_miles, 2 ).' '.__('miles','wpestate').')';
    }else{
        $distance_miles = $distance * 60 * 1.1515*1.6;
        return  '('.round( $distance_miles, 2 ).' '.__('km','wpestate').')';
    }
    

}
endif;

if( !function_exists('wpestate_show_related_listings') ):
function wpestate_show_related_listings($postid,$similar_no=3){
    global $property_unit_slider;
    global $no_listins_per_row;
    global $wpestate_uset_unit;
    global $custom_unit_structure;
        
    $custom_unit_structure  =   get_option('wpestate_property_unit_structure');
    $wpestate_uset_unit     =   intval ( get_option('wpestate_uset_unit','') );
    $no_listins_per_row     =   intval( get_option('wp_estate_listings_per_row', '') );
    $property_unit_slider   =   get_option('wp_estate_prop_list_slider','');
    $counter                =   0;
    $post_category          =   get_the_terms($postid, 'property_category');
    $post_action_category   =   get_the_terms($postid, 'property_action_category');
    $post_city_category     =   get_the_terms($postid, 'property_city');
    $args                   =   '';
    $items[]                =   '';
    $items_actions[]        =   '';
    $items_city[]           =   '';
    $categ_array            =   '';
    $action_array           =   '';
    $city_array             =   '';
    $not_in                 =   array();
    $not_in[]               =   $postid;
    $return_string          =   '';
    
    $property_card_type         =   intval(get_option('wp_estate_unit_card_type'));
    $property_card_type_string  =   '';
    if($property_card_type==0){
        $property_card_type_string='';
    }else{
        $property_card_type_string='_type'.$property_card_type;
    }

    ////////////////////////////////////////////////////////////////////////////
    /// compose taxomomy categ array
    ////////////////////////////////////////////////////////////////////////////

    if ($post_category!=''):
        foreach ($post_category as $item) {
            $items[] = $item->term_id;
        }
        $categ_array=array(
                'taxonomy' => 'property_category',
                'field' => 'id',
                'terms' => $items
            );
    endif;

    ////////////////////////////////////////////////////////////////////////////
    /// compose taxomomy action array
    ////////////////////////////////////////////////////////////////////////////

    if ($post_action_category!=''):
        foreach ($post_action_category as $item) {
            $items_actions[] = $item->term_id;
        }
        $action_array=array(
                'taxonomy' => 'property_action_category',
                'field' => 'id',
                'terms' => $items_actions
            );
    endif;

    ////////////////////////////////////////////////////////////////////////////
    /// compose taxomomy action city
    ////////////////////////////////////////////////////////////////////////////

    if ($post_city_category!=''):
        foreach ($post_city_category as $item) {
            $items_city[] = $item->term_id;
        }
        $city_array=array(
                'taxonomy' => 'property_city',
                'field' => 'id',
                'terms' => $items_city
            );
    endif;

    ////////////////////////////////////////////////////////////////////////////
    /// compose wp_query
    ////////////////////////////////////////////////////////////////////////////

    $args=array(
        'showposts'             => $similar_no,      
        'ignore_sticky_posts'   => 0,
        'post_type'             => 'estate_property',
        'post_status'           => 'publish',
        'post__not_in'          => $not_in,
        'tax_query'             => array(
        'relation'              => 'AND',
                                   $categ_array,
                                   $action_array,
                                   $city_array
                                   )
    );



    $compare_submit =   wpestate_get_template_link('compare_listings.php');
    $my_query = new WP_Query($args);
   
  
    if ($my_query->have_posts()) {
        
  
        $return_string.='
        <div class="mylistings"> 
            <h3 class="agent_listings_title_similar" >'.__('Similar Listings', 'wpestate').'</h3>';   
            ob_start();
            while ($my_query->have_posts()):$my_query->the_post();
                get_template_part('templates/property_unit'.$property_card_type_string);
            endwhile;
            $temp=ob_get_contents();
            ob_end_clean();
        $return_string.=$temp.'
        </div>';
    } //endif have post
    


wp_reset_query();
wp_reset_postdata();
return $return_string;
}
endif;





if( !function_exists('wpestate_sizes_no_format') ):
function wpestate_sizes_no_format($value,$return=0){
    $th_separator   =   get_option('wp_estate_prices_th_separator','');
    $return         = stripslashes(  number_format((floatval($value)),0,'.',$th_separator) );
    return $return;
   

}
endif;


if( !function_exists('wpestate_half_map_conditions')):
    function wpestate_half_map_conditions($pos_id){
    
        if( !is_category() && !is_tax()  && basename(get_page_template($pos_id)) == 'property_list_half.php'){
            return true;
        } else if( (  is_tax('') ) &&  get_option('wp_estate_property_list_type','')==2){
            $taxonomy    = get_query_var('taxonomy');
            if( $taxonomy == 'property_category_agent' || 
                $taxonomy == 'property_action_category_agent' || 
                $taxonomy == 'property_city_agent' || 
                $taxonomy == 'property_area_agent' ||
                $taxonomy == 'property_county_state_agent' ||
                $taxonomy == 'category_agency' ||
                $taxonomy == 'action_category_agency' ||
                $taxonomy == 'city_agency' ||
                $taxonomy == 'area_agency' ||
                $taxonomy == 'county_state_agency' ||
                $taxonomy == 'property_category_developer' ||
                $taxonomy == 'property_action_developer' ||
                $taxonomy == 'property_city_developer' ||
                $taxonomy == 'property_area_developer' ||
                $taxonomy == 'property_county_state_developer' 
                    
                    ){
                return false;
            }else{
                return true;
            }
        } else if(  is_page_template('advanced_search_results.php') &&  get_option('wp_estate_property_list_type_adv','')==2){
             return true;   
        }else{ 
            return false; 
        }
        
    }
endif;

//////////////////////////////////////////////////////////////////////////////////////
// show price bookign for invoice - 1 currency only
///////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_show_price_booking_for_invoice') ):
function wpestate_show_price_booking_for_invoice($price,$currency,$where_currency,$has_data=0,$return=0){
      
        
    $price_label='';
    $th_separator   =get_option('wp_estate_prices_th_separator','');
    $custom_fields = get_option( 'wp_estate_multi_curr', true);

    
    if ($price != 0) {
        $price=floatval($price);
        $price = number_format(($price),2,'.',$th_separator);
        if($has_data==1){
            $price = '<span class="inv_data_value">'.$price.'</span>';
        }
       
        if ($where_currency == 'before') {
            $price = $currency . ' ' . $price;
        } else {
            $price = $price . ' ' . $currency;
        }

    }else{
        $price='';
    }

  
    
    if($return==0){
        print $price.' '.$price_label;
    }else{
        return $price.' '.$price_label;
    }
}
endif;


if( !function_exists('wpestate_show_price_custom_invoice') ):
    function wpestate_show_price_custom_invoice($price){
        $price_label    =   '';
        $currency       =   esc_html( get_option('wp_estate_submission_curency', '') );
        $where_currency =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
        $th_separator   =   get_option('wp_estate_prices_th_separator','');
        $custom_fields  =   get_option( 'wp_estate_multi_curr', true);

        if ($price != 0) {
           $price = number_format($price,2,'.',$th_separator);

            if ($where_currency == 'before') {
                $price = $currency . ' ' . $price;
            } else {
                $price = $price . ' ' . $currency;
            }

        }else{
            $price='';
        }

     
        return $price.' '.$price_label;
       
    }
endif;

/////////////////////////////////////////////////////////////////////////////////
// datepcker_translate
///////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_date_picker_translation') ):
function wpestate_date_picker_translation($selector){
    $date_lang_status= esc_html ( get_option('wp_estate_date_lang','') );
     print '<script type="text/javascript">
                //<![CDATA[
                jQuery(document).ready(function(){
                        jQuery("#'.$selector.'").datepicker({
                                dateFormat : "yy-mm-dd"
                        },jQuery.datepicker.regional["'.$date_lang_status.'"]).datepicker("widget").wrap(\'<div class="ll-skin-melon"/>\');
                });
                //]]>
            </script>';
}
endif;


if( !function_exists('wpestate_date_picker_translation_return') ):
function wpestate_date_picker_translation_return($selector){
    $date_lang_status= esc_html ( get_option('wp_estate_date_lang','') );
     return '<script type="text/javascript">
                //<![CDATA[
                jQuery(document).ready(function(){
                        jQuery("#'.$selector.'").datepicker({
                                dateFormat : "yy-mm-dd"
                        },jQuery.datepicker.regional["'.$date_lang_status.'"]).datepicker("widget").wrap(\'<div class="ll-skin-melon"/>\');
                });
                //]]>
            </script>';
}
endif;


/////////////////////////////////////////////////////////////////////////////////
// show price
///////////////////////////////////////////////////////////////////////////////////




if( !function_exists('wpestate_show_price') ):
function wpestate_show_price($post_id,$currency,$where_currency,$return=0){
      
    $price_label        = '<span class="price_label">'.esc_html ( get_post_meta($post_id, 'property_label', true) ).'</span>';
    $price_label_before = '<span class="price_label price_label_before">'.esc_html ( get_post_meta($post_id, 'property_label_before', true) ).'</span>';
    $price              = floatval( get_post_meta($post_id, 'property_price', true) );
    
    $th_separator   = stripslashes ( get_option('wp_estate_prices_th_separator','') );
    $custom_fields  = get_option( 'wp_estate_multi_curr', true);
  
    if( !empty($custom_fields) && isset($_COOKIE['my_custom_curr']) &&  isset($_COOKIE['my_custom_curr_pos']) &&  isset($_COOKIE['my_custom_curr_symbol']) && $_COOKIE['my_custom_curr_pos']!=-1){
        $i=intval($_COOKIE['my_custom_curr_pos']);
        $custom_fields = get_option( 'wp_estate_multi_curr', true);
        if ($price != 0) {
            $price      = $price * $custom_fields[$i][2];
            if( $price == intval($price)){
                $price = number_format($price,0,'.',$th_separator);
            }else{
                $price = number_format($price,2,'.',$th_separator);
            }
           
            $currency   = $custom_fields[$i][0];
            
            if ($custom_fields[$i][3] == 'before') {
                $price = $currency . ' ' . $price;
            } else {
                $price = $price . ' ' . $currency;
            }
            
        }else{
            $price='';
        }
    }else{
        if ($price != 0) {
            
         
            if( $price == intval($price)){
              
                $price = number_format($price,0,'.',$th_separator);
            }else{
         
                $price = number_format($price,2,'.',$th_separator);
            }
            
            if ($where_currency == 'before') {
                $price = $currency . ' ' . $price;
            } else {
                $price = $price . ' ' . $currency;
            }
            
        }else{
            $price='';
        }
    
    }
    
  
    
    if($return==0){
        print $price_label_before.' '.$price.' '.$price_label;
    }else{
        return $price_label_before.' '.$price.' '.$price_label;
    }
}
endif;


/////////////////////////////////////////////////////////////////////////////////
// show price
///////////////////////////////////////////////////////////////////////////////////


if( !function_exists('wpestate_show_price_floor') ):
function wpestate_show_price_floor($price,$currency,$where_currency,$return=0){
      

    
    $th_separator   = stripslashes ( get_option('wp_estate_prices_th_separator','') );
    $custom_fields  = get_option( 'wp_estate_multi_curr', true);


    if( !empty($custom_fields) && isset($_COOKIE['my_custom_curr']) &&  isset($_COOKIE['my_custom_curr_pos']) &&  isset($_COOKIE['my_custom_curr_symbol']) && $_COOKIE['my_custom_curr_pos']!=-1){
        $i=intval($_COOKIE['my_custom_curr_pos']);
        $custom_fields = get_option( 'wp_estate_multi_curr', true);
        if ($price != 0) {
            
            $price      = $price * $custom_fields[$i][2];
           
           
            $price      = number_format($price,2,'.',$th_separator);
           
            $currency   = $custom_fields[$i][0];
            
            if ($custom_fields[$i][3] == 'before') {
                $price = $currency . ' ' . $price;
            } else {
                $price = $price . ' ' . $currency;
            }
            
        }else{
            $price='';
        }
    }else{
        if ($price != 0) {
        
         

            if( $price == intval($price)){
              
                $price = number_format($price,0,'.',$th_separator);
            }else{
         
                $price = number_format($price,2,'.',$th_separator);
            }
            
            if ($where_currency == 'before') {
                $price = $currency . ' ' . $price;
            } else {
                $price = $price . ' ' . $currency;
            }
            
        }else{
            $price='';
        }
    }
    
  
    
    if($return==0){
        print $price;
    }else{
        return $price;
    }
}
endif;


if( !function_exists('wpestate_virtual_tour_details') ):
function wpestate_virtual_tour_details($post_id) {
    echo $virtual_tour                   =   get_post_meta($post_id, 'embed_virtual_tour', true);   
}
endif;

/////////////////////////////////////////////////////////////////////////////////
// walscore api
///////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_walkscore_details') ):
function wpestate_walkscore_details($post_id) {
    
    
    $walkscore_api= esc_html ( get_option('wp_estate_walkscore_api','') );
    $w = new WalkScore($walkscore_api);
     
    $gmap_lat                   =   esc_html( get_post_meta($post_id, 'property_latitude', true));
    $gmap_long                  =   esc_html( get_post_meta($post_id, 'property_longitude', true));
    
    $options = array(
    'address' => '',
    'lat' => $gmap_lat,
    'lon' => $gmap_long,
    );
    
    $walkscore=$w->WalkScore($options);
    if(isset($walkscore->walkscore)){
        print '<div class="walk_details"><img src="https://cdn.walk.sc/images/api-logo.png" alt="walkscore">';
        print '<span>'.$walkscore->walkscore.' / '. $walkscore->description;
        print ' <a href="'.$walkscore->ws_link.'" target="_blank">'.__('more details here','wpestate').'</a> </span></div>';

        $property_city      =   get_the_term_list($post_id, 'property_city', '', ', ', '') ;
        $property_state      =   get_the_term_list($post_id, 'property_county_state', '', ', ', '') ;

        $regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>";
        if(preg_match_all("/$regexp/siU", $property_city, $matches, PREG_SET_ORDER)) {
            foreach($matches as $match) {
                // $match[2] = link address
                // $match[3] = link text
                $property_city = $match[3];
            }
        } 
        $regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>";
        if(preg_match_all("/$regexp/siU", $property_state, $matches, PREG_SET_ORDER)) {
            foreach($matches as $match) {
                // $match[2] = link address
                // $match[3] = link text
                $property_state =  $match[3];
            }
        } 


        $options = array(
            'lat' => $gmap_lat,
            'lon' => $gmap_long,
            'city' => $property_city,
            'state'=> $property_state
        );

        $tranzit_score= $w->PublicTransit('score', $options);
        if(isset($tranzit_score)){
            print '<div class="walk_details"><img src="https://cdn.walk.sc/images/transit-score-logo.png" alt="walkscore">';
            print '<span>'.$tranzit_score->transit_score.' / '. $tranzit_score->description.'</span>';
            print '<span class="" >'.$tranzit_score->summary.': </a>';
            print '<a href="'.$tranzit_score->ws_link.'" target="_blank">'.__('more details here','wpestate').'</a> </span></div>';   
        }
    }
} 
endif;



////////////////////

if( !function_exists('wpestate_insert_attachment') ):
function wpestate_insert_attachment($file_handler,$post_id,$setthumb='false') {

    // check to make sure its a successful upload
    if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();

    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
    require_once(ABSPATH . "wp-admin" . '/includes/file.php');
    require_once(ABSPATH . "wp-admin" . '/includes/media.php');

    $attach_id = media_handle_upload( $file_handler, $post_id );

    if ($setthumb) update_post_meta($post_id,'_thumbnail_id',$attach_id);
    return $attach_id;
} 
endif;

/////////////////////////////////////////////////////////////////////////////////
// order by filter featured
///////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_get_measure_unit') ):
function wpestate_get_measure_unit() {
    $measure_sys    =   esc_html ( get_option('wp_estate_measure_sys','') ); 
            
    if($measure_sys=='feet'){
        return 'ft<sup>2</sup>';
    }else{ 
        return 'm<sup>2</sup>';
    }              
}
endif;
/////////////////////////////////////////////////////////////////////////////////
// order by filter featured
///////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_my_order') ):
function wpestate_my_order($orderby) { 
    global $wpdb; 
    global $table_prefix;
    $orderby = $table_prefix.'postmeta.meta_value DESC, '.$table_prefix.'posts.ID DESC';
    return $orderby;
}    

endif; // end   wpestate_my_order  


if( !function_exists('wpestate_title_filter') ):
function wpestate_title_filter( $where, $wp_query ){
    global $wpdb;
    global $table_prefix;
    global $keyword;
    $search_term = $wpdb->esc_like($keyword);
    $search_term = ' \'%' . $search_term . '%\'';
    $where .= ' AND ' . $wpdb->posts . '.post_title LIKE '.$search_term;
    
    return $where;
}

endif;

////////////////////////////////////////////////////////////////////////////////////////
/////// Pagination
/////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('kriesi_pagination') ):

function kriesi_pagination($pages = '', $range = 2){  
 
    $showitems = ($range * 2)+1;  
    global $paged;
    if(empty($paged)) $paged = 1;


    if($pages == ''){
        global $wp_query;
        $pages = $wp_query->max_num_pages;
        if(!$pages)
        {
            $pages = 1;
        }
    }   

    if(1 != $pages){
        echo '<ul class="pagination pagination_nojax">';
        echo "<li class=\"roundleft\"><a href='".get_pagenum_link($paged - 1)."'><i class=\"fa fa-angle-left\"></i></a></li>";

        for ($i=1; $i <= $pages; $i++)
        {
            if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
            {
                if ($paged == $i){
                   print '<li class="active"><a href="'.get_pagenum_link($i).'" >'.$i.'</a><li>';
                }else{
                   print '<li><a href="'.get_pagenum_link($i).'" >'.$i.'</a><li>';
                }
            }
        }

        $prev_page= get_pagenum_link($paged + 1);
        if ( ($paged +1) > $pages){
           $prev_page= get_pagenum_link($paged );
        }else{
            $prev_page= get_pagenum_link($paged + 1);
        }


        echo "<li class=\"roundright\"><a href='".$prev_page."'><i class=\"fa fa-angle-right\"></i></a><li></ul>";
    }
}
endif; // end   kriesi_pagination  

////////////////////////////////////////////////////////////////////////////////////////
/////// Pagination Ajax
/////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('kriesi_pagination_agent') ):

function kriesi_pagination_agent($pages = '', $range = 2){  
 
    $showitems = ($range * 2)+1;  
    $paged = (get_query_var('page')) ? get_query_var('page') : 1;
    if(empty($paged)) $paged = 1;


    
    
   
     if(1 != $pages)
     { 
         $prev_pagex=  str_replace('page/','',get_pagenum_link($paged - 1) );
         echo '<ul class="pagination pagination_nojax">';
         echo "<li class=\"roundleft\"><a href='".$prev_pagex."'><i class=\"fa fa-angle-left\"></i></a></li>";
      
         for ($i=1; $i <= $pages; $i++)
         {
               $cur_page=str_replace('page/','',get_pagenum_link($i) );
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 if ($paged == $i){
                    print '<li class="active"><a href="'.$cur_page.'" >'.$i.'</a><li>';
                 }else{
                    print '<li><a href="'.$cur_page.'" >'.$i.'</a><li>';
                 }
             }
         }
         
        $prev_page= str_replace('page/','',get_pagenum_link($paged + 1) );
        if ( ($paged +1) > $pages){
           $prev_page= str_replace('page/','',get_pagenum_link($paged ) );
        }else{
           $prev_page= str_replace('page/','', get_pagenum_link($paged + 1) );
        }
     
         
         echo "<li class=\"roundright\"><a href='".$prev_page."'><i class=\"fa fa-angle-right\"></i></a><li></ul>";
     }
}
endif; // end   kriesi_pagination  

////////////////////////////////////////////////////////////////////////////////////////
/////// Pagination Custom
/////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('kriesi_pagination_ajax_newver') ):

function kriesi_pagination_ajax_newver($pages = '', $range = 2,$paged,$where,$order)
{  
    $showitems = ($range * 2)+1;  

     if(1 != $pages)
     {
        echo '<ul class="pagination c '.$where.'">';
        if($paged!=1){
            $prev_page=$paged-1;
        }else{
            $prev_page=1;
        }
         
        $prev_link= get_pagenum_link($paged - 1);
        $prev_link = add_query_arg( 'order', $order,$prev_link );
        
        echo "<li class=\"roundleft\"><a href='".$prev_link."' data-future='".$prev_page."'><i class=\"fa fa-angle-left\"></i></a></li>";
      
        for ($i=1; $i <= $pages; $i++)
        {
            $page_link=get_pagenum_link($i); 
            $page_link = add_query_arg( 'order', $order,$page_link );
            if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )){
                 if ($paged == $i){
                    print '<li class="active"><a href="'.$page_link.'" data-future="'.$i.'">'.$i.'</a><li>';
                 }else{
                    print '<li><a href="'.$page_link.'" data-future="'.$i.'">'.$i.'</a><li>';
                 }
            }
         }
         
        $next_page= get_pagenum_link($paged + 1);
        if ( ($paged +1) > $pages){
            $next_page= get_pagenum_link($paged );
            $next_page = add_query_arg( 'order', $order,$next_page );
            echo "<li class=\"roundright\"><a href='".$next_page."' data-future='".$paged."'><i class=\"fa fa-angle-right\"></i></a><li>"; 
        }else{
            $next_page= get_pagenum_link($paged + 1);
            $next_page = add_query_arg( 'order', $order,$next_page );
            echo "<li class=\"roundright\"><a href='".$next_page."' data-future='".($paged+1)."'><i class=\"fa fa-angle-right\"></i></a><li>"; 
        }
     
        echo "</ul>\n";
     }
}
endif; // end   kriesi_pagination  

if( !function_exists('kriesi_pagination_ajax') ):

function kriesi_pagination_ajax($pages = '', $range = 2,$paged,$where)
{  
    $showitems = ($range * 2)+1;  

     if(1 != $pages)
     {
         echo '<ul class="pagination c '.$where.'">';
         if($paged!=1){
             $prev_page=$paged-1;
         }else{
             $prev_page=1;
         }
         echo "<li class=\"roundleft\"><a href='".get_pagenum_link($paged - 1)."' data-future='".$prev_page."'><i class=\"fa fa-angle-left\"></i></a></li>";
      
         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 if ($paged == $i){
                    print '<li class="active"><a href="'.get_pagenum_link($i).'" data-future="'.$i.'">'.$i.'</a><li>';
                 }else{
                    print '<li><a href="'.get_pagenum_link($i).'" data-future="'.$i.'">'.$i.'</a><li>';
                 }
             }
         }
         
         $prev_page= get_pagenum_link($paged + 1);
         if ( ($paged +1) > $pages){
            $prev_page= get_pagenum_link($paged );
             echo "<li class=\"roundright\"><a href='".$prev_page."' data-future='".$paged."'><i class=\"fa fa-angle-right\"></i></a><li>"; 
         }else{
             $prev_page= get_pagenum_link($paged + 1);
             echo "<li class=\"roundright\"><a href='".$prev_page."' data-future='".($paged+1)."'><i class=\"fa fa-angle-right\"></i></a><li>"; 
         }
     
         
        
         echo "</ul>\n";
     }
}
endif; // end   kriesi_pagination  
///////////////////////////////////////////////////////////////////////////////////////////
/////// Look for images in post and add the rel="prettyPhoto"
///////////////////////////////////////////////////////////////////////////////////////////

add_filter('the_content', 'pretyScan');

if( !function_exists('pretyScan') ):
function pretyScan($content) {
    global $post;
    $pattern = "/<a(.*?)href=('|\")(.*?).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>/i";
    $replacement = '<a$1href=$2$3.$4$5 data-pretty="prettyPhoto" title="' . $post->post_title . '"$6>';
    $content = preg_replace($pattern, $replacement, $content);
    return $content;
}
endif; // end   pretyScan  






////////////////////////////////////////////////////////////////////////////////
/// force html5 validation -remove category list rel atttribute
////////////////////////////////////////////////////////////////////////////////    

add_filter( 'wp_list_categories', 'wpestate_remove_category_list_rel' );
add_filter( 'the_category', 'wpestate_remove_category_list_rel' );

if( !function_exists('wpestate_remove_category_list_rel') ):
function wpestate_remove_category_list_rel( $output ) {
    // Remove rel attribute from the category list
    return str_replace( ' rel="category tag"', '', $output );
}
endif; // end   wpestate_remove_category_list_rel  



////////////////////////////////////////////////////////////////////////////////
/// avatar url
////////////////////////////////////////////////////////////////////////////////    

if( !function_exists('wpestate_get_avatar_url') ):
function wpestate_get_avatar_url($get_avatar) {
    preg_match("/src='(.*?)'/i", $get_avatar, $matches);
    return $matches[1];
}
endif; // end   wpestate_get_avatar_url  



////////////////////////////////////////////////////////////////////////////////
///  get current map height
////////////////////////////////////////////////////////////////////////////////   

if( !function_exists('get_current_map_height') ):
function get_current_map_height($post_id){
    
   if ( $post_id == '' || is_home() ) {
        $min_height =   intval ( get_option('wp_estate_min_height','') );
   } else{
        $min_height =   intval ( (get_post_meta($post_id, 'min_height', true)) );
        if($min_height==0){
              $min_height =   intval ( get_option('wp_estate_min_height','') );
        }
   }    
   return $min_height;
}
endif; // end   get_current_map_height  



////////////////////////////////////////////////////////////////////////////////
///  get  map open height
////////////////////////////////////////////////////////////////////////////////   

if( !function_exists('get_map_open_height') ):
function get_map_open_height($post_id){
    
   if ( $post_id == '' || is_home() ) {
        $max_height =   intval ( get_option('wp_estate_max_height','') );
   } else{
        $max_height =   intval ( (get_post_meta($post_id, 'max_height', true)) );
        if($max_height==0){
            $max_height =   intval ( get_option('wp_estate_max_height','') );
        }
   }
    
   return $max_height;
}
endif; // end   get_map_open_height  





////////////////////////////////////////////////////////////////////////////////
///  get  map open/close status 
////////////////////////////////////////////////////////////////////////////////   

if( !function_exists('get_map_open_close_status') ):
function get_map_open_close_status($post_id){    
   if ( $post_id == '' || is_home() ) {
        $keep_min =  esc_html( get_option('wp_estate_keep_min','' ) ) ;
   } else{
        $keep_min =  esc_html ( (get_post_meta($post_id, 'keep_min', true)) );
   }
    
   if ($keep_min == 'yes'){
       $keep_min=1; // map is forced at closed
   }else{
       $keep_min=0; // map is free for resize
   }
   
   return $keep_min;
}
endif; // end   get_map_open_close_status  




////////////////////////////////////////////////////////////////////////////////
///  get  map  longitude
////////////////////////////////////////////////////////////////////////////////   
if( !function_exists('get_page_long') ):
function get_page_long($post_id){
      $header_type  =   get_post_meta ( $post_id ,'header_type', true);
      if( $header_type==5 ){
        $page_long  = esc_html( get_post_meta($post_id, 'page_custom_long', true) );          
      }
      else{
        $page_long  = esc_html( get_option('wp_estate_general_longitude','') );
      }
      return $page_long;   
}  
endif; // end   get_page_long  




////////////////////////////////////////////////////////////////////////////////
///  get  map  lattitudine
////////////////////////////////////////////////////////////////////////////////  

if( !function_exists('get_page_lat') ):
function get_page_lat($post_id){
      $header_type  =   get_post_meta ( $post_id ,'header_type', true);
      if( $header_type==5 ){
        $page_lat  = esc_html( get_post_meta($post_id, 'page_custom_lat', true) );
      }
      else{
        $page_lat = esc_html( get_option('wp_estate_general_latitude','') );
      }
      return $page_lat;
    
              
}  
endif; // end   get_page_lat  

////////////////////////////////////////////////////////////////////////////////
///  get  map  zoom
////////////////////////////////////////////////////////////////////////////////  

if( !function_exists('get_page_zoom') ):
function get_page_zoom($post_id){
      $header_type  =   get_post_meta ( $post_id ,'header_type', true);
      if( $header_type==5 ){
        $page_zoom  =  get_post_meta($post_id, 'page_custom_zoom', true);
      }
      else{
        $page_zoom = esc_html( get_option('wp_estate_default_map_zoom','') );
      }
      return $page_zoom;
    
              
}  
endif; // end   get_page_lat  



///////////////////////////////////////////////////////////////////////////////////////////
// get template link
///////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_get_template_link') ):
function wpestate_get_template_link( $template_name ){   
   $transient_name=$template_name;
    
        if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
            $transient_name.='_'. ICL_LANGUAGE_CODE;
        }

        
        $template_link = get_transient( 'wpestate_get_template_link_' . $transient_name );
        
        if( $template_link === false  ) {   
            $pages = get_pages(array(
                'meta_key'      => '_wp_page_template',
                'meta_value'    => $template_name
            ));

            if( $pages ){
                $template_link = get_permalink( $pages[0]->ID );
            }else{
                $template_link=home_url();
            }
            
          
            set_transient('wpestate_get_template_link_' . $transient_name,$template_link,60*60*24);
           
        }



        return $template_link;
}
endif; // end  









wpestate_get_template_link('user_dashboard_favorite.php');









///////////////////////////////////////////////////////////////////////////////////////////
// return video divs for sliders
///////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('custom_vimdeo_video') ):
    function custom_vimdeo_video($video_id) {
        $protocol = is_ssl() ? 'https' : 'http';
        return $return_string = '
        <div style="max-width:100%;" class="video">
           <iframe id="player_1" src="'.$protocol.'://player.vimeo.com/video/' . $video_id . '?api=1&amp;player_id=player_1"      allowFullScreen></iframe>
        </div>';

    }
endif; // end   custom_vimdeo_video  


if( !function_exists('custom_youtube_video') ):
    function  custom_youtube_video($video_id){
        $protocol = is_ssl() ? 'https' : 'http';
        return $return_string='
        <div style="max-width:100%;" class="video">
            <iframe id="player_2" title="YouTube video player" src="'.$protocol.'://www.youtube.com/embed/' . $video_id  . '?wmode=transparent&amp;rel=0" allowfullscreen ></iframe>
        </div>';
    }
endif; // end   custom_youtube_video  


if( !function_exists('get_video_thumb') ): 
    function get_video_thumb($post_id){
        $video_id       = esc_html( get_post_meta($post_id, 'embed_video_id', true) );
        $video_type     = esc_html( get_post_meta($post_id, 'embed_video_type', true) );
        $protocol       = is_ssl() ? 'https' : 'http';
        if($video_type=='vimeo'){
             $hash2 = ( wp_remote_get($protocol."://vimeo.com/api/v2/video/$video_id.php") );
             $pre_tumb=(unserialize ( $hash2['body']) );
             $video_thumb=$pre_tumb[0]['thumbnail_medium'];                                        
        }else{
            $video_thumb = $protocol.'://img.youtube.com/vi/' . $video_id . '/0.jpg';
        }
        return $video_thumb;
    }
endif;


if( !function_exists('generateRandomString') ): 
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
endif;




///////////////////////////////////////////////////////////////////////////////////////////
/////// Show advanced search form - classic frim
///////////////////////////////////////////////////////////////////////////////////////////





///////////////////////////////////////////////////////////////////////////////////////////
/////// Return country list for adv search 
///////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_country_list_adv_search') ): 
    function wpestate_country_list_adv_search($appendix,$slug){
        $country_list=wpestate_country_list_search($slug);
        $allowed_html = array();
        if(isset($_GET['advanced_country']) && $_GET['advanced_country']!='' && $_GET['advanced_country']!='all'){
            $advanced_country_value=  esc_html( wp_kses($_GET['advanced_country'], $allowed_html ) );
            $advanced_country_value1='';
        }else{
            $advanced_country_value=__('All Countries','wpestate');
            $advanced_country_value1='all';
        } 

        $return_string=wpestate_build_dropdown_adv($appendix,'adv-search-country','advanced_country',$advanced_country_value,$advanced_country_value1,'advanced_country',$country_list);
        return $return_string;         
    }
endif;    

///////////////////////////////////////////////////////////////////////////////////////////
/////// Return price form  for adv search 
//////////////////////////////
if( !function_exists('wpestate_price_form_adv_search') ): 
    function wpestate_price_form_adv_search($position,$slug,$label){
        $show_slider_price            =   get_option('wp_estate_show_slider_price','');
        
        if($position=='mainform'){
            $slider_id      =   'slider_price';
            $price_low_id   =   'price_low';
            $price_max_id   =   'price_max';
            $ammount_id     =   'amount';
            
        }else if($position=='sidebar') {
            $slider_id      =   'slider_price_widget';
            $price_low_id   =   'price_low_widget';
            $price_max_id   =   'price_max_widget';
            $ammount_id     =   'amount_wd';
            
        }else if($position=='shortcode') {
            $slider_id      =   'slider_price_sh';
            $price_low_id   =   'price_low_sh';
            $price_max_id   =   'price_max_sh';
            $ammount_id     =   'amount_sh';
            
        }else if($position=='mobile') {
            $slider_id      =   'slider_price_mobile';
            $price_low_id   =   'price_low_mobile';
            $price_max_id   =   'price_max_mobile';
            $ammount_id     =   'amount_mobile';
           
        }else if($position=='half') {
            $slider_id='slider_price';
            $price_low_id   =   'price_low';
            $price_max_id   =   'price_max';
            $ammount_id     =   'amount';
            
        }
        
        
        if ($show_slider_price==='yes'){
                $min_price_slider= ( floatval(get_option('wp_estate_show_slider_min_price','')) );
                $max_price_slider= ( floatval(get_option('wp_estate_show_slider_max_price','')) );

                if(isset($_GET['price_low'])){
                    $min_price_slider=  floatval($_GET['price_low']) ;
                }

                if(isset($_GET['price_low'])){
                    $max_price_slider=  floatval($_GET['price_max']) ;
                }

                $where_currency         =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
                $currency               =   esc_html( get_option('wp_estate_currency_symbol', '') );

                $price_slider_label = wpestate_show_price_label_slider($min_price_slider,$max_price_slider,$currency,$where_currency);
                
               
                
                $return_string='';
                if($position=='half'){
                    $return_string.='<div class="col-md-6 adv_search_slider">';
                }else{
                    $return_string.='<div class="adv_search_slider">';
                }
                
                $return_string.=' 
                    <p>
                        <label for="amount">'. __('Price range:','wpestate').'</label>
                        <span id="'.$ammount_id.'"  style="border:0; color:#3C90BE; font-weight:bold;">'.$price_slider_label.'</span>
                    </p>
                    <div id="'.$slider_id.'"></div>';
                $custom_fields = get_option( 'wp_estate_multi_curr', true);
                if( !empty($custom_fields) && isset($_COOKIE['my_custom_curr']) &&  isset($_COOKIE['my_custom_curr_pos']) &&  isset($_COOKIE['my_custom_curr_symbol']) && $_COOKIE['my_custom_curr_pos']!=-1){
                    $i=intval($_COOKIE['my_custom_curr_pos']);

                    if( !isset($_GET['price_low']) && !isset($_GET['price_max'])  ){
                        $min_price_slider       =   $min_price_slider * $custom_fields[$i][2];
                        $max_price_slider       =   $max_price_slider * $custom_fields[$i][2];
                    }
                }
                
                $return_string.='
                    <input type="hidden" id="'.$price_low_id.'"  name="price_low"  value="'.$min_price_slider.'"/>
                    <input type="hidden" id="'.$price_max_id.'"  name="price_max"  value="'.$max_price_slider.'"/>
                </div>';
                
        }else{
            $return_string='';
            if($position=='half'){
                $return_string.='<div class="col-md-3">';
            }
                
            $return_string.='<input type="text" id="'.$slug.'"  name="'.$slug.'" placeholder="'.$label.'" value="';
            if (isset($_GET[$slug])) {
                $allowed_html = array();
                $return_string.= esc_attr ( $_GET[$slug] );
            }
            $return_string.='" class="advanced_select form-control" />';
            
            if($position=='half'){
                $return_string.='</div>';
            }
        }
        return $return_string;
}
endif;


if( !function_exists('wpestate_price_form_adv_search_with_tabs') ): 
    function wpestate_price_form_adv_search_with_tabs($position,$slug,$label,$use_name,$term_id,$adv6_taxonomy_terms,$adv6_min_price,$adv6_max_price){
        $show_slider_price            =   get_option('wp_estate_show_slider_price','');
        
        
        $price_key=array_search($term_id,$adv6_taxonomy_terms);
        
        if($position=='mainform'){
            $slider_id      =   'slider_price_'.$term_id;
            $price_low_id   =   'price_low_'.$term_id;
            $price_max_id   =   'price_max_'.$term_id;
            $ammount_id     =   'amount_'.$term_id;
            
        }else if($position=='sidebar') {
            $slider_id      =   'slider_price_widget';
            $price_low_id   =   'price_low_widget';
            $price_max_id   =   'price_max_widget';
            $ammount_id     =   'amount_wd';
            
        }else if($position=='shortcode') {
            $slider_id      =   'slider_price_sh';
            $price_low_id   =   'price_low_sh';
            $price_max_id   =   'price_max_sh';
            $ammount_id     =   'amount_sh';
            
        }else if($position=='mobile') {
            $slider_id      =   'slider_price_mobile';
            $price_low_id   =   'price_low_mobile';
            $price_max_id   =   'price_max_mobile';
            $ammount_id     =   'amount_mobile';
           
        }else if($position=='half') {
            $slider_id='slider_price';
            $price_low_id   =   'price_low';
            $price_max_id   =   'price_max';
            $ammount_id     =   'amount';
            
        }
        
        $search_term_id=0;
        if(isset($_GET['term_id'])){
            $search_term_id=intval($_GET['term_id']);
        }
        
        
        if ($show_slider_price==='yes'){
                $min_price_slider=  floatval($adv6_min_price[$price_key] );
                $max_price_slider=  floatval($adv6_max_price[$price_key] );

                if(isset($_GET['price_low_'.$search_term_id]) && $search_term_id==$term_id ){
                    $min_price_slider=  floatval($_GET['price_low_'.$search_term_id]) ;
                }

                if(isset($_GET['price_low_'.$search_term_id]) && $search_term_id==$term_id ){
                    $max_price_slider=  floatval($_GET['price_max_'.$search_term_id]) ;
                }

                $where_currency         =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
                $currency               =   esc_html( get_option('wp_estate_currency_symbol', '') );

                $price_slider_label = wpestate_show_price_label_slider($min_price_slider,$max_price_slider,$currency,$where_currency);
                
               
                
                $return_string='';
                if($position=='half'){
                    $return_string.='<div class="col-md-6 adv_search_slider">';
                }else{
                    $return_string.='<div class="adv_search_slider">';
                }
                
                $return_string.=' 
                    <p>
                        <label for="amount">'. __('Price range:','wpestate').'</label>
                        <span id="'.$ammount_id.'"  style="border:0; color:#3C90BE; font-weight:bold;">'.$price_slider_label.'</span>
                    </p>
                    <div id="'.$slider_id.'"></div>';
                $custom_fields = get_option( 'wp_estate_multi_curr', true);
                if( !empty($custom_fields) && isset($_COOKIE['my_custom_curr']) &&  isset($_COOKIE['my_custom_curr_pos']) &&  isset($_COOKIE['my_custom_curr_symbol']) && $_COOKIE['my_custom_curr_pos']!=-1){
                    $i=intval($_COOKIE['my_custom_curr_pos']);

                    if( !isset($_GET['price_low_'.$search_term_id]) && !isset($_GET['price_max_'.$search_term_id])  ){
                        $min_price_slider       =   $min_price_slider * $custom_fields[$i][2];
                        $max_price_slider       =   $max_price_slider * $custom_fields[$i][2];
                    }
                }
                
                $return_string.='
                    <input type="hidden" id="'.$price_low_id.'" class="adv6_price_low price_active" name="'.$price_low_id.'"  value="'.$min_price_slider.'"/>
                    <input type="hidden" id="'.$price_max_id.'" class="adv6_price_max price_active" name="'.$price_max_id.'"  value="'.$max_price_slider.'"/>
                </div>';
                
        }else{
            $return_string='';
            if($position=='half'){
                $return_string.='<div class="col-md-3">';
            }
                
            $return_string.='<input type="text" id="'.$slug.'"  name="'.$slug.'" placeholder="'.$label.'" value="';
            if (isset($_GET[$slug])) {
                $allowed_html = array();
                $return_string.= esc_attr ( $_GET[$slug] );
            }
            $return_string.='" class="advanced_select form-control" />';
            
            if($position=='half'){
                $return_string.='</div>';
            }
        }
        return $return_string;
}
endif;







if( !function_exists('wpestate_return_title_from_slug') ):
function wpestate_return_title_from_slug($get_var,$getval){
    if ( $get_var=='filter_search_type' ){ 
        if( $getval!=='All'){
            $taxonomy   =   "property_category"; 
            $term       =   get_term_by(  'slug', $getval, $taxonomy );
            return $term->name;
        }else{
            return $getval;
        }
       
    }
    else if( $get_var== 'filter_search_action' ){
        $taxonomy="property_action_category"; 
        if( $getval!=='All'){
            $term       =   get_term_by(  'slug', $getval, $taxonomy );
            return $term->name;
        }else{
            return $getval;
        }
    }
    else if( $get_var== 'advanced_city' ){
        $taxonomy="property_city";
        if( $getval!=='All'){
            $term       =   get_term_by(  'slug', $getval, $taxonomy );
            return $term->name;
        }else{
            return $getval;
        }
    }
    else if( $get_var== 'advanced_area'){
        $taxonomy="property_area";
        if( $getval!=='All'){
            $term       =   get_term_by(  'slug', $getval, $taxonomy );
            return $term->name;
        }else{
            return $getval;
        }
    }
    else if( $get_var== 'advanced_contystate' ){
        $taxonomy="property_county_state";
        if( $getval!=='All'){
            $term       =   get_term_by(  'slug', $getval, $taxonomy );
            return $term->name;
        }else{
            return $getval;
        }
    }else{
        return $getval;
    }
    
    
    
    
    
};
endif;


//%d0%9c%d0%b8%d1%80%d0%b0%d0%ba%d1%81-%d0%9f%d0%b0%d1%80%d0%ba
//%d0%bc%d0%b8%d1%80%d0%b0%d0%ba%d1%81-%d0%bf%d0%b0%d1%80%d0%ba
//%d0%bc%d0%b8%d1%80%d0%b0%d0%ba%d1%81-%d0%bf%d0%b0%d1%80%d0%ba
//%d0%bc%d0%b8%d1%80%d0%b0%d0%ba%d1%81-%d0%bf%d0%b0%d1%80%d0%ba
///wpestate_build_dropdown_adv($appendix,'search-'.$slug,$slug,$label,'all',$slug,$rooms_select_list);
///////////////////////////////////////////////////////////////////////////////////////////
/////// Show advanced search fields
///////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_build_dropdown_adv') ):
function wpestate_build_dropdown_adv($appendix,$ul_id,$toogle_id,$values,$values1,$get_var,$select_list){
    $extraclass='';
    $caret_class='';
    $wrapper_class='';
    $return_string='';
    $is_half=0;
    $allowed_html =array();
            
    if($appendix==''){
        $extraclass=' filter_menu_trigger  ';
        $caret_class= ' caret_filter '; 
    }else  if($appendix=='sidebar-'){
        $extraclass=' sidebar_filter_menu  ';
        $caret_class= ' caret_sidebar '; 
    } else  if($appendix=='shortcode-'){
        $extraclass=' filter_menu_trigger  ';
        $caret_class= ' caret_filter '; 
        $wrapper_class = 'listing_filter_select';
    } else  if($appendix=='mobile-'){
        $extraclass=' filter_menu_trigger  ';
        $caret_class= ' caret_filter '; 
        $wrapper_class = '';
    }else  if($appendix=='half-'){
        $extraclass=' filter_menu_trigger  ';
        $caret_class= ' caret_filter '; 
        $wrapper_class = '';
        $return_string='<div class="col-md-3">';
        $appendix='';
        $is_half=1;
    }
    

        if ($get_var=='filter_search_type' || $get_var== 'filter_search_action'){
            if (isset(  $_GET[$get_var] ) && trim( $_GET[$get_var][0] ) !='' ){
                $getval         =   ucwords( esc_html( $_GET[$get_var][0] ) ); 
                $real_title     =   wpestate_return_title_from_slug($get_var,$getval);
                //remved09.02
                // $real_slug      =   esc_attr( wp_kses(  $_GET[$get_var] ,$allowed_html) );
                $getval         =   str_replace('-', ' ', $getval); 
                $show_val       =   $real_title;
                $current_val    =   $getval;
                $current_val1   =   $real_title;
            }else{
                $current_val  = $values;
                $show_val     = $values;
                $current_val1 = $values1;
            }
        }else{
            $get_var=sanitize_key($get_var);
           
            if (isset(  $_GET[$get_var] ) && trim( $_GET[$get_var]) !='' ){
                $getval         =   ucwords( esc_html ( wp_kses ( $_GET[$get_var] ,$allowed_html )  )   );
                $real_title     =   wpestate_return_title_from_slug($get_var,$getval);
                //removed09.02
                // $real_slug      =   esc_html( wp_kses( $_GET[$get_var], $allowed_html) );
                $getval         =   str_replace('-', ' ', $getval);
                $current_val    =   $getval;
                $show_val       =   $real_title;
                $current_val1   =   $real_title;
            }else{
                $current_val = $values;
                $show_val     = $values;
                $current_val1 = $values1;
            }
        }
                

 
        $return_string.=  '<div class="dropdown form-control '.$wrapper_class.'">
        <div data-toggle="dropdown" id="'.sanitize_key( $appendix.$toogle_id ).'" class="'.$extraclass.'" xx '.$values1.' '.$values.' data-value="'.( esc_attr( $current_val1) ).'">';
              
            if (  $get_var=='filter_search_type' || $get_var=='filter_search_action' || $get_var=='advanced_city' || $get_var=='advanced_area' || $get_var=='advanced_conty' || $get_var=='advanced_contystate'){
                if($show_val=='All'){
                    //sorry for this ugly fix
                    if($get_var=='filter_search_type'){
                        $return_string.=  __('All Types','wpestate');
                    }else if($get_var=='filter_search_action'){
                        $return_string.= __('All Actions','wpestate');
                    }else if($get_var=='advanced_city' ){
                        $return_string.= __('All Cities','wpestate');
                    }else if($get_var=='advanced_area'){
                        $return_string.=__('All Areas','wpestate');
                    }else if($get_var=='advanced_conty'){
                        $return_string.= __('All Actions','wpestate');
                    }else if($get_var=='advanced_contystate'){
                        $return_string.= __('All Counties/States','wpestate');
                    }
                    
                    
                    
                }else{
                    $return_string.= $show_val;     
                }
                
            }else{
                //$return_string.= str_replace('-',' ',$show_val);
                if (function_exists('icl_translate') ){
                    $show_val = apply_filters('wpml_translate_single_string', trim($show_val),'custom field value','custom_field_value'.$show_val );
                }
               //$return_string.= $show_val;
                //$return_string.= $values;
                
                if($show_val=='all' || $show_val=='All'){
                    $return_string.=    $values;
                }else{
                    $return_string.=    $show_val;
                }
            }
                    

            $return_string.= '
            <span class="caret '.$caret_class.'"></span>
            </div>';           
                     
                    
            if ($get_var=='filter_search_type' || $get_var== 'filter_search_action'){
                $return_string.=' <input type="hidden" name="'.$get_var.'[]" value="';
                if(isset($_GET[$get_var][0])){
                    $return_string.= strtolower(  esc_attr( $_GET[$get_var][0] ) );
                }
            }else{
                $return_string.=' <input type="hidden" name="'.sanitize_key( $get_var ).'" value="';
                if(isset($_GET[$get_var])){
                    $return_string.= strtolower( esc_attr ( $_GET[$get_var] ) );
                }
            }

                $return_string.='">
                <ul  id="'.$appendix.$ul_id.'" class="dropdown-menu filter_menu" role="menu" aria-labelledby="'.$appendix.$toogle_id.'">
                    '.$select_list.'
                </ul>        
            </div>';
                    
        if($is_half==1){
            $return_string.='</div>';  
        }                
    return $return_string;                
}
endif;

///////////////////////////////////////////////////////////////////////////////////////////
/////// Show advanced search form - custom fileds
///////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_show_search_field_with_tabs') ):
         
    function  wpestate_show_search_field_with_tabs($position,$search_field,$action_select_list,$categ_select_list,$select_city_list,$select_area_list,$key,$select_county_state_list,$use_name,$term_id){
        $adv_search_what        =   get_option('wp_estate_adv_search_what','');
        $adv_search_label       =   get_option('wp_estate_adv_search_label','');
        $adv_search_how         =   get_option('wp_estate_adv_search_how','');
        $adv6_max_price         =   get_option('wp_estate_adv6_max_price');     
        $adv6_min_price         =   get_option('wp_estate_adv6_min_price');
        $adv6_taxonomy_terms    =   get_option('wp_estate_adv6_taxonomy_terms'); 
     
        $allowed_html=array();
        if($position=='mainform'){
            $appendix='';
        }else if($position=='sidebar') {
            $appendix='sidebar-';
        }else if($position=='shortcode') {
            $appendix='shortcode-';  
        }else if($position=='mobile') {
            $appendix='mobile-';
        }else if($position=='half') {
            $appendix='half-';
        }
        
        $return_string='';
        if($search_field=='none'){
            $return_string=''; 
        }
        else if($search_field=='types'){
           
            if(isset($_GET['filter_search_action'][0]) && $_GET['filter_search_action'][0]!='' && $_GET['filter_search_action'][0]!='all'){
                $full_name          =   get_term_by('slug', ( ( $_GET['filter_search_action'][0] ) ),'property_action_category');
                $adv_actions_value  =   $adv_actions_value1 = $full_name->name;
            }else{
                $adv_actions_value  =   __('All Actions','wpestate');
                $adv_actions_value1 =   'all';
            } 

            $return_string  .=   wpestate_build_dropdown_adv($appendix,'actionslist','adv_actions',$adv_actions_value,$adv_actions_value1,'filter_search_action',$action_select_list);


        }else if($search_field=='categories'){
            
            if( isset($_GET['filter_search_type'][0]) && $_GET['filter_search_type'][0]!=''  && $_GET['filter_search_type'][0]!='all' ){
                $full_name = get_term_by('slug', esc_html( wp_kses($_GET['filter_search_type'][0], $allowed_html) ),'property_category');
                $adv_categ_value    =   $adv_categ_value1   =   $full_name->name;
            }else{
                $adv_categ_value    =   __('All Types','wpestate');
                $adv_categ_value1   =   'all';
            }
            $return_string=wpestate_build_dropdown_adv($appendix,'categlist','adv_categ',$adv_categ_value,$adv_categ_value1,'filter_search_type',$categ_select_list);


        }  else if($search_field=='cities'){
            
            if(isset($_GET['advanced_city']) && $_GET['advanced_city']!='' && $_GET['advanced_city']!='all'){
                $full_name              =   get_term_by('slug', esc_html( wp_kses( $_GET['advanced_city'], $allowed_html) ),'property_city');
                $advanced_city_value    =   $advanced_city_value1=$full_name->name;
            }else{
                $advanced_city_value    =   __('All Cities','wpestate');
                $advanced_city_value1   =   'all';
            } 
            $return_string=wpestate_build_dropdown_adv($appendix,'adv-search-city','advanced_city',$advanced_city_value,$advanced_city_value1,'advanced_city',$select_city_list);

        }   else if($search_field=='areas'){

            if(isset($_GET['advanced_area']) && $_GET['advanced_area']!=''  && $_GET['advanced_area']!='all'){
                $full_name              =   get_term_by('slug', esc_html( wp_kses($_GET['advanced_area'], $allowed_html) ),'property_area');
                $advanced_area_value    =   $advanced_area_value1= $full_name->name;
            }else{
                $advanced_area_value    =   __('All Areas','wpestate');
                $advanced_area_value1   =   'all';
            }
            $return_string=wpestate_build_dropdown_adv($appendix,'adv-search-area','advanced_area',$advanced_area_value,$advanced_area_value1,'advanced_area',$select_area_list);

        }else if($search_field=='county / state'){
            
            if(isset($_GET['advanced_contystate']) && $_GET['advanced_contystate']!='' && $_GET['advanced_contystate']!='all' ){
                $full_name              = get_term_by('slug', esc_html( wp_kses($_GET['advanced_contystate'], $allowed_html) ),'property_county_state');
                $advanced_county_value  = $advanced_county_value1= $full_name->name;
              
            }else{
                $advanced_county_value  = __('All Counties/States','wpestate');
                $advanced_county_value1 = 'all';
            }
            $return_string=wpestate_build_dropdown_adv($appendix,'adv-search-countystate','county-state',$advanced_county_value,$advanced_county_value1,'advanced_contystate',$select_county_state_list);

        }else {
                $show_dropdowns          =   get_option('wp_estate_show_dropdowns','');
                $string       =   wpestate_limit45 ( sanitize_title ($adv_search_label[$key]) );              
                $slug         =   sanitize_key($string);
              
                $label=$adv_search_label[$key];
                if (function_exists('icl_translate') ){
                    $label     =   icl_translate('wpestate','wp_estate_custom_search_'.$label, $label ) ;
                }
            
              //  print '--- '.$adv_search_what[$key];
                
                if ( $adv_search_what[$key]=='property country'){
                    ////////////////////////////////  show country list
                    $return_string =  wpestate_country_list_adv_search($appendix,$slug);
                     
                } else if ( $adv_search_what[$key]=='property price'){
                    ////////////////////////////////  show price form
                    $return_string = wpestate_price_form_adv_search_with_tabs($position,$slug,$label,$use_name,$term_id,$adv6_taxonomy_terms,$adv6_min_price,$adv6_max_price);
                
                    
                } else if ( $show_dropdowns=='yes' && ( $adv_search_what[$key]=='property rooms' ||  $adv_search_what[$key]=='property bedrooms' ||  $adv_search_what[$key]=='property bathrooms') ){
                    $i=0;
                    if (function_exists('icl_translate') ){
                    $label     =   icl_translate('wpestate','wp_estate_custom_search_'.$adv_search_label[$key], $adv_search_label[$key] ) ;
                    }else{
                       $label= $adv_search_label[$key];
                    }
                    $rooms_select_list =   ' <li role="presentation" data-value="all">'.  $label.'</li>';
                    while($i < 10 ){
                        $i++;
                        $rooms_select_list.='<li data-value="'.$i.'"  value="'.$i.'">'.$i.'</li>';
                    }
                    
                    $return_string=wpestate_build_dropdown_adv($appendix,'search-'.$slug,$slug,$label,'all',$slug,$rooms_select_list);
                 
                }else{ 
                    $custom_fields = get_option( 'wp_estate_custom_fields', true); 
                 
                    $i=0;
                    $found_dropdown=0;
                    ///////////////////////////////// dropdown check
                    if( !empty($custom_fields)){  
                        while($i< count($custom_fields) ){          
                            $name       =   $custom_fields[$i][0];
                          
                            $slug_drop       =   str_replace(' ','-',$name);

                            if( $slug_drop == $adv_search_what[$key] && $custom_fields[$i][2]=='dropdown' ){
                              
                                $found_dropdown=1;
                                $front_name=sanitize_title($adv_search_label[$key]);
                                if (function_exists('icl_translate') ){
                                    $initial_key = apply_filters('wpml_translate_single_string', trim($adv_search_label[$key]),'custom field value','custom_field_value'.$adv_search_label[$key] );
                                    $action_select_list =   ' <li role="presentation" data-value="all"> '. $initial_key .'</li>';  
                                }else{
                                    $action_select_list =   ' <li role="presentation" data-value="all">'.  $adv_search_label[$key].'</li>';
                                }
                                
                                $dropdown_values_array=explode(',',$custom_fields[$i][4]);
                             
                                foreach($dropdown_values_array as $drop_key=>$value_drop){
                                    $original_value_drop    =$value_drop;
                                    if (function_exists('icl_translate') ){
                                        
                                        $value_drop = apply_filters('wpml_translate_single_string', trim($value_drop),'custom field value','custom_field_value'.$value_drop );
                                    }
                                    $action_select_list .=   ' <li role="presentation" data-value="'.trim($original_value_drop).'">'.trim($value_drop).'</li>';
                                }
                                $front_name=sanitize_title($adv_search_label[$key]);
                                if(isset($_GET[$front_name]) && $_GET[$front_name]!='' && $_GET[$front_name]!='all'){
                                    $advanced_drop_value= esc_attr( wp_kses( $_GET[$front_name], $allowed_html) );
                                    $advanced_drop_value1='';
                                }else{
                                    $advanced_drop_value= $label;
                                    $advanced_drop_value1='all';
                                } 
                                $front_name=  wpestate_limit45($front_name);
                                $return_string=wpestate_build_dropdown_adv($appendix,$front_name,$front_name,$advanced_drop_value,$advanced_drop_value1,$front_name,$action_select_list);
                 
                              
                            }
                            $i++;
                        }
                    }  
                    ///////////////////// end dropdown check
                    
                    if($found_dropdown==0){
                        //////////////// regular field 
                        $return_string='';
                        if($position=='half'){
                            $return_string.='<div class="col-md-3">';
                            $appendix='';
                        }
                        
                        if ( $adv_search_how[$key]=='date bigger' || $adv_search_how[$key]=='date smaller'){
                            $return_string.='<input type="text" id="'.wp_kses($term_id.$appendix.$slug,$allowed_html).'"  name="'.wp_kses($slug,$allowed_html).'" placeholder="'.wp_kses($label,$allowed_html).'" value="';
                        }else{
                            $return_string.='<input type="text" id="'.wp_kses($appendix.$slug,$allowed_html).'"  name="'.wp_kses($slug,$allowed_html).'" placeholder="'.wp_kses($label,$allowed_html).'" value="';
                        }
                        
                        if (isset($_GET[$slug])) {
                            $return_string.=  esc_attr( $_GET[$slug] );
                        }
                        $return_string.='" class="advanced_select form-control" />';
                        
                        if($position=='half'){
                            $return_string.='</div>';
                        }
                        ////////////////// apply datepicker if is the case
                        if ( $adv_search_how[$key]=='date bigger' || $adv_search_how[$key]=='date smaller'){
                            wpestate_date_picker_translation($term_id.$appendix.$slug);
                        }
                    }
                    
                }

            } 
            print $return_string;
         }
endif; // 


if( !function_exists('wpestate_show_search_field_tab_inject') ):
         
    function  wpestate_show_search_field_tab_inject($position,$search_field,$action_select_list,$categ_select_list,$select_city_list,$select_area_list,$key,$select_county_state_list){
        $adv_search_what        =   get_option('wp_estate_adv_search_what','');
        $adv_search_label       =   get_option('wp_estate_adv_search_label','');
        $adv_search_how         =   get_option('wp_estate_adv_search_how','');
        $allowed_html=array();
        if($position=='mainform'){
            $appendix='';
        }else if($position=='sidebar') {
            $appendix='sidebar-';
        }else if($position=='shortcode') {
            $appendix='shortcode-';  
        }else if($position=='mobile') {
            $appendix='mobile-';
        }else if($position=='half') {
            $appendix='half-';
        }
        
        $return_string='';
        if($search_field=='none'){
            $return_string=''; 
        }
        else if($search_field=='types'){
           
            if(isset($_GET['filter_search_action'][0]) && $_GET['filter_search_action'][0]!='' && $_GET['filter_search_action'][0]!='all'){
                $full_name          =   get_term_by('slug', ( ( $_GET['filter_search_action'][0] ) ),'property_action_category');
                $adv_actions_value  =   $adv_actions_value1 = $full_name->name;
            }else{
                $adv_actions_value  =   __('All Actions','wpestate');
                $adv_actions_value1 =   'all';
            } 

            $return_string  .=   wpestate_build_dropdown_adv($appendix,'actionslist','adv_actions',$adv_actions_value,$adv_actions_value1,'filter_search_action',$action_select_list);


        }else if($search_field=='categories'){
            
            if( isset($_GET['filter_search_type'][0]) && $_GET['filter_search_type'][0]!=''  && $_GET['filter_search_type'][0]!='all' ){
                $full_name = get_term_by('slug', esc_html( wp_kses($_GET['filter_search_type'][0], $allowed_html) ),'property_category');
                $adv_categ_value    =   $adv_categ_value1   =   $full_name->name;
            }else{
                $adv_categ_value    =   __('All Types','wpestate');
                $adv_categ_value1   =   'all';
            }
            $return_string=wpestate_build_dropdown_adv($appendix,'categlist','adv_categ',$adv_categ_value,$adv_categ_value1,'filter_search_type',$categ_select_list);


        }  else if($search_field=='cities'){
            
            if(isset($_GET['advanced_city']) && $_GET['advanced_city']!='' && $_GET['advanced_city']!='all'){
                $full_name              =   get_term_by('slug', esc_html( wp_kses( $_GET['advanced_city'], $allowed_html) ),'property_city');
                $advanced_city_value    =   $advanced_city_value1=$full_name->name;
            }else{
                $advanced_city_value    =   __('All Cities','wpestate');
                $advanced_city_value1   =   'all';
            } 
            $return_string=wpestate_build_dropdown_adv($appendix,'adv-search-city','advanced_city',$advanced_city_value,$advanced_city_value1,'advanced_city',$select_city_list);

        }else if($search_field=='areas'){

            if(isset($_GET['advanced_area']) && $_GET['advanced_area']!=''  && $_GET['advanced_area']!='all'){
                $full_name              =   get_term_by('slug', esc_html( wp_kses($_GET['advanced_area'], $allowed_html) ),'property_area');
                $advanced_area_value    =   $advanced_area_value1= $full_name->name;
            }else{
                $advanced_area_value    =   __('All Areas','wpestate');
                $advanced_area_value1   =   'all';
            }
            $return_string=wpestate_build_dropdown_adv($appendix,'adv-search-area','advanced_area',$advanced_area_value,$advanced_area_value1,'advanced_area',$select_area_list);

        }else if($search_field=='county / state'){
            
            if(isset($_GET['advanced_contystate']) && $_GET['advanced_contystate']!='' && $_GET['advanced_contystate']!='all' ){
                $full_name              = get_term_by('slug', esc_html( wp_kses($_GET['advanced_contystate'], $allowed_html) ),'property_county_state');
                $advanced_county_value  = $advanced_county_value1= $full_name->name;
              
            }else{
                $advanced_county_value  = __('All Counties/States','wpestate');
                $advanced_county_value1 = 'all';
            }
            $return_string=wpestate_build_dropdown_adv($appendix,'adv-search-countystate','county-state',$advanced_county_value,$advanced_county_value1,'advanced_contystate',$select_county_state_list);

        }
        print $return_string;
    }
endif; // 


if( !function_exists('wpestate_show_search_field') ):
         
    function  wpestate_show_search_field($position,$search_field,$action_select_list,$categ_select_list,$select_city_list,$select_area_list,$key,$select_county_state_list){
        $adv_search_what        =   get_option('wp_estate_adv_search_what','');
        $adv_search_label       =   get_option('wp_estate_adv_search_label','');
        $adv_search_how         =   get_option('wp_estate_adv_search_how','');
        $allowed_html=array();
        if($position=='mainform'){
            $appendix='';
        }else if($position=='sidebar') {
            $appendix='sidebar-';
        }else if($position=='shortcode') {
            $appendix='shortcode-';  
        }else if($position=='mobile') {
            $appendix='mobile-';
        }else if($position=='half') {
            $appendix='half-';
        }
        
        $return_string='';
        if($search_field=='none'){
            $return_string=''; 
        }
        else if($search_field=='types'){
           
            if(isset($_GET['filter_search_action'][0]) && trim($_GET['filter_search_action'][0])!='' && $_GET['filter_search_action'][0]!='all'){
                $full_name          =   get_term_by('slug', ( ( $_GET['filter_search_action'][0] ) ),'property_action_category');
                $adv_actions_value  =   $adv_actions_value1 = $full_name->name;
            }else{
                $adv_actions_value  =   __('All Actions','wpestate');
                $adv_actions_value1 =   'all';
            } 

            $return_string  .=   wpestate_build_dropdown_adv($appendix,'actionslist','adv_actions',$adv_actions_value,$adv_actions_value1,'filter_search_action',$action_select_list);


        }else if($search_field=='categories'){
            
            if( isset($_GET['filter_search_type'][0]) && trim($_GET['filter_search_type'][0])!=''  && $_GET['filter_search_type'][0]!='all' ){
                $full_name = get_term_by('slug', esc_html( wp_kses($_GET['filter_search_type'][0], $allowed_html) ),'property_category');
                $adv_categ_value    =   $adv_categ_value1   =   $full_name->name;
            }else{
                $adv_categ_value    =   __('All Types','wpestate');
                $adv_categ_value1   =   'all';
            }
            $return_string=wpestate_build_dropdown_adv($appendix,'categlist','adv_categ',$adv_categ_value,$adv_categ_value1,'filter_search_type',$categ_select_list);


        }  else if($search_field=='cities'){
            
            if(isset($_GET['advanced_city']) && trim($_GET['advanced_city'])!='' && $_GET['advanced_city']!='all'){
                $full_name              =   get_term_by('slug', esc_html( wp_kses( $_GET['advanced_city'], $allowed_html) ),'property_city');
                $advanced_city_value    =   $advanced_city_value1=$full_name->name;
            }else{
                $advanced_city_value    =   __('All Cities','wpestate');
                $advanced_city_value1   =   'all';
            } 
            $return_string=wpestate_build_dropdown_adv($appendix,'adv-search-city','advanced_city',$advanced_city_value,$advanced_city_value1,'advanced_city',$select_city_list);

        }   else if($search_field=='areas'){

            if(isset($_GET['advanced_area']) && trim($_GET['advanced_area'])!=''  && $_GET['advanced_area']!='all'){
                $full_name              =   get_term_by('slug', esc_html( wp_kses($_GET['advanced_area'], $allowed_html) ),'property_area');
                $advanced_area_value    =   $advanced_area_value1= $full_name->name;
            }else{
                $advanced_area_value    =   __('All Areas','wpestate');
                $advanced_area_value1   =   'all';
            }
            $return_string=wpestate_build_dropdown_adv($appendix,'adv-search-area','advanced_area',$advanced_area_value,$advanced_area_value1,'advanced_area',$select_area_list);

        }else if($search_field=='county / state'){
            
            if(isset($_GET['advanced_contystate']) && trim($_GET['advanced_contystate'])!='' && $_GET['advanced_contystate']!='all' ){
                $full_name              = get_term_by('slug', esc_html( wp_kses($_GET['advanced_contystate'], $allowed_html) ),'property_county_state');
                $advanced_county_value  = $advanced_county_value1= $full_name->name;
              
            }else{
                $advanced_county_value  = __('All Counties/States','wpestate');
                $advanced_county_value1 = 'all';
            }
            $return_string=wpestate_build_dropdown_adv($appendix,'adv-search-countystate','county-state',$advanced_county_value,$advanced_county_value1,'advanced_contystate',$select_county_state_list);

        }else {
                $show_dropdowns          =   get_option('wp_estate_show_dropdowns','');
                $string       =   wpestate_limit45 ( sanitize_title ($adv_search_label[$key]) );              
                $slug         =   sanitize_key($string);
              
                $label=$adv_search_label[$key];
                if (function_exists('icl_translate') ){
                    $label     =   icl_translate('wpestate','wp_estate_custom_search_'.$label, $label ) ;
                }
            
              //  print '--- '.$adv_search_what[$key];
                
                if ( $adv_search_what[$key]=='property country'){
                    ////////////////////////////////  show country list
                    $return_string =  wpestate_country_list_adv_search($appendix,$slug);
                     
                } else if ( $adv_search_what[$key]=='property price'){
                    ////////////////////////////////  show price form
                    $return_string = wpestate_price_form_adv_search($position,$slug,$label);
                
                    
                } else if ( $show_dropdowns=='yes' && ( $adv_search_what[$key]=='property rooms' ||  $adv_search_what[$key]=='property bedrooms' ||  $adv_search_what[$key]=='property bathrooms') ){
                    $i=0;
                    if (function_exists('icl_translate') ){
                        $label     =   icl_translate('wpestate','wp_estate_custom_search_'.$adv_search_label[$key], $adv_search_label[$key] ) ;
                    }else{
                       $label= $adv_search_label[$key];
                    }
                    $rooms_select_list =   ' <li role="presentation" data-value="all">'.  $label.'</li>';
                    while($i < 10 ){
                        $i++;
                        $rooms_select_list.='<li data-value="'.$i.'"  value="'.$i.'">'.$i.'</li>';
                    }
                    
                    $return_string=wpestate_build_dropdown_adv($appendix,'search-'.$slug,$slug,$label,'all',$slug,$rooms_select_list);
                 
                }else{ 
                    $custom_fields = get_option( 'wp_estate_custom_fields', true); 
                 
                    $i=0;
                    $found_dropdown=0;
                    ///////////////////////////////// dropdown check
                    if( !empty($custom_fields)){  
                        while($i< count($custom_fields) ){          
                            $name       =   $custom_fields[$i][0];
                          
                            $slug_drop       =   str_replace(' ','-',$name);

                            if( $slug_drop == $adv_search_what[$key] && $custom_fields[$i][2]=='dropdown' ){
                              
                                $found_dropdown=1;
                                $front_name=sanitize_title($adv_search_label[$key]);
                                if (function_exists('icl_translate') ){
                                    $initial_key = apply_filters('wpml_translate_single_string', trim($adv_search_label[$key]),'custom field value','custom_field_value'.$adv_search_label[$key] );
                                    $action_select_list =   ' <li role="presentation" data-value="all"> '. $initial_key .'</li>';  
                                }else{
                                    $action_select_list =   ' <li role="presentation" data-value="all">'.  $adv_search_label[$key].'</li>';
                                }
                                
                                $dropdown_values_array=explode(',',$custom_fields[$i][4]);
                             
                                foreach($dropdown_values_array as $drop_key=>$value_drop){
                                    $original_value_drop    =$value_drop;
                                    if (function_exists('icl_translate') ){
                                        
                                        $value_drop = apply_filters('wpml_translate_single_string', trim($value_drop),'custom field value','custom_field_value'.$value_drop );
                                    }
                                    $action_select_list .=   ' <li role="presentation" data-value="'.trim($original_value_drop).'">'.trim($value_drop).'</li>';
                                }
                                $front_name=sanitize_title($adv_search_label[$key]);
                                if(isset($_GET[$front_name]) && $_GET[$front_name]!='' && $_GET[$front_name]!='all'){
                                    $advanced_drop_value= esc_attr( wp_kses( $_GET[$front_name], $allowed_html) );
                                    $advanced_drop_value1='';
                                }else{
                                    $advanced_drop_value= $label;
                                    $advanced_drop_value1='all';
                                } 
                                $front_name=  wpestate_limit45($front_name);
                                $return_string=wpestate_build_dropdown_adv($appendix,$front_name,$front_name,$advanced_drop_value,$advanced_drop_value1,$front_name,$action_select_list);
                 
                              
                            }
                            $i++;
                        }
                    }  
                    ///////////////////// end dropdown check
                    
                    if($found_dropdown==0){
                        //////////////// regular field 
                        $return_string='';
                        if($position=='half'){
                            $return_string.='<div class="col-md-3">';
                            $appendix='';
                        }
                        
                        $return_string.='<input type="text" id="'.wp_kses($appendix.$slug,$allowed_html).'"  name="'.wp_kses($slug,$allowed_html).'" placeholder="'.wp_kses($label,$allowed_html).'" value="';
                        if (isset($_GET[$slug])) {
                            $return_string.=  esc_attr( $_GET[$slug] );
                        }
                        $return_string.='" class="advanced_select form-control" />';
                        
                        if($position=='half'){
                            $return_string.='</div>';
                        }
                        ////////////////// apply datepicker if is the case
                        if ( $adv_search_how[$key]=='date bigger' || $adv_search_how[$key]=='date smaller'){
                            wpestate_date_picker_translation($appendix.$slug);
                        }
                    }
                    
                }

            } 
            print $return_string;
        }
endif; // 


if( !function_exists('show_extended_search') ): 
    function show_extended_search($tip){
        print '<div class="adv_extended_options_text" id="adv_extended_options_text_'.$tip.'">'.__('More Search Options','wpestate').'</div>';
               print '<div class="extended_search_check_wrapper">';
               print '<span id="adv_extended_close_'.$tip.'" class="adv_extended_close_button" ><i class="fa fa-times"></i></span>';

               $advanced_exteded   =   get_option( 'wp_estate_advanced_exteded', true); 

               foreach($advanced_exteded as $checker => $value){
                   $post_var_name  =   str_replace(' ','_', trim($value) );
                   $input_name     =   wpestate_limit45(sanitize_title( $post_var_name ));
                   $input_name     =   sanitize_key($input_name);
                   $value          =   stripslashes($value);
                   if (function_exists('icl_translate') ){
                       $value     =   icl_translate('wpestate','wp_estate_property_custom_amm_'.$value, $value ) ;                                      
                   }
                   
                    $value= str_replace('_',' ', trim($value) );
                    if($value!='none'){
                        $check_selected='';
                        if( isset($_GET[$input_name]) && $_GET[$input_name]=='1'  ){
                        $check_selected=' checked ';  
                        }
                    print
                        '<div class="extended_search_checker">
                            <input type="checkbox" id="'.$input_name.$tip.'" name="'.$input_name.'" value="1" '.$check_selected.'>
                            <label for="'.$input_name.$tip.'">'.($value).'</label>
                        </div>';
                  }
               }

        print '</div>';    
    }
endif;






////////////////////////////////////////////////////////////////////////////////
/// get select arguments
////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_get_select_arguments') ): 
    function wpestate_get_select_arguments(){
        $args = array(
                'hide_empty'    => true  ,
                'hierarchical'  => false,
                'pad_counts '   => true,
                'parent'        => 0
                ); 

        $show_empty_city_status = esc_html ( get_option('wp_estate_show_empty_city','') );
        if ($show_empty_city_status=='yes'){
            $args = array(
                'hide_empty'    => false  ,
                'hierarchical'  => false,
                'pad_counts '   => true,
                'parent'        => 0
                ); 
        }
        return $args;
    }
endif;
////////////////////////////////////////////////////////////////////////////////
/// show hieracy action
////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_get_action_select_list') ): 
    function wpestate_get_action_select_list($args){
        $categ_select_list  =   get_transient('wpestate_get_action_select_list');
        if($categ_select_list===false){
            $taxonomy           =   'property_action_category';
            $categories          =   get_terms($taxonomy,$args);

            $categ_select_list =   ' <li role="presentation" data-value="all">'. __('All Actions','wpestate').'</li>';
            foreach ($categories as $categ) {
                $received = wpestate_hierarchical_category_childen($taxonomy, $categ->term_id,$args ); 
                $counter = $categ->count;
                if(isset($received['count'])){
                    $counter = $counter+$received['count'];
                }

                $categ_select_list     .=   '<li role="presentation" data-value="'.$categ->slug.'">'. ucwords ( urldecode( $categ->name ) ).' ('.$counter.')'.'</li>';
                if(isset($received['html'])){
                    $categ_select_list     .=   $received['html'];  
                }

            }
        set_transient('wpestate_get_action_select_list',$categ_select_list,4*60*60);
        }
        return $categ_select_list;
    }
endif;


////////////////////////////////////////////////////////////////////////////////
/// universal function to get taxonomy dropdown
////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_get_taxonomy_select_list') ): 
    function wpestate_get_taxonomy_select_list( $args, $taxonomy, $non_option_title ){
        
		$data_value = array();
		
        $categories         =   get_terms($taxonomy,$args);    
        $categ_select_list  =  '<li role="presentation" data-value="all">'. $non_option_title.'</li>'; 

        foreach ($categories as $categ) {
			$data_value[] = array('slug' => $categ->slug, 'text' => ucwords ( urldecode( $categ->name ) ) );
            $counter = $categ->count;
            $received = wpestate_hierarchical_category_childen($taxonomy, $categ->term_id,$args ); 
         
            if(isset($received['count'])){
                $counter = $counter+$received['count'];
            }
            
            $categ_select_list     .=   '<li role="presentation" data-value="'.$categ->slug.'">'. ucwords ( urldecode( $categ->name ) ).' ('.$counter.')'.'</li>';
            if(isset($received['html'])){
                $categ_select_list     .=   $received['html'];  
            }
            
        }
        return array( 'text' =>  $categ_select_list, 'values' => $data_value);
    }
endif;








////////////////////////////////////////////////////////////////////////////////
/// show hieracy categ
////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_get_category_select_list') ): 
    function wpestate_get_category_select_list($args){
        $categ_select_list  =   get_transient('wpestate_get_category_select_list');
        
        if($categ_select_list===false){

            $taxonomy           =   'property_category';
            $categories         =   get_terms($taxonomy,$args);

            $categ_select_list  =  '<li role="presentation" data-value="all">'. __('All Types','wpestate').'</li>'; 

            foreach ($categories as $categ) {
                $counter = $categ->count;
                $received = wpestate_hierarchical_category_childen($taxonomy, $categ->term_id,$args ); 


                if(isset($received['count'])){
                    $counter = $counter+$received['count'];
                }

                $categ_select_list     .=   '<li role="presentation" data-value="'.$categ->slug.'">'. ucwords ( urldecode( $categ->name ) ).' ('.$counter.')'.'</li>';
                if(isset($received['html'])){
                    $categ_select_list     .=   $received['html'];  
                }

            }
        set_transient('wpestate_get_category_select_list',$categ_select_list,4*60*60);
        }
        return $categ_select_list;
    }
endif;

////////////////////////////////////////////////////////////////////////////////
/// show hieracy categeg
////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_hierarchical_category_childen') ): 
    function wpestate_hierarchical_category_childen($taxonomy, $cat,$args,$base=1,$level=1  ) {
        $level++;
        $args['parent']             =   $cat;
        $children                   =   get_terms($taxonomy,$args);
        $return_array=array();
        $total_main[$level]=0;
        $children_categ_select_list =   '';
        foreach ($children as $categ) {
            
            $area_addon =   '';
            $city_addon =   '';

            if($taxonomy=='property_city'){
				
				$term_meta      =   get_option( "taxonomy_$categ->term_id");
			
				$string_county  = '';
				if( isset( $term_meta['stateparent'] ) ){
					$string_county         =   wpestate_limit45 ( sanitize_title ( $term_meta['stateparent'] ) );  
				}
				$slug_county           =   sanitize_key($string_county);
				
				
                $string       =     wpestate_limit45 ( sanitize_title ( $categ->slug ) );              
                $slug         =     sanitize_key($string);
                $city_addon   =     '  data-parentcounty="' . $slug_county  . '" data-value2="'.$slug.'" ';
            }

            if($taxonomy=='property_area'){
                $term_meta    =   get_option( "taxonomy_$categ->term_id");
                $string       =   wpestate_limit45 ( sanitize_title ( $term_meta['cityparent'] ) );              
                $slug         =   sanitize_key($string);
                $area_addon   =   ' data-parentcity="' . $slug . '" ';

            }  
            
            $hold_base=  $base;
            $base_string='';
            $base++;
            $hold_base=  $base;
            
            if($level==2){
                $base_string='-';
            }else{
                $i=2;
                $base_string='';
                while( $i <= $level ){
                    $base_string.='-';
                    $i++;
                }
              
            }
    
            
            if($categ->parent!=0){
                $received =wpestate_hierarchical_category_childen( $taxonomy, $categ->term_id,$args,$base,$level ); 
            }
            
            
            $counter = $categ->count;
            if(isset($received['count'])){
                $counter = $counter+$received['count'];
            }
            
            $children_categ_select_list     .=   '<li role="presentation" data-value="'.$categ->slug.'" '.$city_addon.' '.$area_addon.' > '.$base_string.' '. ucwords ( urldecode( $categ->name ) ).' ('.$counter.')'.'</li>';
           
            if(isset($received['html'])){
                $children_categ_select_list     .=   $received['html'];  
            }
          
            $total_main[$level]=$total_main[$level]+$counter;
            
            $return_array['count']=$counter;
            $return_array['html']=$children_categ_select_list;
            
            
        }
      //  return $children_categ_select_list;
 
        $return_array['count']=$total_main[$level];
    
     
        return $return_array;
    }
endif;


////////////////////////////////////////////////////////////////////////////////
/// show hieracy city
////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_get_city_select_list') ): 
    function wpestate_get_city_select_list($args){
        $categ_select_list = get_transient('wpestate_get_city_select_list');
     
        if($categ_select_list===false){
     
            $categ_select_list   =    '<li role="presentation" data-value="all" data-value2="all">'. __('All Cities','wpestate').'</li>';
            $taxonomy           =   'property_city';
            $categories     =   get_terms($taxonomy,$args);

            foreach ($categories as $categ) {
                $string     =   wpestate_limit45 ( sanitize_title ( $categ->slug ) );   
                $slug       =   sanitize_key($string);
                $received   =   wpestate_hierarchical_category_childen($taxonomy, $categ->term_id,$args ); 
                $counter    =   $categ->count;
                if( isset($received['count'])   ){
                    $counter = $counter+$received['count'];
                }
                $slug_county='';
                $term_meta      =   get_option( "taxonomy_$categ->term_id");
                if( isset( $term_meta['stateparent'] ) ){
                    $string_county          =   wpestate_limit45 ( sanitize_title ( $term_meta['stateparent'] ) );  
                    $slug_county            =   sanitize_key($string_county);
                }

                $categ_select_list  .=  '<li role="presentation" data-value="'.$categ->slug.'" data-value2="'.$slug.'" data-parentcounty="'.$slug_county.'">'. ucwords ( urldecode( $categ->name ) ).' ('.$counter.')'.'</li>';
                if(isset($received['html'])){
                    $categ_select_list     .=   $received['html'];  
                }
           
            }
        set_transient('wpestate_get_city_select_list',$categ_select_list,4*60*60);
        }
        return $categ_select_list;
    }
endif;



////////////////////////////////////////////////////////////////////////////////
/// show hieracy area county state
////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_get_county_state_select_list') ): 
function wpestate_get_county_state_select_list($args){
    
    $categ_select_list = get_transient('wpestate_get_county_state_select_list');
    if($categ_select_list===false){
        $categ_select_list  =   '<li role="presentation" data-value="all" data-value2="all">'.__('All Counties/States','wpestate').'</li>';
        $taxonomy           =   'property_county_state';
        $categories         =   get_terms($taxonomy,$args);

        foreach ($categories as $categ) {
            $string     =   wpestate_limit45 ( sanitize_title ( $categ->slug ) );              
            $slug       =   sanitize_key($string);
            $received   =   wpestate_hierarchical_category_childen($taxonomy, $categ->term_id,$args ); 
            $counter    =   $categ->count;
            if( isset($received['count'])   ){
                $counter = $counter+$received['count'];
            }

            $categ_select_list  .=  '<li role="presentation" data-value="'.$categ->slug.'" data-value2="'.$slug.'">'. ucwords ( urldecode( $categ->name ) ).' ('.$counter.')'.'</li>';
            if(isset($received['html'])){
                $categ_select_list     .=   $received['html'];  
            }
         

        }
    set_transient('wpestate_get_county_state_select_list',$categ_select_list,4*60*60);
    }
    return $categ_select_list;
}
endif;


////////////////////////////////////////////////////////////////////////////////
/// show hieracy area
////////////////////////////////////////////////////////////////////////////////


if( !function_exists('wpestate_get_area_select_list') ): 
function wpestate_get_area_select_list($args){
    $categ_select_list = get_transient('wpestate_get_area_select_list');
    if($categ_select_list===false){
            

        $categ_select_list  =   '<li role="presentation" data-value="all">'.__('All Areas','wpestate').'</li>';
        $taxonomy           =   'property_area';
        $categories         =   get_terms($taxonomy,$args);

        foreach ($categories as $categ) {
            $term_meta      =   get_option( "taxonomy_$categ->term_id");
            $string         =   wpestate_limit45 ( sanitize_title ( $term_meta['cityparent'] ) );              
            $slug           =   sanitize_key($string);
            $received       =   wpestate_hierarchical_category_childen($taxonomy, $categ->term_id,$args ); 
            $counter        =   $categ->count;
            if( isset($received['count'])   ){
                $counter = $counter+$received['count'];
            }

            $categ_select_list  .=  '<li role="presentation" data-value="'.$categ->slug.'" data-parentcity="' . $slug . '">'. ucwords ( urldecode( $categ->name ) ).' ('.$counter.')'.'</li>';
            if(isset($received['html'])){
                $categ_select_list     .=   $received['html'];  
            }

        }
    set_transient('wpestate_get_area_select_list',$categ_select_list,4*60*60);  
    }  
    return $categ_select_list;
}
endif;



////////////////////////////////////////////////////////////////////////////////
/// show name on saved searches
////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_get_custom_field_name') ): 
function wpestate_get_custom_field_name($query_name,$adv_search_what,$adv_search_label){
    $i=0;


    if( is_array($adv_search_what) && !empty($adv_search_what) ){
        foreach($adv_search_what as $key=>$term){    
            $term         =   str_replace(' ', '_', $term);
            $slug         =   wpestate_limit45(sanitize_title( $term )); 
            $slug         =   sanitize_key($slug); 

            if($slug==$query_name){
                return  $adv_search_label[$key];
            }
            $i++;
        }
    }
    
    
    $advanced_exteded   =   get_option( 'wp_estate_advanced_exteded', true); 
    foreach($advanced_exteded as $checker => $value){
            $post_var_name  =   str_replace(' ','_', trim($value) );
            $input_name     =   wpestate_limit45(sanitize_title( $post_var_name ));
            $input_name     =   sanitize_key($input_name);
            if($input_name==$query_name){
                return  $value;
            }
    }
    
   
    
    return $query_name;
}
endif;

////////////////////////////////////////////////////////////////////////////////
/// get author
////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpsestate_get_author') ): 
    function wpsestate_get_author( $post_id = 0 ){
        $post = get_post( $post_id );
        wp_reset_postdata();
        wp_reset_query();
        return $post->post_author;
    }
endif;

////////////////////////////////////////////////////////////////////////////////
/// show stripe form per listing
////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_show_stripe_form_per_listing') ): 
function wpestate_show_stripe_form_per_listing($stripe_class,$post_id,$price_submission,$price_featured_submission){
    require_once(get_template_directory().'/libs/stripe/lib/Stripe.php');
    $stripe_secret_key              =   esc_html( get_option('wp_estate_stripe_secret_key','') );
    $stripe_publishable_key         =   esc_html( get_option('wp_estate_stripe_publishable_key','') );

    $stripe = array(
      "secret_key"      => $stripe_secret_key,
      "publishable_key" => $stripe_publishable_key
    );

    Stripe::setApiKey($stripe['secret_key']);
    $processor_link             =   wpestate_get_template_link('stripecharge.php');
    $submission_curency_status  =   esc_html( get_option('wp_estate_submission_curency','') );
    $current_user               =   wp_get_current_user();
    $userID                     =   $current_user->ID ;
    $user_email                 =   $current_user->user_email ;

    $price_submission_total =   $price_submission+$price_featured_submission;
    $price_submission_total =   $price_submission_total*100;
    $price_submission       =   $price_submission*100;
    print ' 
    <div class="stripe-wrapper '.$stripe_class.'">    
    <form action="'.$processor_link.'" method="post" class="stripe_form_simple">
        <div class="stripe_simple">
            <script src="https://checkout.stripe.com/checkout.js" 
            class="stripe-button"
            data-key="'. $stripe_publishable_key.'"
            data-amount="'.$price_submission.'" 
            data-email="'.$user_email.'"
            data-zip-code="true"
            data-locale="auto"
            data-currency="'.$submission_curency_status.'"
            data-label="'.__('Pay with Credit Card','wpestate').'"
            data-description="'.__('Submission Payment','wpestate').'">
            </script>
        </div>
        <input type="hidden" id="propid" name="propid" value="'.$post_id.'">
        <input type="hidden" id="submission_pay" name="submission_pay" value="1">
        <input type="hidden" name="userID" value="'.$userID.'">
        <input type="hidden" id="pay_ammout" name="pay_ammout" value="'.$price_submission.'">
    </form>

    <form action="'.$processor_link.'" method="post" class="stripe_form_featured">
        <div class="stripe_simple">
            <script src="https://checkout.stripe.com/checkout.js" 
            class="stripe-button"
            data-key="'. $stripe_publishable_key.'"
            data-amount="'.$price_submission_total.'" 
            data-email="'.$user_email.'"
            data-zip-code="true"
            data-locale="auto"
            data-currency="'.$submission_curency_status.'"
            data-label="'.__('Pay with Credit Card','wpestate').'"
            data-description="'.__('Submission & Featured Payment','wpestate').'">
            </script>
        </div>
        <input type="hidden" id="propid" name="propid" value="'.$post_id.'">
        <input type="hidden" id="submission_pay" name="submission_pay" value="1">
        <input type="hidden" id="featured_pay" name="featured_pay" value="1">
        <input type="hidden" name="userID" value="'.$userID.'">
        <input type="hidden" id="pay_ammout" name="pay_ammout" value="'.$price_submission_total.'">
    </form>
    </div>';
}
endif;



////////////////////////////////////////////////////////////////////////////////
/// show stripe form membership
////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_show_stripe_form_membership') ): 
    function wpestate_show_stripe_form_membership(){
        require_once(get_template_directory().'/libs/stripe/lib/Stripe.php');

        $current_user = wp_get_current_user();
        //  get_currentuserinfo();
        $userID                 =   $current_user->ID;
        $user_login             =   $current_user->user_login;
        $user_email             =   get_the_author_meta( 'user_email' , $userID );

        $stripe_secret_key              =   esc_html( get_option('wp_estate_stripe_secret_key','') );
        $stripe_publishable_key         =   esc_html( get_option('wp_estate_stripe_publishable_key','') );

        $stripe = array(
          "secret_key"      => $stripe_secret_key,
          "publishable_key" => $stripe_publishable_key
        );
        $pay_ammout=9999;
        $pack_id='11';
        Stripe::setApiKey($stripe['secret_key']);
        $processor_link             =   wpestate_get_template_link('stripecharge.php');
        $submission_curency_status  =   esc_html( get_option('wp_estate_submission_curency','') );


        print ' 
        <form action="'.$processor_link.'" method="post" id="stripe_form">';
           // '.wpestate_get_stripe_buttons($user_email,$submission_curency_status).'
            
        //'.  sanitize_title($title).'
        // data-amount= price  $pack_price         = get_post_meta($postid, 'pack_price', true)*100;
       //   data-description=""
        print '<div class="stripe_buttons" id="">
                            <script src="https://checkout.stripe.com/checkout.js" id="stripe_script"
                            class="stripe-button"
                            data-key="'. $stripe['publishable_key'].'"
                            data-amount="" 
                            data-email="'.$user_email.'"
                            data-currency="'.$submission_curency_status.'"
                            data-zip-code="true"
                            data-locale="auto"
                            data-billing-address="true"
                            data-label="'.__('Pay with Credit Card','wpestate').'"
                            data-description="">
                            </script>
                        </div>
        '; 
        print'   
            <input type="hidden" id="pack_id" name="pack_id" value="'.$pack_id.'">
            <input type="hidden" name="userID" value="'.$userID.'">
            <input type="hidden" id="pay_ammout" name="pay_ammout" value="'.$pay_ammout.'">
        </form>';
    }
endif;




if( !function_exists('wpestate_get_stripe_buttons') ): 
    function wpestate_get_stripe_buttons($stripe_pub_key,$user_email,$submission_curency_status){
        wp_reset_query();
        $buttons='';
        $args = array(
            'post_type' => 'membership_package',
            'meta_query' => array(
                                 array(
                                     'key' => 'pack_visible',
                                     'value' => 'yes',
                                     'compare' => '=',
                                 )
                              )
            );
            $pack_selection = new WP_Query($args);
            $i=0;        
            while($pack_selection->have_posts() ){
                 $pack_selection->the_post();
                        $postid             = get_the_ID();

                        $pack_price         = get_post_meta($postid, 'pack_price', true)*100;
                        $title=get_the_title();
                        if($i==0){
                            $visible_stripe=" visible_stripe ";
                        }else{
                            $visible_stripe ='';
                        }
                        $i++;
                        $buttons.='
                        <div class="stripe_buttons '.$visible_stripe.' " id="'.  sanitize_title($title).'">
                            <script src="https://checkout.stripe.com/checkout.js" id="stripe_script"
                            class="stripe-button"
                            data-key="'. $stripe_pub_key.'"
                            data-amount="'.$pack_price.'" 
                            data-email="'.$user_email.'"
                            data-currency="'.$submission_curency_status.'"
                            data-zip-code="true"
                            data-locale="auto"
                            data-billing-address="true"
                            data-label="'.__('Pay with Credit Card','wpestate').'"
                            data-description="'.$title.' '.__('Package Payment','wpestate').'">
                            </script>
                        </div>';         
            }
            wp_reset_query();
        return $buttons;
    }
endif;





if( !function_exists('wpestate_email_to_admin') ): 
    function wpestate_email_to_admin($onlyfeatured){


            $headers = 'From: No Reply <noreply@'.$_SERVER['HTTP_HOST'].'>' . "\r\n";
            $message  = __('Hi there,','wpestate') . "\r\n\r\n";

            if($onlyfeatured==1){
                
                $arguments=array();
                wpestate_select_email_type(get_option('admin_email'),'featured_submission',$arguments); 
                
                
            }else{
                
                $arguments=array();
                wpestate_select_email_type(get_option('admin_email'),'paid_submissions',$arguments); 
                
            }


         

    }
endif;



if( !function_exists('wpestate_show_stripe_form_upgrade') ): 
function    wpestate_show_stripe_form_upgrade($stripe_class,$post_id,$price_submission,$price_featured_submission){
    require_once(get_template_directory().'/libs/stripe/lib/Stripe.php');
    $stripe_secret_key              =   esc_html( get_option('wp_estate_stripe_secret_key','') );
    $stripe_publishable_key         =   esc_html( get_option('wp_estate_stripe_publishable_key','') );

    $stripe = array(
      "secret_key"      => $stripe_secret_key,
      "publishable_key" => $stripe_publishable_key
    );

    Stripe::setApiKey($stripe['secret_key']);
    $processor_link         =   wpestate_get_template_link('stripecharge.php');
    $current_user           =   wp_get_current_user();
    $userID                 =   $current_user->ID ;
    $user_email             =   $current_user->user_email ;

    $submission_curency_status  =   esc_html( get_option('wp_estate_submission_curency','') );
    $price_featured_submission  =   $price_featured_submission*100;

    print ' 
    <div class="stripe_upgrade">    
    <form action="'.$processor_link.'" method="post" >
    <div class="stripe_simple upgrade_stripe">
        <script src="https://checkout.stripe.com/checkout.js" 
        class="stripe-button"
        data-key="'. $stripe_publishable_key.'"
        data-amount="'.$price_featured_submission.'" 
        data-zip-code="true"
        data-locale="auto"
        data-email="'.$user_email.'"
        data-currency="'.$submission_curency_status.'"
        data-panel-label="'.__('Upgrade to Featured','wpestate').'"
        data-label="'.__('Upgrade to Featured','wpestate').'"
        data-description="'.__(' Featured Payment','wpestate').'">

        </script>
    </div>
    <input type="hidden" id="propid" name="propid" value="'.$post_id.'">
    <input type="hidden" id="submission_pay" name="submission_pay" value="1">
    <input type="hidden" id="is_upgrade" name="is_upgrade" value="1">
    <input type="hidden" name="userID" value="'.$userID.'">
    <input type="hidden" id="pay_ammout" name="pay_ammout" value="'.$price_featured_submission.'">
    </form>
    </div>';
}
endif;




///////////////////////////////////////////////////////////////////////////////////////////
// dasboaord search link
///////////////////////////////////////////////////////////////////////////////////////////



if( !function_exists('get_dasboard_searches_link') ):
function get_dasboard_searches_link(){
    $pages = get_pages(array(
            'meta_key' => '_wp_page_template',
            'meta_value' => 'user_dashboard_search_result.php'
        ));

    if( $pages ){
        $dash_link = get_permalink( $pages[0]->ID);
    }else{
        $dash_link=home_url();
    }  
    
    return $dash_link;
}
endif; // end     
         



if( !function_exists('wpestate_is_user_dashboard') ):
function wpestate_is_user_dashboard(){
   
    if ( basename( get_page_template() ) == 'user_dashboard.php'          || 
        basename( get_page_template() ) == 'user_dashboard_add.php'      ||
        basename( get_page_template() ) == 'user_dashboard_profile.php'  ||
        basename( get_page_template() ) == 'user_dashboard_favorite.php' ||
        basename( get_page_template() ) == 'user_dashboard_searches.php' ||
        basename( get_page_template() ) == 'user_dashboard_floor.php' ||
        basename( get_page_template() ) == 'user_dashboard_search_result.php' ||
        basename( get_page_template() ) == 'user_dashboard_invoices.php' ||
        basename( get_page_template() ) == 'user_dashboard_add_agent.php' ||
        basename( get_page_template() ) == 'user_dashboard_agent_list.php' || 
        basename( get_page_template() ) == 'user_dashboard_inbox.php'
        ){
     
        return true;
    }else{
        return false;
    }
        
   


}
endif;


if( !function_exists('wpestate_get_meaurement_unit_formated') ):
function wpestate_get_meaurement_unit_formated( $show_default = 0 ){
   
	$basic_measure = esc_html( get_option('wp_estate_measure_sys','') );
	if( isset( $_COOKIE['my_measure_unit'] ) ){
		$selected_measure = esc_html( $_COOKIE['my_measure_unit'] );
	}else{
		$selected_measure = $basic_measure;
	}
  
        if( $show_default == 1 ){
            $selected_measure = $basic_measure;
        }
   
	$measure_array=array( 		
		array( 'name' => __('feet','wpestate'), 'unit'  => __('ft','wpestate'), 'is_square' => 0 ),
		array( 'name' => __('meters','wpestate'), 'unit'  => __('m','wpestate'), 'is_square' => 0 ),
		array( 'name' => __('acres','wpestate'), 'unit'  => __('ac','wpestate'), 'is_square' => 1 ),
		array( 'name' => __('yards','wpestate'), 'unit'  => __('yd','wpestate'), 'is_square' => 0 ),
		array( 'name' => __('hectares','wpestate'), 'unit'  => __('ha','wpestate'), 'is_square' => 1 ),
	);
  
  
        // getting unit
	foreach($measure_array as $single_unit ){
            if( $single_unit['unit'] == $selected_measure  ){
                if( $single_unit['is_square'] === 1 ){
                    $measure_unit   =   $single_unit['unit'];
                }else{
                    $measure_unit   =   $single_unit['unit'].'<sup>2</sup>';
                }
            }
	}
   return  $measure_unit;
}
endif;


if( !function_exists('wpestate_get_converted_measure') ):
    function wpestate_return_measurement_sys(){
        if( isset( $_COOKIE['my_measure_unit'] ) ){
            $to_return=' '. esc_html( $_COOKIE['my_measure_unit'] );
            if($_COOKIE['my_measure_unit']=='ft' || $_COOKIE['my_measure_unit']=='m' || $_COOKIE['my_measure_unit']=='yd'){
                $to_return.='<sup>2</sup>';
                return $to_return;
            }
            if($_COOKIE['my_measure_unit']=='ac' || $_COOKIE['my_measure_unit']=='ha'  ){
              
                return $to_return;
            }
        }else{
            $measure = get_option('wp_estate_measure_sys','');
            if($measure=='ft' || $measure=='m' || $measure=='yd'){
                $measure.='<sup>2</sup>';
            }
            return  $measure;
        }        
    }
endif;

if( !function_exists('wpestate_get_converted_measure') ):
    function wpestate_convert_measure($value,$reverse=''){
        $recalculation_table = array(
                'ftft' => 1,
                'ftm' => 0.092903,
                'ftac' => 0.000022957,
                'ftyd' => 0.111111,
                'ftha' => 0.0000092903,

                'mm' => 1,
                'mft' => 10.7639,
                'mac' => 0.000247105,
                'myd' => 1.19599,
                'mha' => 0.0001,

                'acac' => 1,
                'acft' => 43560,
                'acm' => 4046.86,
                'acyd' => 4840,
                'acha' => 0.404686,

                'ydyd' => 1,
                'ydft' => 9,
                'ydm' => 0.836127,
                'ydac' => 0.000206612,
                'ydha' => 0.000083613,


                'haha' => 1,
                'haft' => 107639,
                'ham' => 10000,
                'haac' => 2.47105,
                'hayd' => 11959.9,

           );
   
	$basic_measure = esc_html( get_option('wp_estate_measure_sys','') );
	if( isset( $_COOKIE['my_measure_unit'] ) ){
            $selected_measure = esc_html( $_COOKIE['my_measure_unit'] );
	}else{
            $selected_measure = $basic_measure;
	}
      
        $size_value  = $value * $recalculation_table[ $basic_measure.$selected_measure ];
        if($reverse==1){
             $size_value  = $value * $recalculation_table[ $selected_measure.$basic_measure ];
        }
        
        return $size_value;
    }
endif;





if( !function_exists('wpestate_get_converted_measure') ):
function wpestate_get_converted_measure( $post_id, $meta_key ){
   
    $size_value = get_post_meta($post_id, $meta_key, true) ;
    if( $size_value == '' || !$size_value ){
            return false;
    }

    $measure_array=array( 		
            array( 'name' => __('feet','wpestate'), 'unit'  => __('ft','wpestate'), 'is_square' => 0 ),
            array( 'name' => __('meters','wpestate'), 'unit'  => __('m','wpestate'), 'is_square' => 0 ),
            array( 'name' => __('acres','wpestate'), 'unit'  => __('ac','wpestate'), 'is_square' => 1 ),
            array( 'name' => __('yards','wpestate'), 'unit'  => __('yd','wpestate'), 'is_square' => 0 ),
            array( 'name' => __('hectares','wpestate'), 'unit'  => __('ha','wpestate'), 'is_square' => 1 ),
    );

   
   $recalculation_table = array(
	__('ft','wpestate').__('ft','wpestate') => 1,
	__('ft','wpestate').__('m','wpestate') => 0.092903,
	__('ft','wpestate').__('ac','wpestate') => 0.000022957,
	__('ft','wpestate').__('yd','wpestate') => 0.111111,
	__('ft','wpestate').__('ha','wpestate') => 0.0000092903,
	
	__('m','wpestate').__('m','wpestate') => 1,
	__('m','wpestate').__('ft','wpestate') => 10.7639,
	__('m','wpestate').__('ac','wpestate') => 0.000247105,
	__('m','wpestate').__('yd','wpestate') => 1.19599,
	__('m','wpestate').__('ha','wpestate')=> 0.0001,
	
	__('ac','wpestate').__('ac','wpestate') => 1,
	__('ac','wpestate').__('ft','wpestate')=> 43560,
	__('ac','wpestate').__('m','wpestate') => 4046.86,
	__('ac','wpestate').__('yd','wpestate') => 4840,
	__('ac','wpestate').__('ha','wpestate') => 0.404686,
	
	__('yd','wpestate').__('yd','wpestate') => 1,
	__('yd','wpestate').__('ft','wpestate') => 9,
	__('yd','wpestate').__('m','wpestate')=> 0.836127,
	__('yd','wpestate').__('ac','wpestate') => 0.000206612,
	__('yd','wpestate').__('ha','wpestate') => 0.000083613,
	
	
	__('ha','wpestate').__('ha','wpestate') => 1,
	__('ha','wpestate').__('ft','wpestate') => 107639,
	__('ha','wpestate').__('m','wpestate') => 10000,
	__('ha','wpestate').__('ac','wpestate') => 2.47105,
	__('ha','wpestate').__('yd','wpestate') => 11959.9,
	
   );
   
   
	$basic_measure = esc_html( get_option('wp_estate_measure_sys','') );
	if( isset( $_COOKIE['my_measure_unit'] ) ){
            $selected_measure = esc_html( $_COOKIE['my_measure_unit'] );
	}else{
            $selected_measure = $basic_measure;
	}

	// getting unit
	foreach($measure_array as $single_unit ){
            if( $single_unit['unit'] == $selected_measure  ){
                if( $single_unit['is_square'] === 1 ){
                        $measure_unit   =   $single_unit['unit'];
                }else{
                        $measure_unit   =   $single_unit['unit'].'<sup>2</sup>';
                }
            }
	}

	$size_value  = $size_value * $recalculation_table[ $basic_measure.$selected_measure ];
	
	$size_value = number_format( $size_value, 2, ',', ' ');
	
	return $size_value.' '.$measure_unit;
}
endif;

?>