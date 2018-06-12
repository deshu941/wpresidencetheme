<!-- GET AGENT LISTINGS-->
<?php
global $property_unit_slider;
global $no_listins_per_row;
global $wpestate_uset_unit;
global $custom_unit_structure;
global $align_class;
global $prop_unit_class;
global $prop_unit;
global $post;
$prop_unit      =   esc_html ( get_option('wp_estate_prop_unit','') );
$prop_no        =   intval( get_option('wp_estate_prop_no', '') );
$prop_unit_class            =   '';
if($prop_unit=='list'){
    $prop_unit_class="ajax12";
    $align_class=   'the_list_view';
}

$agent_id    =   get_post_meta($post->ID,'user_meda_id',true);
 
if( !$agent_id ){
    $agent_id = -1;
}
 

$property_unit_slider       =   get_option('wp_estate_prop_list_slider','');
if(isset($_GET['pagelist'])){
    $paged = intval( $_GET['pagelist'] );
}else{
    $paged = 1;
}


$custom_unit_structure      =   get_option('wpestate_property_unit_structure');
$wpestate_uset_unit         =   intval ( get_option('wpestate_uset_unit','') );
$no_listins_per_row         =   intval( get_option('wp_estate_listings_per_row', '') );
$property_card_type         =   intval(get_option('wp_estate_unit_card_type'));
if($property_card_type==0){
    $property_card_type_string='';
}else{
    $property_card_type_string='_type'.$property_card_type;
}


$terms=array();
$selected_term='';
 

if( $agent_id === -1 ){
	// try to query by agent post type id
	$args = array(
        'post_type'         =>  'estate_property',
		
        'paged'             =>  $paged,
        'posts_per_page'    =>  $prop_no,
        'post_status'       => 'publish',
        'meta_key'          => 'prop_featured',
        'orderby'           => 'meta_value',
        'order'             => 'DESC',
		'meta_query' => array(
			array(
				'key'     => 'property_agent',
				'value'   => $post->ID,
			),
		),
        );
        $mapargs = array(
            'post_type'         => 'estate_property',
            'post_status'       => 'publish',
            'posts_per_page'    => -1,
            'meta_query'        => array(
                                        array(
                                            'key'   => 'property_agent',
                                            'value' => $post->ID,
                                        )
                                )
                    );
        
}else{
	$args = array(
            'post_type'         =>  'estate_property',
            'author'            =>  $agent_id,
            'paged'             =>  $paged,
            'posts_per_page'    =>  $prop_no,
            'post_status'       => 'publish',
            'meta_key'          => 'prop_featured',
            'orderby'           => 'meta_value',
            'order'             => 'DESC',
        );
        $mapargs = array(
            'post_type'         =>  'estate_property',
            'author'            =>  $agent_id,
            'paged'             =>  $paged,
            'posts_per_page'    =>  '-1',
            'post_status'       => 'publish',
        );
        
}
 
add_filter( 'posts_orderby', 'wpestate_my_order' );
$prop_selection = new WP_Query($args);
remove_filter( 'posts_orderby', 'wpestate_my_order' );

$tab_terms = array();

$terms = get_terms( 'property_category', array(
    'hide_empty' => false,
) );
$transient_agent_id='';
foreach( $terms as $single_term ){
	
	// if agent field is not set - check select 
	if( $agent_id === -1 ){
            $transient_agent_id='meta_property_agent_'.$post->ID;
            $args = array(
                'post_type'         =>  'estate_property',      
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
                        'fields' => 'ids',
                        'meta_query' => array(
                                array(
                                        'key'     => 'property_agent',
                                        'value'   => $post->ID,
                                ),
                        ),
               );
	}else{
              $transient_agent_id='custom_post_'.$agent_id;
		$args = array(
                    'post_type'         =>  'estate_property',
                    'author'        =>  $agent_id,        
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
	}
	
	
        $all_posts = get_posts( $args );

        if( count( $all_posts ) > 0 )
        $tab_terms[ $single_term->term_id ] = array( 
                                            'name' => $single_term->name, 
                                            'slug' => $single_term->slug, 
                                            'count' => count( $all_posts ) 
                                            );
}


$term_bar='<div class="term_bar_item active_term" data-term_id="0" data-term_name="all">'.__('All','wpestate').' ('.$prop_selection->found_posts.')</div>';


	if( count($tab_terms) > 0 ){
		foreach($tab_terms as $key=>$value){
			$term_bar .= '<div class="term_bar_item "   data-term_id="'.$key.'" data-term_name="'.$value['slug'].'" >'. $value['name'].' ('. $value['count'].')</div>';
		}
	}

    if($prop_selection->have_posts()):
        echo '<div class="mylistings agent_listing agency_listings_title single_listing_block">';
            
            echo'<h3 class="agent_listings_title">'.__('My Listings','wpestate').'</h3>';
            
            echo '<div class="term_bar_wrapper" data-agent_id="'.$agent_id.'" data-post_id="'.$post->ID.'" >'.$term_bar.'</div>';
            
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



if (wp_script_is( 'googlecode_regular', 'enqueued' )) {
    
  
    $max_pins                   =   intval( get_option('wp_estate_map_max_pins') );
    $mapargs['posts_per_page']  =   $max_pins;
    $mapargs['offset']          =   ($paged-1)*9;
    $mapargs['fields']          =   'ids';
    
    $transient_appendix='_agent_listings_'.$transient_agent_id;
    $selected_pins  =   wpestate_listing_pins($transient_appendix,1,$mapargs,1);//call the new pins 
  
    wp_localize_script('googlecode_regular', 'googlecode_regular_vars2', 
                array('markers2'          =>  $selected_pins,
                      'agent_id'             =>  $agent_id ));

}


?>