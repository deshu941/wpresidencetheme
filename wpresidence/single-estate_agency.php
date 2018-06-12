<?php
// Single Agency
// Wp Estate Pack
get_header();
$options                    =   wpestate_page_details($post->ID);
$show_compare               =   1;
$currency                   =   esc_html( get_option('wp_estate_currency_symbol', '') );
$where_currency             =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
$options['content_class']='col-md-12';
?>

<div class="row">
    <?php get_template_part('templates/breadcrumbs'); ?>
    <div class=" <?php print esc_html($options['content_class']);?> ">
  
        <div id="content_container"> 
        <?php 
        while (have_posts()) : the_post(); 
            $agency_id              = get_the_ID();
            $thumb_id               = get_post_thumbnail_id($post->ID);
            $preview                = wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_listings');
            $preview_img            = $preview[0];
            $agency_skype           = esc_html( get_post_meta($post->ID, 'agency_skype', true) );
            $agency_phone           = esc_html( get_post_meta($post->ID, 'agency_phone', true) );
            $agency_mobile          = esc_html( get_post_meta($post->ID, 'agency_mobile', true) );
            $agency_email           = is_email( get_post_meta($post->ID, 'agency_email', true) );
            $agency_posit           = esc_html( get_post_meta($post->ID, 'agency_position', true) );
            $agency_facebook        = esc_html( get_post_meta($post->ID, 'agency_facebook', true) );
            $agency_twitter         = esc_html( get_post_meta($post->ID, 'agency_twitter', true) );
            $agency_linkedin        = esc_html( get_post_meta($post->ID, 'agency_linkedin', true) );
            $agency_pinterest       = esc_html( get_post_meta($post->ID, 'agency_pinterest', true) );
            $agency_instagram       = esc_html( get_post_meta($post->ID, 'agency_instagram', true) );
            $agency_urlc            = esc_html( get_post_meta($post->ID, 'agency_website', true) );
            $agency_opening_hours   = esc_html( get_post_meta($post->ID, 'agency_opening_hours', true) );
            $name                   = get_the_title();
        ?>
        <?php endwhile; // end of the loop.    ?>
         
        <div class="single-content single-agent">    
           
            <div class="col-md-8 agency_content">
                <h3 class=""><?php _e('About Us','wpestate');?></h3>
                
                <div class="agency_socialpage_wrapper">
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
                </div> 
                    
                <?php 
                
                the_content();
                
                ?>
            </div>
            
            <div class="col-md-4 agency_tax">
                
                <div class="agency_taxonomy">
                    
                    
                    <?php
                    $agent_county            =   get_the_term_list($post->ID, 'county_state_agency', '', '', '') ;
                    $agent_city              =   get_the_term_list($post->ID, 'city_agency', '', '', '') ;
                    $agent_area              =   get_the_term_list($post->ID, 'area_agency', '', '', '');
                    $agent_category          =   get_the_term_list($post->ID, 'category_agency', '', '', '') ;
                    $agent_action            =   get_the_term_list($post->ID, 'action_category_agency', '', '', '');  

                    print $agent_category;
                    print $agent_action;
                    print $agent_city;
                    print $agent_area;
                    print $agent_county;

                    ?>
                </div>
            </div>
            
            
            <?php get_template_part('templates/agency_listings');  ?>
            <?php get_template_part('templates/agency_agents');  ?>               
   
            
     
                
                
			<?php 
        
			$wp_estate_show_reviews     =    get_option('wp_estate_show_reviews_block','');         
			if(is_array($wp_estate_show_reviews) && in_array('agency', $wp_estate_show_reviews)){
				get_template_part('templates/agency_reviews');  
			}
			?>
           
                
          </div> 
        </div>  
       
		
        
        
        </div>
    </div><!-- end 9col container-->    
         
  
<?php  //include(locate_template('sidebar.php')); ?>
</div>  

 

<div class="col-md-12 agency_contact_class" >  
    <div class="agency_contact_container" >
        <div class="col-md-8"  id="agency_contact">
            <?php get_template_part('templates/agent_contact');   ?>
        </div>
        <div class="col-md-4 agency_contact_padding">
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

                <?php 
                if($agency_skype!=''){
                    echo '<div class="agency_detail agency_skype"><strong>'.__('Skype:','wpestate').'</strong> '.$agency_skype.'</div>';
                }
                ?>
        </div>
    </div>
</div>

<?php get_template_part('templates/agency_map');  ?>




<?php
get_footer(); 
?>