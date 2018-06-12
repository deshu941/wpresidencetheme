<?php
global $custom_advanced_search;  
global $adv_search_what;
<<<<<<< HEAD
=======
global $adv_search_how;
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
global $adv_search_label;


?>
<div class="search_unit_wrapper">
    <h4> <?php the_title(); ?> </h4>
    <a class="delete_search" data-searchid="<?php print $post->ID; ?>"><?php _e('delete search','wpestate');?></a>
    <?php  
    $search_arguments=  get_post_meta($post->ID, 'search_arguments', true) ;
<<<<<<< HEAD
    $search_arguments_decoded= json_decode($search_arguments);
    
    
    //print  json_last_error();
    //print_r($search_arguments_decoded);
    
    print '<div class="search_param"><strong>'.__('Search Parameters: ','wpestate').'</strong>';
    foreach($search_arguments_decoded->tax_query as $key=>$query ){
        
        if ( isset($query->taxonomy) && isset($query->terms[0]) && $query->taxonomy=='property_category'){
            $page = get_term_by( 'slug',$query->terms[0] ,'property_category');
            if( !empty($page) ){
                print '<strong>'.__('Category','wpestate').':</strong> '. $page->name .', ';  
            }
        }
        
        if ( isset($query->taxonomy) && isset($query->terms[0]) && $query->taxonomy=='property_action_category'){
           $page = get_term_by( 'slug',$query->terms[0] ,'property_action_category');
            if( !empty($page) ){
                print '<strong>'.__('For','wpestate').':</strong> '.$page->name.', ';  
            }
            
        }
        
        if ( isset($query->taxonomy) && isset($query->terms[0]) && $query->taxonomy=='property_city'){
            $page = get_term_by( 'slug',urldecode($query->terms[0]) ,'property_city');
            if( !empty($page) ){
                print '<strong>'.__('City','wpestate').':</strong> '.$page->name.', ';  
            }
            
        }
        
        if ( isset($query->taxonomy) && isset($query->terms[0]) && $query->taxonomy=='property_area'){
            $page = get_term_by( 'slug',urldecode($query->terms[0] ),'property_area');
            if( !empty($page) ){
                print '<strong>'.__('Area','wpestate').':</strong> '.$page->name.', ';  
            }
                
        }
    }
 
    foreach($search_arguments_decoded->meta_query as $key=>$query ){
        if($custom_advanced_search==='yes'){
            
            $custm_name = wpestate_get_custom_field_name($query->key,$adv_search_what,$adv_search_label);
            if ( isset($query->compare) ){
                
                
                
                
                if ($query->compare=='CHAR'){
                    print __('has','wpestate').' <strong>'.str_replace('_',' ',$custm_name).'</strong>, ';       
                }else if ($query->compare=='<='){
                    print '<strong>'.$custm_name.'</strong> '.__('smaller than ','wpestate').' '.$query->value.', ';            
                }  else{
                    print '<strong>'.$custm_name.'</strong> '.__('bigger than','wpestate').' '.$query->value.', ';   
                }                
            }else{
                print '<strong>'.$custm_name.':</strong> '.$query->value.', ';
            } //end elese query compare
            
            
        }else{
            if ( isset($query->compare) ){
                if ($query->compare=='CHAR'){
                    print __('has','wpestate').' <strong>'.str_replace('_',' ',$query->key).'</strong>, ';       
                }else if ($query->compare=='<='){
                    print '<strong>'.str_replace('_',' ',$query->key).'</strong> '.__('smaller than ','wpestate').' '.$query->value.', ';            
                } else{
                     print '<strong>'.str_replace('_',' ',$query->key).'</strong> '.__('bigger than ','wpestate').' '.$query->value.', ';            
                }                 
            }else{
                print '<strong>'.str_replace('_',' ',$query->key).':</strong> '.$query->value.', ';
            } //end elese query compare
       
        }//end else if custom adv search
        
        
       
    }
    
=======
    $search_arguments_decoded= (array)json_decode($search_arguments,true);
    
    $meta_arguments=  get_post_meta($post->ID, 'meta_arguments', true) ;
    $meta_arguments = (array)json_decode($meta_arguments,true);

    
    print '<div class="search_param"><strong>'.__('Search Parameters: ','wpestate').'</strong>';
    wpestate_show_search_params_new($meta_arguments,$search_arguments_decoded,$custom_advanced_search, $adv_search_what,$adv_search_how,$adv_search_label);
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    print '</div>';
    
    
    ?>
</div>

