<?php
global $options;

$thumb_id           =   get_post_thumbnail_id($post->ID);
$preview            =   wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_listings');
$agent_skype        =   esc_html( get_post_meta($post->ID, 'agent_skype', true) );
$agent_phone        =   esc_html( get_post_meta($post->ID, 'agent_phone', true) );
$agent_mobile       =   esc_html( get_post_meta($post->ID, 'agent_mobile', true) );
$agent_email        =   esc_html( get_post_meta($post->ID, 'agent_email', true) );
$agent_posit        =   esc_html( get_post_meta($post->ID, 'agent_position', true) );
$post_status        =   get_post_status($post->ID);
$name               =   get_the_title();
$link               =   get_permalink();
$edit_link          =   wpestate_get_template_link('user_dashboard_add_agent.php');
$edit_link          =   esc_url_raw(add_query_arg( 'listing_edit', $post->ID, $edit_link )) ;
$extra= array(
        'data-original'=>$preview[0],
        'class'	=> 'lazyload img-responsive',    
        );
$thumb_prop    = get_the_post_thumbnail($post->ID, 'property_listings',$extra);

if($thumb_prop==''){
    $thumb_prop = '<img src="'.get_template_directory_uri().'/img/default_user.png" alt="agent-images">';
}

$col_class=4;
if($options['content_class']=='col-md-12'){
    $col_class=3;
}


           
?>



<div class="col-md-4 listing_wrapper">
    <div class="agent_unit" data-link="<?php print esc_url($link);?>">
        <div class="agent-unit-img-wrapper">
            <div class="prop_new_details_back"></div>
            <?php 
                print $thumb_prop; 
            ?>
        </div>    
            
        <div class="">
            <?php
            print '<h4> <a href="' . $link . '">' . $name. '</a></h4>
            <div class="agent_position">'. $agent_posit .'</div>';
           
            if ($agent_phone) {
                print '<div class="agent_detail"><i class="fa fa-phone"></i>' . $agent_phone . '</div>';
            }
            if ($agent_mobile) {
                print '<div class="agent_detail"><i class="fa fa-mobile"></i>' . $agent_mobile . '</div>';
            }

            if ($agent_email) {
                print '<div class="agent_detail"><i class="fa fa-envelope-o"></i>' . $agent_email . '</div>';
            }

            if ($agent_skype) {
                print '<div class="agent_detail"><i class="fa fa-skype"></i>' . $agent_skype . '</div>';
            }
            
            print '<div class="agent_detail"><strong>'.__('user id:','wpestate').'</strong>  '.     get_post_meta($post->ID, 'user_meda_id',true ). '</div>';
            ?>
        </div> 
    
        
        <div class="agent_control_bar ">
          
                <a  data-original-title="<?php _e('Edit Agent','wpestate');?>"   class="dashboad-tooltip" href="<?php  print esc_url($edit_link);?>"><i class="fa fa-pencil-square-o editprop"></i></a>
                <a  data-original-title="<?php _e('Delete Agent','wpestate');?>" class="dashboad-tooltip" onclick="return confirm(' <?php echo __('Are you sure you wish to delete ','wpestate').get_the_title(); ?>?')" href="<?php print esc_url_raw(add_query_arg( 'delete_id', $post->ID,  $_SERVER['REQUEST_URI']  ) );?>"><i class="fa fa-times deleteprop"></i></a>  
                <?php
                    if( $post_status == 'publish' ){ 
                        print ' <span  data-original-title="'.__('Disable Agent','wpestate').'" class="dashboad-tooltip disable_listing disabledx" data-postid="'.$post->ID.'" ><i class="fa fa-pause"></i></span>';
                    }else if($post_status=='disabled') {
                        print ' <span  data-original-title="'.__('Enable Agent','wpestate').'" class="dashboad-tooltip disable_listing" data-postid="'.$post->ID.'" ><i class="fa fa-play"></i></span>';
                    }
                ?>               
         
        </div>
    </div>
</div>