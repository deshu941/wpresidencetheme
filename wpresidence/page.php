<?php
// Sigle - Blog post
// Wp Estate Pack
global $post;
get_header(); 
$options=wpestate_page_details($post->ID); 
<<<<<<< HEAD
=======

>>>>>>> 64662fd89bea560852792d7203888072d7452d48
?>



<div class="row">
    <?php get_template_part('templates/breadcrumbs'); ?>
<<<<<<< HEAD
    <div class="col-xs-12 <?php print $options['content_class'];?> ">
=======
    <div class="col-xs-12 <?php print esc_html($options['content_class']);?> ">
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        
         <?php get_template_part('templates/ajax_container'); ?>
        
        <?php while (have_posts()) : the_post(); ?>
            <?php if (esc_html( get_post_meta($post->ID, 'page_show_title', true) ) != 'no') { ?>
                <h1 class="entry-title"><?php the_title(); ?></h1>
            <?php } ?>
         
            <div class="single-content"><?php the_content();?></div><!-- single content-->

                   
        
        <!-- #comments start-->
<<<<<<< HEAD
        <?php comments_template('', true);?> 	
=======
        <?php 
        if(!is_front_page()){
            comments_template('', true);
        }?> 	
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        <!-- end comments -->   
        
        <?php endwhile; // end of the loop. ?>
    </div>
  
    
<?php  include(locate_template('sidebar.php')); ?>
</div>   
<?php get_footer(); ?>