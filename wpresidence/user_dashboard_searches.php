<?php
// Template Name: User Dashboard  Saved Searches
// Wp Estate Pack

if ( !is_user_logged_in() ) {   
    wp_redirect(  home_url() );exit;
} 



$current_user = wp_get_current_user();  
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
$custom_advanced_search         =   get_option('wp_estate_custom_advanced_search','');
$adv_search_what                =   get_option('wp_estate_adv_search_what','');
$adv_search_how                 =   get_option('wp_estate_adv_search_how','');
$adv_search_label               =   get_option('wp_estate_adv_search_label','');                    


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
        <?php   get_template_part('templates/breadcrumbs'); ?>
        <?php   get_template_part('templates/user_memebership_profile');  ?>
        <?php   get_template_part('templates/ajax_container'); ?>
        
        <?php if (esc_html( get_post_meta($post->ID, 'page_show_title', true) ) != 'no') { ?>
            <h3 class="entry-title"><?php the_title(); ?></h3>
        <?php } ?>
         
        <?php
 
            $args = array(
                'post_type'        => 'wpestate_search',
                'post_status'      =>  'any',
                'posts_per_page'   => -1 ,
                'author'      => $userID
              
            );
        
      
            $prop_selection = new WP_Query($args);
            $counter = 0;
      
          
            if($prop_selection->have_posts()){ 
                print '<div id="listing_ajax_container">';
                while ($prop_selection->have_posts()): $prop_selection->the_post(); 
                    get_template_part('templates/search_unit');
                endwhile;
                print '</div>';
            }else{
                print'<div class="col-md-12 row_dasboard-prop-listing">';
                print '<h4>'.__('You don\'t have any saved searches yet!','wpestate').'</h4>';
                print'</div>';
            }



      
        ?>    
       
                
                
    </div>
    
 
  
</div>   
<?php get_footer(); ?>