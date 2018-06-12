<?php
global $current_adv_filter_search_label;
global $current_adv_filter_category_label;
global $current_adv_filter_city_label;
global $current_adv_filter_area_label;
global $prop_unit;

$current_name      =   '';
$current_slug      =   '';
$listings_list     =   '';
$show_filter_area  =   get_post_meta($post->ID, 'show_filter_area', true);

if( is_tax() ){
    $show_filter_area = 'yes';
    $current_adv_filter_search_label    =__('All Actions','wpestate');
    $current_adv_filter_category_label  =__('All Types','wpestate');
    $current_adv_filter_city_label      =__('All Cities','wpestate');
    $current_adv_filter_area_label      =__('All Areas','wpestate');
    $taxonmy                            = get_query_var('taxonomy');
//  $term                               = get_query_var( 'name' );
    $term                               = single_cat_title('',false);
    
    if ($taxonmy == 'property_city'){
        $current_adv_filter_city_label = ucwords( str_replace('-',' ',$term) );
    }
    if ($taxonmy == 'property_area'){
        $current_adv_filter_area_label = ucwords( str_replace('-',' ',$term) );
    }
    if ($taxonmy == 'property_category'){
        $current_adv_filter_category_label = ucwords( str_replace('-',' ',$term) );
    }
    if ($taxonmy == 'property_action_category'){
        $current_adv_filter_search_label = ucwords( str_replace('-',' ',$term) );
    }
    
}

?>
<div data-toggle="dropdown" id="second_filter_action" class="hide" data-value="<?php print $current_adv_filter_search_label;?>"> <?php print $current_adv_filter_search_label;?>  </div>           
<div data-toggle="dropdown" id="second_filter_categ" class="hide" data-value="<?php print $current_adv_filter_category_label;?> "> <?php print $current_adv_filter_category_label;?> </div>           
<div data-toggle="dropdown" id="second_filter_cities" class="hide" data-value="<?php print $current_adv_filter_city_label;?>"> <?php print $current_adv_filter_city_label;?>  </div>           
<div data-toggle="dropdown" id="second_filter_areas"  class="hide" data-value="<?php print $current_adv_filter_area_label;?>"><?php print $current_adv_filter_area_label;?></div>           
      