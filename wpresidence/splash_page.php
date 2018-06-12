<?php
// Template Name: Splash Page
// Wp Estate Pack 
global $post;
get_header(); 
$options=wpestate_page_details($post->ID); 

?>


  
</div><!-- end content_wrapper started in header -->

</div> <!-- end class container -->

<?php wp_footer(); ?>

</div> <!-- end website wrapper -->

<?php  get_template_part('templates/login_register_modal'); ?> 
</body>
</html>