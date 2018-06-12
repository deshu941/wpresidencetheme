<?php
$order_class            =   ' order_filter_single ';  
$selected_order         =   __('Sort by','wpestate');
$listing_filter         =   '';
if( isset($post->ID) ){
    $listing_filter         = get_post_meta($post->ID, 'listing_filter',true );
}
$listing_filter_array   = array(
                            "1"=>__('Price High to Low','wpestate'),
                            "2"=>__('Price Low to High','wpestate'),
                            "3"=>__('Newest first','wpestate'),
                            "4"=>__('Oldest first','wpestate'),
                            "5"=>__('Bedrooms High to Low','wpestate'),
                            "6"=>__('Bedrooms Low to high','wpestate'),
                            "7"=>__('Bathrooms High to Low','wpestate'),
                            "8"=>__('Bathrooms Low to high','wpestate'),
                            "0"=>__('Default','wpestate')
                        );




$listings_list='';
foreach($listing_filter_array as $key=>$value){
    $listings_list.= '<li role="presentation" data-value="'.$key.'">'.$value.'</li>';

    if($key==$listing_filter){
        $selected_order     =   $value;
        $selected_order_num =   $key;
    }
} 

?>

  
<div class="dropdown listing_filter_select order_filter <?php print $order_class;?>">
    <div data-toggle="dropdown" id="a_filter_order" class="filter_menu_trigger" data-value="<?php echo esc_html($selected_order_num);?>"> <?php echo esc_html($selected_order); ?> <span class="caret caret_filter"></span> </div>           
     <ul id="filter_order" class="dropdown-menu filter_menu" role="menu" aria-labelledby="a_filter_order">
         <?php print $listings_list; ?>                   
     </ul>        
</div> 