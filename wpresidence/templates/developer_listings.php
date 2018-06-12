<?php
global $property_unit_slider;
global $no_listins_per_row;
global $wpestate_uset_unit;
global $custom_unit_structure;
global $align_class;
global $prop_unit_class;
global $prop_unit;
$property_unit_slider       =   get_option('wp_estate_prop_list_slider','');
$prop_unit                  =   esc_html ( get_option('wp_estate_prop_unit','') );
$prop_unit_class            =   '';
if($prop_unit=='list'){
    $prop_unit_class="ajax12";
    $align_class=   'the_list_view';
}


$user_agency    =   get_post_meta($post->ID,'user_meda_id',true);
$agent_list     =   (array)get_user_meta($user_agency,'current_agent_list',true);
$agent_list[]   =   $user_agency;
$prop_no        =   intval( get_option('wp_estate_prop_no', '') );
$paged = (get_query_var('page')) ? get_query_var('page') : 1;

if(isset($_GET['pagelist'])){
    $paged = intval( $_GET['pagelist'] );
}else{
    $paged = 1;
}

$custom_unit_structure      =   get_option('wpestate_property_unit_structure');
$wpestate_uset_unit         =   intval ( get_option('wpestate_uset_unit','') );
$no_listins_per_row         =   intval( get_option('wp_estate_listings_per_row', '') );
$property_card_type         =   intval(get_option('wp_estate_unit_card_type'));
$property_card_type_string  =   '';
if($property_card_type==0){
    $property_card_type_string='';
}else{
    $property_card_type_string='_type'.$property_card_type;
}


$terms=array();
$selected_term='';
 

$args = array(
        'post_type'         =>  'estate_property',
        'author__in'        =>  $agent_list,
        'paged'             =>  $paged,
        'posts_per_page'    =>  $prop_no,
        'post_status'       => 'publish',
        'meta_key'          => 'prop_featured',
        'orderby'           => 'meta_value',
        'order'             => 'DESC',
        );

 
$prop_selection = new WP_Query($args);

$tab_terms = array();

$terms = get_terms( 'property_category', array(
    'hide_empty' => false,
) );
foreach( $terms as $single_term ){
	$args = array(
        'post_type'         =>  'estate_property',
        'author__in'        =>  $agent_list,      
        'posts_per_page'    =>  -1,
        'post_status'       => 'publish',
        'meta_key'          => 'prop_featured',
        'orderby'           => 'meta_value',
        'order'             => 'DESC',
		'tax_query' => array(
			array(
				'taxonomy' => 'property_category',
				'field'    => 'term_id',
				'terms'    => $single_term->term_id,
			),
		),
		'fields' => 'ids'
       );
	   $all_posts = get_posts( $args );
	   
	   if( count( $all_posts ) > 0 )
	   $tab_terms[ $single_term->term_id ] = array( 'name' => $single_term->name, 'slug' => $single_term->slug, 'count' => count( $all_posts ) );
}



$term_bar='<div class="term_bar_item active_term" data-term_id="0" data-term_name="all">'.__('All','wpestate').' ('.$prop_selection->found_posts.')</div>';

	foreach($tab_terms as $key=>$value){
        $term_bar .= '<div class="term_bar_item "   data-term_id="'.$key.'" data-term_name="'.$value['slug'].'" >'. $value['name'].' ('. $value['count'].')</div>';
    } 
 


	
	 if($prop_selection->have_posts()):
        echo '<div class="mylistings developer_listing agency_listings_title single_listing_block">';
            echo '<div class="term_bar_wrapper" data-agency_id="'.$user_agency.'" data-post_id="'.$post->ID.'"  >'.$term_bar.'</div>';
            
			echo '
                 <div class="agency_listings_wrapper">';
            while ($prop_selection->have_posts()): $prop_selection->the_post();   
                $property_category     =   get_the_terms($post->ID, 'property_category') ;

                get_template_part('templates/property_unit'.$property_card_type_string);

            endwhile; 
  
        echo '</div>';
		echo '<div class="spinner" id="listing_loader">
                    <div class="new_prelader"></div>
                </div>';
		echo '
			<div class="load_more_ajax_cont">
				<input type="button" class="wpresidence_button listing_load_more" value="'.__('Load More Properties','wpestate').'">
				<!--
				<img  class="load_more_progress_bar" src="'.get_template_directory_uri().'/img/ajax-loader-gmap.gif" /> -->
			</div>
		</div>';
    endif;
	



wp_reset_postdata();
wp_reset_query();
