<?php



remove_action( 'welcome_panel', 'wp_welcome_panel' ); // remove WordPress admin dashboard panel

function wpestate_action_welcome_panel() { 
    $logo               =   get_option('wp_estate_logo_image','');  
    $theme_activated    =   get_option('is_theme_activated','');
    
    print '<div class="wpestate_admin_theme_back"></div>';
    print '<div class="wpestate_admin_theme_gradient"></div>';
    print '<img class="img-responsive retina_ready dashboard_widget_logo" src="' . get_template_directory_uri() . '/img/logo_admin_white.png" alt="logo residence"/>';
    
    
    print'<nav class="wpestate_admin_menu">';
         print'<ul class="menu_admin">';
            print'<li><a target="_blank "href="http://help.wpresidence.net/article/how-to-update-the-theme/">'.__('Update the theme & plugins','wpestate').'</a></li>';
            print'<li><a target="_blank "href="https://themeforest.net/item/wp-residence-real-estate-wordpress-theme/7896392?ref=annapx&ref=annapx">'.__('Buy new license','wpestate').'</a></li>';
            print'<li><a target="_blank "href="http://help.wpresidence.net/article-category/change-log/">'.__('Change log','wpestate').'</a></li>';
            print '<li><a href="#">'.__( 'Get help', 'wpestate' ).'<div alt="f347" class="dashicons dashicons-arrow-down-alt2"></div></a>';
                print'<ul class="wpestate_dropdown_admin">';
                    print '<li><a target="_blank" href="http://support.wpestate.org/">'.__( 'Open ticket', 'wpestate' ).'</a></li>';
                    print '<li><a target="_blank" href="http://help.wpresidence.net/">'.__( 'Documentation', 'wpestate' ).'</a></li>';
                    print '<li><a target="_blank" href="https://themeforest.net/downloads">'.__( 'Rate us', 'wpestate' ).'</a></li>';
                print'</ul>';
            print '</li>';
        print '</ul>';
    print'</nav>';
    
    
    print'<div class="wpestate_admin_version">'; 
        print '<div class="theme_details_welcome">'.__('Current Verison: ','wpestate') . wp_get_theme().'</div>';
        if($theme_activated=='is_active'){
            print'<div alt="f528" class="dashicons dashicons-unlock"></div>';
        }else{
            print'<div alt="f528" class="dashicons dashicons-lock"></div>';
        }
       
    print'</div>';
    
    print'<div class="wpestate_admin_theme_opt">';
        print'<div id="start_wprentals_setup" class="wpestate_admin_button">' . __('Start Now', 'wpestate') . '</div>';
        print'<div class="wpestate_theme_opt wpestate_admin_button"><a href="themes.php?page=libs/theme-admin.php">' . __('Site Settings ', 'wpestate') . '</a></div>';
    print'</div>';
    
    
    print'<div id="wpestate_start_wrapper">';
        print'<button type="button" class="wpestate_admin_button wpestate_start_wrapper_close" ><div alt="f158" class="dashicons dashicons-no"></div></button>';

        print'<div class="wpestate_admin_start_notice" id="wpestate_start">';
            print'<p>'.__('We recommend doing demo import first and then finishing this setup. Adding Demo import AFTER completing this setup changes your settings options to demo options. ','wpestate') .'</p>';
            print'<div class="wpestate_admin_start_notice_wpapper">';
                print'<div class="wpestate_admin_button" id="button_start_notice">'.__('Continue','wpestate') .'</div>'.__('OR','wpestate');
                print'<div class="wpestate_admin_button"><a href="themes.php?page=libs/theme-import.php">'.__('Import Demo Content','wpestate') .'</a></div>';
            print'</div>';
        print '</div>';
        
        
        print'<div class="wpestate_admin_start_map" id="wpestate_start_map"><h1>'.__( 'Map Settings', 'wpestate' ).'</h1>';  
            $cache_array       =   array('yes','no');
            $ssl_map_symbol    ='';
            $ssl_map_status    = esc_html ( get_option('wp_estate_ssl_map','') );
            $api_key                        =   esc_html( get_option('wp_estate_api_key') );
            foreach($cache_array as $value){
                $ssl_map_symbol.='<option value="'.$value.'"';
                if ($ssl_map_status==$value){
                    $ssl_map_symbol.=' selected="selected" ';
                }
                $ssl_map_symbol.='>'.$value.'</option>';
            }


            print'<div class="estate_start_setup">
                <div class="label_option_start">'.__('Use Google maps with SSL ?','wpestate').'</div>
                <div class="option_row_explain">'.__('Set to Yes if you use SSL (https://)','wpestate').'</div>    
                    <select id="ssl_map_set" name="ssl_map">
                        '.$ssl_map_symbol.'
                    </select>
            </div>';   

            print'<div class="estate_start_setup">
                <div class="label_option_start">'.__('Google Maps API KEY','wpestate').'</div>
                <div class="option_row_explain">'.__('The Google Maps JavaScript API v3 REQUIRES an API key to function correctly. Get an APIs Console key and post the code in Theme Options. You can get it from <a href="https://developers.google.com/maps/documentation/javascript/tutorial#api_key" target="_blank">here</a>','wpestate').'</div>    
                    <input  type="text" id="api_key" name="api_key" class="regular-text" value="'.$api_key.'"/>
            </div>';

            print'<input type="submit" class="wpestate_admin_button reverse_but" id="button_map_prev" value="' . __('Previous Step', 'wpestate') . '"/>';
            print'<input type="submit" class="wpestate_admin_button reverse_but" id="button_map_set" value="'.__('Next Step', 'wpestate').'"/>'; 
       
        print'</div>';
        
        
        print'<div class="wpestate_admin_start_general_settings" id="wpestate_general_settings"><h1>'.__('General Settings', 'wpestate').'</h1>';
            $general_country                =   esc_html( get_option('wp_estate_general_country') );
            print'<div class="estate_start_setup">
                <div class="label_option_row">'.__('Country','wpestate').'</div>
                <div class="option_row_explain">'.__('Select default country','wpestate').'</div>    
                '.wpestate_general_country_list($general_country).'
            </div>';
            
            $currency_symbol                =   esc_html( get_option('wp_estate_currency_symbol') );
            print'<div class="estate_start_setup">
                <div class="label_option_row">'.__('Currency symbol','wpestate').'</div>
                <div class="option_row_explain">'.__('Set currency symbol for property price.','wpestate').'</div>    
                    <input  type="text" id="currency_symbol" name="currency_symbol"  value="'.$currency_symbol.'"/>
                </div>';
            
            $measure_sys='';
            $measure_array = array( 

                        array( 'name' => __('feet','wpestate'), 'unit'  => __('ft','wpestate'), 'is_square' => 0 ),
                        array( 'name' => __('meters','wpestate'), 'unit'  => __('m','wpestate'), 'is_square' => 0 ),
                        array( 'name' => __('acres','wpestate'), 'unit'  => __('ac','wpestate'), 'is_square' => 1 ),
                        array( 'name' => __('yards','wpestate'), 'unit'  => __('yd','wpestate'), 'is_square' => 0 ),
                        array( 'name' => __('hectares','wpestate'), 'unit'  => __('ha','wpestate'), 'is_square' => 1 ),
            );
            update_option( 'wpestate_measurement_units',  $measure_array);


            $measure_array_status= esc_html( get_option('wp_estate_measure_sys','') );

            foreach($measure_array as $single_unit ){


                    $measure_sys.='<option value="'.$single_unit['unit'].'"';
                    if ($measure_array_status==$single_unit['unit']){
                        $measure_sys.=' selected="selected" ';
                    }
                                if( $single_unit['is_square'] === 1 ){
                                        $measure_sys.='>'.$single_unit['name'].' - '.$single_unit['unit'].'</option>';
                                }else{
                                        $measure_sys.='>'.__('square','wpestate').' '.$single_unit['name'].' - '.$single_unit['unit'].'<sup>2</sup></option>';
                                }
            }
            
            print'<div class="estate_start_setup">
                <div class="label_option_row">'.__('Measurement Unit','wpestate').'</div>
                <div class="option_row_explain">'.__('Select the measurement unit you will use on the website','wpestate').'</div>    
                    <select id="measure_sys" name="measure_sys">
                        '.$measure_sys.'
                    </select>
                </div>';
            
             
            $date_languages=array(  'xx'=> 'default',
                                    'af'=>'Afrikaans',
                                    'ar'=>'Arabic',
                                    'ar-DZ' =>'Algerian',
                                    'az'=>'Azerbaijani',
                                    'be'=>'Belarusian',
                                    'bg'=>'Bulgarian',
                                    'bs'=>'Bosnian',
                                    'ca'=>'Catalan',
                                    'cs'=>'Czech',
                                    'cy-GB'=>'Welsh/UK',
                                    'da'=>'Danish',
                                    'de'=>'German',
                                    'el'=>'Greek',
                                    'en-AU'=>'English/Australia',
                                    'en-GB'=>'English/UK',
                                    'en-NZ'=>'English/New Zealand',
                                    'eo'=>'Esperanto',
                                    'es'=>'Spanish',
                                    'et'=>'Estonian',
                                    'eu'=>'Karrikas-ek',
                                    'fa'=>'Persian',
                                    'fi'=>'Finnish',
                                    'fo'=>'Faroese',
                                    'fr'=>'French',
                                    'fr-CA'=>'Canadian-French',
                                    'fr-CH'=>'Swiss-French',
                                    'gl'=>'Galician',
                                    'he'=>'Hebrew',
                                    'hi'=>'Hindi',
                                    'hr'=>'Croatian',
                                    'hu'=>'Hungarian',
                                    'hy'=>'Armenian',
                                    'id'=>'Indonesian',
                                    'ic'=>'Icelandic',
                                    'it'=>'Italian',
                                    'it-CH'=>'Italian-CH',
                                    'ja'=>'Japanese',
                                    'ka'=>'Georgian',
                                    'kk'=>'Kazakh',
                                    'km'=>'Khmer',
                                    'ko'=>'Korean',
                                    'ky'=>'Kyrgyz',
                                    'lb'=>'Luxembourgish',
                                    'lt'=>'Lithuanian',
                                    'lv'=>'Latvian',
                                    'mk'=>'Macedonian',
                                    'ml'=>'Malayalam',
                                    'ms'=>'Malaysian',
                                    'nb'=>'Norwegian',
                                    'nl'=>'Dutch',
                                    'nl-BE'=>'Dutch-Belgium',
                                    'nn'=>'Norwegian-Nynorsk',
                                    'no'=>'Norwegian',
                                    'pl'=>'Polish',
                                    'pt'=>'Portuguese',
                                    'pt-BR'=>'Brazilian',
                                    'rm'=>'Romansh',
                                    'ro'=>'Romanian',
                                    'ru'=>'Russian',
                                    'sk'=>'Slovak',
                                    'sl'=>'Slovenian',
                                    'sq'=>'Albanian',
                                    'sr'=>'Serbian',
                                    'sr-SR'=>'Serbian-i18n',
                                    'sv'=>'Swedish',
                                    'ta'=>'Tamil',
                                    'th'=>'Thai',
                                    'tj'=>'Tajiki',
                                    'tr'=>'Turkish',
                                    'uk'=>'Ukrainian',
                                    'vi'=>'Vietnamese',
                                    'zh-CN'=>'Chinese',
                                    'zh-HK'=>'Chinese-Hong-Kong',
                                    'zh-TW'=>'Chinese Taiwan',
                ); 
            
            $date_lang_symbol =  wpestate_dropdowns_theme_admin_with_key($date_languages,'date_lang');
            print'<div class="estate_start_setup">
                <div class="label_option_row">'.__('Language for datepicker','wpestate').'</div>
                <div class="option_row_explain">'.__('This applies for the calendar field type available for properties.','wpestate').'</div>    
                <select id="date_lang" name="date_lang">
                    '.$date_lang_symbol.'
                 </select>
            </div>';
            
            
            print'<input type="submit" class="wpestate_admin_button reverse_but" id="button_start_general_prev" value="' . __('Previous Step', 'wpestate') . '"/>';
            print'<input type="submit" class="wpestate_admin_button reverse_but" id="button_start_general_set" value="'.__('Next Step', 'wpestate').'"/>'; 
        
        print'</div>';
        
        print'<div class="wpestate_admin_start_apperance_settings" id="wpestate_apperance_settings_quick"><h1>'.__('Apperance Options', 'wpestate').'</h1>';
           $prop_list_array=array(
               "1"  =>  __("standard ","wpestate"),
               "2"  =>  __("half map","wpestate")
            );
           $property_list_type_symbol_adv   = wpestate_dropdowns_theme_admin_with_key($prop_list_array,'property_list_type_adv');
   
            print'<div class="estate_start_setup">
            <div class="label_option_row">'.__('Property List Type for Advanced Search','wpestate').'</div>
            <div class="option_row_explain">'.__('Select standard or half map style for advanced search results page.','wpestate').'</div>    
                <select id="property_list_type_adv" name="property_list_type_adv">
                    '.$property_list_type_symbol_adv.'
                </select>
            </div>';

            $prop_unit_array    =   array(
                                        'grid'    =>__('grid','wpestate'),
                                        'list'      => __('list','wpestate')
                                    );
            $prop_unit_select_view   = wpestate_dropdowns_theme_admin_with_key($prop_unit_array,'prop_unit');

            print'<div class="estate_start_setup">
            <div class="label_option_row">'.__('Property List display(*global option)','wpestate').'</div>
            <div class="option_row_explain">'.__('Select grid or list style for properties list pages.','wpestate').'</div>    
                <select id="prop_unit" name="prop_unit">
                    '.$prop_unit_select_view.'
                </select>
            </div>';
        
            print'<input type="submit" class="wpestate_admin_button reverse_but" id="button_apperance_settings_prev" value="' . __('Previous Step', 'wpestate') . '"/>';
            print'<input type="submit" class="wpestate_admin_button reverse_but" id="button_apperance_settings_set" value="'.__('Next Step', 'wpestate').'"/>'; 
     
        print'</div>';
        
        print'<div class="wpestate_admin_end_notice" id="wpestate_end">';
            print'<p>'.__('For further setup see our help files, knowledgebase articles and tutorials to help make this process easier and more enjoyable for you: ','wpestate') .'<a target="_blank" href="http://help.wpresidence.net/">'.__( 'http://help.wpresidence.net/', 'wpestate' ).'</a></p>';
        print'</div>';
    print'</div>';
}
add_action( 'welcome_panel', 'wpestate_action_welcome_panel', 11, 1 ); // add theme admin welcome panel

//add new dashboard widgets

add_action( 'admin_init', 'wpestate_set_dashboard_meta_order' );
function wpestate_set_dashboard_meta_order() {
  $id = get_current_user_id(); //we need to know who we're updating
  $meta_value = array(
    'normal'  => 'wpestate_dashboard_welcome', //first key/value pair from the above serialized array
    'side'    => 'wpestate_dashboard_links', //second key/value pair from the above serialized array
    'column3' => 'wpestate_dashboard_new_property', //third key/value pair from the above serialized array
    'column4' => 'wpestate_set_payments', //last key/value pair from the above serialized array
  );
  update_user_meta( $id, 'meta-box-order_dashboard', $meta_value ); //update the user meta with the user's ID, the meta_key meta-box-order_dashboard, and the new meta_value
}

// remove_add new dashboard widgets
function wpestate_remove_dashboard_widgets() {
    $user = wp_get_current_user();

        remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');//since 3.8
        
        if( current_user_can('administrator')){
            wp_add_dashboard_widget( 'wpestate_dashboard_welcome', __('Personalize Your Website','wpestate'), 'wpestate_add_welcome_widget' );
            wp_add_dashboard_widget( 'wpestate_dashboard_links', __('Add New Page','wpestate'), 'wpestate_add_new_page_widget' );
            wp_add_dashboard_widget( 'wpestate_set_payments', __('Payments','wpestate'), 'wpestate_add_payments_widget' );
            wp_add_dashboard_widget( 'wpestate_dashboard_new_property', __('Add New Property','wpestate'), 'wpestate_add_new_property_widget' );
        }
        global $wp_meta_boxes;
 
 
}
add_action( 'wp_dashboard_setup', 'wpestate_remove_dashboard_widgets' );



// White labeled wp-admin 
function wpestate_admin_login_logo() { 
         ?> <style type="text/css"> 
        body.login div#login h1 a {
            background-image: url(<?php 
                             $logo       =   esc_html( get_option('wp_estate_logo_image','') );
                            if ($logo != '') {
                                    print  $logo;
                                } else {
                                    print get_template_directory_uri() . '/img/logo.png';
                                };
                                ?>);  //Add your own logo image in this url 
            padding-bottom: 30px; 
            background-size: 161px;
            background-position: center bottom;
            background-repeat: no-repeat;
            color: #444;
            height: 85px;
            width: 161px;
            margin: 0px auto;
            margin-top: 10px;
        }
        body.login {
            background-image: url(<?php print get_template_directory_uri() . '/img/admin_background.png'?>);
        }
        
        #login {
            padding: 0% 0 0;
            margin: auto;
            background-color: #fff;
            position: absolute;
            padding-bottom: 5px;
            box-shadow: 0 1px 3px rgba(0,0,0,.13);
            top: 50%;
            left: 50%;
            margin-left: -160px;
            margin-top: -235px;
        }  
        .login form{
            box-shadow: none;
            padding: 26px 24px 26px;
            margin-top: 0px;
        }
        .interim-login #login {
            margin-left: -160px;
            margin-top: -235px;
            margin-bottom: 0px;
            top: 56%;
        }
        #wp-auth-check-wrap #wp-auth-check {
            max-height: 515px!important;
        }
        .interim-login #login_error, 
        .interim-login.login .message {
            margin: 0px;
        }

</style><?php 
   
 }
 
 add_action('login_head', 'wpestate_admin_login_logo');
 function wpestate_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'wpestate_login_logo_url' );

function wpestate_login_logo_url_title() {
    return __('Powered by ','wpestate'). home_url();
}
add_filter( 'login_headertitle', 'wpestate_login_logo_url_title' );
 
 
 
 
 
 add_action( 'wp_ajax_wpestate_cache_notice_set', 'wpestate_cache_notice_set' );  
if( !function_exists('wpestate_cache_notice_set') ):
function wpestate_cache_notice_set(){ 
  
    
    if(current_user_can('administrator')){
        update_option('wp_estate_cache_notice','yes');
           
    }
    die();

    
}
endif;
