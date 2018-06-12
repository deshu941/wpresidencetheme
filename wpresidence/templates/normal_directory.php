<?php
global $prop_selection;
global $options;
global $num;
global $args;
global $custom_advanced_search;
global $adv_search_what;
global $adv_search_how;
global $adv_search_label;
global $prop_unit_class;
global $show_compare_only;
global $property_unit_slider;
global $custom_post_type;
global $col_class;
global $custom_unit_structure;
global $no_listins_per_row;
global $wpestate_uset_unit;
global $included_ids;
global $prop_unit;
$wpestate_uset_unit         =   intval ( get_option('wpestate_uset_unit','') );
$no_listins_per_row         =   intval( get_option('wp_estate_listings_per_row', '') );
$custom_unit_structure      =   get_option('wpestate_property_unit_structure');
$taxonmy                    =   get_query_var('taxonomy');
$term                       =   get_query_var( 'term' );
$property_unit_slider       =   get_option('wp_estate_prop_list_slider','');
$property_card_type         =   intval(get_option('wp_estate_unit_card_type'));
$property_card_type_string  =   '';
if($property_card_type==0){
    $property_card_type_string='';
}else{
    $property_card_type_string='_type'.$property_card_type;
}

if( is_tax() && $custom_post_type=='estate_agent'){
global $no_listins_per_row;
$no_listins_per_row       =   intval( get_option('wp_estate_agent_listings_per_row', '') );

$col_class=4;
if($options['content_class']=='col-md-12'){
    $col_class=3;
}

if($no_listins_per_row==3){
    $col_class  =   '6';
    $col_org    =   6;
    if($options['content_class']=='col-md-12'){
        $col_class  =   '4';
        $col_org    =   4;
    }
}else{   
    $col_class  =   '4';
    $col_org    =   4;
    if($options['content_class']=='col-md-12'){
        $col_class  =   '3';
        $col_org    =   3;
    }
}

}
   


$selected_order         =   __('Sort by','wpestate');
$listing_filter         =   '';
$listings_list          =   '';
if( isset($post->ID) ){
    $listing_filter         = get_post_meta($post->ID, 'listing_filter',true );
}
$listing_filter_array   = array(
                            "1"=>__('Price High to Low','wpestate'),
                            "2"=>__('Price Low to High','wpestate'),
                            "3"=>__('Newest first','wpestate'),
                            "4"=>__('Oldest first','wpestate'),
                            "5"=>__('Bedrooms High to Low','wpestate'),
                            "6"=>__('Bedrooms Low to high','wpestate'),
                            "7"=>__('Bathrooms High to Low','wpestate'),
                            "8"=>__('Bathrooms Low to high','wpestate'),
                            "0"=>__('Default','wpestate')
                        );
    

$args = wpestate_get_select_arguments();


foreach($listing_filter_array as $key=>$value){
    $listings_list.= '<li role="presentation" data-value="'.$key.'">'.$value.'</li>';

    if($key==$listing_filter){
        $selected_order     =   $value;
        $selected_order_num =   $key;
    }
}   
      

$order_class='';

?>

<div class="row">
    <?php get_template_part('templates/breadcrumbs'); ?>
    <div class=" <?php print esc_html($options['content_class']);?> ">
        
        <div class="single-content" style="margin-bottom:20px;">
            <?php 
                if (esc_html( get_post_meta($post->ID, 'page_show_title', true) ) == 'yes') { ?>
                    <h1 class="entry-title title_prop"><?php the_title(); ?></h1>                
            <?php 
                } 
            ?>
                    
            <?php   
                if (   !is_tax() ){
                    echo get_the_content();
                }
            ?>
        </div>

              
        <!--Filters starts here-->     
        <div class="listing_filters_head_directory"> 
            <input type="hidden" id="page_idx" value="<?php 
            if ( !is_tax() && !is_category() ) { 
               print $post->ID;
            }?>">

            <div class="dropdown listing_filter_select order_filter <?php print $order_class;?>">
                <div data-toggle="dropdown" id="a_filter_order_directory" class="filter_menu_trigger" data-value="<?php echo esc_html($selected_order_num);?>"> <?php echo esc_html($selected_order); ?> <span class="caret caret_filter"></span> </div>           
                 <ul id="filter_order" class="dropdown-menu filter_menu" role="menu" aria-labelledby="a_filter_order">
                     <?php print $listings_list; ?>                   
                 </ul>        
            </div> 


            <?php
            $prop_unit_list_class    =   '';
            $prop_unit_grid_class    =   'icon_selected';
            if($prop_unit=='list'){
                $prop_unit_grid_class="";
                $prop_unit_list_class="icon_selected";
            }

            ?>    
        
            <div class="listing_filter_select listing_filter_views">
                <div id="grid_view" class="<?php echo esc_html($prop_unit_grid_class); ?>"> 
                    <i class="fa fa-th"></i>
                </div>
            </div>

            <div class="listing_filter_select listing_filter_views">
                 <div id="list_view" class="<?php echo esc_html($prop_unit_list_class); ?>">
                     <i class="fa fa-bars"></i>                   
                 </div>
            </div>
           
    </div> 
        <!--Filters Ends here-->   
  
        
        <!-- Listings starts here -->                   
       
        
        <?php if( $custom_post_type=='estate_agent'){?>
            <div id=" listing_ajax_container_agent_tax" class="<?php echo esc_html($prop_unit_class);?>"></div> 
        <?php } ?> 
             
        <div id="listing_ajax_container" class="<?php echo esc_html($prop_unit_class);?>"> 
        
            <?php
            global $tax_categ_picked;
            global $tax_action_picked;
            global $tax_city_picked;
            global $taxa_area_picked;
            ?>
            
            <input type="hidden" id="tax_categ_picked" value="<?php echo $tax_categ_picked;?>">
            <input type="hidden" id="tax_action_picked" value="<?php echo $tax_action_picked;?>">
            <input type="hidden" id="tax_city_picked" value="<?php echo $tax_city_picked;?>">
            <input type="hidden" id="taxa_area_picked" value="<?php echo $taxa_area_picked;?>">
            <?php
           

            $show_compare_only  =   'yes';
            $counter = 0;
            if( is_page_template('advanced_search_results.php') ) {
                $first=0;
                if ($prop_selection->have_posts()){    
                    while ($prop_selection->have_posts()): $prop_selection->the_post();
                        if( isset($_GET['is2']) && $_GET['is2']==1 && $first==0 ){
                            $gmap_lat    =   esc_html(get_post_meta($post->ID, 'property_latitude', true));
                            $gmap_long   =   esc_html(get_post_meta($post->ID, 'property_longitude', true));
                            if($gmap_lat!='' && $gmap_long!=''){
                                print '<span style="display:none" id="basepoint" data-lat="'.$gmap_lat.'" data-long="'.$gmap_long.'"></span>';
                                $first=1;
                            }
                        }

                        get_template_part('templates/property_unit'.$property_card_type_string);
                        
                        
                    endwhile;
                }else{   
                    print '<div class="bottom_sixty">';
                    _e('We didn\'t find any results. Please try again with different search parameters. ','wpestate');
                    print '</div>';
                }  
            }else{
                if( $prop_selection->have_posts() ){
                    
                    while ($prop_selection->have_posts()): $prop_selection->the_post(); 
                        if($custom_post_type!='estate_agent'){
                            get_template_part('templates/property_unit'.$property_card_type_string);
                        }else{
                            print '<div class="col-md-'.$col_class.' listing_wrapper">';
                                get_template_part('templates/agent_unit'); 
                            print '</div>';
                        }
                       
                    endwhile;
                }else{
                    if($custom_post_type!='estate_agent'){
                        print '<h4 class="nothing">'.__('There are no properties listed on this page at this moment. Please try again later. ','wpestate').'</h4>';
                    }else{
                        print '<h4 class="nothing">'.__('There are no agents listed on this page at this moment. Please try again later. ','wpestate').'</h4>';
                    }
                    
                    }
            }
           
            
            wp_reset_query();               
        ?>
            
            
       
        </div>
        <?php  get_template_part('templates/spiner'); ?> 
            
        <?php   if( $prop_selection->have_posts() ){?> 
            <div id="directory_load_more" class="wpresidence_button"><?php _e('Load More Listings','wpestate')?></div>  
        <?php } ?>
        <!-- Listings Ends  here --> 
        
        <?php   
            if (   !is_tax() ){
                print '   <div class="single-content">';
                $property_list_second_content = get_post_meta($post->ID, 'property_list_second_content', true);
                echo do_shortcode($property_list_second_content);
                print '</div>';
            }
          ?>
        
        <?php //kriesi_pagination($prop_selection->max_num_pages, $range =2); ?>       
    <?php 
    if( wp_is_mobile() ){
    ?>
        <div class="col-xs-12 <?php print esc_html($options['sidebar_class']);?> widget-area-sidebar" id="primary" >
            <ul class="xoxo">
                <?php   generated_dynamic_sidebar( $options['sidebar_name'] ); ?>
            </ul>
        </div>

    <?php 
    } 
    ?>    
    </div><!-- end 9col container-->
    
 
    
<?php  get_template_part('templates/directory_filters') ?>
</div>   