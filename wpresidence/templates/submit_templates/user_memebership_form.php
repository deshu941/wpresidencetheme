<?php 
<<<<<<< HEAD
global $current_user;
get_currentuserinfo();
$userID                 =   $current_user->ID;
$user_login             =   $current_user->user_login;
$user_pack              =   get_the_author_meta( 'package_id' , $userID );
$user_registered        =   get_the_author_meta( 'user_registered' , $userID );
$user_package_activation=   get_the_author_meta( 'package_activation' , $userID );
=======
$current_user = wp_get_current_user();
$userID                 =   $current_user->ID;
$parent_userID          =   wpestate_check_for_agency($userID);
$user_login             =   $current_user->user_login;
$user_pack              =   get_the_author_meta( 'package_id' , $parent_userID );
$user_registered        =   get_the_author_meta( 'user_registered' , $parent_userID );
$user_package_activation=   get_the_author_meta( 'package_activation' , $parent_userID );
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
$images                 =   '';
$counter                =   0;
$unit                   =   esc_html( get_option('wp_estate_measure_sys', '') );
$paid_submission_status = esc_html ( get_option('wp_estate_paid_submission','') );
?> 


    <?php                        
    if( $paid_submission_status == 'membership'){
<<<<<<< HEAD
       print'
       <div class="submit_container">    
       <div class="submit_container_header">'.__('Membership','wpestate').'</div>'; 
       wpestate_get_pack_data_for_user($userID,$user_pack,$user_registered,$user_package_activation);
=======
    
       print'
       <div class="submit_container">    
       <div class="submit_container_header">'.__('Membership','wpestate').'</div>'; 
       wpestate_get_pack_data_for_user($parent_userID,$user_pack,$user_registered,$user_package_activation);
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
       print'</div>'; // end submit container
    }
    if( $paid_submission_status == 'per listing'){
        $price_submission               =   floatval( get_option('wp_estate_price_submission','') );
        $price_featured_submission      =   floatval( get_option('wp_estate_price_featured_submission','') );
        $submission_curency_status      =   esc_html( get_option('wp_estate_submission_curency','') );
<<<<<<< HEAD
        print'
        <div class="submit_container">
        <div class="submit_container_header">'.__('Paid submission','wpestate').'</div>';
=======
        print'<div class="submit_container">
        <div class="submit_container_header">'.__('Paid submission','wpestate').'</div>';
        print'<div class="user_dashboard_box">';
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        print '<p class="full_form-nob">'.__( 'This is a paid submission.','wpestate').'</p>';
        print '<p class="full_form-nob">'.__( 'Price: ','wpestate').'<span class="submit-price">'.$price_submission.' '.$submission_curency_status.'</span></p>';
        print '<p class="full_form-nob">'.__( 'Featured (extra): ','wpestate').'<span class="submit-price">'.$price_featured_submission.' '.$submission_curency_status.'</span></p>';
        print'</div>'; // end submit container
<<<<<<< HEAD
=======
        print'</div>';
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
     }
    ?>