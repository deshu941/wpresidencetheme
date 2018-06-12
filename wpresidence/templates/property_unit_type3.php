<?php
global $curent_fav;
global $currency;
global $where_currency;
global $show_compare;
global $show_compare_only;
global $show_remove_fav;
global $options;
global $isdashabord;
global $align;
global $align_class;
global $is_shortcode;
global $row_number_col;
global $is_col_md_12;
global $prop_unit;
global $property_unit_slider;
global $custom_unit_structure;
global $no_listins_per_row;
global $wpestate_uset_unit;
global $property_address;

$pinterest          =   '';
$previe             =   '';
$compare            =   '';
$extra              =   '';
$property_size      =   '';
$property_bathrooms =   '';
$property_rooms     =   '';
$measure_sys        =   '';
$property_category  =   '';


if($no_listins_per_row==3){
    $col_class  =   'col-md-6';
    $col_org    =   6;
}else{   
    $col_class  =   'col-md-4';
    $col_org    =   4;
}


if($options['content_class']=='col-md-12' && $show_remove_fav!=1){
    if($no_listins_per_row==3){
        $col_class  =   'col-md-4';
        $col_org    =   4;
    }else{
        $col_class  =   'col-md-3';
        $col_org    =   3;
    }
    
}
// if template is vertical
if($align=='col-md-12'){
    $col_class  =  'col-md-12';
    $col_org    =  12;
}



if(isset($is_shortcode) && $is_shortcode==1 ){
    $col_class='col-md-'.$row_number_col.' shortcode-col';
}

if(isset($is_col_md_12) && $is_col_md_12==1){
    $col_class  =   'col-md-6';
    $col_org    =   6;
}

$title          =   get_the_title();
$link           =   get_permalink();
$preview        =   array();
$preview[0]     =   '';
$favorite_class =   'icon-fav-off';
$fav_mes        =   __('add to favorites','wpestate');
if($curent_fav){
    if ( in_array ($post->ID,$curent_fav) ){
    $favorite_class =   'icon-fav-on';   
    $fav_mes        =   __('remove from favorites','wpestate');
    } 
}
if(isset($prop_unit) && $prop_unit=='list'){
   $col_class= 'col-md-12';
}

if( $property_unit_slider==1){
    $col_class.=' has_prop_slider ';
}

if($no_listins_per_row==4){
    $col_class.=' has_4per_row ';
}
$is_custom_desing=11;
$property_city      =   get_the_term_list($post->ID, 'property_city', '', ', ', '') ;
$property_address   =   get_post_meta($post->ID,'property_address',true);
?>  



<div class="<?php echo esc_html($col_class);?> listing_wrapper property_unit_type3" data-org="<?php echo esc_html($col_org);?>" data-listid="<?php echo intval($post->ID);?>" > 
    <div class="property_listing property_unit_type3 <?php if($wpestate_uset_unit==1) print 'property_listing_custom_design' ?> " data-link="<?php   if(  $property_unit_slider==0){ echo esc_url($link);}?>">
        
        <?php 
        if ($wpestate_uset_unit==1){
            if ( isset($show_remove_fav) && $show_remove_fav==1 ) {
                print '<span class="icon-fav icon-fav-on-remove" data-postid="'.$post->ID.'"> '.$fav_mes.'</span>';
            }
  
            wpestate_build_unit_custom_structure($custom_unit_structure,$post->ID,$property_unit_slider);
            
        } else{
            if ( has_post_thumbnail() ){
                $arguments      = array(
                                        'numberposts' => -1,
                                        'post_type' => 'attachment',
                                        'post_mime_type' => 'image',
                                        'post_parent' => $post->ID,
                                        'post_status' => null,
                                        'exclude' => get_post_thumbnail_id(),
                                        'orderby' => 'menu_order',
                                        'order' => 'ASC'
                                    );
                $post_attachments   = get_posts($arguments);
                
                    
                $pinterest = wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_full_map');
                $preview   = wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_listings');
                $compare   = wp_get_attachment_image_src(get_post_thumbnail_id(), 'slider_thumb');
                $extra= array(
                    'data-original' =>  $preview[0],
                    'class'         =>  'lazyload img-responsive',    
                );


                $thumb_prop             =   get_the_post_thumbnail($post->ID, 'property_listings',$extra);

                if($thumb_prop ==''){
                    $thumb_prop_default =  get_template_directory_uri().'/img/defaults/default_property_listings.jpg';
                    $thumb_prop         =  '<img src="'.$thumb_prop_default.'" class="b-lazy img-responsive wp-post-image  lazy-hidden" alt="no thumb" />';   
                }


                $prop_stat              =   stripslashes ( esc_html( get_post_meta($post->ID, 'property_status', true) ) );
                $featured               =   intval  ( get_post_meta($post->ID, 'prop_featured', true) );
                $property_rooms         =   get_post_meta($post->ID, 'property_rooms', true);
                if($property_rooms!=''){
                    $property_rooms=floatval($property_rooms);
                }

                $property_bedrooms     =   get_post_meta($post->ID, 'property_bedrooms', true) ;
                if($property_bedrooms!=''){
                    $property_bedrooms=floatval($property_bedrooms);
                }

                $property_size                  =   wpestate_get_converted_measure( $post->ID, 'property_size' );
                $property_category              =   get_the_term_list($post->ID, 'property_category', '', ', ', '') ;
                $property_action_category       =   get_the_term_list($post->ID, 'property_action_category', '', ', ', '') ;
                $measure_sys                    =   esc_html ( get_option('wp_estate_measure_sys','') ); 

                print   '<div class="listing-unit-img-wrapper">';
            
                
                if(  $property_unit_slider==1){
                    //slider
                   

                    $slides='';

                    $no_slides = 0;
                    foreach ($post_attachments as $attachment) { 
                        $no_slides++;
                        $preview    =   wp_get_attachment_image_src($attachment->ID, 'property_listings');

                        $slides     .= '<div class="item lazy-load-item">
                                            <a href="'.$link.'"><img  data-lazy-load-src="'.$preview[0].'" alt="'.$title.'" class="img-responsive" /></a>
                                        </div>';

                    }// end foreach
                    $unique_prop_id=uniqid();
                    print '
                    <div id="property_unit_carousel_'.$unique_prop_id.'" class="carousel property_unit_carousel slide " data-ride="carousel" data-interval="false">
                        <div class="carousel-inner">         
                            <div class="item active">    
                                <a href="'.$link.'">'.$thumb_prop.'</a>     
                            </div>
                            '.$slides.'
                        </div>




                        <a href="'.$link.'"> </a>';

                        if( $no_slides>0){
                            print '<a class="left  carousel-control" href="#property_unit_carousel_'.$unique_prop_id.'" data-slide="prev">
                                <i class="demo-icon icon-left-open-big"></i>
                            </a>

                            <a class="right  carousel-control" href="#property_unit_carousel_'.$unique_prop_id.'" data-slide="next">
                                <i class="demo-icon icon-right-open-big"></i>
                            </a>';
                        }
                    print'
                    </div>';


                }else{
                    print   '<a href="'.$link.'">'.$thumb_prop.'</a>';
                  
                }

                if( !isset($show_compare) || $show_compare!=0  ){
                    $protocol = is_ssl() ? 'https' : 'http'; ?>
                    <div class="listing_actions">

                        <div class="share_unit">
                            <a href="<?php echo $protocol;?>://www.facebook.com/sharer.php?u=<?php echo esc_url($link); ?>&amp;t=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="social_facebook"></a>
                            <a href="<?php echo $protocol;?>://twitter.com/home?status=<?php echo urlencode(get_the_title().' '.$link); ?>" class="social_tweet" target="_blank"></a>
                            <a href="<?php echo $protocol;?>://pinterest.com/pin/create/button/?url=<?php echo esc_url($link); ?>&amp;media=<?php if (isset( $pinterest[0])){ echo esc_url($pinterest[0]); }?>&amp;description=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="social_pinterest"></a>
                            <a href="<?php echo $protocol;?>://plus.google.com/share?url=<?php echo esc_url($link); ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" target="_blank" class="social_google"></a>                   
                        </div>



                        <span class="share_list"  data-original-title="<?php _e('share','wpestate');?>" ></span>
                        <span class="icon-fav <?php echo esc_html($favorite_class);?>" data-original-title="<?php print $fav_mes; ?>" data-postid="<?php echo intval($post->ID); ?>"></span>
                        <span class="compare-action" data-original-title="<?php  _e('compare','wpestate');?>" data-pimage="<?php if( isset($compare[0])){echo esc_html($compare[0]);} ?>" data-pid="<?php echo intval($post->ID); ?>"></span>

                    </div>
                <?php
                }
                

               
                print '<div class="listing_unit_price_wrapper">';
                    wpestate_show_price($post->ID,$currency,$where_currency);
                print '</div>';
  
                
               

                print'<div class="tag-wrapper">';
                    if($featured==1){
                        print '<div class="featured_div">'.__('Featured','wpestate').'</div>';
                    }
                 
                
                    print'<div class="status-wrapper">';    
                        $property_action            =   get_the_terms($post->ID, 'property_action_category');  
                        if(isset($property_action[0])){
                            $property_action_term = $property_action[0]->name;
                            print '<div class="action_tag_wrapper '.$property_action_term.' ">'.$property_action_term.'</div>';
                        }

                        if ($prop_stat != 'normal') {
                            $ribbon_class = str_replace(' ', '-', $prop_stat);
                            if (function_exists('icl_translate') ){
                                $prop_stat     =   icl_translate('wpestate','wp_estate_property_status'.$prop_stat, $prop_stat );
                            }
                            print'<div class="ribbon-inside ' . $ribbon_class . '">' . $prop_stat . '</div>';
                        } 
     
                    print   '</div>';
                print   '</div>'; 
            }
        print   '</div>';
        
        
        if ( isset($show_remove_fav) && $show_remove_fav==1 ) {
            print '<span class="icon-fav icon-fav-on-remove" data-postid="'.$post->ID.'"> '.$fav_mes.'</span>';
        }
    ?>

        <div class="info_container_unit_3">

            <h4><a href="<?php echo esc_url($link); ?>">
                <?php
                    echo mb_substr( $title,0,44); 
                    if(mb_strlen($title)>44){
                        echo '...';   
                    } 
                 
                ?>
                </a> 
            </h4> 
        
            <div class="property_address_type3">
                <?php
                    if($property_address!=''){
                        print '<span>'.$property_address.'</span>';
                    }
                    if($property_city!=''){
                        print '<span>, '.$property_city.'</span>';
                    }

                ?>
            </div>
                
            <div class="property_categ_unit_type3">
                <?php 
                    if($property_category!=''){
                        print '<span><strong>'.__('Category:','wpestate').'</strong> '.$property_category.', '.$property_action_category.'</span>';
                    }
                ?>
            </div>
        
        
            <div class="property_listing_details">
                <?php 
                    if($property_rooms!=''){
                        print ' <div class="inforoom_unit_type3">'.$property_rooms.' '.__('rooms','wpestate').'</div>';
                    }

                    if($property_bedrooms!=''){
                        print '<div class="infobath_unit_type3">'.$property_bedrooms.' '.__('beds','wpestate').'</div>';
                    }
                    
                    if($property_size!=''){
                        print ' <div class="infosize_unit_type3">'.$property_size.'</div>';
                    }
                    
                  ?>
            </div>
        
           
        </div>
        
            <div class="property_location_unit_type3">
                    
                    <?php 
                    $agent_id       =   intval  ( get_post_meta($post->ID, 'property_agent', true) );
                    $thumb_id       =   get_post_thumbnail_id($agent_id);
                    $agent_face     =   wp_get_attachment_image_src($thumb_id, 'agent_picture_thumb');

                    if ($agent_face[0]==''){
                       $agent_face[0]= get_template_directory_uri().'/img/default-user_1.png';
                    }
                    ?>
                    <div class="property_agent_wrapper">
                   
                    <?php if($agent_id!=0){
                        echo ' <a href="'.get_permalink($agent_id).'">'.get_the_title($agent_id).'</a>';
                    }else{
                        echo get_the_author_meta( 'nicename',$post->post_author);
                    }
                    ?>
                    </div>
                
                    <div class="unit_type3_details">
                        <a href="<?php echo  ($link); ?>"><?php echo __( 'details', 'wpestate' )?></a>
                    </div>
                
                        <?php
                        

                print '</div>';        

               
              
            }// end if custom structure
            ?>
        </div>             
    </div>

<?php
unset($pinterest);
unset($previe);
unset($compare);
unset($extra);
unset($property_size);
unset($property_bathrooms);
unset($property_rooms);
unset($measure_sys);
unset($col_class);
unset($col_org);
unset($link);
unset($preview);
unset($favorite_class);
unset($fav_mes);
unset($curent_fav);
unset($thumb_prop);
unset($prop_stat);
unset($featured);
unset($property_rooms);
unset($property_bathrooms);
unset($property_size);
unset($prop_stat);
unset($ribbon_class);
unset($property_city);
unset($property_area);
unset($show_remove_fav);
unset($title);
unset($align_class);
?>