<?php


get_header();
get_currentuserinfo();
$options            =   wpestate_page_details($post->ID);
$show_compare       =   1;
$area_array         =   ''; 
$city_array         =   '';  
$action_array       =   '';
$categ_array        =   '';
$id_array           =   '';
$countystate_array  =   '';

$compare_submit         =   get_compare_link();
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



if($custom_advanced_search==='yes'){ // we have CUSTOM advanced search
    //get custom search fields
    $adv_search_what    = get_option('wp_estate_adv_search_what','');
    $adv_search_how     = get_option('wp_estate_adv_search_how','');
    $adv_search_label   = get_option('wp_estate_adv_search_label','');                    
    $adv_search_type    = get_option('wp_estate_adv_search_type','');


    foreach($adv_search_what as $key=>$term){

        if($term=='none'){
                           
        }else if($term=='property id'){
            $term         =     str_replace(' ', '_', $term);
            $slug         =     wpestate_limit45(sanitize_title( $term )); 
            $slug         =     sanitize_key($slug); 
            $string       =     wpestate_limit45 ( sanitize_title ($adv_search_label[$key]) );              
            $slug_name    =     sanitize_key($string);
            $id_array     =     intval ($_POST[$slug_name]);
        }
        else if($term=='categories'){ // for property_category taxonomy
                if (isset($_POST['filter_search_type']) && $_POST['filter_search_type'][0]!='all' && $_POST['filter_search_type'][0]!=''){
                    $taxcateg_include   =   array();

                    foreach($_POST['filter_search_type'] as $key=>$value){
                        $taxcateg_include[]= sanitize_title($value);
                    }

                    $categ_array=array(
                         'taxonomy' => 'property_category',
                         'field' => 'slug',
                         'terms' => $taxcateg_include
                    );
                } 
        } /////////// end if categories
       

        else if($term=='types'){ // for property_action_category taxonomy
                if ( ( isset($_POST['filter_search_action']) && $_POST['filter_search_action'][0]!='all' && $_POST['filter_search_action'][0]!='' ) ){
                    $taxaction_include   =   array();   

                    foreach( $_POST['filter_search_action'] as $key=>$value){
                        $taxaction_include[]= sanitize_title ($value);
                    }

                    $action_array=array(
                        'taxonomy'  => 'property_action_category',
                        'field'     => 'slug',
                        'terms'     => $taxaction_include
                    );
                }
        } //////////// end for property_action_category taxonomy


        else if($term=='cities'){ // for property_city taxonomy
                if (isset($_POST['advanced_city']) && $_POST['advanced_city'] != 'all' && $_POST['advanced_city'] != '' ) {
                    $taxcity[]  = sanitize_title ( $_POST['advanced_city'] );
                    $city_array = array(
                        'taxonomy'  => 'property_city',
                        'field'     => 'slug',
                        'terms'     => $taxcity
                    );
                }
        } //////////// end for property_city taxonomy

        else if($term=='areas'){ // for property_area taxonomy

                if (isset($_POST['advanced_area']) && $_POST['advanced_area'] != 'all' &&  $_POST['advanced_area'] != '') {
                    $taxarea[]  = sanitize_title($_POST['advanced_area']);
                    $area_array = array(
                        'taxonomy' => 'property_area',
                        'field' => 'slug',
                        'terms' => $taxarea
                    );
                }
        } //////////// end for property_area taxonomy
        else if($term=='county / state'){ // for property_area taxonomy
          
                if (isset($_POST['advanced_contystate']) && $_POST['advanced_contystate'] != 'all' &&  $_POST['advanced_contystate'] != '') {
                    $taxarea[]  = sanitize_title($_POST['advanced_contystate']);
               
                    $countystate_array = array(
                        'taxonomy' => 'property_county_state',
                        'field' => 'slug',
                        'terms' => $taxarea
                    );
                }
        } //////////// end for property_area taxonomy

        else{ 

         //   $slug_name         =   wpestate_limit45(sanitize_title( $term ));
         //   $slug_name         =   sanitize_key($slug_name);
         //   $slug_name_key     =   $slug_name; 
           
                
            $term         =   str_replace(' ', '_', $term);
            $slug         =   wpestate_limit45(sanitize_title( $term )); 
            $slug         =   sanitize_key($slug); 
            
            $string       =   wpestate_limit45 ( sanitize_title ($adv_search_label[$key]) );              
            $slug_name    =   sanitize_key($string);
            $compare_array  =   array();
             $show_slider_price            =   get_option('wp_estate_show_slider_price','');
                       
            if ( $adv_search_what[$key]=='property price' && $show_slider_price==='yes'){
                $compare_array['key']        = 'property_price';
                if(isset($_POST['price_low'])){
                     $compare_array['value']      = $_POST['price_low'];
                }
                $compare_array['type']       = 'numeric';
                $compare_array['compare']    = '>=';
                $meta_query[]                = $compare_array;

                $compare_array['key']        = 'property_price';
                if(isset($_POST['price_max'])){
                    $compare_array['value']      = $_POST['price_max'];
                }
                $compare_array['type']       = 'numeric';
                $compare_array['compare']    = '<=';
                $meta_query[]                = $compare_array;

                
            } else if( isset($_POST[$slug_name]) && $adv_search_label[$key] != $_POST[$slug_name] && $_POST[$slug_name] != ''){ // if diffrent than the default values
                    $compare        =   '';
                    $search_type    =   ''; 
                  
                    $allowed_html   =   array();
                     //$adv_search_how
                    
                 

                    $compare=$adv_search_how[$key];

                    if($compare=='equal'){
                       $compare='='; 
                       $search_type='numeric';
                       $term_value= floatval ( $_POST[$slug_name] );

                    }else if($compare=='greater'){
                        $compare='>='; 
                        $search_type='numeric';
                        $term_value= floatval ( $_POST[$slug_name] );

                    }else if($compare=='smaller'){
                        $compare='<='; 
                        $search_type='numeric';
                        $term_value= floatval ( $_POST[$slug_name] );

                    }else if($compare=='like'){
                        $compare='LIKE'; 
                        $search_type='CHAR';
                        $term_value= wp_kses( $_POST[$slug_name] ,$allowed_html);

                    }else if($compare=='date bigger'){
                        $compare='>='; 
                        $search_type='DATE';
                        $term_value= wp_kses( $_POST[$slug_name],$allowed_html );

                    }else if($compare=='date smaller'){
                        $compare='<='; 
                        $search_type='DATE';
                        $term_value= wp_kses( $_POST[$slug_name],$allowed_html );
                    }

                    $compare_array['key']        = $slug;
                    $compare_array['value']      = $term_value;
                    $compare_array['type']       = $search_type;
                    $compare_array['compare']    = $compare;
                    $meta_query[]                = $compare_array;

          }// end if diffrent
        }////////////////// end last else
     } ///////////////////////////////////////////// end for each adv search term

}else{ // no advanced search
                    
    //////////////////////////////////////////////////////////////////////////////////////
    ///// category filters 
    //////////////////////////////////////////////////////////////////////////////////////

    if (isset($_POST['filter_search_type']) && $_POST['filter_search_type'][0]!='all' && $_POST['filter_search_type'][0]!='' ){
            $taxcateg_include   =   array();

            foreach($_POST['filter_search_type'] as $key=>$value){
                $taxcateg_include[]= sanitize_title ( $value );
            }

            $categ_array=array(
                 'taxonomy'     => 'property_category',
                 'field'        => 'slug',
                 'terms'        => $taxcateg_include
            );
     }

    //////////////////////////////////////////////////////////////////////////////////////
    ///// action  filters 
    //////////////////////////////////////////////////////////////////////////////////////

      if ( ( isset($_POST['filter_search_action']) && $_POST['filter_search_action'][0]!='all' && $_POST['filter_search_action'][0]!='') ){
            $taxaction_include   =   array();   

            foreach( $_POST['filter_search_action'] as $key=>$value){
                $taxaction_include[]    = sanitize_title ( $value );
            }

            $action_array=array(
                 'taxonomy'     => 'property_action_category',
                 'field'        => 'slug',
                 'terms'        => $taxaction_include
            );
     }


    //////////////////////////////////////////////////////////////////////////////////////
    ///// city filters 
    //////////////////////////////////////////////////////////////////////////////////////

     if (isset($_POST['advanced_city']) and $_POST['advanced_city'] != 'all' && $_POST['advanced_city'] != '') {
         $taxcity[] = sanitize_title ( ($_POST['advanced_city']) );
         $city_array = array(
             'taxonomy'     => 'property_city',
             'field'        => 'slug',
             'terms'        => $taxcity
         );
     }

    //////////////////////////////////////////////////////////////////////////////////////
    ///// area filters 
    //////////////////////////////////////////////////////////////////////////////////////

     if (isset($_POST['advanced_area']) and $_POST['advanced_area'] != 'all' && $_POST['advanced_area'] != '') {
         $taxarea[] = sanitize_title (  ($_POST['advanced_area']) );
         $area_array = array(
             'taxonomy'     => 'property_area',
             'field'        => 'slug',
             'terms'        => $taxarea
         );
     }

    //////////////////////////////////////////////////////////////////////////////////////
    ///// rooms and baths filters 
    //////////////////////////////////////////////////////////////////////////////////////

     $meta_query = $rooms = $baths = $price = array();
     if (isset($_POST['advanced_rooms']) && is_numeric($_POST['advanced_rooms'])) {
         $rooms['key'] = 'property_bedrooms';
         $rooms['value'] = floatval ($_POST['advanced_rooms']);
         $meta_query[] = $rooms;
     }

     if (isset($_POST['advanced_bath']) && is_numeric($_POST['advanced_bath'])) {
         $baths['key'] = 'property_bathrooms';
         $baths['value'] = floatval ($_POST['advanced_bath']);
         $meta_query[] = $baths;
     }


    //////////////////////////////////////////////////////////////////////////////////////
    ///// price filters 
    //////////////////////////////////////////////////////////////////////////////////////
    $price_low ='';
    if( isset($_POST['price_low'])){
        $price_low         = intval($_POST['price_low']);
        $price['key']      = 'property_price';
        $price['value']    = $price_low;
        $price['type']     = 'numeric';
        $price['compare']  = '>='; 
        $meta_query[]     = $price;
    }

    $price_max='';
    if( isset($_POST['price_max'])  && is_numeric($_POST['price_max']) ){
        $price_max         = intval($_POST['price_max']);
        $price['key']      = 'property_price';
        $price['value']    = $price_max;
        $price['type']     = 'numeric';
        $price['compare']  = '<='; 
        $meta_query[] = $price;
    }

} // end ? custom advnced search
                



//////////////////////////////////////////////////////////////////////////////////////
///// features and ammenities
//////////////////////////////////////////////////////////////////////////////////////

$feature_list_array =   array();
$feature_list       =   esc_html( get_option('wp_estate_feature_list') );
$feature_list_array =   explode( ',',$feature_list);

foreach($feature_list_array as $checker => $value){
    $post_var_name  =   str_replace(' ','_', trim($value) );
    $input_name     =   wpestate_limit45(sanitize_title( $post_var_name ));
    $input_name     =   sanitize_key($input_name);
                
    if ( isset( $_POST[$input_name] ) && $_POST[$input_name]==1 ){

        $feature=array();
        $feature['key']         = $input_name;
        $feature['value']       = 1;
        $feature['type']        = '=';
        $feature['compare']     = 'CHAR';
        $meta_query[]           = $feature;
    }
}








    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    if($paged>1){

       $meta_query= get_option('wpestate_pagination_meta_query','');
       $categ_array= get_option('wpestate_pagination_categ_query','');
       $action_array= get_option('wpestate_pagination_action_query','');
       $city_array= get_option('wpestate_pagination_city_query','');
       $area_array=get_option('wpestate_pagination_area_query','');
       $county_state_array=get_option('wpestate_pagination_county_state_query','');
    }else{
        update_option('wpestate_pagination_meta_query',$meta_query);
        update_option('wpestate_pagination_categ_query',$categ_array);
        update_option('wpestate_pagination_action_query',$action_array);
        update_option('wpestate_pagination_city_query',$city_array);
        update_option('wpestate_pagination_area_query',$area_array);
        update_option('wpestate_pagination_county_state_query',$countystate_array);
    }

                            
//////////////////////////////////////////////////////////////////////////////////////
///// compose query 
//////////////////////////////////////////////////////////////////////////////////////
    $args = array(
        'post_type'       => 'estate_property',
        'post_status'     => 'publish',
        'paged'           => $paged,
        'posts_per_page'  => 30,
        'meta_key'        => 'prop_featured',
        'orderby'         => 'meta_value',
        'order'           => 'DESC',
        'meta_query'      => $meta_query,
        'tax_query'       => array(
                                    'relation' => 'AND',
                                    $categ_array,
                                    $action_array,
                                    $city_array,
                                    $area_array,
                                    $countystate_array
                               )
    );

    $mapargs = array(
        'post_type'     => 'estate_property',
        'post_status'   => 'publish',
        'posts_per_page' => -1,
        'nopaging'      => true,
        'meta_query'    => $meta_query,
        'tax_query'     => array(
                                'relation' => 'AND',
                                $categ_array,
                                $action_array,
                                $city_array,
                                $area_array,
                                $countystate_array
                            )
    );

  
    if( !empty($id_array)){
        $args= array(  'post_type'     => 'estate_property',
                        'p'           =>    $id_array
                );
        $prop_selection =   new WP_Query( $args);
        
    }else{
      
        $custom_fields = get_option( 'wp_estate_custom_fields', true); 
        add_filter( 'posts_orderby', 'wpestate_my_order' );
        $prop_selection =   new WP_Query($args);
        remove_filter( 'posts_orderby', 'wpestate_my_order' );
    }

    $num = $prop_selection->found_posts;
 
    $selected_pins  =   wpestate_listing_pins($mapargs,1);//call the new pins  
   
?>



<div class="row">
    <?php get_template_part('templates/breadcrumbs'); ?>
    <div class=" <?php print $options['content_class'];?> ">
        <?php get_template_part('templates/ajax_container'); ?>
        <?php while (have_posts()) : the_post(); ?>
        <?php if (esc_html( get_post_meta($post->ID, 'page_show_title', true) ) == 'yes') { ?>
              <h1 class="entry-title title_prop"><?php the_title(); print " (".$num.")" ?></h1>                
        <?php } ?>
        <div class="single-content">
            
            <?php the_content();?>
            
            <?php
            $show_save_search            =   get_option('wp_estate_show_save_search','');
    
          
            
           
            if ($show_save_search=='yes' ){
                if( is_user_logged_in() ){
                    print '<div class="search_unit_wrapper advanced_search_notice">';
                    print '<div class="search_param"><strong>'.__('Search Parameters: ','wpestate').'</strong>';
                        wpestate_show_search_params($args,$custom_advanced_search, $adv_search_what,$adv_search_how,$adv_search_label);
                    print'</div>';
                    print'</div>';
                
                
                    print '<div class="saved_search_wrapper"> <span id="save_search_notice">'.__('Save this Search?','wpestate').'</span>'; 
                    print '<input type="text" id="search_name" class="new_search_name" placeholder="'.__('Search name','wpestate').'">';
                    print '<button class="wpb_button  wpb_btn-info wpb_btn-large" id="save_search_button">'.__('Save Search','wpestate').'</button>';
                    print  "<input type='hidden' id='search_args' value=' ";
                    print json_encode($args,JSON_HEX_TAG);
                    print "'>";
                    print '<input type="hidden" name="save_search_nonce" id="save_search_nonce"  value="'. wp_create_nonce( 'save_search_nonce' ).'" />';
                    print '';
                    print '</div>';
                }else{
                    print '<div class="vc_row wpb_row vc_row-fluid vc_row">
                            <div class="vc_col-sm-12 wpb_column vc_column_container vc_column">
                                <div class="wpb_wrapper">
                                    <div class="wpb_alert wpb_content_element vc_alert_rounded wpb_alert-info wpestate_message vc_message">
                                        <div class="messagebox_text"><p>'.__('Login to save search and and you will receive an email notification when new properties matching your search will be published.','wpestate').'</p>
                                    </div>
                                    </div>
                                </div> 
                            </div> 
                    </div>';
                    
                }
                
            }

            
            ?>
        
        </div>
        <?php endwhile; // end of the loop.
        $compare_submit =   get_compare_link();  ?>  
              
        <?php  get_template_part('templates/compare_list'); ?>       
              
        
        <div id="listing_ajax_container"> 
            
            
            
            
        <?php 
       
        if ($prop_selection->have_posts()){    
            while ($prop_selection->have_posts()): $prop_selection->the_post();
                get_template_part('templates/property_unit');
            endwhile;
        }else{   
            print '<div class="bottom_sixty">';
            _e('We didn\'t find any results. Please try again with different search parameters. ','wpestate');
            print '</div>';
        }
        wp_reset_query();
        ?>   
  
        </div>
        <!-- Listings Ends  here --> 
        <?php kriesi_pagination($prop_selection->max_num_pages, $range =2); ?>       
    
    </div><!-- end 9col container-->
    
<?php  include(locate_template('sidebar.php')); ?>
</div>   

<?php 
wp_localize_script('googlecode_regular', 'googlecode_regular_vars2', 
    array(  
        'markers2'           =>  $selected_pins,
    )
);
get_footer(); 

if( !function_exists('wpestate_show_search_params') ):
function wpestate_show_search_params($args,$custom_advanced_search, $adv_search_what,$adv_search_how,$adv_search_label){
    if( isset($args['tax_query'] )){
        foreach($args['tax_query'] as $key=>$query ){

            if ( isset($query['taxonomy']) && isset( $query['terms'][0] ) && $query['taxonomy'] == 'property_category'){
                $page = get_term_by( 'slug',$query['terms'][0] ,'property_category');
                print '<strong>'.__('Category','wpestate').':</strong> '. $page->name .', ';  
            }

            if ( isset($query['taxonomy']) && isset( $query['terms'][0] ) && $query['taxonomy']=='property_action_category' ){
                $page = get_term_by( 'slug',$query['terms'][0] ,'property_action_category');
                print '<strong>'.__('For','wpestate').':</strong> '.$page->name.', ';  
            }

            if ( isset($query['taxonomy']) && isset($query['terms'][0]) && $query['taxonomy']=='property_city'){
                $page = get_term_by( 'slug',$query['terms'][0] ,'property_city');
                print '<strong>'.__('City','wpestate').':</strong> '.$page->name.', ';  
            }

            if ( isset($query['taxonomy']) && isset($query['terms'][0]) && $query['taxonomy']=='property_area'){
                $page = get_term_by( 'slug',$query['terms'][0] ,'property_area');
                print '<strong>'.__('Area','wpestate').':</strong> '.$page->name.', ';  
            }
            if ( isset($query['taxonomy']) && isset($query['terms'][0]) && $query['taxonomy']=='property_county_state'){
                $page = get_term_by( 'slug',$query['terms'][0] ,'property_county_state');
                print '<strong>'.__('County / State','wpestate').':</strong> '.$page->name.', ';  
            }
        }
    }
    
    if( isset($args['meta_query'] )){
    foreach($args['meta_query'] as $key=>$query ){
        $admin_submission_array=array(
                                  'types'             =>__('types','wpestate'),
                                  'categories'        =>__('categories','wpestate'),
                                  'cities'            =>__('cities','wpestate'),
                                  'areas'             =>__('areas','wpestate'),
                                  'property price'    =>__('property price','wpestate'),
                                  'property size'     =>__('property size','wpestate'),
                                  'property lot size' =>__('property lot size','wpestate'),
                                  'property rooms'    =>__('property rooms','wpestate'),
                                  'property bedrooms' =>__('property bedrooms','wpestate'),
                                  'property bathrooms'=>__('property bathrooms','wpestate'),
                                  'property address'  =>__('property address','wpestate'),
                                  'property county'   =>__('property county','wpestate'),
                                  'property state'    =>__('property state','wpestate'),
                                  'property zip'      =>__('property zip','wpestate'),
                                  'property country'  =>__('property country','wpestate'),
                                  'property status'   =>__('property status','wpestate')
                              );
        $label=str_replace('_',' ',$query['key']);
          
        if(array_key_exists ($label, $admin_submission_array)){
           $label=$admin_submission_array[$label];
        }
        if($custom_advanced_search==='yes'){
               
            $custm_name = wpestate_get_custom_field_name($query['key'],$adv_search_what,$adv_search_label);
         
            
            
            if ( isset($query['compare']) ){
                
                if ($query['compare']=='CHAR'){
                    print __('has','wpestate').' <strong>'.str_replace('_',' ',$custm_name).'</strong>, ';       
                }else if ( $query['compare'] == '<=' ){
                    if($query['key']=='property_price'){
                        print $query['value']; 
                    }else{
                        print '<strong>'.$custm_name.'</strong> '.__('smaller than ','wpestate').' '.$query['value'].', '; 
                    }
                          
                }else{
                    if($query['key']=='property_price'){
                        print '<strong>'.__('price range from ','wpestate').'</strong> '.$query['value'].' '.__('to','wpestate').' ';   
                    }else{
                        print '<strong>'.$custm_name.'</strong> '.__('bigger than','wpestate').' '.$query['value'].', ';   

                    }
                }                
            }else{
                print '<strong>'.$custm_name.':</strong> '.$query['value'].', ';
            } //end elese query compare
            
            
        }else{
            if ( isset( $query['compare'] ) ){
                
                if ( $query['compare'] == 'CHAR' ){
                    print __('has','wpestate').' <strong>'.str_replace('_',' ',$query['key']).'</strong>, ';     
                }else if ( $query['compare'] == '<=' ){
                    if($query['key']=='property_price'){
                        print $query['value']; 
                    }else{
                        print '<strong>'.$custm_name.'</strong> '.__('smaller than ','wpestate').' '.$query['value'].', '; 
                    }          
                } else{
                    if($query['key']=='property_price'){
                        print '<strong>'.__('price range from ','wpestate').'</strong> '.$query['value'].' '.__('to','wpestate').' ';   
                    }else{
                        print '<strong>'.$custm_name.'</strong> '.__('bigger than','wpestate').' '.$query['value'].', ';   

                    }          
                }
                
            }else{
                print '<strong>'.$label.':</strong> '.$query['value'].', ';
            } //end elese query compare
       
        }//end else if custom adv search
        
        
       
    }
    }

  
}
endif;
?>