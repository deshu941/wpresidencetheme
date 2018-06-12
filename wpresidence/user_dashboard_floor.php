<?php
// Template Name: User Dashboard Floor Plans
// Wp Estate Pack

if ( !is_user_logged_in() ) {   
<<<<<<< HEAD
     wp_redirect(  home_url() );
} 

global $current_user;
get_currentuserinfo();     
=======
     wp_redirect(  home_url() );exit;
} 

$current_user = wp_get_current_user();  
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
$paid_submission_status         =   esc_html ( get_option('wp_estate_paid_submission','') );
$price_submission               =   floatval( get_option('wp_estate_price_submission','') );
$submission_curency_status      =   esc_html( get_option('wp_estate_submission_curency','') );
$userID                         =   $current_user->ID;
$user_option                    =   'favorites'.$userID;
$curent_fav                     =   get_option($user_option);
$show_remove_fav                =   1;   
$show_compare                   =   1;
$show_compare_only              =   'no';
$currency                       =   esc_html( get_option('wp_estate_currency_symbol', '') );
$where_currency                 =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
<<<<<<< HEAD

=======
$agent_list                     =   (array)get_user_meta($userID,'current_agent_list',true);
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
get_header();
$options=wpestate_page_details($post->ID);

$post_id='';

if( isset( $_GET['floor_edit'] ) && is_numeric( $_GET['floor_edit'] ) ){
   $post_id=intval( $_GET['floor_edit']);
   $post_title=get_the_title($post_id);
}

<<<<<<< HEAD
=======

 $the_post= get_post( $post_id); 
 
    if( $current_user->ID != $the_post->post_author &&  !in_array($the_post->post_author , $agent_list)   ) {
        exit('You don\'t have the rights to edit this');
    }

>>>>>>> 64662fd89bea560852792d7203888072d7452d48
if( 'POST' == $_SERVER['REQUEST_METHOD'] ){
    //////////////////////////////////////////////////////////////////
    /// save floor plan
    //////////////////////////////////////////////////////////////////
    
    $floor_for_post= intval($_POST['floor_for_post']);
<<<<<<< HEAD
    
   // print_R($_POST);
=======

>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    
    if(isset($_POST['use_floor_plans'])){
        update_post_meta($floor_for_post, 'use_floor_plans',intval( $_POST['use_floor_plans'] ) );
    }
    
    if(isset($_POST['plan_title'])){        
        update_post_meta($floor_for_post, 'plan_title',wpestate_sanitize_array ( $_POST['plan_title'] ) );
    }else{
        if(isset($floor_for_post)){
            update_post_meta($floor_for_post, 'plan_title','' );
        }
    }
     
    if(isset($_POST['plan_description'])){        
            update_post_meta($floor_for_post, 'plan_description',wpestate_sanitize_array ( $_POST['plan_description'] ) );
    }else{
        if(isset($floor_for_post)){
            update_post_meta($floor_for_post, 'plan_description','' );
        }
    }
    
     if(isset($_POST['plan_image_attach'])){        
            update_post_meta($floor_for_post, 'plan_image_attach',wpestate_sanitize_array ( $_POST['plan_image_attach'] ) );
    }else{
        if(isset($floor_for_post)){
            update_post_meta($floor_for_post, 'plan_image_attach','' );
        }
    }
    
    
    if(isset($_POST['plan_image'])){        
            update_post_meta($floor_for_post, 'plan_image',wpestate_sanitize_array ( $_POST['plan_image'] ) );
    }else{
        if(isset($floor_for_post)){
            update_post_meta($floor_for_post, 'plan_image','' );
        }
    }
    
    if(isset($_POST['plan_size'])){        
            update_post_meta($floor_for_post, 'plan_size',wpestate_sanitize_array ( $_POST['plan_size'] ) );
    }else{
        if(isset($floor_for_post)){
            update_post_meta($floor_for_post, 'plan_size','' );
        }
    }
    
    
      if(isset($_POST['plan_rooms'])){        
            update_post_meta($floor_for_post, 'plan_rooms',wpestate_sanitize_array ( $_POST['plan_rooms'] ) );
    }else{
        if(isset($floor_for_post)){
            update_post_meta($floor_for_post, 'plan_rooms','' );
        }
    }
    
      if(isset($_POST['plan_bath'])){        
            update_post_meta($floor_for_post, 'plan_bath',wpestate_sanitize_array ( $_POST['plan_bath'] ) );
    }else{
        if(isset($floor_for_post)){
            update_post_meta($floor_for_post, 'plan_bath','' );
        }
    }
    
      if(isset($_POST['plan_price'])){        
            update_post_meta($floor_for_post, 'plan_price',wpestate_sanitize_array ( $_POST['plan_price'] ) );
    }else{
        if(isset($floor_for_post)){
            update_post_meta($floor_for_post, 'plan_price','' );
        }
    }
    
    
    //////////////////////////////////////// end save floor plan
}




?> 


<<<<<<< HEAD
<div class="row">
    <?php get_template_part('templates/breadcrumbs'); ?>
    <div class="col-md-3">
       <?php  get_template_part('templates/user_menu');  ?>
    </div>  
    
    <div class="col-md-9 dashboard-margin">
        
=======

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


<div class="row row_user_dashboard">
    <!--<?php get_template_part('templates/breadcrumbs'); ?>-->
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
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        <?php get_template_part('templates/ajax_container'); ?>
        
        
        
        <?php if (esc_html( get_post_meta($post->ID, 'page_show_title', true) ) != 'no') { ?>
<<<<<<< HEAD
            <h1 class="entry-title"><?php the_title(); echo ' '.__('for','wpestate').' '; echo $post_title; ?></h1>
        <?php } ?>
        
     
=======
            <h3 class="entry-title"><?php the_title(); echo ' '.__('for','wpestate').' '; echo esc_html($post_title); ?></h3>
        <?php } ?>
        
     <div class="col-md-12 row_dasboard-prop-listing">
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        <?php     
        $plan_title         =   '';
        $plan_image         =   '';
        $plan_description   =   '';
        $plan_bath          =   '';
        $plan_rooms         =   '';
        $plan_size          =   '';
        $plan_price         =   '';
        
        $use_floor_plans        = get_post_meta($post_id, 'use_floor_plans', true);
        $plan_title_array       = get_post_meta($post_id, 'plan_title', true);
        $plan_desc_array        = get_post_meta($post_id, 'plan_description', true) ;
        $plan_image_attach_array= get_post_meta($post_id, 'plan_image_attach', true) ;
        $plan_image_array       = get_post_meta($post_id, 'plan_image', true) ;
        $plan_size_array        = get_post_meta($post_id, 'plan_size', true) ;
        $plan_rooms_array       = get_post_meta($post_id, 'plan_rooms', true) ;
        $plan_bath_array        = get_post_meta($post_id, 'plan_bath', true);
        $plan_price_array       = get_post_meta($post_id, 'plan_price', true) ;
        
<<<<<<< HEAD
        //print_r($plan_title_array);
        
    
     
    
=======

>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        print '<div id="plan_wrapper"><form action="" method="POST">';

        if(is_array($plan_title_array)){
            print '<p class="meta-options"> 
                  <input type="hidden" name="use_floor_plans" value="0">
                  <input type="checkbox" id="use_floor_plans" name="use_floor_plans" value="1"'; 

                if($use_floor_plans==1){
                    print ' checked="checked" ';
                }
            print'><label for="use_floor_plans">'.__('Use Floor Plans','wpestate').'</label>
            </p>';
        }

        if(is_array($plan_title_array)){
            foreach ($plan_title_array as $key=> $plan_name) {

                if ( isset($plan_desc_array[$key])){
                    $plan_desc=$plan_desc_array[$key];
                }else{
                    $plan_desc='';
                }
                
                if ( isset($plan_desc_array[$key])){
                    $plan_image_attach=$plan_image_attach_array[$key];
                }else{
                    $plan_image_attach='';
                }
                
                if ( isset($plan_image_array[$key])){
                    $plan_img=$plan_image_array[$key];
                }else{
                    $plan_img='';
                }

                if ( isset($plan_size_array[$key])){
                    $plan_size=$plan_size_array[$key];
                }else{
                    $plan_size='';
                }

                if ( isset($plan_rooms_array[$key])){
                    $plan_rooms=$plan_rooms_array[$key];
                }else{
                    $plan_rooms='';
                }

                if ( isset($plan_bath_array[$key])){
                    $plan_bath=$plan_bath_array[$key];
                }else{
                    $plan_bath='';
                }

                if ( isset($plan_price_array[$key])){
                    $plan_price=$plan_price_array[$key];
                }else{
                    $plan_price='';
                }

//user_picture_profile
            $preview=wp_get_attachment_image_src($plan_image_attach, 'user_picture_profile');    
            print '
            <div class="uploaded_images floor_container" data-imageid="">
            <input type="hidden" name="plan_image_attach[]" value="'.$plan_image_attach.'">
            <input type="hidden" name="plan_image[]" value="'.$plan_img.'">
            <img src="'.$preview[0].'" alt="thumb"><i class="fa deleter_floor fa-trash-o"></i>
            <div class="">
            <p class="meta-options floor_p">
                <label for="plan_title">'.__('Plan Title','wpestate').'</label><br>
                <input id="plan_title" type="text" size="36" name="plan_title[]" value="'.$plan_name.'" >
            </p>
            
            <p class="meta-options floor_full"> 
                <label for="plan_description">'.__('Plan Description','wpestate').'</label><br> 
                <textarea class="plan_description" type="text" size="36" name="plan_description[]" >'.$plan_desc.'</textarea>
            </p>
             
            <p class="meta-options floor_p"> 
                <label for="plan_size">'.__('Plan Size','wpestate').'</label><br> 
                <input id="plan_size" type="text" size="36" name="plan_size[]" value="'.$plan_size.'"> 
            </p> 
            
            <p class="meta-options floor_p"> 
                <label for="plan_rooms">'.__('Plan Rooms','wpestate').'</label><br> 
                <input id="plan_rooms" type="text" size="36" name="plan_rooms[]" value="'.$plan_rooms.'""> 
            </p> 
            <p class="meta-options floor_p"> 
                <label for="plan_bath">'.__('Plan Bathrooms','wpestate').'</label><br> 
                <input id="plan_bath" type="text" size="36"name="plan_bath[]" value="'.$plan_bath.'"> 
            </p> 
            <p class="meta-options floor_p"> 
                <label for="plan_price">'.__('Price in ','wpestate'). esc_html( get_option('wp_estate_currency_symbol', '') ) .'</label><br> 
                <input id="plan_price" type="text" size="36" name="plan_price[]" value="'.$plan_price.'"> 
            </p> 
    </div></div>';
            }
        }else{
<<<<<<< HEAD
            print '<h4 id="no_plan_mess">'.__('You don\'t have any plans attached!','wpestate').'</h4>';
        }
        
        $images='';
    ?>
=======

            print '<h4 id="no_plan_mess">'.__('You don\'t have any plans attached!','wpestate').'</h4>';

        }
        
        $images='';
    ?> 
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        <div id="upload-container">                 
            <div id="aaiu-upload-container">                 
                <div id="aaiu-upload-imagelist">
                    <ul id="aaiu-ul-list" class="aaiu-upload-list"></ul>
                </div>

                <div id="imagelist">
                <?php 
                    if($images!=''){
                        print $images;
                    }
                ?>  
                </div>

<<<<<<< HEAD
                <button id="aaiu-uploader"  class="wpb_button floor_upload_but wpb_btn-success wpb_btn-large vc_button"><?php _e('Upload New Plan Image','wpestate');?></button>
            </div>  
        </div>      
    </div>
    <input type="hidden" name="floor_for_post" value="<?php print $post_id;?>">
    <input type="submit" class="wpb_button  wpb_btn-info wpb_btn-large" id="floor_submit" value="<?php _e('SAVE PLANS','wpestate');?>">
  </form>
</div>   </div>  
=======
                <button id="aaiu-uploader"  class="wpresidence_button wpresidence_success"><?php _e('Upload New Plan Image','wpestate');?></button>
      
        </div>  
        </div>   
    

    <input type="hidden" name="floor_for_post" value="<?php print intval($post_id);?>">
    <input type="submit" class="wpresidence_button" id="floor_submit" value="<?php _e('Save Plans','wpestate');?>">
  </form>
 </div>
 </div>
</div>   
>>>>>>> 64662fd89bea560852792d7203888072d7452d48

<?php get_footer(); ?>