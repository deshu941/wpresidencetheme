<?php 
global $prop_featured;
global $prop_featured_check;
global $userID;

$paid_submission_status= esc_html ( get_option('wp_estate_paid_submission','') );

if ( ( $paid_submission_status == 'membership' && wpestate_get_remain_featured_listing_user($userID)>0 )){ ?>  
    <div class="submit_container">  
    <div class="submit_container_header"><?php  _e('Featured Submission','wpestate');?></div>
<<<<<<< HEAD
=======
    <div class="user_dashboard_box">
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        <p class="meta-options full_form-nob"> 
          <?php _e('Make this listing featured from property list.','wpestate')?>
        </p> 
    </div>
<<<<<<< HEAD
=======
    </div>
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
<?php 
}elseif( $paid_submission_status == 'no' ){
    //print '<input type="hidden"  id="prop_featured"  name="prop_featured"  value="0" > ';
} else{

    // print '<input type="hidden"  id="prop_featured"  name="prop_featured"  value="'.$prop_featured.'"  '.$prop_featured_check.' > ';
}
?> 
            