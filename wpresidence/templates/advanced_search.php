<?php
global $adv_search_type;
global $post;
<<<<<<< HEAD
$adv_submit             =   get_adv_search_link();
//  show cities or areas that are empty ?
$args = wpestate_get_select_arguments();
$action_select_list         =   wpestate_get_action_select_list($args);
$categ_select_list          =   wpestate_get_category_select_list($args);
$select_city_list           =   wpestate_get_city_select_list($args); 
$select_area_list           =   wpestate_get_area_select_list($args);
$select_county_state_list   =   wpestate_get_county_state_select_list($args);
$adv_search_type            =   get_option('wp_estate_adv_search_type','');
$show_adv_search_visible    =   get_option('wp_estate_show_adv_search_visible','');
$close_class_wr             =   ' ';

    
if($show_adv_search_visible=='no'){
    $close_class_wr='search_wrapper-close-extended';
}
   
if(isset( $post->ID)){
    $post_id = $post->ID;
}else{
    $post_id = '';
}

?>

<div class="search_wrapper search_wr_<?php print $adv_search_type.' '.$close_class_wr;?>" id="search_wrapper"  data-postid="<?php echo $post_id; ?>">       
   
<?php  
    if ( isset($post->ID) && is_page($post->ID) &&  basename( get_page_template() ) == 'contact_page.php' ) {
        //
    }else {
       
     
        
        if ($adv_search_type==1){
            include(locate_template('templates/advanced_search_type1.php'));
        }else if ($adv_search_type==3){
            include(locate_template('templates/advanced_search_type3.php'));
        }else{
     
            if( !is_tax() && basename ( get_page_template() )  !== 'advanced_search_results.php'){
                include(locate_template('templates/advanced_search_type2.php')); 
            }else{
                print '<div class="adv_results_wrapper">';
                include(locate_template('templates/advanced_search_type1.php')); 
                print '<div class="adv-helper"></div>';
                print '</div>';       
            }
        }
        
    }    
?>

</div><!-- end search wrapper--> 
<!-- END SEARCH CODE -->
=======
$show_adv_search    =   get_option('wp_estate_show_adv_search_general','');

if(isset($post->ID)){
   $show_adv_search_local = get_post_meta($post->ID,'page_show_adv_search',true);
    if($show_adv_search_local==''){
        $show_adv_search_local='global';
    }
    if($show_adv_search_local!='global'){
        $show_adv_search = $show_adv_search_local;
    }
}

if(is_tax() || is_category() || is_archive() ||is_tag()){
    $show_adv_search        =   get_option('wp_estate_show_adv_search_tax','');
}



if($show_adv_search!=='no'){


    $adv_submit                 =   wpestate_get_template_link('advanced_search_results.php');
    $args                       =   wpestate_get_select_arguments();
    $action_select_list         =   wpestate_get_action_select_list($args);
    $categ_select_list          =   wpestate_get_category_select_list($args);
    $select_city_list           =   wpestate_get_city_select_list($args); 
    $select_area_list           =   wpestate_get_area_select_list($args);
    $select_county_state_list   =   wpestate_get_county_state_select_list($args);
    $adv_search_type            =   get_option('wp_estate_adv_search_type','');
    $show_adv_search_visible    =   get_option('wp_estate_show_adv_search_visible','');
    $close_class_wr             =   ' ';
    $search_on_start            =   get_option('wp_estate_search_on_start','');
    $use_float_search_form      =   get_option('wp_estate_use_float_search_form','');
    $wp_estate_float_form_top   =   get_option('wp_estate_float_form_top','');

    if( is_tax() ){
      $wp_estate_float_form_top             =    esc_html( get_option('wp_estate_float_form_top_tax')  );      
    }

    //if($show_adv_search_visible=='no'){
    //    $close_class_wr='search_wrapper-close-extended';
    //}

    if(isset( $post->ID)){
        $post_id = $post->ID;
    }else{
        $post_id = '';
    }

    $search_start_class='';
    if($search_on_start=='yes'){
        $search_start_class.=" with_search_on_start ";
    }else{
        $search_start_class.=" with_search_on_end ";
    }

    $float_style='';
    if($use_float_search_form=="yes" ||  is_page_template( 'splash_page.php' )){
        $search_start_class.=" with_search_form_float ";

    }else{
        $search_start_class.=" without_search_form_float ";
    }

    if($adv_search_type==1 || $adv_search_type==4 || $adv_search_type==3){
        $show_adv_search_visible    =   get_option('wp_estate_show_adv_search_visible','');
        if($show_adv_search_visible=='no'){
            $close_class_wr .="  float_search_closed ";
        }
    }


    ?>

    <?php 
    $prpg_slider_type_status= esc_html ( get_option('wp_estate_global_prpg_slider_type','') );
    if ( (is_singular('estate_property') && get_post_meta($post->ID, 'local_pgpr_slider_type', true)=='global' && $prpg_slider_type_status === 'full width header' ) ||
          (is_singular('estate_property') && get_post_meta($post->ID, 'local_pgpr_slider_type', true)=='full width header' ) ) {
    
            
    }else{
        
     
    ?>

    <div class="search_wrapper search_wr_<?php print $adv_search_type.' '.$close_class_wr.' '.$search_start_class;?>" id="search_wrapper"  data-postid="<?php echo intval($post_id); ?>">       
      
    <?php  
    

        if (  (isset($post->ID) && is_page($post->ID) &&  ( basename( get_page_template() ) == 'contact_page.php') || is_singular('estate_agency') || is_singular('estate_developer') ) 
            // || 
            //  (is_singular('estate_property') && get_post_meta($post->ID, 'local_pgpr_slider_type', true)=='global' && $prpg_slider_type_status === 'full width header' ) ||
            // (is_singular('estate_property') && get_post_meta($post->ID, 'local_pgpr_slider_type', true)=='full width header' ) 
            ) {

            //do nothing
        }else {
            print '  <div id="search_wrapper_color"></div>';
            if ($adv_search_type==1){
                include(locate_template('templates/advanced_search_type1.php'));
            }else if ($adv_search_type==3){
                include(locate_template('templates/advanced_search_type3.php'));
            }else if ($adv_search_type==4){
                include(locate_template('templates/advanced_search_type4.php'));
            }else if ($adv_search_type==5){
                include(locate_template('templates/advanced_search_type5.php'));
            }else if ($adv_search_type==6){
                include(locate_template('templates/advanced_search_type6.php'));
            }else if ($adv_search_type==7){
                include(locate_template('templates/advanced_search_type7.php'));
            } else if ($adv_search_type==8){
                include(locate_template('templates/advanced_search_type8.php'));
            } else if ($adv_search_type==9){
                include(locate_template('templates/advanced_search_type9.php'));
            }else if ($adv_search_type==10){
                include(locate_template('templates/advanced_search_type10.php'));
            }else if ($adv_search_type==11){
                include(locate_template('templates/advanced_search_type11.php'));
            }else{

                if( !is_tax() && basename ( get_page_template() )  !== 'advanced_search_results.php'){
                    include(locate_template('templates/advanced_search_type2.php')); 
                }else{
                    print '<div class="adv_results_wrapper">';
                    include(locate_template('templates/advanced_search_type1.php')); 
                    print '<div class="adv-helper"></div>';
                    print '</div>';       
                }
            }

        }    
    ?>

    </div><!-- end search wrapper--> 
    <!-- END SEARCH CODE -->
    <?php } // end if prop page full slider?>

<?php 
} 
?>
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
