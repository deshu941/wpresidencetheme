<?php
class Footer_latest_widget extends WP_Widget {
<<<<<<< HEAD
	
	function footer_latest_widget(){
		$widget_ops = array('classname' => 'latest_listings', 'description' => 'Show latest listings.');
		$control_ops = array('id_base' => 'footer_latest_widget');
		$this->WP_Widget('footer_latest_widget', 'Wp Estate: Latest Listing ', $widget_ops, $control_ops);
=======
	function __construct(){
	//function footer_latest_widget(){
		$widget_ops = array('classname' => 'latest_listings', 'description' => 'Show latest listings.');
		$control_ops = array('id_base' => 'footer_latest_widget');
		//$this->WP_Widget('footer_latest_widget', 'Wp Estate: Latest Listing ', $widget_ops, $control_ops);
                parent::__construct('footer_latest_widget', 'Wp Estate: Latest Listing ', $widget_ops, $control_ops);
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
	}
	 
	function form($instance){
		$defaults = array('title'                       =>  'Latest Listing',
                                  'listing_no'                  =>  3,
                                   'adv_filter_search_action'   =>  '',
                                   'adv_filter_search_category' =>  '',
                                   'current_adv_filter_city'    =>  '',
                                   'current_adv_filter_area'    =>  '',
<<<<<<< HEAD
                                   'show_featured_only'         =>  ''
=======
                                   'show_featured_only'         =>  '',
                                   'show_as_slider'             =>  'list',
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
                    );
		$instance = wp_parse_args((array) $instance, $defaults);
                
                
                $args = array(
                    'hide_empty'    => false 
                );  

                $actions_select     =   '';
                $categ_select       =   '';
                $taxonomy           =   'property_action_category';
                $tax_terms          =   get_terms($taxonomy,$args);

                $current_adv_filter_search_action = $instance['adv_filter_search_action'];
                if($current_adv_filter_search_action==''){
                    $current_adv_filter_search_action=array();
                }


                $all_selected='';
                if(!empty($current_adv_filter_search_action) &&  in_array  (__('all','wpestate'),$current_adv_filter_search_action)  ){
                  $all_selected=' selected="selected" ';  
                }

                $actions_select.='<option value="all" '.$all_selected.'>'.__('all','wpestate').'</option>';
                if( !empty( $tax_terms ) ){                       
                    foreach ($tax_terms as $tax_term) {
                        $actions_select .= '<option value="'.$tax_term->name.'" ';
                        if( in_array  ( $tax_term->name,$current_adv_filter_search_action) ){
                          $actions_select .= ' selected="selected" ';  
                        }
                        $actions_select .=' >'.$tax_term->name.'</option>';      
                    } 
                }



                //////////////////////////////////////////////////////////////////////////////////////////
                $taxonomy           =   'property_category';
                $tax_terms          =   get_terms($taxonomy,$args);

                $current_adv_filter_search_category = $instance['adv_filter_search_category'];
                if($current_adv_filter_search_category==''){
                    $current_adv_filter_search_category=array();
                }

                $all_selected='';
                if( !empty($current_adv_filter_search_category) && $current_adv_filter_search_category[0]=='all'){
                  $all_selected=' selected="selected" ';  
                }

                $categ_select.='<option value="all" '.$all_selected.'>'.__('all','wpestate').'</option>';
                if( !empty( $tax_terms ) ){                       
                    foreach ($tax_terms as $tax_term) {
                        $categ_select.='<option value="'.$tax_term->name.'" ';
                        if( in_array  ( $tax_term->name, $current_adv_filter_search_category) ){
                          $categ_select.=' selected="selected" ';  
                        }
                        $categ_select.=' >'.$tax_term->name.'</option>';      
                    } 
                }


             //////////////////////////////////////////////////////////////////////////////////////////   

                $select_city='';
                $taxonomy = 'property_city';
                $tax_terms_city = get_terms($taxonomy,$args);
                $current_adv_filter_city =  $instance['current_adv_filter_city'];

                if($current_adv_filter_city==''){
                    $current_adv_filter_city=array();
                }

                $all_selected='';
                if( !empty($current_adv_filter_city) && $current_adv_filter_city[0]=='all'){
                  $all_selected=' selected="selected" ';  
                }

                $select_city.='<option value="all" '.$all_selected.' >'.__('all','wpestate').'</option>';
                foreach ($tax_terms_city as $tax_term) {

                    $select_city.= '<option value="' . $tax_term->name . '" ';
                    if( in_array  ( $tax_term->name, $current_adv_filter_city) ){
                          $select_city.=' selected="selected" ';  
                    }
                    $select_city.= '>' . $tax_term->name . '</option>';
                } 


             //////////////////////////////////////////////////////////////////////////////////////////   

                $select_area='';
                $taxonomy = 'property_area';
                $tax_terms_area = get_terms($taxonomy,$args);
                $current_adv_filter_area =  $instance['current_adv_filter_area']; 
                if($current_adv_filter_area==''){
                    $current_adv_filter_area=array();
                }

                $all_selected='';
                if(!empty($current_adv_filter_area) && $current_adv_filter_area[0]=='all'){
                  $all_selected=' selected="selected" ';  
                }

                $select_area.='<option value="all" '.$all_selected.'>'.__('all','wpestate').'</option>';
                foreach ($tax_terms_area as $tax_term) {
                    $term_meta=  get_option( "taxonomy_$tax_term->term_id");
                    $select_area.= '<option value="' . $tax_term->name . '" ';
                    if( in_array  ( $tax_term->name, $current_adv_filter_area) ){
                          $select_area.=' selected="selected" ';  
                    }
                    $select_area.= '>' . $tax_term->name . '</option>';
                } 

                //////////////////////////////////   
    
                   
 
                $cache_array                =   array('yes','no');
                $show_featured_only_select  =   '';
                $show_featured_only         =   $instance['show_featured_only'];
                foreach($cache_array as $value){
                    $show_featured_only_select.='<option value="'.$value.'" ';
                    if ( $show_featured_only == $value ){
                        $show_featured_only_select.=' selected="selected" ';
                    }
                    $show_featured_only_select.='>'.$value.'</option>';
                }

                 //////////////////////////////////   
                
		$display='
                <p>
                    <label for="'.$this->get_field_id('title').'">Title:</label> </br>  
                    <input id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" value="'.$instance['title'].'" />
		</p>

                <p>
                   <label for="'.$this->get_field_id('listing_no').'">How many Listings:</label> </br>  		
                   <input id="'.$this->get_field_id('listing_no').'" name="'.$this->get_field_name('listing_no').'" value="'.$instance['listing_no'].'" />
		</p>
                
                <p>               
                    <label   for="'.$this->get_field_id('adv_filter_search_action').'">Pick actions</label> </br>            
                    <select id="'.$this->get_field_id('adv_filter_search_action').'" name="'.$this->get_field_name('adv_filter_search_action').'[]"   multiple="multiple" style="width:250px;" >
                        '.$actions_select.'
                    </select>
                </p>

                <p>
                    <label for="'.$this->get_field_id('adv_filter_search_category').'">Pick category</label> </br>          
                    <select id="'.$this->get_field_id('adv_filter_search_category').'"  name="'.$this->get_field_name('adv_filter_search_category').'[]"  multiple="multiple" style="width:250px;" >
                        '.$categ_select.'
                    </select>
                </p>
                
                <p>
                    <label for="'.$this->get_field_id('current_adv_filter_city').'">Pick City</label> </br>
                    <select  id="'.$this->get_field_id('current_adv_filter_city').'" name="'.$this->get_field_name('current_adv_filter_city').'[]"  multiple="multiple" style="width:250px;" >
                        '.$select_city.'
                    </select>
                </p>
                
                 <p>
                    <label for="'.$this->get_field_id('current_adv_filter_area').'">Pick Area</label> </br>
                    <select id="'.$this->get_field_id('current_adv_filter_area').'"  name="'.$this->get_field_name('current_adv_filter_area').'[]"  multiple="multiple" style="width:250px;" >
                        '.$select_area.'
                    </select>
                </p>
                
                <p>
                    <label for="'.$this->get_field_id('show_featured_only').'">Show featured only </label><br />
                    <select id="'.$this->get_field_id('show_featured_only').'"  name="'.$this->get_field_name('show_featured_only').'" style="width:250px;" >
                        '.$show_featured_only_select.'
                    </select>
<<<<<<< HEAD
                </p>';
                
		print $display;
=======
                </p>
                
                <p>
                    <label for="'.$this->get_field_id('show_as_slider').'">Show as List or Slider ? </label><br />
                    <input type="radio" name="'.$this->get_field_name('show_as_slider').'" value="list"'; 
                    if( $instance['show_as_slider'] == 'list'){
                        $display.= ' checked ';
                    }
                    $display.='>List<br>
                    <input type="radio" name="'.$this->get_field_name('show_as_slider').'" value="slider"';
                    if( $instance['show_as_slider'] == 'slider'){
                        $display.= ' checked ';
                    }
                    $display.='>Slider<br>
                </p>';
                
		print $display; 
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
	}


	function update($new_instance, $old_instance){
		$instance                               =   $old_instance;
		$instance['title']                      =   $new_instance['title'];
		$instance['listing_no']                 =   $new_instance['listing_no'];
                $instance['adv_filter_search_action']   =   $new_instance['adv_filter_search_action'];
		$instance['adv_filter_search_category'] =   $new_instance['adv_filter_search_category'];
                $instance['current_adv_filter_city']    =   $new_instance['current_adv_filter_city'];
                $instance['current_adv_filter_area']    =   $new_instance['current_adv_filter_area'];
                $instance['show_featured_only']         =   $new_instance['show_featured_only'];
<<<<<<< HEAD
=======
                $instance['show_as_slider']             =   $new_instance['show_as_slider'];
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
		return $instance;
	}



	function widget($args, $instance){
		extract($args);
<<<<<<< HEAD
                $currency = get_option('wp_estate_currency_symbol', '');
                $where_currency = get_option('wp_estate_where_currency_symbol', '');
                
                $display='';
                $title = apply_filters('widget_title', $instance['title']);
=======
                $currency       =   get_option('wp_estate_currency_symbol', '');
                $where_currency =   get_option('wp_estate_where_currency_symbol', '');
                $transient_name =   'wpestate_widget_recent_query_output_'; 
                $display        =   '';
                $title          =   apply_filters('widget_title', $instance['title']);
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
                
		print $before_widget;
                if($title) {
			print $before_title.$title.$after_title;
		}
                
<<<<<<< HEAD
                $display.='<div class="latest_listings">';
=======
              
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
                
                
                ///adding custom parameters
                
<<<<<<< HEAD
                global $current_user;
                get_currentuserinfo();
=======
                $current_user = wp_get_current_user();
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
                $currency                   =   esc_html( get_option('wp_estate_currency_symbol', '') );
                $where_currency             =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
                $prop_no                    =   intval( get_option('wp_estate_prop_no', '') );
                $userID                     =   $current_user->ID;
                $user_option                =   'favorites'.$userID;
                $curent_fav                 =   get_option($user_option);
                $icons                      =   array();
<<<<<<< HEAD
                $taxonomy                   =   'property_action_category';
                $tax_terms                  =   get_terms($taxonomy);
                $taxonomy_cat               =   'property_category';
                $categories                 =   get_terms($taxonomy_cat);
=======
//                $taxonomy                   =   'property_action_category';
//                $tax_terms                  =   get_terms($taxonomy);
//                $taxonomy_cat               =   'property_category';
//                $categories                 =   get_terms($taxonomy_cat);
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
                $show_compare=1;


                $current_adv_filter_search_action       = $instance['adv_filter_search_action'];
                $current_adv_filter_search_category     = $instance['adv_filter_search_category'];
                $current_adv_filter_area                = $instance['current_adv_filter_area'];
                $current_adv_filter_city                = $instance['current_adv_filter_city'];
                $show_featured_only                     = $instance['show_featured_only'];
<<<<<<< HEAD
               

=======
                $show_as_slider                         =   'list';
                if(isset($instance['show_as_slider'])){
                    $show_as_slider                         = $instance['show_as_slider'];
                }
>>>>>>> 64662fd89bea560852792d7203888072d7452d48

                $area_array =   $city_array =   $action_array   =   $categ_array    ='';

                /////////////////////////////////////////////////////////////////////////action


                if (!empty($current_adv_filter_search_action) && $current_adv_filter_search_action[0]!='all'){
                    $taxcateg_include   =   array();

                    foreach($current_adv_filter_search_action as $key=>$value){
                        $taxcateg_include[]=sanitize_title($value);
<<<<<<< HEAD
=======
                        $transient_name.='_'.sanitize_title($value);
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
                    }

                    $categ_array=array(
                         'taxonomy' => 'property_action_category',
                         'field' => 'slug',
                         'terms' => $taxcateg_include
                    );

                    $current_adv_filter_search_label= $current_adv_filter_search_action[0];
                }else{
                     $current_adv_filter_search_label=__('All Actions','wpestate');
                }



                /////////////////////////////////////////////////////////////////////////category

                if ( !empty($current_adv_filter_search_category) && $current_adv_filter_search_category[0]!='all' ){
                    $taxaction_include   =   array();   

                    foreach( $current_adv_filter_search_category as $key=>$value){
                        $taxaction_include[]=sanitize_title($value);
<<<<<<< HEAD
=======
                        $transient_name.='_'.sanitize_title($value);
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
                    }

                    $action_array=array(
                         'taxonomy' => 'property_category',
                         'field' => 'slug',
                         'terms' => $taxaction_include
                    );
<<<<<<< HEAD
                     $current_adv_filter_category_label=$current_adv_filter_search_category[0];
=======
                    $current_adv_filter_category_label=$current_adv_filter_search_category[0];
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
                }else{
                    $current_adv_filter_category_label=__('All Types','wpestate');
                }
                /////////////////////////////////////////////////////////////////////////////

                if ( !empty( $current_adv_filter_city ) && $current_adv_filter_city[0]!='all' ) {
                     $taxaction_include   =   array();   

                    foreach( $current_adv_filter_city as $key=>$value){
                        $taxaction_include[]=sanitize_title($value);
<<<<<<< HEAD
=======
                        $transient_name.='_'.sanitize_title($value);
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
                    }

                    $city_array = array(
                        'taxonomy' => 'property_city',
                        'field' => 'slug',
                        'terms' => $taxaction_include
                    );

                    $current_adv_filter_city_label=$current_adv_filter_city[0];
                }else{
                    $current_adv_filter_city_label=__('All Cities','wpestate');
                }
                /////////////////////////////////////////////////////////////////////////////

                if ( !empty( $current_adv_filter_area ) && $current_adv_filter_area[0]!='all' ) {
                     $taxaction_include   =   array();   

                    foreach( $current_adv_filter_area as $key=>$value){
                        $taxaction_include[]=sanitize_title($value);
<<<<<<< HEAD
=======
                        $transient_name.='_'.sanitize_title($value);
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
                    }

                    $area_array = array(
                        'taxonomy' => 'property_area',
                        'field' => 'slug',
                        'terms' => $taxaction_include
                    );

                    $current_adv_filter_area_label=$current_adv_filter_area[0];
                }else{
<<<<<<< HEAD
                     $current_adv_filter_area_label=__('All Areas','wpestate');
=======
                    $current_adv_filter_area_label=__('All Areas','wpestate');
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
                }



                /////////////////////////////////////////////////////////////////////////////

                $meta_query=array();                
                if($show_featured_only=='yes'){
                    $compare_array=array();
                    $compare_array['key']        = 'prop_featured';
                    $compare_array['value']      = 1;
                    $compare_array['type']       = 'numeric';
                    $compare_array['compare']    = '=';
                    $meta_query[]                = $compare_array;
                }
<<<<<<< HEAD



                $meta_directions='DESC';
                $meta_order='prop_featured';
             
=======
               


                $meta_directions    =   'DESC';
                $meta_order         =   'prop_featured';
                
                $transient_name.='_'.$show_featured_only.'_'.$instance['listing_no'].'_'.$meta_directions.'_'.$meta_order;
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    
                $args = array(
                    'post_type'         => 'estate_property',
                    'post_status'       => 'publish',
                    'paged'             => 1,
                    'posts_per_page'    => $instance['listing_no'],
                    'orderby'           => 'id',
                    'meta_key'          => $meta_order,
                    'order'             => $meta_directions,
                    'meta_query'        => $meta_query,
                    'tax_query'         => array(
                                                'relation' => 'AND',
                                                $categ_array,
                                                $action_array,
                                                $city_array,
                                                $area_array
                                            )
                );
<<<<<<< HEAD
          //   print_r($args);
             
                add_filter( 'posts_orderby', 'wpestate_my_order' );
                $the_query = new WP_Query( $args );
                remove_filter( 'posts_orderby', 'wpestate_my_order' );

                // The Loop
                while ( $the_query->have_posts() ) :
                        $the_query->the_post();
                        
                        $price          = floatval   ( get_post_meta(get_the_ID(), 'property_price', true) );
                        $price_label    = esc_html ( get_post_meta(get_the_ID(), 'property_label', true) );
                        if ($price != '0') {
                            $price = wpestate_show_price(get_the_ID(),$currency,$where_currency,1);  
                        }else{
                            $price='';
                        }
                      
        
                        $class='no_post_th';
                        $display.='<div class="widget_latest_internal" data-link="'.get_permalink().'">';  
                       
                        $class      =   '';
                        $thumb_id   =   get_post_thumbnail_id();
                        $link       =   get_permalink();
                        $preview    =   wp_get_attachment_image_src(get_post_thumbnail_id(), 'widget_thumb'); 
                        $display    .=  '<div class="widget_latest_listing_image">
                                            <a href="'.$link.'"><img  src="'.$preview[0].'"  alt="slider-thumb" data-original="'.$preview[0].'" class="lazyload img_responsive" height="70" width="105" /></a>
                                            <div class="listing-cover"></div>
                                            <a href="'.$link.'"> <span class="listing-cover-plus">+</span></a>
                                        </div>';

                       
                        $display.='<div class="listing_name '.$class.' "><span class=widget_latest_title><a href="'.$link.'">';
                        $title=get_the_title();
                        $display.= substr( $title,0,35); 
                        if(strlen($title)>35){
                            $display.= '...';   
                        } 
            
                        $display.='</a></span>
                                        <span class=widget_latest_price>'. $price.'</span>
                                   </div>' ;
                        $display.='</div>';
                endwhile;
                
                wp_reset_query();
				
                

		$display.='</div>';
=======
                
                if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
                    $transient_name.='_'. ICL_LANGUAGE_CODE;
                }
                if ( isset($_COOKIE['my_custom_curr_symbol'] ) ){
                    $transient_name.='_'.$_COOKIE['my_custom_curr_symbol'];
                }

                if(isset($_COOKIE['my_measure_unit'])){
                    $transient_name.= $_COOKIE['my_measure_unit'];
                }
    
                $display = get_transient( $transient_name);
                if( $display === false){
                    $display.='<div class="latest_listings">';
                  
                    add_filter( 'posts_orderby', 'wpestate_my_order' );
                    $the_query = new WP_Query( $args );
                    remove_filter( 'posts_orderby', 'wpestate_my_order' );

                     if($show_as_slider=='slider'){
                        $display.='<div class="owl-featured-slider">';
                     }

                    // The Loop
                    while ( $the_query->have_posts() ) :
                            $the_query->the_post();

                            $price          =   floatval   ( get_post_meta(get_the_ID(), 'property_price', true) );
                            $price_label    =   esc_html ( get_post_meta(get_the_ID(), 'property_label', true) );
                            $price          =   wpestate_show_price(get_the_ID(),$currency,$where_currency,1);  
                            $thumb_id       =   get_post_thumbnail_id();
                            $link           =   get_permalink();
                            $title          =   get_the_title();
                            if($show_as_slider=='list'){

                                $class='no_post_th';
                                $display.='<div class="widget_latest_internal" data-link="'.get_permalink().'">';  

                                $class      =   '';


                                $preview    =   wp_get_attachment_image_src(get_post_thumbnail_id(), 'widget_thumb'); 
                                if($preview[0] ==''){
                                    $preview[0] =  get_template_directory_uri().'/img/defaults/default_widget_thumb.jpg';
                                }

                                $display    .=  '<div class="widget_latest_listing_image">
                                                    <a href="'.$link.'"><img  src="'.$preview[0].'"  alt="slider-thumb" data-original="'.$preview[0].'" class="lazyload img_responsive" height="70" width="105" /></a>
                                                </div>';


                                $display.='<div class="listing_name '.$class.' "><span class=widget_latest_title><a href="'.$link.'">';

                                $display.= mb_substr( $title,0,35); 
                                if(mb_strlen($title)>35){
                                    $display.= '...';   
                                } 

                                $display.='</a></span>
                                                <span class=widget_latest_price>'. $price.'</span>
                                           </div>' ;
                                $display.='</div>';
                            }else{

                                    $preview     =  wp_get_attachment_image_src($thumb_id, 'property_listings'); 
                                    if($preview[0]==''){
                                        $preview[0]= get_template_directory_uri().'/img/defaults/default_property_listings.jpg';
                                    }

                                    $display.='
                                    <div class="item">
                                        <div class="featured_widget_image" data-link="'.get_permalink().'">
                                            <div class="prop_new_details_back"></div>
                                            <a href="'.get_permalink().'"><img  src="'.$preview[0].'" class="img-responsive" alt="slider-thumb" /></a>
                                        </div>
                                        <div class="featured_title"><a href="'.$link.'" class="featured_title_link">'.$title.'</a></div>
                                    </div>';

                            }
                    endwhile;


                    if($show_as_slider=='slider'){
                        $display.='</div>';
                    }

                    wp_reset_query();



                    $display.='</div>';
                    
                    set_transient($transient_name,wpestate_html_compress($display),4*60*60);
                      
                }
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
		print $display;
		print $after_widget;
	 }

 function action_select_dropn(){
     
 }


}

?>