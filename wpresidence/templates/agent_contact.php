<?php
<<<<<<< HEAD
global $agent_email;
global $propid;

$contact_form_7_agent   =   stripslashes( ( get_option('wp_estate_contact_form_7_agent','') ) );
$contact_form_7_contact =   stripslashes( ( get_option('wp_estate_contact_form_7_contact','') ) );
?>
  
<div class="agent_contanct_form">
    <?php    
     if ( basename(get_page_template())!='contact_page.php') { ?>
             <h4 id="show_contact"><?php _e('Contact Me', 'wpestate'); ?></h4>
     <?php 
           }else{
     ?>
             <h4 id="show_contact"><?php _e('Contact Us', 'wpestate'); ?></h4>
     <?php } ?>
                
=======

global $propid;
$agent_id   = intval( get_post_meta($propid, 'property_agent', true) );

if(is_singular('estate_agent') ||is_singular('estate_agency') || is_singular('estate_developer')){
    $agent_id = get_the_ID();
}



$contact_form_7_agent   =   stripslashes( ( get_option('wp_estate_contact_form_7_agent','') ) );
$contact_form_7_contact =   stripslashes( ( get_option('wp_estate_contact_form_7_contact','') ) );
if (function_exists('icl_translate') ){
    $contact_form_7_agent     =   icl_translate('wpestate','contact_form7_agent', $contact_form_7_agent ) ;
    $contact_form_7_contact   =   icl_translate('wpestate','contact_form7_contact', $contact_form_7_contact ) ;
}
?>
  
<div class="agent_contanct_form ">
    <?php    
    if ( basename(get_page_template())!='contact_page.php') { ?>
        <?php
        if(is_singular('estate_agency')|| is_singular('estate_developer') ){
           echo '<h4 id="show_contact">'.__('Contact Us', 'wpestate').'</h4>';
        }else{
            echo '<h4 id="show_contact">'.__('Contact Me', 'wpestate').'</h4>';
        }
        ?>
       
        <?php 
        if( $contact_form_7_agent ==''){ 
        ?>
            <div id="schedule_meeting"><?php _e('Schedule a showing?','wpestate');?></div>    
        <?php 
        } 
        ?>


    <?php }else{ ?>
        <h4 id="show_contact"><?php _e('Contact Us', 'wpestate'); ?></h4>
        
       
    <?php } ?>

>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    <?php if ( ($contact_form_7_agent =='' && basename(get_page_template())!='contact_page.php') || ( $contact_form_7_contact=='' && basename(get_page_template())=='contact_page.php')  ){ ?>


        <div class="alert-box error">
          <div class="alert-message" id="alert-agent-contact"></div>
        </div> 

<<<<<<< HEAD

=======
        <div class="schedule_wrapper ">    
            <div class="col-md-6">
                <input name="schedule_day" id="schedule_day" type="text"  placeholder="<?php _e('Day', 'wpestate'); ?>" aria-required="true" class="form-control">
            </div>
               
            <div class="col-md-6">
                <select name="schedule_hour" id="schedule_hour" class="form-control">
                    <option value="0"><?php _e('Time','wpestate');?></option>
                    <?php
                    for ($i=7; $i <= 19; $i++){
                        for ($j = 0; $j <= 45; $j+=15){
                            $show_j=$j;
                            if($j==0){
                                $show_j='00';
                            }

                            $val =$i.':'.$show_j;
                            echo '<option value="'.$val.'">'.$val.'</option>';
                        }
                    }
                    ?>
                </select>       
            </div>    
        </div>
            
            
            
    
          
  
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        <input name="contact_name" id="agent_contact_name" type="text"  placeholder="<?php _e('Your Name', 'wpestate'); ?>" 
               aria-required="true" class="form-control">
        <input type="text" name="email" class="form-control" id="agent_user_email" aria-required="true" placeholder="<?php _e('Your Email', 'wpestate'); ?>" >
        <input type="text" name="phone"  class="form-control" id="agent_phone" placeholder="<?php _e('Your Phone', 'wpestate'); ?>" >

<<<<<<< HEAD
        <textarea id="agent_comment" name="comment" class="form-control" cols="45" rows="8" aria-required="true" placeholder="<?php _e('Your Message', 'wpestate'); ?>" ></textarea>	

        <input type="submit" class="wpb_button  wpb_btn-info wpb_btn-large"  id="agent_submit" value="<?php _e('Send Message', 'wpestate'); ?>">

        <input name="prop_id" type="hidden"  id="agent_property_id" value="<?php echo $propid;?>">
        <input name="agent_email" type="hidden"  id="agent_email" value="<?php print $agent_email; ?>">
        <input type="hidden" name="contact_ajax_nonce" id="agent_property_ajax_nonce"  value="<?php echo wp_create_nonce( 'ajax-property-contact' );?>" />


=======
        <textarea id="agent_comment" name="comment" class="form-control" cols="45" rows="8" aria-required="true"><?php         
            if(is_singular('estate_property') ){
                _e("I'm interested in ","wpestate");
                echo ' [ '.get_the_title($propid).' ] ';
            }
            ?></textarea>	

        <input type="submit" class="wpresidence_button agent_submit_class "  id="agent_submit" value="<?php _e('Send Email', 'wpestate');?>">
        <?php if( get_option('wp_estate_enable_direct_mess',true)=='yes'){ ?>
            <input type="submit" class="wpresidence_button message_submit"   value="<?php _e('Send Private Message', 'wpestate');?>">
            <div class=" col-md-12 message_explaining"><?php _e('You can reply to private messages from "Inbox" page in your user account.','wpestate');?></div>
        <?php } ?>
     
        <input name="prop_id" type="hidden"  id="agent_property_id" value="<?php echo intval($propid);?>">
        <input name="prop_id" type="hidden"  id="agent_id" value="<?php echo intval($agent_id);?>">
        <input type="hidden" name="contact_ajax_nonce" id="agent_property_ajax_nonce"  value="<?php echo wp_create_nonce( 'ajax-property-contact' );?>" />

       
>>>>>>> 64662fd89bea560852792d7203888072d7452d48

    <?php 
    }else{
        if ( basename(get_page_template())=='contact_page.php') {
          //  $contact_form_7_contact = stripslashes( ( get_option('wp_estate_contact_form_7_contact','') ) );
            echo do_shortcode($contact_form_7_contact);
        }else{
            wp_reset_query();
            echo do_shortcode($contact_form_7_agent);
        }
      
      
    }
    ?>
</div>