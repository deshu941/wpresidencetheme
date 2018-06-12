<?php

<<<<<<< HEAD
   
////////////////////////////////////////////////////////////////////////////////
/// google map functions - contact pin array creation
////////////////////////////////////////////////////////////////////////////////  

if( !function_exists('wpestate_contact_pin') ):

function wpestate_contact_pin(){
        $place_markers=array();
       
        
        $company_name=esc_html( get_option('wp_estate_company_name','') );
        if($company_name==''){
            $company_name='Company Name';
        }

        $place_markers[0]    =   $company_name;
        $place_markers[1]    =   '';
        $place_markers[2]    =   '';
        $place_markers[3]    =   1;
        $place_markers[4]    =   esc_html(get_option('wp_estate_company_contact_image', '') );
        $place_markers[5]    =   '0';
        $place_markers[6]    =   'address';
        $place_markers[7]    =   'none';
        $place_markers[8]    =   '';
       /*  */
        return json_encode($place_markers);
}    

endif; // end   wpestate_contact_pin  




////////////////////////////////////////////////////////////////////////////////
/// google map functions - pin array creation
////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_listing_pins') ):

function wpestate_listing_pins($args='',$jump=0){
    wp_suspend_cache_addition(true);
    set_time_limit (0);
    $counter=0;
    $unit                       =   get_option('wp_estate_measure_sys','');
    $currency                   =   get_option('wp_estate_currency_symbol','');
    $where_currency             =   get_option('wp_estate_where_currency_symbol', '');
    $cache                      =   get_option('wp_estate_cache','');
    $place_markers=$markers     =   array();

    if($cache=='yes'){
        if(!get_transient('prop_list_cached')) { 
                
                if  ( $args==''){
                    $args = array(
                        'post_type'      =>  'estate_property',
                        'post_status'    =>  'publish',
                        'nopaging'      =>  'true',
                        'cache_results'  => false,
                        'update_post_meta_cache'  =>   false,
                        'update_post_term_cache'  =>   false,
                     );
                }
               $prop_selection = new WP_Query($args);
               set_transient('prop_list_cached', $prop_selection, 60 * 60 * 3);//store data for 3h 
        }else{
              $prop_selection =get_transient('prop_list_cached');// retrive cached data
        }
        wp_reset_query(); 
    }
    else{  
        if  ( $args==''){
             $args = array(
                        'post_type'      =>  'estate_property',
                        'post_status'    =>  'publish',
                        'nopaging'      =>  'true',
                        'cache_results'  => false,
                        'update_post_meta_cache'  =>   false,
                        'update_post_term_cache'  =>   false,
                       );	
        }
          
 
          
        $prop_selection = new WP_Query($args);
        wp_reset_query(); 
    }//end cache
        $custom_advanced_search = get_option('wp_estate_custom_advanced_search','');
        $show_slider_price      = get_option('wp_estate_show_slider_price','');
        $has_slider         =   0; 

   
        while($prop_selection->have_posts()): $prop_selection->the_post();

               $the_id      =   get_the_ID();
               ////////////////////////////////////// gathering data for markups
               $gmap_lat    =   esc_html(get_post_meta($the_id, 'property_latitude', true));
               $gmap_long   =   esc_html(get_post_meta($the_id, 'property_longitude', true));

               //////////////////////////////////////  get property type
               $slug        =   array();
               $prop_type   =   array();
               $prop_city   =   array();
               $prop_area   =   array();
               $prop_countystate=array();
               $types       =   get_the_terms($the_id,'property_category' );
               $types_act   =   get_the_terms($the_id,'property_action_category' );
               $city_tax    =   get_the_terms($the_id,'property_city' );
               $area_tax    =   get_the_terms($the_id,'property_area' );
               $countystate_tax    =   get_the_terms($the_id,'property_county_state' );
               
             
               
                $prop_type_name=array();
                if ( $types && ! is_wp_error( $types ) ) { 
                     foreach ($types as $single_type) {
                        $prop_type[]      = $single_type->slug;
                        $prop_type_name[] = $single_type->name;
                        $slug             = $single_type->slug;
                       }

                $single_first_type= $prop_type[0];   
                $single_first_type_name= $prop_type_name[0]; 
                }else{
                      $single_first_type='';
                      $single_first_type_name='';
                }



                ////////////////////////////////////// get property action
                $prop_action        =   array();
                $prop_action_name   =   array();
                if ( $types_act && ! is_wp_error( $types_act ) ) { 
                      foreach ($types_act as $single_type) {
                        $prop_action[]      = $single_type->slug;
                        $prop_action_name[] = $single_type->name;
                        $slug=$single_type->slug;
                       }
                $single_first_action        = $prop_action[0];
                $single_first_action_name   = $prop_action_name[0];
                }else{
                    $single_first_action='';
                    $single_first_action_name='';
                }


                 /////////////////////////////////////////////////////////////////
                // add city
                if ( $city_tax && ! is_wp_error( $city_tax ) ) { 
                        foreach ($city_tax as $single_city) {
                           $prop_city[] = $single_city->slug;
                          }

                       $city= $prop_city[0];   
                   }else{
                         $city='';
                   }

                ///////////////////////////////////////  //////////////////////// 
                //add area
                 if ( $area_tax && ! is_wp_error( $area_tax ) ) { 
                         foreach ($area_tax as $single_area) {
                            $prop_area[] = $single_area->slug;
                           }

                        $area= $prop_area[0];   
                    }else{
                        $area='';
                    }     

                ///////////////////////////////////////  //////////////////////// 
               
                //add county state
           
                if ( $countystate_tax && ! is_wp_error( $countystate_tax ) ) { 
                     foreach ($countystate_tax as $single_area) {
                        $prop_countystate[] = $single_area->slug;
                       }

                    $countystate= $prop_countystate[0];   
                }else{
                    $countystate='';
                }     
                

                    // composing name of the pin
                    if($single_first_type=='' || $single_first_action ==''){
                          $pin                   =  sanitize_key(wpestate_limit54($single_first_type.$single_first_action));
                    }else{
                          $pin                   =  sanitize_key(wpestate_limit27($single_first_type)).sanitize_key(wpestate_limit27($single_first_action));
                    }
                    $counter++;

                    //// get price
                    $price          =   floatval   ( get_post_meta($the_id, 'property_price', true) );
                    $price_label    =   esc_html ( get_post_meta($the_id, 'property_label', true) );
                    $clean_price    =   floatval   ( get_post_meta($the_id, 'property_price', true) );
                    if($price==0){
                        $price='';                        
                    }else{
                        $th_separator   = stripslashes ( get_option('wp_estate_prices_th_separator','') );
                        $price = number_format($price,0,'.',$th_separator);
                        if($where_currency=='before'){
                            $price=$currency.' '.$price;
                        }else{
                            $price=$price.' '.$currency;
                        }
                        $price=$price.'<span class="infocur">'.$price_label.'</span>';
                    }
                    
                    $rooms      =   get_post_meta($the_id, 'property_bedrooms', true);
                    $bathrooms  =   get_post_meta($the_id, 'property_bathrooms', true);  
                    $size       =   get_post_meta($the_id, 'property_size', true);  		
                    if($size!=''){
                       $size =  number_format(intval($size)) ;
                    }
                    
                    $place_markers=array();

                    
                    $title_orig = get_the_title();
                   /* $title =  substr( $title_orig,0,45); 
                    if(strlen($title_orig)>45){
                        $title.= '...';   
                    }
                    */
                    // print $title_orig .' / '.$title.'</br>';
                    $place_markers[]    = rawurlencode ($title_orig);//0
                    $gmap_lat = floatval( $gmap_lat);
                    $gmap_long= floatval ( $gmap_long);
                    if($gmap_lat==0){
                        $gmap_lat='';
                    }
                    if($gmap_long==0){
                        $gmap_long='';
                    }
                    $place_markers[]    = $gmap_lat;//1
                    $place_markers[]    = $gmap_long;//2
                    $place_markers[]    = $counter;//3
                    $place_markers[]    = rawurlencode ( get_the_post_thumbnail($the_id,'property_map1') );////4
                    $place_markers[]    = rawurlencode ( $price); //5
                    $place_markers[]    = rawurlencode ($single_first_type);//6
                    $place_markers[]    = rawurlencode ($single_first_action);//7
                    $place_markers[]    = rawurlencode ($pin);//8
                    $place_markers[]    = rawurlencode (get_permalink());//9
                    $place_markers[]    = $the_id;//10
                    $place_markers[]    = rawurlencode ( $city ) ;//11
                    $place_markers[]    = rawurlencode ($area ) ;//12
                    $place_markers[]    = $clean_price;//13
                    $place_markers[]    = $rooms;//14
                    $place_markers[]    = $bathrooms;//15
                    $place_markers[]    = $size;//16
                    $place_markers[]    = rawurlencode ( $single_first_type_name);//17
                    $place_markers[]    = rawurlencode  ( $single_first_action_name);//18
                    
                     $custom_advanced_search= get_option('wp_estate_custom_advanced_search','');
                     if ( $custom_advanced_search == 'yes'){  
                      //starts from 17
                        $adv_search_what    = get_option('wp_estate_adv_search_what','');
                        $adv_search_how     = get_option('wp_estate_adv_search_how','');
                        $adv_search_label   = get_option('wp_estate_adv_search_label','');                    
                        $adv_search_type    = get_option('wp_estate_adv_search_type','');
    
                        foreach($adv_search_what as $key => $search_field){
                            //$slug=str_replace(' ','_',$search_field); 
                            $slug         =   wpestate_limit45(sanitize_title( $search_field )); 
                            $slug         =   sanitize_key($slug);
         
                            $place_markers[]    = $slug;
                           
                            if ( $slug == "categories" ){
                                $place_markers []   =  $single_first_type;
                            }else if ( $slug == "types" ){
                                $place_markers [] = $single_first_action;
                            }else if ( $slug == "cities" ){
                                $place_markers [] = $city;
                            }else if ( $slug == "areas" ){
                                $place_markers [] = $area;
                            }else if ( $slug == "county-state" ){
                                $place_markers [] = $countystate;
                            }else if ( $slug == "keyword"){
                                 $place_markers [] = rawurlencode ($title_orig);
                            }else if ( $slug == "property-price" && $show_slider_price=='yes'){    
                                $place_markers []   = get_post_meta($the_id, 'property_price', true);                            
                           $place_markers []   = 'greater'; 
                                $place_markers []   = 'property-price';
                                $place_markers []   = get_post_meta($the_id, 'property_price', true);
                                    $place_markers []   = 'smaller';
                                $has_slider=1;  
                                  
                            }else{
                                $old_values=array(
                                    'property-price',
                                    'property-label',
                                    'property-size',
                                    'property-lot-size',
                                    'property-rooms',
                                    'property-bedrooms',
                                    'property-bathrooms',
                                    'property-bathrooms',
                                    'property-address',
                                    'property-county',
                                    'property-state',
                                    'property-zip',
                                    'property-country',
                                    'property-status',
                                    );
                                
                                if(  in_array($slug,$old_values) ){
                                    $slug=  str_replace('-', '_', $slug);
                                }
                              
                                $place_markers []   = get_post_meta($the_id, $slug, true);//17 18 19 20 
                            }
                            
                            // check if 2n slider row is inserted
                            if($has_slider==0){
                                $place_markers[]    =   $adv_search_how[$key];//21 22      
                                
                            }   else{
                                $has_slider         =   0; 
                            }  
                            // end slider check
                        }                        
                    }
                       
         
                    $markers[]=$place_markers;


        endwhile; 
        wp_reset_query(); 
        //  print_r($markers);
        wp_suspend_cache_addition(false);
      
        if (get_option('wp_estate_readsys','')=='yes' && $jump==0){
            $path=estate_get_pin_file_path();
            file_put_contents($path, json_encode($markers)); 
        } else{
       
            return json_encode($markers);
        }
}
endif; // end   wpestate_listing_pins  


////////////////////////////////////////////////////////////////////////////////
/// google map functions - pin Images array creation
////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_pin_images') ):
 
function wpestate_pin_images(){
    $pins=array();
    $taxonomy = 'property_action_category';
    $tax_terms = get_terms($taxonomy);

    $taxonomy_cat = 'property_category';
    $categories = get_terms($taxonomy_cat);
    
     foreach ($tax_terms as $tax_term) {
        $name                    =  sanitize_key( wpestate_limit64('wp_estate_'.$tax_term->slug) );
        $limit54                 =  sanitize_key( wpestate_limit54($tax_term->slug));
        $pins[$limit54]          =  esc_html( get_option($name) ); 
    }
    
    foreach ($categories as $categ) {
        $name                           =   sanitize_key ( wpestate_limit64('wp_estate_'.$categ->slug) );
        $limit54                        =   sanitize_key(wpestate_limit54($categ->slug));
        $pins[$limit54]                 =   esc_html( get_option($name) );
    }
    

    foreach ($tax_terms as $tax_term) {
        foreach ($categories as $categ) {           
            $limit54                    =   sanitize_key ( wpestate_limit27($categ->slug)).sanitize_key(wpestate_limit27($tax_term->slug) );
            $name                       =   'wp_estate_'.$limit54;
            $pins[$limit54]              =   esc_html( get_option($name) ) ;  
        }
    }
    
    $name='wp_estate_idxpin';
    $pins['idxpin']=esc_html( get_option($name) );  
    
    $name='wp_estate_userpin';
    $pins['userpin']=esc_html( get_option($name) );  
    

    return json_encode($pins);
}
endif; // end   wpestate_pin_images 




////////////////////////////////////////////////////////////////////////////////
/// icon functiosn - return array with icons
////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_get_icons') ):

function wpestate_get_icons(){
    $icons          =   array();
    $taxonomy       =   'property_action_category';
    $tax_terms      =   get_terms($taxonomy);
    $taxonomy_cat   =   'property_category';
    $categories     =   get_terms($taxonomy_cat);

  
    // add only actions
    foreach ($tax_terms as $tax_term) {
       $icon_name   =   wpestate_limit64( 'wp_estate_icon'.$tax_term->slug);
       $limit50     =   wpestate_limit50( $tax_term->slug);
       $value       =    esc_html( get_option($icon_name) );
         
       if ( $value == ''){
          $icons[$limit50]  =    get_template_directory_uri().'/css/css-images/'.$tax_term->slug.'icon.png';  
       }else{
          $icons[$limit50]  =    $value;
       }
       
    }

    // add only categories
    foreach ($categories as $categ) { 
        $icon_name    =    wpestate_limit64( 'wp_estate_icon'.$categ->slug);
        $value        =    esc_html( get_option($icon_name) );
        $limit50      =    wpestate_limit50( $categ->slug);
        
        if ( $value == ''){
          $icons[$limit50]  =    get_template_directory_uri().'/css/css-images/'.$categ->slug.'icon.png';  
        }else{
          $icons[$limit50]  =    $value;
        }
    } 


    return json_encode($icons);
}
endif; // end   wpestate_get_icons  
=======
if( !function_exists('wpestate_pin_unit_creation') ):
    function wpestate_pin_unit_creation($the_id,$currency,$where_currency,$unit,$counter){
   
        ////////////////////////////////////// gathering data for markups
        $gmap_lat    =      floatval(get_post_meta($the_id, 'property_latitude', true));
        $gmap_long   =      floatval(get_post_meta($the_id, 'property_longitude', true));
           
        if($gmap_lat==0){
            $gmap_lat='';
        }

        if($gmap_long==0){
            $gmap_long='';
        }

        $slug        =   array();
        $prop_type   =   array();
             
        $types       =   get_the_terms($the_id,'property_category' );
        $types_act   =   get_the_terms($the_id,'property_action_category' );
            
        $prop_type_name=array();
        if ( $types && ! is_wp_error( $types ) ) { 
            foreach ($types as $single_type) {
                $prop_type[]      = $single_type->slug;
                $prop_type_name[] = $single_type->name;
                $slug             = $single_type->slug;
                $parent_term      = $single_type->parent;

            }

            $single_first_type      = $prop_type[0]; 
            $single_first_type_pin  = $prop_type[0];
            if($parent_term!=0){
                $single_first_type=$single_first_type.wpestate_add_parent_infobox($parent_term,'property_category');
            }
            $single_first_type_name= $prop_type_name[0]; 
        }else{
            $single_first_type        ='';
            $single_first_type_name   ='';
            $single_first_type_pin    ='';
        }


        ////////////////////////////////////// get property action
        $prop_action        =   array();
        $prop_action_name   =   array();
        if ( $types_act && ! is_wp_error( $types_act ) ) { 
              foreach ($types_act as $single_type) {
                $prop_action[]      =   $single_type->slug;
                $prop_action_name[] =   $single_type->name;
                $slug               =   $single_type->slug;
                $parent_term        =   $single_type->parent;
               }
        $single_first_action        = $prop_action[0];
        $single_first_action_pin    = $prop_action[0];

        if($parent_term!=0){
            $single_first_action=$single_first_action.wpestate_add_parent_infobox($parent_term,'property_action_category');
        }
        $single_first_action_name   = $prop_action_name[0];
        }else{
            $single_first_action        ='';
            $single_first_action_name   ='';
            $single_first_action_pin    ='';
        }

        // composing name of the pin
        if($single_first_action=='' || $single_first_action ==''){
              $pin                   =  sanitize_key(wpestate_limit54($single_first_type_pin.$single_first_action_pin));
        }else{
              $pin                   =  sanitize_key(wpestate_limit27($single_first_type_pin)).sanitize_key(wpestate_limit27($single_first_action_pin));
        }
        $counter++;

            
        //// get price
        $price              =   floatval    ( get_post_meta($the_id, 'property_price', true) );
        $price_label        =   esc_html    ( get_post_meta($the_id, 'property_label', true) );
        $price_label_before =   esc_html    ( get_post_meta($the_id, 'property_label_before', true) );
        $clean_price        =   floatval    ( get_post_meta($the_id, 'property_price', true) );

        if($price==0){
            $price      =   $price_label_before.''.$price_label; 
            $pin_price  =   '';
        }else{
            $th_separator   =   stripslashes ( get_option('wp_estate_prices_th_separator','') );
            $pin_price      =   $price;
            if(floor( $price ) != $price ){
                $price          =   number_format($price,2,'.',$th_separator);
            }else{
                $price          =   number_format($price,0,'.',$th_separator);
            }

            if($where_currency=='before'){
                $price=$currency.' '.$price;
            }else{
                $price=$price.' '.$currency;
            }


            if( get_option('wp_estate_use_price_pins_full_price','')=='no'){
                $pin_price  =   wpestate_price_pin_converter($pin_price,$where_currency,$currency);

            }else{
                $pin_price  =='<span class="infocur infocur_first">'.$price_label_before.'</span>'.$price.'<span class="infocur">'.$price_label.'</span>';
            }

            $price='<span class="infocur infocur_first">'.$price_label_before.'</span>'.$price.'<span class="infocur">'.$price_label.'</span>';
        }

         

        $rooms      =   get_post_meta($the_id, 'property_bedrooms', true);
        $bathrooms  =   get_post_meta($the_id, 'property_bathrooms', true);  
        $size       =   wpestate_get_converted_measure( $the_id, 'property_size' );

        $place_markers  =   array();
        $title_orig     =   get_the_title($the_id);
        $title_orig     =   str_replace('%','', $title_orig); 

        $place_markers[]    =   rawurlencode ($title_orig);//0           
        $place_markers[]    =   $gmap_lat;//1
        $place_markers[]    =   $gmap_long;//2
        $place_markers[]    =   $counter;//3
        $place_markers[]    =   rawurlencode ( get_the_post_thumbnail($the_id,'property_map1') );////4
        $place_markers[]    =   rawurlencode (  $price); //5
        $place_markers[]    =   rawurlencode ($single_first_type);//6
        $place_markers[]    =   rawurlencode ($single_first_action);//7
        $place_markers[]    =   rawurlencode ($pin);//8
        $place_markers[]    =   rawurlencode (get_permalink($the_id));//9
        $place_markers[]    =   $the_id;//10
        $place_markers[]    =   $clean_price;//11
        $place_markers[]    =   $rooms;//12
        $place_markers[]    =   $bathrooms;//13
        $place_markers[]    =   $size;//14
        $place_markers[]    =   rawurlencode ( $single_first_type_name);//15
        $place_markers[]    =   rawurlencode  ( $single_first_action_name);//16
        $place_markers[]    =   rawurlencode($pin_price);
        $place_markers[]    =   rawurlencode(get_the_post_thumbnail($the_id,'widget_thumb') );
        return $place_markers;

        
       
    }
endif;







if( !function_exists('wpestate_listing_pins_marker_creation') ):
    function wpestate_listing_pins_marker_creation($prop_selection=''){
        $counter                    =   0;
        $unit                       =   get_option('wp_estate_measure_sys','');
        $currency                   =   get_option('wp_estate_currency_symbol','');
        $where_currency             =   get_option('wp_estate_where_currency_symbol', '');
        $markers                    =   array();

        while($prop_selection->have_posts()): $prop_selection->the_post();

            $the_id      =   get_the_ID();
            ////////////////////////////////////// gathering data for markups
            $gmap_lat    =      floatval(get_post_meta($the_id, 'property_latitude', true));
            $gmap_long   =      floatval(get_post_meta($the_id, 'property_longitude', true));
           
            if($gmap_lat==0){
                $gmap_lat='';
            }
            
            if($gmap_long==0){
                $gmap_long='';
            }
                    
            $slug        =   array();
            $prop_type   =   array();
             
            $types       =   get_the_terms($the_id,'property_category' );
            $types_act   =   get_the_terms($the_id,'property_action_category' );
            
            $prop_type_name=array();
            if ( $types && ! is_wp_error( $types ) ) { 
                foreach ($types as $single_type) {
                    $prop_type[]      = $single_type->slug;
                    $prop_type_name[] = $single_type->name;
                    $slug             = $single_type->slug;
                    $parent_term      = $single_type->parent;

                }

                $single_first_type      = $prop_type[0]; 
                $single_first_type_pin  = $prop_type[0];
                if($parent_term!=0){
                    $single_first_type=$single_first_type.wpestate_add_parent_infobox($parent_term,'property_category');
                }
                $single_first_type_name= $prop_type_name[0]; 
            }else{
                $single_first_type        ='';
                $single_first_type_name   ='';
                $single_first_type_pin    ='';
            }


            ////////////////////////////////////// get property action
            $prop_action        =   array();
            $prop_action_name   =   array();
            if ( $types_act && ! is_wp_error( $types_act ) ) { 
                  foreach ($types_act as $single_type) {
                    $prop_action[]      =   $single_type->slug;
                    $prop_action_name[] =   $single_type->name;
                    $slug               =   $single_type->slug;
                    $parent_term        =   $single_type->parent;
                   }
            $single_first_action        = $prop_action[0];
            $single_first_action_pin    = $prop_action[0];

            if($parent_term!=0){
                $single_first_action=$single_first_action.wpestate_add_parent_infobox($parent_term,'property_action_category');
            }
            $single_first_action_name   = $prop_action_name[0];
            }else{
                $single_first_action        ='';
                $single_first_action_name   ='';
                $single_first_action_pin    ='';
            }

            // composing name of the pin
            if($single_first_action=='' || $single_first_action ==''){
                  $pin                   =  sanitize_key(wpestate_limit54($single_first_type_pin.$single_first_action_pin));
            }else{
                  $pin                   =  sanitize_key(wpestate_limit27($single_first_type_pin)).sanitize_key(wpestate_limit27($single_first_action_pin));
            }
            $counter++;

            
            //// get price
            $price              =   floatval    ( get_post_meta($the_id, 'property_price', true) );
            $price_label        =   esc_html    ( get_post_meta($the_id, 'property_label', true) );
            $price_label_before =   esc_html    ( get_post_meta($the_id, 'property_label_before', true) );
            $clean_price        =   floatval    ( get_post_meta($the_id, 'property_price', true) );
            
            if($price==0){
                $price      =   $price_label_before.''.$price_label; 
                $pin_price  =   '';
            }else{
                $th_separator   =   stripslashes ( get_option('wp_estate_prices_th_separator','') );
                $pin_price      =   $price;
                if(floor( $price ) != $price ){
                    $price          =   number_format($price,2,'.',$th_separator);
                }else{
                    $price          =   number_format($price,0,'.',$th_separator);
                }
                
                if($where_currency=='before'){
                    $price=$currency.' '.$price;
                }else{
                    $price=$price.' '.$currency;
                }
                 
                
                if( get_option('wp_estate_use_price_pins_full_price','')=='no'){
                    $pin_price  =   wpestate_price_pin_converter($pin_price,$where_currency,$currency);
                    
                }else{
                    $pin_price  =='<span class="infocur infocur_first">'.$price_label_before.'</span>'.$price.'<span class="infocur">'.$price_label.'</span>';
                }
            
                $price='<span class="infocur infocur_first">'.$price_label_before.'</span>'.$price.'<span class="infocur">'.$price_label.'</span>';
            }

         
            
            $rooms      =   get_post_meta($the_id, 'property_bedrooms', true);
            $bathrooms  =   get_post_meta($the_id, 'property_bathrooms', true);  
            /*
            $size       =   get_post_meta($the_id, 'property_size', true);  		
            if($size!=''){
               $size =  number_format(intval($size)) ;
            }
            */
            $size       = wpestate_get_converted_measure( $the_id, 'property_size' );
            
            $place_markers  =   array();
            $title_orig     =   get_the_title();
            $title_orig     =   str_replace('%','', $title_orig); 
           
            $place_markers[]    =   rawurlencode ($title_orig);//0           
            $place_markers[]    =   $gmap_lat;//1
            $place_markers[]    =   $gmap_long;//2
            $place_markers[]    =   $counter;//3
            $place_markers[]    =   rawurlencode ( get_the_post_thumbnail($the_id,'property_map1') );////4
            $place_markers[]    =   rawurlencode (  $price); //5
            $place_markers[]    =   rawurlencode ($single_first_type);//6
            $place_markers[]    =   rawurlencode ($single_first_action);//7
            $place_markers[]    =   rawurlencode ($pin);//8
            $place_markers[]    =   rawurlencode (get_permalink());//9
            $place_markers[]    =   $the_id;//10
            $place_markers[]    =   $clean_price;//11
            $place_markers[]    =   $rooms;//12
            $place_markers[]    =   $bathrooms;//13
            $place_markers[]    =   $size;//14
            $place_markers[]    =   rawurlencode ( $single_first_type_name);//15
            $place_markers[]    =   rawurlencode  ( $single_first_action_name);//16
            $place_markers[]    =   rawurlencode($pin_price);
            $place_markers[]    =   rawurlencode(get_the_post_thumbnail($the_id,'widget_thumb') );
            $markers[]=$place_markers;
        endwhile;   
        
        return $markers;
    }
endif;





if( !function_exists('wpestate_listing_pins_on_demand') ):
    function wpestate_listing_pins_on_demand($args='',$jump=0){
        wp_suspend_cache_addition(true);
        global $keyword;
        //set_time_limit (0);
        $counter=0;
      
        $cache                      =   get_option('wp_estate_cache','');
        $place_markers              =   array();
        $markers                    =   array();
        
        if( !empty($keyword) ){
            add_filter( 'posts_where', 'wpestate_title_filter', 10, 2 );
        }
        
        if($args['meta_key']=='prop_featured'){
            add_filter( 'posts_orderby', 'wpestate_my_order' );
        }
        
     
        if( get_option('wp_estate_use_geo_location','')=='yes' && $_POST['geo_lat']!='' && $_POST['geo_long']!='' ){
            $geo_lat    = $_POST['geo_lat'];
            $geo_long   = $_POST['geo_long'];
            $geo_rad    = $_POST['geo_rad'];
            $args       = wpestate_geo_search_filter_function( $args, $geo_lat, $geo_long, $geo_rad);
          
            
        }
        

 
        $prop_selection = new WP_Query($args);
        
        
        
        if($args['meta_key']=='prop_featured'){
           remove_filter( 'posts_orderby', 'wpestate_my_order' );
        }
        
        if( !empty($keyword) ){
            remove_filter( 'posts_where', 'wpestate_title_filter', 10, 2 );
        }
        wp_reset_query(); 


        $custom_advanced_search = get_option('wp_estate_custom_advanced_search','');
        $show_slider_price      = get_option('wp_estate_show_slider_price','');
        $has_slider             =   0; 


        $markers=wpestate_listing_pins_marker_creation($prop_selection);

        wp_suspend_cache_addition(false);
        wp_reset_query(); 
        $return_array= array();
        $return_array['markers']=$markers;
        $return_array['results']=$prop_selection->found_posts;

        return ($return_array);
    }
endif; // end   wpestate_listing_pins_on_demand  



////////////////////////////////////////////////////////////////////////////////
/// google map functions - contact pin array creation
////////////////////////////////////////////////////////////////////////////////  

if( !function_exists('wpestate_contact_pin') ):
    function wpestate_contact_pin(){
            $place_markers=array();
            $company_name=esc_html(stripslashes( get_option('wp_estate_company_name','') ) );
            if($company_name==''){
                $company_name='Company Name';
            }

            $place_markers[0]    =   $company_name;
            $place_markers[1]    =   '';
            $place_markers[2]    =   '';
            $place_markers[3]    =   1;
            $place_markers[4]    =   esc_html(get_option('wp_estate_company_contact_image', '') );
            $place_markers[5]    =   '0';
            $place_markers[6]    =   'address';
            $place_markers[7]    =   'none';
            $place_markers[8]    =   '';
            return json_encode($place_markers);
    }    
endif; // end   wpestate_contact_pin  




if( !function_exists('wpestate_add_parent_infobox') ):
    function wpestate_add_parent_infobox($parent_term,$taxonomy){
        $parent_term = get_term_by( 'id', $parent_term, $taxonomy);
        if( isset($parent_term) ){
            if(  $parent_term->parent!=0){
                return  '.'.$parent_term->slug.wpestate_add_parent_infobox($parent_term->parent,$taxonomy); 
            }else{
                return '.'.$parent_term->slug;
            } 
        }


}   
endif;




////////////////////////////////////////////////////////////////////////////////
/// google map functions - pin array creation
////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_listing_pins') ):
//function wpestate_listing_pins($args='',$jump=0,$keyword='',$id_array=''){
function wpestate_listing_pins($transient_appendix='',$with_cache=1,$args='',$jump=0,$keyword='',$id_array=''){   
    wp_suspend_cache_addition(true);
    $counter                    =   0;
    $unit                       =   get_option('wp_estate_measure_sys','');
    $currency                   =   get_option('wp_estate_currency_symbol','');
    $where_currency             =   get_option('wp_estate_where_currency_symbol', '');
    $place_markers  =   array();
    $markers        =   array();
    
    if  ( $args==''){
        $args = array(
            'post_type'                 =>    'estate_property',
            'post_status'               =>    'publish',
            'posts_per_page'            =>    intval( get_option('wp_estate_map_max_pins') ),
            'cache_results'             =>    false,
            'update_post_meta_cache'    =>    false,
            'update_post_term_cache'    =>    false,
            'fields'                    =>    'ids'
           );	
        $transient_appendix='default_pins';
    }
    if( intval($id_array)!=0 ){
        $transient_appendix='default_pins_with_ids';
    }else{
        if( !empty($keyword) ){
            $transient_appendix.='prop_title_filter';
        }

        if( isset($args['meta_key']) && $args['meta_key']=='prop_featured'){
            $transient_appendix.='_prop_featured';
        }
    }
    
    if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
        $transient_appendix.='_'. ICL_LANGUAGE_CODE;
    }
    if ( isset($_COOKIE['my_custom_curr_symbol'] ) ){
        $transient_appendix.='_'.$_COOKIE['my_custom_curr_symbol'];
    }
    if(isset($_COOKIE['my_measure_unit'])){
          $transient_appendix.= $_COOKIE['my_measure_unit'];
    }
    
    
    if($with_cache==1){
        $markers = get_transient('wpestate_markers'.$transient_appendix);
    }else{
        $markers=false;
    }

    
    if( $markers === false ) {
        if( intval($id_array)!=0 ){
                $args=  array(  
                    'post_type'     => 'estate_property',
                    'p'           =>    $id_array
                );
            $prop_selection =   new WP_Query( $args);
          
        }else{
            if( !empty($keyword) ){
                add_filter( 'posts_where', 'wpestate_title_filter', 10, 2 );
            }

            if( isset($args['meta_key']) && $args['meta_key']=='prop_featured'){
                add_filter( 'posts_orderby', 'wpestate_my_order' );
            }
        
            $prop_selection = new WP_Query($args);
            
   
            if( isset($args['meta_key']) && $args['meta_key']=='prop_featured'){
               remove_filter( 'posts_orderby', 'wpestate_my_order' );
            }

            if( !empty($keyword) ){
                remove_filter( 'posts_where', 'wpestate_title_filter', 10, 2 );
            }
        }
        
         // build markers array 
        foreach ($prop_selection->posts as $key=>$value){
            $counter++;
           
            $markers[]=wpestate_pin_unit_creation( $value,$currency,$where_currency,$unit,$counter );  
        }
        
        if($with_cache==1){
            set_transient('wpestate_markers'.$transient_appendix,$markers,4*60*60);
        }
    }
    
   //$markers    =   wpestate_listing_pins_marker_creation($prop_selection);

   
   
    wp_suspend_cache_addition(false);
    wp_reset_query(); 
    if (get_option('wp_estate_readsys','')=='yes' && $jump==0){
        $path=estate_get_pin_file_path();
        file_put_contents($path, json_encode($markers)); 
    } else{

        return json_encode($markers);
    }
}
endif; // end   wpestate_listing_pins  



if( !function_exists('wpestate_listing_pins_query_based') ):
function wpestate_listing_pins_query_based($prop_selection,$jump=0){
    
    $markers    =   wpestate_listing_pins_marker_creation($prop_selection);
    wp_suspend_cache_addition(false);
    return json_encode($markers);
    
}
endif; // end   wpestate_listing_pins  






if( !function_exists('wpestate_listing_pins_for_file') ):
function wpestate_listing_pins_for_file(){
    wp_suspend_cache_addition(true);
 
    
    $place_markers=$markers     =   array();

    $args = array(
        'post_type'                 =>    'estate_property',
        'post_status'               =>    'publish',
        'posts_per_page'            =>    -1,
        'cache_results'             =>    false,
        'update_post_meta_cache'    =>    false,
        'update_post_term_cache'    =>    false,
       );	
    
    $prop_selection =   new WP_Query($args);
    $path           =   estate_get_pin_file_path();
    
    $markers    =   wpestate_listing_pins_marker_creation($prop_selection);
    file_put_contents($path, json_encode($markers)); 
}
endif;



>>>>>>> 64662fd89bea560852792d7203888072d7452d48




////////////////////////////////////////////////////////////////////////////////
<<<<<<< HEAD
/// hover icon functiosn - return array with icons
////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_get_hover_icons') ):

function wpestate_get_hover_icons(){
    $icons          =   array();
    $taxonomy       =   'property_action_category';
    $tax_terms      =   get_terms($taxonomy);
    $taxonomy_cat   =   'property_category';
    $categories     =   get_terms($taxonomy_cat);

    // add only actions
    foreach ($tax_terms as $tax_term) {
       $hover_icon_name =   'wp_estate_hovericon'.$tax_term->slug;
       $value           =    esc_html( get_option($hover_icon_name) );
       
       if ( $value == ''){
          $icons[$tax_term->slug]  =    get_template_directory_uri().'/css/css-images/'.$tax_term->slug.'iconhover.png';  
       }else{
          $icons[$tax_term->slug]  =    $value;
       }
       
    }

    //
    // add only categories
    foreach ($categories as $categ) {
        $hover_icon_name    =   'wp_estate_hovericon'.$categ->slug;
        $value              =    esc_html( get_option($hover_icon_name) );
        
        if ( $value == ''){
          $icons[$categ->slug]  =    get_template_directory_uri().'/css/css-images/'.$categ->slug.'iconhover.png';  
        }else{
          $icons[$categ->slug]  =    $value;
        }
    } 
       

    return json_encode($icons);
}
endif; // end   wpestate_get_hover_icons  
=======
/// google map functions - pin Images array creation
////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_pin_images') ):
 
function wpestate_pin_images(){
    $pins           =   array();
    if(get_option('wp_estate_use_single_image_pin','')=='yes'){
        return json_encode($pins);
    }
    $pins = get_transient('wpestate_pin_images');
  
    if($pins===false){
        $pins           =   array();
        $taxonomy       =   'property_action_category';
        $tax_terms      =   get_terms($taxonomy);
        $taxonomy_cat   =   'property_category';
        $categories     =   get_terms($taxonomy_cat);

        foreach ($tax_terms as $tax_term) {
            $name                    =  sanitize_key( wpestate_limit64('wp_estate_'.$tax_term->slug) );
            $limit54                 =  sanitize_key( wpestate_limit54($tax_term->slug));
            $pins[$limit54]          =  esc_html( get_option($name) ); 
        }

        foreach ($categories as $categ) {
            $name                           =   sanitize_key ( wpestate_limit64('wp_estate_'.$categ->slug) );
            $limit54                        =   sanitize_key(wpestate_limit54($categ->slug));
            $pins[$limit54]                 =   esc_html( get_option($name) );
        }


        foreach ($tax_terms as $tax_term) {
            foreach ($categories as $categ) {           
                $limit54                    =   sanitize_key ( wpestate_limit27($categ->slug)).sanitize_key(wpestate_limit27($tax_term->slug) );
                $name                       =   'wp_estate_'.$limit54;
                $pins[$limit54]              =   esc_html( get_option($name) ) ;  
            }
        }
    
        $name='wp_estate_idxpin';
        $pins['idxpin']=esc_html( get_option($name) );  

        $name='wp_estate_userpin';
        $pins['userpin']=esc_html( get_option($name) );  
        set_transient('wpestate_pin_images',$pins,4*60*60);
    }

    return json_encode($pins);
}
endif; // end   wpestate_pin_images 



>>>>>>> 64662fd89bea560852792d7203888072d7452d48


if( !function_exists('wpestate_limit64') ): 
    function wpestate_limit64($stringtolimit){
<<<<<<< HEAD
        return substr($stringtolimit,0,64);
=======
        return mb_substr($stringtolimit,0,64);
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    }
endif;


if( !function_exists('wpestate_limit54') ): 
    function wpestate_limit54($stringtolimit){
<<<<<<< HEAD
        return substr($stringtolimit,0,54);
=======
        return mb_substr($stringtolimit,0,54);
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    }
endif;

if( !function_exists('wpestate_limit50') ): 
    function wpestate_limit50($stringtolimit){ // 14
<<<<<<< HEAD
        return substr($stringtolimit,0,50);
=======
        return mb_substr($stringtolimit,0,50);
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    }
endif;

if( !function_exists('wpestate_limit45') ): 
    function wpestate_limit45($stringtolimit){ // 19
<<<<<<< HEAD
        return substr($stringtolimit,0,45);
=======
        return mb_substr($stringtolimit,0,45);
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    }
endif;

if( !function_exists('wpestate_limit27') ): 
    function wpestate_limit27($stringtolimit){ // 27
<<<<<<< HEAD
        return substr($stringtolimit,0,27);
=======
        return mb_substr($stringtolimit,0,27);
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    }
endif;

?>