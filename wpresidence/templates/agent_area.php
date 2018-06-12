<?php
global $prop_id ;
global $agent_email;
global $agent_urlc;
global $link;
global $agent_url;
global $agent_urlc;
global $link;
global $agent_facebook;
global $agent_posit;
global $agent_twitter; 
global $agent_linkedin; 
global $agent_instagram;
global $agent_pinterest; 
global $agent_member;
$agent_id       =   intval( get_post_meta($post->ID, 'property_agent', true) );
$prop_id        =   $post->ID;  
$author_email   =   get_the_author_meta( 'user_email'  );
$agent_user_id  =   get_post_meta($agent_id,'user_agent_id',true);


if ($agent_id!=0){                        

        $thumb_id       = '';
        $preview_img    = '';
        $agent_skype    = '';
        $agent_phone    = '';
        $agent_mobile   = '';
        $agent_email    = '';
        $agent_pitch    = '';
        $link           = '';
        $name           = 'No agent';

        
          

        $thumb_id            = get_post_thumbnail_id($agent_id);
        $preview             = wp_get_attachment_image_src($thumb_id, 'property_listings');
        $preview_img         = $preview[0];
        
        $role_type= get_post_type($agent_id);
   
        if($role_type=='estate_agent'){
            $agent_skype         = esc_html( get_post_meta($agent_id, 'agent_skype', true) );
            $agent_phone         = esc_html( get_post_meta($agent_id, 'agent_phone', true) );
            $agent_mobile        = esc_html( get_post_meta($agent_id, 'agent_mobile', true) );
            $agent_email         = esc_html( get_post_meta($agent_id, 'agent_email', true) );
            if($agent_email==''){
                $agent_email=$author_email;
            }
            $agent_pitch         = esc_html( get_post_meta($agent_id, 'agent_pitch', true) );
            $agent_posit         = esc_html( get_post_meta($agent_id, 'agent_position', true) );
            $agent_facebook      = esc_html( get_post_meta($agent_id, 'agent_facebook', true) );
            $agent_twitter       = esc_html( get_post_meta($agent_id, 'agent_twitter', true) );
            $agent_linkedin      = esc_html( get_post_meta($agent_id, 'agent_linkedin', true) );
            $agent_pinterest     = esc_html( get_post_meta($agent_id, 'agent_pinterest', true) );
            $agent_instagram     = esc_html( get_post_meta($agent_id, 'agent_instagram', true) );
            $agent_urlc          = esc_html( get_post_meta($agent_id, 'agent_website', true) );
        }else if($role_type=='estate_agency'){
            $agent_skype         = esc_html( get_post_meta($agent_id, 'agency_skype', true) );
            $agent_phone         = esc_html( get_post_meta($agent_id, 'agency_phone', true) );
            $agent_mobile        = esc_html( get_post_meta($agent_id, 'agency_mobile', true) );
            $agent_email         = esc_html( get_post_meta($agent_id, 'agency_email', true) );
            if($agent_email==''){
                $agent_email=$author_email;
            }
            $agent_pitch         = esc_html( get_post_meta($agent_id, 'agency_pitch', true) );
            $agent_posit         = esc_html( get_post_meta($agent_id, 'agency_position', true) );
            $agent_facebook      = esc_html( get_post_meta($agent_id, 'agency_facebook', true) );
            $agent_twitter       = esc_html( get_post_meta($agent_id, 'agency_twitter', true) );
            $agent_linkedin      = esc_html( get_post_meta($agent_id, 'agency_linkedin', true) );
            $agent_pinterest     = esc_html( get_post_meta($agent_id, 'agency_pinterest', true) );
            $agent_instagram     = esc_html( get_post_meta($agent_id, 'agency_instagram', true) );
            $agent_urlc          = esc_html( get_post_meta($agent_id, 'agency_website', true) );
        }else if($role_type=='estate_developer'){
            $agent_skype         = esc_html( get_post_meta($agent_id, 'developer_skype', true) );
            $agent_phone         = esc_html( get_post_meta($agent_id, 'developer_phone', true) );
            $agent_mobile        = esc_html( get_post_meta($agent_id, 'developer_mobile', true) );
            $agent_email         = esc_html( get_post_meta($agent_id, 'developer_email', true) );
            if($agent_email==''){
                $agent_email=$author_email;
            }
            $agent_pitch         = esc_html( get_post_meta($agent_id, 'developer_pitch', true) );
            $agent_posit         = esc_html( get_post_meta($agent_id, 'developer_position', true) );
            $agent_facebook      = esc_html( get_post_meta($agent_id, 'developer_facebook', true) );
            $agent_twitter       = esc_html( get_post_meta($agent_id, 'developer_twitter', true) );
            $agent_linkedin      = esc_html( get_post_meta($agent_id, 'developer_linkedin', true) );
            $agent_pinterest     = esc_html( get_post_meta($agent_id, 'developer_pinterest', true) );
            $agent_instagram     = esc_html( get_post_meta($agent_id, 'developer_instagram', true) );
            $agent_urlc          = esc_html( get_post_meta($agent_id, 'developer_website', true) );
        }

        $link                = get_permalink($agent_id);
        $name                = get_the_title($agent_id);
      
        include( locate_template('templates/agentdetails.php'));
        get_template_part('templates/agent_contact');    
                   
            
              
      
}   // end if !=0
else{  

        if ( get_the_author_meta('user_level') !=10){
        
            $preview_img    =   get_the_author_meta( 'custom_picture'  );
            if($preview_img==''){
                $preview_img=get_template_directory_uri().'/img/default-user.png';
            }
       
            $agent_skype         = get_the_author_meta( 'skype'  );
            $agent_phone         = get_the_author_meta( 'phone'  );
            $agent_mobile        = get_the_author_meta( 'mobile'  );
            $agent_email         = get_the_author_meta( 'user_email'  );
            $agent_pitch         = '';
            $agent_posit         = get_the_author_meta( 'title'  );
            $agent_facebook      = get_the_author_meta( 'facebook'  );
            $agent_twitter       = get_the_author_meta( 'twitter'  );
            $agent_linkedin      = get_the_author_meta( 'linkedin'  );
            $agent_pinterest     = get_the_author_meta( 'pinterest'  );
            $agent_instagram     = get_the_author_meta( 'instagram'  );
            $agent_urlc          = get_the_author_meta( 'website'  );
            $link                = get_permalink();
            $name                = get_the_author_meta( 'first_name' ).' '.get_the_author_meta( 'last_name');;
            
       
     
         
        
            
        include( locate_template('templates/agentdetails.php'));
        get_template_part('templates/agent_contact');    
            
        
        }
}
?>