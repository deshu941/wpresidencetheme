<<<<<<< HEAD
<div class="top_bar_wrapper">
    <div class="top_bar">        
        <div class="left-top-widet">
            <ul class="xoxo">
            <?php dynamic_sidebar('top-bar-left-widget-area'); ?>
=======
<div class="top_bar_wrapper <?php echo 'topbar_show_mobile_'.get_option('wp_estate_show_top_bar_user_menu_mobile',''); ?>">
    <div class="top_bar">      
        <?php if ( !wpestate_is_user_dashboard() ){?>
        <div class="left-top-widet">
            <ul class="xoxo">
            <?php 
            dynamic_sidebar('top-bar-left-widget-area'); ?>
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
            </ul>    
        </div>  

        <div class="right-top-widet">
            <ul class="xoxo">
            <?php dynamic_sidebar('top-bar-right-widget-area'); ?>
            </ul>
        </div> 
<<<<<<< HEAD
       
=======
        
        <?php }else{?>
        <div class="left-top-widet">
            <ul class="xoxo"> 
            <?php dynamic_sidebar('dashboard-top-bar-left-widget-area'); ?>
            </ul>    
        </div>  

        <div class="right-top-widet">
            <ul class="xoxo">
            <?php dynamic_sidebar('dashboard-top-bar-right-widget-area'); ?>
            </ul>
        </div> 
        
        <?php } ?>
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
       <!-- <span id="switch" style="margin-left: 20px;">swithc style</span> -->
    </div>    
</div>