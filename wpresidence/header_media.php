<<<<<<< HEAD
<div class="header_media">
<?php 
$show_adv_search_status     =   get_option('wp_estate_show_adv_search','');
$header_type                =   get_post_meta ( $post->ID, 'header_type', true);
$global_header_type         =   get_option('wp_estate_header_type','');

if(is_tax () ){
    $header_type=0;
}

if( !wpestate_half_map_conditions ($post->ID) ){
    $custom_image               =   esc_html( esc_html(get_post_meta($post->ID, 'page_custom_image', true)) );  
    $rev_slider                 =   esc_html( esc_html(get_post_meta($post->ID, 'rev_slider', true)) ); 
    
    if (!$header_type==0){  // is not global settings
          switch ($header_type) {
            case 1://none
                break;
            case 2://image
                print '<img src="'.$custom_image.'"  class="img-responsive" alt="header_image"/>';
                break;
            case 3://theme slider
                wpestate_present_theme_slider();
                break;
            case 4://revolutin slider
                putRevSlider($rev_slider);
                break;
            case 5://google maps
                get_template_part('templates/google_maps_base'); 
                break;
          }
          
         
            
    }else{    // we don't have particular settings - applt global header
          switch ($global_header_type) {
            case 0://image
                break;
            case 1://image
                $global_header  =   get_option('wp_estate_global_header','');
                print '<img src="'.$global_header.'"  class="img-responsive" class="headerimg" alt="header_image"/>';
                break;
            case 2://theme slider
                wpestate_present_theme_slider();
                break;
            case 3://revolutin slider
                 $global_revolution_slider   =  get_option('wp_estate_global_revolution_slider','');
                 putRevSlider($global_revolution_slider);
                break;
            case 4://google maps
                get_template_part('templates/google_maps_base'); 
                break;
          }
    
    } // end if header
}
    

    
    
    

    
                     
?>
    
<?php
$show_adv_search_general    =   get_option('wp_estate_show_adv_search_general','');
$header_type                =   get_post_meta ( $post->ID, 'header_type', true);
$global_header_type         =   get_option('wp_estate_header_type','');
$show_adv_search_slider     =   get_option('wp_estate_show_adv_search_slider','');
$show_mobile                =   0;  

if ( is_category() || is_tax() || is_archive() ){
    $header_type=0;
}
    
if($show_adv_search_general ==  'yes' && !is_404() && !is_page_template('property_list_half.php')){
    
    if( !wpestate_half_map_conditions ($post->ID) ){
        if($header_type == 1){
          //nothing  
        }else if($header_type == 0){ 
            if($global_header_type==4){
                $show_mobile=1;
                get_template_part('templates/advanced_search');  
            }else if( $global_header_type==0){
               //nonthing 
            }else{
                if($show_adv_search_slider=='yes'){
                    $show_mobile=1;
                    get_template_part('templates/advanced_search');  
                }
            }

        }else if($header_type == 5){
                $show_mobile=1;
                get_template_part('templates/advanced_search');  
        }else{
             if($show_adv_search_slider=='yes'){
                $show_mobile=1;
                get_template_part('templates/advanced_search');  
            }
        }  
    }
}
?>   
=======
<?php 
$show_adv_search_status     =   get_option('wp_estate_show_adv_search','');
$global_header_type         =   get_option('wp_estate_header_type','');
$adv_search_type            =   get_option('wp_estate_adv_search_type','');
$search_on_start            =   get_option('wp_estate_search_on_start','');
$post_id                    =   '';
if(isset($post->ID)){
    $post_id=$post->ID;
}



if($search_on_start=='yes' && !is_page_template( 'splash_page.php' ) ){
    wpestate_show_advanced_search($post_id);
}


?>




<div class="header_media with_search_<?php echo esc_html($adv_search_type);?>">

<?php
    if ( is_category() || is_tax() || is_archive() || is_search() ){
        $header_type=0;
    }else{
        $header_type                =   get_post_meta ( $post->ID, 'header_type', true);
    }
    
    if(is_singular('estate_agency')){
        $header_type=21;
    }
    if(is_singular('estate_developer')){
        $header_type=22;
    }
    
    
    
    
    
    
    
    

    if( isset($post->ID) && !wpestate_half_map_conditions ($post->ID) ){
        $custom_image               =   esc_html( esc_html(get_post_meta($post->ID, 'page_custom_image', true)) );  
        $rev_slider                 =   esc_html( esc_html(get_post_meta($post->ID, 'rev_slider', true)) ); 
        ////////////////////////////////////////////////////////////////////////////
        // if taxonomy
        ////////////////////////////////////////////////////////////////////////////
        if( is_tax() ){
            global $term_data;
            $taxonmy    =   get_query_var('taxonomy');
            $term       =   get_query_var( 'term' );
            $term_data  =   get_term_by('slug', $term, $taxonmy);
            $place_id   =   $term_data->term_id;
            $term_meta  =   get_option( "taxonomy_$place_id");
            if( isset($term_meta['category_featured_image']) && $term_meta['category_featured_image']!='' ){
               $header_type=7;
            }
        }

        ////////////////////////////////////////////////////////////////////////////
        // if property page
        ////////////////////////////////////////////////////////////////////////////


        if(is_singular('estate_property')){
            $prpg_slider_type_status= esc_html ( get_option('wp_estate_global_prpg_slider_type','') );
            $local_pgpr_slider_type_status=  get_post_meta($post->ID, 'local_pgpr_slider_type', true);

            if($local_pgpr_slider_type_status=='global' && $prpg_slider_type_status === 'full width header'){
                $header_type=8;
            }
            if($local_pgpr_slider_type_status=='full width header'){
                $header_type=8;
            }
            if($local_pgpr_slider_type_status=='global' && $prpg_slider_type_status === 'multi image slider'){
                $header_type=9;
            }
            if($local_pgpr_slider_type_status=='multi image slider'){
                $header_type=9;
            }
            
            
            if($local_pgpr_slider_type_status=='animation slider'){
                $header_type = 'animation slider';
            }
            
             
        }

        if( is_page_template( 'splash_page.php' ) ){
            $header_type=20;
        }



     
 
    
    
    
    }
    
    
    if( is_tax() ){
        global $term_data;
        $taxonmy    =   get_query_var('taxonomy');
        $term       =   get_query_var( 'term' );
        $term_data  =   get_term_by('slug', $term, $taxonmy);
        $place_id   =   $term_data->term_id;
        $term_meta  =   get_option( "taxonomy_$place_id");
        if( isset($term_meta['category_featured_image']) && $term_meta['category_featured_image']!='' ){
           $header_type=7;
        }
    }
    if( is_tax() &&  intval(get_option('wp_estate_property_list_type','') )==1 ){
        $taxonmy    =   get_query_var('taxonomy');
        global $term_data;
        $place_id                       =$term_data->term_id;
        $term_meta                      = get_option( "taxonomy_$place_id");
        
       
        
        if( $taxonmy == 'property_category' || 
            $taxonmy == 'property_action_category' || 
            $taxonmy == 'property_city' || 
            $taxonmy == 'property_area' ||
            $taxonmy == 'property_county_state'){
            
            if( isset($term_meta['category_featured_image']) && $term_meta['category_featured_image']!=''){
                $header_type=7;
            }
        }
    }
    
    if( is_page_template( 'property_list_half.php' ) ){
        $header_type=5;
    }
    
    if( is_tax() &&  intval(get_option('wp_estate_property_list_type','') )==2 ){
           $header_type=5;
    }
    
    
    if(is_page_template( 'advanced_search_results.php' ) &&  intval(get_option('wp_estate_property_list_type_adv','') )==2  ){
        $header_type=5;
    }

        if (!$header_type==0){  // is not global settings
            switch ($header_type) {
                case 1://none
                    break;
                case 2://image
                   // print '<img src="'.$custom_image.'"  class="img-responsive" alt="header_image"/>';
                    wpestate_header_image($custom_image);
                    break;
                case 3://theme slider
                    wpestate_present_theme_slider();
                    break;
                case 4://revolutin slider
                    putRevSlider($rev_slider);
                    break;
                case 5://google maps
                    if( isset($post->ID) && !wpestate_half_map_conditions ($post->ID) ){
                        get_template_part('templates/google_maps_base'); 
                    }
                    break;
                case 6:
                    wpestate_video_header();
                    break;
                case 7://google maps
                    get_template_part('templates/header_taxonomy'); 
                    break;
                case 8:
                    wpestate_listing_full_width_slider($post->ID);
                    break;
                case 9:
                    wpestate_multi_image_slider($post->ID);
                    break;
                case 20:
                    wpestate_splash_page_header();
                    break;
                case 21;
                    get_template_part('templates/header_agency'); 
                    break;
                case 22;
                    get_template_part('templates/header_developer'); 
                    break;
                    
                case 'animation slider';
                    get_template_part('templates/property_animation_slider'); 
                    break;
                case 11;
                    get_template_part('templates/property_slider_tour'); 
                    break;
               
            }
        }else{    // we don't have particular settings - applt global header
            switch ($global_header_type) {
                case 0://image
                    break;
                case 1://image
                    $global_header  =   get_option('wp_estate_global_header','');
                    // print '<img src="'.$global_header.'"  class="img-responsive" class="headerimg" alt="header_image"/>';
                    wpestate_header_image($global_header);
                    break;
                case 2://theme slider
                    wpestate_present_theme_slider();
                    break;
                case 3://revolutin slider
                     $global_revolution_slider   =  get_option('wp_estate_global_revolution_slider','');
                     putRevSlider($global_revolution_slider);
                    break;
                case 4://google maps
                    get_template_part('templates/google_maps_base'); 
                    break;
                case 8:
                    wpestate_listing_full_width_slider($post->ID);
                    break;
            }

        } // end if header
    
  
  
    $global_header_type         =   get_option('wp_estate_header_type','');
    $show_adv_search_slider     =   get_option('wp_estate_show_adv_search_slider','');
    $show_mobile                =   0;  

    if ( is_category() || is_tax() || is_archive() || is_search() ){
        $header_type=0;
    }else{
        $header_type                =   get_post_meta ( $post->ID, 'header_type', true);
    }
    
    if( wpestate_float_search_placement($post_id) ||  is_page_template( 'splash_page.php' )  ){
     
        if($header_type==1 || ( $global_header_type==0 && $header_type==0) ){
            //nothing
        }else{
            get_template_part( 'templates/advanced_search' );
        }
    }
    
    if( is_page_template( 'splash_page.php' ) ){
        get_template_part( 'templates/adv_search_mobile');
    }
?>   
    
    
    <?php 
        if(is_page_template( 'splash_page.php' ) ){
            print '<div class="splash_page_widgets_wrapper">';
            
            print ' <div class="splash-left-widet">
                <ul class="xoxo">';
                    dynamic_sidebar('splash-page_bottom-left-widget-area');
                print'</ul>    
            </div> '; 

            print'
            <div class="splash-right-widet">
                <ul class="xoxo">';
                   dynamic_sidebar('splash-page_bottom-right-widget-area');
                print'</ul>
            </div>';
            
            print '</div>';
        }
    
    ?>
    
    
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
</div>

<?php 

<<<<<<< HEAD
if( $show_mobile == 1 ){
    get_template_part('templates/adv_search_mobile');
}
=======



if($search_on_start=='no'  && !is_page_template( 'splash_page.php' )){
    wpestate_show_advanced_search($post_id);
}

if( !wpestate_half_map_conditions('') && !wpestate_is_user_dashboard() && !is_page_template( 'splash_page.php' ) ){
    get_template_part( 'templates/adv_search_mobile');
}


>>>>>>> 64662fd89bea560852792d7203888072d7452d48
?>