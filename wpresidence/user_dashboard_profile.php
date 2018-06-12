<?php
// Template Name: User Dashboard Profile Page
// Wp Estate Pack
<<<<<<< HEAD
global $current_user;
get_currentuserinfo(); 
$dash_profile_link = get_dashboard_profile_link();
=======
$current_user       = wp_get_current_user();
$dash_profile_link  = wpestate_get_template_link('user_dashboard_profile.php');

>>>>>>> 64662fd89bea560852792d7203888072d7452d48

 
//////////////////////////////////////////////////////////////////////////////////////////
// Paypal payments for membeship packages
//////////////////////////////////////////////////////////////////////////////////////////
if (isset($_GET['token']) ){
    $allowed_html   =   array();
<<<<<<< HEAD
    $token               =   wp_kses ( $_GET['token'] ,$allowed_html);
    $token_recursive     =   wp_kses ( $_GET['token'] ,$allowed_html);
=======
    $token               =   esc_html ( wp_kses( $_GET['token'], $allowed_html) );
    $token_recursive     =   esc_html ( wp_kses( $_GET['token'], $allowed_html) );
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    
       
    // get transfer data
    $save_data              =   get_option('paypal_pack_transfer');
    $payment_execute_url    =   $save_data[$current_user->ID ]['paypal_execute'];
    $token                  =   $save_data[$current_user->ID ]['paypal_token'];
    $pack_id                =   $save_data[$current_user->ID ]['pack_id'];
    $recursive              =   0;
    if (isset ( $save_data[$current_user->ID ]['recursive']) ){
        $recursive              =   $save_data[$current_user->ID ]['recursive']; 
    }

<<<<<<< HEAD
    if($recursive!=1){
        if( isset($_GET['PayerID']) ){
            $payerId             =   wp_kses ( $_GET['PayerID'],$allowed_html );  

            $payment_execute = array(
                           'payer_id' => $payerId
                          );
=======

    if( isset($_GET['PayerID']) ){
            $payerId             =   esc_html( wp_kses( $_GET['PayerID'], $allowed_html) );  

            $payment_execute = array(
                'payer_id' => $payerId
               );
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
            $json = json_encode($payment_execute);
            $json_resp = wpestate_make_post_call($payment_execute_url, $json,$token);

            $save_data[$current_user->ID ]=array();
            update_option ('paypal_pack_transfer',$save_data); 

            if($json_resp['state']=='approved' ){

                 if( wpestate_check_downgrade_situation($current_user->ID,$pack_id) ){
                    wpestate_downgrade_to_pack( $current_user->ID, $pack_id );
                    wpestate_upgrade_user_membership($current_user->ID,$pack_id,1,'');
                 }else{
                    wpestate_upgrade_user_membership($current_user->ID,$pack_id,1,'');
                 }
<<<<<<< HEAD
                 wp_redirect( $dash_profile_link ); 
            }
        } //end if Get
    }else{
         
        require('libs/resources/paypalfunctions.php');   
        $billing_period                 =   get_post_meta($pack_id, 'biling_period', true);
        $billing_freq                   =   intval(get_post_meta($pack_id, 'billing_freq', true));
        
        $obj=new paypal_recurring;
        $obj->environment       =   esc_html( get_option('wp_estate_paypal_api','') );
        $obj->paymentType       =   urlencode('Sale');          // or 'Sale' or 'Order'
        $paypal_api_username    =   esc_html( get_option('wp_estate_paypal_api_username','') );
        $paypal_api_password    =   esc_html( get_option('wp_estate_paypal_api_password','') );
        $paypal_api_signature   =   esc_html( get_option('wp_estate_paypal_api_signature','') );    
        $obj->API_UserName      =   urlencode( $paypal_api_username );
        $obj->API_Password      =   urlencode( $paypal_api_password );
        $obj->API_Signature     =   urlencode( $paypal_api_signature );
        $obj->API_Endpoint      =   "https://api-3t.paypal.com/nvp";
        $obj->paymentType       =   urlencode('Sale');  
        $obj->returnURL         =   urlencode($dash_profile_link);
        $obj->cancelURL         =   urlencode($dash_profile_link);
        $obj->paymentAmount     =   get_post_meta($pack_id, 'pack_price', true);
        $obj->currencyID        =   get_option('wp_estate_submission_curency','');
        $date                   =   $save_data[$current_user->ID ]['date'];
        $obj->startDate         =   urlencode($date);
        $obj->billingPeriod     =   urlencode($billing_period);         
        $obj->billingFreq       =   urlencode($billing_freq); 
        $pack_name              =   get_the_title($pack_id);
        $obj->productdesc       =   urlencode($pack_name.__(' package on ','wpestate').get_bloginfo('name') );
        $obj->user_id           =   $current_user->ID;
        $obj->pack_id           =   $pack_id;
        
       if ( $obj->getExpressCheckout($token_recursive) ){
            
             if( wpestate_check_downgrade_situation($current_user->ID,$pack_id) ){
                 wpestate_downgrade_to_pack( $current_user->ID, $pack_id );
                 wpestate_upgrade_user_membership($current_user->ID,$pack_id,2,'');
             }else{
                 wpestate_upgrade_user_membership($current_user->ID,$pack_id,2,'');
             }      
             wp_redirect( $dash_profile_link );  
        }
        
    }
                             
=======
                 wp_redirect( $dash_profile_link ); exit;
            }
         //end if Get
    }else{
        $payment_execute = array();
        $json       = json_encode($payment_execute);
        $json_resp  = wpestate_make_post_call($payment_execute_url, $json,$token);
       
        if( isset($json_resp['state']) && $json_resp['state']=='Active'){
            if( wpestate_check_downgrade_situation($current_user->ID,$pack_id) ){
                wpestate_downgrade_to_pack( $current_user->ID, $pack_id );
                wpestate_upgrade_user_membership($current_user->ID,$pack_id,2,'');
            }else{
                wpestate_upgrade_user_membership($current_user->ID,$pack_id,2,'');
            }      
            
            // canel curent agrement
            update_user_meta($current_user->ID,'paypal_agreement',$json_resp['id']);
            
            wp_redirect( $dash_profile_link );  
            exit();
            
         }
    }
        
//        require('libs/resources/paypalfunctions.php');   
//        $billing_period                 =   get_post_meta($pack_id, 'biling_period', true);
//        $billing_freq                   =   intval(get_post_meta($pack_id, 'billing_freq', true));
//        
//        $obj=new paypal_recurring;
//        $obj->environment       =   esc_html( get_option('wp_estate_paypal_api','') );
//        $obj->paymentType       =   urlencode('Sale');          // or 'Sale' or 'Order'
//        $paypal_api_username    =   esc_html( get_option('wp_estate_paypal_api_username','') );
//        $paypal_api_password    =   esc_html( get_option('wp_estate_paypal_api_password','') );
//        $paypal_api_signature   =   esc_html( get_option('wp_estate_paypal_api_signature','') );    
//        $obj->API_UserName      =   urlencode( $paypal_api_username );
//        $obj->API_Password      =   urlencode( $paypal_api_password );
//        $obj->API_Signature     =   urlencode( $paypal_api_signature );
//        $obj->API_Endpoint      =   "https://api-3t.paypal.com/nvp";
//        $obj->paymentType       =   urlencode('Sale');  
//        $obj->returnURL         =   urlencode($dash_profile_link);
//        $obj->cancelURL         =   urlencode($dash_profile_link);
//        $obj->paymentAmount     =   get_post_meta($pack_id, 'pack_price', true);
//        $obj->currencyID        =   get_option('wp_estate_submission_curency','');
//        $date                   =   $save_data[$current_user->ID ]['date'];
//        $obj->startDate         =   urlencode($date);
//        $obj->billingPeriod     =   urlencode($billing_period);         
//        $obj->billingFreq       =   urlencode($billing_freq); 
//        $pack_name              =   get_the_title($pack_id);
//        $obj->productdesc       =   urlencode($pack_name.__(' package on ','wpestate').get_bloginfo('name') );
//        $obj->user_id           =   $current_user->ID;
//        $obj->pack_id           =   $pack_id;
//        
//       if ( $obj->getExpressCheckout($token_recursive) ){
//            
//             if( wpestate_check_downgrade_situation($current_user->ID,$pack_id) ){
//                 wpestate_downgrade_to_pack( $current_user->ID, $pack_id );
//                 wpestate_upgrade_user_membership($current_user->ID,$pack_id,2,'');
//             }else{
//                 wpestate_upgrade_user_membership($current_user->ID,$pack_id,2,'');
//             }      
//             wp_redirect( $dash_profile_link );  exit;
//        }
//        
//    }
    update_option('paypal_pack_transfer','');                         
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
}


//////////////////////////////////////////////////////////////////////////////////////////
// 3rd party login code
//////////////////////////////////////////////////////////////////////////////////////////

if( ( isset($_GET['code']) && isset($_GET['state']) ) ){
<<<<<<< HEAD
    estate_facebook_login($_GET);
  
=======
    $vsessionid = session_id();
    if (empty($vsessionid)) {session_name('PHPSESSID'); session_start();}
    estate_facebook_login($_GET);
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
}else if(isset($_GET['openid_mode']) && $_GET['openid_mode']=='id_res' ){   
    estate_open_id_login($_GET);
  
}else if (isset($_GET['code'])){
    estate_google_oauth_login($_GET);
}else{
    if ( !is_user_logged_in() ) {   
<<<<<<< HEAD
      wp_redirect(  home_url() );
=======
      wp_redirect(  home_url() );exit;
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    }

}
   
$paid_submission_status         =   esc_html ( get_option('wp_estate_paid_submission','') );
$price_submission               =   floatval( get_option('wp_estate_price_submission','') );
$submission_curency_status      =   esc_html( get_option('wp_estate_submission_curency','') );
<<<<<<< HEAD
$edit_link                      =   get_dasboard_add_listing();
$processor_link                 =   get_procesor_link();
  
get_header();
$options=wpestate_page_details($post->ID);
?> 

<!--        -               -->

<div class="row">
    <?php get_template_part('templates/breadcrumbs'); ?>
    <div class="col-md-3">
       <?php  get_template_part('templates/user_menu');  ?>
    </div>  
    
    
    <div class="col-md-9 dashboard-margin">
        
        <?php get_template_part('templates/ajax_container'); ?>
        
        <?php while (have_posts()) : the_post(); ?>
            <?php if (esc_html( get_post_meta($post->ID, 'page_show_title', true) ) != 'no') { ?>
                <h1 class="entry-title"><?php the_title(); ?></h1>
=======
$edit_link                      =   wpestate_get_template_link('user_dashboard_add.php');
$processor_link                 =   wpestate_get_template_link('processor.php');
  
get_header();
$options=wpestate_page_details($post->ID);





?> 

<?php
$current_user               =   wp_get_current_user();
$user_custom_picture        =   get_the_author_meta( 'small_custom_picture' , $current_user->ID  );
$user_small_picture_id      =   get_the_author_meta( 'small_custom_picture' , $current_user->ID  );
if( $user_small_picture_id == '' ){

    $user_small_picture[0]=get_template_directory_uri().'/img/default-user_1.png';
}else{
    $user_small_picture=wp_get_attachment_image_src($user_small_picture_id,'agent_picture_thumb');
    
}
?>
<!--  -->
<!--                      -->

<div class="row row_user_dashboard">

    <div class="col-md-3 user_menu_wrapper">
       <div class="dashboard_menu_user_image">
            <div class="menu_user_picture" style="background-image: url('<?php print $user_small_picture[0];  ?>');height: 80px;width: 80px;" ></div>
            <div class="dashboard_username">
                <?php _e('Welcome back, ','wpestate'); echo $user_login.'!';?>
            </div> 
        </div>
          <?php  get_template_part('templates/user_menu');  ?>
    </div>  
    

    <div class="col-md-9 dashboard-margin">
        <?php get_template_part('templates/breadcrumbs'); ?>
        <?php  get_template_part('templates/user_memebership_profile');  ?>
        <?php get_template_part('templates/ajax_container'); ?>
        <?php while (have_posts()) : the_post(); ?>
            <?php if (esc_html( get_post_meta($post->ID, 'page_show_title', true) ) != 'no') { ?>
                <h3 class="entry-title"><?php the_title(); ?></h3>
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
            <?php } ?>
         
            <div class="single-content"><?php the_content();?></div><!-- single content-->

<<<<<<< HEAD
           <?php endwhile; // end of the loop. ?>
           <?php   get_template_part('templates/user_profile'); ?>
    </div>
    
  
  
</div>   
<?php get_footer(); ?>
=======
        <?php endwhile; // end of the loop. ?>
            
            
        <?php  
       $user_role = intval (get_user_meta( $current_user->ID, 'user_estate_role', true) );
           
        if($user_role==1 || $user_role==0){
            get_template_part('templates/user_profile');
        }else if($user_role==2){
            get_template_part('templates/user_profile_agent');
        }else if($user_role==3){
            get_template_part('templates/user_profile_agency');
        }else if($user_role==4){        
            get_template_part('templates/user_profile_developer');
        }
        
        ?>
         
    </div>
  
  
</div>  


<?php get_footer(); ?>

<?php
$buy_pack=  get_query_var( 'packet', 0 );

if($buy_pack!=0){


    print '<script type="text/javascript">
                //<![CDATA[
                jQuery(document).ready(function(){
              
                var handler= jQuery(".pack-listing[data-id='.$buy_pack.']");
                
                    jQuery(\'#open_packages\').trigger(\'click\');
                    jQuery(\'.pack-listing[data-id='.$buy_pack.']\').find(\'.buypackage\').trigger(\'click\');
                });
                //]]>
            </script>';
}
?>
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
