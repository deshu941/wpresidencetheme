<?php
global $post;
$agency_lat     =   esc_html(get_post_meta($post->ID, 'agency_lat', true));
$agency_long    =   esc_html(get_post_meta($post->ID, 'agency_long', true));

if(is_singular('estate_developer')){
    $agency_lat     =   esc_html(get_post_meta($post->ID, 'developer_lat', true));
    $agency_long    =   esc_html(get_post_meta($post->ID, 'developer_long', true));
}
?>
<div class="">
 
    <div id="agency_map" 
        data-cur_lat="<?php echo $agency_lat;?>" 
        data-cur_long="<?php echo $agency_long;?>">
    </div>

</div>
 
<script type="text/javascript">
//<![CDATA[
jQuery(document).ready(function(){
      wpestate_agency_map_function();
});
//]]>
</script>
    