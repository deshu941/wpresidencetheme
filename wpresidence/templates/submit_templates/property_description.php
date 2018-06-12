<?php
global $submit_title;
global $submit_description;
global $property_price; 
global $property_label; 
<<<<<<< HEAD
?>

<div class="submit_container">
<div class="submit_container_header"><?php _e('Property Description & Price','wpestate');?></div>

<p class="full_form">
   <label for="title"><?php _e('*Title (mandatory)','wpestate'); ?> </label>
   <input type="text" id="title" class="form-control" value="<?php print $submit_title; ?>" size="20" name="title" />
</p>

<p class="full_form">
   <label for="description"><?php _e('*Description (mandatory)','wpestate');?></label>
   <textarea id="description"  class="form-control"  name="description" cols="50" rows="6"><?php print $submit_description; ?></textarea>
</p>

 <p class="half_form">
   <label for="property_price"> <?php _e('Price in ','wpestate');print esc_html( get_option('wp_estate_currency_symbol', '') ).' '; _e('(only numbers)','wpestate'); ?>  </label>
   <input type="text" id="property_price" class="form-control" size="40" name="property_price" value="<?php print $property_price;?>">
 </p>

<p class="half_form half_form_last">
   <label for="property_label"><?php _e('After Price Label (ex: "per month")','wpestate');?></label>
   <input type="text" id="property_label" class="form-control" size="40" name="property_label" value="<?php print $property_label;?>">
</p> 
</div>
=======
global $property_label_before; 
global $submission_page_fields;

?>
<div class="col-md-12 add-estate profile-page profile-onprofile row"> 
    <div class="submit_container">



        <div class="col-md-4 profile_label">
            <div class="user_details_row"><?php _e('Property Description','wpestate');?></div> 
            <div class="user_profile_explain"><?php _e('This description will appear first in page. Keeping it as a brief overview makes it easier to read.','wpestate')?></div>
            <input type="hidden" name="is_user_submit" value="1">
        </div>



        <div class="col-md-8">   
            <p class="full_form">
               <label for="title"><?php _e('*Title (mandatory)','wpestate'); ?> </label>
               <input type="text" id="title" class="form-control" value="<?php print stripslashes(($submit_title)); ?>" size="20" name="wpestate_title" />
            </p>

            <?php if(   is_array($submission_page_fields) && in_array('wpestate_description', $submission_page_fields)) { ?>
                <p class="full_form">
                   <label for="description"><?php _e('Description','wpestate');?></label>
                  
                   
                   
                   <?php
          
                   // <textarea id="description"  class="form-control"  name="wpestate_description" cols="50" rows="6"><?php print stripslashes($submit_description);//</textarea>
                    wp_editor(  
                            stripslashes($submit_description), 
                            'description', 
                            array(
                                'textarea_rows' =>  6,
                                'textarea_name' =>  'wpestate_description',
                                'wpautop'       =>  true, // use wpautop?
                                'media_buttons' =>  false, // show insert/upload button(s)
                                'tabindex'      =>  '',
                                'editor_css'    =>  '', 
                                'editor_class'  => '', 
                                'teeny'         => false, 
                                'dfw'           => false, 
                                'tinymce'       => false,
                                'quicktags'     => array("buttons"=>"strong,em,block,ins,ul,li,ol,close"),
                               ) 
                            );
                   ?>
                
                </p>
            <?php }?>
        </div>    
    </div>

</div>






<?php if(   is_array($submission_page_fields) && 
           (    in_array('property_label', $submission_page_fields) || 
                in_array('property_price', $submission_page_fields) || 
                in_array('property_label_before', $submission_page_fields) 
            )
        ) { ?>    
    <div class="col-md-12 add-estate profile-page profile-onprofile row"> 

        <div class="submit_container">

            <div class="col-md-4 profile_label">
                <!--<div class="submit_container_header"><?php _e('Property Description & Price','wpestate');?></div>-->
                <div class="user_details_row"><?php _e('Property Price','wpestate');?></div> 
                <div class="user_profile_explain"><?php _e('Adding a price will make it easier for users to find your property in search results.','wpestate')?></div>
            </div>


            <div class="col-md-8">
                <?php if(   is_array($submission_page_fields) && in_array('property_price', $submission_page_fields)) { ?>
                    <p class="col-md-12 half_form">
                        <label for="property_price"> <?php _e('Price in ','wpestate');print esc_html( get_option('wp_estate_currency_symbol', '') ).' '; _e('(only numbers)','wpestate'); ?>  </label>
                        <input type="text" id="property_price" class="form-control" size="40" name="property_price" value="<?php print $property_price;?>">
                    </p>
                <?php }?>

                <?php if(   is_array($submission_page_fields) && in_array('property_label', $submission_page_fields)) { ?>    
                    <p class="col-md-6 half_form ">
                        <label for="property_label"><?php _e('After Price Label (ex: "/month")','wpestate');?></label>
                        <input type="text" id="property_label" class="form-control" size="40" name="property_label" value="<?php print $property_label;?>">
                    </p> 
                <?php }?>

                <?php if(   is_array($submission_page_fields) && in_array('property_label_before', $submission_page_fields)) { ?>
                    <p class="col-md-6 half_form">
                        <label for="property_label_before"><?php _e('Before Price Label (ex: "from ")','wpestate');?></label>
                        <input type="text" id="property_label_before" class="form-control" size="40" name="property_label_before" value="<?php print $property_label_before;?>">
                    </p>
                <?php }?>
            </div>

        </div>
    </div>
<?php }?>
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
