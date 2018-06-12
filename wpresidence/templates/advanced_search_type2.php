<?php 
global $post;
 
  
$show_adv_search_visible    =   get_option('wp_estate_show_adv_search_visible','');
$close_class                =   '';
if($show_adv_search_visible=='no'){
    $close_class='adv-search-1-close';
}
if(isset( $post->ID)){
    $post_id = $post->ID;
}else{
    $post_id = '';
}

  

    
?>

 


<<<<<<< HEAD
<div class="adv-search-1  adv-search-2 <?php echo $close_class;?>" id="adv-search-2" data-postid="<?php echo $post_id; ?>"> 
    <div class="transparent-wrapper">
    </div> 
        <form role="search" method="get" class="visible-wrapper"  action="<?php print $adv_submit; ?>" >


                <input type="text" id="adv_location" class="form-control" name="adv_location"  placeholder="<?php _e('Search State, City or Area','wpestate');?>" value="">      


                <div class="dropdown form-control" >
                    <div data-toggle="dropdown" id="adv_categ" class="filter_menu_trigger" data-value="<?php //echo  $adv_categ_value1;?>"> 
                        <?php 
                        echo  __('All Types','wpestate');
                        ?> 
                    <span class="caret caret_filter"></span> </div>           
                    <input type="hidden" name="filter_search_type[]" value="<?php if(isset($_GET['filter_search_type'][0])){echo $_GET['filter_search_type'][0];}?>">
                    <ul  class="dropdown-menu filter_menu" role="menu" aria-labelledby="adv_categ">
                        <?php print $categ_select_list;?>
                    </ul>        
                </div> 

                <div class="dropdown form-control" >
                    <div data-toggle="dropdown" id="adv_actions" class="filter_menu_trigger" data-value="<?php //echo $adv_actions_value1; ?>"> 
                        <?php _e('All Actions','wpestate');?> 
                        <span class="caret caret_filter"></span> </div>           

                    <input type="hidden" name="filter_search_action[]" value="<?php if(isset($_GET['filter_search_action'][0])){echo $_GET['filter_search_action'][0];}?>">
                    <ul  class="dropdown-menu filter_menu" role="menu" aria-labelledby="adv_actions">
                        <?php print $action_select_list;?>
                    </ul>        
                </div>

                <input type="hidden" name="is2" value="1">


            <input name="submit" type="submit" class="wpb_button  wpb_btn-info wpb_btn-large vc_button" id="advanced_submit_22" value="<?php _e('SEARCH PROPERTIES','wpestate');?>">

=======
<div class="adv-search-1  adv-search-2 <?php echo esc_html($close_class);?>" id="adv-search-2" data-postid="<?php echo intval($post_id); ?>"> 
  
        <form role="search" method="get" class="visible-wrapper" id="adv_search_form"  action="<?php print esc_url($adv_submit); ?>" >
                <?php
                if (function_exists('icl_translate') ){
                    print do_action( 'wpml_add_language_form_field' );
                }
                ?> 
                
                <div class="col-md-4">
                    <input type="text" id="adv_location" class="form-control" name="adv_location"  placeholder="<?php _e('Search State, City or Area','wpestate');?>" value="">      
                </div>

                <div class="col-md-8 adv2_nopadding">
                
                    <div class="col-md-4">
                        <div class="dropdown form-control" >
                            <div data-toggle="dropdown" id="adv_categ" class="filter_menu_trigger" data-value="<?php //echo  $adv_categ_value1;?>"> 
                                <?php 
                                echo  __('All Types','wpestate');
                                ?> 
                            <span class="caret caret_filter"></span> </div>   

                            <input type="hidden" name="filter_search_type[]" value="<?php if(isset($_GET['filter_search_type'][0])){echo esc_attr( wp_kses($_GET['filter_search_type'][0], $allowed_html) );}?>">
                            <ul  class="dropdown-menu filter_menu" role="menu" aria-labelledby="adv_categ">
                                <?php print $categ_select_list;?>
                            </ul>        
                        </div> 
                    </div>    

                    <div class="col-md-4">
                        <div class="dropdown form-control" >
                            <div data-toggle="dropdown" id="adv_actions" class="filter_menu_trigger" data-value="<?php //; ?>"> 
                                <?php _e('All Actions','wpestate');?> 
                                <span class="caret caret_filter"></span> </div>           

                            <input type="hidden" name="filter_search_action[]" value="<?php if(isset($_GET['filter_search_action'][0])){echo esc_attr( wp_kses($_GET['filter_search_action'][0], $allowed_html) );}?>">
                            <ul  class="dropdown-menu filter_menu" role="menu" aria-labelledby="adv_actions">
                                <?php print $action_select_list;?>
                            </ul>        
                        </div>
                    </div>   


                    <input type="hidden" name="is2" value="1">

                    <div class="col-md-4">
                        <input name="submit" type="submit" class="wpresidence_button" id="advanced_submit_22" value="<?php _e('SEARCH PROPERTIES','wpestate');?>">
                    </div>
                </div>
            
            
            <?php get_template_part('templates/preview_template')?>
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        </form> 
    
    
</div>  

<?php
$availableTags='';
<<<<<<< HEAD
$args = array( 'hide_empty=0' );
=======
$args = array(
    'orderby' => 'count',
    'hide_empty' => 0,
); 

>>>>>>> 64662fd89bea560852792d7203888072d7452d48
$terms = get_terms( 'property_city', $args );
foreach ( $terms as $term ) {
   $availableTags.= '"'.$term->name.'",';
}

$terms = get_terms( 'property_area', $args );
<<<<<<< HEAD
=======

>>>>>>> 64662fd89bea560852792d7203888072d7452d48
foreach ( $terms as $term ) {
   $availableTags.= '"'.$term->name.'",';
}

$terms = get_terms( 'property_county_state', $args );
foreach ( $terms as $term ) {
   $availableTags.= '"'.$term->name.'",';
}

 print '<script type="text/javascript">
                       //<![CDATA[
                       jQuery(document).ready(function(){
                            var availableTags = ['.$availableTags.'];
                            jQuery("#adv_location").autocomplete({
<<<<<<< HEAD
                                source: availableTags
=======
                                source: availableTags,
                                change: function() {
                                    wpestate_show_pins();
                                }
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
                            });
                       });
                       //]]>
                       </script>';
 
?>