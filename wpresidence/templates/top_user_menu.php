<?php
$current_user               =   wp_get_current_user();
$user_custom_picture        =   get_the_author_meta( 'small_custom_picture' , $current_user->ID  );
$user_small_picture_id      =   get_the_author_meta( 'small_custom_picture' , $current_user->ID  );
if( $user_small_picture_id == '' ){

    $user_small_picture[0]=get_template_directory_uri().'/img/default_user_small.png';
}else{
    $user_small_picture=wp_get_attachment_image_src($user_small_picture_id,'user_thumb');
    
}
?>

   
<?php if(is_user_logged_in()){ ?>   
    <div class="user_menu user_loged" id="user_menu_u">
        <a class="menu_user_tools dropdown" id="user_menu_trigger" data-toggle="dropdown"> 
            <a class="navicon-button x">
                <div class="navicon"></div>
            </a>
        <div class="menu_user_picture" style="background-image: url('<?php print $user_small_picture[0]; ?>');"></div>
<?php }else{ ?>
    <div class="user_menu user_not_loged" id="user_menu_u">   
        <a class="menu_user_tools dropdown" id="user_menu_trigger" data-toggle="dropdown">  
            <a class="navicon-button nav-notlog x">
                <div class="navicon"></div>
            </a>
        <div class="submit_action"><?php _e('+ Submit Property','wpestate');?></div>
<?php } ?>   
                  
    </div> 
        
        
<?php 
if ( 0 != $current_user->ID  && is_user_logged_in() ) {
    $username               =   $current_user->user_login ;
    $add_link               =   wpestate_get_template_link('user_dashboard_add.php');
    $dash_profile           =   wpestate_get_template_link('user_dashboard_profile.php');
    $dash_favorite          =   wpestate_get_template_link('user_dashboard_favorite.php');
    $dash_link              =   wpestate_get_template_link('user_dashboard.php');
    $dash_searches          =   wpestate_get_template_link('user_dashboard_searches.php');
    $logout_url             =   wp_logout_url();      
    $home_url               =   home_url();
    $dash_invoices          =   wpestate_get_template_link('user_dashboard_invoices.php');
    $activeaddagent         =   wpestate_get_template_link('user_dashboard_add_agent.php');
    $activeagentlist        =   wpestate_get_template_link('user_dashboard_agent_list.php');
    $dash_inbox             =   wpestate_get_template_link('user_dashboard_inbox.php');
    $no_unread              =   intval(get_user_meta($current_user->ID,'unread_mess',true));
    $user_role              =   get_user_meta( $current_user->ID, 'user_estate_role', true) ;
    $user_agent_id          =   intval( get_user_meta($current_user->ID,'user_agent_id',true));
?> 
    <ul id="user_menu_open" class="dropdown-menu menulist topmenux" role="menu" aria-labelledby="user_menu_trigger"> 
        <?php if($home_url!=$dash_profile && $dash_profile!=''){?>

                  <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php print esc_url($dash_profile);?>"  class="active_profile"><i class="fa fa-cog"></i><?php _e('My Profile','wpestate');?></a></li>    
        <?php  
        }
        ?>
        
        <?php if($home_url!=$dash_link && $dash_link!=''){
            if($user_agent_id==0 || ( $user_agent_id!=0 && get_post_status($user_agent_id)!='pending' && get_post_status($user_agent_id)!='disabled') ){?>
         <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php print esc_url($dash_link);?>"     class="active_dash"><i class="fa fa-map-marker"></i><?php _e('My Properties List','wpestate');?></a></li>
        
        <?php  } 
        }
        ?>
        
        <?php if($home_url!=$add_link && $add_link!=''){
          if($user_agent_id==0 || ( $user_agent_id!=0 && get_post_status($user_agent_id)!='pending' && get_post_status($user_agent_id)!='disabled') ){?>
          <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php print esc_url($add_link);?>"      class="active_add"><i class="fa fa-plus"></i><?php _e('Add New Property','wpestate');?></a></li>
        
        <?php   
        }
        }
        ?>
          
        <?php if($user_role==3 || $user_role ==4){
             if( $user_agent_id!=0 && get_post_status($user_agent_id)!='pending'){?>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php print esc_url($activeaddagent);?>"      class="active_add"><i class="fa fa-user-plus"></i><?php _e('Add New Agent','wpestate');?></a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php print esc_url($activeagentlist);?>"     class="active_add"><i class="fa fa-user"></i><?php _e('Agent list','wpestate');?></a></li>

          
        <?php
            }
        }
        ?>
        
        <?php if($home_url!=$dash_favorite && $dash_favorite!=''){?>
            <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php print esc_url($dash_favorite);?>" class="active_fav"><i class="fa fa-heart"></i><?php _e('Favorites','wpestate');?></a></li>
        <?php   
        }
        ?>
        
        <?php if($home_url!=$dash_searches && $dash_searches!=''){?>
            <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php print esc_url($dash_searches);?>" class="active_fav"><i class="fa fa-search"></i><?php _e('Saved Searches','wpestate');?></a></li>
        <?php   
        }
        ?>
            
        <?php if($home_url!=$dash_invoices && $dash_invoices!=''){?>
            <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php print esc_url($dash_invoices);?>" class="active_fav"><i class="fa fa-file-text-o"></i><?php _e('My Invoices','wpestate');?></a></li>
        <?php   
        }
        ?>
            
        <?php if($home_url!=$dash_inbox && $dash_inbox!=''){ ?>
                 <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php print esc_url($dash_inbox);?>" class="active_fav"><i class="fa fa-envelope-o"></i><?php _e('Inbox','wpestate');?></a>
                <?php 
                    if  ($no_unread>0){
                        echo '<div class="unread_mess">'.$no_unread.'</div>';
                    }
                ?>
            </li>
        <?php   
        }
        ?>
            
       
        <li role="presentation" class="divider"></li>
        <li role="presentation"><a href="<?php echo wp_logout_url( home_url());?>" title="Logout" class="menulogout"><i class="fa fa-power-off"></i><?php _e('Log Out','wpestate');?></a></li>
    </ul>
<?php }?>