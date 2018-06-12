<?php
global $options;
$tags = wp_get_post_tags($post->ID);
$col_class  =   4;
$no_rows    =   3;
if($options['content_class']=='col-md-12'){
    $col_class  =   3;
    $no_rows    =   4;
}


if ($tags) {
        $tag_array=array();
        foreach($tags as $tag){
            $tag_array[]=$tag->term_id;
        }
    
     
     
        $args = array(
            'tag__in'       => $tag_array,
            'post__not_in'  => array($post->ID),
            'showposts'     => $no_rows,
            'meta_query'    => array(
                                    array(
                                        'key' => '_thumbnail_id',
                                        'compare' => 'EXISTS'
                                    ),
                                )
        );
        

        wp_reset_query();
        $my_query = new WP_Query($args);
        
        
        if ( $my_query->have_posts() ) { ?>	

          <div class="related_posts"> 
                <h3><?php _e('Related Posts', 'wpestate'); ?></h3>   
              
                    <?php
                    while ($my_query->have_posts()) {
                       $my_query->the_post();
                       if(has_post_thumbnail() ){
                        get_template_part('templates/related_post_unit');   
                       }
                       
                    } //end while
                    ?>
                
          </div>		

        <?php } //endif have post
}// end if tags

 
wp_reset_query();
?> 