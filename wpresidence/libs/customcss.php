<?php
<<<<<<< HEAD
if ($color_scheme == 'yes') {
    $main_color                     =  esc_html ( get_option('wp_estate_main_color','') );
    $background_color               = esc_html( get_option('wp_estate_background_color', '') );
    $content_back_color             = esc_html( get_option('wp_estate_content_back_color', '') );
    $header_color                   = esc_html( get_option('wp_estate_header_color', '') );
    $breadcrumbs_font_color         = esc_html(get_option('wp_estate_breadcrumbs_font_color', '') );
    $font_color                     = esc_html(get_option('wp_estate_font_color', '') );
    /* ---- */   $link_color                     = esc_html(get_option('wp_estate_link_color', '') );
    $headings_color                 = esc_html(get_option('wp_estate_headings_color', '') );
    $footer_back_color              = esc_html(get_option('wp_estate_footer_back_color', '') );
    $footer_font_color              = esc_html(get_option('wp_estate_footer_font_color', '') );
    $footer_copy_color              = esc_html(get_option('wp_estate_footer_copy_color', '') );
    $sidebar_widget_color           = esc_html(get_option('wp_estate_sidebar_widget_color', '') );
    $sidebar_heading_color          = esc_html ( get_option('wp_estate_sidebar_heading_color','') );
    $sidebar_heading_boxed_color    = esc_html ( get_option('wp_estate_sidebar_heading_boxed_color','') );
    $sidebar2_font_color            = esc_html(get_option('wp_estate_sidebar2_font_color', '') );
    $menu_font_color                = esc_html(get_option('wp_estate_menu_font_color', '') );
    $menu_hover_back_color          = esc_html(get_option('wp_estate_menu_hover_back_color', '') );
    $menu_hover_font_color          = esc_html(get_option('wp_estate_menu_hover_font_color', '') );
    $agent_color                    = esc_html(get_option('wp_estate_agent_color', '') );
    $top_bar_back                   = esc_html ( get_option('wp_estate_top_bar_back','') );
    $top_bar_font                   = esc_html ( get_option('wp_estate_top_bar_font','') );
    $adv_search_back_color          = esc_html ( get_option('wp_estate_adv_search_back_color ','') );
    $adv_search_font_color          = esc_html ( get_option('wp_estate_adv_search_font_color','') );
    $box_content_back_color         =  esc_html ( get_option('wp_estate_box_content_back_color','') );
    $box_content_border_color       =  esc_html ( get_option('wp_estate_box_content_border_color','') );
    $hover_button_color             =  esc_html ( get_option('wp_estate_hover_button_color','') );
   
=======

$main_color                     =   esc_html ( get_option('wp_estate_main_color','') );
$background_color               =   esc_html( get_option('wp_estate_background_color', '') );
$content_back_color             =   esc_html( get_option('wp_estate_content_back_color', '') );
$header_color                   =   esc_html( get_option('wp_estate_header_color', '') );
$breadcrumbs_font_color         =   esc_html(get_option('wp_estate_breadcrumbs_font_color', '') );
$menu_items_color               =   esc_html(get_option('wp_estate_menu_items_color', '') );
$font_color                     =   esc_html(get_option('wp_estate_font_color', '') );
$link_color                     =   esc_html(get_option('wp_estate_link_color', '') );
$headings_color                 =   esc_html(get_option('wp_estate_headings_color', '') );
$footer_back_color              =   esc_html(get_option('wp_estate_footer_back_color', '') );
$footer_font_color              =   esc_html(get_option('wp_estate_footer_font_color', '') );
$footer_copy_color              =   esc_html(get_option('wp_estate_footer_copy_color', '') );
$footer_copy_back_color         =   esc_html(get_option('wp_estate_footer_copy_back_color', '') );
$sidebar2_font_color            =   esc_html(get_option('wp_estate_sidebar2_font_color', '') );
$menu_font_color                =   esc_html(get_option('wp_estate_menu_font_color', '') );
$menu_hover_back_color          =   esc_html(get_option('wp_estate_menu_hover_back_color', '') );
$menu_hover_font_color          =   esc_html(get_option('wp_estate_menu_hover_font_color', '') );
$menu_border_color              =   esc_html ( get_option('wp_estate_menu_border_color','') );
$agent_color                    =   esc_html(get_option('wp_estate_agent_color', '') );
$top_bar_back                   =   esc_html ( get_option('wp_estate_top_bar_back','') );
$top_bar_font                   =   esc_html ( get_option('wp_estate_top_bar_font','') );
$adv_search_back_color          =   esc_html ( get_option('wp_estate_adv_search_back_color ','') );
$adv_search_font_color          =   esc_html ( get_option('wp_estate_adv_search_font_color','') );
$box_content_back_color         =   esc_html ( get_option('wp_estate_box_content_back_color','') );
$box_content_border_color       =   esc_html ( get_option('wp_estate_box_content_border_color','') );
$hover_button_color             =   esc_html ( get_option('wp_estate_hover_button_color','') );
 
$top_menu_hover_font_color                =  esc_html ( get_option('wp_estate_top_menu_hover_font_color','') );
    
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
/// Custom Colors
///////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($main_color != '') {
print'
<<<<<<< HEAD
    .property_listing img{
        border-bottom: 3px solid #'.$main_color.';
    }
    
#adv-search-header-3,#tab_prpg ul,.wpcf7-form input[type="submit"],.adv_results_wrapper #advanced_submit_2,.wpb_btn-info,#slider_enable_map:hover, #slider_enable_street:hover, #slider_enable_slider:hover,#colophon .social_sidebar_internal a:hover, #primary .social_sidebar_internal a:hover,
.ui-widget-header,.slider_control_left,  .slider_control_right,.single-content input[type="submit"] ,
#slider_enable_slider.slideron,#slider_enable_street.slideron, #slider_enable_map.slideron ,
.comment-form #submit,#add_favorites.isfavorite:hover,#add_favorites:hover  ,.carousel-control-theme-prev,.carousel-control-theme-next,
#primary .social_sidebar_internal a:hover , #adv-search-header-mobile,#adv-search-header-1, .featured_second_line, .wpb_btn-info, .agent_contanct_form input[type="submit"]  {
    background-color: #' . $main_color . '!important;
}
 
.blog_unit_image img, .blog2v img, .single-content input[type="submit"] ,
=======
.term_bar_item:hover:after,
.term_bar_item.active_term:after,
#schedule_meeting,
.agent_unit_button:hover,
.acc_google_maps,
.submit_action,
.submit_action:hover,
.header5_bottom_row_wrapper,
.unit_type3_details{
  background-color: #' . $main_color . ';
}


.no_more_list{
    color:#fff!important;
    border: 1px solid #'.$main_color.';
}
.agent_unit_button:hover{
    color:#fff!important;
}
.developer_taxonomy a:hover,
.shortcode_contact_form.sh_form_align_center #btn-cont-submit_sh:hover,
.lighbox-image-close-floor,
.lighbox-image-close,
#add_favorites.isfavorite,
.tax_active,  
.results_header,
.ll-skin-melon td .ui-state-active,
.ll-skin-melon td .ui-state-hover,
.adv_search_tab_item.active,    
button.slick-prev.slick-arrow,
button.slick-next.slick-arrow,
.wpresidence_button,
.comment-form #submit,
#adv-search-header-3,
#tab_prpg>ul,
.wpcf7-form input[type="submit"],
.adv_results_wrapper #advanced_submit_2,
.wpb_btn-info,
#slider_enable_map:hover,
#slider_enable_street:hover, 
#slider_enable_slider:hover,
#colophon .social_sidebar_internal a:hover,
#primary .social_sidebar_internal a:hover,
.ui-widget-header,
.slider_control_left,
.slider_control_right,
.single-content input[type="submit"],
#slider_enable_slider.slideron,
#slider_enable_street.slideron,
#slider_enable_map.slideron,
.comment-form #submit,
#add_favorites.isfavorite:hover,
#add_favorites:hover,
.carousel-control-theme-prev,
.carousel-control-theme-next,
#primary .social_sidebar_internal a:hover, 
#adv-search-header-mobile,
#adv-search-header-1,
.featured_second_line, 
.wpb_btn-info,
.agent_contanct_form input[type="submit"]{
    background-color: #' . $main_color . '!important;
}
.wpresidence_button{
border:none;
}

.comment-form #submit, 
.blog_unit_image img, .blog2v img,
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
.agentpict,.featured_property img , .agent_unit img {
    border-bottom: 3px solid #'.$main_color.'!important;
}

<<<<<<< HEAD
.compare_item_head .property_price,#grid_view:hover, #list_view:hover,#primary a:hover,.front_plan_row:hover,.adv_extended_options_text,.slider-content h3 a:hover,.agent_unit_social_single a:hover ,
.adv_extended_options_text:hover ,.breadcrumb a:hover , .property-panel h4:hover,
.featured_article:hover .featured_article_right, .info_details .prop_pricex,#contactinfobox,
.info_details #infobox_title,.featured_property:hover h2 a,
.blog_unit:hover h3 a,.blog_unit_meta .read_more:hover,
.blog_unit_meta a:hover,.agent_unit:hover h4 a,.listing_filter_select.open .filter_menu_trigger,
.wpestate_accordion_tab .ui-state-active a,.wpestate_accordion_tab .ui-state-active a:link,.wpestate_accordion_tab .ui-state-active a:visited,
.theme-slider-price, .agent_unit:hover h4 a,.meta-info a:hover,.widget_latest_price,.pack-listing-title,#colophon a:hover, #colophon li a:hover,
.price_area, .property_listing:hover h4 a, .listing_unit_price_wrapper,a:hover, a:focus, .top_bar .social_sidebar_internal a:hover,
.pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus,.featured_prop_price,.user_menu,.user_loged i, #access .current-menu-item >a, #access .current-menu-parent>a, #access .current-menu-ancestor>a,#access .menu li:hover>a, #access .menu li:hover>a:active, #access .menu li:hover>a:focus{
    color: #' . $main_color . ';
}
#amount_wd, #amount,#amount_mobile,#amount_sh{
=======
.developer_taxonomy a,
.directory_slider #property_size, 
.directory_slider #property_lot_size, 
.directory_slider #property_rooms, 
.directory_slider #property_bedrooms, 
.directory_slider #property_bathrooms,
.header_5_widget_icon,
input[type="checkbox"]:checked:before,
.testimonial-slider-container .slick-prev.slick-arrow:hover, .testimonial-slider-container .slick-next.slick-arrow:hover,
.testimonial-slider-container .slick-dots li.slick-active button:before,
.slider_container .slick-dots li button::before,
.slider_container .slick-dots li.slick-active button:before,
.single-content p a:hover,
.agent_unit_social a:hover,
.featured_prop_price .price_label,
.featured_prop_price .price_label_before,.compare_item_head .property_price,#grid_view:hover, 
#list_view:hover,#primary a:hover,.front_plan_row:hover,.adv_extended_options_text,.slider-content h3 a:hover,
.agent_unit_social_single a:hover ,
.adv_extended_options_text:hover ,.breadcrumb a:hover , .property-panel h4:hover,
.featured_article:hover .featured_article_right, .info_details .prop_pricex,.info_details .infocur,#contactinfobox,
.featured_property:hover h2 a,
.blog_unit:hover h3 a,.blog_unit_meta .read_more:hover,
.blog_unit_meta a:hover,.agent_unit:hover h4 a,.listing_filter_select.open .filter_menu_trigger,
.wpestate_accordion_tab .ui-state-active a,.wpestate_accordion_tab .ui-state-active a:link,.wpestate_accordion_tab .ui-state-active a:visited,
.theme-slider-price, .agent_unit:hover h4 a,.meta-info a:hover,.widget_latest_price,#colophon a:hover, #colophon li a:hover,
.price_area, .property_listing:hover h4 a, .listing_unit_price_wrapper,a:hover, a:focus, .top_bar .social_sidebar_internal a:hover,
.pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, 
.pagination > .active > a:focus, .pagination > .active > span:focus,.featured_prop_price,.user_menu,.user_loged i, 
#access .current-menu-item >a, #access .current-menu-parent>a, #access .current-menu-ancestor>a,
#access .menu li:hover>a:active, #access .menu li:hover>a:focus,
.social-wrapper a:hover i,
.agency_unit_wrapper .social-wrapper a i:hover,
.property_ratings i,
.listing-review .property_ratings i,
.term_bar_item:hover,
.agency_social i:hover,
.inforoom_unit_type4 span, 
.infobath_unit_type4 span, 
.infosize_unit_type4 span,
.propery_price4_grid{
    color: #' . $main_color . ';
}

.agent_unit_button,
#amount_wd, #amount,#amount_mobile,#amount_sh,
.mobile-trigger-user:hover i, .mobile-trigger:hover i,
.mobilemenu-close-user:hover, .mobilemenu-close:hover{
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    color: #' . $main_color . '!important;
}
        
.featured_article_title{
    border-top: 3px solid #'.$main_color.'!important;
}
<<<<<<< HEAD

.scrollon {
    border: 1px solid #'.$main_color.';
}
.customnav{
    border-bottom: 1px solid #'.$main_color.';
}';   
    

} 

=======
.developer_taxonomy a,
.agent_unit_button,
.adv_search_tab_item.active,
.scrollon {
    border: 1px solid #'.$main_color.';
}
.shortcode_contact_form.sh_form_align_center #btn-cont-submit_sh:hover{
   border-color: #' . $main_color . ';
}

';   
    

} 
    
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    
if ($background_color != '') {
print'body,.wide {background-color: #' . $background_color . ';} ';        
} // end $background_color

<<<<<<< HEAD
=======

>>>>>>> 64662fd89bea560852792d7203888072d7452d48
if ($content_back_color != '') {
print '.content_wrapper{ background-color: #' . $content_back_color . ';} ';
}// end content_back_color

<<<<<<< HEAD
if ($header_color != '') {
print' .master_header,#access ul ul,.customnav  {background-color: #' . $header_color . ' }'; 
=======

if ($header_color != '') {
print'
    .fixed_header.header_transparent .header_wrapper,
    .header_transparent .header_wrapper.navbar-fixed-top.customnav,
    .header_wrapper ,
    .master_header,
    #access ul ul,.customnav{
        background-color: #' . $header_color . '
    }'; 
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
} // end $header_color


if ($breadcrumbs_font_color != '') {
print '
.featured_article_righ, .featured_article_secondline,
.property_location .inforoom, .property_location .infobath , .agent_meta , .blog_unit_meta a, .property_location .infosize,
.sale_line , .meta-info a, .breadcrumb > li + li:before, .blog_unit_meta, .meta-info,.agent_position,.breadcrumb a {
    color: #' . $breadcrumbs_font_color . ';
}';
} // end $breadcrumbs_font_color 

<<<<<<< HEAD
if ($font_color != '') {
print'body,a,label,input[type=text], input[type=password], input[type=email], input[type=url], input[type=number], textarea, .slider-content, .listing-details, .form-control, #user_menu_open i,
#grid_view, #list_view, .listing_details a, .notice_area, .social-agent-page a, .prop_detailsx, #reg_passmail_topbar,#reg_passmail, .testimonial-text,
.wpestate_tabs .ui-widget-content, .wpestate_tour  .ui-widget-content, .wpestate_accordion_tab .ui-widget-content, .wpestate_accordion_tab .ui-state-default, .wpestate_accordion_tab .ui-widget-content .ui-state-default, 
.wpestate_accordion_tab .ui-widget-header .ui-state-default,.filter_menu{ color: #' . $font_color . ';}';

print '.caret,  .caret_sidebar, .advanced_search_shortcode .caret_filter{ border-top: 6px solid #' . $font_color . ';}';

} // end $font_color #a0a5a8

if ($link_color != '') {
    
print '
.user_dashboard_listed a,    .blog_unit_meta .read_more, .slider-content .read_more , .blog2v .read_more, .breadcrumb .active{
    color: #'.$link_color.';
}';
    
} // end $link_color

if ($headings_color != '') {
print 'h1, h2, h3, h4, h5, h6, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a ,.featured_property h2 a, .featured_property h2,.blog_unit h3, .blog_unit h3 a,.submit_container_header  {color: #'.$headings_color.';}';
} // end $headings_color 

if ($footer_back_color != '') {
print '#colophon {background-color: #'.$footer_back_color.';}';
} // end 


if ($footer_font_color != '') {
print '#colophon, #colophon a, #colophon li a {color: #'.$footer_font_color.';}';
} 

if ($footer_copy_color != '') {
print '.sub_footer, .subfooter_menu a, .subfooter_menu li a {color: #'.$footer_copy_color.'!important;}';
} 


if ($sidebar_widget_color != '') {
print '.zillow_widget .widget-title-footer, .mortgage_calculator_div .widget-title-sidebar, .loginwd_sidebar .widget-title-sidebar,.zillow_widget .widget-title-sidebar, .advanced_search_sidebar .widget-title-sidebar,.zillow_widget,.advanced_search_sidebar,.loginwd_sidebar,.mortgage_calculator_div {background-color: #'.$sidebar_widget_color.';}';
} 

if($sidebar_heading_color!=''){
    print '.widget-title-sidebar{color: #'.$sidebar_heading_color.';}';
}

if($sidebar_heading_boxed_color!=''){
    print ' .mortgage_calculator_div .widget-title-sidebar,.loginwd_sidebar .widget-title-sidebar, .zillow_widget .widget-title-sidebar, .advanced_search_sidebar .widget-title-sidebar{color: #'.$sidebar_heading_boxed_color.';}';
}

if ($sidebar2_font_color != '') {
print '#primary,#primary a,#primary label,  .advanced_search_sidebar  .form-control::-webkit-input-placeholder {color: #'.$sidebar2_font_color.';}'; 
} 

if ($menu_font_color != '') {
    print '#access a,#access ul ul a{color:#'.$menu_font_color.';}';  
} 

if ($menu_hover_back_color != '') {
    print '
    #user_menu_open > li > a:hover,     #user_menu_open > li > a:focus,
    .filter_menu li:hover,    .sub-menu li:hover, #access .menu li:hover>a, 
    #access .menu li:hover>a:active,     #access .menu li:hover>a:focus{
=======

if ($menu_font_color != '') {
    print '
    .customnav.header_type5 #access .menu-main-menu-container>ul>li>a,
    .header_type5 #access .menu-main-menu-container>ul>li>a,
    #header4_footer,
    #header4_footer .widget-title-header4,
    #header4_footer a,
    #access ul.menu >li>a{
        color: #' . $menu_font_color . ';
    }
    
    .menu_user_picture{
        border-color:#' . $menu_font_color . ';
    }
    
    .navicon:before, 
    .navicon:after,
    .navicon{  
        background: #'.$menu_font_color.';
     }';
} 

$transparent_menu_font_color                =  esc_html ( get_option('wp_estate_transparent_menu_font_color','') );
if ($transparent_menu_font_color != '') {
    print '
    .header_transparent .menu_user_tools, 
    .header_transparent #access ul.menu >li>a{
        color: #' . $transparent_menu_font_color . ';
    }
    
    .header_transparent .navicon:before, 
    .header_transparent .navicon:after,
    .header_transparent .navicon{
        background: #' . $transparent_menu_font_color . ';
    }
    .header_transparent .menu_user_picture{
        border-color: #' . $transparent_menu_font_color . ';
    }
    '; 
    
    

} 


if($top_menu_hover_font_color!=''){

    print '
    .customnav.header_type5 #access .menu-main-menu-container>ul>li:hover>a,
    .header_type5 #access .menu-main-menu-container>ul>li:hover>a,
    #access .menu li:hover>a,
    .header_type3_menu_sidebar #access .menu li:hover>a, 
    .header_type3_menu_sidebar #access .menu li:hover>a:active, 
    .header_type3_menu_sidebar #access .menu li:hover>a:focus,
    .customnav #access ul.menu >li>a:hover,
    #access ul.menu >li>a:hover,
    .hover_type_3 #access .menu > li:hover>a,
    .hover_type_4 #access .menu > li:hover>a,
    .hover_type_6 #access .menu > li:hover>a {
        color: #' . $top_menu_hover_font_color . ';
    }
    .hover_type_5 #access .menu > li:hover>a {
        border-bottom: 3px solid #' . $top_menu_hover_font_color . ';
    }
    .hover_type_6 #access .menu > li:hover>a {
      border: 2px solid #' . $top_menu_hover_font_color . ';
    }
    .hover_type_2 #access .menu > li:hover>a:before {
        border-top: 3px solid #' . $top_menu_hover_font_color . ';
    }'; 
   

}
$transparent_menu_hover_font_color               =  esc_html ( get_option('wp_estate_transparent_menu_hover_font_color','') );
  
if($transparent_menu_hover_font_color!=''){

    print '
    .header_transparent .customnav #access ul.menu >li>a:hover,
    .header_transparent #access ul.menu >li>a:hover,
    .header_transparent .hover_type_3 #access .menu > li:hover>a,
    .header_transparent .hover_type_4 #access .menu > li:hover>a,
    .header_transparent .hover_type_6 #access .menu > li:hover>a {
        color: #' . $transparent_menu_hover_font_color . ';
    }
    .header_transparent .hover_type_5 #access .menu > li:hover>a {
        border-bottom: 3px solid #' . $transparent_menu_hover_font_color . ';
    }
    .header_transparent .hover_type_6 #access .menu > li:hover>a {
      border: 2px solid #' . $transparent_menu_hover_font_color . ';
    }
    .header_transparent .hover_type_2 #access .menu > li:hover>a:before {
        border-top: 3px solid #' . $transparent_menu_hover_font_color . ';
    }'; 
   

}



$top_menu_hover_back_font_color                =  esc_html ( get_option('wp_estate_top_menu_hover_back_font_color','') );
if($top_menu_hover_back_font_color !=''){
    print '
     .alalx223,
       .header_type3_menu_sidebar .menu > li:hover,
    .hover_type_3 #access .menu > li:hover>a,
    .hover_type_4 #access .menu > li:hover>a {
        background: #'.$top_menu_hover_back_font_color.'!important;
    }';
}
    

$sticky_menu_font_color                =  esc_html ( get_option('wp_estate_sticky_menu_font_color','') );
if($sticky_menu_font_color!=''){
    print '
    .customnav.header_type5 #access .menu-main-menu-container>ul>li>a,
    .customnav #access ul.menu >li>a{
        color: #' . $sticky_menu_font_color . ';
    }
    .customnav .menu_user_picture{
        border-color:#' . $sticky_menu_font_color . ';
    }
    
    .customnav .navicon:before, 
    .customnav .navicon:after,
    .customnav .navicon{  
        background: #'.$sticky_menu_font_color.';
    }'; 
     
}


$menu_item_back_color         =  esc_html ( get_option('wp_estate_menu_item_back_color','') );
if($menu_item_back_color!=''){
    print '
    #access ul ul{
        background-color: #' . $menu_item_back_color . ';
    }'; 
     
}


  
  
  
  
if ($menu_hover_back_color != '') {
    print '
    #user_menu_open > li > a:hover,
    #user_menu_open > li > a:focus,
    .filter_menu li:hover,
    .sub-menu li:hover, #access .menu li:hover>a, 
    #access .menu li:hover>a:active, 
    #access .menu li:hover>a:focus{
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    background-color: #'.$menu_hover_back_color.';}
    
    .form-control.open .filter_menu_trigger, .menu_user_tools{
        color: #'.$menu_hover_back_color.';
    }
    .menu_user_picture {
        border: 1px solid #'.$menu_hover_back_color.';
    }
    ';
} // end $menu_hover_back_color


if ($menu_hover_font_color != '') {
<<<<<<< HEAD
    print '#access .sub-menu li:hover>a, #access .sub-menu li:hover>a:active, #access .sub-menu li:hover>a:focus {color: #'.$menu_hover_font_color.';}';
} // end $menu_hover_font_color

=======
    print '
    #access .menu ul li:hover>a,
    #access .sub-menu li:hover>a,
    #access .sub-menu li:hover>a:active, 
    #access .sub-menu li:hover>a:focus,
    #access .with-megamenu .sub-menu li:hover>a, 
    #access .with-megamenu .sub-menu li:hover>a:active, 
    #access .with-megamenu .sub-menu li:hover>a:focus{
        color: #'.$menu_hover_font_color.';
    }
    ';
} // end $menu_hover_font_color


if($menu_border_color!=''){
    print'#access ul ul {
        border-left: 1px solid   #'.$menu_border_color.'!important;
        border-right: 1px solid  #'.$menu_border_color.'!important;
        border-bottom: 1px solid #'.$menu_border_color.'!important;
        border-top: 1px solid #'.$menu_border_color.'!important;
    }
    #access ul ul a {
        border-bottom: 1px solid #'.$menu_border_color.';
    }';
}

$wp_estate_top_menu_font_size     = get_option('wp_estate_top_menu_font_size','');
if($wp_estate_top_menu_font_size!=''){     
    print '
    #access ul.menu >li>a{
        font-size:' . $wp_estate_top_menu_font_size . 'px;
    }'; 
}
 
$wp_estate_menu_item_font_size     = get_option('wp_estate_menu_item_font_size','');

if($wp_estate_menu_item_font_size!=''){     
    print '
        #access ul ul a,
        #access ul ul li.wpestate_megamenu_col_1, 
        #access ul ul li.wpestate_megamenu_col_2, 
        #access ul ul li.wpestate_megamenu_col_3, 
        #access ul ul li.wpestate_megamenu_col_4, 
        #access ul ul li.wpestate_megamenu_col_5, 
        #access ul ul li.wpestate_megamenu_col_6, 
        #access ul ul li.wpestate_megamenu_col_1 a, 
        #access ul ul li.wpestate_megamenu_col_2 a, 
        #access ul ul li.wpestate_megamenu_col_3 a, 
        #access ul ul li.wpestate_megamenu_col_4 a, 
        #access ul ul li.wpestate_megamenu_col_5 a, 
        #access ul ul li.wpestate_megamenu_col_6 a{
            font-size:' . $wp_estate_menu_item_font_size . 'px;
    }'; 
}




if ($menu_items_color != '') {
    print '
        #access a,
        #access ul ul a,
        #access ul ul li.wpestate_megamenu_col_1, 
        #access ul ul li.wpestate_megamenu_col_2, 
        #access ul ul li.wpestate_megamenu_col_3, 
        #access ul ul li.wpestate_megamenu_col_4, 
        #access ul ul li.wpestate_megamenu_col_5, 
        #access ul ul li.wpestate_megamenu_col_6, 
        #access ul ul li.wpestate_megamenu_col_1 a, 
        #access ul ul li.wpestate_megamenu_col_2 a, 
        #access ul ul li.wpestate_megamenu_col_3 a, 
        #access ul ul li.wpestate_megamenu_col_4 a, 
        #access ul ul li.wpestate_megamenu_col_5 a, 
        #access ul ul li.wpestate_megamenu_col_6 a,
        #access ul ul li.wpestate_megamenu_col_1 a.menu-item-link, 
        #access ul ul li.wpestate_megamenu_col_2 a.menu-item-link, 
        #access ul ul li.wpestate_megamenu_col_3 a.menu-item-link, 
        #access ul ul li.wpestate_megamenu_col_4 a.menu-item-link, 
        #access ul ul li.wpestate_megamenu_col_5 a.menu-item-link, 
        #access ul ul li.wpestate_megamenu_col_6 a.menu-item-link{
            color:#'.$menu_items_color.';
        }';  
   print '
       #access ul ul li.wpestate_megamenu_col_1 .megamenu-title:hover a, 
       #access ul ul li.wpestate_megamenu_col_2 .megamenu-title:hover a, 
       #access ul ul li.wpestate_megamenu_col_3 .megamenu-title:hover a, 
       #access ul ul li.wpestate_megamenu_col_4 .megamenu-title:hover a, 
       #access ul ul li.wpestate_megamenu_col_5 .megamenu-title:hover a, 
       #access ul ul li.wpestate_megamenu_col_6 .megamenu-title:hover a,
       #access .current-menu-item >a, 
       #access .current-menu-parent>a, 
       #access .current-menu-ancestor>a,
 
       #access .menu li:hover>a:active, 
       #access .menu li:hover>a:focus{
        color: #' . $menu_items_color . ';
    }'; 
   
 
    
   
}
















if ($font_color != '') {
print'body,a,label,input[type=text], input[type=password], input[type=email], 
    input[type=url], input[type=number], textarea, .slider-content, .listing-details, .form-control, #user_menu_open i,
#grid_view, #list_view, .listing_details a, .notice_area, .social-agent-page a, .prop_detailsx, #reg_passmail_topbar,
#reg_passmail, .testimonial-text,
.wpestate_tabs .ui-widget-content, 
.wpestate_tour .ui-widget-content, .wpestate_accordion_tab .ui-widget-content, 
.wpestate_accordion_tab .ui-state-default, .wpestate_accordion_tab .ui-widget-content .ui-state-default, 
.wpestate_accordion_tab .ui-widget-header .ui-state-default,
.filter_menu,
.property_listing_details .infosize,.property_listing_details .infobath,.property_listing_details .inforoom,
.directory_sidebar label,
.agent_detail a,
.agent_detail,.agent_position{ color: #' . $font_color . ';}';

print '.caret, .caret_sidebar, .advanced_search_shortcode .caret_filter{ border-top-color:#' . $font_color . ';}';

} // end $font_color #a0a5a8



if ($link_color != '') {
    
print '
.pagination > li > a,
.pagination > li > span,
.single-content p a,
.featured_article:hover h2 a,
.user_dashboard_listed a,
.blog_unit_meta .read_more, 
.slider-content .read_more, 
.blog2v .read_more, 
.breadcrumb .active,
.unit_more_x a, .unit_more_x,
#login_trigger_modal{
    color: #'.$link_color.';
}';
    
} // end $link_color



if ($headings_color != '') {
print 'h1, h2, h3, h4, h5, h6, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a ,.featured_property h2 a, .featured_property h2,'
    . '.blog_unit h3, .blog_unit h3 a,.submit_container_header,.info_details #infobox_title {color: #'.$headings_color.';}';
} // end $headings_color 



if ($footer_back_color != '') {
print '#colophon {background-color: #'.$footer_back_color.';}';
} // end 


if ($footer_font_color != '') {
print '#colophon, #colophon a, #colophon li a ,#colophon .widget-title-footer{color: #'.$footer_font_color.';}';
} 

if ($footer_copy_color != '') {
    print '.sub_footer, .subfooter_menu a, .subfooter_menu li a {color: #'.$footer_copy_color.'!important;}';
} 

if($footer_copy_back_color!=''){
    print '.sub_footer{background-color:#'.$footer_copy_back_color.';}'; 
}






>>>>>>> 64662fd89bea560852792d7203888072d7452d48
if($top_bar_back!=''){
    print '.top_bar_wrapper{background-color:#'.$top_bar_back.';}';
}    

if($top_bar_font!=''){
    print '.top_bar,.top_bar a{color:#'.$top_bar_font.';}';
}
 
if ($adv_search_back_color != '') {
<<<<<<< HEAD
   // print '#search_wrapper, .adv-search-1{background-color:#'.$adv_search_back_color.';}';
} 

if ($adv_search_font_color != '') {
    print '.advanced_search_shortcode  .caret_filter,.advanced_search_shortcode  .form-control,.advanced_search_shortcode  input[type=text],.advanced_search_shortcode  .form-control::-webkit-input-placeholder,
    .adv-search-1 .caret_filter,.adv-search-1 .form-control,.adv-search-1 input[type=text],.adv-search-1 .form-control::-webkit-input-placeholder{color:#'.$adv_search_font_color.';}';
} 

if ($box_content_back_color != '') {
    print '.featured_article_title, .testimonial-text, .adv1-holder,   .advanced_search_shortcode, .featured_secondline ,  .property_listing ,.agent_unit, .blog_unit { background-color:#'.$box_content_back_color.';}';
=======
    print '#advanced_submit_3, .adv-search-1 .wpresidence_button, .adv_handler{background-color:#'.$adv_search_back_color.'!important;}';
} 

if ($adv_search_font_color != '') {
    print '.advanced_search_shortcode .caret_filter,
    .advanced_search_shortcode .form-control,
    .advanced_search_shortcode input[type=text],
    .advanced_search_shortcode .form-control::-webkit-input-placeholder,
    .adv-search-1 .caret_filter,
    .adv-search-1 .form-control,
    .adv-search-3 .caret_filter,
    .adv-search-3 .form-control,
    .adv-search-1 input[type=text],
    .adv-search-3 input[type=text],
    .adv-search-1 .form-control::-webkit-input-placeholder,
    .adv-search-3 .form-control::-webkit-input-placeholder{color:#'.$adv_search_font_color.';}';
} 

if ($box_content_back_color != '') {
    print '.featured_article_title, .testimonial-text, .adv1-holder,.advanced_search_shortcode, .featured_secondline , '
    . '.property_listing ,.agent_unit, .blog_unit { background-color:#'.$box_content_back_color.';}';
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
} 

if ($box_content_border_color != '') {
    print '
<<<<<<< HEAD
    .featured_article,  .mortgage_calculator_div, .loginwd_sidebar, .advanced_search_sidebar, .advanced_search_shortcode,  #access ul ul, .testimonial-text, .submit_container, .zillow_widget,   
=======
    .featured_article,.mortgage_calculator_div, .loginwd_sidebar, .advanced_search_sidebar, 
    .advanced_search_shortcode, #access ul ul, .testimonial-text, .submit_container, .zillow_widget, 
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    .featured_property, .property_listing ,.agent_unit,.blog_unit,property_listing{
        border-color:#'.$box_content_border_color.';
    } 
 
    .company_headline, .loginwd_sidebar .widget-title-sidebar,
    .advanced_search_sidebar .widget-title-footer,.advanced_search_sidebar .widget-title-sidebar ,
<<<<<<< HEAD
    .zillow_widget .widget-title-footer,.zillow_widget .widget-title-sidebar, .adv1-holder,.notice_area,  .top_bar_wrapper, .master_header,  #access ul ul a , .listing_filters_head, .listing_filters    {
        border-bottom: 1px solid #'.$box_content_border_color.';
    }
    
    .adv-search-1, .notice_area,  .listing_filters_head, .listing_filters, .listing_unit_price_wrapper{
=======
    .zillow_widget .widget-title-footer,.zillow_widget .widget-title-sidebar, .adv1-holder,.notice_area,
    .top_bar_wrapper, .master_header, .listing_filters_head, .listing_filters{
        border-bottom: 1px solid #'.$box_content_border_color.';
    }
    
    .notice_area,.listing_filters_head, .listing_filters{
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        border-top: 1px solid #'.$box_content_border_color.';
    }
    
    .adv1-holder{
        border-left: 1px solid #'.$box_content_border_color.';
    }
    
<<<<<<< HEAD
    #search_wrapper{
      border-bottom: 3px solid #'.$box_content_border_color.';
    }'; 
=======
    '; 
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
} 

///////////////////////////////////////////////////////////////////////////////////////////////////////////
// End colors


if ($hover_button_color!=''){
<<<<<<< HEAD
    print ' .twitter_wrapper, .slider_control_right:hover, .slider_control_left:hover, .comment-form #submit:hover, .carousel-control-theme-prev:hover, .carousel-control-theme-next:hover , .wpb_btn-info:hover, #advanced_submit_2:hover, #agent_submit:hover{'
    .'background-color: #' . $hover_button_color . '!important;}';
    print '.comment-form #submit, .wpb_btn-info, .agent_contanct_form input[type="submit"], .twitter_wrapper{'
    . ' border-bottom: 3px solid #'.$hover_button_color.'!important;}';
    print '.icon_selected,.featured_prop_label {color: #' . $hover_button_color . '!important;}';
    print '#tab_prpg li{border-right: 1px solid #'. $hover_button_color .';}';
}


} //////////// end if color scheme
/////// Custom css
=======
    print '
    .acc_google_maps:hover, 
    #schedule_meeting:hover,
    .wpresidence_button:hover,
    .twitter_wrapper, 
    .slider_control_right:hover, 
    .slider_control_left:hover, 
    .comment-form #submit:hover, 
    .carousel-control-theme-prev:hover, 
    .carousel-control-theme-next:hover , 
    .wpb_btn-info:hover, 
    #advanced_submit_2:hover, 
    #agent_submit:hover,
    .single-content input[type="submit"]:hover,
    .agent_contanct_form input[type="submit"]:hover{
        background-color: #' . $hover_button_color . '!important;
    }
    
   
    .no_more_list:hover{
        background-color: #fff!important;
        border: 1px solid #'. $hover_button_color.';
        color:#' . $hover_button_color . '!important;
    }
    .icon_selected,.featured_prop_label{
        color: #' . $hover_button_color . '!important;
    }
    #tab_prpg li{
        border-right: 1px solid #'. $hover_button_color.';
    }';
}






//
$user_dashboard_menu_color      =  esc_html ( get_option('wp_estate_user_dashboard_menu_color','') );
if( $user_dashboard_menu_color  !=''){ 
    print'.user_dashboard_links a,.dashboard_username,.mobilex-menu li a {  color: #' . $user_dashboard_menu_color . ';}'; 
    print'.dashboard_menu_user_image,.mobilex-menu li {  border-bottom: 1px solid #' . $user_dashboard_menu_color . ';}';     
}

$user_dashboard_menu_hover_color      =  esc_html ( get_option('wp_estate_user_dashboard_menu_hover_color','') );
if( $user_dashboard_menu_hover_color  !=''){ 
    print'.user_dashboard_links a:hover,.user_dashboard_links .user_tab_active,.mobilex-menu li a:hover {  color: #' . $user_dashboard_menu_hover_color . ';}'; 
}

$user_dashboard_menu_color_hover  =  esc_html ( get_option('wp_estate_user_dashboard_menu_color_hover','') );
if( $user_dashboard_menu_color_hover  !=''){ 
    print '#open_packages:hover .fa,#open_packages:hover{color:#'.$user_dashboard_menu_color_hover.'}';
    print'.user_dashboard_links a:hover,.user_dashboard_links .user_tab_active,.mobile_user_menu li:hover{  background-color: #' . $user_dashboard_menu_color_hover . ';}'; 
 }

$user_dashboard_menu_back      =  esc_html ( get_option('wp_estate_user_dashboard_menu_back ','') );
if( $user_dashboard_menu_back   !=''){ 
    print'.col-md-3.user_menu_wrapper,.snap-drawer,.mobilex-menu li  { background-color: #' . $user_dashboard_menu_back  . ';}'; 
}

$user_dashboard_package_back      =  esc_html ( get_option('wp_estate_user_dashboard_package_back ','') );
if( $user_dashboard_package_back   !=''){ 
    print'.dashboard_package_row { background-color: #' . $user_dashboard_package_back. ';}'; 
}

$user_dashboard_package_color     =  esc_html ( get_option('wp_estate_user_dashboard_package_color ','') );
if( $user_dashboard_package_color   !=''){ 
    print'.pack-unit h4,.pack_description_unit.pack_description_details,.wrapper_packages .fa, .wrapper_packages,.pack-listing-title,.pack-listing-period,.buypackage { color: #' . $user_dashboard_package_color. ';}'; 
    print'.pack_description_unit.pack_description_details,.buypackage input[type="checkbox"],.pack-listing,.pack_description_details {  border: 1px solid #' . $user_dashboard_package_color  . ';}'; 
    print'.pack_description_row .add-estate.profile-page.profile-onprofile.row {  border-top: 1px solid #' . $user_dashboard_package_color  . ';}'; 
    print'.submit-price{  border-bottom: 1px solid #' . $user_dashboard_package_color  . ';}';
}

$user_dashboard_buy_package     =  esc_html ( get_option('wp_estate_user_dashboard_buy_package ','') );
if( $user_dashboard_buy_package   !=''){ 
    print '.package_selected {      border: 1px solid #'.$user_dashboard_buy_package.';}';
    print'.package_selected .buypackage { background-color: #' . $user_dashboard_buy_package. ';}'; 
    print'.pack-name,#open_packages:hover .fa,#open_packages:hover,.buypackage input[type="checkbox"]:checked:before,input[type="checkbox"]:checked:before { color: #' . $user_dashboard_buy_package. ';}'; 
}

$user_dashboard_package_select     =  esc_html ( get_option('wp_estate_user_dashboard_package_select ','') );
if( $user_dashboard_package_select   !=''){ 
    print'.buypackage,.buypackage input[type="checkbox"] { background-color: #' . $user_dashboard_package_select. ';}'; 
    print'.pack-name { color: #' . $user_dashboard_package_select. ';}'; 
}

$user_dashboard_content_back     =  esc_html ( get_option('wp_estate_user_dashboard_content_back ','') );
if( $user_dashboard_content_back   !=''){ 
    print'.dashboard-margin { background-color: #' . $user_dashboard_content_back . ';}'; 
}

$user_dashboard_content_button_back     =  esc_html ( get_option('wp_estate_user_dashboard_content_button_back  ','') );
if( $user_dashboard_content_button_back    !=''){ 
    print'#stripe_cancel,#update_profile, #change_pass, .wpresidence_success,.page-template-user_dashboard_add .wpresidence_button,.page-template-user_dashboard .wpresidence_button,.wpb_btn-success { background-color: #' . $user_dashboard_content_button_back  . '!important;}'; 
    print'.wpb_btn-success { border-bottom: 3px solid #' . $user_dashboard_content_button_back  . '!important;}'; 
}

$user_dashboard_content_color     =  esc_html ( get_option('wp_estate_user_dashboard_content_color','') );
if( $user_dashboard_content_color    !=''){ 
    print'.dashboard-margin .entry-title,.user_details_row, .change_pass,.user_details_row, .change_pass,.user_profile_explain, .profile-page label, .pass_note, .upload_explain, .full_form_image,.invoice_totals,.invoice_unit_title,.invoice_unit,.col-md-12.row_dasboard-prop-listing h4 { color: #' . $user_dashboard_content_color . ';}'; 
    print'.add-estate.profile-page.profile-onprofile.row { border-top: 1px solid #' . $user_dashboard_content_color  . ';}'; 
}

$mobile_header_background_color       =  esc_html ( get_option('wp_estate_mobile_header_background_color','') );
if($mobile_header_background_color   !=''){
    print'.mobile_header {background-color: #'.$mobile_header_background_color.';}';
}

$mobile_header_icon_color          =  esc_html ( get_option('wp_estate_mobile_header_icon_color','') );
if($mobile_header_icon_color  !=''){
    print'.mobilemenu-close-user, .mobilemenu-close, .mobile_header i  {color: #'.$mobile_header_icon_color.';}';
    
}

$mobile_menu_font_color          =  esc_html ( get_option('wp_estate_mobile_menu_font_color','') );
if($mobile_menu_font_color  !=''){
    print'.mobilex-menu li a {color:#'.$mobile_menu_font_color .' ;}';
}

$mobile_menu_hover_font_color    =esc_html( get_option('wp_estate_mobile_menu_hover_font_color',''));

if($mobile_menu_hover_font_color  !=''){
    print'.mobilex-menu li a:hover{color:#'.$mobile_menu_hover_font_color. ';}';
}

$mobile_item_hover_back_color         =  esc_html ( get_option('wp_estate_mobile_item_hover_back_color','') );
if($mobile_item_hover_back_color  !=''){
    print' .mobile_user_menu li:hover {background-color:#'.$mobile_item_hover_back_color .';}';
}

 $mobile_menu_backgound_color = esc_html(get_option('wp_estate_mobile_menu_backgound_color', ''));
 if( $mobile_menu_backgound_color !=''){
    print' .mobilex-menu, .snap-drawer { background-color: #'.$mobile_menu_backgound_color.' ;}'; 
 }
 
$mobile_menu_border_color = esc_html(get_option('wp_estate_mobile_menu_border_color', ''));
  if($mobile_menu_border_color !=''){
      print' .mobilex-menu li {border-bottom-color: #'.$mobile_menu_border_color.';}';
  }



>>>>>>> 64662fd89bea560852792d7203888072d7452d48
?>