<?php

///////////////////////////////////////////////////////////////////////////////////////////
/////// Js & Css include on front site 
///////////////////////////////////////////////////////////////////////////////////////////



if( !function_exists('wpestate_scripts') ):
function wpestate_scripts() {   
    
    global $post;
    $custom_image               =   '';
    $use_idx_plugins            =   0;
    $header_type                =   '';
    $idx_status                 =   esc_html ( get_option('wp_estate_idx_enable','') );   
    $adv_search_type_status     =   intval   ( get_option('wp_estate_adv_search_type',''));
    $home_small_map_status      =   esc_html ( get_option('wp_estate_home_small_map','') );
        
    if($idx_status=='yes'){
        $use_idx_plugins=1;
    }
   
    if( isset($post->ID) ) {
         $header_type                =   get_post_meta ( $post->ID, 'header_type', true);
    }
   
    $global_header_type         =   get_option('wp_estate_header_type','');
    $listing_map                =   'internal';
<<<<<<< HEAD
    //print 'xxxx '.$header_type.' / '.$global_header_type;
    
    // if( $header_type==5 || $global_header_type==4 ){
    //    $listing_map            =   'top';        
    // }
=======
  
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
   
    if( $header_type==0 ){
        if($global_header_type==4){
            $listing_map            =   'top'; 
        }
    }else if ( $header_type==5 ){
<<<<<<< HEAD
          $listing_map            =   'top'; 
    }
   
=======
        $listing_map            =   'top'; 
    }
   
    if( is_tax() &&  intval(get_option('wp_estate_property_list_type','') )==2 ){
        $global_header_type=4;
    }
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    
    $slugs=array();
    $hows=array();
    $show_price_slider          =   'no';
    $slider_price_position      =   0;
            
    $custom_advanced_search= get_option('wp_estate_custom_advanced_search','');
    if ( $custom_advanced_search == 'yes'){
<<<<<<< HEAD
=======
        
        
        
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
            $adv_search_what        =   get_option('wp_estate_adv_search_what','');
            $adv_search_label       =   get_option('wp_estate_adv_search_label','');
            $adv_search_how         =   get_option('wp_estate_adv_search_how','');
            $show_price_slider       =   get_option('wp_estate_show_slider_price','');
<<<<<<< HEAD
=======
            
          
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
            $slider_price_position  =   0;
            $counter                =   0;
            foreach($adv_search_what as $key=>$search_field){
                $counter++;
                if($search_field=='types'){  
                    $slugs[]='adv_actions';
                }
                else if($search_field=='categories'){
                    $slugs[]='adv_categ';
                }  
                else if($search_field=='cities'){
                    $slugs[]='advanced_city';
                } 
                else if($search_field=='areas'){
                    $slugs[]='advanced_area';
                }
                else if($search_field=='county / state'){
                    $slugs[]='county-state';
                } 
                else if($search_field=='property country'){
                    $slugs[]='property-country';
                }else if (  $search_field=='property price' && $show_price_slider=='yes' ){
                    $slugs[]='property_price';
<<<<<<< HEAD
                    $slugs[]='property_price';
=======
                    // $slugs[]='property_price';
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
                    $slider_price_position=$counter ;
                    
                }
                else { 
<<<<<<< HEAD
                     // $slug=str_replace(' ','_',$search_field);
                        //$slug         =   wpestate_limit45(sanitize_title( $search_field )); 
                       // $slug         =   sanitize_key($slug);
                        
                      //  $slug=str_replace(' ','_',$search_field);
                      
                        $string       =   wpestate_limit45 ( sanitize_title ($adv_search_label[$key]) );              
                        $slug         =   sanitize_key($string);
                                            
                      $slugs[]=$slug;
=======
                    $string       =    wpestate_limit45( sanitize_title ($adv_search_label[$key]) );              
                    $slug         =   sanitize_key($string);
                    $slugs[]=$slug;
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
                 }
            }
          
            foreach($adv_search_how as $key=>$search_field){
                $hows[]= $adv_search_how[$key];
                
            }
<<<<<<< HEAD
    }
    

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // load the css files
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    wp_enqueue_style('wpestate_style',get_stylesheet_uri(), array(), '1.0', 'all');  
    wp_enqueue_style('wpestate_media',get_template_directory_uri().'/css/my_media.css', array(), '1.0', 'all'); 
    wp_enqueue_style('prettyphoto',get_template_directory_uri().'/css/prettyphoto.css', array(), '1.0', 'all'); 
    
=======
            
    }
    
    $use_mimify     =   get_option('wp_estate_use_mimify','');
    $mimify_prefix  =   '';
    if($use_mimify==='yes'){
        $mimify_prefix  =   '.min';    
    }
    
    
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // load the css files
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
     
    if($mimify_prefix===''){
        wp_enqueue_style('wpestate_style',get_stylesheet_uri(), array(), '1.0', 'all');  
    }else{
        wp_enqueue_style('wpestate_style',get_template_directory_uri().'/style.min.css', array(), '1.0', 'all');  
    }
   
    wp_enqueue_style('wpestate_media',get_template_directory_uri().'/css/my_media'.$mimify_prefix.'.css', array(), '1.0', 'all'); 
    //wp_enqueue_style('wip',get_template_directory_uri().'/wip.css', array(), '1.0', 'all'); 

    $protocol = is_ssl() ? 'https' : 'http';
    $general_font = esc_html( get_option('wp_estate_general_font', '') );
    
    $headings_font_subset   =   esc_html ( get_option('wp_estate_headings_font_subset','') );
    if($headings_font_subset!=''){
        $headings_font_subset='&amp;subset='.$headings_font_subset;
    }
    
    // embed custom fonts from admin
    if($general_font && $general_font!='x'){
        $general_font =  str_replace(' ', '+', $general_font);
        wp_enqueue_style( 'wpestate-custom-font',"https://fonts.googleapis.com/css?family=$general_font:400,500,300$headings_font_subset");  
    }else{
        wp_enqueue_style( 'wpestate-opensans', "https://fonts.googleapis.com/css?family=Open+Sans:400,600,300,700,800&amp;subset=latin,latin-ext" );
    }
   
    $headings_font = esc_html( get_option('wp_estate_headings_font', '') );
    if($headings_font && $headings_font!='x'){
       $headings_font =  str_replace(' ', '+', $headings_font);
       wp_enqueue_style( 'wpestate-custom-secondary-font', "https://fonts.googleapis.com/css?family=$headings_font:400,500,300" );  
    }
    
    wp_enqueue_style( 'font-awesome.min',  get_template_directory_uri() . '/css/fontawesome/css/font-awesome.min.css' );  
    wp_enqueue_style( 'fontello',  get_template_directory_uri() . '/css/fontello.min.css' );  
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // load the general js files
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    wp_enqueue_script("jquery");
    wp_enqueue_script("jquery-ui-draggable");
    wp_enqueue_script("jquery-ui-autocomplete");
    wp_enqueue_script("jquery-ui-slider");
<<<<<<< HEAD
    if( is_page_template('user-dashboard-profile.php')  ){
          //   wp_enqueue_script('plupload-handlers');
    }
     
    wp_enqueue_script('bootstrap', get_template_directory_uri().'/js/bootstrap.min.js',array(), '1.0', false);
    wp_enqueue_script('modernizr', get_template_directory_uri().'/js/modernizr.custom.62456.js',array(), '1.0', false);     
    wp_enqueue_script('jquery.prettyphoto', get_template_directory_uri().'/js/jquery.prettyphoto.js',array('jquery'), '1.0', true); 
    wp_enqueue_script('jquery.placeholders', get_template_directory_uri().'/js/placeholders.min.js',array('jquery'), '1.0', true);
  //  wp_enqueue_script('jquery.retina', get_template_directory_uri().'/js/retina-1.1.0.js',array('jquery'), '1.0', true);
    wp_enqueue_script('dense', get_template_directory_uri().'/js/dense.js',array('jquery'), '1.0', true);
    wp_enqueue_script("jquery-ui-datepicker");
  
=======
    wp_enqueue_script("jquery-ui-datepicker");
    
    if( get_option('wp_estate_use_optima','')!='yes'){
        wp_enqueue_script('bootstrap', get_template_directory_uri().'/js/bootstrap.min.js',array(), '1.0', false);
    }
    wp_enqueue_script('all_external', get_template_directory_uri().'/js/all_external.min.js',array(), '1.0', false); 
    // wp_enqueue_script('owl_carousel', get_template_directory_uri().'/js/owl.carousel.min.js',array(), '1.0', false); 
    //wp_enqueue_script('latinise.min', get_template_directory_uri().'/js/latinise.min_.js',array('jquery'), '1.0', true);
  
  
    if(get_option('wp_estate_use_captcha','')=='yes'){
        wp_enqueue_script('recaptcha', 'https://www.google.com/recaptcha/api.js?onload=wpestate_onloadCallback&render=explicit&hl=iw" async defer',array('jquery'), '1.0', true);        
    }
  
    if ( is_singular('estate_property') || is_page_template('user_dashboard.php')  ){
        wp_enqueue_script('jquery.chart.min', get_template_directory_uri().'/js/Chart.min.js',array('jquery'), '1.0', true);
      
    }
    
    
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    $date_lang_status= esc_html ( get_option('wp_estate_date_lang','') );
    
    if($date_lang_status!='xx'){
        $handle="datepicker-".$date_lang_status;
        $name="datepicker-".$date_lang_status.".js";
        wp_enqueue_script($handle, get_template_directory_uri().'/js/i18n/'.$name,array('jquery'), '1.0', true);
    }
    
<<<<<<< HEAD
    
    if ( is_page_template('user_dashboard_add.php') ){
=======
    if (function_exists('icl_translate') ){
        if(ICL_LANGUAGE_CODE!='en'){
            $handle="datepicker-".ICL_LANGUAGE_CODE ;
            $name="datepicker-".ICL_LANGUAGE_CODE.".js";
            wp_enqueue_script($handle, get_template_directory_uri().'/js/i18n/'.$name,array('jquery'), '1.0', true);
        }
        $date_lang_status=ICL_LANGUAGE_CODE;
    }
    
    
    
    
    if ( is_page_template('user_dashboard_add_agent.php') || is_page_template('user_dashboard_add.php') || 
            is_page_template('user_dashboard_profile.php') || is_page_template('front_property_submit.php') ){
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        wp_enqueue_script("jquery-ui-draggable");
        wp_enqueue_script("jquery-ui-sortable");              
    }
    
    wp_enqueue_script('touch-punch', get_template_directory_uri().'/js/jquery.ui.touch-punch.min.js',array('jquery'), '1.0', true);
    wp_enqueue_style('jquery.ui.theme', get_template_directory_uri() . '/css/jquery-ui.min.css');
<<<<<<< HEAD
  
    
=======
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
   
    $use_generated_pins =   0;
    $load_extra         =   0;
    $post_type          =   get_post_type();
<<<<<<< HEAD
    //is_page_template('advanced_search_results.php') ||
    if(  $post_type=='estate_agent' ){    // search results -> pins are added  from template   
=======
    
    
    
    if( is_page_template('advanced_search_results.php') || 
        is_page_template('property_list.php') || 
        //  is_page_template('property_list_directory.php') || 
        is_page_template('property_list_half.php') || 
        is_singular('estate_agent') || 
        is_singular('estate_property') || 
        is_tax() ){    // search results -> pins are added  from template   
       
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        $use_generated_pins=1;
        $json_string=array();
        $json_string=json_encode($json_string);
    }else{
<<<<<<< HEAD
         // google maps pins
        
        if ( get_option('wp_estate_readsys','') =='yes' ){
            $path=estate_get_pin_file_path();
            $json_string=file_get_contents($path);
            //print '<div style="width:100%;height:30px;background:red;">reading from file</div>';
        }else{
           // print '<div style="width:100%;height:30px;background:blue;">reading from database</div>';
            $json_string= wpestate_listing_pins();
=======
        // google maps pins
        if( $header_type==5 || $global_header_type==4 ){
            if ( get_option('wp_estate_readsys','') =='yes' ){
             
                $path=estate_get_pin_file_path();
                $json_string=file_get_contents($path);
                
                
                
                //print '<div style="width:100%;height:30px;background:red;">reading from file</div>';
            }else{
               // print '<div style="width:100%;height:30px;background:blue;">reading from database</div>';
                $json_string= wpestate_listing_pins();
            }
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        }
    }

   
    // load idx placing javascript 
    if($idx_status=='yes'){
<<<<<<< HEAD
       wp_enqueue_script('idx', get_template_directory_uri().'/js/google_js/idx.js',array('jquery'), '1.0', true); 
=======
       wp_enqueue_script('idx', get_template_directory_uri().'/js/google_js/idx'.$mimify_prefix.'.js',array('jquery'), '1.0', true); 
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    } 
    
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // load the Google Maps js files
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    $show_g_search_status= esc_html ( get_option('wp_estate_show_g_search','') );
<<<<<<< HEAD
    if($header_type==5 || $global_header_type==4 || is_page_template('user_dashboard_add.php') || is_single()){    
        if (esc_html ( get_option('wp_estate_ssl_map','') ) =='yes'){
            wp_enqueue_script('googlemap', 'https://maps-api-ssl.google.com/maps/api/js?libraries=places&amp;sensor=true&amp;key='.esc_html(get_option('wp_estate_api_key', '') ),array('jquery'), '1.0', false);        
        }else{
            wp_enqueue_script('googlemap', 'http://maps.googleapis.com/maps/api/js?libraries=places&amp;sensor=true&amp;key='.esc_html(get_option('wp_estate_api_key', '') ),array('jquery'), '1.0', false);        
        }
        
        wp_enqueue_script('infobox',  get_template_directory_uri() .'/js/infobox.js',array('jquery'), '1.0', true); 
=======
    if($header_type==5 || $global_header_type==4 || is_page_template('user_dashboard_add.php') || is_single() || is_page_template('user_dashboard_profile.php')   ){    
        if (esc_html ( get_option('wp_estate_ssl_map','') ) =='yes'){
            wp_enqueue_script('googlemap', 'https://maps-api-ssl.google.com/maps/api/js?v=3&libraries=places&amp;key='.esc_html(get_option('wp_estate_api_key', '') ),array('jquery'), '1.0', false);        
        }else{
            wp_enqueue_script('googlemap', 'http://maps.googleapis.com/maps/api/js?v=3&libraries=places&amp;key='.esc_html(get_option('wp_estate_api_key', '') ),array('jquery'), '1.0', false);        
        }
        
        wp_enqueue_script('infobox',  get_template_directory_uri() .'/js/infobox'.$mimify_prefix.'.js',array('jquery'), '1.0', true); 
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    }
   
    $pin_images=wpestate_pin_images();
    $geolocation_radius =   esc_html ( get_option('wp_estate_geolocation_radius','') );
    if ($geolocation_radius==''){
          $geolocation_radius =1000;
    }
    $pin_cluster_status =   esc_html ( get_option('wp_estate_pin_cluster','') );
    $zoom_cluster       =   esc_html ( get_option('wp_estate_zoom_cluster ','') );
    $show_adv_search    =   esc_html ( get_option('wp_estate_show_adv_search_map_close','') );
    
    if( isset($post->ID) ){
        $page_lat           =   get_page_lat($post->ID);
        $page_long          =   get_page_long($post->ID);  
        $page_custom_zoom   =   get_page_zoom($post->ID); 
        $page_custom_zoom_prop   =   get_post_meta($post->ID,'page_custom_zoom',true);
        $closed_height      =   get_current_map_height($post->ID);
        $open_height        =   get_map_open_height($post->ID);
        $open_close_status  =   get_map_open_close_status($post->ID);  
    }else{
        $page_lat           =   esc_html( get_option('wp_estate_general_latitude','') );
        $page_long          =   esc_html( get_option('wp_estate_general_longitude','') );
        $page_custom_zoom   =   esc_html( get_option('wp_estate_default_map_zoom','') ); 
        $page_custom_zoom_prop  =   15;
        $closed_height      =   intval (get_option('wp_estate_min_height',''));
        $open_height        =   get_option('wp_estate_max_height','');
        $open_close_status  =   esc_html( get_option('wp_estate_keep_min','' ) ); 
    }
   
    
    if( get_post_type() === 'estate_property' && !is_tax() &&!is_search() ){
<<<<<<< HEAD
=======
      
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        $load_extra =   1;
        $google_camera_angle    =   intval( esc_html(get_post_meta($post->ID, 'google_camera_angle', true)) );
        $header_type                =   get_post_meta ( $post->ID, 'header_type', true);
        $global_header_type         =   get_option('wp_estate_header_type','');
        $small_map=0;
        if ( $header_type == 0 ){ // global
            if ($global_header_type != 4){
                $small_map=1;
            }
        }else{
            if($header_type!=5){
                $small_map=1;
            }
        }
        
       
         
        
      
        
<<<<<<< HEAD
        wp_enqueue_script('googlecode_property', get_template_directory_uri().'/js/google_js/google_map_code_listing.js',array('jquery'), '1.0', true); 
=======
        wp_enqueue_script('googlecode_property', get_template_directory_uri().'/js/google_js/google_map_code_listing'.$mimify_prefix.'.js',array('jquery'), '1.0', true); 
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        wp_localize_script('googlecode_property', 'googlecode_property_vars', 
              array(  'general_latitude'  =>  esc_html( get_option('wp_estate_general_latitude','') ),
                      'general_longitude' =>  esc_html( get_option('wp_estate_general_longitude','') ),
                      'path'              =>  get_template_directory_uri().'/css/css-images',
                      'markers'           =>  $json_string,
                      'camera_angle'      =>  $google_camera_angle,
                      'idx_status'        =>  $use_idx_plugins,
<<<<<<< HEAD
                      'page_custom_zoom'  =>  $page_custom_zoom_prop,
                      'current_id'        =>  $post->ID,
                      'generated_pins'    =>  0,
=======
                      'page_custom_zoom'  =>  intval($page_custom_zoom_prop),
                      'current_id'        =>  $post->ID,
                      'generated_pins'    =>  1,
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
                      'small_map'          => $small_map,
                      'type'              =>  esc_html ( get_option('wp_estate_default_map_type','')),
                   
                   )
          );
        
      
   
  
    }else if( is_page_template('contact_page.php')  ){
        $load_extra =   1;
        if($custom_image    ==  ''){  
<<<<<<< HEAD
          wp_enqueue_script('googlecode_contact', get_template_directory_uri().'/js/google_js/google_map_code_contact.js',array('jquery'), '1.0', true);        
=======
          wp_enqueue_script('googlecode_contact', get_template_directory_uri().'/js/google_js/google_map_code_contact'.$mimify_prefix.'.js',array('jquery'), '1.0', true);        
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
          $hq_latitude =  esc_html( get_option('wp_estate_hq_latitude','') );
          $hq_longitude=  esc_html( get_option('wp_estate_hq_longitude','') );

          if($hq_latitude==''){
              $hq_latitude='40.781711';
          }

          if($hq_longitude==''){
              $hq_longitude='-73.955927';
          }
          $json_string=wpestate_contact_pin(); 

          wp_localize_script('googlecode_contact', 'googlecode_contact_vars', 
<<<<<<< HEAD
              array(  'hq_latitude'       =>  $hq_latitude,
                      'hq_longitude'      =>  $hq_longitude,
                      'path'              =>  get_template_directory_uri().'/css/css-images',
                      'markers'           =>  $json_string,
                      'page_custom_zoom'  =>  $page_custom_zoom,
                      'address'           =>  esc_html(stripslashes( get_option('wp_estate_co_address', '') ) ),
                      'logo'              =>  esc_html( get_option('wp_estate_company_contact_image', '') ),
                       'type'              =>  esc_html ( get_option('wp_estate_default_map_type','')),
=======
              array(    'hq_latitude'       =>  $hq_latitude,
                        'hq_longitude'      =>  $hq_longitude,
                        'path'              =>  get_template_directory_uri().'/css/css-images',
                        'markers'           =>  $json_string,
                        'page_custom_zoom'  =>  intval($page_custom_zoom),
                        'address'           =>  esc_html(stripslashes( get_option('wp_estate_co_address', '') ) ),
                        'logo'              =>  esc_html( get_option('wp_estate_company_contact_image', '') ),
                        'type'              =>  esc_html ( get_option('wp_estate_default_map_type','')),
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
                   )
          );
        }
       
    }else {
<<<<<<< HEAD
            if($header_type==5 || $global_header_type==4){           
                $load_extra     =   1;
                $is_adv_search  =   0;
                if ( is_page_template('advanced_search_results.php') ){
                    $is_adv_search=1;
                }
                    
                wp_enqueue_script('googlecode_regular', get_template_directory_uri().'/js/google_js/google_map_code.js',array('jquery'), '1.0', true);        
=======

            if($header_type==5 || $global_header_type==4){           
                $load_extra         =   1;
                $is_adv_search      =   0;
                $is_half_map_list   =   0;
                $is_normal_map_list =   0;
                if ( is_page_template('advanced_search_results.php') ){
                    $is_adv_search=1;
                }  
                
                if ( is_page_template('property_list_half.php') ||  ( is_tax() &&  intval(get_option('wp_estate_property_list_type','') )==2 ) ){
                    $taxonmy    =   get_query_var('taxonomy');
 
                    if( $taxonmy == 'property_category' || 
                        $taxonmy == 'property_action_category' || 
                        $taxonmy == 'property_city' || 
                        $taxonmy == 'property_area' ||
                        $taxonmy == 'property_county_state'){

                        $is_half_map_list=1;

                    }
                 
                }
                
                if( is_page_template('advanced_search_results.php') &&  intval(get_option('wp_estate_property_list_type_adv') )==2 ) {
                    $is_half_map_list=1;
                }
                   
                
                
                if ( is_page_template('property_list.php') 
                        //|| is_page_template('property_list_directory.php')
                        ){
                    $is_normal_map_list=1;
                }
                
          
                wp_enqueue_script('googlecode_regular', get_template_directory_uri().'/js/google_js/google_map_code'.$mimify_prefix.'.js',array('jquery'), '1.0', true);        
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
                wp_localize_script('googlecode_regular', 'googlecode_regular_vars', 
                    array(  'general_latitude'  =>  $page_lat,
                            'general_longitude' =>  $page_long,
                            'path'              =>  get_template_directory_uri().'/css/css-images',
                            'markers'           =>  $json_string,
                            'idx_status'        =>  $use_idx_plugins,
<<<<<<< HEAD
                            'page_custom_zoom'  =>  $page_custom_zoom,
                            'generated_pins'    =>  $use_generated_pins,
                            'page_custom_zoom'  =>  $page_custom_zoom,
                            'type'              =>  esc_html ( get_option('wp_estate_default_map_type','')),
                            'is_adv_search'    =>  $is_adv_search
=======
                            'page_custom_zoom'  =>  intval($page_custom_zoom),
                            'generated_pins'    =>  $use_generated_pins,
                            'page_custom_zoom'  =>  intval($page_custom_zoom),
                            'type'              =>  esc_html ( get_option('wp_estate_default_map_type','')),
                            'is_adv_search'     =>  $is_adv_search,
                            'is_half_map_list'  =>  $is_half_map_list,
                            'is_normal_map_list'=>  $is_normal_map_list
                        
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
                         )
                );

            }
    }         
   
   $custom_advanced_search  = get_option('wp_estate_custom_advanced_search','');
   $measure_sys             = get_option('wp_estate_measure_sys','');
   
    $is_half=0;
    if( is_page_template('property_list_half.php') ){
        $is_half=1;    
    }
    
    $property_list_type_status =    esc_html(get_option('wp_estate_property_list_type_adv',''));
    if( is_page_template('advanced_search_results.php') &&  $property_list_type_status == 2  ){
        $is_half=1;    
    }
    
<<<<<<< HEAD
    if( is_tax() &&  $property_list_type_status == 2  ){
        $is_half=1;    
    }
    
    $is_prop_list=0;
    if( is_page_template('property_list.php') ){
=======
    $property_list_type_tax =    esc_html(get_option('wp_estate_property_list_type',''));
    if( is_tax() &&  $property_list_type_tax == 2  ){
        $is_half=1;    
    }
    if( is_tax('property_category_agent')  ||  is_tax('property_action_category_agent') || 
            is_tax('property_city_agent')||  is_tax('property_area_agent')|| is_tax('property_county_state_agent')){
        $is_half=0;      
    }
   
    
    $is_prop_list=0;
    if( is_page_template('property_list.php') 
            //|| is_page_template('property_list_directory.php')
             ){
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        $is_prop_list=1;    
    }
    $is_tax=0;  
    if( is_tax() ){
        $is_tax=1;  
    }
    
<<<<<<< HEAD
    if(is_page_template('user_dashboard_add.php' ) ){
        $load_extra=1; 
    }
    
    $local_pgpr_slider_type_status=  get_post_meta($post->ID, 'local_pgpr_slider_type', true);
=======
    if( is_page_template('user_dashboard_add.php' ) || is_page_template('user_dashboard_profile.php' ) || ( is_page_template('property_list.php' ) ) ){
        $load_extra=1; 
    }
    $local_pgpr_slider_type_status ='';
    if(isset($post->ID)){
        $local_pgpr_slider_type_status=  get_post_meta($post->ID, 'local_pgpr_slider_type', true);
    }
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    if ($local_pgpr_slider_type_status=='global'){
        $small_slider_t= esc_html ( get_option('wp_estate_global_prpg_slider_type','') );
    }else{
        $small_slider_t=$local_pgpr_slider_type_status;
    }

   
<<<<<<< HEAD
    if($load_extra ==   1){
       
        wp_enqueue_script('mapfunctions', get_template_directory_uri().'/js/google_js/mapfunctions.js',array('jquery'), '1.0', true);   
        wp_localize_script('mapfunctions', 'mapfunctions_vars', 
                array(   'path'                 =>  get_template_directory_uri().'/css/css-images',
                         'pin_images'           =>  $pin_images ,
                         'geolocation_radius'   =>  $geolocation_radius,
                         'adv_search'           =>  $adv_search_type_status,
                         'in_text'              =>  __(' in ','wpestate'),
                         'zoom_cluster'         =>  $zoom_cluster,
                         'user_cluster'         =>  $pin_cluster_status,
                         'open_close_status'    =>  $open_close_status,
                         'open_height'          =>  $open_height,
                         'closed_height'        =>  $closed_height,     
                         'generated_pins'       =>  $use_generated_pins,
                         'geo_no_pos'           =>  __('The browser couldn\'t detect your position!','wpestate'),
                         'geo_no_brow'          =>  __('Geolocation is not supported by this browser.','wpestate'),
                         'geo_message'          =>  __('m radius','wpestate'),
                         'show_adv_search'      =>  $show_adv_search,
                         'custom_search'        =>  $custom_advanced_search,
                         'listing_map'          =>  $listing_map,
                         'slugs'                =>  $slugs,
                         'hows'                 =>  $hows,
                         'measure_sys'          =>  $measure_sys,
                         'close_map'            =>  __('close map','wpestate'),
                         'show_g_search_status' =>  $show_g_search_status,
                         'slider_price'         =>  $show_price_slider,
                         'slider_price_position'=>  $slider_price_position,
                         'adv_search_type'      =>  get_option('wp_estate_adv_search_type',''),
                         'is_half'              =>  $is_half,
                         'map_style'            =>  stripslashes (  get_option('wp_estate_map_style','') ),
                         'small_slider_t'       =>  $small_slider_t,
                         'is_prop_list'         =>  $is_prop_list,
                         'is_tax'               =>  $is_tax
                    
                     )
            );   
        wp_enqueue_script('markerclusterer', get_template_directory_uri().'/js/google_js/markerclusterer.js',array('jquery'), '1.0', true);  
        wp_enqueue_script('oms.min', get_template_directory_uri().'/js/google_js/oms.min.js',array('jquery'), '1.0', true); 
    } // end load extra
    
  
    if(is_page_template('user_dashboard_add.php') || is_page_template('user-dashboard.php') ){
            $page_lat   = esc_html( get_option('wp_estate_general_latitude','') );
            $page_long  = esc_html( get_option('wp_estate_general_longitude','') );
            wp_enqueue_script('google_map_submit', get_template_directory_uri().'/js/google_js/google_map_submit.js',array('jquery'), '1.0', true);  
=======
    if(1 ==   1){
       
        wp_enqueue_script('mapfunctions', get_template_directory_uri().'/js/google_js/mapfunctions'.$mimify_prefix.'.js',array('jquery'), '1.0', true);   
        wp_localize_script('mapfunctions', 'mapfunctions_vars', 
                array(      'path'                      =>  get_template_directory_uri().'/css/css-images',
                            'pin_images'                =>  $pin_images ,
                            'geolocation_radius'        =>  $geolocation_radius,
                            'adv_search'                =>  $adv_search_type_status,
                            'in_text'                   =>  __(' in ','wpestate'),
                            'zoom_cluster'              =>  intval($zoom_cluster),
                            'user_cluster'              =>  $pin_cluster_status,
                            'open_close_status'         =>  $open_close_status,
                            'open_height'               =>  $open_height,
                            'closed_height'             =>  $closed_height,     
                            'generated_pins'            =>  $use_generated_pins,
                            'geo_no_pos'                =>  __('The browser couldn\'t detect your position!','wpestate'),
                            'geo_no_brow'               =>  __('Geolocation is not supported by this browser.','wpestate'),
                            'geo_message'               =>  __('m radius','wpestate'),
                            'show_adv_search'           =>  $show_adv_search,
                            'custom_search'             =>  $custom_advanced_search,
                            'listing_map'               =>  $listing_map,
                            'slugs'                     =>  $slugs,
                            'hows'                      =>  $hows,
                            'measure_sys'               =>  $measure_sys,
                            'close_map'                 =>  __('close map','wpestate'),
                            'show_g_search_status'      =>  $show_g_search_status,
                            'slider_price'              =>  $show_price_slider,
                            'slider_price_position'     =>  $slider_price_position,
                            'adv_search_type'           =>  get_option('wp_estate_adv_search_type',''),
                            'is_half'                   =>  $is_half,
                            'map_style'                 =>  stripslashes (  get_option('wp_estate_map_style','') ),
                            'small_slider_t'            =>  $small_slider_t,
                            'is_prop_list'              =>  $is_prop_list,
                            'is_tax'                    =>  $is_tax,
                            'half_no_results'           =>  __('No results found!','wpestate'),
                            'fields_no'                 =>  intval( get_option('wp_estate_adv_search_fields_no')),
                            'type'                      =>  esc_html ( get_option('wp_estate_default_map_type','')),
                            'useprice'                  =>  esc_html ( get_option('wp_estate_use_price_pins','')),
                            'use_price_pins_full_price' =>  esc_html ( get_option('wp_estate_use_price_pins_full_price','')),
                            'use_single_image_pin'      =>  esc_html ( get_option('wp_estate_use_single_image_pin','')),
                            'loading_results'           =>  __('loading results...','wpestate')
                     )
            );   
        wp_enqueue_script('markerclusterer', get_template_directory_uri().'/js/google_js/markerclusterer'.$mimify_prefix.'.js',array('jquery'), '1.0', true);  
        wp_enqueue_script('oms.min', get_template_directory_uri().'/js/google_js/oms.min.js',array('jquery'), '1.0', true); 
  
    
        } // end load extra
    
  
    if(is_page_template('user_dashboard_add.php') || is_page_template('user-dashboard.php') || 
            is_page_template('user_dashboard_profile.php') || is_page_template('front_property_submit.php') ){
            $page_lat   = '';
            $page_long  = '';
            
            $current_user = wp_get_current_user();
            $user_role = get_user_meta( $current_user->ID, 'user_estate_role', true) ;
            
            if($user_role==3){
                $page_lat  =  esc_html(get_post_meta($post->ID, 'agency_lat', true));
                $page_long =  esc_html(get_post_meta($post->ID, 'agency_long', true));
            }
            
            if($user_role==4){
                $page_lat  =  esc_html(get_post_meta($post->ID, 'developer_lat', true));
                $page_long =  esc_html(get_post_meta($post->ID, 'developer_long', true));
            }
            
            if($page_lat=='' || $page_lat==''){
                $page_lat   = esc_html( get_option('wp_estate_general_latitude','') );
                $page_long  = esc_html( get_option('wp_estate_general_longitude','') );
            }
            
            
            wp_enqueue_script('google_map_submit', get_template_directory_uri().'/js/google_js/google_map_submit'.$mimify_prefix.'.js',array('jquery'), '1.0', true);  
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
            wp_localize_script('google_map_submit', 'google_map_submit_vars', 
                array(  'general_latitude'  =>  $page_lat,
                        'general_longitude' =>  $page_long,    
                        'geo_fails'         =>  __('Geolocation was not successful for the following reason:','wpestate'),
                        'enable_auto'       =>  get_option('wp_estate_enable_autocomplete','')
                     )
            ); 
          
    }   
         

<<<<<<< HEAD
    $icons          =   wpestate_get_icons();
    $hover_icons    =   wpestate_get_hover_icons();
    $login_redirect =   get_dashboard_profile_link();
    $show_adv_search_map_close          =   esc_html ( get_option('wp_estate_show_adv_search_map_close','') ); 
    $max_file_size  = 100 * 1000 * 1000;
    global $current_user;
    get_currentuserinfo();
    $userID                     =   $current_user->ID; 
=======
    $login_redirect                 =   wpestate_get_template_link('user_dashboard_profile.php');
    $show_adv_search_map_close      =   esc_html ( get_option('wp_estate_show_adv_search_map_close','') ); 
    $max_file_size                  =   100 * 1000 * 1000;
    $current_user                   =   wp_get_current_user();
    $userID                         =   $current_user->ID; 
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
      
    $argsx=array(
            'br' => array(),
            'em' => array(),
            'strong' => array()
    );
<<<<<<< HEAD
    $direct_payment_details         =   wp_kses( get_option('wp_estate_direct_payment_details','') ,$argsx);
    
=======
    //$direct_payment_details         =   wp_kses( get_option('wp_estate_direct_payment_details','') ,$argsx);
    if (function_exists('icl_translate') ){
        $mes =  wp_kses( get_option('wp_estate_direct_payment_details','') ,$argsx);
        $direct_payment_details      =   icl_translate('wpestate','wp_estate_property_direct_payment_text', $mes );
    }else{
        $direct_payment_details =  wp_kses( get_option('wp_estate_direct_payment_details','') ,$argsx);
    }
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    
    $submission_curency = esc_html( get_option('wp_estate_submission_curency_custom', '') );
    if($submission_curency == ''){
        $submission_curency = esc_html( get_option('wp_estate_submission_curency', '') );
    }
    
<<<<<<< HEAD
    wp_enqueue_script('control', get_template_directory_uri().'/js/control.js',array('jquery'), '1.0', true);   
=======
    if(is_singular('estate_property')  || is_singular('estate_agent')  || is_singular('estate_agency') || is_singular('estate_developer') ){
        $array_label    =   wp_estate_return_traffic_labels($post->ID,14);
        $array_values   =   wp_estate_return_traffic_data_accordion($post->ID,14);
        
        wp_enqueue_script('wpestate_property', get_template_directory_uri().'/js/property'.$mimify_prefix.'.js',array('jquery'), '1.0', true);   
        wp_localize_script('wpestate_property', 'wpestate_property_vars', 
            array(  'singular_label'                 =>   json_encode ( $array_label ),
                    'singular_values'                 =>  json_encode ( $array_values),)
                    ); 
    }
    
    $scroll_trigger= intval ( get_option('wp_estate_header_height','') );  
    if($scroll_trigger==0){
        $scroll_trigger=100;
    }
    $is_rtl=0;
    if( is_rtl() ){
        $is_rtl=1;
    }
    
    $sticky_search = get_option('wp_estate_sticky_search');
    if( wpestate_is_user_dashboard() ){
        $sticky_search = 'no';
    }
    
    
    wp_enqueue_script('control', get_template_directory_uri().'/js/control'.$mimify_prefix.'.js',array('jquery'), '1.0', true);   
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    wp_localize_script('control', 'control_vars', 
            array(  'morg1'                 =>   __('Amount Financed:','wpestate'),
                    'morg2'                 =>   __('Mortgage Payments:','wpestate'),
                    'morg3'                 =>   __('Annual cost of Loan:','wpestate'),
                    'searchtext'            =>   __('SEARCH','wpestate'),
<<<<<<< HEAD
                    'searchtext2'           =>   __('Search here...','wpestate'),
                    'icons'                 =>   $icons,
                    'hovericons'            =>   $hover_icons,
=======
                    'searchtext2'           =>   __('Search here...','wpestate'),   
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
                    'path'                  =>   get_template_directory_uri(),
                    'search_room'           =>  __('Type Bedrooms No.','wpestate'),
                    'search_bath'           =>  __('Type Bathrooms No.','wpestate'),
                    'search_min_price'      =>  __('Type Min. Price','wpestate'),
                    'search_max_price'      =>  __('Type Max. Price','wpestate'),
                    'contact_name'          =>  __('Your Name','wpestate'),
                    'contact_email'         =>  __('Your Email','wpestate'),
                    'contact_phone'         =>  __('Your Phone','wpestate'),
                    'contact_comment'       =>  __('Your Message','wpestate'),
                    'zillow_addres'         =>  __('Your Address','wpestate'),
                    'zillow_city'           =>  __('Your City','wpestate'),
                    'zillow_state'          =>  __('Your State Code (ex CA)','wpestate'),
                    'adv_contact_name'      =>  __('Your Name','wpestate'),
                    'adv_email'             =>  __('Your Email','wpestate'),
                    'adv_phone'             =>  __('Your Phone','wpestate'),
                    'adv_comment'           =>  __('Your Message','wpestate'),
                    'adv_search'            =>  __('Send Message','wpestate'),
                    'admin_url'             =>  get_admin_url(),
                    'login_redirect'        =>  $login_redirect,
                    'login_loading'         =>  __('Sending user info, please wait...','wpestate'), 
                    'street_view_on'        =>  __('Street View','wpestate'),
                    'street_view_off'       =>  __('Close Street View','wpestate'),
                    'userid'                =>  $userID,
                    'show_adv_search_map_close'=>$show_adv_search_map_close,
                    'close_map'             =>  __('close map','wpestate'),
                    'open_map'              =>  __('open map','wpestate'),
                    'fullscreen'            =>  __('Fullscreen','wpestate'),
                    'default'               =>  __('Default','wpestate'),
                    'addprop'               =>  __('Please wait while we are processing your submission!','wpestate'),
                    'deleteconfirm'         =>  __('Are you sure you wish to delete?','wpestate'),
                    'terms_cond'            =>  __('You need to agree with terms and conditions !','wpestate'),
                    'procesing'             =>  __('Processing...','wpestate'),
                    'slider_min'            =>  floatval(get_option('wp_estate_show_slider_min_price','')),
                    'slider_max'            =>  floatval(get_option('wp_estate_show_slider_max_price','')), 
                    'curency'               =>  esc_html( get_option('wp_estate_currency_symbol', '') ),
                    'where_curency'         =>  esc_html( get_option('wp_estate_where_currency_symbol', '') ),
                    'submission_curency'    =>  $submission_curency,
                    'to'                    =>  __('to','wpestate'),
                    'direct_pay'            =>  $direct_payment_details,
                    'send_invoice'          =>  __('Send me the invoice','wpestate'),
                    'direct_title'          =>  __('Direct payment instructions','wpestate'),
                    'direct_thx'            =>  __('Thank you. Please check your email for payment instructions.','wpestate'),
                    'direct_price'          =>  __('To be paid','wpestate'),
                    'price_separator'       =>  stripslashes ( esc_html( get_option('wp_estate_prices_th_separator', '') ) ),
                    'plan_title'            =>  __('Plan Title','wpestate'),
                    'plan_image'            =>  __('Plan Image','wpestate'),
                    'plan_desc'             =>  __('Plan Description','wpestate'),
                    'plan_size'             =>  __('Plan Size','wpestate'),
                    'plan_rooms'            =>  __('Plan Rooms','wpestate'),
                    'plan_bathrooms'        =>  __('Plan Bathrooms','wpestate'),
                    'plan_price'            =>  __('Plan Price','wpestate'),
                    'readsys'               =>  get_option('wp_estate_readsys',''),
                    'datepick_lang'         =>  $date_lang_status,
<<<<<<< HEAD
=======
                    'deleting'              =>  __('deleting...','wpestate'),
                    'save_search'           =>  __('saving...','wpestate'),
                    'captchakey'            =>  get_option('wp_estate_recaptha_sitekey',''),
                    'usecaptcha'            =>  get_option('wp_estate_use_captcha',''),
                    'scroll_trigger'        =>  $scroll_trigger,
                    'adv6_taxonomy_term'    =>  get_option('wp_estate_adv6_taxonomy_terms'),
                    'adv6_max_price'        =>  get_option('wp_estate_adv6_max_price'),     
                    'adv6_min_price'        =>  get_option('wp_estate_adv6_min_price'),   
                    'is_rtl'                =>  $is_rtl,
                    'sticky_footer'         =>  get_option('wp_estate_show_sticky_footer',''),
                    'geo_radius_measure'    =>  get_option('wp_estate_geo_radius_measure',''),
                    'initial_radius'        =>  get_option('wp_estate_initial_radius',''),
                    'min_geo_radius'        =>  get_option('wp_estate_min_geo_radius',''),
                    'max_geo_radius'        =>  get_option('wp_estate_max_geo_radius',''),
                    'stiky_search'          =>  $sticky_search,
                    'posting'               =>  __('posting','wpestate'),
                    'review_posted'         =>  __('Review Sent ','wpestate'),
                    'review_edited'         =>  __('Review Edit Saved','wpestate'),
					'sticky_bar'        =>  get_option('wp_estate_theme_sticky_sidebar' )
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
                    )
     );
    
    
<<<<<<< HEAD
      wp_enqueue_script('ajaxcalls', get_template_directory_uri().'/js/ajaxcalls.js',array('jquery'), '1.0', true);   
=======
      wp_enqueue_script('ajaxcalls', get_template_directory_uri().'/js/ajaxcalls'.$mimify_prefix.'.js',array('jquery'), '1.0', true);   
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
      wp_localize_script('ajaxcalls', 'ajaxcalls_vars', 
            array(  'contact_name'          =>  __('Your Name','wpestate'),
                    'contact_email'         =>  __('Your Email','wpestate'),
                    'contact_phone'         =>  __('Your Phone','wpestate'),
                    'contact_comment'       =>  __('Your Message','wpestate'),
                    'adv_contact_name'      =>  __('Your Name','wpestate'),
                    'adv_email'             =>  __('Your Email','wpestate'),
                    'adv_phone'             =>  __('Your Phone','wpestate'),
                    'adv_comment'           =>  __('Your Message','wpestate'),
                    'adv_search'            =>  __('Send Message','wpestate'),
<<<<<<< HEAD
=======
                    'disabled'              =>  __('Disabled','wpestate'),
                    'published'             =>  __('Published','wpestate'),
                    'no_title'        =>  __('Please, enter property title','wpestate'),
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
                    'admin_url'             =>  get_admin_url(),
                    'login_redirect'        =>  $login_redirect,
                    'login_loading'         =>  __('Sending user info, please wait...','wpestate'), 
                    'userid'                =>  $userID,
                    'prop_featured'         =>  __('Property is featured','wpestate'),
                    'no_prop_featured'      =>  __('You have used all the "Featured" listings in your package.','wpestate'),
                    'favorite'              =>  __('favorite','wpestate'),
                    'add_favorite'          =>  __('add to favorites','wpestate'),
                    'saving'                =>  __('saving..','wpestate'),
                    'sending'               =>  __('sending message..','wpestate'),
<<<<<<< HEAD
                    'paypal'                =>  __('Connecting to Paypal! Please wait...','wpestate'),
                    'stripecancel'          =>  __('subscription will be cancelled at the end of current period','wpestate'),
                    'userpass'              =>  esc_html ( get_option('wp_estate_enable_user_pass','') ),
                   
                )
     );
    

=======
                    'error_field'               =>  __('Please, enter field:','wpestate'),
                    'noimages'               =>  __('You need to upload at last one image','wpestate'),
                    'notitle'               =>  __('Please, enter property title','wpestate'),
                    'paypal'                =>  __('Connecting to Paypal! Please wait...','wpestate'),
                    'stripecancel'          =>  __('subscription will be cancelled at the end of current period','wpestate'),
                    'userpass'              =>  esc_html ( get_option('wp_estate_enable_user_pass','') ),
                    'disablelisting'        =>  esc_html__( 'Disable Listing','wpestate'),
                    'enablelisting'         =>  esc_html__( 'Enable Listing','wpestate'),
                    'disableagent'          =>  esc_html__( 'Disable Agent','wpestate'),
                    'enableagent'           =>  esc_html__( 'Enable Agent','wpestate'),
                    'agent_list'            =>  wpestate_get_template_link('user_dashboard_agent_list.php'),
                    'delete_account'        =>  esc_html__('Confirm your ACCOUNT DELETION request! Clicking the button below will delete your account and data. This means you will no longer be able to login to your account and access your account information: My Profile, My Properties, Inbox, Saved Searches and Messages. This operation CAN NOT BE REVERSED!','wpestate')
                )
     );
    
    if( wpestate_is_user_dashboard() ){
        wp_enqueue_script('dashboard', get_template_directory_uri().'/js/dashboard'.$mimify_prefix.'.js',array('jquery'), '1.0', true);   
        wp_localize_script('dashboard', 'dashboard_vars', 
            array(  'sending'                 =>   __('Sending','wpestate') ) );
    }
    
    if( is_page_template('property_list_directory.php') ){
        wp_enqueue_script('directory', get_template_directory_uri().'/js/property_directory_control'.$mimify_prefix.'.js',array('jquery'), '1.0', true);   
        
        wp_localize_script('directory', 'directory_vars', 
            array(   
                'dir_min_size'          =>  wpestate_convert_measure( get_post_meta($post->ID,'dir_min_size',true) ),
                'dir_max_size'          =>  wpestate_convert_measure( get_post_meta($post->ID,'dir_max_size',true) ),
                'dir_min_lot_size'      =>  wpestate_convert_measure( get_post_meta($post->ID,'dir_min_lot_size',true) ),
                'dir_max_lot_size'      =>  wpestate_convert_measure( get_post_meta($post->ID,'dir_max_lot_size',true) ),
                'dir_rooms_min'         =>  get_post_meta($post->ID,'dir_rooms_min',true),
                'dir_rooms_max'         =>  get_post_meta($post->ID,'dir_rooms_max',true),
                'dir_bedrooms_min'      =>  get_post_meta($post->ID,'dir_bedrooms_min',true),
                'dir_bedrooms_max'      =>  get_post_meta($post->ID,'dir_bedrooms_max',true),
                'dir_bathrooms_min'     =>  get_post_meta($post->ID,'dir_bathrooms_min',true),
                'dir_bedrooms_max'      =>  get_post_meta($post->ID,'dir_bedrooms_max',true),
                'measures_sys'          =>  wpestate_return_measurement_sys(),
                'no_more'               =>  __('No More Listings','wpestate'),
                
            ) );
    }
    
    if( is_page_template('front_property_submit.php') ){
        wp_enqueue_script('front_end_submit', get_template_directory_uri().'/js/front_end_submit'.$mimify_prefix.'.js',array('jquery'), '1.0', true);   
        
    }
    
    
    
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////file upload ajax - profile and user dashboard
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
<<<<<<< HEAD
    if( is_page_template('user_dashboard_profile.php') || is_page_template('user_dashboard_add.php')   ){
   
        wp_enqueue_script('ajax-upload', get_template_directory_uri().'/js/ajax-upload.js',array('jquery','plupload-handlers'), '1.0', true);  
=======
    if( is_page_template('user_dashboard_profile.php') ||
            is_page_template('user_dashboard_add.php')  || is_page_template('user_dashboard_add_agent.php')  || 
            is_page_template('front_property_submit.php') ){
        
        $is_profile=0;
        if ( is_page_template('user_dashboard_profile.php') ){
            $is_profile=1;    
        }
        
        $plup_url = add_query_arg( array(
            'action'    =>  'wpestate_me_upload',
            'base'      =>  $is_profile,
            'nonce'     =>  wp_create_nonce('aaiu_allow'),
        ), admin_url('admin-ajax.php') );
        
        $max_images             =   intval   ( get_option('wp_estate_prop_image_number','') );
        
        $current_user           =   wp_get_current_user();
        $userID                 =   $current_user->ID;
        $parent_userID          =   wpestate_check_for_agency($userID);
        $paid_submission_status =   esc_html ( get_option('wp_estate_paid_submission','') );
        if( $paid_submission_status == 'membership'){
            $user_pack              =   get_the_author_meta( 'package_id' , $parent_userID ); 
            if($user_pack!=''){
                $max_images         =   get_post_meta($user_pack, 'pack_image_included', true);    
            }else{
                 $max_images        = intval   ( get_option('wp_estate_free_pack_image_included','') );
            }
        }
        
        
        wp_enqueue_script('ajax-upload', get_template_directory_uri().'/js/ajax-upload'.$mimify_prefix.'.js',array('jquery','plupload-handlers'), '1.0', true);  
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        wp_localize_script('ajax-upload', 'ajax_vars', 
            array(  'ajaxurl'           => admin_url('admin-ajax.php'),
                    'nonce'             => wp_create_nonce('aaiu_upload'),
                    'remove'            => wp_create_nonce('aaiu_remove'),
                    'number'            => 1,
<<<<<<< HEAD
                    'upload_enabled'    => true,
                    'path'              =>  get_template_directory_uri(),
=======
                    'warning'           =>  __('Image needs to be at least 500px height  x 500px wide!','wpestate'),
                    'upload_enabled'    => true,
                    'path'              =>  get_template_directory_uri(),
                    'max_images'        =>  $max_images,
                    'warning_max'      =>  __('You cannot upload more than','wpestate').' '.$max_images.' '.__('images','wpestate'),
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
                    'confirmMsg'        => __('Are you sure you want to delete this?','wpestate'),
                    'plupload'         => array(
                                            'runtimes'          => 'html5,flash,html4',
                                            'browse_button'     => 'aaiu-uploader',
                                            'container'         => 'aaiu-upload-container',
                                            'file_data_name'    => 'aaiu_upload_file',
                                            'max_file_size'     => $max_file_size . 'b',
<<<<<<< HEAD
                                            'url'               => admin_url('admin-ajax.php') . '?action=me_upload&nonce=' . wp_create_nonce('aaiu_allow'),
=======
                                            'url'               => $plup_url,
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
                                            'flash_swf_url'     => includes_url('js/plupload/plupload.flash.swf'),
                                            'filters'           => array(array('title' => __('Allowed Files','wpestate'), 'extensions' => "jpeg,jpg,gif,png,pdf")),
                                            'multipart'         => true,
                                            'urlstream_upload'  => true,
<<<<<<< HEAD
                                        //    'max_file_count'    =>2
                                       //     'multi_selection'   => false
                                            
                         
=======
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
                                            )
                
                )
                );
    }
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////file upload ajax - floor plans
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    if( is_page_template('user_dashboard_floor.php') ){
<<<<<<< HEAD
        wp_enqueue_script('ajax-upload', get_template_directory_uri().'/js/ajax-upload.js',array('jquery','plupload-handlers'), '1.0', true);  
=======
        $plup_url = add_query_arg( array(
            'action'    => 'wpestate_me_upload',        
            'nonce'     =>  wp_create_nonce('aaiu_allow'),
        ), admin_url('admin-ajax.php') );
        
        wp_enqueue_script('ajax-upload', get_template_directory_uri().'/js/ajax-upload'.$mimify_prefix.'.js',array('jquery','plupload-handlers'), '1.0', true);  
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        wp_localize_script('ajax-upload', 'ajax_vars', 
            array(  'ajaxurl'           => admin_url('admin-ajax.php'),
                    'nonce'             => wp_create_nonce('aaiu_upload'),
                    'remove'            => wp_create_nonce('aaiu_remove'),
                    'number'            => 1,
                    'is_floor'          => 1,
                    'upload_enabled'    => true,
<<<<<<< HEAD
=======
                    'warning'           =>  __('Image needs to be at least 500px height  x 500px wide!','wpestate'),
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
                    'path'              =>  get_template_directory_uri(),
                    'confirmMsg'        => __('Are you sure you want to delete this?','wpestate'),
                    'plupload'         => array(
                                            'runtimes'          => 'html5,flash,html4',
                                            'browse_button'     => 'aaiu-uploader',
                                            'container'         => 'aaiu-upload-container',
                                            'file_data_name'    => 'aaiu_upload_file',
                                            'max_file_size'     => $max_file_size . 'b',
<<<<<<< HEAD
                                            'url'               => admin_url('admin-ajax.php') . '?action=me_upload&nonce=' . wp_create_nonce('aaiu_allow'),
=======
                                            'url'               => $plup_url,
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
                                            'flash_swf_url'     => includes_url('js/plupload/plupload.flash.swf'),
                                            'filters'           => array(array('title' => __('Allowed Files','wpestate'), 'extensions' => "jpeg,jpg,gif,png")),
                                            'multipart'         => true,
                                            'urlstream_upload'  => true
<<<<<<< HEAD
                                            
                         
=======
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
                                            )
                
                )
                );
    }
     
     
     
    if ( is_singular() && get_option( 'thread_comments' ) ){
        wp_enqueue_script( 'comment-reply' );
    }
    
    
<<<<<<< HEAD
    if( get_post_type() === 'estate_property' && !is_tax() ){
        wp_enqueue_script('property',get_template_directory_uri().'/js/property.js',array('jquery'), '1.0', true); 
    }
   
    $protocol = is_ssl() ? 'https' : 'http';
    $general_font = esc_html( get_option('wp_estate_general_font', '') );
    
    $headings_font_subset   =   esc_html ( get_option('wp_estate_headings_font_subset','') );
    if($headings_font_subset!=''){
        $headings_font_subset='&amp;subset='.$headings_font_subset;
    }
    
    // embed custom fonts from admin
    if($general_font && $general_font!='x'){
        $general_font =  str_replace(' ', '+', $general_font);
        wp_enqueue_style( 'wpestate-custom-font',"$protocol://fonts.googleapis.com/css?family=$general_font:400,500,300$headings_font_subset");  
    }else{
        wp_enqueue_style( 'wpestate-opensans', "$protocol://fonts.googleapis.com/css?family=Open+Sans:400,600,300&amp;subset=latin,latin-ext" );
    }
   
    $headings_font = esc_html( get_option('wp_estate_headings_font', '') );
    if($headings_font && $headings_font!='x'){
       $headings_font =  str_replace(' ', '+', $headings_font);
       wp_enqueue_style( 'wpestate-custom-secondary-font', "$protocol://fonts.googleapis.com/css?family=$headings_font:400,500,300" );  
    }
    
    
    
     wp_enqueue_style( 'font-awesome.min',  get_template_directory_uri() . '/css/fontawesome/css/font-awesome.min.css' );  
  
    
      
=======


  

>>>>>>> 64662fd89bea560852792d7203888072d7452d48
}
endif; // end   wpestate_scripts  







///////////////////////////////////////////////////////////////////////////////////////////
/////// Js & Css include on admin site 
///////////////////////////////////////////////////////////////////////////////////////////


if( !function_exists('wpestate_admin') ):

function wpestate_admin($hook_suffix) {	
    global $post;            
    global $pagenow;
    global $typenow;
<<<<<<< HEAD
    
=======
    wp_enqueue_media();
    wp_enqueue_script("jquery-ui-autocomplete");
    wp_enqueue_script("jquery-ui-draggable");
    wp_enqueue_script("jquery-ui-droppable");
    wp_enqueue_script("jquery-ui-sortable");        
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_enqueue_script('my-upload'); 
    wp_enqueue_style('thickbox');
    wp_enqueue_style('adminstyle', get_template_directory_uri() . '/css/admin.css');
    wp_enqueue_script('admin-control', get_template_directory_uri().'/js/admin-control.js',array('jquery'), '1.0', true);     
    wp_localize_script('admin-control', 'admin_control_vars', 
        array( 'ajaxurl'            => admin_url('admin-ajax.php'),
                'plan_title'        =>  __('Plan Title','wpestate'),
                'plan_image'        =>  __('Plan Image','wpestate'),
                'plan_desc'         =>  __('Plan Description','wpestate'),
                'plan_size'         =>  __('Plan Size','wpestate'),
                'plan_rooms'        =>  __('Plan Rooms','wpestate'),
                'plan_bathrooms'    =>  __('Plan Bathrooms','wpestate'),
                'plan_price'        =>  __('Plan Price','wpestate'),
<<<<<<< HEAD
                  
=======
                'admin_url'         =>  get_admin_url(),
                
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        )
    );
    
    
    
    
    if($hook_suffix=='post-new.php' || $hook_suffix=='post.php'){
      wp_enqueue_script("jquery-ui-datepicker");
      wp_enqueue_style( 'wpestate-custom-secondary-font', "//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" );  
  
      wp_enqueue_style('jquery.ui.theme', get_template_directory_uri() . '/css/jquery-ui.min.css');
    }

    if (empty($typenow) && !empty($_GET['post'])) {
        $allowed_html   =   array();
<<<<<<< HEAD
        $post = get_post(wp_kses($_GET['post'],$allowed_html));
        $typenow = $post->post_type;
    }

    if (is_admin() &&  ( $pagenow=='post-new.php' || $pagenow=='post.php') && $typenow=='estate_property') {
        wp_enqueue_script('googlemap',      'http://maps.googleapis.com/maps/api/js?key='.esc_html(get_option('wp_estate_api_key', '') ).'&amp;sensor=true',array('jquery'), '1.0', false);
        wp_enqueue_script('admin_google',   get_template_directory_uri().'/js/google_js/admin_google.js',array('jquery'), '1.0', true); 
=======
        $post = get_post( esc_html( wp_kses( $_GET['post'], $allowed_html) ) );
        $typenow = $post->post_type;
    }

    if (is_admin() &&  ( $pagenow=='post-new.php' || $pagenow=='post.php') && ($typenow=='estate_property' || $typenow=='estate_agency' || $typenow=='estate_developer') ) {
        if (esc_html ( get_option('wp_estate_ssl_map','') ) =='yes'){
            wp_enqueue_script('googlemap',      'https://maps-api-ssl.google.com/maps/api/js?v=3&key='.esc_html(get_option('wp_estate_api_key', '') ).'',array('jquery'), '1.0', false);
        }else{
            wp_enqueue_script('googlemap',      'http://maps.googleapis.com/maps/api/js?v=3&key='.esc_html(get_option('wp_estate_api_key', '') ).'',array('jquery'), '1.0', false);
       }
        
       wp_enqueue_script('admin_google',   get_template_directory_uri().'/js/google_js/admin_google.js',array('jquery'), '1.0', true); 
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
              
                     
                     
        $wp_estate_general_latitude  = esc_html(get_post_meta($post->ID, 'property_latitude', true));
        $wp_estate_general_longitude = esc_html(get_post_meta($post->ID, 'property_longitude', true));

<<<<<<< HEAD
=======
        if( $typenow=='estate_agency' ){
            $wp_estate_general_latitude  = esc_html(get_post_meta($post->ID, 'agency_lat', true));
            $wp_estate_general_longitude = esc_html(get_post_meta($post->ID, 'agency_long', true));
        }
        
        if( $typenow=='estate_developer' ){
            $wp_estate_general_latitude  = esc_html(get_post_meta($post->ID, 'developer_lat', true));
            $wp_estate_general_longitude = esc_html(get_post_meta($post->ID, 'developer_long', true));
        }
        
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        if ($wp_estate_general_latitude=='' || $wp_estate_general_longitude=='' ){
            $wp_estate_general_latitude    = esc_html( get_option('wp_estate_general_latitude','') ) ;
            $wp_estate_general_longitude   = esc_html( get_option('wp_estate_general_longitude','') );

            if($wp_estate_general_latitude==''){
               $wp_estate_general_latitude ='40.781711';
            }

            if($wp_estate_general_longitude==''){ 
               $wp_estate_general_longitude='-73.955927';  
            }
        }
        
<<<<<<< HEAD
        wp_localize_script('admin_google', 'admin_google_vars', 
        array(  'general_latitude'  =>  $wp_estate_general_latitude,
                'general_longitude' =>  $wp_estate_general_longitude,
                'postId'=>$post->ID,
                'geo_fails'        =>  __('Geolocation was not successful for the following reason:','wpestate') 
              )
        );
     }

    $admin_pages = array('appearance_page_libs/theme-admin');
 
    if(in_array($hook_suffix, $admin_pages)) {
=======
       
        
        wp_localize_script('admin_google', 'admin_google_vars', 
        array(  'general_latitude'  =>  $wp_estate_general_latitude,
                'general_longitude' =>  $wp_estate_general_longitude,
                'postId'            =>  $post->ID,
                'geo_fails'         =>  __('Geolocation was not successful for the following reason:','wpestate') 
            )
        );
     }

   
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        wp_enqueue_script('admin', get_template_directory_uri().'/js/admin.js',array('jquery'), '1.0', true); 
        wp_enqueue_style('colorpicker_css', get_template_directory_uri().'/css/colorpicker.css', false, '1.0', 'all');
        wp_enqueue_script('admin_colorpicker', get_template_directory_uri().'/js/admin_colorpicker.js',array('jquery'), '1.0', true);
        wp_enqueue_script('config-property', get_template_directory_uri().'/js/config-property.js',array('jquery'), '1.0', true);          
<<<<<<< HEAD
    }
   
=======
   
   
       
        $max_file_size  = 100 * 1000 * 1000;
             
        $upload_dir = wp_upload_dir();
        $destination = $upload_dir['baseurl'];
        $destination_path = $destination . '/estate_templates/';
        
        wp_enqueue_script('ajax_upload_demo', get_template_directory_uri().'/js/ajax-upload-demo.js',array('jquery','plupload-handlers'), '1.0', true);  
        wp_localize_script('ajax_upload_demo', 'ajax_upload_demo_vars', 
            array(  'ajaxurl'           => admin_url('admin-ajax.php'),
                    'importing'         =>  __('Importing... Please wait!','wpestate'),
                    'complete'          =>  __('Import Completed!','wpestate'),
                    'admin_url'         =>  get_admin_url(),
                    'nonce'             => wp_create_nonce('aaiu_upload'),
                    'remove'            => wp_create_nonce('aaiu_remove'),
                    'number'            => 1,
                    'warning'           =>  __('Warning !','wpestate'),
                    'upload_enabled'    => true,
                    'path'              =>  get_template_directory_uri(),
                    'confirmMsg'        => __('Are you sure you want to delete this?','wpestate'),
                    'destination_path'  =>  $destination_path,
                    'plupload'         => array(
                                            'runtimes'          => 'html5,flash,html4',
                                            'browse_button'     => 'aaiu-uploader-demo',
                                            'container'         => 'aaiu-upload-container-demo',
                                            'file_data_name'    => 'aaiu_upload_file',
                                            'max_file_size'     => $max_file_size . 'b',
//                                            'url'               => $plup_url,
                                            'flash_swf_url'     => includes_url('js/plupload/plupload.flash.swf'),
                                            'filters'           => array(array('title' => __('Allowed Files','wpestate'), 'extensions' => "zip")),
                                            'multipart'         => true,
                                            'urlstream_upload'  => true,
                                            )
                
                )
        );
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
}

endif; // end   wpestate_admin  
?>