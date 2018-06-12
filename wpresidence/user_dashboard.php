<?php
// Template Name: User Dashboard
// Wp Estate Pack
if ( !is_user_logged_in() ) {   
<<<<<<< HEAD
     wp_redirect(  home_url() );
=======
     wp_redirect(  home_url() );exit;
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
} 



<<<<<<< HEAD
global $current_user;
get_currentuserinfo();
=======
$current_user = wp_get_current_user();
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
$userID                         =   $current_user->ID;
$user_login                     =   $current_user->user_login;
$user_pack                      =   get_the_author_meta( 'package_id' , $userID );
$user_registered                =   get_the_author_meta( 'user_registered' , $userID );
$user_package_activation        =   get_the_author_meta( 'package_activation' , $userID );   
$paid_submission_status         =   esc_html ( get_option('wp_estate_paid_submission','') );
$price_submission               =   floatval( get_option('wp_estate_price_submission','') );
$submission_curency_status      =   esc_html( get_option('wp_estate_submission_curency','') );
<<<<<<< HEAD
$edit_link                      =   get_dasboard_add_listing();
$floor_link                     =   get_dasboard_floor_plan();
$processor_link                 =   get_procesor_link();


if( isset( $_GET['delete_id'] ) ) {
    if( !is_numeric($_GET['delete_id'] ) ){
          exit('you don\'t have the right to delete this');
    }else{
        $delete_id=$_GET['delete_id'];
        $the_post= get_post( $delete_id); 

        if( $current_user->ID != $the_post->post_author ) {
            exit('you don\'t have the right to delete this');;
=======
$edit_link                      =   wpestate_get_template_link('user_dashboard_add.php');
$floor_link                     =   wpestate_get_template_link('user_dashboard_floor.php');
$processor_link                 =   wpestate_get_template_link('processor.php');
$agent_list                     =  (array)get_user_meta($userID,'current_agent_list',true);


$user_agent_id          =   intval( get_user_meta($userID,'user_agent_id',true));
$status                 =   get_post_status($user_agent_id);

if( $status==='pending' || $status==='disabled' ){
    wp_redirect( home_url() );exit;
}

if( isset( $_GET['delete_id'] ) ) {
    if( !is_numeric($_GET['delete_id'] ) ){
        exit('you don\'t have the right to delete this');
    }else{
        $delete_id  =   $_GET['delete_id'];
        $the_post   =   get_post( $delete_id); 

   
      
        
        
        if( $current_user->ID != $the_post->post_author   &&  !in_array($the_post->post_author , $agent_list)  ) {
            exit('you don\'t have the right to delete this');
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        }else{
         
           
            // delete attchaments
            $arguments = array(
<<<<<<< HEAD
                'numberposts' => -1,
                'post_type' => 'attachment',
                'post_parent' => $delete_id,
                'post_status' => null,
                'exclude' => get_post_thumbnail_id(),
                'orderby' => 'menu_order',
                'order' => 'ASC'
=======
                'numberposts'   =>  -1,
                'post_type'     =>  'attachment',
                'post_parent'   =>  $delete_id,
                'post_status'   =>  null,
                'exclude'       =>  get_post_thumbnail_id(),
                'orderby'       =>  'menu_order',
                'order'         =>  'ASC'
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
            );
            $post_attachments = get_posts($arguments);
            
            foreach ($post_attachments as $attachment) {
               wp_delete_post($attachment->ID);                      
<<<<<<< HEAD
             }
           
            wp_delete_post( $delete_id ); 
         
=======
            }
           
            wp_delete_post( $delete_id ); 
            wp_redirect( wpestate_get_template_link('user_dashboard.php') );  exit;
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        }  
        
    }
    
    
}  
  


get_header();
$options=wpestate_page_details($post->ID);
?> 
  
<<<<<<< HEAD


<div class="row">
    <?php get_template_part('templates/breadcrumbs'); ?>
    
    <div class="col-md-3">
=======
<!--  -->
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

<div class="row row_user_dashboard">

    
    <div class="col-md-3 user_menu_wrapper">
        <div class="dashboard_menu_user_image">
        <div class="menu_user_picture" style="background-image: url('<?php print $user_small_picture[0];  ?>');height: 80px;width: 80px;" ></div>
        <div class="dashboard_username">
            <?php _e('Welcome back, ','wpestate'); echo $user_login.'!';?>
        </div> 
        </div>
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
       <?php  get_template_part('templates/user_menu');  ?>
    </div>  
    
    <div class="col-md-9 dashboard-margin">
<<<<<<< HEAD
        
        <?php get_template_part('templates/ajax_container'); ?>
        
        <?php if (esc_html( get_post_meta($post->ID, 'page_show_title', true) ) != 'no') { ?>
            <h1 class="entry-title"><?php the_title(); ?></h1>
        <?php } ?>
=======
        <?php get_template_part('templates/breadcrumbs'); ?>   
        <?php get_template_part('templates/user_memebership_profile');  ?>
        <?php get_template_part('templates/ajax_container'); ?>
        
        <?php if (esc_html( get_post_meta($post->ID, 'page_show_title', true) ) != 'no') { ?>
            <h3 class="entry-title"><?php the_title(); ?></h3>
        <?php } ?>
            
        <?php
    
        $agent_list[]   =   $current_user->ID;
        
        
        ?>
            
            
            
            
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        <?php
        $prop_no      =   intval( get_option('wp_estate_prop_no', '') );
        $paged        = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $args = array(
                'post_type'        =>  'estate_property',
<<<<<<< HEAD
                'author'           =>  $current_user->ID,
=======
                'author__in'           =>  $agent_list,
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
                'paged'             => $paged,
                'posts_per_page'    => $prop_no,
                'post_status'      =>  array( 'any' )
                );


        $prop_selection = new WP_Query($args);
        if( !$prop_selection->have_posts() ){
<<<<<<< HEAD
            print '<h4>'.__('You don\'t have any properties yet!','wpestate').'</h4>';
=======
            print'<div class="col-md-12 row_dasboard-prop-listing">';
            print '<h4>'.__('You don\'t have any properties yet!','wpestate').'</h4>';
            print'</div>';
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        }else{
            print '
            <form action="'.get_dasboard_searches_link().'" id="search_dashboard_auto" method="POST">
                <input type="text" id="prop_name" name="prop_name" value="" placeholder="'.__('Search a listing','wpestate').'">  
<<<<<<< HEAD
                <input type="submit" class="wpb_button  wpb_btn-info wpb_btn-large" id="search_form_submit_1" value="'.__('Search','wpestate').'">
=======
                <input type="submit" class="wpresidence_button" id="search_form_submit_1" value="'.__('Search','wpestate').'">
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
            </form> '; 
            
                
         }
<<<<<<< HEAD
         $autofill='';
           
        while ($prop_selection->have_posts()): $prop_selection->the_post();          
               get_template_part('templates/dashboard_listing_unit'); 
                $autofill.= '"'.get_the_title().'",';
        endwhile;      
=======
        $autofill='';
           
        while ($prop_selection->have_posts()): $prop_selection->the_post();          
            get_template_part('templates/dashboard_listing_unit'); 
        endwhile;     
        
        
        $args2= array(
                'post_type'                 =>  'estate_property',
                'author__in'                    =>  $agent_list,
                'posts_per_page'            => '-1' ,
                'post_status'               =>  array( 'any' ),
                'cache_results'             =>  false,
                'update_post_meta_cache'    =>  false,
                'update_post_term_cache'    =>  false,
        
                );
        $prop_selection2 = new WP_Query($args2);
        while ($prop_selection2->have_posts()): $prop_selection2->the_post();          
                $autofill.= '"'.get_the_title().'",';
        endwhile;     
        
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        print '<script type="text/javascript">
           //<![CDATA[
                 jQuery(document).ready(function(){
                     var autofill=['.$autofill.']
                     jQuery( "#prop_name" ).autocomplete({
                     source: autofill
                 });
           });
           //]]>
           </script>';
        kriesi_pagination($prop_selection->max_num_pages, $range =2);
        ?>    
    </div>
    
   
  
</div>  



<?php get_footer(); ?>