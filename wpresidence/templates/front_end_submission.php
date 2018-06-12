<?php 
global $submit_title;
global $submit_description;
global $prop_category;
global $prop_action_category;       
global $property_city;      
global $property_area;
global $property_address;
global $property_county;
<<<<<<< HEAD
global $property_state; 
global $property_zip; 
=======
global $property_zip;
global $property_state;
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
global $country_selected; 
global $property_status; 
global $property_price; 
global $property_label; 
<<<<<<< HEAD
=======
global $property_label_before; 
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
global $property_size; 
global $property_lot_size; 
global $property_year;
global $property_rooms;    
global $property_bedrooms;      
global $property_bathrooms; 
global $option_video; 
global $embed_video_id; 
<<<<<<< HEAD
=======
global $virtual_tour;
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
global $property_latitude; 
global $property_longitude;
global $google_view_check; 
global $prop_featured_check;
global $google_camera_angle;  
global $action;
global $edit_id;
global $show_err;
global $feature_list_array;
global $prop_category_selected;
global $prop_action_category_selected;
global $userID;
global $user_pack;
global $prop_featured;                
global $current_user;
global $custom_fields_array;
global $option_slider;
<<<<<<< HEAD


$images_to_show     =   '';
$remaining_listings =   wpestate_get_remain_listing_user($userID,$user_pack);
=======
global $property_has_subunits;
global $property_subunits_list;
global $all_submission_fields;
global $submission_page_fields;
//kul
$parent_userID          =   wpestate_check_for_agency($userID);


$images_to_show     =   '';
$remaining_listings =   wpestate_get_remain_listing_user($parent_userID,$user_pack);
>>>>>>> 64662fd89bea560852792d7203888072d7452d48

if($remaining_listings  === -1){
   $remaining_listings=11;
}
$paid_submission_status= esc_html ( get_option('wp_estate_paid_submission','') );

    

if( !isset( $_GET['listing_edit'] ) && $paid_submission_status == 'membership' && $remaining_listings != -1 && $remaining_listings < 1 ) {
    print '<div class="user_profile_div"><h4>'.__('Your current package doesn\'t let you publish more properties! You need to upgrade your membership.','wpestate' ).'</h4></div>';
}else{
<<<<<<< HEAD
     
=======
 
          
    $mandatory_fields           =   ( get_option('wp_estate_mandatory_page_fields','') );
    if(is_array($mandatory_fields)){
        $mandatory_fields           =   array_map("wpestate_strip_array",$mandatory_fields);
    }
    if(is_array($mandatory_fields) && !empty($mandatory_fields) ){
        $all_mandatory_fields   =   wpestate_return_all_fields(1);
        print '<div class="submit_mandatory col-md-9">';
        _e('These fields are mandatory: Title','wpestate');
            foreach ($mandatory_fields as  $key=>$value){
                print ', '.$all_mandatory_fields[$value];
            }
        print '</div>';
    }
             
                
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
?>




<<<<<<< HEAD


=======
 
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
<form id="new_post" name="new_post" method="post" action="" enctype="multipart/form-data" class="add-estate">
     
       <?php
       
       if( esc_html ( get_option('wp_estate_paid_submission','') ) == 'yes' ){
         print '<br>'.__('This is a paid submission.The listing will be live after payment is received.','wpestate');  
       }
        
       ?>
        </span> 
        
<<<<<<< HEAD
     
=======
<div class="col-md-12 row_dasboard-prop-listing">
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
       <?php
       if($show_err){
           print '<div class="alert alert-danger">'.$show_err.'</div>';
       }
       ?>
<<<<<<< HEAD
            
    
=======
</div>

>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    
    <div class="profile-page row">
             <?php
              if ( wp_is_mobile() ) { 
<<<<<<< HEAD
                 // echo "Do Something if it's a mobile device";
                  get_template_part('templates/submit_templates/property_description'); 
                  get_template_part('templates/submit_templates/property_featured');
                  get_template_part('templates/submit_templates/property_images'); 
                  get_template_part('templates/submit_templates/property_location'); 
                  get_template_part('templates/submit_templates/property_details');
                  get_template_part('templates/submit_templates/user_memebership_form'); 
                  get_template_part('templates/submit_templates/property_categories'); 
                 // get_template_part('templates/submit_templates/property_slider');  
                  get_template_part('templates/submit_templates/property_status');  
                  get_template_part('templates/submit_templates/property_amenities');  
                  get_template_part('templates/submit_templates/property_video');

              }else{

                  print '<div class="col-md-8 ">';
                    get_template_part('templates/submit_templates/property_description'); 
                    include(locate_template('templates/submit_templates/property_images.php')); 
                  
                    
                    get_template_part('templates/submit_templates/property_location');
                    get_template_part('templates/submit_templates/property_details');
                    
                   
                  print '</div>';
                  
                  
                  print '<div class="col-md-4">';
                    get_template_part('templates/submit_templates/user_memebership_form'); 
                    get_template_part('templates/submit_templates/property_featured');
                    get_template_part('templates/submit_templates/property_categories');
                  //  get_template_part('templates/submit_templates/property_slider'); 
                    get_template_part('templates/submit_templates/property_status');  
                    get_template_part('templates/submit_templates/property_amenities');  
                    get_template_part('templates/submit_templates/property_video'); 
                  print '</div>';
                  
                  
              
                
              
                            
              }
=======
                    get_template_part('templates/submit_templates/user_memebership_form');
                    get_template_part('templates/submit_templates/property_featured');
//                    print '<div class="submit_container">';
                    get_template_part('templates/submit_templates/property_description');
                    get_template_part('templates/submit_templates/property_categories'); 
                    get_template_part('templates/submit_templates/property_images'); 
                    get_template_part('templates/submit_templates/property_location');
                    get_template_part('templates/submit_templates/property_energy_effective');  
                    get_template_part('templates/submit_templates/property_details'); 
                    get_template_part('templates/submit_templates/property_status');  
                    get_template_part('templates/submit_templates/property_amenities');  
                    get_template_part('templates/submit_templates/property_video');
                    get_template_part('templates/submit_templates/video_tour');
                    get_template_part('templates/submit_templates/property_subunits');
                   // print'<div>';
            }else{
                    print '<div class="col-md-9 user_dashboard">';
                    get_template_part('templates/submit_templates/property_description'); 
                    get_template_part('templates/submit_templates/property_categories');
                    include(locate_template('templates/submit_templates/property_images.php')); 
                    get_template_part('templates/submit_templates/property_location');
                    get_template_part('templates/submit_templates/property_energy_effective');
                    get_template_part('templates/submit_templates/property_details');
                    get_template_part('templates/submit_templates/property_status');  
                    get_template_part('templates/submit_templates/property_amenities');  
                    get_template_part('templates/submit_templates/property_video');
                    get_template_part('templates/submit_templates/video_tour');
                    get_template_part('templates/submit_templates/property_subunits');
                    print '</div>';

                    print '<div class="col-md-3 user_dashboard">';
                    get_template_part('templates/submit_templates/user_memebership_form'); 
                    get_template_part('templates/submit_templates/property_featured');
                    print '</div>';
                             
            }
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
            ?>
   
     


<<<<<<< HEAD
    <input type="hidden" name="action" value="<?php print $action;?>">
        <div class="submit_form_row">
            <?php
            if($action=='edit'){ ?>
                <input type="submit" class="wpb_button  wpb_btn-info wpb_btn-large" id="form_submit_1" value="<?php _e('SAVE CHANGES', 'wpestate') ?>" />
            <?php    
            }else{
            ?>
               <input type="submit" class="wpb_button  wpb_btn-info wpb_btn-large" id="form_submit_1" value="<?php _e('ADD PROPERTY', 'wpestate') ?>" />
            <?php
            }
            ?>
        </div>  
=======
   
   <div class="col-md-12">
       <div class="col-md-3"></div>
       <div class="col-md-9">
            <input type="hidden" name="action" value="<?php print $action;?>">
            <div class="submit_form_row">
                <?php
                if($action=='edit'){ ?>
                    <input type="submit" class="wpresidence_button" id="form_submit_1" value="<?php _e('SAVE CHANGES', 'wpestate') ?>" />
                <?php    
                }else{
                ?>
                   <input type="submit" class="wpresidence_button" id="form_submit_1" value="<?php _e('ADD PROPERTY', 'wpestate') ?>" />
                <?php
                }
                ?>
            </div>
        </div>
    </div>

</div>
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    
    
    
    
   
    
    
    
    </div><!-- end row--> 
       
    <input type="hidden" name="edit_id" value="<?php print $edit_id;?>">
    <input type="hidden" name="images_todelete" id="images_todelete" value="">
    <?php wp_nonce_field('submit_new_estate','new_estate'); ?>
</form>
<?php } // end check pack rights ?>