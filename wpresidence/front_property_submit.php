<?php
// Template Name: Front Property Submit
// Wp Estate Pack
$current_user = wp_get_current_user();
$userID                         =   $current_user->ID;

$user_agent_id          =   intval( get_user_meta($userID,'user_agent_id',true));
$status                 =   get_post_status($user_agent_id);

if( $status==='pending' || $status==='disabled' ){
    wp_redirect( home_url() );exit;
}
 add_filter('wp_kses_allowed_html', 'wpestate_add_allowed_tags');


 
$current_user                   =   wp_get_current_user();
$userID                         =   $current_user->ID;
$user_pack                      =   get_the_author_meta( 'package_id' , $userID );
$status_values                  =   esc_html( get_option('wp_estate_status_list') );
$status_values_array            =   explode(",",$status_values);
$feature_list_array             =   array();
$feature_list                   =   esc_html( get_option('wp_estate_feature_list') );
$feature_list_array             =   explode( ',',$feature_list);
$allowed_html                   =   array();
$submission_page_fields         =   ( get_option('wp_estate_submission_page_fields','') );
$all_submission_fields          =   wpestate_return_all_fields();
$agent_list                     =   (array)get_user_meta($userID,'current_agent_list',true);

global $show_err;
global $submission_page_fields;
global $all_submission_fields;

     
$allowed_html_desc=array(
    'a' => array(
        'href' => array(),
        'title' => array()
    ),
    'br'        =>  array(),
    'em'        =>  array(),
    'strong'    =>  array(),
    'ul'        =>  array('li'),
    'li'        =>  array(),
    'code'      =>  array(),
    'ol'        =>  array('li'),
    'del'       =>  array(
                    'datetime'=>array()
                    ),
    'blockquote'=> array(),
    'ins'       =>  array(),
    
    
);

$submit_title                   =   ''; 
$submit_description             =   ''; 
$prop_category                  =   ''; 
$property_address               =   ''; 
$property_county                =   ''; 
$property_state                 =   ''; 
$property_zip                   =   ''; 
$country_selected               =   ''; 
$prop_stat                      =   ''; 
$property_status                =   '';
$property_price                 =   ''; 
$property_label                 =   '';   
$property_label_before          =   '';  
$property_size                  =   ''; 
$owner_notes                    =   '';   
$property_lot_size              =   ''; 
$property_year                  =   ''; 
$property_rooms                 =   ''; 
$property_bedrooms              =   ''; 
$property_bathrooms             =   ''; 
$option_video                   =   '';
$option_slider                  =   '';
$video_type                     =   '';  
$embed_video_id                 =   ''; 
$virtual_tour                   =   '';
$property_latitude              =   ''; 
$property_longitude             =   '';  
$google_view                    =   ''; 
$google_camera_angle            =   ''; 
$prop_category                  =   '';  
$plan_title_array               =   '';
$plan_desc_array                =   '';
$plan_image_array               =   '';
$plan_size_array                =   '';
$plan_rooms_array               =   '';
$plan_bath_array                =   '';
$plan_price_array               =   '';
$property_has_subunits          =   '';
$property_subunits_list         =   '';

// enegy effective
$energy_class          =   '';
$energy_index         =   '';
//ee end

$custom_fields = get_option( 'wp_estate_custom_fields', true);    
$custom_fields_array=array();
$i=0;
if( !empty($custom_fields)){  
    while($i< count($custom_fields) ){
       $name    =   $custom_fields[$i][0];
       $type    =   $custom_fields[$i][2];
       $slug    =   wpestate_limit45(sanitize_title( $name ));
       $slug    =   sanitize_key($slug);
       $custom_fields_array[$slug]='';
       $i++;
    }
}





foreach ($status_values_array as $key=>$value) {
    $value          =   trim($value);
    $value_wpml     =   $value;
    $slug_status    =   sanitize_title($value);
    if (function_exists('icl_translate') ){
        $value_wpml = icl_translate('wpestate','wp_estate_property_status_front_'.$slug_status,$value );
    }
    $property_status.='<option value="' . $value . '"';
    $property_status.='>' . stripslashes($value_wpml) . '</option>';
}



$video_values                   =   array('vimeo', 'youtube');
foreach ($video_values as $value) {
  $option_video.='<option value="' . $value . '"';
  $option_video.='>' . $value . '</option>';
}    

$option_slider='';
$slider_values = array('full top slider', 'small slider');

foreach ($slider_values as $value) {
    $option_slider.='<option value="' . $value . '"';
    $option_slider.='>' . $value . '</option>';
}


 
$options=wpestate_page_details($post->ID);
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


/// defaults
global $option_video;
global $property_status;
global $show_err;
global $submission_page_fields;
global $all_submission_fields;

$submission_page_fields         =   ( get_option('wp_estate_submission_page_fields','') );
$all_submission_fields          =   wpestate_return_all_fields();

$video_values                   =   array('vimeo', 'youtube');
foreach ($video_values as $value) {
  $option_video.='<option value="' . $value . '"';
  $option_video.='>' . $value . '</option>';
}    


$status_values                  =   esc_html( get_option('wp_estate_status_list') );
$status_values_array            =   explode(",",$status_values);


foreach ($status_values_array as $key=>$value) {
     $value = (trim($value));
     $value_wpml=$value;
     $slug_status=sanitize_title($value);
     if (function_exists('icl_translate') ){
         $value_wpml= icl_translate('wpestate','wp_estate_property_status_front_'.$slug_status,$value );
     }

     $property_status.='<option value="' . $value . '"';
     if ($value == $prop_stat) {
         $property_status.='selected="selected"';
     }
     $property_status.='>' .stripslashes( $value_wpml) . '</option>';
 }


$feature_list_array             =   array();
$feature_list                   =   esc_html( get_option('wp_estate_feature_list') );
$feature_list_array             =   explode( ',',$feature_list);
$moving_array=array();
foreach($feature_list_array as $key => $value){
    $post_var_name    =   str_replace(' ','_', trim($value) );
    $post_var_name    =   wpestate_limit45(sanitize_title( $post_var_name ));
    $post_var_name    =   sanitize_key($post_var_name);
    $feature_value    = 0;
    if(isset($_POST[$post_var_name])){
        $feature_value    =   wp_kses( esc_html($_POST[$post_var_name]) ,$allowed_html);
    }

    if($feature_value==1){
        $moving_array[]=$post_var_name;
    }        
}




///////////////////////////////////////////////////////////////////////////////////////////
/////// Submit Code
///////////////////////////////////////////////////////////////////////////////////////////

if( 'POST' == $_SERVER['REQUEST_METHOD'] && $_POST['action']=='front_submit' && is_user_logged_in()) {
    $parent_userID              =   wpestate_check_for_agency($userID);
    $paid_submission_status    =    esc_html ( get_option('wp_estate_paid_submission','') );

    if ( $paid_submission_status!='membership' || ( $paid_submission_status== 'membership' || wpestate_get_current_user_listings($parent_userID) > 0)  ){ // if user can submit
        
//        if ( !isset($_POST['new_estate']) || !wp_verify_nonce($_POST['new_estate'],'submit_new_estate') ){
//           exit('Sorry, your not submiting from site'); 
//        }
   
        if( !isset($_POST['prop_category']) || $_POST['prop_category']==-1 ) {
            $prop_category=0;           
        }else{
            $prop_category  =   intval($_POST['prop_category']);
        }
  
        if( !isset($_POST['prop_action_category']) ) {
            $prop_action_category=0;           
        }else{
            $prop_action_category  =   wp_kses(esc_html($_POST['prop_action_category']),$allowed_html);
        }
        
        if( !isset($_POST['property_city']) ) {
            $property_city='';           
        }else{
            $property_city  =   wp_kses(esc_html($_POST['property_city']),$allowed_html);
        }
        
        if( !isset($_POST['property_area']) ) {
            $property_area='';           
        }else{
            $property_area  =   wp_kses(esc_html($_POST['property_area']),$allowed_html);
        }
       
        
        if( !isset($_POST['property_county']) ) {
            $property_county_state='';           
        }else{
            $property_county_state  =   wp_kses(esc_html($_POST['property_county']),$allowed_html);
        }
       
        
        
        
                
        $show_err                       =   '';
        $post_id                        =   '';
        $submit_title                   =   '';
        if(isset($_POST['wpestate_title'])){
            $submit_title                   =   wp_kses( $_POST['wpestate_title'],$allowed_html ); 
        }
        $submit_description                   =   '';
        if(isset($_POST['wpestate_description'])){
            $submit_description             =   wp_kses( $_POST['wpestate_description'],$allowed_html_desc);     
        }
        
        $property_address                   =   '';
        if(isset($_POST['property_address'])){
            $property_address               =   wp_kses( $_POST['property_address'],$allowed_html);
        }
        
        $property_county                   =   '';
        if(isset($_POST['property_county'])){
            $property_county                =   wp_kses( $_POST['property_county'],$allowed_html);
        }
        
        $property_zip                   =   '';
        if(isset($_POST['property_zip'])){
            $property_zip                   =   wp_kses( $_POST['property_zip'],$allowed_html);
        }
		
		
        // energy effect
        $energy_class                   =   '';
        if(isset($_POST['energy_class'])){
            $energy_class                   =   wp_kses( $_POST['energy_class'],$allowed_html);
        }
        $energy_index                   =   '';
        if(isset($_POST['energy_index'])){
            $energy_index                   =   wp_kses( $_POST['energy_index'],$allowed_html);
        }
        // end
        
        $country_selected                   =   '';
        if(isset($_POST['property_country'])){
            $country_selected               =   wp_kses( $_POST['property_country'],$allowed_html);     
        }
        
        $prop_stat                   =   '';
        if(isset($_POST['property_status'])){
            $prop_stat                      =   wp_kses( $_POST['property_status'],$allowed_html);
        }
        
        
        $property_status                =   '';
        
        foreach ($status_values_array as $key=>$value) {
            $value = trim($value);
            $value_wpml=$value;
            $slug_status=sanitize_title($value);
            if (function_exists('icl_translate') ){
                $value_wpml= icl_translate('wpestate','wp_estate_property_status_front_'.$slug_status,$value );
            }
            
            $property_status.='<option value="' . $value . '"';
            if ($value == $prop_stat) {
                $property_status.='selected="selected"';
            }
            $property_status.='>' . $value_wpml . '</option>';
        }

        
        $property_price                   =   '';
        if(isset($_POST['property_price'])){
            $property_price                 =   wp_kses( esc_html($_POST['property_price']),$allowed_html);
        }
        
        $property_label                   =   '';
        if(isset($_POST['property_label'])){
            $property_label                 =   wp_kses( esc_html($_POST['property_label']),$allowed_html);   
        }
        
        $property_label_before                   =   '';
        if(isset($_POST['property_label_before'])){
            $property_label_before          =   wp_kses( esc_html($_POST['property_label_before']),$allowed_html); 
        }
        
        $property_size                   =   '';
        if(isset($_POST['property_size'])){
            $property_size                  =   wp_kses( esc_html($_POST['property_size']),$allowed_html);  
        }
        
        $owner_notes                   =   '';
        if(isset($_POST['owner_notes'])){
            $owner_notes                    =   wp_kses( esc_html($_POST['owner_notes']),$allowed_html);  
        }
        
        $property_lot_size                   =   '';
        if(isset($_POST['property_lot_size'])){
            $property_lot_size              =   wp_kses( esc_html($_POST['property_lot_size']),$allowed_html); 
        }
        
        $property_rooms                   =   '';
        if(isset($_POST['property_rooms'])){
            $property_rooms                 =   wp_kses( esc_html($_POST['property_rooms']),$allowed_html); 
        }
        
        $property_bedrooms                   =   '';
        if(isset($_POST['property_bedrooms'])){
            $property_bedrooms              =   wp_kses( esc_html($_POST['property_bedrooms']),$allowed_html); 
        }
        
        
        $property_bathrooms                   =   '';
        if(isset($_POST['property_bathrooms'])){
            $property_bathrooms             =   wp_kses( esc_html($_POST['property_bathrooms']),$allowed_html); 
        }
        
        
        $option_video                   =   '';
        $video_values                   =   array('vimeo', 'youtube');
        
        $video_type                   =   '';
        if(isset($_POST['embed_video_type'])){
            $video_type                     =   wp_kses( esc_html($_POST['embed_video_type']),$allowed_html); 
        }
        
        $google_camera_angle                   =   '';
        if(isset($_POST['google_camera_angle'])){
            $google_camera_angle            =   wp_kses( esc_html($_POST['google_camera_angle']),$allowed_html); 
        }
        
        $property_has_subunits                   =   '';
        if(isset($_POST['property_has_subunits'])){
            $property_has_subunits          =   wp_kses( esc_html($_POST['property_has_subunits']),$allowed_html); 
        }
        
        if(isset($_POST['property_subunits_list'])){
            $property_subunits_list         =   $_POST['property_subunits_list']; 
        }
        $has_errors                      =   false;
        
        
       
        
        $errors                         =   array();
        
        $moving_array=array();
        foreach($feature_list_array as $key => $value){
            $post_var_name    =   str_replace(' ','_', trim($value) );
            $post_var_name    =   wpestate_limit45(sanitize_title( $post_var_name ));
            $post_var_name    =   sanitize_key($post_var_name);
            $feature_value    = 0;
            if(isset($_POST[$post_var_name])){
                $feature_value    =   wp_kses( esc_html($_POST[$post_var_name]) ,$allowed_html);
            }
            
            if($feature_value==1){
                $moving_array[]=$post_var_name;
            }        
       }
        
      
        foreach ($video_values as $value) {
            $option_video.='<option value="' . $value . '"';
            if ($value == $video_type) {
                $option_video.='selected="selected"';
            }
            $option_video.='>' . $value . '</option>';
        }
        
        $option_slider='';
        $slider_values = array('full top slider', 'small slider'); 
        $iframe = array( 'iframe' => array(
                         'src' => array (),
                         'width' => array (),
                         'height' => array (),
                         'frameborder' => array(),
                        'style' => array(),
                         'allowFullScreen' => array() // add any other attributes you wish to allow
                          ) );
      
        
        
        $embed_video_id                   =   '';
        if(isset($_POST['embed_video_id'])){
            $embed_video_id                 =   wp_kses( esc_html($_POST['embed_video_id']),$allowed_html); 
        }
        
        $virtual_tour                   =   '';
        if(isset($_POST['embed_virtual_tour'])){
            $virtual_tour                   =   wp_kses (trim($_POST['embed_virtual_tour']),$iframe) ;
        }
        
        
        $property_latitude                   =   '';
        if(isset($_POST['property_latitude'])){
            $property_latitude              =   floatval( $_POST['property_latitude']); 
        }
        
        $property_longitude                   =   '';
        if(isset($_POST['property_longitude'])){
            $property_longitude             =   floatval( $_POST['property_longitude']); 
        }
        
        $google_view                   =   '';
        if(isset($_POST['property_google_view'])){
            $google_view                    =   wp_kses( esc_html( $_POST['property_google_view']),$allowed_html); 
        }
        
        
        if($google_view==1){
            $google_view_check=' checked="checked" ';
        }else{
            $google_view_check=' ';
        }
   
         
        $google_camera_angle                   =   '';
        if(isset($_POST['google_camera_angle'])){
            $google_camera_angle            =   intval( $_POST['google_camera_angle']); 
        }
        
        $prop_category                  =   get_term( $prop_category, 'property_category');
        if(isset($prop_category->term_id)){
            $prop_category_selected         =   $prop_category->term_id;
        }else{
           $prop_category = -1; 
        }
    
        $prop_action_category           =   get_term( $prop_action_category, 'property_action_category');  
        if(isset($prop_action_category->term_id)){
            $prop_action_category_selected  =   $prop_action_category->term_id;
        }else{
            $prop_action_category=-1;
        }
         
        $attchs =   array();
        if(isset($_POST['attachid'])){
            $attchs =   explode(',',$_POST['attachid']);
        }
            
        
        // save custom fields
     
        $i=0;
        if( !empty($custom_fields)){  
            while($i< count($custom_fields) ){
               $name    =   $custom_fields[$i][0];
               $type    =   $custom_fields[$i][1];
               $slug    =   str_replace(' ','_',$name);
               $slug    =   wpestate_limit45(sanitize_title( $name ));
               $slug    =   sanitize_key($slug);
               if(isset($_POST[$slug])){
                $custom_fields_array[$slug]= wp_kses( esc_html($_POST[$slug]),$allowed_html);
               }
               $i++;
            }
        }    
            
        if($submit_title==''){
            $has_errors=true;
            $errors[]=__('Please submit a title for your property','wpestate');
        }
        $mandatory_fields           =   ( get_option('wp_estate_mandatory_page_fields','') );
    
        
    
        if(is_array($mandatory_fields)){
            foreach($mandatory_fields as $key=>$value){
                
                $value_post =   wpestate_limit45(sanitize_title( $value ));
                $value_post =   sanitize_key($value_post);
                
                $check_categs=0;
                if( ($value_post=='prop_category' && is_numeric($prop_category) && $prop_category==-1) || ($value_post=='prop_action_category'  && is_numeric($prop_action_category) && $prop_action_category==-1)){
                    $check_categs=1;
                }
                
                if( !isset($_POST[strtolower($value_post)]) || $_POST[strtolower($value_post)]=='' ||  $check_categs==1 ){
                    $has_errors=true;
                    $value_new      =   ( str_replace('-', '_', $value));
                    $value_new2     =   htmlspecialchars(stripslashes( ($value_new) ), ENT_QUOTES);
                    $string         =   __('Please submit the','wpestate').' ';
                    if(isset($all_submission_fields[$value_new])){
                        $string     .=  $all_submission_fields[$value_new].' ';
                    }else{
                        $string     .=  $all_submission_fields[$value_new2].' ';
                    }
                    $string     .=__('field','wpestate');
                    $errors[]=$string;
                }
            }
        }
        
       

        if($has_errors){
            foreach($errors as $key=>$value){
                $show_err.=$value.'</br>';
            }            
        }else{
            $paid_submission_status = esc_html ( get_option('wp_estate_paid_submission','') );
            $new_status             = 'pending';
            
            $admin_submission_status= esc_html ( get_option('wp_estate_admin_submission','') );
            if($admin_submission_status=='no' && $paid_submission_status!='per listing'){
               $new_status='publish';  
            }
            
            
            $post = array(
                'post_title'	=> $submit_title,
                'post_content'	=> $submit_description,
                'post_status'	=> $new_status, 
                'post_type'     => 'estate_property' ,
                'post_author'   => $current_user->ID 
            );
            $post_id =  wp_insert_post($post );  
            
            if( $paid_submission_status == 'membership'){ // update pack status
                wpestate_update_listing_no($parent_userID);                
            }
       
        }
        
      

        
        
        if($post_id) {
            // uploaded images
            $order  =   0;
           
            $last_id='';
            foreach($attchs as $att_id){
                if( !is_numeric($att_id) ){
                 
                }else{
                    if($last_id==''){
                        $last_id=  $att_id;  
                    }
                    $order++;
                    wp_update_post( array(
                                'ID' => $att_id,
                                'post_parent' => $post_id,
                                'menu_order'=>$order
                            ));
                        
                    
                }
            }
            
            if( isset($_POST['attachthumb']) &&  is_numeric($_POST['attachthumb']) && $_POST['attachthumb']!=''  ){
                set_post_thumbnail( $post_id, wp_kses(esc_html($_POST['attachthumb']),$allowed_html )); 
            }else{
                set_post_thumbnail( $post_id, $last_id );                
            }
            //end uploaded images
            
            
            if( isset($prop_category->name) ){
                wp_set_object_terms($post_id,$prop_category->name,'property_category'); 
            }  
            if ( isset ($prop_action_category->name) ){
                wp_set_object_terms($post_id,$prop_action_category->name,'property_action_category'); 
            }  
            if( isset($property_city) && $property_city!='none' ){
                if($property_city == -1 ){
                    $property_city='';
                }
                
                wp_set_object_terms($post_id,$property_city,'property_city'); 
            }  
          
            if( isset($property_area) && $property_area!='none' ){
                wp_set_object_terms($post_id,$property_area,'property_area'); 
            }  
            
            if( isset($property_county_state) && $property_county_state!='none' ){
                if($property_county_state == -1){
                    $property_county_state='';
                }
                wp_set_object_terms($post_id,$property_county_state,'property_county_state'); 
            }  
            
            if($property_area!=''){
                $terms= get_term_by('name', $property_area, 'property_area');
                if($terms!=''){
                    $t_id=$terms->term_id;
                    $term_meta=array('cityparent'=>$property_city);
                    add_option( "taxonomy_$t_id", $term_meta ); 
                }
                
            }
	 
            if($property_city!=''){
                $terms= get_term_by('name', $property_city, 'property_city');
                if($terms!=''){
                    $t_id=$terms->term_id;
                    $term_meta=array('stateparent'=>$property_county_state);
                    add_option( "taxonomy_$t_id", $term_meta ); 
                }
                
            }
          
   
            update_post_meta($post_id, 'sidebar_agent_option', 'global');
            update_post_meta($post_id, 'local_pgpr_slider_type', 'global');
            update_post_meta($post_id, 'local_pgpr_content_type', 'global');
            update_post_meta($post_id, 'prop_featured', 0);
            update_post_meta($post_id, 'property_address', $property_address);
            update_post_meta($post_id, 'property_county', $property_county);
            update_post_meta($post_id, 'property_zip', $property_zip);
			
            // energy effect
            update_post_meta($post_id, 'energy_class', $energy_class);
            update_post_meta($post_id, 'energy_index', $energy_index);
            // ee end
			
            update_post_meta($post_id, 'property_country', $country_selected);
            update_post_meta($post_id, 'property_size', $property_size);
            update_post_meta($post_id, 'owner_notes', $owner_notes);
            update_post_meta($post_id, 'property_lot_size', $property_lot_size);  
            update_post_meta($post_id, 'property_rooms', $property_rooms);  
            update_post_meta($post_id, 'property_has_subunits', $property_has_subunits);  
            update_post_meta($post_id, 'property_subunits_list', $property_subunits_list); 
            
            if(is_array($property_subunits_list)){
            foreach ($property_subunits_list as $key) {
                update_post_meta(intval($key), 'property_subunits_master',$post_id );
            }
            }else{
                update_post_meta(intval($property_subunits_list), 'property_subunits_master',$post_id );
            }
        
            
            
            update_post_meta($post_id, 'property_bedrooms', $property_bedrooms);
            update_post_meta($post_id, 'property_bathrooms', $property_bathrooms);
            update_post_meta($post_id, 'property_status', $prop_stat);
            update_post_meta($post_id, 'property_price', $property_price);
            update_post_meta($post_id, 'property_label', $property_label);
            update_post_meta($post_id, 'property_label_before', $property_label_before);
            update_post_meta($post_id, 'embed_video_type', $video_type);
            update_post_meta($post_id, 'embed_video_id',  $embed_video_id );
            update_post_meta($post_id, 'embed_virtual_tour', $virtual_tour);                 
            update_post_meta($post_id, 'property_latitude', $property_latitude);
            update_post_meta($post_id, 'property_longitude', $property_longitude);
            update_post_meta($post_id, 'property_google_view',  $google_view);
            update_post_meta($post_id, 'google_camera_angle', $google_camera_angle);
            update_post_meta($post_id, 'pay_status', 'not paid');
            update_post_meta($post_id, 'page_custom_zoom', 16);
            
     
            $user_id_agent            =   get_the_author_meta( 'user_agent_id' , $current_user->ID  );
            update_post_meta($post_id, 'property_agent', $user_id_agent);                
           
           
            // save custom fields
            $custom_fields = get_option( 'wp_estate_custom_fields', true);  
     
            $i=0;
            if( !empty($custom_fields)){  
                while($i< count($custom_fields) ){
                    $name   =   $custom_fields[$i][0];
                    $type   =   $custom_fields[$i][2];
                    $slug   =   str_replace(' ','_',$name);
                    $slug   =   wpestate_limit45(sanitize_title( $name ));
                    $slug   =   sanitize_key($slug);
                    if( isset($_POST[$slug]) ){
                        if($type=='numeric'){
                            $value_custom    =   intval(wp_kses( $_POST[$slug],$allowed_html ) );

                            if($value_custom==0){
                                $value_custom='';
                            }

                           update_post_meta($post_id, $slug, $value_custom);
                        }else{
                            $value_custom    =   esc_html(wp_kses( $_POST[$slug],$allowed_html ) );
                            update_post_meta($post_id, $slug, $value_custom);
                        }
                        $custom_fields_array[$slug]= wp_kses( esc_html($_POST[$slug]),$allowed_html);
                    }
                   
                    $i++;
                }
            }
            
            
            
            
            foreach($feature_list_array as $key => $value){
                $post_var_name      =   str_replace(' ','_', trim($value) );
                $post_var_name      =   wpestate_limit45(sanitize_title( $post_var_name ));
                $post_var_name      =   sanitize_key($post_var_name);
                
                if( isset($_POST[$post_var_name])){
                    $feature_value  =   wp_kses( esc_html($_POST[$post_var_name]) ,$allowed_html);
                    update_post_meta($post_id, $post_var_name, $feature_value);
                }               
                $moving_array[] =   $post_var_name;
            }
   
            wpestate_update_hiddent_address_single($post_id);
            
            // get user dashboard link
            $redirect = wpestate_get_template_link('user_dashboard.php');
            
            $arguments=array(
                'new_listing_url'   => get_permalink($post_id),
                'new_listing_title' => $submit_title
            );
            wpestate_select_email_type(get_option('admin_email'),'new_listing_submission',$arguments);
    
            wp_reset_query();
            wp_redirect( $redirect);
            exit;
        }
        
        }else{
            echo 'sorry , you cannot submit';
                //end if user can submit   
        }
} // end post



get_header();
$options=wpestate_page_details($post->ID);



///////////////////////////////////////////////////////////////////////////////////////////
/////// Html Form Code below
///////////////////////////////////////////////////////////////////////////////////////////

$current_user               =   wp_get_current_user();
$user_custom_picture        =   get_the_author_meta( 'small_custom_picture' , $current_user->ID  );
$user_small_picture_id      =   get_the_author_meta( 'small_custom_picture' , $current_user->ID  );
if( $user_small_picture_id == '' ){

    $user_small_picture[0]=get_template_directory_uri().'/img/default-user_1.png';
}else{
    $user_small_picture=wp_get_attachment_image_src($user_small_picture_id,'agent_picture_thumb');
    
}


?>

<div class="row">

    <div class=" <?php print esc_html($options['content_class']);?>  page-template-front_property_submit wpestate_inside_container">
        <?php get_template_part('templates/ajax_container'); ?>
		
		<form action="" method="POST" id="front_submit_form" >
		<input type="hidden" name="action" value="front_submit" />
		<?php wp_nonce_field( 'submit_property_front_action', 'submit_property_front' ); 
       
		
		
			echo '<div class="navigation_container">';
			echo '
			<a href="#" class="inner_navigation navigation_1 active" data-id="1">'.__('Description', 'wpestate').'</a>
			<a href="#" class="inner_navigation navigation_2" data-id="2">'.__('Media', 'wpestate').'</a>
			<a href="#" class="inner_navigation navigation_3" data-id="3">'.__('Location', 'wpestate').'</a>
			<a href="#" class="inner_navigation navigation_4" data-id="4">'.__('Property Details', 'wpestate').'</a>
			<a href="#" class="inner_navigation navigation_5" data-id="5">'.__('Amenities and features', 'wpestate').'</a>
			<a href="#" class="inner_navigation navigation_6" data-id="6">'.__('Subunits - replace', 'wpestate').'</a>';
                        
                        if ( !is_user_logged_in() ) {  
                            echo '<a href="#" class="inner_navigation navigation_7" data-id="7">'.__('Login/Register', 'wpestate').'</a>';
                        }
                        echo '</div>';
                        $mandatory_fields           =   ( get_option('wp_estate_mandatory_page_fields','') );
                        if(is_array($mandatory_fields)){
                            $mandatory_fields           =   array_map("wpestate_strip_array",$mandatory_fields);
                        }
                        if(is_array($mandatory_fields) && !empty($mandatory_fields) ){
                            $all_mandatory_fields   =   wpestate_return_all_fields(1);
                            print '<div class="submit_mandatory col-md-12">';
                            _e('These fields are mandatory: Title','wpestate');
                                foreach ($mandatory_fields as  $key=>$value){
                                    print ', '.$all_mandatory_fields[$value];
                                }
                            print '</div>';
                        }
                      
                        if( esc_html ( get_option('wp_estate_paid_submission','') ) == 'yes' ){
                            print '<br>'.__('This is a paid submission.The listing will be live after payment is received.','wpestate');  
                        }

                        if($show_err){
                            print '<div class="alert alert-danger">'.$show_err.'</div>';
                        }

                        
                        print '<div class="navigation_buttons_wrapper_top">
                            <button type="button" class="wpresidence_button" id="front_submit_prev_step_top">'.__('Prev Step', 'wpestate').'</button>
                            <button type="button" class="wpresidence_button" id="front_submit_next_step_top">'.__('Next Step', 'wpestate').'</button></div>';
 
 
			echo '<div class="single_step step_1">';
                            get_template_part('templates/submit_templates/property_description'); 
                            get_template_part('templates/submit_templates/property_categories');
                            get_template_part('templates/submit_templates/property_status');  
			echo '</div>';
            
			echo '<div class="single_step step_2">';
			include(locate_template('templates/submit_templates/property_images.php')); 
                            get_template_part('templates/submit_templates/property_video');
                            get_template_part('templates/submit_templates/video_tour');
			echo '</div>';
			
			echo '<div class="single_step step_3">';
                            get_template_part('templates/submit_templates/property_location');
			echo '</div>';
			
			echo '<div class="single_step step_4">';
                            get_template_part('templates/submit_templates/property_details');
			get_template_part('templates/submit_templates/property_energy_effective');
                        echo '</div>';
			
			echo '<div class="single_step step_5">';
                            get_template_part('templates/submit_templates/property_amenities');  
                        echo '</div>';
			
			echo '<div class="single_step step_6">';
                            echo 'replace - nu se pot arata subunits decat logat.';
			echo '</div>';
			
                        
                        
                        
			echo '<div class="single_step step_7">';
			echo '
			<div class="login_header_text">
				'.__('Do you have an account?', 'wpestate').'
			</div>';
			
                        echo '<div id="front_end_submit_register">LOgin or register </div> 
                        <input type="hidden" id="loginpop" value="3">';
                        
                      
                        
			echo '</div>';
			
			
			echo '<div class="navigation_container_footer">';
			echo '
			<input type="hidden" value="1" id="current_step" />
			<input type="hidden" value="register" id="submit_type" />
			<button type="button" class="wpresidence_button" id="front_submit_prev_step">'.__('Prev Step', 'wpestate').'</button>
			<button type="button" class="wpresidence_button" id="front_submit_next_step">'.__('Next Step', 'wpestate').'</button>
			<button type="submit" class="wpresidence_button" id="submit_property">'.__('Submit Property', 'wpestate').'<span class="loadersmall hidden"></span></button>
			';
			echo '</div>';
			
			
			
			
			
			echo '<div class="status_container" id="status_container">';
			echo '</div>';

		?>     
                <?php wp_nonce_field('submit_new_estate','new_estate'); ?>
		</form>
    </div><!-- end 9col container-->
    
<?php  
include(locate_template('sidebar.php')); 
?>
</div>   
<?php get_footer(); ?>