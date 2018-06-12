<?php 
global $agent_email;
global $propid;
global $agent_wid;

$agent_id       = intval( get_post_meta($post->ID, 'property_agent', true) );
$link           = get_permalink($agent_id);
$name           = get_the_title($agent_id);
$agent_email    = esc_html( get_post_meta($agent_id, 'agent_email', true) );
                  
$thumb_id       = get_post_thumbnail_id($agent_id);
$preview        = wp_get_attachment_image_src($thumb_id, 'property_listings');
$preview_img    = $preview[0];

if($thumb_id==''){
      $preview_img    =   get_template_directory_uri().'/img/default_user_agent.gif';
}else{
    $preview_img         = $preview[0];
}

?>


<div class="agent_contanct_form_sidebar">
    
<?php
    wp_reset_query();
    $agent_wid=$agent_id;
    if ( get_the_author_meta('user_level',$agent_wid) !=10){
        get_template_part('templates/agent_unit_widget'); 
        get_template_part('templates/agent_contact'); 
    }
?>
</div>