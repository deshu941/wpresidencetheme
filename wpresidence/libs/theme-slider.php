<?php

<<<<<<< HEAD
if( !function_exists('wpestate_theme_slider') ):

function  wpestate_theme_slider(){
    $theme_slider   =   get_option( 'wp_estate_theme_slider', true); 
    $slider_cycle   =   get_option( 'wp_estate_slider_cycle', true); 
    
    print '<div class="wpestate-tab-container">';
    print '<h1 class="wpestate-tabh1">'.__('Theme Slider','wpestate').'</h1>'; 
    print '<a href="http://help.wpresidence.net/#!/propertyslider" target="_blank" class="help_link">'.__('help','wpestate').'</a>';
  
      
    print '<p>'. __('*hold CTRL for multiple select','wpestate').'</p>';
    $args = array(       'post_type'         =>  'estate_property',
                        'post_status'       =>  'publish',
                        'nopaging'      =>  'true',
                        'cache_results'  => false,
                        'update_post_meta_cache'  =>   false,
                        'update_post_term_cache'  =>   false,
                 );

        $recent_posts = new WP_Query($args);
        print '<select name="theme_slider[]"  id="theme_slider"  multiple="multiple">';
        while ($recent_posts->have_posts()): $recent_posts->the_post();
             $theid=get_the_ID();
             print '<option value="'.$theid.'" ';
             if( is_array($theme_slider) && in_array($theid, $theme_slider) ){
                 print ' selected="selected" ';
             }
             print'>'.get_the_title().'</option>';
        endwhile;
        print '</select>';
        
        print '<p>'. __('Number of milisecons before auto cycling an item (5000=5sec).Put 0 if you don\'t want to autoslide.','wpestate').'</p>';
        print '<p><input  type="text" id="slider_cycle" name="slider_cycle"  value="'.$slider_cycle.'"/> </p>';
      
        print '    
        <p class="submit">
           <input type="submit" name="submit" id="submit" class="button-primary"  value="'.__('Save Changes','wpestate').'" />
        </p>
        ';

  
    print '</div>';
}



endif;





if( !function_exists('wpestate_present_theme_slider') ):
    function wpestate_present_theme_slider(){
=======
if( !function_exists('wpestate_present_theme_slider') ):
    function wpestate_present_theme_slider(){
    
        
        $theme_slider   =   get_option( 'wp_estate_theme_slider_type', true); 
    
        if($theme_slider=='type2'){
            wpestate_present_theme_slider_type2();
            return;
        }
        
        if($theme_slider=='type3'){
            wpestate_present_theme_slider_type3();
            return;
        }
        
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        $attr=array(
            'class'	=>'img-responsive'
        );

        $theme_slider   =   get_option( 'wp_estate_theme_slider', ''); 

        if(empty($theme_slider)){
            return; // no listings in slider - just return
        }
        $currency       =   esc_html( get_option('wp_estate_currency_symbol', '') );
        $where_currency =   esc_html( get_option('wp_estate_where_currency_symbol', '') );

        $counter    =   0;
        $slides     =   '';
        $indicators =   '';
        $args = array(  
                    'post_type'        =>   'estate_property',
                    'post_status'      =>   'publish',
                    'post__in'         =>   $theme_slider,
                    'posts_per_page'   =>   -1
                  );
       
        $recent_posts = new WP_Query($args);
        $slider_cycle   =   get_option( 'wp_estate_slider_cycle', true); 
        if($slider_cycle == 0){
            $slider_cycle = false;
        }
        
        $extended_search    =   get_option('wp_estate_show_adv_search_extended','');
        $extended_class     =   '';

        if ( $extended_search =='yes' ){
            $extended_class='theme_slider_extended';
        }
<<<<<<< HEAD

        print '<div class="theme_slider_wrapper '.$extended_class.' carousel  slide" data-ride="carousel" data-interval="'.$slider_cycle.'" id="estate-carousel">';

        while ($recent_posts->have_posts()): $recent_posts->the_post();
               $theid=get_the_ID();
               $slide= get_the_post_thumbnail( $theid, 'property_full_map',$attr );
=======
        $theme_slider_height   =   get_option( 'wp_estate_theme_slider_height', true);
        
        if($theme_slider_height==0){
            $theme_slider_height=900;
            $extended_class .= " full_screen_yes ";
        }
        
        print '<div class="theme_slider_wrapper '.$extended_class.' carousel  slide" data-ride="carousel" data-interval="'.$slider_cycle.'" id="estate-carousel"  style="height:'.$theme_slider_height.'px;">';

        while ($recent_posts->have_posts()): $recent_posts->the_post();
               $theid=get_the_ID();
             

                $preview        =   wp_get_attachment_image_src(get_post_thumbnail_id($theid), 'property_full_map');
                if($preview[0]==''){
                    $preview[0]= get_template_directory_uri().'/img/defaults/default_property_featured.jpg';
                }
>>>>>>> 64662fd89bea560852792d7203888072d7452d48

               if($counter==0){
                    $active=" active ";
                }else{
                    $active=" ";
                }
                $measure_sys    =   get_option('wp_estate_measure_sys','');
                $price          =   floatval( get_post_meta($theid, 'property_price', true) );
                $price_label    =   '<span class="">'.esc_html ( get_post_meta($theid, 'property_label', true) ).'</span>';
<<<<<<< HEAD
                $beds           =   floatval( get_post_meta($theid, 'property_bedrooms', true) );
                $baths          =   floatval( get_post_meta($theid, 'property_bathrooms', true) );
                $size           =   number_format ( floatval( get_post_meta($theid, 'property_size', true) ) );
=======
                $price_label_before   =   '<span class="">'.esc_html ( get_post_meta($theid, 'property_label_before', true) ).'</span>';
                $beds           =   floatval( get_post_meta($theid, 'property_bedrooms', true) );
                $baths          =   floatval( get_post_meta($theid, 'property_bathrooms', true) );
                
				/*
				$size           =   wpestate_sizes_no_format ( floatval( get_post_meta($theid, 'property_size', true) ) ,1);
>>>>>>> 64662fd89bea560852792d7203888072d7452d48

                if($measure_sys=='ft'){
                    $size.=' '.__('ft','wpestate').'<sup>2</sup>';
                }else{
                    $size.=' '.__('m','wpestate').'<sup>2</sup>';
                }
<<<<<<< HEAD
=======
				*/
                $size       = wpestate_get_converted_measure( $theid, 'property_size' );
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
                
                if ($price != 0) {
                   $price  = wpestate_show_price($theid,$currency,$where_currency,1);  
                }else{
<<<<<<< HEAD
                    $price='';
=======
                    $price=$price_label_before.''.$price_label;
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
                }


               $slides.= '
<<<<<<< HEAD
               <div class="item '.$active.'">
                    <a class="theme_slider_slide" href="'.get_permalink().'"> '.$slide.' </a>
=======
               <div class="item theme_slider_classic '.$active.'" data-href="'.get_permalink().'" style="background-image:url('.$preview[0].');height:'.$theme_slider_height.'px;">
                   
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
                    <div class="slider-content-wrapper">  
                    <div class="slider-content">

                        <h3><a href="'.get_permalink().'">'.get_the_title().'</a> </h3>
                        <span> '. wpestate_strip_words( get_the_excerpt(),20).' ...<a href="'.get_permalink().'" class="read_more">'.__('Read more','wpestate').'<i class="fa fa-angle-right"></i></a></span>

                         <div class="theme-slider-price">
                            '.$price.'  
                            <div class="listing-details">';
                            if($beds!=0){
<<<<<<< HEAD
                                $slides.= '<img src="'.get_template_directory_uri().'/img/icon_bed_slider.png"  alt="listings-beds">'.$beds;
                            }
                            if($baths!=0){
                                $slides.= '  <img src="'.get_template_directory_uri().'/img/icon_bath_slider.png" alt="lsitings_baths">'.$baths;
                            }
                            if($size!=0){
                                $slides.= '  <img src="'.get_template_directory_uri().'/img/icon_size_slider.png" alt="lsitings_size">'.$size;
=======
                                $slides.= '<img src="'.get_template_directory_uri().'/css/css-images/icon_bed.png"  alt="listings-beds">'.$beds;
                            }
                            if($baths!=0){
                                $slides.= '  <img src="'.get_template_directory_uri().'/css/css-images/icon_bath.png" alt="lsitings_baths">'.$baths;
                            }
                            if($size!=0){
                                $slides.= '  <img src="'.get_template_directory_uri().'/css/css-images/icon-size.png" alt="lsitings_size">'.$size;
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
                            }
                            
                            $slides.= '    
                            </div>
                         </div>

                         <a class="carousel-control-theme-next" href="#estate-carousel" data-slide="next"><i class="fa fa-angle-right"></i></a>
                         <a class="carousel-control-theme-prev" href="#estate-carousel" data-slide="prev"><i class="fa fa-angle-left"></i></a>
                    </div> 
                    </div>
                </div>';

               $indicators.= '
               <li data-target="#estate-carousel" data-slide-to="'.($counter).'" class="'. $active.'">

               </li>';

               $counter++;
        endwhile;
        wp_reset_query();
        print '<div class="carousel-inner" role="listbox">
                  '.$slides.'
               </div>

               <ol class="carousel-indicators">
                    '.$indicators.'
               </ol>





               </div>';
    } 
endif;

<<<<<<< HEAD
=======



if( !function_exists('wpestate_present_theme_slider_type2') ):
    function wpestate_present_theme_slider_type2(){
    
        
       
        
        $attr=array(
            'class'	=>'img-responsive'
        );

        $theme_slider   =   get_option( 'wp_estate_theme_slider', ''); 

        if(empty($theme_slider)){
            return; // no listings in slider - just return
        }
        $currency       =   esc_html( get_option('wp_estate_currency_symbol', '') );
        $where_currency =   esc_html( get_option('wp_estate_where_currency_symbol', '') );

        $counter    =   0;
        $slides     =   '';
        $indicators =   '';
        $args = array(  
                    'post_type'        =>   'estate_property',
                    'post_status'      =>   'publish',
                    'post__in'         =>   $theme_slider,
                    'posts_per_page'   =>   -1
                  );
       
        $recent_posts = new WP_Query($args);
        $slider_cycle   =   get_option( 'wp_estate_slider_cycle', true); 
       
        $extended_search    =   get_option('wp_estate_show_adv_search_extended','');
        $extended_class     =   '';

        if ( $extended_search =='yes' ){
            $extended_class='theme_slider_extended';
        }
        
        
        $theme_slider_height   =   get_option( 'wp_estate_theme_slider_height', true);
        if($theme_slider_height==0){
            $theme_slider_height=900;
            $extended_class .= " full_screen_yes ";
        }
        
        print '<div class="theme_slider_wrapper theme_slider_2 '.$extended_class.' " data-auto="'.$slider_cycle.'" style="height:'.$theme_slider_height.'px;">';

        while ($recent_posts->have_posts()): $recent_posts->the_post();
               $theid=get_the_ID();
           
                $preview        =   wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_full_map');
                if($preview[0]==''){
                    $preview[0]= get_template_directory_uri().'/img/defaults/default_property_featured.jpg';
                }

               if($counter==0){
                    $active=" active ";
                }else{
                    $active=" ";
                }
                $measure_sys    =   get_option('wp_estate_measure_sys','');
                $price          =   floatval( get_post_meta($theid, 'property_price', true) );
                $price_label    =   '<span class="">'.esc_html ( get_post_meta($theid, 'property_label', true) ).'</span>';
                $price_label_before   =   '<span class="">'.esc_html ( get_post_meta($theid, 'property_label_before', true) ).'</span>';
                $beds           =   floatval( get_post_meta($theid, 'property_bedrooms', true) );
                $baths          =   floatval( get_post_meta($theid, 'property_bathrooms', true) );
		$size           =   wpestate_get_converted_measure( $theid, 'property_size' );
				
				
                if ($price != 0) {
                   $price  = wpestate_show_price($theid,$currency,$where_currency,1);  
                }else{
                    $price=$price_label_before.''.$price_label;
                }


               $slides.= '
               <div class="item_type2 '.$active.'"  style="background-image:url('.$preview[0].');height:'.$theme_slider_height.'px;">
                   
                

                        <div class="prop_new_details" data-href="'.get_permalink().'">
                            <div class="prop_new_details_back"></div>
                            <div class="prop_new_detals_info">
                                <div class="theme-slider-price">
                                    '.$price.'  
                                </div>
                                <h3><a href="'.get_permalink().'">'.get_the_title().'</a> </h3>
                                
                            </div>
                        </div>
                   
                </div>';

            
               $counter++;
        endwhile;
        wp_reset_query();
        print $slides.'
            </div>';
    } 
endif;


if( !function_exists('wpestate_present_theme_slider_type3') ):
    function wpestate_present_theme_slider_type3(){
    
        
        $theme_slider   =   get_option( 'wp_estate_theme_slider_type', true); 
    
        $attr=array(
            'class'	=>'img-responsive'
        );

        $theme_slider   =   get_option( 'wp_estate_theme_slider', ''); 

        if(empty($theme_slider)){
            return; // no listings in slider - just return
        }
        $currency       =   esc_html( get_option('wp_estate_currency_symbol', '') );
        $where_currency =   esc_html( get_option('wp_estate_where_currency_symbol', '') );

        $counter    =   0;
        $slides     =   '';
        $excerpts     =   '';
        $indicators =   '';
        $args = array(  
                    'post_type'        =>   'estate_property',
                    'post_status'      =>   'publish',
                    'post__in'         =>   $theme_slider,
                    'posts_per_page'   =>   4
                  );
       
        $recent_posts = new WP_Query($args);
        $slider_cycle   =   get_option( 'wp_estate_slider_cycle', true); 
        if($slider_cycle == 0){
            $slider_cycle = false;
        }
        
        $extended_search    =   get_option('wp_estate_show_adv_search_extended','');
        $extended_class     =   '';

        if ( $extended_search =='yes' ){
            $extended_class='theme_slider_extended';
        }
        $theme_slider_height   =   get_option( 'wp_estate_theme_slider_height', true);
        
        if($theme_slider_height==0){
            $theme_slider_height=900;
            $extended_class .= " full_screen_yes ";
        }
        
        print '<div class="theme_slider_wrapper '.$extended_class.' theme_slider_3 slider_type_3 carousel  slide" data-ride="carousel" data-interval="'.$slider_cycle.'" id="estate-carousel" >';
        
        $class_counter = 1;
        while ($recent_posts->have_posts()): $recent_posts->the_post();
				
				
               $theid=get_the_ID();
             

                $preview        =   wp_get_attachment_image_src(get_post_thumbnail_id($theid), 'property_full_map');
                if($preview[0]==''){
                    $preview[0]= get_template_directory_uri().'/img/defaults/default_property_featured.jpg';
                }

               if($counter==0){
                    $active=" active ";
                }else{
                    $active=" ";
                }
                $measure_sys    =   get_option('wp_estate_measure_sys','');
                $price          =   floatval( get_post_meta($theid, 'property_price', true) );
                $price_label    =   '<span class="">'.esc_html ( get_post_meta($theid, 'property_label', true) ).'</span>';
                $price_label_before   =   '<span class="">'.esc_html ( get_post_meta($theid, 'property_label_before', true) ).'</span>';
                $beds           =   floatval( get_post_meta($theid, 'property_bedrooms', true) );
                $baths          =   floatval( get_post_meta($theid, 'property_bathrooms', true) );
                
                $size           = wpestate_get_converted_measure( $theid, 'property_size' );
                
                
                if ($price != 0) {
                   $price  = wpestate_show_price($theid,$currency,$where_currency,1);  
                }else{
                    $price=$price_label_before.''.$price_label;
                }
				
                $ex_cont=wpestate_strip_words( get_the_excerpt(),10,$theid).' ...';
//                $ex_cont    =get_the_excerpt($theid);

                $slides.= '
                <div class="item   animation_class_'.$class_counter.' '.$active.' " data-id="'.$counter.'" data-href="'.get_permalink().'" style=" height:'.$theme_slider_height.'px;" >
                    <div class="theme_slider_3_gradient"></div>
                   
                    <div class="image_div">
                        <img src="'.$preview[0].'" alt="slider">
                    </div>
			   
					 
                    <div class="slide_cont_block">
                        <a href="'.get_permalink($theid).'" target="_blank"><h2>'.get_the_title().'</h2></a>
                    </div>
                    
                  		
                    
                </div>';

                $indicators.= '
                <li data-target="#estate-carousel" data-slide-to="'.($counter).'" class="'. $active.'">
                    '.$ex_cont.'
                </li>';

                $counter++;
			   
                $class_counter++;
                if( $class_counter > 3 ){
                    $class_counter = 1;
                }
			    
			   
        endwhile;
        wp_reset_query();
        print '<div class="carousel-inner" role="listbox">
                  '.$slides.'
               </div>
			   
			 
              
				 
               <ol class="carousel-indicators">
                    '.$indicators.'
               </ol>

                <a id="carousel-control-theme-next" class="carousel-control-theme-next" href="#estate-carousel" data-slide="next"><i class="fa fa-angle-right"></i></a>
                <a id="carousel-control-theme-prev" class="carousel-control-theme-prev" href="#estate-carousel" data-slide="prev"><i class="fa fa-angle-left"></i></a>

               </div>

                ';
        
        
    }  
endif;

>>>>>>> 64662fd89bea560852792d7203888072d7452d48
?>
