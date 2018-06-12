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

$pinterest          =   '';
$previe             =   '';
$compare            =   '';
$extra              =   '';
$property_size      =   '';
$property_bathrooms =   '';
$property_rooms     =   '';
$measure_sys        =   '';

$col_class  =   'col-md-4';
$col_org    =   4;
if($options['content_class']=='col-md-12' && $show_remove_fav!=1){
    $col_class  =   'col-md-3';
    $col_org    =   3;
}
// if template is vertical
if($align=='col-md-12'){
     $col_class  =  'col-md-12';
     $col_org    =  12;
}



if(isset($is_shortcode) && $is_shortcode==1 ){
    $col_class='col-md-'.$row_number_col.' shortcode-col';
     //$col_class=' shortcode-col';
}

if(isset($is_col_md_12) && $is_col_md_12==1){
   $col_class  =   'col-md-6';
    $col_org    =   6;
}


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

?>  



<div class="col-md-6 listing_wrapper" data-org="6" data-listid="<?php echo $post->ID;?>" > 
    <div class="property_listing" data-link="<?php echo $link;?>">
        <?php
        if ( has_post_thumbnail() ):
            $pinterest = wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_full_map');
            $preview   = wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_full');
            $compare   = wp_get_attachment_image_src(get_post_thumbnail_id(), 'slider_thumb');
            $extra= array(
                'data-original' =>  $preview[0],
                'class'         =>  'lazyload img-responsive',    
            );
       
         
            $thumb_prop             =   get_the_post_thumbnail($post->ID, 'property_full',$extra);
            $thumb_url              =   wp_get_attachment_image_src(  get_post_thumbnail_id( $post->ID), 'property_full' ); ;
            $prop_stat              =   esc_html( get_post_meta($post->ID, 'property_status', true) );
            $featured               =   floatval  ( get_post_meta($post->ID, 'prop_featured', true) );
            $property_rooms         =   get_post_meta($post->ID, 'property_bedrooms', true);
            if($property_rooms!=''){
                $property_rooms=floatval($property_rooms);
            }
            
            $property_bathrooms     =   get_post_meta($post->ID, 'property_bathrooms', true) ;
            if($property_bathrooms!=''){
                $property_bathrooms=floatval($property_bathrooms);
            }
            
            $property_size          =   get_post_meta($post->ID, 'property_size', true) ;
            if($property_size){
                $property_size=number_format(floatval($property_size));
            }
            
            
            
            
            $measure_sys            = esc_html ( get_option('wp_estate_measure_sys','') ); 
       
            print   '<div class="listing-unit-img-wrapper" style="background-image: url('.$thumb_url[0].');">';
          //  print   '<a href="'.$link.'">'.$thumb_prop.'</a>';
            print   '<div class="listing-cover"></div>
                    <a href="'.$link.'"> <span class="listing-cover-plus">+</span></a>';
          
            if($featured==1){
                print '<div class="featured_div"></div>';
            }
              print   '</div>';
            if ($prop_stat != 'normal') {
                $ribbon_class = str_replace(' ', '-', $prop_stat);
                if (function_exists('icl_translate') ){
                    $prop_stat     =   icl_translate('wpestate','wp_estate_property_status'.$prop_stat, $prop_stat );
                }
                print'<a href="' . $link . '"><div class="ribbon-wrapper-default ribbon-wrapper-' . $ribbon_class . '"><div class="ribbon-inside ' . $ribbon_class . '">' . $prop_stat . '</div></div></a>';
            }
           
        endif;

        
        $price = floatval( get_post_meta($post->ID, 'property_price', true) );
        if ($price != 0) {
           $price =  wpestate_show_price($post->ID,$currency,$where_currency,1);
        }else{
            $price='';
        }
        
       
        $property_city      =   get_the_term_list($post->ID, 'property_city', '', ', ', '') ;
        $property_area      =   get_the_term_list($post->ID, 'property_area', '', ', ', '');
      
        if ( isset($show_remove_fav) && $show_remove_fav==1 ) {
            print '<span class="icon-fav icon-fav-on-remove" data-postid="'.$post->ID.'"> '.$fav_mes.'</span>';
        }
        ?>

  
            <h4>
                <a href="<?php the_permalink(); ?>">
                <?php 
                    $title=get_the_title();
                    echo substr( $title,0,54); 
                    if(strlen($title)>54){
                        echo '...';   
                    } 
                ?>
                </a>
            </h4>
            <div class="property_location"><?php // print $property_area.', '.$property_city; ?>
                <?php 
                if($property_rooms!=''){
                    print ' <span class="inforoom">'.$property_rooms.'</span>';
                }
                
                if($property_bathrooms!=''){
                    print '<span class="infobath">'.$property_bathrooms.'</span>';
                }
                
                if($property_size!=''){
                    print ' <span class="infosize">'.$property_size.' '.$measure_sys.'<sup>2</sup></span>';
                }
                ?>
            </div>
                  
            <?php if ($align_class=='the_list_view') {?>
                <div class="listing_details the_list_view" style="display:block;">
                   <?php    echo wpestate_strip_words( get_the_excerpt(),20).' ...'; ?>
                </div>   
            <?php
            }else{
            ?>
                <div class="listing_details the_grid_view">
                    <?php    echo wpestate_strip_words( get_the_excerpt(),14).' ...'; ?>
                </div>

                <div class="listing_details the_list_view">
                    <?php    echo wpestate_strip_words( get_the_excerpt(),20).' ...'; ?>
                </div>
            <?php } ?>   
       
            <div class="listing_prop_details">
                
            </div>
            
            <?php
            print '<div class="listing_unit_price_wrapper">';
               
                    print $price; 
                
              
                    if( !isset($show_compare) || $show_compare!=0  ){ ?>
                           <div class="listing_actions">
                               
                                <div class="share_unit">
                                    <a href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>&amp;t=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="social_facebook"></a>
                                    <a href="http://twitter.com/home?status=<?php echo urlencode(get_the_title().' '.the_permalink()); ?>" class="social_tweet" target="_blank"></a>
                                    <a href="https://plus.google.com/share?url=<?php the_permalink(); ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" target="_blank" class="social_google"></a> 
                                    <a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&amp;media=<?php if (isset( $pinterest[0])){ echo $pinterest[0]; }?>&amp;description=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="social_pinterest"></a>
                                </div>
          
                               
                               
                                <span class="share_list"  data-original-title="<?php _e('share','wpestate');?>" ></span>
                                <span class="icon-fav <?php echo $favorite_class;?>" data-original-title="<?php print $fav_mes; ?>" data-postid="<?php echo $post->ID; ?>"></span>
                            
                          
                                <span class="compare-action" data-original-title="<?php  _e('compare','wpestate');?>" data-pimage="<?php if( isset($compare[0])){echo $compare[0];} ?>" data-pid="<?php echo $post->ID; ?>"></span>
                                     <?php if( $show_compare_only!='no') { ?>
                                 <?php } ?>
                           </div>
                    <?php
                    } 

                   
                 
                 
           print '</div>';
           ?>
           
        </div>          
    </div>