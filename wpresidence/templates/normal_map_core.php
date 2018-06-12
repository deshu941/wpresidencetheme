<?php
global $prop_selection;
global $options;
global $num;
global $args;
global $custom_advanced_search;
global $adv_search_what;
global $adv_search_how;
global $adv_search_label;
global $prop_unit_class;
?>

<div class="row">
    <?php get_template_part('templates/breadcrumbs'); ?>
    <div class=" <?php print $options['content_class'];?> ">
        <?php  
       
        if( is_page_template('advanced_search_results.php') ) {
            
            while (have_posts()) : the_post();
                if (esc_html( get_post_meta($post->ID, 'page_show_title', true) ) == 'yes') { ?>
                    <h1 class="entry-title title_prop"><?php the_title(); print " (".$num.")" ?></h1>                
                <?php } ?>
                <div class="single-content">
            
                <?php 
                the_content();
                $show_save_search            =   get_option('wp_estate_show_save_search','');
    
                if ($show_save_search=='yes' ){
                    if( is_user_logged_in() ){
                        print '<div class="search_unit_wrapper advanced_search_notice">';
                        print '<div class="search_param"><strong>'.__('Search Parameters: ','wpestate').'</strong>';
                            wpestate_show_search_params($args,$custom_advanced_search, $adv_search_what,$adv_search_how,$adv_search_label);
                        print'</div>';
                        print'</div>';


                        print '<div class="saved_search_wrapper"> <span id="save_search_notice">'.__('Save this Search?','wpestate').'</span>'; 
                        print '<input type="text" id="search_name" class="new_search_name" placeholder="'.__('Search name','wpestate').'">';
                        print '<button class="wpb_button  wpb_btn-info wpb_btn-large" id="save_search_button">'.__('Save Search','wpestate').'</button>';
                        print  "<input type='hidden' id='search_args' value=' ";
                        print json_encode($args,JSON_HEX_TAG);
                        print "'>";
                        print '<input type="hidden" name="save_search_nonce" id="save_search_nonce"  value="'. wp_create_nonce( 'save_search_nonce' ).'" />';
                        print '';
                        print '</div>';
                    }else{
                        print '<div class="vc_row wpb_row vc_row-fluid vc_row">
                                <div class="vc_col-sm-12 wpb_column vc_column_container vc_column">
                                    <div class="wpb_wrapper">
                                        <div class="wpb_alert wpb_content_element vc_alert_rounded wpb_alert-info wpestate_message vc_message">
                                            <div class="messagebox_text"><p>'.__('Login to save search and and you will receive an email notification when new properties matching your search will be published.','wpestate').'</p>
                                        </div>
                                        </div>
                                    </div> 
                                </div> 
                        </div>';

                    }

                }

            
            ?>
        
            </div>
                            
        <?php endwhile; // end of the loop.  
         
        get_template_part('templates/property_list_filters_search');
         
        }else if( is_tax()) { ?>
           
            <h1 class="entry-title title_prop"> 
                <?php 
                    _e('Properties listed in ','wpestate');
                    //print '"';
                    single_cat_title();
                    //print '" ';
                ?>
            </h1>
        
        
        <?php
        }else{
            while (have_posts()) : the_post(); ?>
                <?php 
                if (esc_html( get_post_meta($post->ID, 'page_show_title', true) ) == 'yes') { ?>
                    <h1 class="entry-title title_prop"><?php the_title(); ?></h1>
                <?php } 
                ?>
                <div class="single-content"><?php the_content();?></div>
            <?php 
            endwhile; // end of the loop.  
        }
        ?>  

              
        <!--Filters starts here-->     
        <?php  get_template_part('templates/property_list_filters'); ?> 
        <?php //  get_template_part('templates/property_ajax_tax_hidden_filters'); 
        ?> 
        <!--Filters Ends here-->   
       
        <?php  get_template_part('templates/compare_list'); ?> 
        
        <!-- Listings starts here -->                   
        <?php  get_template_part('templates/spiner'); ?> 
        <div id="listing_ajax_container" class="<?php echo $prop_unit_class;?>"> 
            <?php
           


            $counter = 0;
            if( is_page_template('advanced_search_results.php') ) {
                $first=0;
                if ($prop_selection->have_posts()){    
                    while ($prop_selection->have_posts()): $prop_selection->the_post();
                        if( isset($_GET['is2']) && $_GET['is2']==1 && $first==0 ){
                            $gmap_lat    =   esc_html(get_post_meta($post->ID, 'property_latitude', true));
                            $gmap_long   =   esc_html(get_post_meta($post->ID, 'property_longitude', true));
                            if($gmap_lat!='' && $gmap_long!=''){
                                print '<span style="display:none" id="basepoint" data-lat="'.$gmap_lat.'" data-long="'.$gmap_long.'"></span>';
                                $first=1;
                            }
                        }

                        get_template_part('templates/property_unit');
                    endwhile;
                }else{   
                    print '<div class="bottom_sixty">';
                    _e('We didn\'t find any results. Please try again with different search parameters. ','wpestate');
                    print '</div>';
                }  
            }else{
                if( $prop_selection->have_posts() ){
                    while ($prop_selection->have_posts()): $prop_selection->the_post(); 
                        get_template_part('templates/property_unit');
                    endwhile;
                }else{
                    print '<h4 class="nothing">'.__('There are no properties listed on this page at this moment. Please try again later. ','wpestate').'</h4>';
                }
            }
           
            
            wp_reset_query();               
        ?>
        </div>
        <!-- Listings Ends  here --> 
        
        
        
        <?php kriesi_pagination($prop_selection->max_num_pages, $range =2); ?>       
    
    </div><!-- end 9col container-->
    
<?php  include(locate_template('sidebar.php')); ?>
</div>   