<!-- begin sidebar -->
<div class="clearfix visible-xs"></div>
<?php 
global $options;
global $current_adv_filter_search_action;
global $current_adv_filter_search_category;
global $current_adv_filter_area;
global $current_adv_filter_city;
global $current_adv_filter_county;


$sidebar_name   =   $options['sidebar_name'];
$sidebar_class  =   $options['sidebar_class'];
$args                       =   wpestate_get_select_arguments();

$action_select_list         =   wpestate_get_action_select_list($args);
$categ_select_list          =   wpestate_get_category_select_list($args);
$select_city_list           =   wpestate_get_city_select_list($args); 
$select_area_list           =   wpestate_get_area_select_list($args);
$select_county_state_list   =   wpestate_get_county_state_select_list($args);
$allowed_html               =   array();

if(isset($current_adv_filter_search_action[0]) && $current_adv_filter_search_action[0]!='' && $current_adv_filter_search_action[0]!='all'){
    $get_var_filter_search_type=  esc_html( wp_kses( $current_adv_filter_search_action[0], $allowed_html) );
    $full_name = get_term_by('slug',$get_var_filter_search_type,'property_action_category');
    $adv_actions_value=$adv_actions_value1= $full_name->name;
    $adv_actions_value1 = mb_strtolower ( str_replace(' ', '-', $adv_actions_value1) );
}else{
    $adv_actions_value=__('All Actions','wpestate');
    $adv_actions_value1='all';
}


if(isset($current_adv_filter_search_category[0]) && $current_adv_filter_search_category[0]!='' && $current_adv_filter_search_category[0]!='all'){
    $get_var_filter_search_type=  esc_html( wp_kses( $current_adv_filter_search_category[0], $allowed_html) );
    $full_name = get_term_by('slug',$get_var_filter_search_type,'property_category');
    $adv_categ_value=$adv_categ_value1= $full_name->name;
    $adv_categ_value1 = mb_strtolower ( str_replace(' ', '-', $adv_categ_value1) );
}else{
    $adv_categ_value=__('All Types','wpestate');
    $adv_categ_value1='all';
}

if(isset($current_adv_filter_city[0]) && $current_adv_filter_city[0]!='' && $current_adv_filter_city[0]!='all'){
    $get_var_filter_search_type=  esc_html( wp_kses( $current_adv_filter_city[0], $allowed_html) );
    $full_name = get_term_by('slug',$get_var_filter_search_type,'property_city');
    $advanced_city_value=$advanced_city_value1= $full_name->name;
    $advanced_city_value1 = mb_strtolower ( str_replace(' ', '-', $advanced_city_value1) );
}else{
    $advanced_city_value=__('All Cities','wpestate');
    $advanced_city_value1='all';
}

if(isset($current_adv_filter_area[0]) && $current_adv_filter_area[0]!='' && $current_adv_filter_area[0]!='all'){
    $get_var_filter_search_type=  esc_html( wp_kses( $current_adv_filter_area[0], $allowed_html) );
    $full_name = get_term_by('slug',$get_var_filter_search_type,'property_area');
    $advanced_area_value=$advanced_area_value1= $full_name->name;
    $advanced_area_value1 = mb_strtolower ( str_replace(' ', '-', $advanced_area_value1) );
}else{
    $advanced_area_value=__('All Areas','wpestate');
    $advanced_area_value1='all';
}

if(isset($current_adv_filter_county[0]) && $current_adv_filter_county[0]!='' && $current_adv_filter_county[0]!='all'){
    $get_var_filter_search_type=  esc_html( wp_kses( $current_adv_filter_county[0], $allowed_html) );
    $full_name = get_term_by('slug',$get_var_filter_search_type,'property_county_state');
    $advanced_county_value=$advanced_county_value1= $full_name->name;
    $advanced_county_value1 = mb_strtolower ( str_replace(' ', '-', $advanced_county_value) );
}else{
    $advanced_county_value=__('All Counties/States','wpestate');
    $advanced_county_value1='all';
}
        
?>

<div class="directory_sidebar col-xs-12 <?php print esc_html($options['sidebar_class']);?> widget-area-sidebar" id="primary2" >
<div class="directory_sidebar_wrapper">

    
    <div class="dropdown form-control directory-adv_actions">
        <div data-toggle="dropdown" id="sidebar-adv_actions" class="sidebar_filter_menu" data-value="<?php echo $adv_actions_value1;?>"> 
            <?php echo $adv_actions_value;?>
            <span class="caret caret_sidebar"></span> 
        </div>              
        <input type="hidden" name="filter_search_action[]" value="<?php if(isset($current_adv_filter_search_action[0])){echo ( esc_attr( wp_kses( $current_adv_filter_search_action[0], $allowed_html) ) );}?>">
        <ul  class="dropdown-menu filter_menu" role="menu" aria-labelledby="sidebar-adv_actions">
            <?php echo $action_select_list;?>
        </ul>        
    </div>
  
    
    
    
    
    <div class="dropdown form-control directory-adv_category">
        <div data-toggle="dropdown" id="sidebar-adv_categ" class="sidebar_filter_menu" data-value="<?php echo $adv_categ_value1;?>">
            <?php echo $adv_categ_value;?>    
            <span class="caret caret_sidebar"></span>
        </div>           
        
        <input type="hidden" name="filter_search_type[]" value="<?php if(isset($current_adv_filter_search_category[0])){echo ( esc_attr( wp_kses( $current_adv_filter_search_category[0], $allowed_html) ) );}?>">
        <ul  class="dropdown-menu filter_menu" role="menu" aria-labelledby="sidebar-adv_categ">
            <?php echo $categ_select_list;?>
        </ul>
    </div> 
  
    
     <div class="dropdown form-control directory-adv_conty" >
        <div data-toggle="dropdown" id="sidebar-advanced_county" class="sidebar_filter_menu" data-value="<?php echo $advanced_county_value1;?>">
            <?php echo $advanced_county_value;?>   
            <span class="caret caret_sidebar"></span> 
        </div>           
        
        <input type="hidden" name="advanced_county" value="">
        <ul class="dropdown-menu filter_menu" role="menu" id="adv-search-countystate"  aria-labelledby="sidebar-advanced_area">
            <?php echo $select_county_state_list;?>
        </ul>
    </div>
    
    <div class="dropdown form-control directory-adv_city" >
        <div data-toggle="dropdown" id="sidebar-advanced_city" class="sidebar_filter_menu" data-value="<?php echo $advanced_city_value1;?>">
            <?php echo $advanced_city_value;?>    
            <span class="caret caret_sidebar"></span> 
        </div>           
        
        <input type="hidden" name="advanced_city" value="<?php if(isset($current_adv_filter_city[0])){echo ( esc_attr( wp_kses( $current_adv_filter_city[0], $allowed_html) ) );}?>">
        <ul  class="dropdown-menu filter_menu" role="menu"  id="adv-search-city" aria-labelledby="sidebar-advanced_city">
            <?php echo $select_city_list;?>
        </ul>
    </div>  
    
    
    
    <div class="dropdown form-control directory-adv_area" >
        <div data-toggle="dropdown" id="sidebar-advanced_area" class="sidebar_filter_menu" data-value="<?php echo $advanced_area_value1;?>">
            <?php echo $advanced_area_value;?> 
            <span class="caret caret_sidebar"></span> 
        </div>           
        
        <input type="hidden" name="advanced_area" value="<?php if(isset($current_adv_filter_area[0])){echo ( esc_attr( wp_kses( $current_adv_filter_area[0], $allowed_html) ) );}?>">
        <ul class="dropdown-menu filter_menu" role="menu" id="adv-search-area"  aria-labelledby="sidebar-advanced_area">
            <?php echo $select_area_list;?>
        </ul>
    </div>
    

    
    
    <?php
    $where_currency         =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
    $currency               =   esc_html( get_option('wp_estate_currency_symbol', '') );
    $min_price_slider       =   ( floatval(get_option('wp_estate_show_slider_min_price','')) );
    $max_price_slider       =   ( floatval(get_option('wp_estate_show_slider_max_price','')) );  
    $price_slider_label     =   wpestate_show_price_label_slider($min_price_slider,$max_price_slider,$currency,$where_currency);
    

    print'<div class="adv_search_slider">
        <p>
            <label for="amount_wd">'.__('Price range:','wpestate').'</label>
            <span id="amount_wd"  style="border:0; color:#3C90BE; font-weight:bold;">'.$price_slider_label.'</span>
        </p>
        <div id="slider_price_widget"></div>';
            $custom_fields = get_option( 'wp_estate_multi_curr', true);
            if( !empty($custom_fields) && isset($_COOKIE['my_custom_curr']) &&  isset($_COOKIE['my_custom_curr_pos']) &&  isset($_COOKIE['my_custom_curr_symbol']) && $_COOKIE['my_custom_curr_pos']!=-1){
                $i=intval($_COOKIE['my_custom_curr_pos']);

                if( !isset($_GET['price_low']) && !isset($_GET['price_max'])  ){
                    $min_price_slider       =   $min_price_slider * $custom_fields[$i][2];
                    $max_price_slider       =   $max_price_slider * $custom_fields[$i][2];
                }
            }
            print'
            <input type="hidden" id="price_low_widget"  name="price_low"  value="'.$min_price_slider.'>" />
            <input type="hidden" id="price_max_widget"  name="price_max"  value="'.$max_price_slider.'>" />
    </div>';
            
            
            
            
            
    ?>
    
     <?php
    $measure_sys    =   wpestate_get_meaurement_unit_formated();
    $dir_min_size   =   wpestate_convert_measure( get_post_meta($post->ID,'dir_min_size',true) );
    $dir_max_size   =   wpestate_convert_measure( get_post_meta($post->ID,'dir_max_size',true) )
    ?>
    <div class="directory_slider property_size_slider">
        <p>
            <label for="property_size"><?php  echo __('Size:','wpestate').' '; ?></label>
            <span id="property_size"><?php   echo $dir_min_size.' '.$measure_sys.' '.__('to','wpestate').' '.$dir_max_size.' '.$measure_sys;?></span>
        </p>
        <div id="slider_property_size_widget"></div>
        <input type="hidden" id="property_size_low"  name="property_size_low"  value="<?php echo get_post_meta($post->ID,'dir_min_size',true)?>" />
        <input type="hidden" id="property_size_max"  name="property_size_max"  value="<?php echo get_post_meta($post->ID,'dir_max_size',true)?>" />
   
    </div>
    
    
    <?php
    $dir_min_lot_size   =   wpestate_convert_measure(  get_post_meta($post->ID,'dir_min_lot_size',true) );
    $dir_max_lot_size   =   wpestate_convert_measure(  get_post_meta($post->ID,'dir_max_lot_size',true) );
    ?>
    
    <div class="directory_slider property_lot_size_slider">
        <p>
            <label for="property_lot_size"><?php echo __('Lot Size:','wpestate').' ';?></label>
            <span id="property_lot_size"><?php echo $dir_min_lot_size.' '.$measure_sys.' '.__('to','wpestate').' '.$dir_max_lot_size.' '.$measure_sys;?></span>
        </p>
        <div id="slider_property_lot_size_widget"></div>
        <input type="hidden" id="property_lot_size_low"  name="property_lot_size_low"  value="<?php echo get_post_meta($post->ID,'dir_min_lot_size',true)?>" />
        <input type="hidden" id="property_lot_size_max"  name="property_lot_size_max"  value="<?php echo get_post_meta($post->ID,'dir_max_lot_size',true)?>" />
   
    </div>
    
       
   
    
    <?php
    $dir_rooms_min  = get_post_meta($post->ID,'dir_rooms_min',true);
    $dir_rooms_max   = get_post_meta($post->ID,'dir_rooms_max',true);
    ?>
           
    <div class="directory_slider property_rooms_slider">
        <p>
            <label for="property_rooms"><?php echo __('Property Rooms:','wpestate').' ';?></label>
            <span id="property_rooms"><?php echo $dir_rooms_min.' '.__('to','wpestate').' '.$dir_rooms_max;?></span>
        </p>
        <div id="slider_property_rooms_widget"></div>
        <input type="hidden" id="property_rooms_low"  name="property_rooms_low"  value="<?php echo get_post_meta($post->ID,'dir_rooms_min',true)?>" />
        <input type="hidden" id="property_rooms_max"  name="property_rooms_max"  value="<?php echo get_post_meta($post->ID,'dir_rooms_max',true)?>" />
   
    </div>
    
    
    
    
    <?php
    $dir_bedrooms_min  = get_post_meta($post->ID,'dir_bedrooms_min',true);
    $dir_bedrooms_max   = get_post_meta($post->ID,'dir_bedrooms_max',true);
    ?>
    
    <div class="directory_slider property_bedrooms_slider">
        <p>
            <label for="property_bedrooms"><?php  echo __('Property Bedrooms:','wpestate').' ';?></label>
            <span id="property_bedrooms"><?php echo $dir_bedrooms_min.' '.__('to','wpestate').' '.$dir_bedrooms_max;?></span>
        </p>
        <div id="slider_property_bedrooms_widget"></div>
        <input type="hidden" id="property_bedrooms_low"  name="property_bedrooms_low"  value="<?php echo get_post_meta($post->ID,'dir_bedrooms_min',true)?>" />
        <input type="hidden" id="property_bedrooms_max"  name="property_bedrooms_max"  value="<?php echo get_post_meta($post->ID,'dir_bedrooms_max',true)?>" />
   
    </div>
    
    
 
    
    <?php
    $dir_bathrooms_min  = get_post_meta($post->ID,'dir_bathrooms_min',true);
    $dir_bedrooms_max   = get_post_meta($post->ID,'dir_bathrooms_max',true);
    ?>
    
    <div class="directory_slider property_bathrooms_slider">
        <p>
            <label for="property_bathrooms"><?php echo __('Property Bathrooms:','wpestate').' ';?></label>
            <span id="property_bathrooms"><?php echo $dir_bathrooms_min.' '.__('to','wpestate').' '.$dir_bedrooms_max;?></span>
        </p>
        <div id="slider_property_bathrooms_widget"></div>
        <input type="hidden" id="property_bathrooms_low"  name="property_bathrooms_low"  value="<?php echo $dir_bathrooms_min;?>" />
        <input type="hidden" id="property_bathrooms_max"  name="property_bathrooms_max"  value="<?php echo $dir_bedrooms_max;?>" />
   
    </div>
    
    
    <?php
     
    $status_values          =   esc_html( get_option('wp_estate_status_list') );
    $status_values_array    =   explode(",",$status_values);
    $property_status        =   '';

    
    foreach ($status_values_array as $key=>$value) {
        if(trim($value)!= ''){
            if (function_exists('icl_translate') ){
                $value     =   icl_translate('wpestate','wp_estate_property_status_'.$value, $value ) ;                                      
            }

            $value  =   trim($value);
            $value  =   stripslashes($value);
     $valuex=   str_replace(html_entity_decode('&#039;', ENT_COMPAT, 'UTF-8'), ' ', $value);
            
            $property_status.='<option value="' . $value. '"';
           
            $property_status.='>' . $value . '</option>';
        }   
    }
    
    ?>
    
    <div class="property_status_wrapper">
        <label for="property_status"><?php _e('Property Status:','wpestate');?></label><br />
        <select id="property_status"   class="form-control" name="property_status">
        <option value="normal"><?php _e('Property Status','wpestate');?></option>
        <?php echo $property_status ;?>
        </select>
    </div>
    
    
    <div class="property_keyword_wrapper">
        <label for="property_keyword"><?php _e('Property Keyword:','wpestate');?></label><br />
        <input type="text" id="property_keyword" class="form-control" placeholder="<?php _e('keyword','wpestate');?>">
    </div>
    
    <div class="extended_search_check_wrapper_directory">
        <?php
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
                    print'
                    <div class="extended_search_checker '.$input_name.'_directory">
                        <input type="checkbox" id="'.$input_name.'widget" name="'.$input_name.'" value="1">
                        <label class="directory_checkbox" for="'.$input_name.'widget">'.($value).'</label>
                    </div>';
                }
        }
        ?>
    </div>
    <input type="hidden" id="property_dir_per_page" value="<?php echo intval( get_option('wp_estate_prop_no', '') )?>">
    <input type="hidden" id="property_dir_pagination" value="1">
    <input type="hidden" id="property_dir_done" value="0">
    
    </div>

</div>   

<?php 
if(!wp_is_mobile() ){
?>
    <div class="col-xs-12 <?php print esc_html($options['sidebar_class']);?> widget-area-sidebar" id="primary" >
        <ul class="xoxo">
            <?php   generated_dynamic_sidebar( $options['sidebar_name'] ); ?>
        </ul>
    </div>

<?php 
} 
?>