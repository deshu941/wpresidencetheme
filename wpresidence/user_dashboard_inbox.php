<?php
// Template Name: User Dashboard Inbox
// Wp Estate Pack

if ( !is_user_logged_in() ) {   
     wp_redirect(  home_url() );exit;
} 

$current_user       = wp_get_current_user();
$dash_profile_link  = wpestate_get_template_link('user_dashboard_profile.php');


get_header();
$options    =   wpestate_page_details($post->ID);
$user_role  =   get_user_meta( $current_user->ID, 'user_estate_role', true) ;
$userID     =   $current_user->ID;


?>

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
          <?php  get_template_part('templates/user_menu');  ?>
    </div>  
    

    <div class="col-md-9 dashboard-margin">
        <?php get_template_part('templates/breadcrumbs'); ?>
        <?php  get_template_part('templates/user_memebership_profile');  ?>
        <?php get_template_part('templates/ajax_container'); ?>
        <?php while (have_posts()) : the_post(); ?>
            <?php if (esc_html( get_post_meta($post->ID, 'page_show_title', true) ) != 'no' ) { ?>
                <h3 class="entry-title"><?php the_title(); ?></h3>
            <?php }?>
         
            <div class="single-content"><?php the_content();?></div><!-- single content-->

        <?php endwhile; // end of the loop. ?>
            
            
        <div class="unread_mess_wrap">
            <?php
         
            $no_unread=  intval(get_user_meta($userID,'unread_mess',true));
            echo __('You have','wpestate').' '.$no_unread.' '.__('unread messages','wpestate');
            ?>
        </div>    
            
        <?php  
       
        $args = array(
                'post_type'         => 'wpestate_message',
                'post_status'       => 'publish',
                'paged'             => $paged,
                'posts_per_page'    => 80,
                'order'             => 'DESC',
              
                'meta_query' => array(
                                    'relation' => 'AND',
                                    array(
                                        'relation' => 'OR',
                                        array(
                                                'key'       => 'message_to_user',
                                                'value'     => $userID,
                                                'compare'   => '='
                                        ),
                                        array(
                                                'key'       => 'message_from_user',
                                                'value'     => $userID,
                                                'compare'   => '='
                                        ),
                                    ),
                                    array(
                                        'key'       => 'first_content',
                                        'value'     => 1,
                                        'compare'   => '='
                                    ),  
                                    array(
                                        'key'       => 'delete_destination'.$userID,
                                        'value'     => 1,
                                        'compare'   => '!='
                                    ),
                            )
            );
        
      
          
        $message_selection = new WP_Query($args);
        print '<div class="all_mess_wrapper">';
        while ($message_selection->have_posts()): $message_selection->the_post(); 
            get_template_part('templates/message-listing-unit'); 
        endwhile;
        print '</div>';
        wp_reset_query();
        ?>    
         
    </div>
  
  
</div>   
<?php get_footer(); ?>