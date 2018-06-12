<?php
add_action( 'wp_ajax_nopriv_wpestate_agency_listings', 'wpestate_agency_listings' );  
add_action( 'wp_ajax_wpestate_agency_listings', 'wpestate_agency_listings' );

if( !function_exists('wpestate_agency_listings') ):
    
    function wpestate_agency_listings(){
   
        global $options;
        global $no_listins_per_row;
        global $custom_unit_structure;
        global $show_remove_fav;
        global $prop_unit_class;
        global $prop_unit;
        global $currency;
        global $where_currency;
        $currency                   =   esc_html( get_option('wp_estate_currency_symbol', '') );
        $where_currency             =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
        global $property_unit_slider;
        $property_unit_slider       =   get_option('wp_estate_prop_list_slider','');
        $prop_unit                  =   esc_html ( get_option('wp_estate_prop_unit','') );
        $prop_unit_class            =   '';
        if($prop_unit=='list'){
            $prop_unit_class="ajax12";
            $align_class=   'the_list_view';
        }



        $show_remove_fav=0;
        wp_suspend_cache_addition(false);
        $wpestate_uset_unit         =   intval ( get_option('wpestate_uset_unit','') );
        $no_listins_per_row         =   intval( get_option('wp_estate_listings_per_row', '') );
        $custom_unit_structure      =   get_option('wpestate_property_unit_structure');
        $property_card_type         =   intval(get_option('wp_estate_unit_card_type'));
        $property_card_type_string  =   '';
        $prop_no    =   intval( get_option('wp_estate_prop_no', '') );
      
        if($property_card_type==0){
            $property_card_type_string='';
        }else{
            $property_card_type_string='_type'.$property_card_type;
        }
        
        $user_agency    =   intval($_POST['agency_id']);
        $options        =   wpestate_page_details($user_agency);
     
        $agent_list     =   (array)get_user_meta($user_agency,'current_agent_list',true);
        $agent_list[]   =   $user_agency;


        $term_name=esc_html($_POST['term_name']);
    
        
        
        $is_agency = intval($_POST['is_agency']);
		$post_id = intval($_POST['post_id']);
        
        
        if( $is_agency ==1 ){
            $action_array=array(
                'taxonomy'     => 'property_action_category',
                'field'        => 'slug',
                'terms'        => $term_name
            );
        }else{
            $action_array=array(
                'taxonomy'     => 'property_category',
                'field'        => 'slug',
                'terms'        => $term_name
            );
        }

        
        if( count( $agent_list ) == 0 ){
	
            $args = array(
                'post_type'         =>  'estate_property',
                'paged'             =>  $paged,
                'posts_per_page'    =>  $prop_no,
                'post_status'       =>  'publish',
                'meta_key'          =>  'prop_featured',
                'orderby'           =>  'meta_value',
                'order'             =>  'DESC',
                'tax_query'         =>  array(
                                            'relation' => 'AND',
                                            $action_array,
                                        ),
                'meta_query' => array(
                                        array(
                                            'key'     => 'property_agent',
                                            'value'   => $post_id,
                                        ),
                                    ),
            );
        
        }else{
            $args = array(
                'post_type'         =>  'estate_property',
                'author__in'        =>  $agent_list,
                'paged'             =>  $paged,
                'posts_per_page'    =>  $prop_no,
                'post_status'       => 'publish',
                'meta_key'          => 'prop_featured',
                'orderby'           => 'meta_value',
                'order'             => 'DESC',
                'tax_query'         => array(
                                            'relation' => 'AND',
                                            $action_array,
                                        )
                );
            }
        
        if($term_name=='all'){
            unset($args['tax_query']);
        }
        
        
		
        if( (int)$_POST['loaded'] ){
                $args['offset'] = (int)$_POST['loaded'];
        }
		
        $options['content_class']='col-md-12';
        $options['sidebar_class']='x';
      
	  
	  
        add_filter( 'posts_orderby', 'wpestate_my_order' );
        $prop_selection = new WP_Query($args);
        remove_filter( 'posts_orderby', 'wpestate_my_order' );
        
        
        if( $prop_selection->have_posts() ){
               
            while ($prop_selection->have_posts()): $prop_selection->the_post(); 
                get_template_part('templates/property_unit'.$property_card_type_string);
            endwhile;
           
        }else{
            print '<span class="no_results">'. __("We didn't find any results","wpestate").'</>';
        }

        die();
    }
endif;

// agent page property listing call
add_action( 'wp_ajax_nopriv_wpestate_agent_listings', 'wpestate_agent_listings' );  
add_action( 'wp_ajax_wpestate_agent_listings', 'wpestate_agent_listings' );

if( !function_exists('wpestate_agent_listings') ):
    
    function wpestate_agent_listings(){
   
        global $options;
        global $no_listins_per_row;
        global $custom_unit_structure;
        global $show_remove_fav;
        global $prop_unit_class;
        global $prop_unit;
        global $property_unit_slider;
        global $custom_post_type;
        global $col_class;
        global $custom_unit_structure;
        global $no_listins_per_row;
        global $wpestate_uset_unit;
        global $included_ids;
        global $currency;
        global $where_currency;
  
        $currency                   =   esc_html( get_option('wp_estate_currency_symbol', '') );
        $where_currency             =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
        $term_name=esc_html($_POST['term_name']);
        $agent_id = esc_html($_POST['agent_id']);
        $post_id = esc_html($_POST['post_id']);
        
        
        $show_compare               =   1;
        $align_class                =   '';
        $prop_unit                  =   esc_html ( get_option('wp_estate_prop_unit','') );
        $prop_unit_class            =   '';
        if($prop_unit=='list'){
            $prop_unit_class="ajax12";
            $align_class=   'the_list_view';
        }
     
        $currency                   =   esc_html( get_option('wp_estate_currency_symbol', '') );
        $where_currency             =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
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
        
        $page_id        =   get_user_meta($agent_id,'user_agent_id',true);
        $options        =   wpestate_page_details($page_id);
  
    
        $show_remove_fav=0;
        wp_suspend_cache_addition(false);
        $wpestate_uset_unit         =   intval ( get_option('wpestate_uset_unit','') );
        $no_listins_per_row         =   intval( get_option('wp_estate_listings_per_row', '') );
	$custom_unit_structure      =   get_option('wpestate_property_unit_structure');	
		
		
        $custom_unit_structure      =   get_option('wpestate_property_unit_structure');
        $property_card_type         =   intval(get_option('wp_estate_unit_card_type'));
        $property_card_type_string  =   '';
        $prop_no    =   intval( get_option('wp_estate_prop_no', '') );
      
        if($property_card_type==0){
            $property_card_type_string='';
        }else{
            $property_card_type_string='_type'.$property_card_type;
        }
  
        $currency                   =   esc_html( get_option('wp_estate_currency_symbol', '') );
        $where_currency             =   esc_html( get_option('wp_estate_where_currency_symbol', '') );

    
     
    
    
    
        $action_array=array(
			'taxonomy'     => 'property_category',
			'field'        => 'slug',
                        'terms'        => $term_name
        );
  

		if( $agent_id == '-1' ){
			$args = array(
				'post_type'         =>  'estate_property',
				 
				'paged'             =>  $paged,
				'posts_per_page'    =>  $prop_no,
				'post_status'       => 'publish',
				'meta_key'          => 'prop_featured',
				'orderby'           => 'meta_value',
				'order'             => 'DESC',
				'tax_query'         =>  array(
                                                            'relation' => 'AND',
                                                            $action_array,
                                                            ),
				'meta_query'        =>  array(
                                                            array(
                                                                    'key'     => 'property_agent',
                                                                    'value'   => $post_id,
                                                            ),
                                                        ),
				);
		}else{
			$args = array(
				'post_type'         =>  'estate_property',
				'author'            =>  $agent_id,
				'paged'             =>  $paged,
				'posts_per_page'    =>  $prop_no,
				'post_status'       =>  'publish',
				'meta_key'          =>  'prop_featured',
				'orderby'           =>  'meta_value',
				'order'             =>  'DESC',
				'tax_query'         =>  array(
                                                            'relation' => 'AND',
                                                            $action_array,
                                                        )
				);
		}
        
  
        if( (int)$_POST['loaded'] ){
            $args['offset'] = (int)$_POST['loaded'];
        }

        if($term_name=='all'){
            unset($args['tax_query']);
        }
        
        
        
       
        add_filter( 'posts_orderby', 'wpestate_my_order' );
        $prop_selection = new WP_Query($args);
        remove_filter( 'posts_orderby', 'wpestate_my_order' );
        
       
	 
        if( $prop_selection->have_posts() ){
               
            while ($prop_selection->have_posts()): $prop_selection->the_post(); 
                get_template_part('templates/property_unit'.$property_card_type_string);
            endwhile;
 		
        }else{
            print '<span class="no_results">'. __("We didn't find any results","wpestate").'</>';
        }

        die();
    }
endif;





add_action( 'wp_ajax_nopriv_wpestate_classic_ondemand_directory', 'wpestate_classic_ondemand_directory' );  
add_action( 'wp_ajax_wpestate_classic_ondemand_directory', 'wpestate_classic_ondemand_directory' );

if( !function_exists('wpestate_classic_ondemand_directory') ):
    
    function wpestate_classic_ondemand_directory(){
        global $options;
        global $no_listins_per_row;
        global $custom_unit_structure;
        global $prop_unit_class;
        global $prop_unit;
        global $currency;
        global $where_currency;
         global $property_unit_slider ;
         $property_unit_slider       =   get_option('wp_estate_prop_list_slider','');
        
        $currency                   =   esc_html( get_option('wp_estate_currency_symbol', '') );
        $where_currency             =   esc_html( get_option('wp_estate_where_currency_symbol', '') );


        $prop_unit                  =   esc_html ( get_option('wp_estate_prop_unit','') );
        $prop_unit_class            =   '';
        if($prop_unit=='list'){
            $prop_unit_class="ajax12";
            $align_class=   'the_list_view';
        }


        wp_suspend_cache_addition(false);
        $wpestate_uset_unit         =   intval ( get_option('wpestate_uset_unit','') );
        $no_listins_per_row         =   intval( get_option('wp_estate_listings_per_row', '') );
        $custom_unit_structure      =   get_option('wpestate_property_unit_structure');
        $property_card_type         =   intval(get_option('wp_estate_unit_card_type'));
        $property_card_type_string  =   '';
       
        if($property_card_type==0){
            $property_card_type_string='';
        }else{
            $property_card_type_string='_type'.$property_card_type;
        }

    
        $type_name      =   'category_values';
        $type_name_value=   wp_kses( $_REQUEST[$type_name] ,$allowed_html );
        $action_name    =   'action_values';
        $action_name_value  = wp_kses( $_REQUEST[$action_name] ,$allowed_html );
    

        if ( $type_name_value!='all' && $type_name_value!='' ){
            $taxcateg_include   =   array();     
            $taxcateg_include   =   sanitize_title ( wp_kses( $type_name_value ,$allowed_html ) );

            $categ_array=array(
                'taxonomy'     => 'property_category',
                'field'        => 'slug',
                'terms'        => $taxcateg_include
            );
        }

        if ( $action_name_value !='all' && $action_name_value !='') {
            $taxaction_include   =   array();   
            $taxaction_include   =   sanitize_title ( wp_kses( $action_name_value ,$allowed_html) );   

            $action_array=array(
                 'taxonomy'     => 'property_action_category',
                 'field'        => 'slug',
                 'terms'        => $taxaction_include
            );
         }

        if (isset($_REQUEST['city']) and $_REQUEST['city'] != 'all' && $_REQUEST['city'] != '') {
            $taxcity[] = sanitize_title ( wp_kses ( $_REQUEST['city'],$allowed_html ) );
            $city_array = array(
                'taxonomy'     => 'property_city',
                'field'        => 'slug',
                'terms'        => $taxcity
             );
         }


        if (isset($_REQUEST['area']) and $_REQUEST['area'] != 'all' && $_REQUEST['area'] != '') {
            $taxarea[] = sanitize_title ( wp_kses ($_REQUEST['area'],$allowed_html) );
            $area_array = array(
                'taxonomy'     => 'property_area',
                'field'        => 'slug',
                'terms'        => $taxarea
            );
        }

        
        
        
        if (isset($_REQUEST['county']) and $_REQUEST['county'] != 'all' && $_REQUEST['county'] != '') {
            $taxarea[] = sanitize_title ( wp_kses ($_REQUEST['county'],$allowed_html) );
            $county_array = array(
                'taxonomy'     => 'property_county_state',
                'field'        => 'slug',
                'terms'        => $taxarea
            );
        }
        
         
        $pagination = intval($_POST['pagination']);
         
        $price_low='';
        if( isset($_POST['price_low'])){
            $price_low = floatval( $_POST['price_low'] );
        }
        
        $price_max='';
        if( isset($_POST['price_max'])){
            $price_max = floatval( $_POST['price_max'] );
        }
        
        $min_size='';
        if( isset($_POST['min_size'])){
            $min_size =wpestate_convert_measure( floatval( $_POST['min_size'] ));
        }
        
        $max_size='';
        if( isset($_POST['max_size'])){
            $min_size = wpestate_convert_measure(floatval( $_POST['max_size']) );
        }
        
        $min_lot_size='';
        if( isset($_POST['min_lot_size'])){
            $min_lot_size= wpestate_convert_measure(floatval( $_POST['min_lot_size']) );
        }
        
        $max_lot_size='';
        if( isset($_POST['max_lot_size'])){
            $min_lot_size= wpestate_convert_measure(floatval( $_POST['max_lot_size'] ));
        }
        
        $min_rooms='';
        if( isset($_POST['min_rooms'])){
            $min_rooms= floatval( $_POST['min_rooms'] );
        }
        
        $max_rooms='';
        if( isset($_POST['max_rooms'])){
            $max_rooms= floatval( $_POST['max_rooms'] );
        }
        
        $min_bedrooms='';
        if( isset($_POST['min_bedrooms'])){
            $min_bedrooms= floatval( $_POST['min_bedrooms'] );
        }
        
        $max_bedrooms='';
        if( isset($_POST['max_bedrooms'])){
            $max_bedrooms= floatval( $_POST['max_bedrooms'] );
        }
        
        $min_bathrooms='';
        if( isset($_POST['min_bathrooms'])){
            $min_bathrooms= floatval( $_POST['min_bathrooms'] );
        }
        
        $max_bathrooms='';
        if( isset($_POST['max_bathrooms'])){
            $max_bathrooms= floatval( $_POST['max_bathrooms'] );
        }
        
        $status='';
        if( isset($_POST['status'])){
            $status = esc_html( $_POST['status'] );
            $status= html_entity_decode($status,ENT_QUOTES);
            //$status = stripslashes($status);
            
        }
        
        
        
        
        $keyword='';
        if( isset($_POST['keyword'])){
            $keyword = esc_html( $_POST['keyword'] );
        }
        
        $meta_order         =   'prop_featured';
        $meta_directions    =   'DESC';   
        $order_by           =   'meta_value';
    
        if(isset($_POST['order'])) {
            $order=  wp_kses( $_POST['order'],$allowed_html );
            switch ($order){
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
                    $meta_order='property_bedrooms';
                    $meta_directions='ASC';
                    $order_by='meta_value_num';
                    break;
            }
        }

        $price_max          =   '';
        $custom_fields      =   get_option( 'wp_estate_multi_curr', true);
        $price_low          =   floatval($_REQUEST['price_low']);
        
        if( isset($_REQUEST['price_max'])  && $_REQUEST['price_max'] && floatval($_REQUEST['price_max'])>0 ){
            $price_max          = floatval($_REQUEST['price_max']);
            
            if( !empty($custom_fields) && isset($_COOKIE['my_custom_curr']) &&  isset($_COOKIE['my_custom_curr_pos']) &&  isset($_COOKIE['my_custom_curr_symbol']) && $_COOKIE['my_custom_curr_pos']!=-1){
                $i=intval($_COOKIE['my_custom_curr_pos']);
                $price_max       =   $price_max / $custom_fields[$i][2];
                $price_low       =   $price_low / $custom_fields[$i][2];
            }
            
            
            $price['key']       = 'property_price';
            $price['value']     = array($price_low, $price_max);
            $price['type']      = 'numeric';
            $price['compare']   = 'BETWEEN';
            $meta_query[]       = $price;
        }
        
        
        $max_size               =   wpestate_convert_measure ( floatval($_REQUEST['max_size']),1 );
        $min_size               =   wpestate_convert_measure ( floatval($_REQUEST['min_size']),1 );
        $size_array             =   array(); 
        $size_array['key']      =   'property_size';
        $size_array['value']    =   array($min_size, $max_size);
        $size_array['type']     =   'numeric';
        $size_array['compare']  =   'BETWEEN';
        $meta_query[]           =   $size_array;
       
        
        $max_lot_size               =   wpestate_convert_measure ( floatval($_REQUEST['max_lot_size']),1);
        $min_lot_size               =   wpestate_convert_measure ( floatval($_REQUEST['min_lot_size']),1);
        $lotsize_array              =   array(); 
        $lotsize_array['key']       =   'property_lot_size';
        $lotsize_array['value']     =   array($min_lot_size, $max_lot_size);
        $lotsize_array['type']      =   'numeric';
        $lotsize_array['compare']   =   'BETWEEN';
        $meta_query[]               =   $lotsize_array;
        
        
        $max_rooms                  =   floatval($_REQUEST['max_rooms']);
        $min_rooms                  =   floatval($_REQUEST['min_rooms']);
        $rooms_array                =   array(); 
        $rooms_array['key']         =   'property_rooms';
        $rooms_array['value']       =   array($min_rooms, $max_rooms);
        $rooms_array['type']        =   'numeric';
        $rooms_array['compare']     =   'BETWEEN';
        $meta_query[]               =   $rooms_array;
        
        
         
        $max_bedrooms                  =   floatval($_REQUEST['max_bedrooms']);
        $min_bedrooms                  =   floatval($_REQUEST['min_bedrooms']);
        $bedrooms_array                =   array(); 
        $bedrooms_array['key']         =   'property_bedrooms';
        $bedrooms_array['value']       =   array($min_bedrooms, $max_bedrooms);
        $bedrooms_array['type']        =   'numeric';
        $bedrooms_array['compare']     =   'BETWEEN';
        $meta_query[]                  =   $bedrooms_array;
        
        
        $max_bathrooms                 =   floatval($_REQUEST['max_bathrooms']);
        $min_bathrooms                 =   floatval($_REQUEST['min_bathrooms']);
        $bedrooms_array                =   array(); 
        $bedrooms_array['key']         =   'property_bathrooms';
        $bedrooms_array['value']       =   array($min_bathrooms, $max_bathrooms);
        $bedrooms_array['type']        =   'numeric';
        $bedrooms_array['compare']     =   'BETWEEN';
        $meta_query[]                  =   $bedrooms_array;
        
        
        
        
        if($status!='normal'){
            $status_array               =   array(); 
            $status_array['key']        =  'property_status';
            $status_array['value']      =   $status;
            $status_array['compare']    =   'LIKE';
            $meta_query[]               =   $status_array;
        }
        
        
        $prop_no    =   intval( get_option('wp_estate_prop_no', '') );

        $args = array(
            'cache_results'             =>  false,
            'update_post_meta_cache'    =>  false,
            'update_post_term_cache'    =>  false,

            'post_type'       => 'estate_property',
            'post_status'     => 'publish',
            'paged'           => $pagination,
            'posts_per_page'  => $prop_no,
            'meta_key'        => $meta_order,
            'orderby'         => $order_by,
            'order'           => $meta_directions,
           //'meta_query'      => $meta_query,
            'tax_query'       => array(
                                    'relation' => 'AND',
                                    $categ_array,
                                    $action_array,
                                    $city_array,
                                    $area_array,
                                    $county_array,

                                )
        );      
        
      
        $features             = array();
        $features = wpestate_add_feature_to_search_ajax();
        $metas = wpestate_convert_meta_to_postin($meta_query);


        if( !empty($features) ){
            if( !empty($metas)){
                $all_ids = array_intersect($metas,$features);
            }else{
                $all_ids=$features;
            }
        }else{
            $all_ids=$metas;
        }
        

        
        
        if(empty($all_ids)){
            $all_ids[]=0;
        }
        
      
        $args['post__in']=$all_ids;
       
        
        global $keyword;
        $keyword=esc_html ( $_POST['keyword']);
        
        if( !empty($keyword)  ){
          add_filter( 'posts_where', 'wpestate_title_filter', 10, 2 );
        }
        $prop_selection= new Wp_Query($args);

        
        ob_start();
        if( $prop_selection->have_posts() ){
            if($pagination==1){
                print '<h1 style="margin-left: 15px;" class="entry-title title_prop half_results">'.$prop_selection->found_posts.' '.__('listings','wpestate').'</h1>';   
            }
            while ($prop_selection->have_posts()): $prop_selection->the_post(); 
                get_template_part('templates/property_unit'.$property_card_type_string);
            endwhile;
         
        }else{
            print '<span class="no_results">'. __("We didn't find any results","wpestate").'</>';
        }

        $cards= ob_get_contents();
        ob_end_clean();
      

        if( !empty($keyword) ){
            remove_filter( 'posts_where', 'wpestate_title_filter', 10, 2 );
        }
         
        
        
        
        
        
        
        echo json_encode( array(    
                            'meta'=>$meta_query,
                            'args'      =>  $args, 
                            'cards'   =>  $cards,
                            'no_results'=>  $prop_selection->found_posts,
                        ));
       wp_suspend_cache_addition(false);     
       die();
  }
  
 endif; // end   ajax_filter_listings 
 
 
 
function wpestate_show_license_form(){
    
    $theme_activated    =   get_option('is_theme_activated','');
    $ajax_nonce         =   wp_create_nonce( "my-check_ajax_license-string" );
    
    
    $return =1;
    
    
    if($theme_activated!='is_active'){
        
        $theme_active_time = get_option('activation_time','');
        if($theme_active_time==''){
            update_option('activation_time',time());
        }
        
        print '<div class="license_check_wrapper">';
            echo' <div class="activate_notice notice_here">'.__('Please activate the theme in the next 24h to validate the purchase and continue to have access to all theme options! See this <a href="http://help.wpresidence.net/article/how-to-get-your-buyer-license-code/" target="_blank">link</a> if you don\'t know how to get your license key. Thank you!','wpestate').'</div>';
            print '<div class="license_form">
                <input type="text" id="wpestate_license_key" name="wpestate_license_key">
                <input type="submit" name="submit" id="check_ajax_license" class="new_admin_submit" value="Check License">
                <input type="hidden" id="license_ajax_nonce" name="license_ajax_nonce" value="'.$ajax_nonce.'">
            </div>';
            
            if( $theme_active_time +24*60*60 < time() ){
                print '<div class="activate_notice"> You cannot use the theme options until you activate the theme. </div>';
               // exit();
               $return=0;
            
            }
        print '</div>';

    }
    return $return;
          
}

                         

function wpestate_secondary_lic(){
 
    $theme_activated    =   get_option('is_theme_activated','');
    if($theme_activated!='is_active'){
        
        $theme_active_time = get_option('activation_time','');
        if($theme_active_time==''){
            update_option('activation_time',time());
        }
    
        if( $theme_active_time +24*60*60 < time() ){
            exit();            
        }
        
    }
}



add_action( 'wp_ajax_wpestate_check_license_function', 'wpestate_check_license_function' );

if( !function_exists('wpestate_check_license_function') ):
    function wpestate_check_license_function(){
        if( !current_user_can('administrator') ){
            exit('out pls');
        }
        
        $wpestate_license_key = esc_html($_POST['wpestate_license_key']); 
        check_ajax_referer( 'my-check_ajax_license-string',  'security' );
        
   
        $ch = curl_init();
        $data= array('license'=>$wpestate_license_key);

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, "http://support.wpestate.org/theme_license_check.php");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        
        
        $agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)';
        curl_setopt($ch, CURLOPT_USERAGENT, $agent);

        $output = curl_exec($ch);
       
        curl_close($ch);
        
        if($output==='ok'){
            update_option('is_theme_activated','is_active');
            print 'ok';
        }else{
            print 'nook';
        }
  

        die();

    }
endif;






add_action( 'wp_ajax_nopriv_wpestate_load_recent_items_sh', 'wpestate_load_recent_items_sh' );  
add_action( 'wp_ajax_wpestate_load_recent_items_sh', 'wpestate_load_recent_items_sh' );

if( !function_exists('wpestate_load_recent_items_sh') ):
    function wpestate_load_recent_items_sh(){
        
        $type                   =   sanitize_text_field($_POST['type']);
        $category_ids           =   sanitize_text_field($_POST['category_ids']);
        $action_ids             =   sanitize_text_field($_POST['action_ids']);
        $city_ids               =   sanitize_text_field($_POST['city_ids']);
        $area_ids               =   sanitize_text_field($_POST['area_ids']);
        $state_ids              =   sanitize_text_field($_POST['state_ids']);
        $number                 =   sanitize_text_field($_POST['number']);
        $align                  =   sanitize_text_field($_POST['align']);
        $show_featured_only     =   sanitize_text_field($_POST['show_featured_only']);
        $random_pick            =   sanitize_text_field($_POST['random_pick']);
        $featured_first         =   sanitize_text_field($_POST['featured_first']);
        $page                   =   intval($_POST['page']);
        $row_number             =   intval($_POST['row_number']);
//        echo '/'.$type.'/'.$category_ids.'/'.$action_ids.'/'.$city_ids.'/'.$area_ids.'/'.$state_ids;
     //   echo '/'.$number.'/'.$align.'/'.$show_featured_only.'/'.$random_pick.'/'.$featured_first.'/'.$page;
//        
        echo wpestate_display_listings_sh($page,$type ,$category_ids,$action_ids, $city_ids, $area_ids, $state_ids, $number, $align, $show_featured_only, $random_pick, $featured_first,$row_number);
  
        die();
    
    }
endif;



function wpestate_display_listings_sh($page,$type ,$category_ids,$action_ids, $city_ids, $area_ids, $state_ids, $number, $align_received, $show_featured_only, $random_pick, $featured_first,$row_number){
    $orderby='';
    global $options;
    global $align;
    global $align_class;
    global $post;
    global $currency;
    global $where_currency;
    global $is_shortcode;
    global $show_compare_only;
    global $row_number_col;    
    global $current_user;
    global $curent_fav;
    global $property_unit_slider;
    global $no_listins_per_row;
    global $wpestate_uset_unit;
    global $custom_unit_structure;
    $is_shortcode       =   1;
    $currency                   =   esc_html( get_option('wp_estate_currency_symbol', '') );
    $where_currency             =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
    $custom_unit_structure    =   get_option('wpestate_property_unit_structure');
    $wpestate_uset_unit       =   intval ( get_option('wpestate_uset_unit','') );
    $no_listins_per_row       =   intval( get_option('wp_estate_listings_per_row', '') );
    $userID             =   $current_user->ID;
    $user_option        =   'favorites'.$userID;
    $curent_fav         =   get_option($user_option);
    $property_unit_slider = get_option('wp_estate_prop_list_slider','');
    
    $property_card_type         =   intval(get_option('wp_estate_unit_card_type'));
    $property_card_type_string  =   '';
    if($property_card_type==0){
        $property_card_type_string='';
    }else{
        $property_card_type_string='_type'.$property_card_type;
    }
      
    
    if( $row_number == 4 ){
        $row_number_col = 3; // col value is 3 
    }else if( $row_number==3 ){
        $row_number_col = 4; // col value is 4
    }else if ( $row_number==2 ) {
        $row_number_col =  6;// col value is 6
    }else if ($row_number==1) {
        $row_number_col =  12;// col value is 12
        if($align_received=='vertical'){
             $row_number_col =  0;
        }
    }
    

    $align_class='';
    if($align_received =='horizontal'){
        $align="col-md-12";
      
        $align_class='the_list_view';
        $row_number_col='12';
    }
    

    
    if($random_pick==='yes'){
        $orderby    =   'rand';
    }
    
  
    if ($type == 'estate_property') {
        $type = 'estate_property';
        
        $category_array =   '';
        $action_array   =   '';
        $city_array     =   '';
        $area_array     =   '';
        $state_array    =   '';
        
        // build category array
        if($category_ids!=''){
            $category_of_tax=array();
            $category_of_tax=  explode(',', $category_ids);
            $category_array=array(     
                            'taxonomy'  => 'property_category',
                            'field'     => 'term_id',
                            'terms'     => $category_of_tax
                            );
        }
            
        
        // build action array
        if($action_ids!=''){
            $action_of_tax=array();
            $action_of_tax=  explode(',', $action_ids);
            $action_array=array(     
                            'taxonomy'  => 'property_action_category',
                            'field'     => 'term_id',
                            'terms'     => $action_of_tax
                            );
        }
        
        // build city array
        if($city_ids!=''){
            $city_of_tax=array();
            $city_of_tax=  explode(',', $city_ids);
            $city_array=array(     
                            'taxonomy'  => 'property_city',
                            'field'     => 'term_id',
                            'terms'     => $city_of_tax
                            );
        }
        
        // build city array
        if($area_ids!=''){
            $area_of_tax=array();
            $area_of_tax=  explode(',', $area_ids);
            $area_array=array(     
                            'taxonomy'  => 'property_area',
                            'field'     => 'term_id',
                            'terms'     => $area_of_tax
                            );
        }
        
        if($state_ids!=''){
            $state_of_tax   =   array();
            $state_of_tax   =   explode(',', $state_ids);
            $state_array    =   array(     
                                'taxonomy'  => 'property_county_state',
                                'field'     => 'term_id',
                                'terms'     => $state_of_tax
                            );
        }
           
        
        
        $meta_query=array();                
        if($show_featured_only=='yes'){
            $compare_array=array();
            $compare_array['key']        = 'prop_featured';
            $compare_array['value']      = 1;
            $compare_array['type']       = 'numeric';
            $compare_array['compare']    = '=';
            $meta_query[]                = $compare_array;
        }

        if($featured_first=="no"){
            $orderby='ID';
        }
            
        $args = array(
            'post_type'         => $type,
            'post_status'       => 'publish',
            'paged'             => $page,
            'posts_per_page'    => $number,
            'meta_key'          => 'prop_featured',
            'orderby'           => $orderby,
            'order'             => 'DESC',
            'meta_query'        => $meta_query,
            'tax_query'         => array( 
                                    $category_array,
                                    $action_array,
                                    $city_array,
                                    $area_array,
                                    $state_array
                                )

        );
        
          
    } else {
        $type = 'post';
  
       
        
        $args = array(
            'post_type'      => $type,
            'post_status'    => 'publish',
            'paged'          => $page,
            'posts_per_page' => $number,
            'orderby'        => $orderby,
           // 'cat'            => $category_ids
        );
   
    }
    
    
     if ($type == 'estate_property') {
        if($random_pick !=='yes'){
            if($featured_first=='yes'){
                add_filter( 'posts_orderby', 'wpestate_my_order' ); 
            }
            
            $recent_posts = new WP_Query($args);
            $count = 1;
            if($featured_first=='yes'){
                remove_filter( 'posts_orderby', 'wpestate_my_order' ); 
            }
        }else{
           
            $args['orderby']    =   'rand';
            $recent_posts = new WP_Query($args); 
            $count = 1;
        }
   
    }else{
        $recent_posts = new WP_Query($args);
        $count = 1;
    }
    

    ob_start();  
    $return_string='';
    while ($recent_posts->have_posts()): $recent_posts->the_post();
        if($type == 'estate_property'){
            get_template_part('templates/property_unit'.$property_card_type_string);
        } else {
         
			if( $align_received && $align_received == 'horizontal' ){
				get_template_part('templates/blog_unit');
            }else{
				get_template_part('templates/blog_unit2');
            }
            
        }
    endwhile;

    $templates = ob_get_contents();
    ob_end_clean(); 
       wp_reset_query();
    $return_string .=$templates;
      
     $is_shortcode       =   0;
    return $return_string;
    
}



////////////////////////////////////////////////////////////////////////////////
// on demand pins - 

add_action( 'wp_ajax_nopriv_wpestate_custom_ondemand_pin_load', 'wpestate_custom_ondemand_pin_load' );  
add_action( 'wp_ajax_wpestate_custom_ondemand_pin_load', 'wpestate_custom_ondemand_pin_load' );

if( !function_exists('wpestate_custom_ondemand_pin_load') ):
    
    function wpestate_custom_ondemand_pin_load(){
        wp_suspend_cache_addition(false);
        global $keyword;
        $args =  wpestate_search_results_custom ('ajax');
        
        $adv_search_what    =   get_option('wp_estate_adv_search_what','');
        $adv_search_label   =   get_option('wp_estate_adv_search_label','');   
        $return_custom      =   wpestate_search_with_keyword_ajax($adv_search_what, $adv_search_label);
        
        if( isset( $return_custom['id_array']) ){
            $id_array       =   $return_custom['id_array']; 
            if($id_array!=0){
                $args=  array(  'post_type'     =>    'estate_property',
                            'p'             =>    $id_array
                );
            }
        }
        
        if(isset($return_custom['keyword'])){
            $keyword        =   $return_custom['keyword'];
        }
        if( isset($_POST['keyword_search']) && trim($_POST['keyword_search'])!='' ){
            $allowed_html       =   array();
            $keyword            =   esc_attr(  wp_kses ( $_POST['keyword_search'], $allowed_html));
       
        }
        //kraka
        $args['page']=1;
        $args['posts_per_page']=intval( get_option('wp_estate_map_max_pins') );
        
        
       
        
        $on_demand_results = wpestate_listing_pins_on_demand($args,0);
      
         
        echo json_encode( array(  
                            'xxx'       =>  $return_custom,
                            'args'      =>  $args, 
                            'markers'   =>  $on_demand_results['markers'],
                            'no_results'=>  $on_demand_results['results'] 
                        ));
       wp_suspend_cache_addition(false);     
       die();
  }
  
 endif; // end   ajax_filter_listings 
 

 
  
add_action( 'wp_ajax_nopriv_wpestate_classic_ondemand_pin_load_type2_tabs', 'wpestate_classic_ondemand_pin_load_type2_tabs' );  
add_action( 'wp_ajax_wpestate_classic_ondemand_pin_load_type2_tabs', 'wpestate_classic_ondemand_pin_load_type2_tabs' );

if( !function_exists('wpestate_classic_ondemand_pin_load_type2_tabs') ):
    
    function wpestate_classic_ondemand_pin_load_type2_tabs(){
        wp_suspend_cache_addition(false);
   
        $args =  wpestated_advanced_search_tip2_ajax_tabs ();
        //krakau
        $args['page']=1;
        $args['posts_per_page']=intval( get_option('wp_estate_map_max_pins') );
        $on_demand_results = wpestate_listing_pins_on_demand($args);
      
         
        echo json_encode( array(    
                            'args'      =>  $args, 
                            'markers'   =>  $on_demand_results['markers'],
                            'no_results'=>  $on_demand_results['results'] 
                        ));
       wp_suspend_cache_addition(false);     
       die();
  }
  
 endif; // end   ajax_filter_listings 
 
add_action( 'wp_ajax_nopriv_wpestate_classic_ondemand_pin_load_type2', 'wpestate_classic_ondemand_pin_load_type2' );  
add_action( 'wp_ajax_wpestate_classic_ondemand_pin_load_type2', 'wpestate_classic_ondemand_pin_load_type2' );

if( !function_exists('wpestate_classic_ondemand_pin_load_type2') ):
    
    function wpestate_classic_ondemand_pin_load_type2(){
        wp_suspend_cache_addition(false);
        
        $args =  wpestated_advanced_search_tip2_ajax ();
        
        //krakau
        $args['page']=1;
        $args['posts_per_page']=intval( get_option('wp_estate_map_max_pins') );
        $on_demand_results = wpestate_listing_pins_on_demand($args);
        
         
        echo json_encode( array(    
                            'args'      =>  $args, 
                            'markers'   =>  $on_demand_results['markers'],
                            'no_results'=>  $on_demand_results['results'] 
                        ));
       wp_suspend_cache_addition(false);     
       die();
  }
  
 endif; // end   ajax_filter_listings 
 
 
 
////////////////////////////////////////////////////////////////////////////////
// on demand pins - 

add_action( 'wp_ajax_nopriv_wpestate_classic_ondemand_pin_load', 'wpestate_classic_ondemand_pin_load' );  
add_action( 'wp_ajax_wpestate_classic_ondemand_pin_load', 'wpestate_classic_ondemand_pin_load' );

if( !function_exists('wpestate_classic_ondemand_pin_load') ):
    
    function wpestate_classic_ondemand_pin_load(){
        wp_suspend_cache_addition(false);
        
        $args =  wpestate_search_results_default ('ajax');
        
         //krakau
        $args['page']=1;
        $args['posts_per_page']=intval( get_option('wp_estate_map_max_pins') );
//        if( empty($args['post__in']) ){
//            $args['post__in'][]=1;
//        }
        $on_demand_results = wpestate_listing_pins_on_demand($args);
        
         
        echo json_encode( array(    
                            'args'      =>  $args, 
                            'markers'   =>  $on_demand_results['markers'],
                            'no_results'=>  $on_demand_results['results'] 
                        ));
       wp_suspend_cache_addition(false);     
       die();
  }
  
 endif; // end   ajax_filter_listings 
 





////////////////////////////////////////////////////////////////////////////////
/// Ajax  Filters
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_wpestate_ajax_filter_listings_search', 'wpestate_ajax_filter_listings_search' );  
add_action( 'wp_ajax_wpestate_ajax_filter_listings_search', 'wpestate_ajax_filter_listings_search' );

if( !function_exists('wpestate_ajax_filter_listings_search') ):
    
    function wpestate_ajax_filter_listings_search(){
        wp_suspend_cache_addition(false);
        global $post;
        global $options;
        global $show_compare_only;
        global $currency;
        global $where_currency;
        global $property_unit_slider;
        global $is_col_md_12;
        global $prop_unit;
        global $no_listins_per_row;
        global $wpestate_uset_unit;
        global $custom_unit_structure;
        
        $custom_unit_structure      =   get_option('wpestate_property_unit_structure');
        $wpestate_uset_unit         =   intval ( get_option('wpestate_uset_unit','') );
        $prop_unit                  =   esc_html ( get_option('wp_estate_prop_unit','') );
        $show_compare_only          =   'yes';
        if( get_option( 'page_on_front') == intval ( $_POST['postid']) ){
            $show_compare_only  =   'no'; 
        }  
        
        $property_card_type         =   intval(get_option('wp_estate_unit_card_type'));
        $property_card_type_string  =   '';
        if($property_card_type  ==  0){
            $property_card_type_string  =   '';
        }else{
            $property_card_type_string  =   '_type'.$property_card_type;
        }
        
        
        
        $current_user               =   wp_get_current_user();
        $userID                     =   $current_user->ID;
        $user_option                =   'favorites'.$userID;
        $curent_fav                 =   get_option($user_option);
        $currency                   =   esc_html( get_option('wp_estate_currency_symbol', '') );
        $where_currency             =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
        $area_array                 =   '';  
        $city_array                 =   '';  
        $action_array               =   '';   
        $categ_array                =   '';
        $property_unit_slider       =   get_option('wp_estate_prop_list_slider','');
        $options                    =   wpestate_page_details(intval($_POST['postid']));
        $allowed_html               =   array();
        $no_listins_per_row         =   intval( get_option('wp_estate_listings_per_row', '') );
        $half_map =   0;
        if (isset($_POST['halfmap'])){
            $half_map = intval($_POST['halfmap']);
        }  
        
        $args =  wpestate_search_results_default ('ajax');

        $order= intval($_POST['order']);
        $meta_order         =   'prop_featured';
        $meta_directions    =   'DESC';   
        $order_by           =   'meta_value';
    
        if(isset($_POST['order'])) {
            $order=  wp_kses( $_POST['order'],$allowed_html );
            switch ($order){
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
                    $meta_order='property_bedrooms';
                    $meta_directions='ASC';
                    $order_by='meta_value_num';
                    break;
            }
        }
        
        
        
        $args ['meta_key']        = $meta_order;
        $args ['orderby']         = $order_by;
        $args ['order']           = $meta_directions;
        
 
        
        if(isset($_POST['order'])) {
            $prop_selection = new WP_Query($args);
        }else{
            add_filter( 'posts_orderby', 'wpestate_my_order' );
            $prop_selection = new WP_Query($args);
            remove_filter( 'posts_orderby', 'wpestate_my_order' );
        }
  
        ob_start();  
        $counter          =   0;
        $compare_submit   =   wpestate_get_template_link('compare_listings.php');
        print '<span id="scrollhere"><span>';

       
        $paged      =   intval($_POST['newpage']);
      
        if( $prop_selection->have_posts() ){
                if($half_map==1){
                    $is_col_md_12=1;
                }
                while ($prop_selection->have_posts()): $prop_selection->the_post(); 
                    get_template_part('templates/property_unit'.$property_card_type_string);
                endwhile;
            kriesi_pagination_ajax($prop_selection->max_num_pages, $range =2,$paged,'pagination_ajax_search'); 
        }else{
            print '<span class="no_results">'. __("We didn't find any results","wpestate").'</>';
        }

       wp_suspend_cache_addition(false);  
       
         
        $cards= ob_get_contents();
        ob_end_clean();
        echo json_encode( array('sent'=>true, 'args'=>$args,'cards'=>$cards,'no_founs'=> $prop_selection->found_posts.' '.__('Listings','wpestate') ) ); 
      
        
       die();
  }
  
 endif; // end   ajax_filter_listings 
 

















///////////////////////////////////////////////////////////////////////////////

add_action( 'wp_ajax_nopriv_wpestate_load_adv6_tax', 'wpestate_load_adv6_tax' );  
add_action( 'wp_ajax_wpestate_load_adv6_tax', 'wpestate_load_adv6_tax' );

if( !function_exists('wpestate_load_adv6_tax') ):
    function wpestate_load_adv6_tax(){
    
    $tax=esc_html  ( sanitize_text_field ( $_POST['select_tax'] ) );
    
    $terms = get_terms( array(
        'taxonomy'      => $tax,
        'hide_empty'    => false,
    ) );
    

    
    $return='';
    foreach($terms as $term){
        $return.='<option value="'.$term->term_id.'">'.$term->name.'</option>';
    }     
    print $return;
    die();
    }
endif;
    
    
    
    
    


if( !function_exists('estate_property_page_design_tab_options') ):
function  estate_property_page_design_tab_options(){
    $tab_options = array(
    'description'=>array(
                    'label'=>'Description'
                    ),
    'property_address'=>array(
                    'label'=>'Property Address'
                    ),
    'property_details'=>array(
                    'label'=>'Property Details'
                    ),
    'amenities_features'=>array(
                    'label'=>'Amenities and Features'
                    ),
    'map'=>array(
                    'label'=>'Map'
                    ),
    'walkscore'=>array(
                    'label'=>'Walkscore'
                    ),
    'floor_plans'=>array(
                    'label'=>'Floor Plans'
                    ),
    'page_view'=>array(
                    'label'=>'Page Views'
                    ),
    );
}
endif;


if( !function_exists('estate_property_page_design_accordion_options') ):
function estate_property_page_design_accordion_options(){
    
}
endif;

if( !function_exists('estate_property_page_design_detailsoptions') ):
function estate_property_page_design_detailsoptions(){
    
}
endif;


























add_action( 'wp_ajax_wpestate_save_property_page_design', 'wpestate_save_property_page_design' );

if( !function_exists('wpestate_save_property_page_design') ):
    function wpestate_save_property_page_design(){
        if( !current_user_can('administrator') ){   
            exit('out pls');
        }
        
        $content=$_POST['content'];
        echo mb_detect_encoding($content);
        update_option('wpestate_property_page_content',$content);
        update_option('wpestate_uset_unit',intval($_POST['use_unit']));
        $doc = new DOMDocument();
        $doc->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));
        
        
        $finder = new DomXPath($doc);
        $classname="prop_full_width";

        
        $divs = $doc->getElementsByTagName('div');
        $nodes = $finder->query("//*[contains(@class, '$classname')]");

        $structure_array = array();
        foreach ( $nodes as $div ) {
         
           $structure_array []= wpestate_unit_return_row($div);
        }
  
        update_option('wpestate_property_unit_structure',$structure_array);
        die();
      
      
    }
 endif;   


 
 if( !function_exists('wpestate_unit_return_row') ):
 function  wpestate_unit_return_row($div){
     
     

        $return_array=array();
        foreach ( $div->childNodes as $rows ) {
          
        
            $class  =   stripslashes( trim( (string) $rows->getAttribute('class') ) );
            $class  =   str_replace('"', '', $class);
       
            if($class=='prop-columns'){
                $columns_array=array();
                
                foreach ( $rows->childNodes as $elements ) {
             
                    $class  =    stripslashes( trim( (string) $elements->getAttribute('class') ) );
                    $class  =    str_replace('"', '', $class);
                  
                
                    if($class==='design_element_col'){
                        $unit_element=array();
                        
                        $class_name     = ( $elements->getAttribute('data-mystyle-class')   );
                        $class_content  = ( $elements->getAttribute('data-mystyle') );
                        $element_name   = ( $elements->getAttribute('data-tip') );
                        $element_text   = ( $elements->getAttribute('data-custom-text') );
                        $element_icon   = ( $elements->getAttribute('data-icon-image') );
                        $element_font_s = ( $elements->getAttribute('data-font-size') );
                        $element_color  = ( $elements->getAttribute('data-color') );
                        $element_align  = ( $elements->getAttribute('data-text-align') );
                        $element_extra  = ( $elements->getAttribute('data-extra_css') );
                       
                        $unit_element['element_name']   =  wpestate_unit_data_cleam($element_name );
                        $unit_element['class_content']  =  wpestate_unit_data_cleam($class_content);
                        $unit_element['class_name']     =  wpestate_unit_data_cleam($class_name);
                        $unit_element['text']           =  wpestate_unit_data_cleam($element_text);
                        $unit_element['icon']           =  wpestate_unit_data_cleam($element_icon);
                        $unit_element['font']           =  wpestate_unit_data_cleam($element_font_s);
                        $unit_element['color']          =  wpestate_unit_data_cleam($element_color);
                        $unit_element['text-align']     =  wpestate_unit_data_cleam($element_align);
                        $unit_element['extra_class']    =  wpestate_unit_data_cleam($element_extra);
                      
                        $columns_array[]=$unit_element;
                    }
                }
                $return_array[]=$columns_array;
            }
        }

    return $return_array;            

        
}
endif; 

if( !function_exists('wpestate_unit_data_cleam') ):
function wpestate_unit_data_cleam($element){
    $element=(string)$element;
    $element  =   str_replace('\"', '', $element);
    return $element;
}
endif; 
 
if( !function_exists('wpestate_go_home') ):
 function wpestate_go_home($element){
    $element=(string)$element;
    $element  =   str_replace('\"', '', $element);
    return $element;
 }
endif;
 

 
 
 
 
add_action('wp_logout','wpestate_go_home');
if( !function_exists('wpestate_go_home') ):
function wpestate_go_home(){
    wp_redirect( home_url() );
    exit();
}
endif;



if( !function_exists('register_wpestate_widgets_imported') ):
function register_wpestate_widgets_imported(){
    $data = get_option('estate_imported_sidebars');
   
    if($data){
        foreach($data as $sidebar_id){
            register_sidebar(array(
                    'id'    =>  sanitize_title($sidebar_id),
                    'name'  =>  $sidebar_id,
                    'before_widget' => '<li id="%1$s" class="widget widget-container sbg_widget '.$sidebar_id.' %2$s">',
                    'after_widget'  => '</li>',
                    'before_title'  => '<h3 class="widget-title-sidebar">',
                    'after_title'   => '</h3>',
            ));
         
        }
    }
}
endif;




add_action( 'wp_ajax_wpestate_start_demo_import', 'wpestate_start_demo_import' );

if( !function_exists('wpestate_start_demo_import') ):
function wpestate_start_demo_import(){
  
   if( !current_user_can('administrator') ){
        exit('out pls');
    }
    
    /* include importers */
    if (!defined('WP_LOAD_IMPORTERS')) define('WP_LOAD_IMPORTERS', true);
                
    if (!class_exists('WP_Importer')) {
        $wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
        include $wp_importer;
    }
    if (!class_exists('WP_Import')) {
        $wp_import = get_template_directory() . '/libs/plugins/wordpress-importer.php';
        include $wp_import;
    }

    $base_template = sanitize_text_field($_POST['base_template']);
    
    $base_template_array= array(
        'demo1',
        'demo2',
        'demo5',
        'london-demo',
        'losangeles-demo',
        'main-demo',
        'ny-demo',
        'paris-demo',
        'rio-demo',
        'rome-demo',
        'sidney-demo',
        'tokyo-demo',
        'chicago-demo'
    );
    
    if ( !in_array($base_template, $base_template_array)){
        exit('not a demo');
    }
   
    $base_template_dir  =    get_template_directory();  
    $theme_content      =    $base_template_dir . '/wpestate_templates/'.$base_template.'/theme_content.xml';
    $theme_options      =    $base_template_dir . '/wpestate_templates/'.$base_template.'/options.txt';   
    $theme_widget       =    $base_template_dir . '/wpestate_templates/'.$base_template.'/widgets.wie';
    $rev_slder_main     =    $base_template_dir . '/wpestate_templates/'.$base_template.'/main.zip';

            
            

    
    ////////////////////// import the actual demo content
    $importer = new WP_Import();
    $importer->fetch_attachments = true;
    ob_start();  ob_end_clean();
    $importer->import($theme_content);
  
    echo '<li>'.__('Demo content is imported.','wpestate').'</li>';

    ////////////////////// import menus
    $menu_locations  = get_theme_mod('nav_menu_locations');
    $menus      = wp_get_nav_menus();
 
    if ($menus) {
        foreach ($menus as $menu) {
            if ($menu->name == 'Main Navigation' || $menu->name == 'Main' || $menu->name == 'Main Menu' || $menu->name == 'main') {
                $menu_locations['primary'] = $menu->term_id;
                $menu_locations['mobile']= $menu->term_id;
            }
            if ($menu->name == 'Footer' || $menu->name == 'footer') {
                $menu_locations['footer_menu'] = $menu->term_id;
            }
        }
    }
    echo '<li>'.__('Menus are configured','wpestate').'</li>';
    set_theme_mod('nav_menu_locations', $menu_locations);
    

    ////////////////////// set up pages
    $homepage = get_page_by_title('Homepage');
    if (!empty($homepage->ID)) {
        update_option('page_on_front', $homepage->ID);
        update_option('show_on_front', 'page');
         
        echo '<li>'.__('Default homepage is configured','wpestate').'</li>';
    }else{
        echo '<li>'.__('Default homepage is NOT configured','wpestate').'</li>';
    }
         
    
    ///////////////////// theme options imports
                        
    $import_data =file_get_contents($theme_options);
    $data = unserialize(base64_decode($import_data));
    

  
    if (!empty($data)) {
        foreach($data as $key=>$value){
            update_option($key, $value);          
        }
        update_option('wp_estate_readsys','no' );
        echo '<li>'.__('Theme options are imported.','wpestate').'</li>';
    }
     ///////////////////// widgets import
    $wid_import_data    =   file_get_contents($theme_widget);
    $data               =   json_decode($wid_import_data);
    
    global $wp_registered_sidebars;
    global $wp_registered_widget_controls;
    
    $widget_controls    = $wp_registered_widget_controls;
    $available_widgets  = array();
    foreach ($widget_controls as $widget) {
        if (!empty($widget['id_base']) && !isset($available_widgets[ $widget['id_base']])) {
            $available_widgets[ $widget['id_base']]['id_base'] = $widget['id_base'];
            $available_widgets[ $widget['id_base']]['name'] = $widget['name'];
        }
    }
    
    $widget_instances = array();
    foreach ($available_widgets as $widget_data) {
        $widget_instances[ $widget_data['id_base']] = get_option('widget_' . $widget_data['id_base']);
    }
         

    $imported_sidebars=  array();
    
    foreach ($data as $sidebar_id => $widgets) {
        if (!isset($wp_registered_sidebars[ $sidebar_id ])) {
            $imported_sidebars[] =$sidebar_id;
            //    print 'add '.$sidebar_id.'</br>';
        }
    }
    
    update_option('estate_imported_sidebars',$imported_sidebars);
    register_wpestate_widgets_imported();
      
   
    
    foreach ($data as $sidebar_id => $widgets) {
        if ('wp_inactive_widgets' == $sidebar_id) {
            continue;
        }
        
        if (isset($wp_registered_sidebars[ $sidebar_id ])) {
            $sidebar_available      = true;
            $use_sidebar_id         = $sidebar_id;
            $sidebar_message_type   = 'success';
            $sidebar_message        = '';
        }else {
            $sidebar_available      = false;
            $use_sidebar_id         = 'wp_inactive_widgets';
            $sidebar_message_type   = 'error';
            $sidebar_message        = __('Sidebar does not exist', 'wpestate');
        }
       
   
        
        if ( !empty($wp_registered_sidebars[ $sidebar_id ]['name']) ){
            $results[ $sidebar_id ]['name'] = $wp_registered_sidebars[ $sidebar_id ]['name'];
        }else{
            $results[ $sidebar_id ]['name']  = $sidebar_id;
        }
        $results[ $sidebar_id ]['message_type'] = $sidebar_message_type;
        $results[ $sidebar_id ]['message']      = $sidebar_message;
        $results[ $sidebar_id ]['widgets']      = array();
        
        
        foreach ($widgets as $widget_instance_id => $widget) {
                $fail = false;
                $id_base = preg_replace('/-[0-9]+$/', '', $widget_instance_id);
                $instance_id_number = str_replace($id_base . '-', '', $widget_instance_id);
                if (!$fail && !isset($available_widgets[ $id_base ])) {
                        $fail                   = true;
                        $widget_message_type    = 'error';
                        $widget_message         = __('Site does not support this widget', 'wpestate');
                }
                
             
                
                if (!$fail && isset($widget_instances[ $id_base ])) {
                        $sidebars_widgets           = get_option('sidebars_widgets');
                      
                        if(isset($sidebars_widgets[ $use_sidebar_id ])){
                            $sidebar_widgets = $sidebars_widgets[ $use_sidebar_id ];
                        }else{
                            $sidebar_widgets =array();
                        }
                      
                        if( !empty($widget_instances[ $id_base ])  ){
                            $single_widget_instances   =  $widget_instances[ $id_base ]; 
                        }else{
                            $single_widget_instances  = array();
                        }
                        
                        
                        foreach ($single_widget_instances as $check_id => $check_widget) {
                            if (in_array("$id_base-$check_id", $sidebar_widgets) && (array)$widget == $check_widget) {
                                $fail = true;
                                $widget_message_type = 'warning';
                                $widget_message = __('Widget already exists', 'wpestate');
                                break;
                            }
                        }
                }
                
                if (!$fail) {
                        $single_widget_instances = get_option('widget_' . $id_base);
                        $single_widget_instances = !empty($single_widget_instances) ? $single_widget_instances : array(
                                '_multiwidget' => 1
                        );
                        $single_widget_instances[] = (array)$widget;
                        end($single_widget_instances);
                        $new_instance_id_number = key($single_widget_instances);
                        if ('0' === strval($new_instance_id_number)) {
                                $new_instance_id_number = 1;
                                $single_widget_instances[ $new_instance_id_number ] = $single_widget_instances[0];
                                unset($single_widget_instances[0]);
                        }
                        if (isset($single_widget_instances['_multiwidget'])) {
                                $multiwidget = $single_widget_instances['_multiwidget'];
                                unset($single_widget_instances['_multiwidget']);
                                $single_widget_instances['_multiwidget'] = $multiwidget;
                        }
                        update_option('widget_' . $id_base, $single_widget_instances);
                        $sidebars_widgets = get_option('sidebars_widgets');
                        $new_instance_id = $id_base . '-' . $new_instance_id_number;
                        $sidebars_widgets[ $use_sidebar_id ][] = $new_instance_id;
                        update_option('sidebars_widgets', $sidebars_widgets);
                        if ($sidebar_available) {
                                $widget_message_type = 'success';
                                $widget_message = __('Imported', 'wpestate');
                        } 
                        else {
                                $widget_message_type = 'warning';
                                $widget_message = __('Imported to Inactive', 'wpestate');
                        }
                }

                if( isset( $available_widgets[ $id_base ]['name'] ) ) {
                    $results[ $sidebar_id ]['widgets'][ $widget_instance_id ]['name'] = $available_widgets[ $id_base ]['name'] ;
                }else{
                    $results[ $sidebar_id ]['widgets'][ $widget_instance_id ]['name'] = $id_base;
                }
                
                if($widget->title){
                    $results[ $sidebar_id ]['widgets'][ $widget_instance_id ]['title'] =$widget->title;
                }else{
                    $results[ $sidebar_id ]['widgets'][ $widget_instance_id ]['title'] =__('No Title', 'wpestate');
                }
                
                $results[ $sidebar_id ]['widgets'][ $widget_instance_id ]['message_type'] = $widget_message_type;
                $results[ $sidebar_id ]['widgets'][ $widget_instance_id ]['message'] = $widget_message;
            }
            
          
    }
    
    // rev slider import
    $rev_slder_main=    $upload_dir['basedir'] . '/estate_templates/'.$base_template.'/main.zip';
    if( file_exists  ($rev_slder_main) ) {
        $slider = new RevSlider();
        $slider->importSliderFromPost(true,true,$rev_slder_main);  
    }

    wpestate_delete_cache();
    
    die();

}
endif;






////////////////////////////////////////////////////////////////////////////////
/// Ajax  Filters
////////////////////////////////////////////////////////////////////////////////

add_action( 'wp_ajax_wpestate_disable_listing', 'wpestate_disable_listing' );

if( !function_exists('wpestate_disable_listing') ):
    function wpestate_disable_listing(){    
        $current_user       =   wp_get_current_user();
        $userID             =   $current_user->ID;
        $user_login         =   $current_user->user_login;
        
        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }

        $prop_id=intval($_POST['prop_id']);
        if(!is_numeric($prop_id)) {
            exit();
        }
        $agent_list                     =   (array)get_user_meta($userID,'current_agent_list',true);
        $the_post= get_post( $prop_id); 
       
        if( $current_user->ID != $the_post->post_author   &&  !in_array($the_post->post_author , $agent_list)  ) {    
            exit('you don\'t have the right to delete this');
        }
        
        if($the_post->post_status=='disabled'){
            $new_status='publish';
        }else{
            $new_status='disabled';
        }
        $my_post = array(
            'ID'           => $prop_id,
            'post_status'   => $new_status
        );

        wp_update_post( $my_post );
        die();       
    }
endif;    


////////////////////////////////////////////////////////////////////////////////
/// filter invoices
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_wpestate_load_stats_property', 'wpestate_load_stats_property' );  
add_action( 'wp_ajax_wpestate_load_stats_property', 'wpestate_load_stats_property' );

if( !function_exists('wpestate_load_stats_property') ):
    function wpestate_load_stats_property(){
    
    $listing_id     =   intval($_POST['postid']);
    
    $labels         =   wp_estate_return_traffic_labels($listing_id,30);
    $array_values   =   wp_estate_return_traffic_data($listing_id,30);
  
    echo json_encode( array('array_values'=>$array_values,'labels'=>$labels) );
    die();       
    }
 endif;   

////////////////////////////////////////////////////////////////////////////////
/// filter invoices
////////////////////////////////////////////////////////////////////////////////

add_action( 'wp_ajax_wpestate_ajax_filter_invoices', 'wpestate_ajax_filter_invoices' );

if( !function_exists('wpestate_ajax_filter_invoices') ):
    function wpestate_ajax_filter_invoices(){
        $current_user   =   wp_get_current_user();
        $userID         =   $current_user->ID;
        
       
        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }
        
        $start_date       =  sanitize_text_field( esc_html($_POST['start_date']) );
        $end_date         =  sanitize_text_field( esc_html($_POST['end_date']) );
        $type             =  sanitize_text_field( esc_html($_POST['type']) );
        $status           =  sanitize_text_field( esc_html($_POST['status']) );
        
        
        $meta_query =   array();
        
        if( isset($_POST['type']) &&  $_POST['type']!='' ){
            $temp_arr             =   array();
            $type                 =   esc_html($_POST['type']);
            $temp_arr['key']      =   'invoice_type';
            $temp_arr['value']    =   $type;
            $temp_arr['type']     =   'char';
            $temp_arr['compare']  =   'LIKE'; 
            $meta_query[]         =   $temp_arr;
        }
        
        
        if( isset($_POST['status']) &&  $_POST['status'] !='' ){
            $temp_arr             =   array();
            $type                 =   esc_html($_POST['status']);
            $temp_arr['key']      =   'pay_status';
            $temp_arr['value']    =   $type;
            $temp_arr['type']     =   'numeric';
            $temp_arr['compare']  =   '='; 
            $meta_query[]         =   $temp_arr;
        }
      
        $date_query=array();
        
        if( isset($_POST['start_date']) &&  $_POST['start_date'] !='' ){
            $start_date = esc_html( $_POST['start_date'] );
            $date_query ['after']  = $start_date; 
        }
         
        if( isset($_POST['end_date']) &&  $_POST['end_date'] !='' ){
            $end_date = esc_html( $_POST['end_date'] );
            $date_query ['before']  = $end_date; 
        }
       $date_query ['inclusive'] = true;
        
        $args = array(
            'post_type'        => 'wpestate_invoice',
            'post_status'      => 'publish',
            'posts_per_page'   => -1 ,
            'author'           => $userID, 
            'meta_query'       => $meta_query,
            'date_query'       => $date_query
        );
        
        
       
        $prop_selection = new WP_Query($args);
        $total_confirmed = 0;
        $total_issued=0;
            
        ob_start(); 
        while ($prop_selection->have_posts()): $prop_selection->the_post(); 
            get_template_part('templates/invoice_listing_unit'); 
            $inv_id=get_the_ID();
            $status = esc_html(get_post_meta($inv_id, 'invoice_status', true));
            $type   = esc_html(get_post_meta($inv_id, 'invoice_type', true));
            $price = esc_html(get_post_meta($inv_id, 'item_price', true));
            $total_confirmed = $total_confirmed + $price;
            
           
        endwhile;
        $templates = ob_get_contents();
        ob_end_clean(); 
             
     
        
       echo json_encode(array('results'=>$templates, 'invoice_confirmed'=> wpestate_show_price_custom_invoice ( $total_confirmed ) ));
       
        die();
    }
endif;







add_action( 'wp_ajax_wpestate_cancel_stripe', 'wpestate_cancel_stripe' );

if( !function_exists('wpestate_cancel_stripe') ):
    function wpestate_cancel_stripe(){
  
    require_once(get_template_directory().'/libs/stripe/lib/Stripe.php');
    
    $current_user   =   wp_get_current_user();
    $userID         =   $current_user->ID;
    
    if ( !is_user_logged_in() ) {   
        exit('ko');
    }
    if($userID === 0 ){
        exit('out pls');
    }

    $stripe_customer_id         =   get_user_meta( $userID, 'stripe', true );
    $subscription_id            =   get_user_meta( $userID, 'stripe_subscription_id', true );    
    $stripe_secret_key          =   esc_html( get_option('wp_estate_stripe_secret_key','') );
    $stripe_publishable_key     =   esc_html( get_option('wp_estate_stripe_publishable_key','') );

    $stripe = array(
        "secret_key"      => $stripe_secret_key,
        "publishable_key" => $stripe_publishable_key
    );

    Stripe::setApiKey($stripe['secret_key']);
    $processor_link             =   wpestate_get_template_link('stripecharge.php');
    $submission_curency_status  =   esc_html( get_option('wp_estate_submission_curency','') );
 
    
    $cu = Stripe_Customer::retrieve($stripe_customer_id);
    $cu->subscriptions->retrieve($subscription_id)->cancel(
    array("at_period_end" => true ));
    update_user_meta( $current_user->ID, 'stripe_subscription_id', '' );
   
    }
endif;



add_action( 'wp_ajax_nopriv_wpestate_set_cookie_multiple_curr', 'wpestate_set_cookie_multiple_curr' );  
add_action( 'wp_ajax_wpestate_set_cookie_multiple_curr', 'wpestate_set_cookie_multiple_curr' );

if( !function_exists('wpestate_set_cookie_multiple_curr') ):
    function wpestate_set_cookie_multiple_curr(){
        $curr               =   sanitize_text_field($_POST['curr']);
        $pos                =   sanitize_text_field($_POST['pos']);
        $symbol             =   sanitize_text_field($_POST['symbol']);
        $coef               =   sanitize_text_field($_POST['coef']);
        $curpos             =   sanitize_text_field($_POST['curpos']);
     
        setcookie("my_custom_curr", $curr,time()+3600,"/");
        setcookie("my_custom_curr_pos", $pos,time()+3600,"/");
        setcookie("my_custom_curr_symbol", $symbol,time()+3600,"/");
        setcookie("my_custom_curr_coef", $coef,time()+3600,"/");
        setcookie("my_custom_curr_cur_post", $curpos,time()+3600,"/");
        
       // wpestate_delete_cache();
    }
endif;

// set measure unit cookies
add_action( 'wp_ajax_nopriv_wpestate_set_cookie_measure_unit', 'wpestate_set_cookie_measure_unit' );  
add_action( 'wp_ajax_wpestate_set_cookie_measure_unit', 'wpestate_set_cookie_measure_unit' );

if( !function_exists('wpestate_set_cookie_measure_unit') ):
    function wpestate_set_cookie_measure_unit(){
        $value               =   sanitize_text_field($_POST['value']);
 
        setcookie("my_measure_unit", $value ,time()+3600,"/");        
    }
endif;


////////////////////////////////////////////////////////////////////////////////
/// activate purchase
////////////////////////////////////////////////////////////////////////////////


add_action( 'wp_ajax_wpestate_activate_purchase_listing', 'wpestate_activate_purchase_listing' );

if( !function_exists('wpestate_activate_purchase_listing') ):
    function wpestate_activate_purchase_listing(){
        if ( !is_user_logged_in() ) {   
            exit('out pls');
        }
     
        if( !current_user_can('administrator') ){
            exit('out pls');
        }
        
        $item_id            =   intval($_POST['item_id']);
        $invoice_id         =   intval($_POST['invoice_id']);
        $type               =   intval($_POST['type']);
        $owner_id           =   get_post_meta($invoice_id, 'buyer_id', true);
        
        $user               =   get_user_by('id',$owner_id); 
        $user_email         =   $user->user_email;
        
        if ($type==1) { // Listing
            update_post_meta($item_id, 'pay_status', 'paid');
            $post = array(
                    'ID'            => $item_id,
                    'post_status'   => 'publish'
                    );
            $post_id =  wp_update_post($post ); 
            
        }elseif ($type==2) { //Upgrade to Featured
            update_post_meta($item_id, 'prop_featured', 1);
          
        }elseif ($type==3){ //Publish Listing with Featured
            update_post_meta($item_id, 'pay_status', 'paid');
            update_post_meta($item_id, 'prop_featured', 1);
            $post = array(
                    'ID'            => $item_id,
                    'post_status'   => 'publish'
                    );
            $post_id =  wp_update_post($post ); 
            
        }
        
        update_post_meta($invoice_id, 'pay_status', 1);  
        $arguments=array();
        wpestate_select_email_type($user_email,'purchase_activated',$arguments);    
        
    }
         
        
endif;    

////////////////////////////////////////////////////////////////////////////////
/// activate purchase per listing
////////////////////////////////////////////////////////////////////////////////

add_action( 'wp_ajax_wpestate_direct_pay_pack_per_listing', 'wpestate_direct_pay_pack_per_listing' );

if( !function_exists('wpestate_direct_pay_pack_per_listing') ):
    function wpestate_direct_pay_pack_per_listing(){
        $current_user = wp_get_current_user();
        if ( !is_user_logged_in() ) {   
            exit('out pls');
        }
        
        $userID                     =   $current_user->ID;
        $user_email                 =   $current_user->user_email ;       
        $listing_id                 =   intval($_POST['selected_pack']);
        $include_feat               =   intval($_POST['include_feat']);
        $pay_status                 =   get_post_meta($listing_id, 'pay_status', true);
        $price_submission           =   floatval( get_option('wp_estate_price_submission','') );
        $price_featured_submission  =   floatval( get_option('wp_estate_price_featured_submission','') );

      
        
        $total_price    =   0;
        $time           =   time(); 
        $date           =   date('Y-m-d H:i:s',$time);
    
        if( $include_feat==1 ){
            if( $pay_status ==  'paid' ){
                $invoice_no = wpestate_insert_invoice('Upgrade to Featured','One Time',$listing_id,$date,$current_user->ID,0,1,'' );
                wpestate_email_to_admin(1);
                $total_price    =   $price_featured_submission;
            }else{
                $invoice_no = wpestate_insert_invoice('Publish Listing with Featured','One Time',$listing_id,$date,$current_user->ID,1,0,'' );
                wpestate_email_to_admin(0);
                $total_price    =   $price_submission + $price_featured_submission;
            }
        }else{
            $invoice_no = wpestate_insert_invoice('Listing','One Time',$listing_id,$date,$current_user->ID,0,0,'' );
            wpestate_email_to_admin(0);
            $total_price    =   $price_submission;
        }
        
        $currency                   =   esc_html( get_option('wp_estate_currency_symbol', '') );
        $where_currency             =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
        if ($total_price != 0) {
            if ($where_currency == 'before') {
                $total_price = $currency . ' ' . $total_price;
            } else {
                $total_price = $total_price . ' ' . $currency;
            }
        }
        
        
        // send email
        /**/
        $headers = 'From: No Reply <noreply@'.$_SERVER['HTTP_HOST'].'>' . "\r\n";
        $message  = __('Hi there,','wpestate') . "\r\n\r\n";
        $message .= sprintf( __("We received your  Wire Transfer payment request on %s ! Please follow the instructions below in order to start submitting properties as soon as possible.",'wpestate'), get_option('blogname')) . "\r\n\r\n";
        $message .= __('The invoice number is: ','wpestate').$invoice_no." ".__('Amount:','wpestate').' '.$total_price."\r\n\r\n";
        $message .= __('Instructions: ','wpestate'). "\r\n\r\n";
        
        if (function_exists('icl_translate') ){
            $mes =  strip_tags( get_option('wp_estate_direct_payment_details','') );
            $payment_details      =   icl_translate('wpestate','wp_estate_property_direct_payment_text', $mes );
        }else{
            $payment_details =  strip_tags( get_option('wp_estate_direct_payment_details','') );
        }
                    
        $message .= $payment_details;
       
      
        update_post_meta($invoice_no, 'pay_status', 0);  
       
        
        $arguments=array(
            'invoice_no'        =>  $invoice_no,
            'total_price'       =>  $total_price,
            'payment_details'   =>  $payment_details,
        );
        wpestate_select_email_type($user_email,'new_wire_transfer',$arguments);
        $company_email      =  get_bloginfo('admin_email');
        wpestate_select_email_type($company_email,'admin_new_wire_transfer',$arguments);
        
        die();        
}
endif;



////////////////////////////////////////////////////////////////////////////////
/// activate purchase
////////////////////////////////////////////////////////////////////////////////



add_action( 'wp_ajax_wpestate_activate_purchase', 'wpestate_activate_purchase' );

if( !function_exists('wpestate_activate_purchase') ):
    function wpestate_activate_purchase(){
        if ( !is_user_logged_in() ) {   
            exit('out pls');
        }
        if( !current_user_can('administrator') ){
            exit('out pls');
        }
        
        
        $pack_id        =   intval($_POST['item_id']);
        $invoice_id     =   intval($_POST['invoice_id']);
        $userID         =   get_post_meta($invoice_id, 'buyer_id', true);
                   
        if( wpestate_check_downgrade_situation($userID,$pack_id) ){
            wpestate_downgrade_to_pack( $userID, $pack_id );
            wpestate_upgrade_user_membership($userID,$pack_id,1,'',1);
        }else{
            wpestate_upgrade_user_membership($userID,$pack_id,1,'',1);
        }
        update_post_meta($invoice_id, 'pay_status', 1); 
    }
endif;


////////////////////////////////////////////////////////////////////////////////
/// direct pay issue invoice
////////////////////////////////////////////////////////////////////////////////




add_action( 'wp_ajax_wpestate_direct_pay_pack', 'wpestate_direct_pay_pack' );

if( !function_exists('wpestate_direct_pay_pack') ):
    
    function wpestate_direct_pay_pack(){
        $current_user = wp_get_current_user();
        
        if ( !is_user_logged_in() ) {   
            exit('out pls');
        }
        
        $userID                   =   $current_user->ID;
        $user_email               =   $current_user->user_email ;
        $selected_pack            =   intval( $_POST['selected_pack'] );
        $total_price              =   get_post_meta($selected_pack, 'pack_price', true);
        $currency                 =   esc_html( get_option('wp_estate_currency_symbol', '') );
        $where_currency           =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
        
        if ($total_price != 0) {
            if ($where_currency == 'before') {
                $total_price = $currency . ' ' . $total_price;
            }   else {
                $total_price = $total_price . ' ' . $currency;
            }
        }
        
        
        // insert invoice
        $time           =   time(); 
        $date           =   date('Y-m-d H:i:s',$time); 
        $is_featured    =   0;
        $is_upgrade     =   0;
        $paypal_tax_id  =   '';
                 
        $invoice_no = wpestate_insert_invoice('Package','One Time',$selected_pack,$date,$userID,$is_featured,$is_upgrade,$paypal_tax_id);
        
        // send email
        $headers    = 'From: No Reply <noreply@'.$_SERVER['HTTP_HOST'].'>' . "\r\n";
        $message    = __('Hi there,','wpestate') . "\r\n\r\n";
        
        if (function_exists('icl_translate') ){
            $mes                  =     strip_tags( get_option('wp_estate_direct_payment_details','') );
            $payment_details      =     icl_translate('wpestate','wp_estate_property_direct_payment_text', $mes );
        }else{
            $payment_details      =     strip_tags( get_option('wp_estate_direct_payment_details','') );
        }
        
        update_post_meta($invoice_no, 'pay_status', 0);
        $arguments=array(
            'invoice_no'        =>  $invoice_no,
            'total_price'       =>  $total_price,
            'payment_details'   =>  $payment_details,
        );
     
        // email sending
        wpestate_select_email_type($user_email,'new_wire_transfer',$arguments);
        $company_email      =  get_bloginfo('admin_email');
        wpestate_select_email_type($company_email,'admin_new_wire_transfer',$arguments);
         
         
    }

endif;








////////////////////////////////////////////////////////////////////////////////
/// Ajax  Filters
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_wpestate_advanced_search_filters', 'wpestate_advanced_search_filters' );  
add_action( 'wp_ajax_wpestate_advanced_search_filters', 'wpestate_advanced_search_filters' );

if( !function_exists('wpestate_advanced_search_filters') ):
    
    function wpestate_advanced_search_filters(){
    
        wp_suspend_cache_addition(true);
        wp_reset_query();
        wp_reset_postdata();
      
        global $currency;
        global $where_currency;
        global $post;
        global $options;
        global $prop_unit;
        global $prop_unit_class;
        global $property_unit_slider;
        global $no_listins_per_row;
        global $wpestate_uset_unit;
        global $custom_unit_structure;
        
        $custom_unit_structure    =   get_option('wpestate_property_unit_structure');
        $wpestate_uset_unit       =   intval ( get_option('wpestate_uset_unit','') );
        $current_user             =   wp_get_current_user();
        $userID                   =   $current_user->ID;
        $user_option              =   'favorites'.$userID;
        $curent_fav               =   get_option($user_option);
        $currency                 =   esc_html( get_option('wp_estate_currency_symbol', '') );
        $where_currency           =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
        $show_compare             =   1;
        $options                  =   wpestate_page_details(intval($_POST['page_id']));
        $allowed_html             =   array();
        $property_unit_slider     =   get_option('wp_estate_prop_list_slider','');
        $no_listins_per_row       =   intval( get_option('wp_estate_listings_per_row', '') );
        $args1 = stripslashes($_POST['args']);
        
        $property_card_type         =   intval(get_option('wp_estate_unit_card_type'));
        $property_card_type_string  =   '';
        if($property_card_type==0){
            $property_card_type_string='';
        }else{
            $property_card_type_string='_type'.$property_card_type;
        }
        
        $args=  json_decode($args1,true);
        //$args = get_object_vars($args2);
        $prop_unit          =   esc_html ( get_option('wp_estate_prop_unit','') );
        $prop_unit_class    =   '';
        if($prop_unit=='list'){
            $prop_unit_class="ajax12";
        }
       
              
        //////////////////////////////////////////////////////////////////////////////////////
        ///// order details
        //////////////////////////////////////////////////////////////////////////////////////
        $order=esc_html(wp_kses($_POST['value'],$allowed_html));
        
        $meta_directions    =   'DESC';
        $meta_order         =   'prop_featured';
        $order_by           =   'meta_value_num';

        
          switch ($order){
                case 0:
                    $meta_order         =   'prop_featured';
                    $meta_directions    =   'DESC';
                    $order_by           =   'meta_value_num';
                    break;
                
                case 1:
                    $meta_order         =   'property_price';
                    $meta_directions    =   'DESC';
                    $order_by           =   'meta_value_num';
                    break;
                case 2:
                    $meta_order         =   'property_price';
                    $meta_directions    =   'ASC';
                    $order_by           =   'meta_value_num';
                    break;
                case 3:
                    $meta_order         =   '';
                    $meta_directions    =   'DESC';
                    $order_by           =   'ID';
                    break;
                case 4:
                    $meta_order         =   '';
                    $meta_directions    =   'ASC';
                    $order_by           =   'ID';
                    break;
                case 5:
                    $meta_order         =   'property_bedrooms';
                    $meta_directions    =   'DESC';
                    $order_by           =   'meta_value_num';
                    break;
                case 6:
                    $meta_order         =   'property_bedrooms';
                    $meta_directions    =   'ASC';
                    $order_by           =   'meta_value_num';
                    break;
                case 7:
                    $meta_order         =   'property_bathrooms';
                    $meta_directions    =   'DESC';
                    $order_by           =   'meta_value_num';
                    break;
                case 8:
                    $meta_order         =   'property_bathrooms';
                    $meta_directions    =   'ASC';
                    $order_by           =   'meta_value_num';
                    break;
            }
            
            
            
        $args['meta_key']               =   $meta_order;
        $args['orderby']                =   $order_by;
        $args['order']                  =   $meta_directions;
        $args['cache_results']          =   false;
        $args['update_post_meta_cache'] =   false;
        $args['update_post_term_cache'] =   false;
        
        $prop_no    =   intval( get_option('wp_estate_prop_no', '') );
         
        // checks
        
      
        if ( $args['post_type']!='estate_property' || $args['post_status']!='publish'){
            exit('out pls');
        }
        
        $prop_selection = new WP_Query($args);
        print '<span id="scrollhere"></span>';  
        $counter = 0;

        if( $prop_selection->have_posts() ){
            while ( $prop_selection->have_posts() ): $prop_selection->the_post(); 
                get_template_part('templates/property_unit'.$property_card_type_string);
            endwhile;
        }else{
            print '<span class="no_results">'. __("We didn't find any results","wpestate").'</span>';
        }

        wp_reset_query();        
        wp_reset_postdata();

        wp_suspend_cache_addition(false);
        die();
  }
  
 endif; // end   ajax_filter_listings_search 
 
 
 

////////////////////////////////////////////////////////////////////////////////
/// print page function 
////////////////////////////////////////////////////////////////////////////////


  add_action( 'wp_ajax_nopriv_ajax_create_print', 'ajax_create_print' );  
  add_action( 'wp_ajax_ajax_create_print', 'ajax_create_print' );  
  
  if( !function_exists('ajax_create_print') ):
  function ajax_create_print(){ 
      
    if(!isset($_POST['propid'])|| !is_numeric($_POST['propid'])){
        exit('out pls1');
    }  
      
    $post_id            = intval($_POST['propid']);
    
    $the_post= get_post( $post_id); 
    if($the_post->post_type!='estate_property' || $the_post->post_status!='publish'){
        exit('out pls2');
    }
    
    $unit               = esc_html( get_option('wp_estate_measure_sys', '') );
    $currency           = esc_html( get_option('wp_estate_currency_symbol', '') );
    $where_currency     = esc_html( get_option('wp_estate_where_currency_symbol', '') );
    $property_address   = esc_html( get_post_meta($post_id, 'property_address', true) );
    $property_city      = strip_tags ( get_the_term_list($post_id, 'property_city', '', ', ', '') );
    $property_area      = strip_tags ( get_the_term_list($post_id, 'property_area', '', ', ', '') );
    $property_county    = esc_html( get_post_meta($post_id, 'property_county', true) );
    $property_zip       = esc_html(get_post_meta($post_id, 'property_zip', true) );
    $property_country   = esc_html(get_post_meta($post_id, 'property_country', true) );
    $ref_code           = get_post_meta($post_id, 'reference_code', true); 
      
    $property_size                  = wpestate_get_converted_measure( $post_id, 'property_size' ); 
    $property_bedrooms              = floatval ( get_post_meta($post_id, 'property_bedrooms', true) );
    $property_bathrooms             = floatval ( get_post_meta($post_id, 'property_bathrooms', true) );     
    $property_year                  = floatval ( get_post_meta($post_id, 'property_year', true) );  
                  
             
    $image_id           = get_post_thumbnail_id($post_id);
    $full_img           = wp_get_attachment_image_src($image_id, 'full');
    $full_img           = $full_img [0];
  
  
    $title              = get_the_title($post_id); 
    $page_object        = get_page( $post_id );
    $content            = $page_object->post_content;
    
    remove_filter('the_content', 'pretyScan');
    $content            = apply_filters('the_content',$content);
    add_filter('the_content', 'pretyScan');
    
    $price              = floatval   ( get_post_meta($post_id, 'property_price', true) );
  
    if ($price != 0) {
        $price = wpestate_show_price($post_id,$currency,$where_currency,1);    
    }else{
        $price='';
    }
    
    $feature_list_array =   array();
    $feature_list       =   esc_html( get_option('wp_estate_feature_list') );
    $feature_list_array =   explode( ',',$feature_list);
    $all_features   ='';
    if ( !count( $feature_list_array )==0 ){
        foreach($feature_list_array as $checker => $value){
            $post_var_name=  str_replace(' ','_', trim($value) );
            if (esc_html( get_post_meta($post_id, $post_var_name, true) ) == 1) {
                 $all_features   .='<div class="print-right-row">'. trim($value).'</div>';
            }
        }
    }                    
                        
    /////////////////////////////////////////////////////////////////////////////////////////////////////
    // get thumbs
    /////////////////////////////////////////////////////////////////////////////////////////////////////
    $arguments = array( 
        'numberposts'   => -1,
        'post_type'     => 'attachment', 
        'post_parent'   => $post_id,
        'post_status'   => null,
        'exclude'       => $image_id,
        'orderby'       => 'menu_order',
        'order'         => 'ASC'
    );
    $post_attachments = get_posts($arguments);

    
    $agent_email    =   '';
    $agent_skype    =   '';
    $agent_mobile   =   '';
    $agent_phone    =   '';
    $name           =   '';
    $preview_img    =   '';
    
    /////////////////////////////////////////////////////////////////////////////////////////////////////
    // get agent details
    /////////////////////////////////////////////////////////////////////////////////////////////////////
    $author_id      =  wpsestate_get_author($post_id);
   
    $agent_assigned_post    =   intval(get_post_meta($post_id,'property_agent',true));
    $user_assinged_agent    =   intval(get_post_meta($post_id,'user_meda_id',true));
    
    $user_role      = intval (get_user_meta( $author_id, 'user_estate_role', true) );

  
    if($user_assinged_agent==0){
            $thumb_id       = get_post_thumbnail_id($agent_assigned_post);
            $preview        = wp_get_attachment_image_src(get_post_thumbnail_id($agent_assigned_post), 'property_listings');
            $preview_img    = $preview[0];
            $agent_skype    = esc_html( get_post_meta($agent_assigned_post, 'agent_skype', true) );
            $agent_phone    = esc_html( get_post_meta($agent_assigned_post, 'agent_phone', true) );
            $agent_mobile   = esc_html( get_post_meta($agent_assigned_post, 'agent_mobile', true) );
            $agent_email    = esc_html( get_post_meta($agent_assigned_post, 'agent_email', true) );
            $agent_pitch    = esc_html( get_post_meta($agent_assigned_post, 'agent_pitch', true) );
            $agent_posit    = esc_html( get_post_meta($agent_assigned_post, 'agent_position', true) );
            $link           = get_permalink($agent_assigned_post);
            $name           = get_the_title($agent_assigned_post);
    }
    
     
    if( $user_role==1 ){
            $user_id=$author_id;
            $preview_img    =   get_the_author_meta( 'custom_picture',$user_id  );
            if($preview_img==''){
                $preview_img=get_template_directory_uri().'/img/default-user.png';
            }
       
            $agent_skype         = get_the_author_meta( 'skype' ,$user_id );
            $agent_phone         = get_the_author_meta( 'phone' ,$user_id );
            $agent_mobile        = get_the_author_meta( 'mobile' ,$user_id );
            $agent_email         = get_the_author_meta( 'user_email',$user_id );
            $agent_pitch         = '';
            $agent_posit         = get_the_author_meta( 'title',$user_id  );
            $agent_facebook      = get_the_author_meta( 'facebook',$user_id  );
            $agent_twitter       = get_the_author_meta( 'twitter',$user_id  );
            $agent_linkedin      = get_the_author_meta( 'linkedin' ,$user_id );
            $agent_pinterest     = get_the_author_meta( 'pinterest',$user_id  );
            $agent_urlc          = get_the_author_meta( 'website' ,$user_id );
            $link                = get_permalink();
            $name                = get_the_author_meta( 'first_name',$user_id ).' '.get_the_author_meta( 'last_name',$user_id);
            $agent_member        = get_the_author_meta( 'agent_member' ,$user_id );
    }else if($user_role==2){
            $agent_id       = get_user_meta($author_id,'user_agent_id',true);
            $thumb_id       = get_post_thumbnail_id($agent_id);
            $preview        = wp_get_attachment_image_src(get_post_thumbnail_id($agent_id), 'property_listings');
            $preview_img    = $preview[0];
            $agent_skype    = esc_html( get_post_meta($agent_id, 'agent_skype', true) );
            $agent_phone    = esc_html( get_post_meta($agent_id, 'agent_phone', true) );
            $agent_mobile   = esc_html( get_post_meta($agent_id, 'agent_mobile', true) );
            $agent_email    =  get_the_author_meta( 'user_email' , $author_id );
            $agent_pitch    = esc_html( get_post_meta($agent_id, 'agent_pitch', true) );
            $agent_posit    = esc_html( get_post_meta($agent_id, 'agent_position', true) );
            $link           = get_permalink($agent_id);
            $name           = get_the_title($agent_id);
    }else if($user_role==3){//agency
            $agent_id       = get_user_meta($author_id,'user_agent_id',true);
            $thumb_id       = get_post_thumbnail_id($agent_id);
            $preview        = wp_get_attachment_image_src(get_post_thumbnail_id($agent_id), 'property_listings');
    
            $preview_img    = $preview[0];
            $agent_skype    = esc_html( get_post_meta($agent_id, 'agency_skype', true) );
            $agent_phone    = esc_html( get_post_meta($agent_id, 'agency_phone', true) );
            $agent_mobile   = esc_html( get_post_meta($agent_id, 'agency_mobile', true) );
            $agent_email    =  get_the_author_meta( 'user_email' , $author_id );
            $agent_pitch    = esc_html( get_post_meta($agent_id, 'agency_pitch', true) );
            $agent_posit    = esc_html( get_post_meta($agent_id, 'agency_position', true) );
            $link           = get_permalink($agent_id);
            $name           = get_the_title($agent_id);
    }else if($user_role==4){//developer
            $agent_id       =get_user_meta($author_id,'user_agent_id',true);
            $thumb_id       = get_post_thumbnail_id($agent_id);
            $preview        = wp_get_attachment_image_src(get_post_thumbnail_id($agent_id), 'property_listings');
            $preview_img    = $preview[0];
            $agent_skype    = esc_html( get_post_meta($agent_id, 'developer_skype', true) );
            $agent_phone    = esc_html( get_post_meta($agent_id, 'developer_phone', true) );
            $agent_mobile   = esc_html( get_post_meta($agent_id, 'developer_mobile', true) );
            $agent_email    =  get_the_author_meta( 'user_email' , $author_id );
            $agent_pitch    = esc_html( get_post_meta($agent_id, 'developer_pitch', true) );
            $agent_posit    = esc_html( get_post_meta($agent_id, 'developer_position', true) );
            $link           = get_permalink($agent_id);
            $name           = get_the_title($agent_id);
    }
    

    /////////////////////////////////////////////////////////////////////////////////////////////////////
    // end get agent details
    /////////////////////////////////////////////////////////////////////////////////////////////////////
        
    print  '<html><head><title>'.$title.'</title><link href="'.get_stylesheet_uri().'" rel="stylesheet" type="text/css" />';
    
     
    if(is_child_theme()){
        print '<link href="'.get_template_directory_uri().'/style.css" rel="stylesheet" type="text/css" />';   
    }
    
    if(is_rtl()){
        print '<link href="'.get_template_directory_uri().'/rtl.css" rel="stylesheet" type="text/css" />';
    }
    print '</head>';
    $protocol = is_ssl() ? 'https' : 'http';
    print  '<script src="'.$protocol.'://code.jquery.com/jquery-1.10.1.min.js"></script><script>$(window).load(function(){ print(); });</script>';
    print  '<body class="print_body" >';

    $logo=get_option('wp_estate_logo_image','');
    if ( $logo!='' ){
       print '<img src="'.$logo.'" class="img-responsive printlogo" alt="logo"/>';	
    } else {
       print '<img class="img-responsive printlogo" src="'. get_template_directory_uri().'/img/logo.png" alt="logo"/>';
    }

    print '<h1 class="print_title">'.$title.'</h1>';
    print '<div class="print-price">'.__('Price','wpestate').': '.$price.'</div>';
    print '<div class="print-addr">'. $property_address. ', ' . $property_city.', '.$property_area.'</div>';
    print '<div class="print-col-img"><img src="'.$full_img.'">';
    print '<img class="print_qrcode" src="https://chart.googleapis.com/chart?cht=qr&chs=110x110&chl='. urlencode( get_permalink($post_id)) .'&choe=UTF-8" title="'.urlencode($title).'" />';
    print'</div>';
    
        
    $property_description_text  =   esc_html( get_option('wp_estate_property_description_text') );
    $property_details_text      =   esc_html( get_option('wp_estate_property_details_text') );
    $property_features_text     =   esc_html( get_option('wp_estate_property_features_text') );
    $property_adr_text          =   stripslashes ( esc_html( get_option('wp_estate_property_adr_text') ) );
    $print_show_images          =   get_option('wp_estate_print_show_images','');
    $print_show_floor_plans     =   get_option('wp_estate_print_show_floor_plans','');
    $print_show_features        =   get_option('wp_estate_print_show_features','');
    $print_show_details         =   get_option('wp_estate_print_show_details','');
    $print_show_adress          =   get_option('wp_estate_print_show_adress','');
    $print_show_description     =   get_option('wp_estate_print_show_description','');
    $print_show_agent          =    get_option('wp_estate_print_show_agent','');
    $print_show_subunits        =   get_option('wp_estate_print_show_subunits','');
     
     
    if($print_show_subunits == 'yes'){ 
        global $property_subunits_master;
        $has_multi_units=intval(get_post_meta($post_id, 'property_has_subunits', true));
        $property_subunits_master=intval(get_post_meta($post_id, 'property_subunits_master', true));

        print '<div class="print_property_subunits_wrapper">';
            if($has_multi_units==1){
                print '<h2 class="print_header">'.__('Available Units','wpestate').'</h2>';
                wpestate_shortcode_multi_units($post_id,$property_subunits_master,1);
            }else{
                if($property_subunits_master!=0){
                    wpestate_shortcode_multi_units($post_id,$property_subunits_master,1);
                }
            }
        print '</div>';
    }
   
 
    if( $print_show_agent == 'yes'){    
  

        print '<h2 class="print_header">'.__('Agent','wpestate').'</h2>';
        if ( $preview_img!='' ){
            print '<div class="print-col-img agent_print_image"><img src="'.$preview_img.'"></div>';
        }
        print '<div class="print_agent_wrapper">';
            if ($name!='')
                print '<div class="listing_detail_agent col-md-4 agent_name"><strong>'.__('Name','wpestate').':</strong> '.$name.'</div>';
            if($agent_phone!='')
                print '<div class="listing_detail_agent col-md-4"><strong>'.__('Telephone','wpestate').':</strong> '.$agent_phone.'</div>';
            if($agent_mobile!='')
                print '<div class="listing_detail_agent col-md-4"><strong>'.__('Mobile','wpestate').':</strong> '.$agent_mobile.'</div>';
            if($agent_skype!='')
                print '<div class="listing_detail_agent col-md-4"><strong>'.__('Skype','wpestate').':</strong> '.$agent_skype.'</div>';
            if($agent_email!='')
                print '<div class="listing_detail_agent col-md-4"><strong>'.__('Email','wpestate').':</strong> '.$agent_email.'</div>';
        print '</div>';
        print '</div>';
        print '<div class="printbreak"></div>';
    }
  
    if( $print_show_description == 'yes' ){ 
        print '<h2 class="print_header">'.__('Property Description','wpestate').'</h2><div class="print-content">'.$content.energy_save_features($post_id).'</div></div>';
    }
      
    if($print_show_adress  == 'yes' ){ 
        print '<h2 class="print_header">';
            if($property_adr_text!=''){
                echo esc_html($property_adr_text);
            } else{
                _e('Property Address','wpestate');
            }        
        print '</h2>';

      
        print estate_listing_address_print($post_id); 
    }   
    
    if($print_show_details == 'yes' ){ 
        print '<h2 class="print_header">';
            if($property_adr_text!=''){
                echo esc_html($property_details_text);
            } else{
                _e('Property Details','wpestate');
            }   
        print '</h2>';
        print estate_listing_details($post_id);
    }
    
    if($print_show_features == 'yes'){ 
        print '<h2 class="print_header">';
            if($property_adr_text!=''){
                echo esc_html($property_features_text);
            } else{
                _e('Features and Amenities','wpestate');
            }
        print '</h2>';
        print estate_listing_features($post_id,3,1);
    }
    
    if($print_show_floor_plans  == 'yes' ){ 
        print '<h2 class="print_header">'.__('Floor Plans','wpestate').'</h2>';   
        estate_floor_plan($post_id,1);
        print '<div class="printbreak"></div>';
    }
    
    if($print_show_images  == 'yes' ){ 
        print '<h2 class="print_header">'.__('Images','wpestate').'</h2>';                   
        foreach ($post_attachments as $attachment) {
            $original       =   wp_get_attachment_image_src($attachment->ID, 'full');
             print '<div class="print-col-img printimg"><img src="'. $original[0].'"></div>';
        }
    }
  
    print '<div class="print_spacer"></div>';
    print '</body></html>';die();
  } 

endif;

                







////////////////////////////////////////////////////////////////////////////////
/// delete search function
////////////////////////////////////////////////////////////////////////////////

add_action( 'wp_ajax_wpestate_delete_search', 'wpestate_delete_search' );
if( !function_exists('wpestate_delete_search') ):
    
function wpestate_delete_search(){
    $current_user           = wp_get_current_user();
    $userID                 =   $current_user->ID;

    if ( !is_user_logged_in() ) {   
        exit('ko');
    }
    if($userID === 0 ){
        exit('out pls');
    }


        
   
    if( isset( $_POST['search_id'] ) ) {
        if( !is_numeric($_POST['search_id'] ) ){
            exit('you don\'t have the right to delete this');
        }else{
            $delete_id  =   intval($_POST['search_id'] );
            $the_post   =   get_post( $delete_id); 
            if( $current_user->ID != $the_post->post_author ) {
                _e("you don't have the right to delete this","wpestate");
                die();
            }else{
                echo "deleted";
                wp_delete_post( $delete_id );
                die();
            }  

        }
    }
    
}  
    
endif;

////////////////////////////////////////////////////////////////////////////////
/// save search function
////////////////////////////////////////////////////////////////////////////////


add_action( 'wp_ajax_wpestate_save_search_function', 'wpestate_save_search_function' );

if( !function_exists('wpestate_save_search_function') ):
    function wpestate_save_search_function(){
        $current_user   =   wp_get_current_user();
        $userID         =   $current_user->ID;
        $userEmail      =   $current_user->user_email;
        
        if ( !wp_verify_nonce( $_POST['nonce'], 'save_search_nonce')) {
            exit("No naughty business please");
        }   
        $allowed_html   =   array();
        
        
        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }

        
     
        $search_name    =   sanitize_text_field( wp_kses(    $_POST['search_name'],$allowed_html ) );
        $search         =   sanitize_text_field( wp_kses(    $_POST['search'],$allowed_html  ) );
        $meta           =   sanitize_text_field( wp_kses(    $_POST['meta'],$allowed_html  ) );
        
        $new_post = array(
            'post_title'    =>  $search_name,
            'post_author'   =>  $userID,
            'post_type'     =>  'wpestate_search',
    
            );
        $post_id = wp_insert_post($new_post);
        update_post_meta($post_id, 'search_arguments', $search);
        update_post_meta($post_id, 'meta_arguments', $meta);
        update_post_meta($post_id, 'user_email', $userEmail);
        print __('Search has been saved. You will receive an email notification when new properties matching your search have been published','wpestate');
        die();
    
    }
endif;    



////////////////////////////////////////////////////////////////////////////////
/// Ajax  Register function
////////////////////////////////////////////////////////////////////////////////

//add_action( 'wp_ajax_nopriv_wpestate_update_menu_bar', 'wpestate_update_menu_bar' );  
add_action( 'wp_ajax_wpestate_update_menu_bar', 'wpestate_update_menu_bar' );

if( !function_exists('wpestate_update_menu_bar') ):
    function wpestate_update_menu_bar(){

        $user_id    = intval ( $_POST['newuser'] );
  
        if ($user_id!=0 && $user_id!=''){
            
            $add_link               =   wpestate_get_template_link('user_dashboard_add.php');
            $dash_profile           =   wpestate_get_template_link('user_dashboard_profile.php');
            $dash_favorite          =   wpestate_get_template_link('user_dashboard_favorite.php');
            $dash_link              =   wpestate_get_template_link('user_dashboard.php');
            $dash_invoices          =   wpestate_get_template_link('user_dashboard_invoices.php');
            $dash_searches          =   wpestate_get_template_link('user_dashboard_searches.php');
            $dash_inbox             =   wpestate_get_template_link('user_dashboard_inbox.php');
            $no_unread              =   intval(get_user_meta($user_id,'unread_mess',true));
            if( $no_unread>0 ){
                $no_unread= '<div class="unread_mess">'.$no_unread.'</div>';
            }
            
            
            $menu='
            <ul id="user_menu_open" class="dropdown-menu menulist topmenux" role="menu" aria-labelledby="user_menu_trigger">     
                <li role="presentation"><a role="menuitem" tabindex="-1" href="'.$dash_profile.'"  class="active_profile"><i class="fa fa-cog"></i>'.__('My Profile','wpestate').'</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="'.$dash_link.'"     class="active_dash"><i class="fa fa-map-marker"></i>'.__('My Properties List','wpestate').'</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="'.$add_link.'"      class="active_add"><i class="fa fa-plus"></i>'.__('Add New Property','wpestate').'</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="'.$dash_favorite.'" class="active_fav"><i class="fa fa-heart"></i>'.__('Favorites','wpestate').'</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="'.$dash_searches.'" class="active_fav"><i class="fa fa-search"></i>'. __('Saved Searches','wpestate').'</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="'.$dash_invoices.'" class="active_fav"><i class="fa fa-file-text-o"></i>'.__('My Invoices','wpestate').'</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="'.$dash_inbox.'" class="active_fav"><i class="fa fa-envelope-o"></i>'.__('Inbox','wpestate').'</a>';
               
                    if  ($no_unread>0){
                        $menu.='<div class="unread_mess">'.$no_unread.'</div>';
                    }
                
                $menu.='</li>
                <li role="presentation" class="divider"></li>
                <li role="presentation"><a href="'. wp_logout_url( home_url()).'" title="Logout" class="menulogout"><i class="fa fa-power-off"></i>'.__('Log Out','wpestate').'</a></li>
            </ul>';
            
            $user_small_picture_id      =   get_the_author_meta( 'small_custom_picture' , $user_id,true  );
            if( $user_small_picture_id == '' ){
                $user_small_picture=get_template_directory_uri().'/img/default-user.png';
            }else{
                $user_small_picture=wp_get_attachment_image_src($user_small_picture_id,'user_thumb');
            }
            
            echo json_encode(array('picture'=>$user_small_picture[0], 'menu'=>$menu,'nonce_contact'=>wp_create_nonce( 'ajax-property-contact' )));    
        }
        die();
    }
endif;

////////////////////////////////////////////////////////////////////////////////
/// New user notification
////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_wp_new_user_notification') ):

function wpestate_wp_new_user_notification( $user_id, $plaintext_pass = '' ) {

		$user = new WP_User( $user_id );

		$user_login = stripslashes( $user->user_login );
		$user_email = stripslashes( $user->user_email );
                
                $arguments=array(
                    'user_login_register'      =>  $user_login,
                    'user_email_register'      =>  $user_email
                );
                
                wpestate_select_email_type(get_option('admin_email'),'admin_new_user',$arguments);
                
                
                
                
		if ( empty( $plaintext_pass ) )
			return;

                 $arguments=array(
                    'user_login_register'      =>  $user_login,
                    'user_email_register'      =>  $user_email,
                    'user_pass_register'       => $plaintext_pass
                );
                wpestate_select_email_type($user_email,'new_user',$arguments);
                
	}
        
 endif; // end   wpestate_wp_new_user_notification        
        
 
 
////////////////////////////////////////////////////////////////////////////////
/// Ajax  Register function Topbar
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_wpestate_ajax_register_user', 'wpestate_ajax_register_user' );  
add_action( 'wp_ajax_wpestate_ajax_register_user', 'wpestate_ajax_register_user' );

if( !function_exists('wpestate_ajax_register_user') ):
   
function wpestate_ajax_register_user(){
        $type       =   intval( $_POST['type'] );
        $capthca    =   sanitize_text_field ( $_POST['capthca'] );
        
        if( get_option('wp_estate_use_captcha','')=='yes'){
            if(!isset($_POST['capthca']) || $_POST['capthca']==''){
                exit( __('wrong captcha','wpestate') );
            }

            $secret    = get_option('wp_estate_recaptha_secretkey','');
            $response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']), true);

            if ($response['success'] = false) {
                exit('out pls captcha');
            }
        }
        
      
        $allowed_html               =   array();
        $user_email                 =   trim( sanitize_text_field(wp_kses( $_POST['user_email_register'] ,$allowed_html) ) );
        $user_name                  =   trim( sanitize_text_field(wp_kses( $_POST['user_login_register'] ,$allowed_html) ) );
        $enable_user_pass_status    =   esc_html ( get_option('wp_estate_enable_user_pass','') );
        
        $new_user_type              =   intval($_POST['new_user_type']);
      
        
        if (preg_match("/^[0-9A-Za-z_]+$/", $user_name) == 0) {
            print __('Invalid username (do not use special characters or spaces)!','wpestate');
            die();
        }
        
        if ($user_email=='' || $user_name=='' ){
            print __('Username and/or Email field is empty!','wpestate');
            exit();
        }
        
        if(filter_var($user_email,FILTER_VALIDATE_EMAIL) === false) {
            print __('The email doesn\'t look right !','wpestate');
            exit();
        }
        
        $domain = mb_substr(strrchr($user_email, "@"), 1);
        if( !checkdnsrr ($domain) ){
            print __('The email\'s domain doesn\'t look right.','wpestate');
            exit();
        }
        
        
        $user_id     =   username_exists( $user_name );
        if ($user_id){
            print __('Username already exists.  Please choose a new one.','wpestate');
            exit();
        }
        
        if($enable_user_pass_status=='yes' ){
            $user_pass              =   trim( sanitize_text_field(wp_kses( $_POST['user_pass'] ,$allowed_html) ) );
            $user_pass_retype       =   trim( sanitize_text_field(wp_kses( $_POST['user_pass_retype'] ,$allowed_html) ) );
        
            if ($user_pass=='' || $user_pass_retype=='' ){
                print __('One of the password field is empty!','wpestate');
                exit();
            }
            
            if ($user_pass !== $user_pass_retype ){
                print __('Passwords do not match','wpestate');
                exit();
            }
        }
         
 
         
        if ( !$user_id and email_exists($user_email) == false ) {
            if($enable_user_pass_status=='yes' ){
                $user_password = $user_pass; // no so random now!
            }else{
                $user_password = wp_generate_password( $length=12, $include_standard_special_chars=false );
            }
            
            $user_id         = wp_create_user( $user_name, $user_password, $user_email );
         
            if ( is_wp_error($user_id) ){
        
            }else{
                if($enable_user_pass_status=='yes' ){
                    print __('Your account was created and you can login now!','wpestate');
                }else{
                    print __('An email with the generated password was sent!','wpestate');
                }
                  
                wpestate_update_profile($user_id);
                wpestate_wp_new_user_notification( $user_id, $user_password ) ;
                update_user_meta( $user_id, 'user_estate_role', $new_user_type) ;
             
                if($new_user_type!==0 && $new_user_type!==1 ){  
                    wpestate_register_as_user($user_name,$user_id,$new_user_type);
                }
             }
             
        } else {
           print __('Email already exists.  Please choose a new one.','wpestate');
        }
        die(); 
              
}

endif; // end   ajax_register_form 

 

 //array( __('User','wpestate') ,__('Agent','wpestate'),__('Agency','wpestate'),__('Developer','wpestate'));
////////////////////////////////////////////////////////////////////////////////
/// register as agent
////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_register_as_user') ):
    function  wpestate_register_as_user($user_name,$user_id,$new_user_type=0,$first_name='',$last_name=''){
        $post_type  =   '';
        $app_type   =   '';
        if($new_user_type==2){
            $post_type = 'estate_agent'; 
            $app_type   =__('Agent','wpestate');
        }else if($new_user_type==3){
            $post_type = 'estate_agency'; 
            $app_type   =__('Agency','wpestate');
        }else if($new_user_type==4){
            $post_type = 'estate_developer';
            $app_type   =__('Developer','wpestate');
        }
        $admin_submission_user_role = get_option('wp_estate_admin_submission_user_role',true);
    
        
        
        $post_approve = 'publish';
        if(in_array($app_type, $admin_submission_user_role)){
            $post_approve = 'pending';  
        }
        
        
        if($post_type!=''){
            $post = array(
              'post_title'      => $user_name,
              'post_status'     => $post_approve, 
              'post_type'       => $post_type ,
            );
            $post_id =  wp_insert_post($post );  
            update_post_meta($post_id, 'user_meda_id', $user_id);
            update_user_meta($user_id, 'user_agent_id', $post_id);
        }

     
       
        $user_email             =   get_the_author_meta( 'user_email' , $user_id );
         
        if($post_type!=''){
            update_post_meta($post_id, 'agent_email',   $user_email);
        }
          
        if($first_name!=''){
            update_user_meta( $user_id, 'first_name' , $first_name) ; 
        }
        if($last_name!=''){
            update_user_meta( $user_id, 'last_name' , $last_name) ; 
        }
     }
 endif;
////////////////////////////////////////////////////////////////////////////////
/// Ajax  Login function
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_ajax_loginx_form_topbar', 'ajax_loginx_form_topbar' );  
add_action( 'wp_ajax_ajax_loginx_form_topbar', 'ajax_loginx_form_topbar' );  

if( !function_exists('ajax_loginx_form_topbar') ):

function ajax_loginx_form_topbar(){
        if ( is_user_logged_in() ) { 
            echo json_encode(array('loggedin'=>true, 'message'=>__('You are already logged in! redirecting...','wpestate')));   
            exit();
        } 
     
        $allowed_html   =   array();
        $login_user     =  sanitize_text_field ( wp_kses ( $_POST['login_user'], $allowed_html)) ;
        $login_pwd      =  sanitize_text_field ( wp_kses ( $_POST['login_pwd'] , $allowed_html)) ;
        $ispop          =  intval ( $_POST['ispop'] );
       
        if ($login_user=='' || $login_pwd==''){      
            echo json_encode(array('loggedin'=>false, 'message'=>__('Username and/or Password field is empty!','wpestate')));   
            exit();
        }
        
        $vsessionid = session_id();
        if (empty($vsessionid)) {
            session_name('PHPSESSID'); 
            session_start();
        }


        wp_clear_auth_cookie();
        $info                   =   array();
        $info['user_login']     =   $login_user;
        $info['user_password']  =   $login_pwd;
        $info['remember']       =   false;
        $user_signon            =   wp_signon( $info, true );
      
        
        if ( is_wp_error($user_signon) ){
            echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password!','wpestate')));       
        } else {
            wp_set_current_user($user_signon->ID);
            do_action('set_current_user');
            global $current_user;
            $current_user = wp_get_current_user();
            echo json_encode(array('loggedin'=>true,'ispop'=>$ispop,'newuser'=>$user_signon->ID, 'message'=>__('Login successful, redirecting...','wpestate')));
            wpestate_update_old_users($user_signon->ID);
        }
        
        
     
           
            
            
             
        die();       
}
endif; // end   ajax_loginx_form 




add_action( 'wp_ajax_nopriv_wpestate_ajax_loginx_form_mobile', 'wpestate_ajax_loginx_form_mobile' );  
add_action( 'wp_ajax_wpestate_ajax_loginx_form_mobile', 'wpestate_ajax_loginx_form_mobile' );  

if( !function_exists('wpestate_ajax_loginx_form_mobile') ):

function wpestate_ajax_loginx_form_mobile(){
        if ( is_user_logged_in() ) { 
            echo json_encode(array('loggedin'=>true, 'message'=>__('You are already logged in! redirecting...','wpestate')));   
            exit();
        } 
        //check_ajax_referer( 'login_ajax_nonce_mobile', 'security' );
        if( !estate_verify_onetime_nonce_login($_POST['security'], 'login_ajax_nonce_mobile') ){
            //echo json_encode(array('loggedin'=>false, 'message'=>__('You are not submiting from site or you have too many atempts!','wpestate'))); 
            //exit();
        }
        
        $allowed_html   =   array();
        $login_user     =   sanitize_text_field ( wp_kses ( $_POST['login_user'], $allowed_html) );
        $login_pwd      =   sanitize_text_field ( wp_kses ( $_POST['login_pwd'] , $allowed_html) );
       
       
        if ($login_user=='' || $login_pwd==''){      
            echo json_encode(array('loggedin'=>false, 'message'=>__('Username and/or Password field is empty!','wpestate')));   
            exit();
        }
        
        $vsessionid = session_id();
        if (empty($vsessionid)) {
            session_name('PHPSESSID'); 
            session_start();       
        }


        wp_clear_auth_cookie();
        $info                   = array();
        $info['user_login']     = $login_user;
        $info['user_password']  = $login_pwd;
        $info['remember']       = false;
     
        $user_signon            = wp_signon( $info, true );
      
        
        if ( is_wp_error($user_signon) ){
            echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password!','wpestate')));       
        } else {
            wp_set_current_user($user_signon->ID);
            do_action('set_current_user');
            global $current_user;
            $current_user = wp_get_current_user();
            echo json_encode(array('loggedin'=>true,'newuser'=>$user_signon->ID, 'message'=>__('Login successful, redirecting...','wpestate')));
            wpestate_update_old_users($user_signon->ID);
        }
        die(); 
              
}
endif; // end   ajax_loginx_form 

////////////////////////////////////////////////////////////////////////////////
/// Ajax  Login function
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_ajax_loginx_form', 'ajax_loginx_form' );  
add_action( 'wp_ajax_ajax_loginx_form', 'ajax_loginx_form' );  

if( !function_exists('ajax_loginx_form') ):

function ajax_loginx_form(){
        if ( is_user_logged_in() ) { 
            echo json_encode(array('loggedin'=>true, 'message'=>__('You are already logged in! redirecting...','wpestate')));   
            exit();
        } 
        //check_ajax_referer( 'login_ajax_nonce', 'security-login' );
        //check_ajax_referer( 'login_ajax_nonce_mobile', 'security' );
        if( !estate_verify_onetime_nonce_login($_POST['security-login'], 'login_ajax_nonce') ){
            //echo json_encode(array('loggedin'=>false, 'message'=>__('You are not submiting from site or you have too many atempts!','wpestate'))); 
           // exit();
        }
        
        $allowed_html   =   array();
        $login_user  =  wp_kses ( $_POST['login_user'],$allowed_html ) ;
        $login_pwd   =  wp_kses ( $_POST['login_pwd'], $allowed_html) ;
        $ispop       =  intval ( $_POST['ispop'] );
       
        if ($login_user=='' || $login_pwd==''){      
          echo json_encode(array('loggedin'=>false, 'message'=>__('Username and/or Password field is empty!','wpestate')));   
          exit();
        }
        wp_clear_auth_cookie();
        $info                   = array();
        $info['user_login']     = $login_user;
        $info['user_password']  = $login_pwd;
        $info['remember']       = true;
        $user_signon            = wp_signon( $info, true );
      
   
         if ( is_wp_error($user_signon) ){
             echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password!','wpestate')));       
        } else {
            global $current_user;
            wp_set_current_user($user_signon->ID);
            do_action('set_current_user');
            $current_user = wp_get_current_user();
            
            
            echo json_encode(array('loggedin'=>true,'ispop'=>$ispop,'newuser'=>$user_signon->ID, 'message'=>__('Login successful, redirecting...','wpestate')));
            wpestate_update_old_users($user_signon->ID);
        }
        die(); 
              
}
endif; // end   ajax_loginx_form 



////////////////////////////////////////////////////////////////////////////////
/// Ajax  Forgot Pass function
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_wpestate_ajax_forgot_pass', 'wpestate_ajax_forgot_pass' );  
add_action( 'wp_ajax_wpestate_ajax_forgot_pass', 'wpestate_ajax_forgot_pass' );  

if( !function_exists('wpestate_ajax_forgot_pass') ):
   
function wpestate_ajax_forgot_pass(){
    global $wpdb;

    //    check_ajax_referer( 'login_ajax_nonce', 'security-forgot' );
    $allowed_html   =   array();
    $post_id        =   intval( $_POST['postid'] ) ;
    $forgot_email   =   sanitize_text_field( wp_kses( $_POST['forgot_email'],$allowed_html ) );
    $type           =   intval($_POST['type']);
       
    if($type==1){
        check_ajax_referer( 'forgot_ajax_nonce',  'security-forgot' );
    }
    if($type==2){
        check_ajax_referer( 'forgot_ajax_nonce-topbar',  'security-forgot' );
    }
    if($type==3){
        check_ajax_referer( 'login_ajax_nonce_forgot_wd', 'security-forgot');
    }
    if($type==5){
         check_ajax_referer( 'forgot_ajax_nonce-mobile',  'security-forgot' );
    }
        
    if ($forgot_email==''){      
        echo __('Email field is empty!','wpestate');   
        exit();
    }

    //We shall SQL escape the input
    $user_input = trim($forgot_email);
 
        if ( strpos($user_input, '@') ) {
                $user_data = get_user_by( 'email', $user_input );
                if(empty($user_data) || isset( $user_data->caps['administrator'] ) ) {
                    echo __('Invalid E-mail address!','wpestate');
                    exit();
                }
                            
        }
        else {
            $user_data = get_user_by( 'login', $user_input );
            if( empty($user_data) || isset( $user_data->caps['administrator'] ) ) {
               echo __('Invalid Username!','wpestate');
               exit();
            }
        }
        $user_login = $user_data->user_login;
        $user_email = $user_data->user_email;

 
        $key = $wpdb->get_var($wpdb->prepare("SELECT user_activation_key FROM $wpdb->users WHERE user_login = %s", $user_login));
        if(empty($key)) {
                //generate reset key
                $key = wp_generate_password(20, false);
                $wpdb->update($wpdb->users, array('user_activation_key' => $key), array('user_login' => $user_login));
        }
 
        //emailing password change request details to the user
        $headers = 'From: No Reply <noreply@'.$_SERVER['HTTP_HOST'].'>' . "\r\n";
        $arguments=array(
            'reset_link'        =>  wpestate_tg_validate_url($post_id,$type) . "action=reset_pwd&key=$key&login=" . rawurlencode($user_login)
        );
        wpestate_select_email_type($user_email,'password_reset_request',$arguments);

        echo '<div>'.__('We have just sent you an email with Password reset instructions.','wpestate').'</div>';
        die(); 
              
}
endif; // end   wpestate_ajax_forgot_pass 


if( !function_exists('wpestate_tg_validate_url') ):

function wpestate_tg_validate_url($post_id,$type) {
       
    $page_url = home_url();     
    $urlget = strpos($page_url, "?");
    if ($urlget === false) {
            $concate = "?";
    } else {
            $concate = "&";
    }
    return $page_url.$concate;
}

endif; // end   wpestate_tg_validate_url 


////////////////////////////////////////////////////////////////////////////////
/// Ajax  register agent
////////////////////////////////////////////////////////////////////////////////

add_action( 'wp_ajax_wpestate_ajax_register_agent', 'wpestate_ajax_register_agent' );  
if( !function_exists('wpestate_ajax_register_agent') ):
   
   function wpestate_ajax_register_agent(){
	   
	   error_reporting(E_ALL);
	   
		$allowed_html       =   array();
        $current_user           =   wp_get_current_user();
        $userID                 =   $current_user->ID;
        $user_login             =   $current_user->user_login;
        check_ajax_referer( 'profile_ajax_nonce', 'security-profile' );
        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }
        $user_role = get_user_meta( $current_user->ID, 'user_estate_role', true) ;
        if($user_role!=3 && $user_role !=4){
            exit;
        }
        
        $user_email                 =   trim( sanitize_text_field(wp_kses( $_POST['useremail'] ,$allowed_html) ) );
        $user_name                  =   trim( sanitize_text_field(wp_kses( $_POST['agent_username'] ,$allowed_html) ) );
        $firstname                  =   sanitize_text_field ( wp_kses( $_POST['firstname'] ,$allowed_html) );
        $secondname                 =   sanitize_text_field ( wp_kses( $_POST['secondname'] ,$allowed_html) );
        $new_user_type              =   2;//agent
        $errors                     =   array();
        $is_agent_edit              =   intval($_POST['agentedit']);
        $user_id                    =   intval($_POST['userid']);
        $agent_id                   =   intval($_POST['agentid']);
        
        if( $is_agent_edit!=1){
            
            if (preg_match("/^[0-9A-Za-z_]+$/", $user_name) == 0) {
                $errors[]= __('Invalid username (do not use special characters or spaces)!','wpestate');
            }
            
            if ($user_email=='' || $user_name=='' ){
                $errors[]= __('Username and/or Email field is empty!','wpestate');
            }
            
            $user_id     =   username_exists( $user_name );
            if ($user_id){
                $errors[]= __('Username already exists.  Please choose a new one.','wpestate');
            }
            
            $user_pass              =   trim( sanitize_text_field(wp_kses( $_POST['agent_password'] ,$allowed_html) ) );
            $user_pass_retype       =   trim( sanitize_text_field(wp_kses( $_POST['agent_repassword'] ,$allowed_html) ) );

            if ($user_pass=='' || $user_pass_retype=='' ){
                $errors[]= __('One of the password field is empty!','wpestate');
            }

            if ($user_pass !== $user_pass_retype ){
                $errors[]= __('Passwords do not match','wpestate');
            }

            if( email_exists($user_email) ){
                $errors[]= __('Email already exists.  Please choose a new one.','wpestate');
            }
        }
         
        if( $is_agent_edit==1){
            if ($user_email==''  ){
                $errors[]= __('Username and/or Email field is empty!','wpestate');
            }
            if( $user_email != get_post_meta($agent_id, 'agent_email', true) ){
                if( email_exists($user_email) ){
                    $errors[]= __('Email already exists.  Please choose a new one.','wpestate');
                }
            }
        }
        
        if($firstname=='' && $secondname==''){
            $errors[]= __('Agent need a first & last name','wpestate');
        }
       
        
        if(filter_var($user_email,FILTER_VALIDATE_EMAIL) === false) {
            $errors[]= __('The email doesn\'t look right !','wpestate');
        }
        
        $domain = mb_substr(strrchr($user_email, "@"), 1);
        if( !checkdnsrr ($domain) ){
            $errors[]=  __('The email\'s domain doesn\'t look right.','wpestate');
        }
        
        
       
        

       
        
        
        if( !empty($errors) ){
            $erros_mess =   '';
            foreach($errors as $key=>$text){
                $erros_mess .= $text.'</br>';
            }
            print json_encode(array ('added'=>false, 'mesaj'=>$erros_mess ));
            die();
        }
 
        if($is_agent_edit!=1){
            $new_user_id    =   wp_create_user( $user_name, $user_pass, $user_email );
        }else{
            $new_user_id    =   $user_id;
        }
        
       
        
        
        
        $allowed_html               =   array('</br>');
        $firstname                  =   sanitize_text_field ( wp_kses( $_POST['firstname'] ,$allowed_html) );
        $secondname                 =   sanitize_text_field ( wp_kses( $_POST['secondname'] ,$allowed_html) );
        $useremail                  =   sanitize_text_field ( wp_kses( $_POST['useremail'] ,$allowed_html) );
        $userphone                  =   sanitize_text_field ( wp_kses( $_POST['userphone'] ,$allowed_html) );
        $usermobile                 =   sanitize_text_field ( wp_kses( $_POST['usermobile'] ,$allowed_html) );
        $userskype                  =   sanitize_text_field ( wp_kses( $_POST['userskype'] ,$allowed_html) );
        $usertitle                  =   sanitize_text_field ( wp_kses( $_POST['usertitle'] ,$allowed_html) );
        $about_me                   =   wp_kses( $_POST['description'],$allowed_html );
        $profile_image_url_small    =   sanitize_text_field ( wp_kses($_POST['profile_image_url_small'],$allowed_html) );
        $profile_image_url          =   sanitize_text_field ( wp_kses($_POST['profile_image_url'],$allowed_html) );       
        $userfacebook               =   sanitize_text_field ( wp_kses( $_POST['userfacebook'],$allowed_html) );
        $usertwitter                =   sanitize_text_field ( wp_kses( $_POST['usertwitter'],$allowed_html) );
        $userlinkedin               =   sanitize_text_field ( wp_kses( $_POST['userlinkedin'],$allowed_html) );
        $userpinterest              =   sanitize_text_field ( wp_kses( $_POST['userpinterest'],$allowed_html ) );
        $userinstagram              =   sanitize_text_field ( wp_kses( $_POST['userinstagram'],$allowed_html ) );
		 
	 
		$agent_custom_label          =   $_POST['agent_custom_label'];
		$agent_custom_value          =   $_POST['agent_custom_value'];
	 
		// prcess fields data
		$agent_fields_array = array();
		for( $i=1; $i<count( $agent_custom_label  ); $i++ ){
			$agent_fields_array[] = array( 'label' => sanitize_text_field( $agent_custom_label[$i] ), 'value' => sanitize_text_field( $agent_custom_value[$i] ) );
		}
  
        $userurl                    =   sanitize_text_field ( wp_kses( $_POST['userurl'],$allowed_html ) );
        $agent_category_submit      =   sanitize_text_field ( wp_kses( $_POST['agent_category_submit'],$allowed_html ) );
        $agent_action_submit        =   sanitize_text_field ( wp_kses( $_POST['agent_action_submit'],$allowed_html ) );
        $agent_city                 =   sanitize_text_field ( wp_kses( $_POST['agent_city'],$allowed_html ) );
        $agent_county               =   sanitize_text_field ( wp_kses( $_POST['agent_county'],$allowed_html ) );
        $agent_area                 =   sanitize_text_field ( wp_kses( $_POST['agent_area'],$allowed_html ) );
        $agent_member               =   sanitize_text_field ( wp_kses( $_POST['agent_member'],$allowed_html ) ); 
       
        update_user_meta( $new_user_id, 'first_name', $firstname ) ;
        update_user_meta( $new_user_id, 'last_name',  $secondname) ;
        update_user_meta( $new_user_id, 'phone' , $userphone) ;
        update_user_meta( $new_user_id, 'skype' , $userskype) ;
        update_user_meta( $new_user_id, 'title', $usertitle) ;
        update_user_meta( $new_user_id, 'custom_picture',$profile_image_url);
        update_user_meta( $new_user_id, 'small_custom_picture',$profile_image_url_small);     
        update_user_meta( $new_user_id, 'mobile' , $usermobile) ;
        update_user_meta( $new_user_id, 'facebook' , $userfacebook) ;
        update_user_meta( $new_user_id, 'twitter' , $usertwitter) ;
        
		
		update_user_meta( $new_user_id, 'agent_custom_data' , $agent_fields_array) ;
	 
        
        update_user_meta( $new_user_id, 'linkedin' , $userlinkedin) ;
        update_user_meta( $new_user_id, 'pinterest' , $userpinterest) ;
        update_user_meta( $new_user_id, 'instagram' , $userinstagram) ;
//        update_user_meta( $new_user_id, 'description' , $about_me) ;
        update_user_meta( $new_user_id, 'website' , $userurl) ;
        update_user_meta( $new_user_id, 'user_estate_role', 2) ;
        update_user_meta( $new_user_id, 'agent_member' , $agent_member) ;
 
 
        if($is_agent_edit!=1){
            $post = array(
                'post_title'        => $firstname.' '.$secondname,
                'post_status'       => 'publish', 
                'post_type'         => 'estate_agent' ,
                'author'            => $userID ,
                'post_content'      =>  $about_me
            );

            $new_agent_id =  wp_insert_post($post );  
            update_post_meta( $new_agent_id, 'user_meda_id', $new_user_id);
            update_user_meta( $new_user_id, 'user_agent_id', $new_agent_id);
            
            $current_agent_list = (array)get_user_meta($userID,'current_agent_list',true);
            if(!is_array($current_agent_list)){
                $current_agent_list = array();
            }
            $current_agent_list[]=$new_user_id;
            update_user_meta( $userID, 'current_agent_list',array_unique( $current_agent_list) );
        }else{
            $post = array(
                'ID'                =>  $agent_id,
                'post_title'        =>  $firstname.' '.$secondname,
                'post_content'      =>  $about_me
            );
            wp_update_post( $post );
            $new_agent_id   =   $agent_id;
        }
   
		update_post_meta($new_agent_id, 'agent_custom_data',   $agent_fields_array);
	 
        update_post_meta($new_agent_id, 'first_name',   $firstname);
        update_post_meta($new_agent_id, 'last_name',   $secondname);
        update_post_meta($new_agent_id, 'agent_email',   $useremail);
        update_post_meta($new_agent_id, 'agent_phone',   $userphone);
        update_post_meta($new_agent_id, 'agent_mobile',  $usermobile);
        update_post_meta($new_agent_id, 'agent_skype',   $userskype);
        update_post_meta($new_agent_id, 'agent_position',  $usertitle);
        update_post_meta($new_agent_id, 'agent_facebook',   $userfacebook);
        update_post_meta($new_agent_id, 'agent_twitter',   $usertwitter);
        update_post_meta($new_agent_id, 'agent_linkedin',   $userlinkedin);
        update_post_meta($new_agent_id, 'agent_pinterest',   $userpinterest);
        update_post_meta($new_agent_id, 'agent_instagram',   $userinstagram);
        update_post_meta($new_agent_id, 'agent_website',   $userurl);
        update_post_meta($new_agent_id, 'agent_member',   $agent_member);
        set_post_thumbnail($new_agent_id, $profile_image_url_small );


        $agent_category           =   get_term( $agent_category_submit, 'property_category_agent');     
        if(isset($agent_category->term_id)){
            $agent_category_submit  =   $agent_category->name;
        }else{
            $agent_category_submit=-1;
        }

        if( isset($agent_category_submit) && $agent_category_submit!='none' ){
            wp_set_object_terms($new_agent_id,$agent_category_submit,'property_category_agent'); 
        }  

        //---

        $agent_category           =   get_term( $agent_action_submit, 'property_action_category_agent');     
        if(isset($agent_category->term_id)){
            $agent_action_submit  =   $agent_category->name;
        }else{
            $agent_action_submit=-1;
        }

        if( isset($agent_action_submit) && $agent_action_submit!='none' ){
            wp_set_object_terms($new_agent_id,$agent_action_submit,'property_action_category_agent'); 
        }  


        if( isset($agent_city) && $agent_city!='none' ){
            wp_set_object_terms($new_agent_id,$agent_city,'property_city_agent'); 
        }  

        if( isset($agent_county) && $agent_county!='none' ){
            wp_set_object_terms($new_agent_id,$agent_county,'property_county_state_agent'); 
        }  

        if( isset($agent_area) && $agent_area!='none' ){
            wp_set_object_terms($new_agent_id,$agent_area,'property_area_agent'); 
        }  

        if( empty($errors) && $is_agent_edit!=1 ){
            /// to do
            $arguments=array(
                'user_profile'      =>  $user_name,
            );
            wpestate_select_email_type(get_option('admin_email'),'agent_added',$arguments);
            echo json_encode(array('added'=>true, 'mesaj'=> __('Agent was added... You will be redirected to your agent list...','wpestate') ));
        }else{
            $arguments=array(
                'user_profile'      =>  $user_name,
            );
            wpestate_select_email_type(get_option('admin_email'),'agent_update_profile',$arguments);
            echo json_encode(array('added'=>true, 'mesaj'=> __('Agent profile edited','wpestate') ));
        }
        
        
        
        
        
        die(); 
        
    
   }
endif; // end   wpestate_ajax_update_profile 
   



////////////////////////////////////////////////////////////////////////////////
/// Ajax  upadte profile
////////////////////////////////////////////////////////////////////////////////
// for user 
add_action( 'wp_ajax_wpestate_ajax_update_profile', 'wpestate_ajax_update_profile' );  
if( !function_exists('wpestate_ajax_update_profile') ):
   
   function wpestate_ajax_update_profile(){
        $current_user           =   wp_get_current_user();
        $userID                 =   $current_user->ID;
        $user_login             =   $current_user->user_login;
        check_ajax_referer( 'profile_ajax_nonce', 'security-profile' );
        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }


        
        $allowed_html               =   array('</br>');
        $firstname                  =   sanitize_text_field ( wp_kses( $_POST['firstname'] ,$allowed_html) );
        $secondname                 =   sanitize_text_field ( wp_kses( $_POST['secondname'] ,$allowed_html) );
        $useremail                  =   sanitize_text_field ( wp_kses( $_POST['useremail'] ,$allowed_html) );
        $userphone                  =   sanitize_text_field ( wp_kses( $_POST['userphone'] ,$allowed_html) );
        $usermobile                 =   sanitize_text_field ( wp_kses( $_POST['usermobile'] ,$allowed_html) );
        $userskype                  =   sanitize_text_field ( wp_kses( $_POST['userskype'] ,$allowed_html) );
        $usertitle                  =   sanitize_text_field ( wp_kses( $_POST['usertitle'] ,$allowed_html) );
        $about_me                   =   wp_kses( $_POST['description'],$allowed_html );
        $profile_image_url_small    =   sanitize_text_field ( wp_kses($_POST['profile_image_url_small'],$allowed_html) );
        $profile_image_url          =   sanitize_text_field ( wp_kses($_POST['profile_image_url'],$allowed_html) );       
        $userfacebook               =   sanitize_text_field ( wp_kses( $_POST['userfacebook'],$allowed_html) );
        $usertwitter                =   sanitize_text_field ( wp_kses( $_POST['usertwitter'],$allowed_html) );
        $userlinkedin               =   sanitize_text_field ( wp_kses( $_POST['userlinkedin'],$allowed_html) );
        $userpinterest              =   sanitize_text_field ( wp_kses( $_POST['userpinterest'],$allowed_html ) );
        $userinstagram              =   sanitize_text_field ( wp_kses( $_POST['userinstagram'],$allowed_html ) );
        $userurl                    =   sanitize_text_field ( wp_kses( $_POST['userurl'],$allowed_html ) );
        $agent_category_submit      =   sanitize_text_field ( wp_kses( $_POST['agent_category_submit'],$allowed_html ) );
        $agent_action_submit        =   sanitize_text_field ( wp_kses( $_POST['agent_action_submit'],$allowed_html ) );
        $agent_city                 =   sanitize_text_field ( wp_kses( $_POST['agent_city'],$allowed_html ) );
        $agent_county               =   sanitize_text_field ( wp_kses( $_POST['agent_county'],$allowed_html ) );
        $agent_area                 =   sanitize_text_field ( wp_kses( $_POST['agent_area'],$allowed_html ) );     
        $agent_member               =   sanitize_text_field ( wp_kses( $_POST['agent_member'],$allowed_html ) );   
        
		$agent_custom_label          =   $_POST['agent_custom_label'];
		$agent_custom_value          =   $_POST['agent_custom_value'];
	 
		// prcess fields data
		$agent_fields_array = array();
		for( $i=1; $i<count( $agent_custom_label  ); $i++ ){
			$agent_fields_array[] = array( 'label' => sanitize_text_field( $agent_custom_label[$i] ), 'value' => sanitize_text_field( $agent_custom_value[$i] ) );
		}
		
		
		
        update_user_meta( $userID, 'first_name', $firstname ) ;
        update_user_meta( $userID, 'last_name',  $secondname) ;
        update_user_meta( $userID, 'phone' , $userphone) ;
        update_user_meta( $userID, 'skype' , $userskype) ;
        update_user_meta( $userID, 'title', $usertitle) ;
        update_user_meta( $userID, 'custom_picture',$profile_image_url);
        update_user_meta( $userID, 'small_custom_picture',$profile_image_url_small);     
        update_user_meta( $userID, 'mobile' , $usermobile) ;
        
        
        
        update_user_meta( $userID, 'facebook' , $userfacebook) ;
        update_user_meta( $userID, 'twitter' , $usertwitter) ;
        update_user_meta( $userID, 'linkedin' , $userlinkedin) ;
        update_user_meta( $userID, 'pinterest' , $userpinterest) ;
        update_user_meta( $userID, 'instagram' , $userinstagram) ;
        update_user_meta( $userID, 'description' , $about_me) ;
        update_user_meta( $userID, 'website' , $userurl) ;
        
        
        
        $agent_id=get_user_meta( $userID, 'user_agent_id',true);
     
	 
		update_post_meta( $agent_id, 'agent_custom_data' , $agent_fields_array) ;
	 
        wpestate_update_user_agent ($agent_member,$agent_category_submit,$agent_action_submit,$agent_city,$agent_county,$agent_area,$userurl,$agent_id, $firstname ,$secondname ,$useremail,$userphone,$userskype,$usertitle,$profile_image_url,$usermobile,$about_me,$profile_image_url_small,$userfacebook,$usertwitter,$userlinkedin,$userpinterest,$userinstagram) ;
       
        
        if( $current_user->user_email != $useremail ) {
            $user_id=email_exists( $useremail ) ;
            if ( $user_id){
                _e('The email was not saved because it is used by another user.</br>','wpestate');
            } else{
                $args = array(
                    'ID'         => $userID,
                    'user_email' => $useremail
                ); 
                wp_update_user( $args );
            } 
        }
        
        $arguments=array(
            'user_profile'      =>  $user_login,
        );

        wpestate_select_email_type(get_option('admin_email'),'agent_update_profile',$arguments);
        _e('Profile updated','wpestate');
        die(); 
   }
endif; // end   wpestate_ajax_update_profile 
   




////////////////////////////////////////////////////////////////////////////////
/// Ajax  upadte profile agency
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_wpestate_ajax_update_profile_agency', 'wpestate_ajax_update_profile_agency' );  
if( !function_exists('wpestate_ajax_update_profile_agency') ):
   
   function wpestate_ajax_update_profile_agency(){
        $current_user           =   wp_get_current_user();
        $userID                 =   $current_user->ID;
        $user_login             =   $current_user->user_login;
        check_ajax_referer( 'profile_ajax_nonce', 'security-profile' );
        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }
        $user_role = intval (get_user_meta( $current_user->ID, 'user_estate_role', true) );
        
        if($user_role!=3){
            exit('not the right role');
        }
        
        $agent_id=get_user_meta( $userID, 'user_agent_id',true);

        
        $allowed_html               =   array('</br>');
        $agency_name                =   sanitize_text_field ( wp_kses( $_POST['agency_name'] ,$allowed_html) );
        $useremail                  =   sanitize_text_field ( wp_kses( $_POST['useremail'] ,$allowed_html) );
        $userphone                  =   sanitize_text_field ( wp_kses( $_POST['userphone'] ,$allowed_html) );
        $usermobile                 =   sanitize_text_field ( wp_kses( $_POST['usermobile'] ,$allowed_html) );
        $userskype                  =   sanitize_text_field ( wp_kses( $_POST['userskype'] ,$allowed_html) );
        $usertitle                  =   sanitize_text_field ( wp_kses( $_POST['usertitle'] ,$allowed_html) );
        $about_me                   =   wp_kses( $_POST['description'],$allowed_html );
        $profile_image_url_small    =   sanitize_text_field ( wp_kses($_POST['profile_image_url_small'],$allowed_html) );
        $profile_image_url          =   sanitize_text_field ( wp_kses($_POST['profile_image_url'],$allowed_html) );       
        $userfacebook               =   sanitize_text_field ( wp_kses( $_POST['userfacebook'],$allowed_html) );
        $usertwitter                =   sanitize_text_field ( wp_kses( $_POST['usertwitter'],$allowed_html) );
        $userlinkedin               =   sanitize_text_field ( wp_kses( $_POST['userlinkedin'],$allowed_html) );
        $userpinterest              =   sanitize_text_field ( wp_kses( $_POST['userpinterest'],$allowed_html ) );
        $userinstagram              =   sanitize_text_field ( wp_kses( $_POST['userinstagram'],$allowed_html ) );
        $userurl                    =   sanitize_text_field ( wp_kses( $_POST['userurl'],$allowed_html ) );         
        $agency_languages           =   sanitize_text_field ( wp_kses( $_POST['agency_languages'],$allowed_html ) );
        $agency_website             =   sanitize_text_field ( wp_kses( $_POST['agency_website'],$allowed_html ) );
        $agency_taxes               =   sanitize_text_field ( wp_kses( $_POST['agency_taxes'],$allowed_html ) );     
        $agency_category_submit     =   sanitize_text_field ( wp_kses( $_POST['agency_category_submit'],$allowed_html ) );
        $agency_action_submit       =   sanitize_text_field ( wp_kses( $_POST['agency_action_submit'],$allowed_html ) );
        $agency_city                =   sanitize_text_field ( wp_kses( $_POST['agency_city'],$allowed_html ) );
        $agency_county              =   sanitize_text_field ( wp_kses( $_POST['agency_county'],$allowed_html ) );
        $agency_area                =   sanitize_text_field ( wp_kses( $_POST['agency_area'],$allowed_html ) );     
        $agency_address             =   sanitize_text_field ( wp_kses( $_POST['agency_address'],$allowed_html ) );
        $agency_lat                 =   sanitize_text_field ( wp_kses( $_POST['agency_lat'],$allowed_html ) );
        $agency_long                =   sanitize_text_field ( wp_kses( $_POST['agency_long'],$allowed_html ) );
        $agency_opening_hours       =   sanitize_text_field ( wp_kses( $_POST['agency_opening_hours'],$allowed_html ) );
        $agent_id=get_user_meta( $userID, 'user_agent_id',true);
       
       
        update_user_meta( $userID, 'custom_picture',$profile_image_url);
        update_user_meta( $userID, 'small_custom_picture',$profile_image_url_small);     
    
        
        
         if($firstname!=='' || $secondname!='' ){
            $post = array(
                    'ID'            => $agent_id,
                    'post_title'    => $agency_name,
                    'post_content'  => $about_me,
            );
            $post_id =  wp_update_post($post );  
        }
    
     
        update_post_meta($agent_id, 'agency_email',   $useremail);
        update_post_meta($agent_id, 'agency_phone',   $userphone);
        update_post_meta($agent_id, 'agency_mobile',  $usermobile);
        update_post_meta($agent_id, 'agency_skype',   $userskype);
        update_post_meta($agent_id, 'agency_opening_hours',   $agency_opening_hours);
        
        update_post_meta($agent_id, 'agency_facebook',   $userfacebook);
        update_post_meta($agent_id, 'agency_twitter',   $usertwitter);
        update_post_meta($agent_id, 'agency_linkedin',   $userlinkedin);
        update_post_meta($agent_id, 'agency_pinterest',   $userpinterest);
        update_post_meta($agent_id, 'agency_instagram',   $userinstagram);
        update_post_meta($agent_id, 'agency_languages',   $agency_languages);
        update_post_meta($agent_id, 'agency_website',   $agency_website);
        update_post_meta($agent_id, 'agency_taxes',   $agency_taxes);
        update_post_meta($agent_id, 'agency_address',   $agency_address);
        update_post_meta($agent_id, 'agency_lat',   $agency_lat);
        update_post_meta($agent_id, 'agency_long',   $agency_long);
     
        
 

  
        $agency_category           =   get_term( $agency_category_submit, 'category_agency');     
        if(isset($agency_category->term_id)){
            $agency_category_submit  =   $agency_category->name;
        }else{
            $agency_category_submit=-1;
        }
        
        if( isset($agency_category_submit) && $agency_category_submit!='none' ){
            wp_set_object_terms($agent_id,$agency_category_submit,'category_agency'); 
        }  

        
        
        
        
        $agency_category           =   get_term( $agency_action_submit, 'action_category_agency');     
        if(isset($agency_category->term_id)){
            $agency_action_submit  =   $agency_category->name;
        }else{
            $agency_action_submit=-1;
        }
        
        if( isset($agency_action_submit) && $agency_action_submit!='none' ){
            wp_set_object_terms($agent_id,$agency_action_submit,'action_category_agency'); 
        }  

        
        if( isset($agency_city) && $agency_city!='none' ){
            wp_set_object_terms($agent_id,$agency_city,'city_agency'); 
        }  
        
        if( isset($agency_area) && $agency_area!='none' ){
            wp_set_object_terms($agent_id,$agency_area,'area_agency'); 
        }  
        
        if( isset($agency_county) && $agency_county!='none' ){
            wp_set_object_terms($agent_id,$agency_county,'county_state_agency'); 
        }  

     

     
        set_post_thumbnail( $agent_id, $profile_image_url_small );

        
        
        
        
        
        if( $current_user->user_email != $useremail ) {
            $user_id=email_exists( $useremail ) ;
            if ( $user_id){
                _e('The email was not saved because it is used by another user.</br>','wpestate');
            } else{
                $args = array(
                    'ID'         => $userID,
                    'user_email' => $useremail
                ); 
                wp_update_user( $args );
            } 
        }
        
        $arguments=array(
            'user_profile'      =>  $user_login,
        );

        wpestate_select_email_type(get_option('admin_email'),'agent_update_profile',$arguments);
        _e('Profile updated','wpestate');
        die(); 
   }
endif; // end   wpestate_ajax_update_profile agency



////////////////////////////////////////////////////////////////////////////////
/// Ajax  upadte profile developer
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_wpestate_ajax_update_profile_developer', 'wpestate_ajax_update_profile_developer' );  
if( !function_exists('wpestate_ajax_update_profile_developer') ):
   
   function wpestate_ajax_update_profile_developer(){
        $current_user           =   wp_get_current_user();
        $userID                 =   $current_user->ID;
        $user_login             =   $current_user->user_login;
        check_ajax_referer( 'profile_ajax_nonce', 'security-profile' );
        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }
        $user_role = intval (get_user_meta( $current_user->ID, 'user_estate_role', true) );
        
        if($user_role!=4){
            exit('not the right role');
        }
        
        $developer_id=get_user_meta( $userID, 'user_agent_id',true);

        
        $allowed_html               =   array('</br>');
        $developer_name             =   sanitize_text_field ( wp_kses( $_POST['developer_name'] ,$allowed_html) );
        $useremail                  =   sanitize_text_field ( wp_kses( $_POST['useremail'] ,$allowed_html) );
        $userphone                  =   sanitize_text_field ( wp_kses( $_POST['userphone'] ,$allowed_html) );
        $usermobile                 =   sanitize_text_field ( wp_kses( $_POST['usermobile'] ,$allowed_html) );
        $userskype                  =   sanitize_text_field ( wp_kses( $_POST['userskype'] ,$allowed_html) );
        $usertitle                  =   sanitize_text_field ( wp_kses( $_POST['usertitle'] ,$allowed_html) );
        $about_me                   =   wp_kses( $_POST['description'],$allowed_html );
        $profile_image_url_small    =   sanitize_text_field ( wp_kses($_POST['profile_image_url_small'],$allowed_html) );
        $profile_image_url          =   sanitize_text_field ( wp_kses($_POST['profile_image_url'],$allowed_html) );       
        $userfacebook               =   sanitize_text_field ( wp_kses( $_POST['userfacebook'],$allowed_html) );
        $usertwitter                =   sanitize_text_field ( wp_kses( $_POST['usertwitter'],$allowed_html) );
        $userlinkedin               =   sanitize_text_field ( wp_kses( $_POST['userlinkedin'],$allowed_html) );
        $userpinterest              =   sanitize_text_field ( wp_kses( $_POST['userpinterest'],$allowed_html ) );
        $userinstagram              =   sanitize_text_field ( wp_kses( $_POST['userinstagram'],$allowed_html ) );
        $userurl                    =   sanitize_text_field ( wp_kses( $_POST['userurl'],$allowed_html ) );         
        $developer_languages           =   sanitize_text_field ( wp_kses( $_POST['developer_languages'],$allowed_html ) );
        $developer_website             =   sanitize_text_field ( wp_kses( $_POST['developer_website'],$allowed_html ) );
        $developer_taxes               =   sanitize_text_field ( wp_kses( $_POST['developer_taxes'],$allowed_html ) );     
        $developer_category_submit     =   sanitize_text_field ( wp_kses( $_POST['developer_category_submit'],$allowed_html ) );
        $developer_action_submit       =   sanitize_text_field ( wp_kses( $_POST['developer_action_submit'],$allowed_html ) );
        $developer_city                =   sanitize_text_field ( wp_kses( $_POST['developer_city'],$allowed_html ) );
        $developer_county              =   sanitize_text_field ( wp_kses( $_POST['developer_county'],$allowed_html ) );
        $developer_area                =   sanitize_text_field ( wp_kses( $_POST['developer_area'],$allowed_html ) );     
        $developer_address             =   sanitize_text_field ( wp_kses( $_POST['developer_address'],$allowed_html ) );
        $developer_lat                 =   sanitize_text_field ( wp_kses( $_POST['developer_lat'],$allowed_html ) );
        $developer_long                =   sanitize_text_field ( wp_kses( $_POST['developer_long'],$allowed_html ) );
       
        
      
        $developer_id=get_user_meta($userID,'user_agent_id',true);
        
        update_user_meta( $userID, 'custom_picture',$profile_image_url);
        update_user_meta( $userID, 'small_custom_picture',$profile_image_url_small);     
    
        
        
         if($firstname!=='' || $secondname!='' ){
            $post = array(
                    'ID'            => $developer_id,
                    'post_title'    => $developer_name,
                    'post_content'  => $about_me,
            );
            $post_id =  wp_update_post($post );  
        }
    
            
        update_post_meta($developer_id, 'developer_email',   $useremail);
        update_post_meta($developer_id, 'developer_phone',   $userphone);
        update_post_meta($developer_id, 'developer_mobile',  $usermobile);
        update_post_meta($developer_id, 'developer_skype',   $userskype);

        update_post_meta($developer_id, 'developer_facebook',   $userfacebook);
        update_post_meta($developer_id, 'developer_twitter',   $usertwitter);
        update_post_meta($developer_id, 'developer_linkedin',   $userlinkedin);
        update_post_meta($developer_id, 'developer_pinterest',   $userpinterest);
        update_post_meta($developer_id, 'developer_instagram',   $userinstagram);
        update_post_meta($developer_id, 'developer_languages',   $developer_languages);
        update_post_meta($developer_id, 'developer_website',   $developer_website);
        update_post_meta($developer_id, 'developer_taxes',   $developer_taxes);
        update_post_meta($developer_id, 'developer_address',   $developer_address);
        update_post_meta($developer_id, 'developer_lat',   $developer_lat);
        update_post_meta($developer_id, 'developer_long',   $developer_long);
        
        
 

  
        $developer_category           =   get_term( $developer_category_submit, 'property_category_developer');     
        if(isset($developer_category->term_id)){
            $developer_category_submit  =   $developer_category->name;
        }else{
            $developer_category_submit=-1;
        }
        
        if( isset($developer_category_submit) && $developer_category_submit!='none' ){
            wp_set_object_terms($developer_id,$developer_category_submit,'property_category_developer'); 
        }  

        
        
        
        
        $developer_category           =   get_term( $developer_action_submit, 'property_action_developer');     
        if(isset($developer_category->term_id)){
            $developer_action_submit  =   $developer_category->name;
        }else{
            $developer_action_submit=-1;
        }
        
        if( isset($developer_action_submit) && $developer_action_submit!='none' ){
            wp_set_object_terms($developer_id,$developer_action_submit,'property_action_developer'); 
        }  

        
        if( isset($developer_city) && $developer_city!='none' ){
            wp_set_object_terms($developer_id,$developer_city,'property_city_developer'); 
        }  
        
        if( isset($developer_area) && $developer_area!='none' ){
            wp_set_object_terms($developer_id,$developer_area,'property_area_developer'); 
        }  
        
        if( isset($developer_county) && $developer_county!='none' ){
            wp_set_object_terms($developer_id,$developer_county,'property_county_state_developer'); 
        }  

     

     
        set_post_thumbnail( $developer_id, $profile_image_url_small );

        
        
        
        
        
        if( $current_user->user_email != $useremail ) {
            $user_id=email_exists( $useremail ) ;
            if ( $user_id){
                _e('The email was not saved because it is used by another user.</br>','wpestate');
            } else{
                $args = array(
                    'ID'         => $userID,
                    'user_email' => $useremail
                ); 
                wp_update_user( $args );
            } 
        }
        
        $arguments=array(
            'user_profile'      =>  $user_login,
        );

        wpestate_select_email_type(get_option('admin_email'),'agent_update_profile',$arguments);
        _e('Profile updated','wpestate');
        die(); 
   }
endif; // end   wpestate_ajax_update_profile developer


////////////////////////////////////
//delete profile wpestate_delete_profile
//////////////////////////////////
add_action( 'wp_ajax_wpestate_delete_profile', 'wpestate_delete_profile' );  

if( !function_exists('wpestate_delete_profile') ):   
    function wpestate_delete_profile(){
        $current_user   =   wp_get_current_user();
        $userID         =   $current_user->ID;
        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        
         $args = array(
                'post_type' => array('estate_property',
                                    'estate_agent',
                                    'estate_agency',
                                    'estate_developer',
                                    'post',
                                    'wpestate_message',
                                    'attachment'
                                    ),
                'author'           =>  $userID,
                'posts_per_page'    => -1,
            );
        

        $prop_selection = new WP_Query($args);

         
        while ($prop_selection->have_posts()): $prop_selection->the_post(); 
           wp_delete_post( get_the_ID()  ); 
        endwhile;
        
        //delete comments
        $args = array(
            'user_id' => $userID, // use user_id
        );
        
        $comments = get_comments($args);

        foreach($comments as $comment) :
            wp_delete_comment($comment->comment_ID);
        endforeach;
        
        $agent_page =   get_user_meta( $userID, 'user_agent_id' , true) ;
        wp_delete_post($agent_page);

        wp_delete_user($userID);
 
        die(); 
    }
endif; // end   wpestate_delete_profile

/////////////////////////////////////////////////// update user   

if( !function_exists('wpestate_update_user_agent') ):
function    wpestate_update_user_agent ($agent_member,$agent_category_submit,$agent_action_submit,$agent_city,$agent_county,$agent_area,$userurl,$agent_id, $firstname ,$secondname ,$useremail,$userphone,$userskype,$usertitle,$profile_image_url,$usermobile,$about_me,$profile_image_url_small,$userfacebook,$usertwitter,$userlinkedin,$userpinterest,$userinstagram) {
    
    if($firstname!=='' || $secondname!='' ){
        $post = array(
            'ID'            => $agent_id,
            'post_title'    => $firstname.' '.$secondname,
            'post_content'  => $about_me,
        );
        wp_update_post($post );  
    }
     
    update_post_meta($agent_id, 'agent_member',$agent_member);
    update_post_meta($agent_id, 'first_name',   $firstname);
    update_post_meta($agent_id, 'last_name',   $secondname);   
    update_post_meta($agent_id, 'agent_email',   $useremail);
    update_post_meta($agent_id, 'agent_phone',   $userphone);
    update_post_meta($agent_id, 'agent_mobile',  $usermobile);
    update_post_meta($agent_id, 'agent_skype',   $userskype);
    update_post_meta($agent_id, 'agent_position',  $usertitle);
    update_post_meta($agent_id, 'agent_facebook',   $userfacebook);
    update_post_meta($agent_id, 'agent_twitter',   $usertwitter);
    update_post_meta($agent_id, 'agent_linkedin',   $userlinkedin);
    update_post_meta($agent_id, 'agent_pinterest',   $userpinterest);
    update_post_meta($agent_id, 'agent_instagram',   $userinstagram);
    update_post_meta($agent_id, 'agent_website',   $userurl);
    set_post_thumbnail( $agent_id, $profile_image_url_small );


    $agent_category           =   get_term( $agent_category_submit, 'property_category_agent');     
    if(isset($agent_category->term_id)){
        $agent_category_submit  =   $agent_category->name;
    }else{
        $agent_category_submit=-1;
    }

    if( isset($agent_category_submit) && $agent_category_submit!='none' ){
        wp_set_object_terms($agent_id,$agent_category_submit,'property_category_agent'); 
    }  
        
    //---

    $agent_category           =   get_term( $agent_action_submit, 'property_action_category_agent');     
    if(isset($agent_category->term_id)){
        $agent_action_submit  =   $agent_category->name;
    }else{
        $agent_action_submit=-1;
    }
         
    if( isset($agent_action_submit) && $agent_action_submit!='none' ){
        wp_set_object_terms($agent_id,$agent_action_submit,'property_action_category_agent'); 
    }  


    if( isset($agent_city) && $agent_city!='none' ){
        wp_set_object_terms($agent_id,$agent_city,'property_city_agent'); 
    }  

    if( isset($agent_county) && $agent_county!='none' ){
        wp_set_object_terms($agent_id,$agent_county,'property_county_state_agent'); 
    }  

    if( isset($agent_area) && $agent_area!='none' ){
        wp_set_object_terms($agent_id,$agent_area,'property_area_agent'); 
    }  

 
 }
endif; // end   ajax_update_profile         
 



////////////////////////////////////////////////////////////////////////////////
/// Ajax  Forgot Pass function
////////////////////////////////////////////////////////////////////////////////

add_action( 'wp_ajax_wpestate_ajax_update_pass', 'wpestate_ajax_update_pass' );  
if( !function_exists('wpestate_ajax_update_pass') ):
   
   function wpestate_ajax_update_pass(){
        $current_user   =   wp_get_current_user();
        $allowed_html   =   array();
        $userID         =   $current_user->ID;
        
        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }
        
        $oldpass        =  sanitize_text_field ( wp_kses( $_POST['oldpass'] ,$allowed_html) );
        $newpass        =  sanitize_text_field ( wp_kses( $_POST['newpass'] ,$allowed_html) );
        $renewpass      =  sanitize_text_field ( wp_kses( $_POST['renewpass'] ,$allowed_html) ) ;
        
        if($newpass=='' || $renewpass=='' ){
            _e('The new password is blank','wpestate');
            die();
        }
       
        if($newpass != $renewpass){
            _e('Passwords do not match','wpestate');
            die();
        }
        check_ajax_referer( 'pass_ajax_nonce', 'security-pass' );
        
        $user = get_user_by( 'id', $userID );
        if ( $user && wp_check_password( $oldpass, $user->data->user_pass, $user->ID) ){
            wp_set_password( $newpass, $user->ID );
            _e('Password Updated','wpestate');
        }else{
            _e('Old Password is not correct','wpestate');
        }
     
        die();         
   }
endif; // end   wpestate_ajax_update_pass 



   
////////////////////////////////////////////////////////////////////////////////
/// Ajax  Upload   function
////////////////////////////////////////////////////////////////////////////////

add_action( 'wp_ajax_wpestate_ajax_add_fav', 'wpestate_ajax_add_fav' );  

if( !function_exists('wpestate_ajax_add_fav') ):

    function wpestate_ajax_add_fav(){
          
        $current_user   =   wp_get_current_user();
        $userID         =   $current_user->ID;
        $user_option    =   'favorites'.$userID;
        
        
        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }
        
        $post_id        =   intval( $_POST['post_id']);
        $curent_fav     =   get_option($user_option);
       
        
        if($curent_fav==''){ // if empy / first time
            $fav    =   array();
            $fav[]  =   $post_id;
            update_option($user_option,$fav);
            echo json_encode(array('added'=>true, 'response'=>__('addded','wpestate')));
            die();
        }else{
            if ( ! in_array ($post_id,$curent_fav) ){
                $curent_fav[]=$post_id;                  
                update_option($user_option,$curent_fav);
                echo json_encode(array('added'=>true, 'response'=>__('addded','wpestate')));
                die();
            }else{
                if(($key = array_search($post_id, $curent_fav)) !== false) {
                    unset($curent_fav[$key]);
                }
                update_option($user_option,$curent_fav);
                echo json_encode(array('added'=>false, 'response'=>__('removed','wpestate')));
                die();
            }
        }     
        die();
    }
endif; // end   wpestate_ajax_add_fav 
 
 
 
 
 



////////////////////////////////////////////////////////////////////////////////
/// Ajax  Filters
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_ajax_filter_listings', 'ajax_filter_listings' );  
add_action( 'wp_ajax_ajax_filter_listings', 'ajax_filter_listings' );

if( !function_exists('ajax_filter_listings') ):
    
    function ajax_filter_listings(){
        wp_suspend_cache_addition(true);
   
     
        global $currency;
        global $where_currency;
        global $post;
        global $options;
        global $prop_unit;
        global $property_unit_slider;
        global $no_listins_per_row;
        global $wpestate_uset_unit;
        global $custom_unit_structure;
        global $align_class;
        $custom_unit_structure    =   get_option('wpestate_property_unit_structure');        
        $wpestate_uset_unit       =   intval ( get_option('wpestate_uset_unit','') );
        $current_user             =   wp_get_current_user();
        $userID                   =   $current_user->ID;
        $user_option              =   'favorites'.$userID;
        $curent_fav               =   get_option($user_option);
        $currency                 =   esc_html( get_option('wp_estate_currency_symbol', '') );
        $where_currency           =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
        $area_array               =   '';   
        $city_array               =   '';
        $action_array             =   '';
        $categ_array              =   '';
        $show_compare             =   1;
        $property_unit_slider     =   get_option('wp_estate_prop_list_slider','');
        $no_listins_per_row       =   intval( get_option('wp_estate_listings_per_row', '') );   
        $options                  =   wpestate_page_details(intval($_POST['page_id']));
        
        
        
        $prop_unit          =   esc_html ( get_option('wp_estate_prop_unit','') );
        $prop_unit_class    =   '';
        $align_class        =   '';
        if( $prop_unit == 'list' ){
            $prop_unit_class    =   "ajax12";
            $align_class        =   'the_list_view';
        }

        $property_card_type         =   intval(get_option('wp_estate_unit_card_type'));
        $property_card_type_string  =   '';
        if($property_card_type==0){
            $property_card_type_string  =   '';
        }else{
            $property_card_type_string  =   '_type'.$property_card_type;
        }

        //////////////////////////////////////////////////////////////////////////////////////
        ///// category filters 
        //////////////////////////////////////////////////////////////////////////////////////
        $allowed_html   =   array();
        if (isset($_POST['category_values']) && trim($_POST['category_values']) != 'All Types' && $_POST['category_values']!=''&& $_POST['category_values']!='all' && $_POST['category_values']!='all-types'){
            $taxcateg_include   =   sanitize_title ( wp_kses(  $_POST['category_values'],$allowed_html  ) );
            $categ_array    =   array(
                'taxonomy'  => 'property_category',
                'field'     => 'slug',
                'terms'     => $taxcateg_include
            );
        }
         
     
                
        //////////////////////////////////////////////////////////////////////////////////////
        ///// action  filters 
        //////////////////////////////////////////////////////////////////////////////////////

        if ( ( isset($_POST['action_values']) && trim($_POST['action_values']) != 'All Actions' ) && $_POST['action_values']!='' && $_POST['action_values']!='all' && $_POST['action_values']!='all-actions'){
            $taxaction_include   =   sanitize_title ( wp_kses(  $_POST['action_values'],$allowed_html  ) );   
            $action_array   =   array(
                'taxonomy'  => 'property_action_category',
                'field'     => 'slug',
                'terms'     => $taxaction_include
            );
        }

		
		//////////////////////////////////////////////////////////////////////////////////////
        ///// county filters 
        //////////////////////////////////////////////////////////////////////////////////////

        if (isset($_POST['county']) and trim($_POST['county']) !='All Counties/States' && $_POST['county'] && trim($_POST['county']) != 'all' /* && trim($_POST['county']) != 'all-cities' */ )  {
            $taxcounty[] = sanitize_title ( wp_kses($_POST['county'],$allowed_html) );
            $county_array     = array(
                'taxonomy'  => 'property_county_state',
                'field'     => 'slug',
                'terms'     => $taxcounty
            );
        }
   
      
        //////////////////////////////////////////////////////////////////////////////////////
        ///// city filters 
        //////////////////////////////////////////////////////////////////////////////////////

        if (isset($_POST['city']) and trim($_POST['city']) !='All Cities' && $_POST['city'] && trim($_POST['city']) != 'all' && trim($_POST['city']) != 'all-cities' ) {
            $taxcity[] = sanitize_title ( wp_kses($_POST['city'],$allowed_html) );
            $city_array     = array(
                'taxonomy'  => 'property_city',
                'field'     => 'slug',
                'terms'     => $taxcity
            );
        }
 
    
        //////////////////////////////////////////////////////////////////////////////////////
        ///// area filters 
        //////////////////////////////////////////////////////////////////////////////////////

        if ( isset( $_POST['area'] ) && trim($_POST['area']) != 'All Areas' && $_POST['area'] && trim($_POST['area']) != 'all' && trim($_POST['area']) != 'all-areas' ) {
            $taxarea[] = sanitize_title ( wp_kses ($_POST['area'],$allowed_html) );
            $area_array = array(
                'taxonomy'  => 'property_area',
                'field'     => 'slug',
                'terms'     => $taxarea
            );
        }

               
        //////////////////////////////////////////////////////////////////////////////////////
        ///// order details
        //////////////////////////////////////////////////////////////////////////////////////
        $meta_directions    =   'DESC';
        $meta_order         =   'prop_featured';
        $order_by           =   'meta_value_num';

        $order=intval($_POST['order']);

        switch ($order){
                case 1:
                    $meta_order         =   'property_price';
                    $meta_directions    =   'DESC';
                    $order_by           =   'meta_value_num';
                    break;
                case 2:
                    $meta_order         =   'property_price';
                    $meta_directions    =   'ASC';
                    $order_by           =   'meta_value_num';
                    break;
                case 3:
                    $meta_order         =   '';
                    $meta_directions    =   'DESC';
                    $order_by           =   'ID';
                    break;
                case 4:
                    $meta_order         =   '';
                    $meta_directions    =   'ASC';
                    $order_by           =   'ID';
                    break;
                case 5:
                    $meta_order         =   'property_bedrooms';
                    $meta_directions    =   'DESC';
                    $order_by           =   'meta_value_num';
                    break;
                case 6:
                    $meta_order         =   'property_bedrooms';
                    $meta_directions    =   'ASC';
                    $order_by           =   'meta_value_num';
                    break;
                case 7:
                    $meta_order         =   'property_bathrooms';
                    $meta_directions    =   'DESC';
                    $order_by           =   'meta_value_num';
                    break;
                case 8:
                    $meta_order         =   'property_bathrooms';
                    $meta_directions    =   'ASC';
                    $order_by           =   'meta_value_num';
                    break;
            }
        $paged      =   intval( $_POST['newpage'] );
        $prop_no    =   intval( get_option('wp_estate_prop_no', '') );
            
        

        $max_pins                   =   intval( get_option('wp_estate_map_max_pins') );
        $args = array(
            'cache_results'             =>  false,
            'update_post_meta_cache'    =>  false,
            'update_post_term_cache'    =>  false,
            'post_type'         => 'estate_property',
            'post_status'       => 'publish',
            'paged'             => $paged,
            'posts_per_page'    => $prop_no,
            'orderby'           => $order_by, 
            'meta_key'          => $meta_order,
            'order'             => $meta_directions,
            'tax_query'         => array(
                                'relation' => 'AND',
                                        $categ_array,
                                        $action_array,
                                        $county_array,
                                        $city_array,
                                        $area_array
                                )
        );
    

        if( intval($order) === 0 ){
            add_filter( 'posts_orderby', 'wpestate_my_order' );
            $prop_selection = new WP_Query($args);
            remove_filter( 'posts_orderby', 'wpestate_my_order' );
        }else{
            $prop_selection = new WP_Query($args);
        }
      
        
        
        
        $to_show= '<span id="scrollhere"><span>';  
        $counter = 0;
        ob_start();
        if( $prop_selection->have_posts() ){
            while ($prop_selection->have_posts()): $prop_selection->the_post(); 
                get_template_part('templates/property_unit'.$property_card_type_string);
            endwhile;
            kriesi_pagination_ajax_newver($prop_selection->max_num_pages, $range =2,$paged,'pagination_ajax',$order); 
        }else{
            print '<span class="no_results">'. __("We didn't find any results","wpestate").'</>';
        }
        
        $to_show.=ob_get_contents();
        ob_end_clean();
        
        wp_reset_query();
        wp_suspend_cache_addition(false);   
        
         //krakau
        $args['page']=1;
        $args['posts_per_page']=intval( get_option('wp_estate_map_max_pins') );
        $args['offset']          =   ($paged-1)*$prop_no;
        $on_demand_results = wpestate_listing_pins_on_demand($args);
        
         
        echo json_encode( array(    
                            'args'      =>  $args, 
                            'markers'   =>  $on_demand_results['markers'],
                            'no_results'=>  $on_demand_results['results'],
                            'to_show'   =>  $to_show,
                        ));
        die();
  }
  
 endif; // end   ajax_filter_listings_search 
 

////////////////////////////////////////////////////////////////////////////////
/// Ajax  Filters
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_get_filtering_ajax_result', 'get_filtering_ajax_result' );  
add_action( 'wp_ajax_get_filtering_ajax_result', 'get_filtering_ajax_result' );

if( !function_exists('get_filtering_ajax_result') ):
    
    function get_filtering_ajax_result(){
        global $post;
       
        global $options;
        global $show_compare_only;
        global $currency;
        global $where_currency;
        $show_compare_only          =   'no';
        $current_user               =   wp_get_current_user();
        $userID                     =   $current_user->ID;
        $user_option                =   'favorites'.$userID;
        $curent_fav                 =   get_option($user_option);
        $currency                   =   esc_html( get_option('wp_estate_currency_symbol', '') );
        $where_currency             =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
        $area_array                 =   '';              
        $city_array                 =   '';  
        $action_array               =   '';   
        $categ_array                =   '';
        $options                    =   wpestate_page_details(intval($_POST['postid']));
      
 
        //////////////////////////////////////////////////////////////////////////////////////
        ///// category filters 
        //////////////////////////////////////////////////////////////////////////////////////
        $allowed_html   =   array();
        if (isset($_POST['category_values']) && trim($_POST['category_values']) != 'all' ){
            $taxcateg_include   =   sanitize_title ( wp_kses(  $_POST['category_values'] ,$allowed_html ) );
            $categ_array=array(
                'taxonomy'  => 'property_category',
                'field'     => 'slug',
                'terms'     => $taxcateg_include
            );
        }

     
                
        //////////////////////////////////////////////////////////////////////////////////////
        ///// action  filters 
        //////////////////////////////////////////////////////////////////////////////////////

        if ( ( isset($_POST['action_values']) && trim($_POST['action_values']) != 'all' ) ){
            $taxaction_include   =   sanitize_title ( wp_kses( $_POST['action_values'],$allowed_html ) );   
            $action_array=array(
                'taxonomy' => 'property_action_category',
                'field'    => 'slug',
                'terms'    => $taxaction_include
            );
        }

   
      
        //////////////////////////////////////////////////////////////////////////////////////
        ///// city filters 
        //////////////////////////////////////////////////////////////////////////////////////

        if (isset($_POST['city']) and trim($_POST['city']) != 'all' ) {
            $taxcity[] = sanitize_title ( wp_kses($_POST['city'],$allowed_html) );
            $city_array = array(
                'taxonomy'  => 'property_city',
                'field'     => 'slug',
                'terms'     => $taxcity
            );
        }
 
    
        //////////////////////////////////////////////////////////////////////////////////////
        ///// area filters 
        //////////////////////////////////////////////////////////////////////////////////////

         if ( isset( $_POST['area'] ) && trim($_POST['area']) != 'all') {
            $taxarea[] = sanitize_title ( wp_kses ($_POST['area'],$allowed_html) );
            $area_array = array(
                'taxonomy'  => 'property_area',
                'field'     => 'slug',
                'terms'     => $taxarea
            );
         }
 
         
        $meta_query = $rooms = $baths = $price = array();
        if (isset($_POST['advanced_rooms']) && is_numeric($_POST['advanced_rooms'])) {
            $rooms['key']   = 'property_bedrooms';
            $rooms['value'] = floatval ($_POST['advanced_rooms']);
            $meta_query[]   = $rooms;
        }

        if (isset($_POST['advanced_bath']) && is_numeric($_POST['advanced_bath'])) {
            $baths['key']   = 'property_bathrooms';
            $baths['value'] = floatval ($_POST['advanced_bath']);
            $meta_query[]   = $baths;
        }


    //////////////////////////////////////////////////////////////////////////////////////
    ///// price filters 
    //////////////////////////////////////////////////////////////////////////////////////
    $price_low ='';
    if( isset($_POST['price_low'])){
       $price_low = floatval($_POST['price_low']);
    }

    $price_max='';
    if( isset($_POST['price_max'])  && is_numeric($_POST['price_max']) ){
        $price_max         = floatval($_POST['price_max']);
        $price['key']      = 'property_price';
        $price['value']    = array($price_low, $price_max);
        $price['type']     = 'numeric';
        $price['compare']  = 'BETWEEN';
        $meta_query[]      = $price;
    }
         
         
         
         
//////////////////////////////////////////////////////////////////////////////////////
///// order details
//////////////////////////////////////////////////////////////////////////////////////
     
        
        wp_suspend_cache_addition(true);
        $args = array(
            'post_type'         => 'estate_property',
            'post_status'       => 'publish',
            'posts_per_page'    =>  '-1',
            'cache_results'     => false,
            'meta_query'        => $meta_query,
            'tax_query'         => array(
                                    'relation' => 'AND',
                                    $categ_array,
                                    $action_array,
                                    $city_array,
                                    $area_array
                                    )
        );
    

        $prop_selection = new WP_Query($args);
        if( $prop_selection->have_posts() ){
            print $prop_selection->post_count;
        }else{
            print '0';
        } 
        wp_suspend_cache_addition(false);
        die();
  }
  
 endif; // end   get_filtering_ajax_result 
 
 
 
 
 ////////////////////////////////////////////////////////////////////////////////
/// Ajax  Filters
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_wpestate_custom_adv_ajax_filter_listings_search', 'wpestate_custom_adv_ajax_filter_listings_search' );  
add_action( 'wp_ajax_wpestate_custom_adv_ajax_filter_listings_search', 'wpestate_custom_adv_ajax_filter_listings_search' );

if( !function_exists('wpestate_custom_adv_ajax_filter_listings_search') ):
    
    function wpestate_custom_adv_ajax_filter_listings_search(){
        wp_suspend_cache_addition(true);
        global $post;      
        global $options;
        global $show_compare_only;
        global $currency;
        global $where_currency;
        global $keyword;
        global $property_unit_slider;
        global $is_col_md_12;
        global $no_listins_per_row;
        global $wpestate_uset_unit;
        global $custom_unit_structure;
        
        $custom_unit_structure      =   get_option('wpestate_property_unit_structure');
        $wpestate_uset_unit         =   intval ( get_option('wpestate_uset_unit','') );
        $current_user               =   wp_get_current_user();
        $show_compare_only          =   'yes';
        
        if( get_option( 'page_on_front') == intval($_POST['postid']) ){
            $show_compare_only  =   'no'; 
        }  
        
        $userID             =   $current_user->ID;
        $user_option        =   'favorites'.$userID;
        $curent_fav         =   get_option($user_option);
        $currency           =   esc_html( get_option('wp_estate_currency_symbol', '') );
        $where_currency     =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
        $area_array         =   '';   
        $city_array         =   ''; 
        $action_array       =   '';   
        $categ_array        =   '';
        $meta_query         =   array();
        $options            =   wpestate_page_details(intval($_POST['postid']));
          
        $adv_search_what    =   get_option('wp_estate_adv_search_what','');
        $adv_search_how     =   get_option('wp_estate_adv_search_how','');
        $adv_search_label   =   get_option('wp_estate_adv_search_label','');                    
        $adv_search_type    =   get_option('wp_estate_adv_search_type','');
        $property_unit_slider = get_option('wp_estate_prop_list_slider','');
        $no_listins_per_row       =   intval( get_option('wp_estate_listings_per_row', '') );
          
        $half_map =   0;
        if (isset($_POST['halfmap'])){
            $half_map = intval($_POST['halfmap']);
        }  
        global $prop_unit;
        global $prop_unit_class;
        global $align_class;
        $prop_unit          =   esc_html ( get_option('wp_estate_prop_unit','') );
        $prop_unit_class    =   '';
        if( $prop_unit == 'list' ){
            $prop_unit_class    =   "ajax12";
            $align_class        =   'the_list_view';
        }


        $property_card_type         =   intval(get_option('wp_estate_unit_card_type'));
        $property_card_type_string  =   '';
        
        if( $property_card_type ==0 ){
            $property_card_type_string='';
        }else{
            $property_card_type_string='_type'.$property_card_type;
        }
        
        $paged                  =   intval($_POST['newpage']);
        $prop_no                =   intval( get_option('wp_estate_prop_no', '') );
        $args                   =   wpestate_search_results_custom ('ajax'); 
        $args['posts_per_page'] =   intval( get_option('wp_estate_prop_no', '') );
       
        //////////////////////////////////////////////////// in case of slider search
      
        $return_custom      =   wpestate_search_with_keyword_ajax($adv_search_what, $adv_search_label);
        
        if( isset( $return_custom['id_array']) ){
            $id_array       =   $return_custom['id_array']; 
            if($id_array!=0){
                $args=  array(  'post_type'     =>    'estate_property',
                    'p'             =>    $id_array
                );
            }
        }
        
        if(isset($return_custom['keyword'])){
            $keyword        =   $return_custom['keyword'];
        }
        
        
        if( isset($_POST['keyword_search']) && trim($_POST['keyword_search'])!='' ){
            $allowed_html       =   array();
            $keyword            =   esc_attr(  wp_kses ( $_POST['keyword_search'], $allowed_html));
       
        }
    
   
        if( get_option('wp_estate_use_geo_location','')=='yes' && $_POST['geo_lat']!='' && $_POST['geo_long']!='' ){
           
            $geo_lat = $_POST['geo_lat'];
            $geo_long = $_POST['geo_long'];
            $geo_rad = $_POST['geo_rad'];
            $args = wpestate_geo_search_filter_function($args, $geo_lat, $geo_long, $geo_rad);
        }
        
        ////////////////////////////////////////////////////////// end in case of slider search 

        
        
        $order= intval($_POST['order']);
        $meta_order         =   'prop_featured';
        $meta_directions    =   'DESC';   
        $order_by           =   'meta_value';
    
        if(isset($_POST['order'])) {
            $order=  wp_kses( $_POST['order'],$allowed_html );
            switch ($order){
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
                    $meta_order='property_bedrooms';
                    $meta_directions='ASC';
                    $order_by='meta_value_num';
                    break;
            }
        }
        
        
        
        $args ['meta_key']        = $meta_order;
        $args ['orderby']         = $order_by;
        $args ['order']           = $meta_directions;
        
    
       
        if($id_array!=0){
          
            $prop_selection     = new WP_Query($args);
        }else{
            if($order==0){
                add_filter( 'posts_orderby', 'wpestate_my_order' );
            }
            
            if( !empty($keyword) ){
                $keyword    =  str_replace('-', ' ', $keyword);
                add_filter( 'posts_where', 'wpestate_title_filter', 10, 2 );
                $prop_selection     = new WP_Query($args);
             
                remove_filter( 'posts_where', 'wpestate_title_filter', 10, 2 );
            }else{
               $prop_selection     = new WP_Query($args);
            }
            if($order==0){
                remove_filter( 'posts_orderby', 'wpestate_my_order' );
            }
        }
        
    
        $counter            =   0;
        $compare_submit     =   wpestate_get_template_link('compare_listings.php');
             
        
        
        
        
        
        
        ob_start();
        print '<span id="scrollhere"><span>'; 
        if( $prop_selection->have_posts() ){
                  if($half_map==1){
                    $is_col_md_12=1;
                }
                while ($prop_selection->have_posts()): $prop_selection->the_post(); 
                    get_template_part('templates/property_unit'.$property_card_type_string);
                endwhile;
            
  
            kriesi_pagination_ajax($prop_selection->max_num_pages, $range =2,$paged,'pagination_ajax_search'); 
        }else{
            print '<span class="no_results">'. __("We didn't find any results","wpestate").'</>';
        }
        
       //wp_reset_query();
       // wp_reset_postdata();
        wp_suspend_cache_addition(false);
        
        $cards= ob_get_contents();
        ob_end_clean();
        echo json_encode( array('sent'=>true, 'args'=>$args,'cards'=>$cards,'no_founs'=> $prop_selection->found_posts.' '.__('Listings','wpestate') ) ); 
        die();
  }
  
 endif; // end   ajax_filter_listings 
 
 
 ////////////////////////////////////////////////////////////////////////////////
/// Ajax  Filters
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_custom_adv_get_filtering_ajax_result', 'custom_adv_get_filtering_ajax_result' );  
add_action( 'wp_ajax_custom_adv_get_filtering_ajax_result', 'custom_adv_get_filtering_ajax_result' );

if( !function_exists('custom_adv_get_filtering_ajax_result') ):
    
    function custom_adv_get_filtering_ajax_result(){
        wp_suspend_cache_addition(true);
        global $post;
       
        global $options;
        global $show_compare_only;
        global $currency;
        global $where_currency;
        global $keyword;
          
        $show_compare_only          =   'no';
        $allowed_html               =   array();
        $current_user               =   wp_get_current_user();
        $userID                     =   $current_user->ID;
        $user_option                =   'favorites'.$userID;
        $curent_fav                 =   get_option($user_option);
        $currency                   =   esc_html( get_option('wp_estate_currency_symbol', '') );
        $where_currency             =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
        $area_array                 =   '';   
        $city_array                 =   '';    
        $action_array               =   '';   
        $categ_array                =   '';
        $meta_query                 =   array();
        $options                    =   wpestate_page_details(intval($_POST['postid']));
        $adv_search_what            =   get_option('wp_estate_adv_search_what','');
        $adv_search_how             =   get_option('wp_estate_adv_search_how','');
        $adv_search_label           =   get_option('wp_estate_adv_search_label','');                    
        $adv_search_type            =   get_option('wp_estate_adv_search_type','');

     
        
        $args       =   wpestate_search_results_custom ('ajax');
        $keyword    =   wpestate_search_with_keyword_ajax($adv_search_what,$adv_search_label );
         
        ////////////////////////////////////////////////////////// end in case of slider search 
        add_filter( 'posts_orderby', 'wpestate_my_order' );
        if( !empty($keyword) ){
            add_filter( 'posts_where', 'wpestate_title_filter', 10, 2 );
            $prop_selection     = new WP_Query($args);
            remove_filter( 'posts_where', 'wpestate_title_filter', 10, 2 );
        }else{
            $prop_selection     = new WP_Query($args);
        }
         remove_filter( 'posts_orderby', 'wpestate_my_order' );
         
         
        if( $prop_selection->have_posts() ){
            print $prop_selection->post_count;

        }else{
            print '0';
        }

        wp_suspend_cache_addition(false); 
        die();
  }
  
 endif; // end   ajax_filter_listings 
 
 
 
////////////////////////////////////////////////////////////////////////////////
///wpestate_custom_fields_join
////////////////////////////////////////////////////////////////////////////////
 
if( !function_exists('wpestate_custom_fields_join') ):

function wpestate_custom_fields_join($wp_join)
{	
    global $wpdb;
    $wp_join .= " LEFT JOIN (
                    SELECT post_id, meta_value as prop_featured
                    FROM $wpdb->postmeta
                    WHERE meta_key =  'prop_featured' ) AS DD
                    ON $wpdb->posts.ID = DD.post_id ";
    return ($wp_join);
}
 
endif; // end   wpestate_custom_fields_join 
 


////////////////////////////////////////////////////////////////////////////////
/// wpestate_filter_query
////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_filter_query') ):


function wpestate_filter_query( $orderby )
{
    $orderby = " DD.prop_featured  DESC ";
    return $orderby;
}
endif; 
// end   wpestate_filter_query 
 
 
 
 

////////////////////////////////////////////////////////////////////////////////
/// Ajax  Google login form
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_wpestate_ajax_google_login', 'wpestate_ajax_google_login' );  
add_action( 'wp_ajax_wpestate_ajax_google_login', 'wpestate_ajax_google_login' );  

  
if( !function_exists('wpestate_ajax_google_login') ):
  
    function wpestate_ajax_google_login(){  
     
    require 'resources/openid.php';
    $allowed_html   =   array();
    $dash_profile   =   wpestate_get_template_link('user_dashboard_profile.php');
    $login_type     =   wp_kses($_POST['login_type'],$allowed_html);
    try {
        $openid = new LightOpenID( wpestate_get_domain_openid() );
        if(!$openid->mode) {
                if($login_type   ==  'google'){
                   $openid->identity   = 'https://www.google.com/accounts/o8/id'; 
                }else if($login_type ==  'yahoo'){
                   $openid->identity   = 'https://me.yahoo.com'; 
                }else if($login_type ==   'aol'){
                   $openid->identity   = 'http://openid.aol.com/'; 
                }
               
                $openid->required = array(
                        'namePerson',
                        'namePerson/first',
                        'namePerson/last',
                        'contact/email',
                );
                $openid->optional   = array('namePerson', 'namePerson/friendly');         
                $openid->returnUrl  = $dash_profile;
                
                print  $openid->authUrl();
                exit();
                    
        }
    } catch(ErrorException $e) {
      
    }

      
  }
  
endif; // end   wpestate_ajax_google_login 

  
  
  
  
////////////////////////////////////////////////////////////////////////////////
/// Ajax  Google login form OAUTH
////////////////////////////////////////////////////////////////////////////////
  add_action( 'wp_ajax_nopriv_wpestate_ajax_google_login_oauth', 'wpestate_ajax_google_login_oauth' );  
  add_action( 'wp_ajax_wpestate_ajax_google_login_oauth', 'wpestate_ajax_google_login_oauth' );  

  
if( !function_exists('wpestate_ajax_google_login_oauth') ):
  
    function wpestate_ajax_google_login_oauth(){  
       
        set_include_path( get_include_path() . PATH_SEPARATOR . get_template_directory().'/libs/resources');
        $google_client_id       =   esc_html ( get_option('wp_estate_google_oauth_api','') );
        $google_client_secret   =   esc_html ( get_option('wp_estate_google_oauth_client_secret','') );
        $google_redirect_url    =   wpestate_get_template_link('user_dashboard_profile.php');
        $google_developer_key   =   esc_html ( get_option('wp_estate_google_api_key','') );
        
        require_once 'src/Google_Client.php';
        require_once 'src/contrib/Google_Oauth2Service.php';
        
        $gClient = new Google_Client();
        $gClient->setApplicationName('Login to WpResidence');
        $gClient->setClientId($google_client_id);
        $gClient->setClientSecret($google_client_secret);
        $gClient->setRedirectUri($google_redirect_url);
        $gClient->setDeveloperKey($google_developer_key);
        $gClient->setScopes('email');
        $google_oauthV2 = new Google_Oauth2Service($gClient);
        print $authUrl = ($gClient->createAuthUrl());
        die();
    }
  
endif; // end   wpestate_ajax_google_login 

  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
////////////////////////////////////////////////////////////////////////////////
/// Ajax  Google login form
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_wpestate_ajax_facebook_login', 'wpestate_ajax_facebook_login' );  
add_action( 'wp_ajax_wpestate_ajax_facebook_login', 'wpestate_ajax_facebook_login' );  

  
if( !function_exists('wpestate_ajax_facebook_login') ):
    function wpestate_ajax_facebook_login(){ 
        session_start();
        $facebook_api               =   esc_html ( get_option('wp_estate_facebook_api','') );
        $facebook_secret            =   esc_html ( get_option('wp_estate_facebook_secret','') );

        $fb = new Facebook\Facebook([
            'app_id'                => $facebook_api,
            'app_secret'            => $facebook_secret,
            'default_graph_version' => 'v2.12',
        ]);

        $helper         = $fb->getRedirectLoginHelper();
        $permissions    = ['email']; // optional
      
        print    $loginUrl = $helper->getLoginUrl(wpestate_get_template_link('user_dashboard_profile.php'), $permissions);
        die();
    }
   
endif; // end   wpestate_ajax_facebook_login 
  
  
    
 ////////////////////////////////////////////////////////////////////////////////
/// pay via paypal - per listing
////////////////////////////////////////////////////////////////////////////////

add_action( 'wp_ajax_wpestate_ajax_listing_pay', 'wpestate_ajax_listing_pay' );  

if( !function_exists('wpestate_ajax_listing_pay') ):  

    function wpestate_ajax_listing_pay(){
        $current_user   =   wp_get_current_user();
        $is_featured    =   intval($_POST['is_featured']);
        $prop_id        =   intval($_POST['propid']);
        $is_upgrade     =   intval($_POST['is_upgrade']); 
        $userID         =   $current_user->ID;
        $post           =   get_post($prop_id); 


        if ( !is_user_logged_in() ) {   
            exit('ko');
        }

        if($userID === 0 ){
            exit('out pls');
        }

        if( $post->post_author != $userID){
            exit('get out of my cloud');
        }

        $paypal_status                  =   esc_html( get_option('wp_estate_paypal_api','') );
        $host                           =   'https://api.sandbox.paypal.com';  
        $price_submission               =   floatval( get_option('wp_estate_price_submission','') );
        $price_featured_submission      =   floatval( get_option('wp_estate_price_featured_submission','') );
        $submission_curency_status      =   esc_html( get_option('wp_estate_submission_curency','') );
        $pay_description                =   __('Listing payment on ','wpestate').get_bloginfo('url');

        if( $is_featured==0 ){
            $total_price =  number_format($price_submission, 2, '.','');
        }else{
            $total_price = $price_submission + $price_featured_submission;
            $total_price = number_format($total_price, 2, '.','');
        }


        if ($is_upgrade==1){
            $total_price        =  number_format($price_featured_submission, 2, '.','');
            $pay_description    =   __('Upgrade to featured listing on ','wpestate').get_bloginfo('url');
        }

        $sandbox_profile = 'sandbox';
        if($paypal_status=='live'){
            $host               =   'https://api.paypal.com';
            $sandbox_profile    =   '';
            $createdProfile     =    get_option('paypal_web_profile_live','');
        }else{
            $createdProfile     =    get_option('paypal_web_profile_sandbox','');
        }
        $url                =   $host.'/v1/oauth2/token'; 
        $postArgs           =   'grant_type=client_credentials';
        $token              =   wpestate_get_access_token($url,$postArgs);
        $url                =   $host.'/v1/payment-experience/web-profiles'; 





        if($createdProfile === ''){
            // create profile for no shipiing
            $site_title = get_bloginfo();

            $profile = array (
                           "name" => $site_title,
                           "presentation" => array(
                                       "brand_name"  => $site_title.$sandbox_profile,

                                       ),
                           "input_fields" => array( 
                                       "allow_note"=> true,
                                       "no_shipping"=> 0,
                                       "address_override"=> 1)

                           );
            $json           =   json_encode($profile);
            $json_resp      =   wpestate_make_post_call($url, $json,$token);
            $createdProfile =   $json_resp['id'];
            if( $paypal_status=='live' ){
                update_option( 'paypal_web_profile_live', $json_resp['id'] );           
            }else{
                update_option( 'paypal_web_profile_sandbox', $json_resp['id'] );  
            }
        }


        $url                =   $host.'/v1/payments/payment';
        $dash_link          =   wpestate_get_template_link('user_dashboard.php');
        $processor_link     =   wpestate_get_template_link('processor.php');


        $payment = array(
                        'intent' => 'sale',
                        "experience_profile_id" =>  $createdProfile,
                        "redirect_urls"=>array(
                                "return_url"            =>  $processor_link,                  
                                "cancel_url"            =>  $dash_link
                            ),
                        'payer' => array("payment_method"=>"paypal"),

                    );


        $payment['transactions'][0] = array(
                                            'amount' => array(
                                                'total' => $total_price,
                                                'currency' => $submission_curency_status,
                                                'details' => array(
                                                    'subtotal' => $total_price,
                                                    'tax' => '0.00',
                                                    'shipping' => '0.00'
                                                    )
                                                ),
                                            'description' => $pay_description
                                           );
         // prepare individual items


        if ($is_upgrade==1){
                $payment['transactions'][0]['item_list']['items'][] = array(
                                                'quantity' => '1',
                                                'name' => __('Upgrade to Featured Listing','wpestate'),
                                                'price' => $total_price,
                                                'currency' => $submission_curency_status,
                                                'sku' => 'Upgrade Featured Listing',
                                                );
        }else{
               if( $is_featured==0 ){
                    $payment['transactions'][0]['item_list']['items'][] = array(
                                                         'quantity' => '1',
                                                         'name' => __('Listing Payment','wpestate'),
                                                         'price' => $total_price,
                                                         'currency' => $submission_curency_status,
                                                         'sku' => 'Paid Listing',

                                                        );
                  }
                  else{
                      $payment['transactions'][0]['item_list']['items'][] = array(
                                                         'quantity' => '1',
                                                         'name' => __('Listing Payment with Featured option','wpestate'),
                                                         'price' => $total_price,
                                                         'currency' => $submission_curency_status,
                                                         'sku' => 'Featured Paid Listing',
                                                         );

                  } // end is featured
        } // end is upgrade




        $json       =   json_encode($payment);
        $json_resp  =   wpestate_make_post_call($url, $json,$token);
        foreach ($json_resp['links'] as $link) {
                if($link['rel'] == 'execute'){
                    $payment_execute_url    = $link['href'];
                    $payment_execute_method = $link['method'];
                } else if($link['rel'] == 'approval_url'){
                    $payment_approval_url       = $link['href'];
                    $payment_approval_method    = $link['method'];
                }
        }





        $executor['paypal_execute']     =   $payment_execute_url;
        $executor['paypal_token']       =   $token;
        $executor['listing_id']         =   $prop_id;
        $executor['is_featured']        =   $is_featured;
        $executor['is_upgrade']         =   $is_upgrade;
        $save_data[$current_user->ID]   =   $executor;
        update_option('paypal_transfer',$save_data);

        print ($payment_approval_url);

        die();
    }
endif; // end   wpestate_ajax_listing_pay 
  
  
  
////////////////////////////////////////////////////////////////////////////////
/// pay via paypal - per listing
////////////////////////////////////////////////////////////////////////////////

add_action( 'wp_ajax_wpestate_ajax_resend_for_approval', 'wpestate_ajax_resend_for_approval' );  
if( !function_exists('wpestate_ajax_resend_for_approval') ):

    function wpestate_ajax_resend_for_approval(){ 
    
        $current_user   =   wp_get_current_user();
        $prop_id        =   intval($_POST['propid']);
        $userID         =   $current_user->ID;
        $post           =   get_post($prop_id); 

        if ( !is_user_logged_in() ) {   
            exit('ko');
        }

        if($userID === 0 ){
            exit('out pls');
        }
        
        
        $accont_owner       = $userID;
        $agent_id           = get_user_meta($userID,'user_agent_id',true);
       
        
        $owner_author_id    = intval(get_post_field( 'post_author', $agent_id)  );
        
        
        if($owner_author_id!=0 && $owner_author_id!=1){
            $accont_owner=$owner_author_id;
        }
      
        $agent_list                     =   (array)get_user_meta($accont_owner,'current_agent_list',true);
      
        
        if( $post->post_author != $userID ){
            if(!in_array($post->post_author , $agent_list)){
                exit('get out of my cloud');
            }
        }

 
        
        
        $free_list  =   get_user_meta($accont_owner, 'package_listings',true);

        if( $free_list>0 ||  $free_list==-1 ){

            $paid_submission_status     =   esc_html ( get_option('wp_estate_paid_submission','') );
            $new_status                 =   'pending';
            $admin_submission_status    =   esc_html ( get_option('wp_estate_admin_submission','') );
            if($admin_submission_status=='no' && $paid_submission_status!='per listing'){
                $new_status='publish';  
            }

            $prop = array(
                'ID'            => $prop_id,
                'post_type'     => 'estate_property',
                'post_status'   =>  $new_status
            );
            
            wp_update_post($prop );
            update_post_meta($prop_id, 'prop_featured', 0); 

            if($free_list!=-1){ // if !unlimited
                update_user_meta($accont_owner, 'package_listings',$free_list-1);
            }
            print __('Sent for approval','wpestate');
            $submit_title   =   get_the_title($prop_id);
            $arguments=array(
                'submission_title'        =>    $submit_title,
                'submission_url'          =>    get_permalink($prop_id)
            );

            wpestate_select_email_type(get_option('admin_email'),'admin_expired_listing',$arguments);



        }else{
            print __('no listings available','wpestate');
        }
        die();
     
  
     
   }
  
 endif; // end   wpestate_ajax_resend_for_approval 
 
 
 
 
//////////////////////////////////////////////////////////////////////////////
/// Ajax adv search contact function
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_wpestate_ajax_agent_contact_form', 'wpestate_ajax_agent_contact_form' );  
add_action( 'wp_ajax_wpestate_ajax_agent_contact_form', 'wpestate_ajax_agent_contact_form' );  

if( !function_exists('wpestate_ajax_agent_contact_form') ):

    function wpestate_ajax_agent_contact_form(){
    
        // check for POST vars
        $hasError       =   false; 
        $allowed_html   =   array();
        $to_print       =   '';
        
        if ( !wp_verify_nonce( $_POST['nonce'], 'ajax-property-contact')) {
            exit("No naughty business please");
        }   
       
        
        if ( isset($_POST['name']) ) {
            if( trim($_POST['name']) =='' || trim($_POST['name']) ==__('Your Name','wpestate') ){
                echo json_encode(array('sent'=>false, 'response'=>__('The name field is empty !','wpestate') ));         
                exit(); 
            }else {
                $name = sanitize_text_field (wp_kses( trim($_POST['name']),$allowed_html) );
            }          
        } 

        //Check email
        if ( isset($_POST['email']) || trim($_POST['name']) ==__('Your Email','wpestate') ) {
            if( trim($_POST['email']) ==''){
                echo json_encode(array('sent'=>false, 'response'=>__('The email field is empty','wpestate' ) ) );      
                exit(); 
            } else if( filter_var($_POST['email'],FILTER_VALIDATE_EMAIL) === false) {
                echo json_encode(array('sent'=>false, 'response'=>__('The email doesn\'t look right !','wpestate') ) ); 
                exit();
            } else {
                $email = sanitize_text_field ( wp_kses( trim($_POST['email']),$allowed_html) );
            }
        }

        
        
        $phone   = sanitize_text_field(wp_kses( trim($_POST['phone']),$allowed_html) );
        $subject =__('Contact form from ','wpestate') . home_url() ;

        //Check comments 
        if ( isset($_POST['comment']) ) {
            if( trim($_POST['comment']) =='' || trim($_POST['comment']) ==__('Your Message','wpestate')){
                echo json_encode(array('sent'=>false, 'response'=>__('Your message is empty !','wpestate') ) ); 
                exit();
            }else {
                $comment = sanitize_text_field(wp_kses($_POST['comment'] ,$allowed_html ));
            }
        } 

        $message    =   '';
        $propid     =   intval($_POST['propid']);
        $agent_id   =   intval($_POST['agent_id']);
        
        $schedule_mesaj =   '';
        $schedule_hour  =   esc_html($_POST['schedule_hour']);
        $schedule_day   =   esc_html($_POST['schedule_day']);
        
        if($schedule_hour!='' && $schedule_day!=''){
            $schedule_mesaj = sprintf (__('I would like to schedule a viewing on %s at %s. Please confirm the meeting via email or private message. ','wpestate'),$schedule_day,$schedule_hour);
        }
        
//        if($agent_id!=0){
//           wpestate_insert_calendar($agent_id,$name,$email,$phone,$schedule_day,$schedule_hour);
//        }
         
       
         
                
        if($propid!=0){
            $permalink  = get_permalink(  $propid );
              
            if($agent_id!=0){
                $agent_agency_dev_id    =   intval(get_post_meta($agent_id,'user_meda_id',true));
                $receiver_email         =   get_the_author_meta( 'user_email' , $agent_agency_dev_id );
                
                if($receiver_email==''){
                    $receiver_email =   esc_html( get_post_meta($agent_id, 'agent_email', true) );
                }
                
            }else{
                $the_post       =   get_post( $propid); 
                $author_id      =   $the_post->post_author;
                $receiver_email =   get_the_author_meta( 'user_email' ,$author_id ); 
            }
        }else if($agent_id!=0){
            $permalink      =   get_permalink(  $agent_id );
            
            $agent_agency_dev_id    =   intval(get_post_meta($agent_id,'user_meda_id',true));
            $receiver_email         =   get_the_author_meta( 'user_email' , $agent_agency_dev_id );
            if($agent_agency_dev_id==0 && $receiver_email==''){
                $receiver_email =   esc_html( get_post_meta($agent_id, 'agent_email', true) );
            }
            
        }else{
            $permalink      =   'contact page';
            $receiver_email =   esc_html( get_option('wp_estate_email_adr', ''));
        }
        
      
     
        
        
        $message    .=  __('Client Name','wpestate').": " . $name . "\n\n ".__('Email','wpestate').": " . $email . " \n\n ".__('Phone','wpestate').": " . $phone . " \n\n ".__('Subject','wpestate').": " . $subject . " \n\n".__('Message','wpestate').": \n " . $comment;
        $message    .=  "\n\n".__('Message sent from ','wpestate').$permalink;
        
        if($schedule_mesaj!=''){
            $message .="\n\n".$schedule_mesaj;
        }
        
        $headers    =   'From: No Reply <noreply@'.$_SERVER['HTTP_HOST'].'>' . "\r\n";
        $message    =   stripslashes($message);
        $mail                       =  @wp_mail($receiver_email, $subject, $message, $headers);
        $duplicate_email_adr        =   esc_html ( get_option('wp_estate_duplicate_email_adr','') );
        
        if( $duplicate_email_adr!='' ){
            $message = $message.' '.__('Message was also sent to ','wpestate').$receiver_email;
            wp_mail($duplicate_email_adr, $subject, $message, $headers);
        }
        
        if($propid!=0){
            $agents_secondary   =   get_post_meta($propid, 'property_agent_secondary', true);
            foreach($agents_secondary  as $key=>$value){
                $receiver_email= esc_html( get_post_meta($value, 'agent_email', true) );
                wp_mail($receiver_email, $subject, $message, $headers);
            }
        
        }
                
        $response   =__('The message was sent ! ','wpestate');

        if( $schedule_mesaj!=''){
            $response.=__('Your showing request will be confirmed via email or private message.','wpestate');
        }  

        echo json_encode(array('sent'=>true, 'response'=>$response) ); 

                
      
        die(); 
        
        
}

endif; // end   wpestate_ajax_agent_contact_form 


if( !function_exists('wpestate_insert_calendar') ):
    function wpestate_insert_calendar($agent_id,$name,$email,$phone,$schedule_day,$schedule_hour){
        $calendar=get_post_meta($agent_id,'agent_calendar',true);

        if(!is_array($calendar)){
            $calendar=array();
        }
        $temp_array = array();
        $temp_array['status']=0;
        $temp_array['name']=$name;
        $temp_array['email']=$email;
        $temp_array['phone']=$phone;
        $date= strtotime ($schedule_day.' '.$schedule_hour);

        if( isset( $calendar[$date]) && $calendar[$date]!='' ){
            $response =$schedule_day.$schedule_hour. __('The date & time is already booked. Please choose a new one','wpestate');
            $response.=implode('|',$calendar);
            echo json_encode(array('sent'=>true, 'response'=>$response ) ); 
            die();
        }else{
            $calendar[$date] = $temp_array;
            update_post_meta($agent_id,'agent_calendar',$calendar);
        }
    }
         
endif;


//////////////////////////////////////////////////////////////////////////////
/// Ajax adv search contact function
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_wpestate_ajax_contact_form_footer', 'wpestate_ajax_contact_form_footer' );  
add_action( 'wp_ajax_wpestate_ajax_contact_form_footer', 'wpestate_ajax_contact_form_footer' );  

if( !function_exists('wpestate_ajax_contact_form_footer') ):

function wpestate_ajax_contact_form_footer(){
        $hasError       = false;
        $to_print       =   '';
        $allowed_html   =   array();
        check_ajax_referer( 'ajax-footer-contact', 'nonce');
        
        
        if ( isset($_POST['name']) ) {
            if( trim($_POST['name']) =='' || trim($_POST['name']) ==__('Your Name','wpestate') ){
                echo json_encode(array('sent'=>false, 'response'=>__('The name field is empty !','wpestate') ));         
                exit(); 
            }else {
                $name = wp_kses( trim($_POST['name']),$allowed_html );
            }          
        } 

        //Check email
        if ( isset($_POST['email']) || trim($_POST['name']) ==__('Your Email','wpestate') ) {
            if( trim($_POST['email']) ==''){
                echo json_encode(array('sent'=>false, 'response'=>__('The email field is empty','wpestate' ) ) );      
                exit(); 
            } else if( filter_var($_POST['email'],FILTER_VALIDATE_EMAIL) === false) {
                echo json_encode(array('sent'=>false, 'response'=>__('The email doesn\'t look right !','wpestate') ) ); 
                exit();
            } else {
                $email = wp_kses( trim($_POST['email']),$allowed_html );
            }
        }

        
        
        $phone = wp_kses( trim($_POST['phone']),$allowed_html );
     
        //Check comments 
        if ( isset($_POST['contact_coment']) ) {
            if( trim($_POST['contact_coment']) ==''){
                echo json_encode(array('sent'=>false, 'response'=>__('Your message is empty !','wpestate') ) ); 
                exit();
            }else {
                $comment = wp_kses( trim ($_POST['contact_coment'] ) ,$allowed_html);
            }
        } 

      
        $receiver_email =   esc_html( get_option('wp_estate_email_adr', ''));
        $message        =   '';
        
        $subject        =   __('Contact form from ','wpestate') . home_url() ;
        $message        .=  __('Client Name','wpestate').": ". $name . "\n\n".__('Email','wpestate').": " . $email . " \n\n ".__('Phone','wpestate').": " . $phone . " \n\n ".__("Subject",'wpestate').": " . $subject . " \n\n".__('Message','wpestate').":\n " . $comment;
        $message        .=  "\n\n ".__('Message sent from shortcode contact form','wpestate');
        $message        =   stripslashes($message);
        $headers        =   'From: noreply  <noreply@'.$_SERVER['HTTP_HOST'].'>' . "\r\n".
                            'Reply-To: noreply@'.$_SERVER['HTTP_HOST']. "\r\n" .
                            'X-Mailer: PHP/' . phpversion();
        wp_mail($receiver_email, $subject, $message, $headers);
  
        echo json_encode(array('sent'=>true, 'response'=>__('The message was sent !','wpestate') ) ); 
        die(); 
        
    }

endif; // end   ajax_agent_contact_form 







////////////////////////////////////////////////////////////////////////////////
/// Ajax  Package Paypal function
////////////////////////////////////////////////////////////////////////////////

add_action( 'wp_ajax_wpestate_ajax_paypal_pack_generation', 'wpestate_ajax_paypal_pack_generation' );  

if( !function_exists('wpestate_ajax_paypal_pack_generation') ):

function wpestate_ajax_paypal_pack_generation(){
   
    $current_user   =   wp_get_current_user();
    $userID         =   $current_user->ID;
    
    if ( !is_user_logged_in() ) {   
        exit('ko');
    }
    
    if($userID === 0 ){
        exit('out pls');
    }
    
    $allowed_html   =   array();
    $packName       =   esc_html(wp_kses($_POST['packName'],$allowed_html));
    $pack_id        =   intval($_POST['packId']);
    $is_pack        =   get_posts('post_type=membership_package&p='.$pack_id);
    
    
    if( !empty ( $is_pack ) ) {
            
            $pack_price                     =   get_post_meta($pack_id, 'pack_price', true);
            $submission_curency_status      =   esc_html( get_option('wp_estate_submission_curency','') );
            $paypal_status                  =   esc_html( get_option('wp_estate_paypal_api','') );
          
            $host                           =   'https://api.sandbox.paypal.com';
            if($paypal_status=='live'){
                $host   =   'https://api.paypal.com';
            }
            
            $url        = $host.'/v1/oauth2/token'; 
            $postArgs   = 'grant_type=client_credentials';
            $token      = wpestate_get_access_token($url,$postArgs);
            $url        = $host.'/v1/payments/payment';
            

           $dash_profile_link = wpestate_get_template_link('user_dashboard_profile.php');


            $payment = array(
                            'intent' => 'sale',
                            "redirect_urls"=>array(
                                "return_url"=>$dash_profile_link,
                                "cancel_url"=>$dash_profile_link
                                ),
                            'payer' => array("payment_method"=>"paypal"),

                );

            
                    $payment['transactions'][0] = array(
                                        'amount' => array(
                                            'total' => $pack_price,
                                            'currency' => $submission_curency_status,
                                            'details' => array(
                                                'subtotal' => $pack_price,
                                                'tax' => '0.00',
                                                'shipping' => '0.00'
                                                )
                                            ),
                                        'description' => $packName.' '.__('membership payment on ','wpestate').get_bloginfo('url')
                                       );

                    //
                    // prepare individual items
                    $payment['transactions'][0]['item_list']['items'][] = array(
                                                            'quantity' => '1',
                                                            'name' => __('Membership Payment','wpestate'),
                                                            'price' => $pack_price,
                                                            'currency' => $submission_curency_status,
                                                            'sku' => $packName.' '.__('Membership Payment','wpestate'),
                                                           );
                   
                    
                    $json = json_encode($payment);
                    $json_resp = wpestate_make_post_call($url, $json,$token);
                    foreach ($json_resp['links'] as $link) {
                            if($link['rel'] == 'execute'){
                                    $payment_execute_url = $link['href'];
                                    $payment_execute_method = $link['method'];
                            } else 	if($link['rel'] == 'approval_url'){
                                            $payment_approval_url = $link['href'];
                                            $payment_approval_method = $link['method'];
                                    }
                    }



                    $executor['paypal_execute']     =   $payment_execute_url;
                    $executor['paypal_token']       =   $token;
                    $executor['pack_id']            =   $pack_id;
                    $save_data[$current_user->ID ]  =   $executor;
                    update_option('paypal_pack_transfer',$save_data);
                    print ($payment_approval_url);
       }
       die();
}

endif; // end   ajax_paypal_pack_generation  - de la ajax_upload





////////////////////////////////////////////////////////////////////////////////
/// Ajax  Package Paypal function - recuring payments
////////////////////////////////////////////////////////////////////////////////

add_action( 'wp_ajax_wpestate_ajax_paypal_pack_recuring_generation', 'wpestate_ajax_paypal_pack_recuring_generation' );  
   
if( !function_exists('wpestate_ajax_paypal_pack_recuring_generation') ):

function wpestate_ajax_paypal_pack_recuring_generation(){
    $current_user   =   wp_get_current_user();
    $userID         =   $current_user->ID;
    
    if ( !is_user_logged_in() ) {   
        exit('ko');
    }
    
    if($userID === 0 ){
        exit('out pls');
    }
    
    $allowed_html=array();
    $packName   =   wp_kses($_POST['packName'],$allowed_html);
    $pack_id    =   intval($_POST['packId']);
    $is_pack    =   get_posts('post_type=membership_package&p='.$pack_id);
    
    if( !empty ( $is_pack ) ) {
        require('resources/paypalfunctions.php');
        global $current_user;

       
        $pack_price                     =   get_post_meta($pack_id, 'pack_price', true);
        $billing_period                 =   get_post_meta($pack_id, 'biling_period', true);
        $billing_freq                   =   intval(get_post_meta($pack_id, 'billing_freq', true));
        $pack_name                      =   get_the_title($pack_id);
        $submission_curency_status      =   esc_html( get_option('wp_estate_submission_curency','') );
        $paypal_status                  =   esc_html( get_option('wp_estate_paypal_api','') );
        $paymentType                    =   "Sale";
        
        $dash_profile_link              =   wpestate_get_template_link('user_dashboard_profile.php');
     
        $obj=new paypal_recurring;
        $obj->environment               =   esc_html( get_option('wp_estate_paypal_api','') );
        $obj->paymentType               =   urlencode('Sale');
        $obj->productdesc               =   urlencode($pack_name.__(' package on ','wpestate').get_bloginfo('name') );
        $time                           =   time(); 
        $date                           =   date('Y-m-d H:i:s',$time); 
        $obj->startDate                 =   urlencode($date);
        $obj->billingPeriod             =   urlencode($billing_period);         
        $obj->billingFreq               =   urlencode($billing_freq);                
        $obj->paymentAmount             =   urlencode($pack_price);
        $obj->currencyID                =   urlencode($submission_curency_status);  
        $paypal_api_username            =   ( get_option('wp_estate_paypal_api_username','') );
        $paypal_api_password            =   ( get_option('wp_estate_paypal_api_password','') );
        $paypal_api_signature           =   ( get_option('wp_estate_paypal_api_signature','') );    
        $obj->API_UserName              =   urlencode( $paypal_api_username );
        $obj->API_Password              =   urlencode( $paypal_api_password );
        $obj->API_Signature             =   urlencode( $paypal_api_signature );
        $obj->API_Endpoint              =   "https://api-3t.paypal.com/nvp";
        $obj->returnURL                 =   urlencode($dash_profile_link);
        $obj->cancelURL                 =   urlencode($dash_profile_link);   
        $executor['paypal_execute']     =   '';
        $executor['paypal_token']       =   '';
        $executor['pack_id']            =   $pack_id;
        $executor['recursive']          =   1;
        $executor['date']               =   $date;
        $save_data[$current_user->ID ]  =   $executor;
        update_option('paypal_pack_transfer',$save_data);
         
        $obj->setExpressCheckout();
          

    }
}

endif; // end   wpestate_ajax_paypal_pack_recuring_generation  - de la ajax_upload


// drozone ajax functionalityu
add_action('wp_ajax_dropzone_upload_action', 'wat_dropzone_upload_action');
add_action('wp_ajax_nopriv_dropzone_upload_action', 'wat_dropzone_upload_action');

function wat_dropzone_upload_action(){
	global $current_user, $wpdb;
 
 
 $fp = fopen('data_ajax_called.txt', 'w');
fwrite($fp, '1');
fwrite($fp, '23');
fclose($fp);
 
	if( wp_verify_nonce( $_POST['wpestate_upload_nonce'], 'wpestate_upload_action' )  ){
		$current_user   =   wp_get_current_user();
        $userID         =   $current_user->ID;
    
        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }
        
        $filename       =   convertAccentsAndSpecialToNormal($_FILES['dropzone_file']['tmp_name']);
        $base           =   '';
        $allowed_html   =   array();
        
        list($width, $height) = getimagesize($filename);
        
        if(isset($_GET['base'])){
            $base   =   esc_html( wp_kses( $_GET['base'], $allowed_html ) );
        }
        
        $file = array(
            'name'      => convertAccentsAndSpecialToNormal($_FILES['dropzone_file']['name']),
            'type'      => $_FILES['dropzone_file']['type'],
            'tmp_name'  => $_FILES['dropzone_file']['tmp_name'],
            'error'     => $_FILES['dropzone_file']['error'],
            'size'      => $_FILES['dropzone_file']['size'],
            'width'     =>  $width,
            'height'    =>  $height,
            'base'      =>  $base
        );
        $file = fileupload_process($file);
	}
	die();
}


// front submit check login/pass
add_action( 'wp_ajax_nopriv_wpestate_front_property_submit', 'wpestate_wpestate_front_property_submit' );  
add_action( 'wp_ajax_wpestate_front_property_submit', 'wpestate_wpestate_front_property_submit' );

if( !function_exists('wpestate_wpestate_front_property_submit') ):
    function wpestate_wpestate_front_property_submit(){
		
 
        $action_type               =   sanitize_text_field($_POST['action_type']);
        $front_user_login                =   sanitize_text_field($_POST['front_user_login']);
        $front_user_name             =   sanitize_text_field($_POST['front_user_name']);
        $front_user_pass               =   sanitize_text_field($_POST['front_user_pass']);
        $front_user_email             =   sanitize_text_field($_POST['front_user_email']);
     
	 
		if( $action_type == 'login' ){
			$user = get_user_by( 'login', $front_user_login );
			if ( $user && wp_check_password( $front_user_pass, $user->data->user_pass, $user->ID) ){
				
				//wp_clear_auth_cookie();
				wp_set_current_user ( $user->ID );
				wp_set_auth_cookie  ( $user->ID );
				
				echo json_encode( array( 'result' => 'success', 'redirect' => wpestate_get_template_link( 'front_property_submit.php' ) ) );
			}else{
				echo json_encode( array( 'result' => 'error', 'message' => __('Unable to login. Please, check login/password and try again', 'wpestate') ) );
			}
		}
		if( $action_type == 'register' ){
 
			$user_id = username_exists( $front_user_name );
			
			if( !is_email($front_user_email) ){
				echo json_encode( array( 'result' => 'error', 'message' => __('Please, enter correct email', 'wpestate') ) );
				die();
			}
			
			
			if ( !$user_id and email_exists($front_user_email) == false ) {
				$random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );
				$user_id = wp_create_user( $front_user_name, $random_password, $front_user_email );
				if( $user_id ){
					//wp_clear_auth_cookie();
					wp_set_current_user ( $user_id );
					wp_set_auth_cookie  ( $user_id );
					echo json_encode( array( 'result' => 'success', 'redirect' => wpestate_get_template_link( 'front_property_submit.php' ) ) );
				}else{
					echo json_encode( array( 'result' => 'error', 'message' => __('Can\t create user with this credentials', 'wpestate') ) );
				}
				
			} else {
				echo json_encode( array( 'result' => 'error', 'message' => __('Sorry, user already exists. Try different username/email', 'wpestate') ) );
			}
			
			
		}
		die();
    }
endif;



////////////////////////////////////////////////////////////////////////////////
/// Ajax  Package Paypal function - recuring payments REST API
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_wpestate_ajax_paypal_pack_recuring_generation_rest_api', 'wpestate_ajax_paypal_pack_recuring_generation_rest_api' );  
   
if( !function_exists('wpestate_ajax_paypal_pack_recuring_generation_rest_api') ):

    function wpestate_ajax_paypal_pack_recuring_generation_rest_api(){
        $current_user   =   wp_get_current_user();
        $userID         =   $current_user->ID;
        
        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }

        $allowed_html   =   array();
        $packName       =   wp_kses($_POST['packName'],$allowed_html);
        $pack_id        =   intval($_POST['packId']);
        if(!is_numeric($pack_id)){
            exit();
        }

        
        $is_pack = get_posts('post_type=membership_package&p='.$pack_id);
        if( !empty ( $is_pack ) ) {
            $pack_price                     =   get_post_meta($pack_id, 'pack_price', true);
            $billing_period                 =   get_post_meta($pack_id, 'biling_period', true);
            $billing_freq                   =   intval(get_post_meta($pack_id, 'billing_freq', true));
            $pack_name                      =   get_the_title($pack_id);
            $submission_curency_status      =   esc_html( get_option('wp_estate_submission_curency','') );
            
            $host                           =   'https://api.sandbox.paypal.com';
            $paypal_status                  =   esc_html( get_option('wp_estate_paypal_api','') );
            if($paypal_status=='live'){
                $host   =   'https://api.paypal.com';
            }
            $url        = $host.'/v1/oauth2/token'; 
            $postArgs   = 'grant_type=client_credentials';
          
            $token      = wpestate_get_access_token($url,$postArgs);
            
          
            $payment_plan = get_post_meta($pack_id, 'paypal_payment_plan_'.$paypal_status, true);
    
          
            if( !is_array($payment_plan) || $payment_plan==''){
                wpestate_create_paypal_payment_plan($pack_id,$token);
                $payment_plan = get_post_meta($pack_id, 'paypal_payment_plan_'.$paypal_status, true);
            }

            $url        = $host.'/v1/payments/billing-plans/'.$payment_plan['id'];
       
            $json_resp  = wpestate_make_get_call($url,$token);
       
          
            
            
            if( $json_resp['state']!='ACTIVE' ){
                wpestate_activate_paypal_payment_plan( $json_resp['id'],$token);
            }
            
            echo wpestate_create_paypal_payment_agreement($pack_id,$token);
            die();
             

        }
    }

    
endif;

?>
