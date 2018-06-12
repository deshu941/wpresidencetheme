<?php
global $options;
global $property_unit_slider;
global $no_listins_per_row;
global $wpestate_uset_unit;
global $custom_unit_structure;
global $align_class;
global $prop_unit;
$col_class=4;
if($options['content_class']=='col-md-12'){
    $col_class=3;
}
$no_listins_per_row         =   intval( get_option('wp_estate_listings_per_row', '') );
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
$user_agency    =   get_post_meta($post->ID,'user_meda_id',true);



$args = array(
        'post_type'         =>  'estate_agent',
        'author'            =>  $user_agency,
        'posts_per_page'    =>  -1,
        'post_status'       => 'publish',
       
        );

$prop_selection = new WP_Query($args);



echo '<div class="mylistings agency_agents_wrapper">';
if( !$prop_selection->have_posts() ){
    print '<h4 class="no_agents">'.__('We don\'t have any agents yet!','wpestate').'</h4>';
}else{
   
    echo '<h3 class="agent_listings_title">'.__('Our Agents','wpestate').'</h3>';
         
    $per_row_class =' agents_4per_row ';
    while ($prop_selection->have_posts()): $prop_selection->the_post();       
        print '<div class="col-md-3 listing_wrapper '.$per_row_class.'">';
            get_template_part('templates/agent_unit');
        print '</div>';  
    endwhile;
}    
echo '</div>';

wp_reset_postdata();
wp_reset_query();