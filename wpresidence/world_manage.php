<?php

function wpestate_how_many_pages(){
    $args = array(
        'post_type'         => 'page',
        'post_status'       => 'any',
        'paged'             => -1,
    );
    
    $query = new WP_Query($args);
    
    $current_pages= $query->found_posts;
    wp_reset_postdata();
    wp_reset_query();
    return $current_pages;
    
}


function wpestate_how_many_lisitings(){
    $args = array(
        'post_type'         => 'estate_property',
        'post_status'       => 'any',
        'paged'             => -1,
    );
    
    $query = new WP_Query($args);
    
    $current_listed= $query->found_posts;
    wp_reset_postdata();
    wp_reset_query();
    return $current_listed;
    
}


add_action( 'wp_ajax_wpestate_ajax_start_map', 'wpestate_ajax_start_map' );  
if( !function_exists('wpestate_ajax_start_map') ):
function wpestate_ajax_start_map(){ 
    $ssl_map_status    =   sanitize_text_field($_POST['ssl_map_set']) ;
    $api_key           =   sanitize_text_field($_POST['api_key']) ;
    
    if(current_user_can('administrator')){
            update_option('wp_estate_ssl_map',$ssl_map_status);
            update_option('wp_estate_api_key',$api_key);
    }
    die();

    
}
endif;


add_action( 'wp_ajax_wpestate_ajax_general_set', 'wpestate_ajax_general_set' );  
if( !function_exists('wpestate_ajax_general_set') ):
function wpestate_ajax_general_set(){ 
    $general_country    =   sanitize_text_field($_POST['general_country']) ;
    $measure_sys        =   sanitize_text_field($_POST['measure_sys']) ;
    $currency_symbol    =   sanitize_text_field($_POST['currency_symbol']) ;
    $date_lang          =   sanitize_text_field($_POST['date_lang']) ;
    
    if(current_user_can('administrator')){
            update_option('wp_estate_general_country',$general_country);
            update_option('wp_estate_currency_symbol',$currency_symbol);
            update_option('wp_estate_measure_sys',$measure_sys);
            update_option('wp_estate_date_lang',$date_lang);
    }
    die();

    
}
endif; 


add_action( 'wp_ajax_wpestate_ajax_apperance_set', 'wpestate_ajax_apperance_set' );  
if( !function_exists('wpestate_ajax_apperance_set') ):
function wpestate_ajax_apperance_set(){ 
    $property_list_type_adv =   sanitize_text_field($_POST['property_list_type_adv']) ;
    $prop_unit              =   sanitize_text_field($_POST['prop_unit']) ;

    
    if(current_user_can('administrator')){
            update_option('wp_estate_property_list_type_adv',$property_list_type_adv);
            update_option('wp_estate_prop_unit', $prop_unit );
    }
    die();

    
}
endif; 



