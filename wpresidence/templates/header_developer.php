<?php
 
$thumb_id               =   get_post_thumbnail_id($post->ID);
$preview                =   wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_listings');
$preview_img            =   $preview[0];
$agency_skype           =   esc_html( get_post_meta($post->ID, 'developer_skype', true) );
$agency_phone           =   esc_html( get_post_meta($post->ID, 'developer_phone', true) );
$agency_mobile          =   esc_html( get_post_meta($post->ID, 'developer_mobile', true) );
$agency_email           =   is_email( get_post_meta($post->ID, 'developer_email', true) );
$agency_posit           =   esc_html( get_post_meta($post->ID, 'developer_position', true) );
$agency_facebook        =   esc_html( get_post_meta($post->ID, 'developer_facebook', true) );
$agency_twitter         =   esc_html( get_post_meta($post->ID, 'developer_twitter', true) );
$agency_linkedin        =   esc_html( get_post_meta($post->ID, 'developer_linkedin', true) );
$agency_pinterest       =   esc_html( get_post_meta($post->ID, 'developer_pinterest', true) );
$agency_instagram       =   esc_html( get_post_meta($post->ID, 'developer_instagram', true) );
$agency_opening_hours   =   esc_html( get_post_meta($post->ID, 'developer_opening_hours', true) );
$name                   =   get_the_title($post->ID);
$link                   =   get_permalink($post->ID);

$agency_addres          =    esc_html( get_post_meta($post->ID, 'developer_address', true) );
$agency_languages       =    esc_html( get_post_meta($post->ID, 'developer_languages', true) );
$agency_license         =    esc_html( get_post_meta($post->ID, 'developer_license', true) );
$agency_taxes           =    esc_html( get_post_meta($post->ID, 'developer_taxes', true) );
$agency_website         =    esc_html( get_post_meta($post->ID, 'developer_website', true) );
?>

<div class="header_agency_wrapper">
    <div class="header_agency_container">
        <div class="row">
            
           
            
            <div class="col-md-4">
                <a href="<?php print esc_url($link);?>">
                    <img src="<?php print $preview_img;?>"  alt="agent picture" class="img-responsive"/>
                </a>
            </div>
            
            
            <div class="col-md-8">
                <h1 class="agency_title"><?php echo $name?></h1>
                
                
                
                <div class="col-md-6 agency_details">
                    <?php
                         
                        if($agency_facebook!=''){
                            print ' <a class="agency_social" href="'. $agency_facebook.'" target="_blank"><i class="fa fa-facebook"></i></a>';
                        }

                        if($agency_twitter!=''){
                            print ' <a class="agency_social" href="'.$agency_twitter.'" target="_blank"><i class="fa fa-twitter"></i></a>';
                        }
                        if($agency_linkedin!=''){
                            print ' <a class="agency_social" href="'.$agency_linkedin.'" target="_blank"><i class="fa fa-linkedin"></i></a>';
                        }
                        if($agency_pinterest!=''){
                            print ' <a class="agency_social" href="'. $agency_pinterest.'" target="_blank"><i class="fa fa-pinterest"></i></a>';
                        }
                        if($agency_instagram!=''){
                            print ' <a class="agency_social" href="'. $agency_instagram.'" target="_blank"><i class="fa fa-instagram"></i></a>';
                        }

                    ?>
                    
                    <?php 
                    if($agency_addres!=''){
                        echo '<div class="agency_detail agency_address"><strong>'.__('Adress:','wpestate').'</strong> '.$agency_addres.'</div>';
                    }
                    ?>
                    
                    <?php 
                    if($agency_email!=''){
                        echo '<div class="agency_detail agency_email"><strong>'.__('Email:','wpestate').'</strong> <a href="mailto:'.$agency_email.'">'.$agency_email.'</a></div>';
                    }
                    ?>
                 

                    <?php 
                    if($agency_mobile!=''){
                        echo '<div class="agency_detail agency_mobile"><strong>'.__('Mobile:','wpestate').'</strong> <a href="tel:'.$agency_mobile.'">'.$agency_mobile.'</a></div>';
                    }
                    ?>
                    <?php 
                    if($agency_phone!=''){
                        echo '<div class="agency_detail agency_phone"><strong>'.__('Phone:','wpestate').'</strong> <a href="tel:'.$agency_phone.'">'.$agency_phone.'</a></div>';
                    }
                    ?>
                    
                    <a href="#agency_contact" class=" developer_contact_button wpresidence_button"  ><?php _e('Contact Us','wpestate');?></a>
                      
                </div>   
                
                <div class="col-md-6 agency_details">
                    <div class="developer_taxonomy">
                        <?php
                        $agent_county            =   get_the_term_list($post->ID, 'property_county_state_developer', '', '', '') ;
                        $agent_city              =   get_the_term_list($post->ID, 'property_city_developer', '', '', '') ;
                        $agent_area              =   get_the_term_list($post->ID, 'property_area_developer', '', '', '');
                        $agent_category          =   get_the_term_list($post->ID, 'property_category_developer', '', '', '') ;
                        $agent_action            =   get_the_term_list($post->ID, 'property_action_developer', '', '', '');  

                        print $agent_category;
                        print $agent_action;
                        print $agent_city;
                        print $agent_area;
                        print $agent_county;

                        ?>
                    </div>
                    
                </div>
                
                
              
            </div>
            
            
            <div class="col-md-12 developer_content">
                <div class="col-md-9 ">
                    <?php
                    $content_post = get_post($post->ID);
                    $content = $content_post->post_content;
                    $content = apply_filters('the_content', $content);
                    $content = str_replace(']]>', ']]&gt;', $content);
                    echo $content;
                    ?>
                  
                </div>
                
                <div class="col-md-3">
                    <?php 
                    
                    if($agency_website!=''){
                        echo '<div class="agency_detail agency_taxes"><strong>'.__('Website:','wpestate').'</strong> <a href="http://'.$agency_website.'" target="_blank">'.$agency_website.'</a></div>';
                    }
                    ?>
                    
                   
                    <?php 
                    if($agency_skype!=''){
                        echo '<div class="agency_detail agency_skype"><strong>'.__('Skype:','wpestate').'</strong> '.$agency_skype.'</div>';
                    }
                    ?>
                   

                     <?php 
                    if($agency_license!=''){
                        echo '<div class="agency_detail agency_license"><strong>'.__('License:','wpestate').'</strong> '.$agency_license.'</div>';
                    }
                    ?>

                    <?php 
                    if($agency_taxes!=''){
                        echo '<div class="agency_detail agency_taxes"><strong>'.__('Our Taxes:','wpestate').'</strong> '.$agency_taxes.'</div>';
                    }
                    ?>
                </div>
            </div>
            
        </div>
    
    </div>
    
</div>