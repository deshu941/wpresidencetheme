<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
 
<?php 
if(is_singular('wpestate_invoice') || is_singular('wpestate_message')){
    echo '<meta name="robots" content="noindex">';
}
        
$favicon        =   esc_html( get_option('wp_estate_favicon_image','') );
if ( $favicon!='' ){
    echo '<link rel="shortcut icon" href="'.$favicon.'" type="image/x-icon" />';
} else {
    echo '<link rel="shortcut icon" href="'.get_template_directory_uri().'/img/favicon.gif" type="image/x-icon" />';
}


wp_head();


if( is_tax() ) {
    echo '<meta name="description" content="'.strip_tags( term_description('', get_query_var( 'taxonomy' ) )).'" >';
}

if (get_post_type()== 'estate_property'){
    $image_id       =   get_post_thumbnail_id();
    $share_img      =   wp_get_attachment_image_src( $image_id, 'full'); 
    $the_post       =   get_post($post->ID);
    ?>
    <meta property="og:image" content="<?php echo esc_url($share_img[0]); ?>"/>
    <meta property="og:image:secure_url" content="<?php echo esc_url($share_img[0]); ?>" />
    <meta property="og:description"        content=" <?php echo wp_strip_all_tags( $the_post->post_content);?>" />
<?php 
}   
    if(is_singular('wpestate_search') || is_singular('wpestate_invoice')){
        print '<meta name="robots" content="noindex">';
    }
        
?>
</head>



<?php 

$wide_class      =   ' is_boxed ';
$wide_status     =   esc_html(get_option('wp_estate_wide_status',''));
if($wide_status==1 ||   is_page_template( 'splash_page.php' ) ){
    $wide_class=" wide ";
}

if( isset($post->ID) && wpestate_half_map_conditions ($post->ID) ){
    $wide_class="wide fixed_header ";
}


$halfmap_body_class='';
if( isset($post->ID) && wpestate_half_map_conditions ($post->ID) ){
    $halfmap_body_class=" half_map_body ";
}

if(esc_html ( get_option('wp_estate_show_top_bar_user_menu','') )=="yes"){
    $halfmap_body_class.=" has_top_bar ";
}

$logo_header_type            =   get_option('wp_estate_logo_header_type','');
$logo_header_align           =   get_option('wp_estate_logo_header_align','');
$wide_header                 =   get_option('wp_estate_wide_header','');
$wide_header_class           =  '';
if($wide_header=='yes' ||   is_page_template( 'splash_page.php' ) ){
    $wide_header_class=" full_width_header ";
}

$top_menu_hover_type        =   get_option('wp_estate_top_menu_hover_type','');  
$header_transparent_class   =   '';
$header_transparent         =   get_option('wp_estate_header_transparent','');


if(isset($post->ID) && !is_tax() && !is_category() ){
        $header_transparent_page    =   get_post_meta ( $post->ID, 'header_transparent', true);
        if($header_transparent_page=="global" || $header_transparent_page==""){
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

$logo                       =   get_option('wp_estate_logo_image','');  
$stikcy_logo_image          =   esc_html( get_option('wp_estate_stikcy_logo_image','') );
$logo_margin                =   intval( get_option('wp_estate_logo_margin','') );
$transparent_logo           =   esc_html( get_option('wp_estate_transparent_logo_image','') );
$show_top_bar_user_login    =   esc_html ( get_option('wp_estate_show_top_bar_user_login','') );

if( ( trim($header_transparent_class) == 'header_transparent' || is_page_template( 'splash_page.php' ) ) && $transparent_logo!='' ){
    $logo  = $transparent_logo;
}

$text_header_align_select   =  get_option('wp_estate_text_header_align','');
$show_header_dashboard      =  get_option('wp_estate_show_header_dashboard','');

if( wpestate_is_user_dashboard() && $show_header_dashboard=='no'){
    $halfmap_body_class.=" dash_no_header ";
    $logo_header_type='';
}

if(wpestate_is_user_dashboard() && $show_header_dashboard=='yes'){
    $wide_class=" wide ";
    $logo_header_type = "type1  ";
    $wide_header_class=" full_width_header ";
    $header_transparent_class   =   '';
}

$show_top_bar_user_login_class='';
if($show_top_bar_user_login != 'yes'){
    $show_top_bar_user_login_class=" no_user_submit ";
}

?>




<body <?php body_class($halfmap_body_class); ?>>  
   

<?php   get_template_part('templates/mobile_menu' ); ?> 
    
<div class="website-wrapper" id="all_wrapper" >
<div class="container main_wrapper <?php print esc_html($wide_class); print esc_html('has_header_'.$logo_header_type.' '.$header_transparent_class); print  'contentheader_'.$logo_header_align; print ' cheader_'.$logo_header_align;?> ">

    <div class="master_header <?php print esc_html($wide_class.' '.$header_transparent_class); echo ' '.$wide_header_class;?>">
        
        <?php   
            if(esc_html ( get_option('wp_estate_show_top_bar_user_menu','') )=="yes" && !is_page_template( 'splash_page.php' ) ){
                get_template_part( 'templates/top_bar' ); 
            } 
            get_template_part('templates/mobile_menu_header' );
            
            
        ?>
       
        
        <div class="header_wrapper <?php echo $show_top_bar_user_login_class.' header_'.$logo_header_type.' header_'.$logo_header_align; echo ' hover_type_'.$top_menu_hover_type.' header_alignment_text_'.$text_header_align_select; ;?> ">
            <?php 
            if($logo_header_type  =='type5'){
                get_template_part('templates/header5');
            }else{
            ?>
            
            <div class="header_wrapper_inside <?php echo $wide_header_class; ?>" data-logo="<?php echo $logo;?>" data-sticky-logo="<?php echo $stikcy_logo_image; ?>">
                
                <div class="logo" >
                    <a href="<?php 
                    
                        $splash_page_logo_link   =   get_option('wp_estate_splash_page_logo_link','');  
                        if( is_page_template( 'splash_page.php' ) && $splash_page_logo_link!='' ){
                            echo $splash_page_logo_link;
                        }else{
                            echo home_url('','login');
                        }
                        ?>">
                        
                       <?php  
                        if ( $logo!='' ){
                           print '<img id="logo_image" style="margin-top:'.$logo_margin.'px;" src="'.$logo.'" class="img-responsive retina_ready" alt="logo"/>';	
                        } else {
                           print '<img id="logo_image" class="img-responsive retina_ready" src="'. get_template_directory_uri().'/img/logo.png" alt="logo"/>';
                        }
                        ?>
                    </a>
                </div>   

              
                <?php 
        
                    if( $show_top_bar_user_login == "yes" && $logo_header_type!='type3'){
                        get_template_part('templates/top_user_menu');  
                    }
                ?>    
                
                <?php 
                    if($logo_header_type!='type3'){
                ?>
                    <nav id="access">
                        <?php 
                            wp_nav_menu( 
                                array(  'theme_location'    => 'primary' ,
                                        'walker'            => new wpestate_custom_walker
                                    ) 
                            ); 
                        ?>
                    </nav><!-- #access -->
                <?php }else{ ?>
                    <a class="navicon-button header_type3_navicon" id="header_type3_trigger">
                        <div class="navicon"></div>
                    </a>
                <?php } ?>
                    
                <?php 
                if($logo_header_type=='type4'){
                    print '<div id="header4_footer"><ul class="xoxo">';
                        dynamic_sidebar('header4-widget-area');
                    print'</ul></div>';
                }
                ?>    
                    
            </div>
            <?php } ?>
        </div>

     </div> 
    
    <?php get_template_part( 'header_media' ); ?>   
    
  <div class="container content_wrapper">