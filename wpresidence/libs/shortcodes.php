<?php

if( !function_exists('wpestate_recent_posts_pictures_new') ):
function wpestate_contact_us_form($attributes, $content = null){
    $return_string  =   '';
    $text_align     =   '';
    $attributes = shortcode_atts( 
        array(
            'text_align'                 => 'left',
        ), $attributes) ;


    
    if ( $attributes['text_align'] ){
        $text_align  =   $attributes['text_align'];
    }

    $return_string.='  <div class="shortcode_contact_form sh_form_align_'.$text_align.'">
     
        <div class="alert-box error">
            <div class="alert-message" id="footer_alert-agent-contact_sh"></div>
        </div> 
        
        <input type="text" placeholder="'.__('Your Name','wpestate').'" required="required"   id="foot_contact_name_sh"  name="contact_name" class="form-control" value="" tabindex="373"> 
        <input type="email" required="required" placeholder="'. __('Your Email','wpestate').'"  id="foot_contact_email_sh" name="contact_email" class="form-control" value="" tabindex="374">
        <input type="email" required="required" placeholder="'.__('Your Phone','wpestate').'"  id="foot_contact_phone_sh" name="contact_phone" class="form-control" value="" tabindex="374">
        <textarea placeholder="'.__('Type your message...','wpestate').'" required="required" id="foot_contact_content_sh" name="contact_content" class="form-control" rows="4" tabindex="375"></textarea>
        <input type="hidden" name="contact_footer_ajax_nonce" id="contact_footer_ajax_nonce_sh"  value="'.wp_create_nonce( 'ajax-footer-contact' ).'" />

        <div class="btn-cont">
            <button type="submit" id="btn-cont-submit_sh" class="wpresidence_button">'.__('Send Message','wpestate').'</button>
         
            <input type="hidden" value="" name="contact_to">
            <div class="bottom-arrow"></div>
        </div>  
    </div>';
    $return_string .= '<script type="text/javascript">
                //<![CDATA[
                jQuery(document).ready(function(){
                  wpestate_contact_us_shortcode();
                });
                //]]>
            </script>';
    //
    
    return $return_string;
}
endif;


if( !function_exists('wpestate_recent_posts_pictures_new') ):

function wpestate_recent_posts_pictures_new($attributes, $content = null) {
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
    global $property_unit_slider;
    global $no_listins_per_row;
    global $wpestate_uset_unit;
    global $custom_unit_structure;
        
    $custom_unit_structure    =   get_option('wpestate_property_unit_structure');
    $wpestate_uset_unit       =   intval ( get_option('wpestate_uset_unit','') );
    $no_listins_per_row       =   intval( get_option('wp_estate_listings_per_row', '') );

    $current_user = wp_get_current_user();
    
    $title              =   '';
    if ( isset($attributes['title']) ){
        $title=$attributes['title'];
    }

    $attributes = shortcode_atts( 
                array(
                    'title'                 =>  '',
                    'type'                  => 'properties',
                    'category_ids'          =>  '',
                    'action_ids'            =>  '',
                    'city_ids'              =>  '',
                    'area_ids'              =>  '',
                    'state_ids'             =>  '',
                    'number'                =>  4,
                    'rownumber'             =>  4,
                    'align'                 =>  'vertical',
                    'link'                  =>  '',
                    'control_terms_id'      =>  '',
                    'show_featured_only'    =>  'no',
                    'random_pick'           =>  'no',
                    'featured_first'        =>  'no'
                ), $attributes) ;

    

    
    $userID             =   $current_user->ID;
    $user_option        =   'favorites'.$userID;
    $curent_fav         =   get_option($user_option);
    $property_unit_slider = get_option('wp_estate_prop_list_slider','');
    
    
    $options            =   wpestate_page_details($post->ID);
    $return_string      =   '';
    $pictures           =   '';
    $button             =   '';
    $class              =   '';
    $category=$action=$city=$area=$state='';
    $control_terms_id   =   '';
    
    $currency           =   esc_html( get_option('wp_estate_currency_symbol', '') );
    $where_currency     =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
    $is_shortcode       =   1;
    $show_compare_only  =   'no';
    $row_number_col     =   '';
    $row_number         =   '';       
    $show_featured_only =   '';
    $random_pick        =   '';
    $featured_first     =   '';
    $orderby            =   'meta_value';
   

    $property_card_type         =   intval(get_option('wp_estate_unit_card_type'));
    $property_card_type_string  =   '';
    if($property_card_type==0){
        $property_card_type_string='';
    }else{
        $property_card_type_string='_type'.$property_card_type;
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
    
    if ( isset($attributes['state_ids']) ){
        $state=$attributes['state_ids'];
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
    
    
    if( isset($attributes['control_terms_id'])){
        $control_terms_id=$attributes['control_terms_id'];
    }
    
    if (isset($attributes['featured_first'])){
        $featured_first=   $attributes['featured_first'];
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
        $state_array    =   '';
        
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
        
        if($state!=''){
            $state_of_tax   =   array();
            $state_of_tax   =   explode(',', $state);
            $state_array    =   array(     
                                'taxonomy'  => 'property_county_state',
                                'field'     => 'term_id',
                                'terms'     => $state_of_tax
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

            if($featured_first=="no"){
                $orderby='ID';
            }
            
            $args = array(
                'post_type'         => $type,
                'post_status'       => 'publish',
                'paged'             => 1,
                'posts_per_page'    => $post_number_total,
                'meta_key'          => 'prop_featured',
                'orderby'           => $orderby,
                'order'             => 'DESC',
                'meta_query'        => $meta_query,
                'tax_query'         => array( 
                                        $category_array,
                                        $action_array,
                                        $city_array,
                                        $area_array,
                                        $state_array
                                    )
              
            );
        

          
    } else {
        $type = 'post';
  
       
        
        $args = array(
            'post_type'      => $type,
            'post_status'    => 'publish',
            'paged'          => 0,
            'posts_per_page' => $post_number_total,
            'orderby'           => $orderby,
            //'cat'            => $category
        );
    }


        if ($attributes['type'] == 'properties') {
            $button .= '<div class="listinglink-wrapper_sh_listings">
               <span class="wpresidence_button wpestate_item_list_sh">'.__('load more listings','wpestate').' </span>
               </div>';
        } else {
            $button .= '<div class="listinglink-wrapper_sh_listings">
               <span class="wpresidence_button wpestate_item_list_sh">  '.__('load articles','wpestate').' </span>
               </div>';
        }
    
    
    if ($attributes['type'] != 'properties') {
          $class.=" blogs_wrapper ";
    }

    
    if($category!=''){
        $category.=',';
    }
    if($action!=''){
        $action.=',';
    }
    if($city!=''){
        $city.=',';
    }
    if($area!=''){
        $area.=',';
    }
    if($state!=''){
        $state.=',';
    }
    $anime_id='wpestate_sh_anime_'.rand(1,999);
    $return_string .= '<div id="'.$anime_id.'" class="article_container wpestate_latest_listings_sh bottom-'.$type.' '.$class.'"  '
            . 'data-type="'.$type.'" '
            . 'data-category_ids="'.$category.'" '
            . 'data-action_ids="'.$action.'" '
            . 'data-city_ids="'.$city.'" '
            . 'data-area_ids="'.$area.'" '
            . 'data-state_ids="'.$state.'" '
            . 'data-number="'.$post_number_total.'" '
            . 'data-row-number="'.$row_number.'" '
            . 'data-align="'.$attributes['align'].'" '
            . 'data-show_featured_only="'.$show_featured_only.'"  '
            . 'data-random_pick="'.$random_pick.'"  '
            . 'data-featured_first="'.$featured_first.'" '
            . 'data-page="1" >';
    if($title!=''){
         $return_string .= '<h2 class="shortcode_title">'.$title.'</h2>';
    }
  
    
    if($control_terms_id !=''){
        //$control_taxonomy           =   'apartments,condos,sales,rentals,jersey city';
        //$control_taxonomy           =   '12,17,26,28';
        
        $control_taxonomy_array     =   explode (',',$control_terms_id);
        
        $return_string.='<div class="control_tax_wrapper">';
        foreach($control_taxonomy_array as $key=>$term_name){
            $term_data      =   get_term($term_name);
            if(isset($term_data->term_id)){
                $return_string .=   '<div  class="control_tax_sh" data-taxid="'.$term_data->term_id.'" data-taxonomy="'.$term_data->taxonomy.'">'.$term_data->name.'</div>';
            }
        }
        $return_string.='</div>';
        
        
    }
    
    $transient_name= 'wpestate_recent_posts_pictures_query_' . $type . '_' . $category . '_' . $action . '_' . $city . '_' . $area.'_'.$state.'_'.$row_number.'_'.$post_number_total.'_'.$featured_first.'_'.$align.'_'.$random_pick;
   
    if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
        $transient_name.='_'. ICL_LANGUAGE_CODE;
    }
    if ( isset($_COOKIE['my_custom_curr_symbol'] ) ){
        $transient_name.='_'.$_COOKIE['my_custom_curr_symbol'];
    }
    if(isset($_COOKIE['my_measure_unit'])){
        $transient_name.= $_COOKIE['my_measure_unit'];
    }
    
    
    $templates = get_transient( $transient_name);
    
 
    if( $templates === false ) {
        
        if ($attributes['type'] == 'properties') {
            if($random_pick !=='yes'){
                if($featured_first=='yes'){
                    add_filter( 'posts_orderby', 'wpestate_my_order' ); 
                }

                $recent_posts = new WP_Query($args);
                $count = 1;
                if($featured_first=='yes'){
                    remove_filter( 'posts_orderby', 'wpestate_my_order' ); 
                }
            }else{

                $args['orderby']    =   'rand';
                $recent_posts = new WP_Query($args); 
                $count = 1;
            }

        }else{
            $recent_posts = new WP_Query($args);
            $count = 1;
        }
    
    
        ob_start();  
        while ($recent_posts->have_posts()): $recent_posts->the_post();
            if($type == 'estate_property'){
                get_template_part('templates/property_unit'.$property_card_type_string);
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
        set_transient( $transient_name,wpestate_html_compress( $templates ), 60*60*4 );
    
    }
    
    
    
    
    $return_string .=$templates;

    
    $return_string.='<div class="wpestate_listing_sh_loader">
       <div class="new_prelader"></div>
        
    </div>';
    
    $return_string .=$button;
    
    
    $return_string .= '</div>';
    
    if ($attributes['type'] == 'properties'){
            $return_string .= '<script type="text/javascript">
                //<![CDATA[
                jQuery(document).ready(function(){
                    wpestate_anime("#'.$anime_id.'");
                    wpestate_property_list_sh("#'.$anime_id.' .wpestate_item_list_sh", "#'.$anime_id.' .control_tax_sh");
                });
                //]]>
            </script>';
    }
    if ($attributes['type'] == 'articles'){
            $return_string .= '<script type="text/javascript">
                //<![CDATA[
                jQuery(document).ready(function(){
                    wpestate_anime("#'.$anime_id.'");
                    wpestate_property_list_sh("#'.$anime_id.' .wpestate_item_list_sh", "#'.$anime_id.' .control_tax_sh");
                    
                });
                //]]>
            </script>';
    }
    
    wp_reset_query();
    $is_shortcode       =   0;
    return $return_string;
    
    
}
endif; // end   wpestate_recent_posts_pictures 




if( !function_exists('wpestate_property_page_map_function') ):
function wpestate_property_page_map_function( $attributes,$content = null) {
    global $post;
    $use_mimify     =   get_option('wp_estate_use_mimify','');
    $mimify_prefix  =   '';
    if($use_mimify==='yes'){
        $mimify_prefix  =   '.min';    
    }
    
    if ( !wp_script_is( 'mapfunctions', 'enqueued' ) && !wp_script_is( 'googlemap', 'enqueued' )) {
        if (esc_html ( get_option('wp_estate_ssl_map','') ) =='yes'){
            wp_enqueue_script('googlemap',      'https://maps-api-ssl.google.com/maps/api/js?key='.esc_html(get_option('wp_estate_api_key', '') ).'',array('jquery'), '1.0', false);
        }else{
            wp_enqueue_script('googlemap',      'http://maps.googleapis.com/maps/api/js?key='.esc_html(get_option('wp_estate_api_key', '') ).'',array('jquery'), '1.0', false);
        }
        wp_enqueue_script('infobox',  get_template_directory_uri() .'/js/infobox'.$mimify_prefix.'.js',array('jquery'), '1.0', true); 
        wp_enqueue_script('mapfunctions', get_template_directory_uri().'/js/google_js/mapfunctions'.$mimify_prefix.'.js',array('jquery'), '1.0', true);   
        $pin_images=wpestate_pin_images();
        wp_localize_script('mapfunctions', 'mapfunctions_vars', 
                array(  'pin_images'           =>  $pin_images,
                        'map_style'            =>  stripslashes (  get_option('wp_estate_map_style','') ),
                    ) 
        );
    }
    
    
    $return_string='';
    $istab=0;
    $attributes = shortcode_atts( 
		array(
		'propertyid' => '',
                'istab' =>'',
		), $attributes );
        
    if ( isset($attributes['propertyid']) ){
       $the_id=$propertyid=$attributes['propertyid'];
    }

    if ( isset($attributes['istab']) ){
       $istab=$attributes['istab'];
    }
    
    if ( isset($attributes['single_marker']) ){
        $nooflisting=$attributes['single_marker'];
    }
    
    
    $currency               =   get_option('wp_estate_currency_symbol','');
    $where_currency         =   get_option('wp_estate_where_currency_symbol', '');
    $title_orig             =   get_the_title($the_id);
    $title_orig             =   str_replace('%','', $title_orig);  
    $types                  =   get_the_terms($the_id,'property_category' );
    if ( $types && ! is_wp_error( $types ) ) { 
        foreach ($types as $single_type) {
           $prop_type[]      =  $single_type->name;//$single_type->slug;
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
   
   
    $types_act   =   get_the_terms($the_id,'property_action_category' );
    if ( $types_act && ! is_wp_error( $types_act ) ) { 
            foreach ($types_act as $single_type) {
              $prop_action[]      =   $single_type->name;//$single_type->slug;
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

          
    if($single_first_action=='' || $single_first_action ==''){
        $pin                   =  sanitize_key(wpestate_limit54($single_first_type_pin.$single_first_action_pin));
    }else{
        $pin                   =  sanitize_key(wpestate_limit27($single_first_type_pin)).sanitize_key(wpestate_limit27($single_first_action_pin));
    } 
    
    //// get price
    $price              =   floatval    ( get_post_meta($the_id, 'property_price', true) );
    $price_label        =   esc_html    ( get_post_meta($the_id, 'property_label', true) );
    $price_label_before =   esc_html    ( get_post_meta($the_id, 'property_label_before', true) );
    $clean_price        =   floatval    ( get_post_meta($the_id, 'property_price', true) );
    if($price==0){
        $price          =   $price_label_before.''.$price_label; 
         $pin_price     =   '';
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
            $pin_price  =="<span class='infocur infocur_first'>".$price_label_before."</span>".$price."<span class='infocur'>".$price_label."</span>";
           
        }

        $price="<span class='infocur infocur_first'>".$price_label_before."</span>".$price."<span class='infocur'>".$price_label."</span>";
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
	
	
    $gmap_lat          =    esc_html( get_post_meta($propertyid, 'property_latitude', true));
    $gmap_long         =    esc_html( get_post_meta($propertyid, 'property_longitude', true));
    $property_add_on   =    ' data-post_id="'.$propertyid.'" data-cur_lat="'.$gmap_lat.'" data-cur_long="'.$gmap_long.'" ';
    $property_add_on   .=   ' data-title="'.$title_orig.'"  data-pin="'.$pin.'" data-thumb="'. rawurlencode ( get_the_post_thumbnail($the_id,'property_map1') ).'" ';      
    $property_add_on   .=   ' data-price="'.$price.'" ';
    $property_add_on   .=   ' data-single-first-type="'.rawurlencode ($single_first_type).'"  data-single-first-action="'.rawurlencode ($single_first_action).'" ';
    $property_add_on   .=   ' data-rooms="'.$rooms.'" data-size="'.$size.'" data-bathrooms="'.$bathrooms.'" ';
    $property_add_on   .=   ' data-prop_url="'.rawurlencode(get_permalink($the_id)).'" ';
    $property_add_on   .=   ' data-pin_price="'.$pin_price.'" ';
    $property_add_on   .=   ' data-clean_price="'.$clean_price.'" ';
    
    
    
    $return_string ='<div class="google_map_shortcode_wrapper">
                <div id="gmapzoomplus_sh"  class="smallslidecontrol shortcode_control" ><i class="fa fa-plus"></i> </div>
                <div id="gmapzoomminus_sh" class="smallslidecontrol shortcode_control" ><i class="fa fa-minus"></i></div>';
                $return_string .= wpestate_show_poi_onmap('sh');
                $return_string .= '<div id="slider_enable_street_sh" data-placement="bottom" data-original-title="'.__('Street View','wpestate').'"> <i class="fa fa-location-arrow"></i>    </div>';
    $return_string .='<div id="googleMap_shortcode" '.$property_add_on.' ></div></div>';
    
    if($istab!=1){
    $return_string .= '<script type="text/javascript">
                //<![CDATA[
                jQuery(document).ready(function(){
                    wpestate_map_shortcode_function();
                    
                });
                //]]>
            </script>';
    }
    return $return_string;
        
}
endif;

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  shortcode - Listings per agent
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wplistingsperagent_shortcode_function') ):
function wplistingsperagent_shortcode_function( $attributes,$content = null) {
    global $post;
    global $no_listins_per_row;
    global $wpestate_uset_unit;
    global $custom_unit_structure;
        
    $custom_unit_structure    =     get_option('wpestate_property_unit_structure'); 
    $wpestate_uset_unit       =     intval ( get_option('wpestate_uset_unit','') );
    $no_listins_per_row       =     intval( get_option('wp_estate_listings_per_row', '') );
    $return_string            =     '';
    
    $property_card_type         =   intval(get_option('wp_estate_unit_card_type'));
    $property_card_type_string  =   '';
    if($property_card_type==0){
        $property_card_type_string='';
    }else{
        $property_card_type_string='_type'.$property_card_type;
    }
        
    $attributes = shortcode_atts( 
        array(
            'agentid' => '',
            'nooflisting' => '',
            'type'  => 'estate_property',
        ), $attributes );
        
        if ( isset($attributes['agentid']) ){
            $agentid=$attributes['agentid'];
    	}
        
        if ( isset($attributes['nooflisting']) ){
            $nooflisting=$attributes['nooflisting'];
    	}
        if ( isset($attributes['type']) ){
            $type=$attributes['type'];
    	}
	
        $args = array(
                'post_type'         => $type,
                'post_status'       => 'publish',
                'order'             => 'ASC',
				'paged'          	=> 0,
				'posts_per_page' 	=> $nooflisting ,
                'meta_query'        =>  array(
				array(
          			 'key' => 'property_agent',
          			 'value' => $agentid,
           			'compare' => '=',
       				)
				)
            );
			
        $listings_per_agent = new WP_Query($args);
        ob_start(); 
    
        while ($listings_per_agent->have_posts()): $listings_per_agent->the_post(); 
            get_template_part('templates/property_unit'.$property_card_type_string);
        endwhile;
        
        $return_string ='<div class="article_container">'. ob_get_contents().'</div>';
        ob_end_clean(); 
        wp_reset_postdata();
        wp_reset_query();
        return $return_string;
     
}
endif;


////////////////////////////////////////////////////////////////////////////////
// place list 
////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_places_list_function') ):
function wpestate_places_list_function($attributes, $content = null) {
    global $full_page;
    global $is_shortcode;
    global $row_number_col;
    global $place_id;
    global $place_per_row;
    $is_shortcode       =1;
    $place_list         ='';
    $return_string      ='';
    $extra_class_name   ='';
    $place_type         = '';
    
    $attributes = shortcode_atts( 
        array(
            'place_list'                       => '',
            'place_per_row'                    => 4,
            'extra_class_name'                 => '',
            'place_type'                       =>  1,
        ), $attributes) ;

    
    $post_number_total = $attributes['place_per_row'];
    if ( isset($attributes['place_per_row']) ){
        $row_number        = $attributes['place_per_row']; 
    }
    if ( isset($attributes['place_type']) ){
        $place_type        = $attributes['place_type']; 
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
        if( isset($attributes['align']) && $attributes['align']=='vertical'){
             $row_number_col =  0;
        }
    }
    
    
    if ( isset($attributes['place_list']) ){
        $place_list=$attributes['place_list'];
    }
    if ( isset($attributes['place_per_row']) ){
        $place_per_row=$attributes['place_per_row'];
    }
    
    if($place_per_row>5){
        $place_per_row=5;
    }
    
    if( isset($attributes['extra_class_name'])){
        $extra_class_name=$attributes['extra_class_name'];
    }    
    
  
    
    $all_places_array=  explode(',', $place_list);
    
    
 

    ob_start(); 
    
    foreach($all_places_array as $place_id){
        $place_id=intval($place_id);
        if($place_type==1){
            get_template_part('templates/places_unit');     
        }else{
             get_template_part('templates/places_unit_type2');     
        }
    }
    
    $return_string ='<div class="article_container">'. ob_get_contents().'</div>';
    ob_end_clean(); 
    $is_shortcode       =0;
    return $return_string;
     
}
endif;


////////////////////////////////////////////////////////////////////////////////////////////
///  shortcode - agent list
////////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_list_agents_function') ):

function wpestate_list_agents_function($attributes, $content = null) {
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
    global $property_unit_slider;


   // get_currentuserinfo();
   $current_user = wp_get_current_user();
    
    $title              =   '';
    if ( isset($attributes['title']) ){
        $title=$attributes['title'];
    }

    $attributes = shortcode_atts( 
                array(
                    'title'                 =>  '',
                    'type'                  => 'estate_agent',
                    'category_ids'          =>  '',
                    'action_ids'            =>  '',
                    'city_ids'              =>  '',
                    'area_ids'              =>  '',
                    'number'                =>  4,
                    'rownumber'             =>  4,
                    'align'                 =>  'vertical',
                    'link'                  =>  '',
                    'random_pick'           =>  'no'
                ), $attributes) ;

    

    
    $userID             =   $current_user->ID;
    $user_option        =   'favorites'.$userID;
    $curent_fav         =   get_option($user_option);
    $property_unit_slider = get_option('wp_estate_prop_list_slider','');
    
    
    $options            =   wpestate_page_details($post->ID);
    $return_string      =   '';
    $pictures           =   '';
    $button             =   '';
    $class              =   '';
    $category=$action=$city=$area='';
    
    $currency           =   esc_html( get_option('wp_estate_currency_symbol', '') );
    $where_currency     =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
    $is_shortcode       =   1;
    $show_compare_only  =   'no';
    $row_number_col     =   '';
    $row_number         =   '';       
    $show_featured_only =   '';
    $random_pick        =   '';
    $orderby            =   'ID';
    $transient_name='wpestate_sh_agent_list';
   
    
    if ( isset($attributes['category_ids']) ){
        $category=$attributes['category_ids'];
        $transient_name.='_'.$category;
    }
   

    if ( isset($attributes['action_ids']) ){
        $action=$attributes['action_ids'];
        $transient_name.='_'.$action;
    }

    if ( isset($attributes['city_ids']) ){
        $city=$attributes['city_ids'];
        $transient_name.='_'.$city;
    }

    if ( isset($attributes['area_ids']) ){
        $area=$attributes['area_ids'];
        $transient_name.='_'.$area;
    }
    
    

    if (isset($attributes['random_pick'])){
        $random_pick=   $attributes['random_pick'];
        if($random_pick==='yes'){
            $orderby    =   'rand';
            $transient_name.='_rand';
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
     $transient_name.='_row'.$row_number.'_'.$post_number_total;
    
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
    
  
 
        $type = 'estate_agent';
        
        $category_array =   '';
        $action_array   =   '';
        $city_array     =   '';
        $area_array     =   '';
        
        // build category array
        if($category!=''){
            $category_of_tax=array();
            $category_of_tax=  explode(',', $category);
            $category_array=array(     
                            'taxonomy'  => 'property_category_agent',
                            'field'     => 'term_id',
                            'terms'     => $category_of_tax
                            );
        }
            
        
        // build action array
        if($action!=''){
            $action_of_tax=array();
            $action_of_tax=  explode(',', $action);
            $action_array=array(     
                            'taxonomy'  => 'property_action_category_agent',
                            'field'     => 'term_id',
                            'terms'     => $action_of_tax
                            );
        }
        
        // build city array
        if($city!=''){
            $city_of_tax=array();
            $city_of_tax=  explode(',', $city);
            $city_array=array(     
                            'taxonomy'  => 'property_city_agent',
                            'field'     => 'term_id',
                            'terms'     => $city_of_tax
                            );
        }
        
        // build city array
        if($area!=''){
            $area_of_tax=array();
            $area_of_tax=  explode(',', $area);
            $area_array=array(     
                            'taxonomy'  => 'property_area_agent',
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
                'post_type'         => 'estate_agent',
                'post_status'       => 'publish',
                'paged'             => 0,
                'posts_per_page'    => $post_number_total,
           
                'orderby'           => $orderby,
                'order'             => 'DESC',
            
                'tax_query'         => array( 
                                        $category_array,
                                        $action_array,
                                        $city_array,
                                        $area_array
                                    )
              
            );
     



    if ( isset($attributes['link']) && $attributes['link'] != '') {
        $button .= '<div class="listinglink-wrapper">
               <a href="' . $attributes['link'] . '"> <span class="wpresidence_button">'.__('more listings','wpestate').' </span></a> 
               </div>';        
    } else {
        $class = "nobutton";
    }

    $return_string .=   '<div class="article_container bottom-'.$type.' '.$class.'" >';
    if($title!=''){
        $return_string .= '<h2 class="shortcode_title">'.$title.'</h2>';
    }


    if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
        $transient_name.='_'. ICL_LANGUAGE_CODE;
    }
    $templates =get_transient($transient_name);
    
    if($templates===false){
        $recent_posts   =   new WP_Query($args); 
       
        ob_start();  
        while ($recent_posts->have_posts()): $recent_posts->the_post();
            print '<div class="col-md-'.$row_number_col.' listing_wrapper">';
                get_template_part('templates/agent_unit');       
            print '</div>';
        endwhile;

        $templates = ob_get_contents();
        ob_end_clean(); 
    
        set_transient($transient_name,wpestate_html_compress($templates),60*60*24);
    }
    
    
    $return_string .=$templates;
    $return_string .=$button;
    $return_string .= '</div>';
    wp_reset_query();
    $is_shortcode       =   0;
    return $return_string;
    
    
}
endif; // end   


////////////////////////////////////////////////////////////////////////////////////////////
///  shortcode - recent post with picture
////////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_slider_recent_posts_pictures') ):

function wpestate_slider_recent_posts_pictures($attributes) {
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
    global $property_unit_slider;
    global $prop_unit;
    global $no_listins_per_row;
    global $wpestate_uset_unit;
    global $custom_unit_structure;
        
    $custom_unit_structure    =   get_option('wpestate_property_unit_structure');
    $wpestate_uset_unit       =   intval ( get_option('wpestate_uset_unit','') );
    $no_listins_per_row       =   intval( get_option('wp_estate_listings_per_row', '') );
    $prop_unit          =   'grid';
    $options            =   wpestate_page_details($post->ID);
    $return_string      =   '';
    $pictures           =   '';
    $button             =   '';
    $class              =   '';
    $category           =   '';
    $action             =   '';
    $city               =   '';
    $area               =   '';
    $state              =   '';
    $title              =   '';
    $currency           =   esc_html( get_option('wp_estate_currency_symbol', '') );
    $where_currency     =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
    $is_shortcode       =   1;
    $show_compare_only  =   'no';
    $row_number_col     =   '';
    $row_number         =   '';       
    $show_featured_only =   '';
    $autoscroll         =   '';
    $property_unit_slider = get_option('wp_estate_prop_list_slider','');
    $templates          =   '';
    $featured_first     =   'no';
    $current_user       =   wp_get_current_user();
    $userID             =   $current_user->ID;
    $user_option        =   'favorites'.$userID;
    $curent_fav         =   get_option($user_option);


   
    $title              =   '';
   
    
    $property_card_type         =   intval(get_option('wp_estate_unit_card_type'));
    $property_card_type_string  =   '';
    if($property_card_type==0){
        $property_card_type_string='';
    }else{
        $property_card_type_string='_type'.$property_card_type;
    }
     
    $attributes = shortcode_atts( 
                array(
                    'title'                 =>  '',
                    'type'                  => 'properties',
                    'category_ids'          =>  '',
                    'action_ids'            =>  '',
                    'city_ids'              =>  '',
                    'area_ids'              =>  '',
                    'state_ids'             =>  '',
                    'number'                =>  4,
                    'show_featured_only'    =>  'no',
                    'random_pick'           =>  'no',
                    'autoscroll'            =>  0,
                    'featured_first'        =>  'no'
                ), $attributes) ;

     if ( isset($attributes['title']) ){
        $title=$attributes['title'];
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
     
    if ( isset($attributes['state_ids']) ){
        $state=$attributes['state_ids'];
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
   
       
    if (isset($attributes['featured_first'])){
        $featured_first=   $attributes['featured_first'];
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
        $state_array    =   '';
        
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
        
         if($state!=''){
            $state_of_tax    =   array();
            $state_of_tax    =   explode(',', $state);
            $state_array=array(     
                            'taxonomy'  => 'property_county_state',
                            'field'     => 'term_id',
                            'terms'     => $state_of_tax
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
        
            
            $orderby            =   'meta_value';
            if($featured_first=="no"){
                $orderby='ID';
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
                                        $area_array,
                                        $state_array
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
               <a href="' . $attributes['link'] . '"> <span class="wpresidence_button">'.__('more listings','wpestate').' </span></a> 
               </div>';
        } else {
            $button .= '<div class="listinglink-wrapper">
               <a href="' . $attributes['link'] . '"> <span class="wpresidence_button">  '.__('more articles','wpestate').' </span></a> 
               </div>';
        }
    } else {
        $class = "nobutton";
    }


    
      
   

    $return_string .= '<div class="article_container slider_container bottom-'.$type.' '.$class.'" >';

    if($title!=''){
         $return_string .= '<h2 class="shortcode_title title_slider">'.$title.'</h2>';
    }

    $is_autoscroll  =   '';
    $is_autoscroll  =   ' data-auto="'.$autoscroll.'" '; 

    $items_per_row         =   intval( get_option('wp_estate_listings_per_row', '') );
    if($type != 'estate_property'){
        $items_per_row  =    intval( get_option('wp_estate_blog_listings_per_row', '') );
    }

    $three_per_row_class='';
    if($items_per_row==3){
        $three_per_row_class = ' three_per_row ';
    }


    $return_string .=  '<div class="shortcode_slider_wrapper" >';
    
    
    $transient_name= 'wpestate_recent_posts_slider_' . $type . '_' . $category . '_' . $action . '_' . $city . '_' . $area.'_'.$state.'_'.$row_number.'_'.$post_number_total.'_'.$featured_first.'_'.$show_featured_only.'_'.$is_autoscroll;
   
    if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
        $transient_name.='_'. ICL_LANGUAGE_CODE;
    }
    if ( isset($_COOKIE['my_custom_curr_symbol'] ) ){
        $transient_name.='_'.$_COOKIE['my_custom_curr_symbol'];
    }
    if(isset($_COOKIE['my_measure_unit'])){
        $transient_name.= $_COOKIE['my_measure_unit'];
    }
    
    
    
    $templates = get_transient( $transient_name);

    if($templates === false ){


        if ($attributes['type'] == 'properties') {
            if($featured_first=='yes'){
                add_filter( 'posts_orderby', 'wpestate_my_order' ); 
            }

            $recent_posts = new WP_Query($args);
            $count = 1;
            if($featured_first=='yes'){
                remove_filter( 'posts_orderby', 'wpestate_my_order' ); 
            }
        }else{
            $recent_posts = new WP_Query($args);
            $count = 1;
        }

        ob_start();
        print '<div class="shortcode_slider_list" data-items-per-row="'.$items_per_row.'" '.$is_autoscroll.'>';


        while ($recent_posts->have_posts()): $recent_posts->the_post();
            print '<div class=" slider_prop_wrapper  '.$three_per_row_class.' " >';

            if($type == 'estate_property'){
                get_template_part('templates/property_unit'.$property_card_type_string);
            } else {
                if( isset($attributes['align']) && $attributes['align']=='horizontal'){
                    get_template_part('templates/blog_unit');
                }else{
                    get_template_part('templates/blog_unit2');
                }
            }
            print '</div>';
        endwhile;


        $templates = ob_get_contents();
        ob_end_clean(); 
        set_transient ($transient_name,wpestate_html_compress($templates),4*60*60);
    }
    
    
    
    $return_string .=$templates;
    $return_string .=$button;
    
    $return_string .= '</div></div>';// end shrcode wrapper
    $return_string .= '</div>';
    wp_reset_query();
    wp_reset_postdata();
    $is_shortcode       =   0;
    
  
    return $return_string;
    
    
}
endif; // end   wpestate_slider_recent_posts_pictures 


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
    
   
    
    
    $title              =   '';
    if ( isset($attributes['title']) ){
        $title=$attributes['title'];
    }
    

    
    $attributes = shortcode_atts( 
                array(
                    'title'                       => 'title',
                    'image'                       => '',
                    'content_box'                 => 'Content of the box goes here',
                    'image_effect'                =>  'yes',  
                    'link'                        =>  ''
                ), $attributes) ;

    
    
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
            $return_string .= '  <a href="'.$link.'"><img src="' .$image . '"  class="img-responsive" alt="thumb"/ ></a>
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
    
    
    

    
    $attributes = shortcode_atts( 
                array(
                    'type'            => '1',
                    'height'          => '40',                    
                ), $attributes) ;

    
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
        $search_col         =   3;
        $search_col_but     =   3;
        $search_col_price   =   6;
        if ( isset($attributes['title']) ){
            $title=$attributes['title'];    
        }
    
        $args = wpestate_get_select_arguments();
        $action_select_list =   wpestate_get_action_select_list($args);
        $categ_select_list  =   wpestate_get_category_select_list($args);
        $select_city_list   =   wpestate_get_city_select_list($args); 
        $select_area_list   =   wpestate_get_area_select_list($args);
        $select_county_state_list   =   wpestate_get_county_state_select_list($args);


        $adv_submit=wpestate_get_template_link('advanced_search_results.php');
     
        if($title!=''){
            
        }
        
        $return_string .= '<h2 class="shortcode_title_adv">'.$title.'</h2>';
        $return_string .= '<div class="advanced_search_shortcode" id="advanced_search_shortcode">
        <form role="search" method="get"   action="'.$adv_submit.'" >';
        
     
        if (function_exists('icl_translate') ){
            $return_string .=  do_action( 'wpml_add_language_form_field' );
        }
        
        

        if($custom_advanced_search=='yes'){
                $adv_search_type        =   get_option('wp_estate_adv_search_type','');
                $adv_search_what        =   get_option('wp_estate_adv_search_what','');
                $adv_search_label       =   get_option('wp_estate_adv_search_label','');
                $adv_search_how         =   get_option('wp_estate_adv_search_how','');
                $count=0;
                ob_start();
                $search_field='';
                $adv_search_fields_no_per_row   =   ( floatval( get_option('wp_estate_search_fields_no_per_row') ) );
                
                if ( $adv_search_type==6 ){    
                    $adv6_taxonomy          =   get_option('wp_estate_adv6_taxonomy');
                
                    if ($adv6_taxonomy=='property_category'){
                        $search_field="categories";
                    }else if ($adv6_taxonomy=='property_action_category'){
                        $search_field="types";
                    }else if ($adv6_taxonomy=='property_city'){
                        $search_field="cities";
                    }else if ($adv6_taxonomy=='property_area'){
                        $search_field="areas";
                    }else if ($adv6_taxonomy=='property_county_state'){
                        $search_field="county / state";
                    }
                        
                    $search_col         =   3;
                    $search_col_but     =   3;
                    $search_col_price   =   6;
                    if($adv_search_fields_no_per_row==2){
                        $search_col         =   6;
                        $search_col_but     =   6;
                        $search_col_price   =   12;
                    }else  if($adv_search_fields_no_per_row==3){
                        $search_col         =   4;
                        $search_col_but     =   4;
                        $search_col_price   =   8;
                    }
                    
                    print '<div class="col-md-'.$search_col.' ">';
                        wpestate_show_search_field_tab_inject('shortcode',$search_field,$action_select_list,$categ_select_list,$select_city_list,$select_area_list,'',$select_county_state_list);
                    print '</div>';
                    
                }
                
                if($adv_search_type==10 ){
                    $adv_actions_value=__('All Actions','wpestate');
                    $adv_actions_value1='all';
            
                    print '<div class="col-md-9">
                        <input type="text" id="adv_location" class="form-control" name="adv_location"  placeholder="'.__('Type address, state, city or area','wpestate').'" value="">      
                    </div>';
                    
                    print'
                    <div class="col-md-3">    
                        <div class="dropdown form-control listing_filter_select" >
                            <div data-toggle="dropdown" id="adv_actions" class="filter_menu_trigger" data-value="'.strtolower ( rawurlencode ( $adv_actions_value1) ).'"> 
                                '.$adv_actions_value.' 
                            <span class="caret caret_filter"></span> </div>           
                            <input type="hidden" name="filter_search_action[]" value="">
                            <ul  class="dropdown-menu filter_menu" role="menu" aria-labelledby="adv_actions">
                                '.$action_select_list.'
                            </ul>        
                        </div>
                    </div>';
                    print '<input type="hidden" name="is10" value="10">';
                }
                
                
                
                if($adv_search_type==11 ){
                    $adv_actions_value=__('All Actions','wpestate');
                    $adv_actions_value1='all';
                    $adv_categ_value    = __('All Types','wpestate');
                    $adv_categ_value1   ='all';
            
                    print'  
                    <div class="col-md-6">
                    <input type="text" id="keyword_search" class="form-control" name="keyword_search"  placeholder="'. __('Type Keyword','wpestate').'" value="">      
                    </div>';
                    
                    print '
                    <div class="col-md-3">
                        <div class="dropdown form-control listing_filter_select" >
                            <div data-toggle="dropdown" id="adv_categ" class="filter_menu_trigger"  data-value="'.strtolower ( rawurlencode( $adv_categ_value1)).'"> 
                                '.$adv_categ_value.'               
                            <span class="caret caret_filter"></span> </div>           
                            <input type="hidden" name="filter_search_type[]" value="">
                            <ul  class="dropdown-menu filter_menu" role="menu" aria-labelledby="adv_categ">
                                '.$categ_select_list.'
                            </ul>
                        </div>    
                    </div>';
               
                    print'
                    <div class="col-md-3">    
                        <div class="dropdown form-control listing_filter_select" >
                            <div data-toggle="dropdown" id="adv_actions" class="filter_menu_trigger" data-value="'.strtolower ( rawurlencode ( $adv_actions_value1) ).'"> 
                                '.$adv_actions_value.' 
                            <span class="caret caret_filter"></span> </div>           
                            <input type="hidden" name="filter_search_action[]" value="">
                            <ul  class="dropdown-menu filter_menu" role="menu" aria-labelledby="adv_actions">
                                '.$action_select_list.'
                            </ul>        
                        </div>
                    </div>';
                    
                    print ' <input type="hidden" name="is11" value="11">';
                }
                
                
                
                foreach($adv_search_what as $key=>$search_field){
                    
                    $search_col         =   3;
                    $search_col_but     =   3;
                    $search_col_price   =   6;
                    if($adv_search_fields_no_per_row==2){
                        $search_col         =   6;
                        $search_col_but     =   6;
                        $search_col_price   =   12;
                    }else  if($adv_search_fields_no_per_row==3){
                        $search_col         =   4;
                        $search_col_but     =   4;
                        $search_col_price   =   8;
                    }
                    if($search_field=='property price' &&  get_option('wp_estate_show_slider_price','')=='yes'){
                        $search_col=$search_col_price;
                    }
                    
                    print '<div class="col-md-'.$search_col.' '.str_replace(" ","_",$search_field).'">';
                        wpestate_show_search_field('shortcode',$search_field,$action_select_list,$categ_select_list,$select_city_list,$select_area_list,$key,$select_county_state_list);
                    print '</div>';
                     
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
        $search_field="submit";
        $return_string.='<div class="col-md-'.$search_col_but.' '.str_replace(" ","_",$search_field).'">
            <button class="wpresidence_button" id="advanced_submit_shorcode">'.__('Search','wpestate').'</button>              
        </div>         
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
    global $property_unit_slider;
    global $no_listins_per_row;
    global $wpestate_uset_unit;
    global $custom_unit_structure;
    global $prop_unit;
    
    $custom_unit_structure    =   get_option('wpestate_property_unit_structure');
    $wpestate_uset_unit       =   intval ( get_option('wpestate_uset_unit','') );
    $no_listins_per_row       =   intval( get_option('wp_estate_listings_per_row', '') );
    $property_unit_slider = get_option('wp_estate_prop_list_slider','');
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
    $prop_unit          =   '';
    
    global $current_user;
    global $curent_fav;
    $current_user       =   wp_get_current_user();
    $userID             =   $current_user->ID;
    $user_option        =   'favorites'.$userID;
    $curent_fav         =   get_option($user_option);
    $title              =   '';
    
    
    $property_card_type         =   intval(get_option('wp_estate_unit_card_type'));
    $property_card_type_string  =   '';
    if($property_card_type==0){
        $property_card_type_string='';
    }else{
        $property_card_type_string='_type'.$property_card_type;
    }

    if ( isset($attributes['title']) ){
        $title=$attributes['title'];
    }
    

    
    $attributes = shortcode_atts( 
                array(
                    'title'                 => '',
                    'type'                  => 'properties',
                    'ids'                   =>  '',
                    'number'                =>  3,
                    'rownumber'             =>  4,
                    'align'                 =>  'vertical',
                    'link'                  =>  '#',
                ), $attributes) ;

    
    $transient_ids='';
    if ( isset($attributes['ids']) ){
        $ids=$transient_ids=$attributes['ids'];
        $ids_array=explode(',',$ids);
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
        $align      =   "col-md-12";
        $prop_unit  =   'list';
    }
    
    
    
    if ($attributes['type'] == 'properties') {
       $type = 'estate_property';
    } else {
       $type = 'post';
    }

    if ($attributes['link'] != '') {
        if ($attributes['type'] == 'properties') {
            $button .= '<div class="listinglink-wrapper">
                           <a href="' . $attributes['link'] . '"> <span class="wpresidence_button">'.__(' more listings','wpestate').' </span></a>
                       </div>';
        } else {
            $button .= '<div class="listinglink-wrapper">
                           <a href="' . $attributes['link'] . '"> <span class="wpresidence_button">'.__(' more articles','wpestate').'</span></a>
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
        'orderby'           => 'post__in'
    );
 
  
   

    $return_string .= '<div class="article_container">';
    if($title!=''){
        $return_string .= '<h2 class="shortcode_title">'.$title.'</h2>';
    }
     
    $transient_name = 'wpestate_list_items_by_id_'.$transient_ids;
    if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
        $transient_name.='_'. ICL_LANGUAGE_CODE;
    }
    if ( isset($_COOKIE['my_custom_curr_symbol'] ) ){
        $transient_name.='_'.$_COOKIE['my_custom_curr_symbol'];
    }
    if(isset($_COOKIE['my_measure_unit'])){
        $transient_name.= $_COOKIE['my_measure_unit'];
    }
    
    
    
    $templates = get_transient( $transient_name );
    if( $templates === false ) {
        $recent_posts = new WP_Query($args);
          
        ob_start();  
        while ($recent_posts->have_posts()): $recent_posts->the_post();
            if($type == 'estate_property'){
                if(isset($attributes['align']) && $attributes['align']=='horizontal'){
                   $col_class='col-md-12';
                }
                get_template_part('templates/property_unit'.$property_card_type_string);

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
        set_transient( $transient_name,wpestate_html_compress($templates),4*60*60);
    }
    
    
    
    
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
        
        $attributes = shortcode_atts( 
              array(
                  'register_label'                  => '',
                  'register_url'                =>  '',
                 
              ), $attributes) ;  

  
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
              
                <input type="hidden" id="security-login" name="security-login" value="'. estate_create_onetime_nonce( 'login_ajax_nonce' ).'">
       
                   
                <button id="wp-login-but" class="wpresidence_button">'.__('Login','wpestate').'</button>
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
                    $return_string.='<div id="facebooklogin" data-social="facebook">'.__('Login with Facebook','wpestate').'</div>';
                }
                if($google_status=='yes'){
                    $return_string.='<div id="googlelogin" data-social="google">'.__('Login with Google','wpestate').'</div>';
                }
                if($yahoo_status=='yes'){
                    $return_string.='<div id="yahoologin" data-social="yahoo">'.__('Login with Yahoo','wpestate').'</div>';
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
            <button class="wpresidence_button" id="wp-forgot-but" name="forgot" >'.__('Reset Password','wpestate').'</button>
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
                        $return_string.='<select id="new_user_type" name="new_user_type" class="form-control" >';
                        $return_string.= '<option value="0">'.__('Select User Type','wpestate').'</option>';
                        foreach($user_types as $key=>$name){
                            if(in_array($name, $permited_roles)){
                                $return_string.= '<option value="'.$key.'">'.$name.'</option>';
                            }
                        }
                        $return_string.= '</select>';
                }
                }

                $return_string.='        
                <input type="checkbox" name="terms" id="user_terms_register_sh">
                <label id="user_terms_register_sh_label" for="user_terms_register_sh">'.__('I agree with ','wpestate').'<a href="'.wpestate_get_template_link('terms_conditions.php').'" target="_blank" id="user_terms_register_topbar_link">'.__('terms & conditions','wpestate').'</a> </label>';
               
                if(get_option('wp_estate_use_captcha','')=='yes'){
                    $return_string.= '<div id="shortcode_register_menu"  style="float: left;margin-top: 10px;transform:scale(0.75);-webkit-transform:scale(0.75);transform-origin:0 0;-webkit-transform-origin:0 0;"></div>';
                 }
           
                
                if($enable_user_pass_status != 'yes'){
                    $return_string.='<p id="reg_passmail">'.__('A password will be e-mailed to you','wpestate').'</p>';
                }
                
                $return_string.= '   
                <input type="hidden" id="security-register" name="security-register" value="'.estate_create_onetime_nonce( 'register_ajax_nonce_sh' ).'">
           
                <p class="submit">
                    <button id="wp-submit-register"  class="wpresidence_button">'.__('Register','wpestate').'</button>
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
    
    
    $attributes = shortcode_atts( 
                array(
                    'id'                  => '',
                    'second_line'         =>  '',
                    'design_type'         =>  1
                ), $attributes) ;
     
    
    if(isset($attributes['id'])){
        $article = intval($attributes['id']);
    }
    
    if( isset($attributes['second_line'] )){
        $second_line = $attributes['second_line']; 
    }
    
    if(isset($attributes['design_type'])){
        $desgin_type=$attributes['design_type'];
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
            
            if($preview[0]==''){
                $previewh[0]  = $preview[0]= get_template_directory_uri().'/img/defaults/default_property_featured.jpg';
            }
            
            $avatar     =   wpestate_get_avatar_url(get_avatar(get_the_author_meta('email'), 55));
            $content    =   get_the_excerpt();
            $title      =   get_the_title();
            $link       =   get_permalink();

            if($desgin_type==1){
                $return_string.= '
                <div class="featured_article">


                    <div class="featured_img">
                        <a href="' . $link . '"> <img src="' . $preview[0] . '" data-original="'.$preview[0].'" alt="featured image" class="lazyload img-responsive" /></a>

                    </div>

                    <div class="featured_article_title" data-link="'.$link.'">
                        <div class="blog_author_image" style="background-image: url(' . $avatar . ');"></div>    
                        <h2 class="featured_type_2"> <a href="' . $link . '">'; 
                        $title=get_the_title();
                        $return_string .= mb_substr( $title,0,35); 
                        if(mb_strlen($title)>35){
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
            }else if($desgin_type==2){
                $preview    =   wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                $return_string.= '<div class="featured_article_type2">
                       <div class="featured_img_type2" style="background-image:url('.$preview[0] .')">
                           
                            <div class="featured_gradient"></div>
                            <div class="featured_article_type2_title_wrapper">
                                <div class="featured_article_label">'.__('Featured Article','wpestate').'</div>
                                <h2>'.$title.'</h2>
                                <div class="featured_read_more"><a href="'.$link.'">'.__('read more','wpestate').'</a> <i class="fa fa-angle-right"></i></div>    
                            </div>        
                        </div>
                    </div>';
                
            }
                     
        }
    }

    wp_reset_query();
    wp_reset_postdata();
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
    $return_string  =   '';
    $prop_id        =   '';
    $design_type    =   '';
    global $property_unit_slider;
    global $sale_line;
    $property_unit_slider = get_option('wp_estate_prop_list_slider','');
    $attributes = shortcode_atts( 
                array(
                    'id'                  => '',
                    'sale_line'           => '',
                    'design_type'         => 1
                ), $attributes) ;
     
     
    if( isset($attributes['id'])){
        $prop_id=$attributes['id'];
    }
    
    if( isset($attributes['design_type'])){
        $design_type=$attributes['design_type'];
    }
    
    
    $sale_line='';
    if ( isset($attributes['sale_line'])){
        $sale_line =  $attributes['sale_line'];
    }
    
    $transient_name='wpestate_featured_prop_'.$prop_id;
    if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
        $transient_name.='_'. ICL_LANGUAGE_CODE;
    }
    if ( isset($_COOKIE['my_custom_curr_symbol'] ) ){
        $transient_name.='_'.$_COOKIE['my_custom_curr_symbol'];
    }
    if(isset($_COOKIE['my_measure_unit'])){
        $transient_name.= $_COOKIE['my_measure_unit'];
    }
    $transient_name.='_type'.$design_type;
    $return_string = get_transient($transient_name);
    
    if($return_string===false){
        $args = array('post_type'   => 'estate_property',
                      'post_status' => 'publish',
                      'p'           => $prop_id
                    );

        $my_query = new WP_Query($args);
        if ($my_query->have_posts()) {
            ob_start();
            while ($my_query->have_posts()) {
                $my_query->the_post();

                if($design_type==1){
                    get_template_part('templates/featured_property_1');
                }else if($design_type==2){
                    get_template_part('templates/featured_property_2');
                }else if($design_type==3){
                    get_template_part('templates/featured_property_3');
                }else if($design_type==4){
                    get_template_part('templates/featured_property_4b');
                }

            }
            $return_string = ob_get_contents();
            ob_end_clean();  
        }

        wp_reset_query();
        set_transient($transient_name,wpestate_html_compress($return_string),60*60*4);
    }


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
    
    
     $attributes = shortcode_atts( 
                array(
                    'id'                  => 0,
                    'notes'                =>  '',
                ), $attributes) ;
     
    
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
    global $property_unit_slider;
    global $no_listins_per_row;
    global $wpestate_uset_unit;
    global $custom_unit_structure;
        
    $custom_unit_structure    =   get_option('wpestate_property_unit_structure');
    $wpestate_uset_unit       =   intval ( get_option('wpestate_uset_unit','') );
    $no_listins_per_row       =   intval( get_option('wp_estate_listings_per_row', '') );

    $current_user = wp_get_current_user();
    
    $title              =   '';
    if ( isset($attributes['title']) ){
        $title=$attributes['title'];
    }

    $attributes = shortcode_atts( 
                array(
                    'title'                 =>  '',
                    'type'                  => 'properties',
                    'category_ids'          =>  '',
                    'action_ids'            =>  '',
                    'city_ids'              =>  '',
                    'area_ids'              =>  '',
                    'state_ids'             =>  '',
                    'number'                =>  4,
                    'rownumber'             =>  4,
                    'align'                 =>  'vertical',
                    'link'                  =>  '',
                    'show_featured_only'    =>  'no',
                    'random_pick'           =>  'no',
                    'featured_first'        =>  'no'
                ), $attributes) ;

    

    
    $userID             =   $current_user->ID;
    $user_option        =   'favorites'.$userID;
    $curent_fav         =   get_option($user_option);
    $property_unit_slider = get_option('wp_estate_prop_list_slider','');
    
    
    $options            =   wpestate_page_details($post->ID);
    $return_string      =   '';
    $pictures           =   '';
    $button             =   '';
    $class              =   '';
    $category=$action=$city=$area=$state='';
    
    $currency           =   esc_html( get_option('wp_estate_currency_symbol', '') );
    $where_currency     =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
    $is_shortcode       =   1;
    $show_compare_only  =   'no';
    $row_number_col     =   '';
    $row_number         =   '';       
    $show_featured_only =   '';
    $random_pick        =   '';
    $featured_first     =   '';
    $orderby            =   'meta_value';
    

    $property_card_type         =   intval(get_option('wp_estate_unit_card_type'));
    $property_card_type_string  =   '';
    if($property_card_type==0){
        $property_card_type_string='';
    }else{
        $property_card_type_string='_type'.$property_card_type;
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
    
    if ( isset($attributes['state_ids']) ){
        $state=$attributes['state_ids'];
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
    
    
    if (isset($attributes['featured_first'])){
        $featured_first=   $attributes['featured_first'];
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
        $state_array    =   '';
        
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
        
        if($state!=''){
            $state_of_tax   =   array();
            $state_of_tax   =   explode(',', $state);
            $state_array    =   array(     
                                'taxonomy'  => 'property_county_state',
                                'field'     => 'term_id',
                                'terms'     => $state_of_tax
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

            if($featured_first=="no"){
                $orderby='ID';
            }
            
            $args = array(
                'post_type'         => $type,
                'post_status'       => 'publish',
                'paged'             => 1,
                'posts_per_page'    => $post_number_total,
                'meta_key'          => 'prop_featured',
                'orderby'           => $orderby,
                'order'             => 'DESC',
                'meta_query'        => $meta_query,
                'tax_query'         => array( 
                                        $category_array,
                                        $action_array,
                                        $city_array,
                                        $area_array,
                                        $state_array
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
               <a href="' . $attributes['link'] . '"> <span class="wpresidence_button">'.__('more listings','wpestate').' </span></a> 
               </div>';
        } else {
            $button .= '<div class="listinglink-wrapper">
               <a href="' . $attributes['link'] . '"> <span class="wpresidence_button">  '.__('more articles','wpestate').' </span></a> 
               </div>';
        }
    } else {
        $class = "nobutton";
    }
    
    if ($attributes['type'] != 'properties') {
          $class.=" blogs_wrapper ";
    }

    if ($attributes['type'] == 'properties') {
        if($random_pick !=='yes'){
            if($featured_first=='yes'){
                add_filter( 'posts_orderby', 'wpestate_my_order' ); 
            }
            
            $recent_posts = new WP_Query($args);
            $count = 1;
            if($featured_first=='yes'){
                remove_filter( 'posts_orderby', 'wpestate_my_order' ); 
            }
        }else{
           
            $args['orderby']    =   'rand';
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
            get_template_part('templates/property_unit'.$property_card_type_string);
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
    $return_string      =   '';
    $title_client       =   '';
    $client_name        =   '';
    $imagelinks         =   '';
    $testimonial_text   =   '';
    $type               =   1;
    $stars_client       =   '';
    $testimonial_title  =   '';
    $attributes = shortcode_atts( 
        array(
            'client_name'                  => 'Name Here',
            'title_client'                 => "happy client",
            'imagelinks'                   => '',
            'testimonial_text'             => '',
            'testimonial_type'             => '1',
            'stars_client'                 =>  '5',
            'testimonial_title'            => ''

        ), $attributes) ;

    
    
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
    
    if( $attributes['testimonial_type'] ){
        $type   =  'type_class_'. $attributes['testimonial_type']  ;
    } 
    if( $attributes['stars_client'] ){
        $stars_client   =  floatval($attributes['stars_client'])  ;
    }
    if( $attributes['testimonial_title'] ){
        $testimonial_title   =  $attributes['testimonial_title']  ;
    }
    
    
    
    
    if($type=='type_class_1'){
        $return_string .= '     <div class="testimonial-container '.$type.' ">';
        $return_string .= '     <div class="testimonial-image" style="background-image:url(' .$imagelinks . ')"></div>';
        $return_string .= '     <div class="testimonial-text">'.$testimonial_text.'</div>';    
        $return_string .= '     <div class="testimonial-author-line"><span class="testimonial-author">' . $client_name .'</span>, '.$title_client.' </div>';
        $return_string .= '     </div>';
    }else   if($type=='type_class_2'){
        $return_string .= '     <div class="testimonial-container '.$type.' ">';   
        $return_string .= '     <div class="testimonial-text">'.$testimonial_text.'</div>';    
        $return_string .= '     <div class="testimonial-image" style="background-image:url(' .$imagelinks . ')"></div>';
        $return_string .= '     <div class="testimonial-author-line"><span class="testimonial-author">' . $client_name .'</span>, '.$title_client.' </div>';
        $return_string .= '     </div>';
    }else if($type=='type_class_3'){
        $return_string .= '     <div class="testimonial-container '.$type.' ">';
        $return_string .= '     <div class="testimonial-image" style="background-image:url(' .$imagelinks . ')"></div>';
        $return_string .= '     <div class="testimonial_title">'.$testimonial_title.'</div>';

        $return_string .= '     <div class="testimmonials_starts">'.wpestate_starts_reviews($stars_client).'</div>';
        $return_string .= '     <div class="testimonial-text">'.$testimonial_text.'</div>';    
 
        $return_string .= '     <div class="testimonial-author-line"><span class="testimonial-author">' . $client_name .'</span>, '.$title_client.' </div>';
        $return_string .= '     </div>';
    }
    
    
    
    
    
    return $return_string;
}
endif; // end   wpestate_testimonial_function 


function wpestate_starts_reviews($stars){
    $whole          =   floor($stars);    
    $fraction       =   $stars - $whole;
    $return_string  =   '';
    
    for ($i = 1; $i <= $whole; $i++) {
        $return_string.='<i class="fa fa-star" aria-hidden="true"></i>';
    }
    if($fraction>0){
        $return_string.='<i class="fa fa-star-half" aria-hidden="true"></i>';
    }
    return $return_string;
}


if( !function_exists('wpestate_testimonial_slider_function') ):
function wpestate_testimonial_slider_function($attributes, $content = null) {
    $return_string      =   '';
    $title              =   '';
    $visible_items      =   '';
    $slider_types       =   '';    
    $attributes = shortcode_atts( 
                array(
                    'title'                 => '',
                    'visible_items'         => '1',
                    'slider_types'          => '1',
                ), $attributes) ;


    
    if ( $attributes['title'] ){
        $title   =   $attributes['title'];
    }
    
    if( $attributes['visible_items'] ){
        $visible_items=$attributes['visible_items'];
    }
    
    if( $attributes['slider_types'] ){
        $slider_types=$attributes['slider_types'];
    }
    
    
    $return_string .=   '<div class="testimonial-slider-container container_type_'.$slider_types.'" data-visible-items="'.$visible_items.'" data-auto="0">';
    $return_string .=   $title.do_shortcode($content);
    $return_string .=   '</div>';
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

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  shortcode - memerbership packages function
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_membership_packages_function') ):
function wpestate_membership_packages_function($atts, $content=null){
    $package_id       =  '';
    $pack_featured_sh =  array('no','yes');
    $package_content  = '';
    $return_string='';
    $attributes = shortcode_atts(
            array(
                    'package_id'        => '',
                    'pack_featured_sh'  => 'no',
                    'package_content'   =>''
                      
            ), $atts);
   
    if ( isset($attributes['package_id']) ){
            $package_id=$attributes['package_id'];
    	}
    if ( isset($attributes['pack_featured_sh']) ){
        $pack_featured_sh=$attributes['pack_featured_sh'];
    }
    if ( isset($attributes['package_content']) ){
        $package_content=$attributes['package_content'];
    }
    
    
 
  
    
    if($pack_featured_sh=='yes'){
        $pack_featured_sh='featured_pack_sh';                         
    }else{
        $pack_featured_sh='';
    }
    
    $pack_price             = get_post_meta($package_id, 'pack_price', true);
    $biling_period          = get_post_meta($package_id, 'biling_period', true);
    $billing_freq           = get_post_meta($package_id, 'billing_freq', true);
    $pack_image_included    = get_post_meta($package_id, 'pack_image_included', true);
    $pack_featured          = get_post_meta($package_id, 'pack_featured_listings', true);
    $currency           =   esc_html( get_option('wp_estate_submission_curency', '') );
    $where_currency     =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
    if($billing_freq>1){
        $biling_period.='s';
    }
    
    
  
    
    switch (strtolower($biling_period)) {
        case 'day':
            $biling_period=__('Day','wpestate');
            break;
        case 'days':
            $biling_period=__('Days','wpestate');
            break;
        case 'week':
            $biling_period=__('Week','wpestate');
            break;
        case 'weeks':
            $biling_period=__('Weeks','wpestate');
            break;
        case 'month':
            $biling_period=__('Month','wpestate');
            break;
        case 'month':
            $biling_period=__('Months','wpestate');
            break;
        case 'year':
            $biling_period=__('Year','wpestate');
            break;
        case 'years':
            $biling_period=__('Years','wpestate');
            break;
    }
    
    
    
    
    
    
    if (intval($pack_image_included)==0){
        $pack_image_included=__('Unlimited', 'wpestate');
    }
    
    
    $pack_list              = get_post_meta($package_id, 'pack_listings', true);
    $unlimited_listings     = get_post_meta($package_id, 'mem_list_unl', true);
    if($unlimited_listings==1){
        $unlimited_listings_sh='<div><strong>'.__('Unlimited', 'wpestate').' </strong> '.__('Listings', 'wpestate').' </div>';
    }else{
        $unlimited_listings_sh='<div><strong> '.$pack_list.'</strong>  '.__('Listings', 'wpestate').' </div>';
    }
                            
    $currency                   =   esc_html( get_option('wp_estate_currency_symbol', '') );
    $where_currency             =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
    
        
  
    $link   =   wpestate_get_template_link('user_dashboard_profile.php');
    $link   =   add_query_arg('packet',$package_id,$link);
    $return_string.='<div class="membership_package_product '.$pack_featured_sh.'">'
                    .'<h4>'.get_the_title($package_id).'</h4>'
                    .'<div class="pack-price_sh">'.wpestate_show_price_floor($pack_price,$currency,$where_currency,1).'</div>' 
                    .'<div class="pack_content">'.$package_content.'</div>' 
                    .'<div class="pack-bill_freg_sh"><strong>'.$billing_freq.'</strong> '.$biling_period.'</div>'
                    .'<div class="pack-listing_sh"> '.$unlimited_listings_sh.'</div>'
                    .'<div class="pack-listing-period_sh"><strong> '.$pack_image_included.'</strong>  '.__('Images / listing', 'wpestate').'</div> '
                    .'<div class="pack-listing_feat_sh"><strong> '.$pack_featured.'</strong> '.__('Featured Listings', 'wpestate').'</div> '
                    .'<div class="buy_package_sh"><a href="'.$link.'" class="wpresidence_button">'.__('Get started', 'wpestate').'</a></div>'
            
                    .'</div>';
  
  
    return '<div class="article_container">'.$return_string.'</div>';
      
  }
endif;//end memerbership packages function


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  shortcode - featured user role function
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_featured_user_role_shortcode') ):

function wpestate_featured_user_role_shortcode($atts, $content=null){
    $user_role_id   ='';
    $status         ='';
    $return_string  ='';
    $user_shortcode_imagelink ='';
    
    $attributes     = shortcode_atts(
                    array(
                        'user_role_id'              => '',
                        'status'                    => '',
                        'user_shortcode_imagelink'  => '' 
                    ), $atts);
   
   if ( isset($attributes['user_role_id']) ){
        $user_role_id=$attributes['user_role_id'];
    }
    
    if ( isset($attributes['status']) ){
        $status=$attributes['status'];
    }
     if ( isset($attributes['user_shortcode_imagelink']) ){
        $user_shortcode_imagelink=$attributes['user_shortcode_imagelink'];
    }
    
    $post = get_post($user_role_id);
    $user_id             = get_post_meta( $post->ID, 'user_meda_id', true);
    $user_role           = get_user_meta( $user_id, 'user_estate_role', true) ;    
 
    
    if($user_role==3 ){
        $agency_phone       = esc_html( get_post_meta($user_role_id, 'agency_phone', true) );
        $agent_email         = esc_html( get_post_meta($user_role_id, 'agency_email', true) );   
    }else{
        $agency_phone     = esc_html( get_post_meta($user_role_id, 'developer_phone', true) );
        $agent_email     = esc_html( get_post_meta($user_role_id, 'developer_email', true) );   
    }
   
  
  
    $return_string.='<div class="user_role_unit">'
                   
                    .'<div class="featured_user_role_unit_details">'
                        .'<div class="user_role_status">'.$status.'</div>'
                        .'<div class="user_role_image" style="background-image:url('.wp_get_attachment_thumb_url(get_post_thumbnail_id($user_role_id)).')"></div>'
                        .'<h4><a href="'.get_permalink($user_role_id).'">'.get_the_title($user_role_id).'</a></h4>'
                        .'<div class="user_role_phone"><i class="fa fa-phone"></i> <a href="tel:'.urlencode($agency_phone). '">'.$agency_phone.'</a></div>'
                        .'<div class="user_role_email"><i class="fa fa-envelope-o"></i> <a href="mailto:' . $agent_email . '">'.$agent_email.'</a></div>'   
                        .'<div class="user_role_content">'.wpestate_strip_excerpt_by_char($post->post_content,180,$user_role_id). '</div>'
                        .'<a class="wpresidence_button button_user_role" href="'.get_permalink($user_role_id).'">'.__('View Profile', 'wpestate').'</a>'
                    .'</div>'
            
                    .'<div class="user_role_featured_image">'
                        .'<div class="user_role" style="background-image:url('.$user_shortcode_imagelink.')"></div>'
                        .'<div class="prop_new_details"><div class="prop_new_details_back"></div></div>'
                    .'</div>'
                    .'</div>';
   
  
     
    wp_reset_query();
    return $return_string;
  
    
    
    
}

endif; // end   featured user role function   



if( !function_exists('wpestate_places_slider') ):

function wpestate_places_slider($attributes, $content=null){	
	
	global $full_page;
    global $is_shortcode;
    global $row_number_col;
    global $place_id;
    global $place_per_row;
	 
	
    $is_shortcode       =1;
    $place_list         ='';
    $return_string      ='';
    $extra_class_name   ='';

    
 
    $attributes = shortcode_atts( 
        array(
            'place_list'                       => '',
            'place_per_row'                    => 3,
            'extra_class_name'                 => '',
        
        ), $attributes) ;
 
    $post_number_total = $attributes['place_per_row'];
    
	/*
	
	if ( isset($attributes['place_per_row']) ){
        $row_number        = $attributes['place_per_row']; 
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
        if( isset($attributes['align']) && $attributes['align']=='vertical'){
             $row_number_col =  0;
        }
    }
    */
    
    if ( isset($attributes['place_list']) ){
        $place_list=$attributes['place_list'];
    }
    if ( isset($attributes['place_per_row']) ){
        $place_per_row=$attributes['place_per_row'];
    }
	
	
    
    if($place_per_row>5){
        $place_per_row=5;
    }
    
    if( isset($attributes['extra_class_name'])){
        $extra_class_name = $attributes['extra_class_name'];
    }    
    
  
    
    $all_places_array =  explode(',', $place_list);
  
	$slide_cont = '';
    foreach( $all_places_array as $single_term){
        $place_id =intval( $single_term  );
		
		ob_start(); 
        get_template_part('templates/places_unit_type2');   
		$slide_cont_tmp =  ob_get_clean();		
		//var_dump( $slide_cont_tmp );
		//var_dump( $slide_cont_tmp && trim($slide_cont_tmp) != '' );
		if( $slide_cont_tmp && trim($slide_cont_tmp) != '' ){
			$slide_cont .=  '<div class="single_slide_container">';
			$slide_cont .= $slide_cont_tmp;
			$slide_cont .= '</div>';
		}
		

    }
    
    $return_string = '<div class="estate_places_slider '.$extra_class_name.'"  data-items-per-row="'.$place_per_row.'" data-auto="0" >'. $slide_cont.'</div>';
    //ob_end_clean(); 
    $is_shortcode       =0;
    return $return_string;
     

}
endif;
?>