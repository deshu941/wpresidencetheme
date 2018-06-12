<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no">

<title><?php
    // Print the <title> tag based on what is being viewed
    global $page, $paged;
    wp_title( '|', true, 'right' );

    // Add the blog name.
    bloginfo( 'name' );

    // Add the blog description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) )
        echo " | $site_description";

    // Add a page number if necessary:
    if ( $paged >= 2 || $page >= 2 )
        echo ' | ' . sprintf( __( 'Page %s', 'wpestate' ), max( $paged, $page ) );
    ?>
</title>



<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
 
<?php 
$favicon        =   esc_html( get_option('wp_estate_favicon_image','') );

if ( $favicon!='' ){
    echo '<link rel="shortcut icon" href="'.$favicon.'" type="image/x-icon" />';
} else {
    echo '<link rel="shortcut icon" href="'.get_template_directory_uri().'/img/favicon.gif" type="image/x-icon" />';
}

wp_head();
$wide_class      =   '';
$wide_status     =   esc_html(get_option('wp_estate_wide_status',''));
if($wide_status==1){
    $wide_class=" wide ";
}

if( wpestate_half_map_conditions ($post->ID) ){
    $wide_class="wide fixed_header ";
}


if (get_post_type()== 'estate_property'){
    $image_id       =   get_post_thumbnail_id();
    $share_img= wp_get_attachment_image_src( $image_id, 'full'); 
    ?>
    <meta property="og:image" content="<?php echo $share_img[0]; ?>"/>
    <meta property="og:image:secure_url" content="<?php echo $share_img[0]; ?>" />
<?php 
} 
?>
</head>


<body <?php body_class(); ?>>  
    

<?php      
    //print number_format(memory_get_usage()).'</br>';
    get_template_part('templates/mobile_menu' );    
    //print number_format(memory_get_usage()).'</br>';
?> 
    
<div class="website-wrapper" id="all_wrapper" >
<div class="container main_wrapper <?php print $wide_class;?> ">
    <?php    

    get_template_part('templates/mobile_menu_header' ); 
 
    ?>
    <?php
        $header_transparent_class   =   '';
        $header_transparent         =   get_option('wp_estate_header_transparent','');
        $header_transparent_page    =   get_post_meta ( $post->ID, 'header_transparent', true);
    
        //  $header_transparent_class=' header_transparent '; 
        
        if(isset($post->ID) && !is_tax() && !is_category() ){
                if($header_transparent_page=="global"){
                    if ($header_transparent=='yes'){
                        $header_transparent_class=' header_transparent ';
                    }
                }else if($header_transparent_page=="yes"){
                    $header_transparent_class=' header_transparent ';
                }
        }else{
            if ($header_transparent=='yes'){
                    $header_transparent_class=' header_transparent ';
            }
        }
        
    $logo=get_option('wp_estate_logo_image','');   

    ?>
    
    <div class="master_header <?php print $wide_class.' '.$header_transparent_class; ?>">
        
        <?php   
        if(esc_html ( get_option('wp_estate_show_top_bar_user_menu','') )=="yes"){
            get_template_part( 'templates/top_bar' ); 
        } 
        ?>
       
        <?php
        // header type -type1 is the default
        $logo_header_type    =   get_option('wp_estate_logo_header_type','');
        ?>
        
        
        <div class="header_wrapper <?php echo 'header_'.$logo_header_type;?> ">
            <div class="header_wrapper_inside">
                <?php $logo_margin                    =   intval( get_option('wp_estate_logo_margin','') ); ?>
                <div class="logo" >
                    <a href="<?php echo home_url('','login');?>">
                        <?php  
                       
                        if ( $logo!='' ){
                           print '<img style="margin-top:'.$logo_margin.'px;" src="'.$logo.'" class="img-responsive retina_ready" alt="logo"/>';	
                        } else {
                           print '<img class="img-responsive retina_ready" src="'. get_template_directory_uri().'/img/logo.png" alt="logo"/>';
                        }
                        ?>
                    </a>
                </div>   

              
                <?php 
                if(esc_html ( get_option('wp_estate_show_top_bar_user_login','') )=="yes"){
                   get_template_part('templates/top_user_menu');  
                }
                ?>    
                <nav id="access" role="navigation">
                    <?php 
                    wp_nav_menu( array( 'theme_location' => 'primary' ) );
                    ?>
                </nav><!-- #access -->
                </div>
        </div>

     </div> 
    
    <?php get_template_part( 'header_media' ); ?>   
    
  <div class="container content_wrapper">