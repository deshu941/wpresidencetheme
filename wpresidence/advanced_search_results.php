<?php
// Template Name: Advanced Search Results
// Wp Estate Pack
global $keyword;
<<<<<<< HEAD
wp_cache_flush();
get_header();
get_currentuserinfo();
set_time_limit (0);
=======
global $included_ids;
wp_cache_flush();
get_header();
$current_user = wp_get_current_user();
//set_time_limit (0);
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    
$options            =   wpestate_page_details($post->ID);
$show_compare       =   1;
$area_array         =   ''; 
$city_array         =   '';  
$action_array       =   '';
$categ_array        =   '';
$id_array           =   '';
$countystate_array  =   '';

<<<<<<< HEAD
$compare_submit         =   get_compare_link();
=======
$compare_submit         =   wpestate_get_template_link('compare_listings.php');
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
$currency               =   esc_html( get_option('wp_estate_currency_symbol', '') );
$where_currency         =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
$prop_no                =   intval ( get_option('wp_estate_prop_no', '') );
$show_compare_link      =   'yes';
$userID                 =   $current_user->ID;
$user_option            =   'favorites'.$userID;
$curent_fav             =   get_option($user_option);
$custom_advanced_search =   get_option('wp_estate_custom_advanced_search','');
$meta_query             =   array();
           
$adv_search_what        =   '';
$adv_search_how         =   '';
$adv_search_label       =   '';             
$adv_search_type        =   '';   
$adv_search_type        =   get_option('wp_estate_adv_search_type','');  

$prop_unit          =   esc_html ( get_option('wp_estate_prop_unit','') );
$prop_unit_class    =   '';
$align_class        =   '';
if($prop_unit=='list'){
    $prop_unit_class="ajax12";
    $align_class=   'the_list_view';
}

$adv_search_what    =   get_option('wp_estate_adv_search_what','');
$adv_search_how     =   get_option('wp_estate_adv_search_how','');
$adv_search_label   =   get_option('wp_estate_adv_search_label','');                    
$adv_search_type    =   get_option('wp_estate_adv_search_type','');

$adv_search_type        =   get_option('wp_estate_adv_search_type','');  

if( !isset($_GET['is2']) ){
    //////////////////////////////////////////////////////////////////////////////////////
    ///// type1 or type 3
    //////////////////////////////////////////////////////////////////////////////////////
    if( $custom_advanced_search==='yes' ){
        $args = $mapargs    =   wpestate_search_results_custom ('search');        
        $return_custom      =   wpestate_search_with_keyword($adv_search_what, $adv_search_label);

        if(isset($return_custom['keyword'])){
            $keyword        =   $return_custom['keyword'];
        }

        if(isset( $return_custom['id_array']) ){
            $id_array       =   $return_custom['id_array']; 
        }

    }else{
        $args = $mapargs = wpestate_search_results_default ('search');
    }
<<<<<<< HEAD
     
=======

>>>>>>> 64662fd89bea560852792d7203888072d7452d48
}else{
    //////////////////////////////////////////////////////////////////////////////////////
    ///// type 2 city.area,state
    //////////////////////////////////////////////////////////////////////////////////////
<<<<<<< HEAD
    $args=wpestated_advanced_search_tip2();
    $mapargs = array(
        'post_type'      =>  'estate_property',
        'post_status'    =>  'publish',
        'nopaging'       =>  'true',
        'cache_results'  => false,
        'paged'           => $paged,
        'posts_per_page'  => 30,
    );

}
=======
  
    $args                 = wpestated_advanced_search_tip2();
    $meta_query           = array();
    $features             = array();
    $features = wpestate_add_feature_to_search();
    //$args['meta_query']   = wpestate_add_feature_to_search($meta_query); 
    if(!empty($features)){
        $args['post__in']=$features;
    }
    
    $mapargs = array(
        'post_type'         =>  'estate_property',
        'post_status'       =>  'publish',
        'nopaging'          =>  'true',
        'cache_results'     =>  false,
        'paged'             =>  $paged,
        'posts_per_page'    =>  30,
    );
    $mapargs=$args;
}

if( isset($_GET['is10']) && intval($_GET['is10'])==10 ){

    $args    =   wpestated_advanced_search_tip10($args);
    $mapargs =   $args;

}

if( isset($_GET['is11']) && intval($_GET['is11']) == 11 ){
    $allowed_html       =   array();
    $keyword            =   esc_attr(  wp_kses ( $_GET['keyword_search'], $allowed_html));
    $args               =   wpestated_advanced_search_tip11($args);
    $mapargs            =   $args;
  
}


////////////////////////////////////////////////////////////////////////////////////////////
// order by on searhc pagination
////////////////////////////////////////////////////////////////////////////////////////////
if( isset($_GET['order_search']) && is_numeric($_GET['order_search'] ) ){
    $meta_directions    =   'DESC';
    $meta_order         =   'prop_featured';
    $order_by           =   'meta_value_num';

    $order= intval($_GET['order_search']);    
    switch ($order){
        case 0:
            $meta_order='prop_featured';
            $meta_directions='DESC';
            $order_by           =   'meta_value_num';
            break;
        case 1:
            $meta_order='property_price';
            $meta_directions='DESC';
            $order_by='meta_value_num';
            break;
        case 2:
            $meta_order='property_price';
            $meta_directions='ASC';
            $order_by='meta_value_num';
            break;
        case 3:
            $meta_order='';
            $meta_directions='DESC';
            $order_by='ID';
            break;
        case 4:
            $meta_order='';
            $meta_directions='ASC';
            $order_by='ID';
            break;
        case 5:
            $meta_order='property_bedrooms';
            $meta_directions='DESC';
            $order_by='meta_value_num';
            break;
        case 6:
            $meta_order='property_bedrooms';
            $meta_directions='ASC';
            $order_by='meta_value_num';
            break;
        case 7:
            $meta_order='property_bathrooms';
            $meta_directions='DESC';
            $order_by='meta_value_num';
            break;
        case 8:
            $meta_order='property_bathrooms';
            $meta_directions='ASC';
            $order_by='meta_value_num';
            break;
      }



  $args['meta_key']       =   $meta_order;
  $args['orderby']        =   $order_by;
  $args['order']          =   $meta_directions;
}
////////////////////////////////////////////////////////////////////////////////////////////
// END order by on searhc pagination
////////////////////////////////////////////////////////////////////////////////////////////
>>>>>>> 64662fd89bea560852792d7203888072d7452d48


if( !empty($id_array)){
    $args=  array(  'post_type'     => 'estate_property',
<<<<<<< HEAD
                    'p'           =>    $id_array
=======
                'p'           =>    $id_array
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
            );
    $prop_selection =   new WP_Query( $args);

}else{

<<<<<<< HEAD
    $custom_fields = get_option( 'wp_estate_custom_fields', true); 
    add_filter( 'posts_orderby', 'wpestate_my_order' );
    if( !empty($keyword) ){
        add_filter( 'posts_where', 'wpestate_title_filter', 10, 2 );
    }
    $prop_selection =   new WP_Query($args);
    remove_filter( 'posts_orderby', 'wpestate_my_order' );

=======
    
    $custom_fields = get_option( 'wp_estate_custom_fields', true); 
    if( !isset($_GET['order_search']) ){
        add_filter( 'posts_orderby', 'wpestate_my_order' );
    }
    if( !empty($keyword) ){
        add_filter( 'posts_where', 'wpestate_title_filter', 10, 2 );
    }
    
    $prop_selection =   new WP_Query($args);
    
    if( !isset($_GET['order_search']) ){
        remove_filter( 'posts_orderby', 'wpestate_my_order' );
    }
    
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    if( !empty($keyword) ){
        remove_filter( 'posts_where', 'wpestate_title_filter', 10, 2 );
    }
}


<<<<<<< HEAD
 
   
//   print_r($prop_selection);
$num = $prop_selection->found_posts;
$selected_pins  =   wpestate_listing_pins($mapargs,1);//call the new pins  
   
$property_list_type_status =    esc_html(get_option('wp_estate_property_list_type_adv',''));
$half_map_results = 0;

if ( $property_list_type_status == 2 ){
    get_template_part('templates/half_map_core');
    $half_map_results=1;
=======

$num = $prop_selection->found_posts;   
$property_list_type_status =    esc_html(get_option('wp_estate_property_list_type_adv',''));
$half_map_results = 0;


if ( $property_list_type_status == 2 ){
    get_template_part('templates/half_map_core');
    $half_map_results=1;
    
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
}else{
    get_template_part('templates/normal_map_core'); 
}




<<<<<<< HEAD


$adv_search_type        =   get_option('wp_estate_adv_search_type','');        
if ($adv_search_type==1){
    wp_localize_script('googlecode_regular', 'googlecode_regular_vars2', 
        array(  
           // 'markers2'           =>  $selected_pins,
            'half_map_results'   => $half_map_results
        )
    );
}else{
    if ( get_option('wp_estate_readsys','') =='yes' ){
        $path=estate_get_pin_file_path();
        $json_string=file_get_contents($path);       
    }else{
        $json_string= wpestate_listing_pins();
    }
        
        
    wp_localize_script('googlecode_regular', 'googlecode_regular_vars2', 
        array(  
          //  'markers2'           =>  $json_string,
            'half_map_results'   => $half_map_results
        )
    );
   
}

=======
        

if (wp_script_is( 'googlecode_regular', 'enqueued' )) {

    
    $max_pins                   =   intval( get_option('wp_estate_map_max_pins') );
    $mapargs['posts_per_page']  =   $max_pins;
    $mapargs['offset']          =   ($paged-1)*$prop_no;
    
    $mapargs['fields']          =   'ids';
    
  
    $selected_pins  =   wpestate_listing_pins('blank',0,$mapargs,1,$keyword,$id_array);//call the new pins  

    wp_localize_script('googlecode_regular', 'googlecode_regular_vars2', 
        array(  
            'markers2'           => $selected_pins,
            'half_map_results'   => $half_map_results
        )
    );


}
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
get_footer(); 
?>