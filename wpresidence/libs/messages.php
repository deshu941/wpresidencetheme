<?php
// register the custom post type
add_action( 'after_setup_theme', 'wpestate_create_message_type' );

if( !function_exists('wpestate_create_message_type') ):

function wpestate_create_message_type() {
    register_post_type( 'wpestate_message',
                    array(
                            'labels' => array(
                                    'name'          => __(  'Messages','wpestate'),
                                    'singular_name' => __(  'Message','wpestate'),
                                    'add_new'       => __( 'Add New Message','wpestate'),
                    'add_new_item'          =>  __( 'Add Message','wpestate'),
                    'edit'                  =>  __( 'Edit' ,'wpestate'),
                    'edit_item'             =>  __( 'Edit Message','wpestate'),
                    'new_item'              =>  __( 'New Message','wpestate'),
                    'view'                  =>  __( 'View','wpestate'),
                    'view_item'             =>  __( 'View Message','wpestate'),
                    'search_items'          =>  __( 'Search Message','wpestate'),
                    'not_found'             =>  __( 'No Message found','wpestate'),
                    'not_found_in_trash'    =>  __( 'No Message found','wpestate'),
                    'parent'                =>  __( 'Parent Message','wpestate')
                            ),
                    'public' => true,
                    'has_archive' => true,
                    'rewrite' => array('slug' => 'message'),
                    'supports' => array('title', 'editor'),
                    'can_export' => true,
                    'register_meta_box_cb' => 'wpestate_add_message_metaboxes',
                    'menu_icon'=> get_template_directory_uri().'/img/message.png',
                    'exclude_from_search'   => true    
                    )
            ); 
}
endif; // end   wpestate_message  

function wpestate_hide_add_new_wpestate_message()
{
    global $submenu;
    // replace my_type with the name of your post type
    unset($submenu['edit.php?post_type=wpestate_message'][10]);
}
add_action('admin_menu', 'wpestate_hide_add_new_wpestate_message');


////////////////////////////////////////////////////////////////////////////////////////////////
// Add message metaboxes
////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_add_message_metaboxes') ):
    function wpestate_add_message_metaboxes() {	
      add_meta_box(  'estate_message-sectionid', esc_html__(  'Message Details', 'wpestate' ), 'wpestate_message_meta_function', 'wpestate_message' ,'normal','default');
    }
endif; // end   



////////////////////////////////////////////////////////////////////////////////////////////////
// message details
////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_message_meta_function') ):
    function wpestate_message_meta_function( $post ) {
        wp_nonce_field( plugin_basename( __FILE__ ), 'estate_message_noncename' );
        global $post;

        $from_value=esc_html(get_post_meta($post->ID, 'message_from_user', true));
         $first_content=esc_html(get_post_meta($post->ID, 'first_content', true));
        if (wpestate_is_edit_page('new')){
            $from_value='administrator';
        }
        $to_val=esc_html(get_post_meta($post->ID, 'message_to_user', true));
     
        print'
        <p class="meta-options">
            <label for="message_from_user">'.esc_html__( 'From User:','wpestate').' </label><br />
            <input type="text" id="message_from_user" size="58" name="message_from_user" value="';
            //$from_value 
            $user = get_user_by( 'id', $from_value );
            echo $user->user_login;
            print '">
        </p>

        <p class="meta-options">
            <label for="message_to_user">'.esc_html__( 'To User:','wpestate').' </label><br />
            <select id="message_to_user" name="message_to_user">
                '.wpestate_get_user_list().'
            </select>   

        <input type="hidden" name="message_status" value="'.esc_html__( 'unread','wpestate').'">
        <input type="hidden" name="delete_source" value="0">
        <input type="hidden" name="delete_destination" value="0">    
        </p>';     
    }
endif; // end   





////////////////////////////////////////////////////////////////////////////////
// get_user_list
////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_get_user_list') ):
    function wpestate_get_user_list(){
        global $post;
        $selected=  get_post_meta($post->ID,'message_to_user',true);
        
        $return_string='';
        $blogusers = get_users();
        foreach ($blogusers as $user) {
           $return_string.= '<option value="'.$user->ID.'" ';
           if( $selected == $user->ID ){
                $return_string.=' selected="selected" ';
           }
           $return_string.= '>' . $user->user_nicename . '</option>';
        }
     return $return_string;   
    }
endif;



if( !function_exists('wpestate_is_edit_page') ):
    function wpestate_is_edit_page($new_edit = null){
        global $pagenow;
        //make sure we are on the backend
        if (!is_admin()) return false;


        if($new_edit == "edit")
            return in_array( $pagenow, array( 'post.php',  ) );
        elseif($new_edit == "new") //check for new post page
            return in_array( $pagenow, array( 'post-new.php' ) );
        else //check for either new or edit
            return in_array( $pagenow, array( 'post.php', 'post-new.php' ) );
    }
endif;



if( !function_exists('wpestate_show_mess_reply') ):
    function wpestate_show_mess_reply($post_id){
        $args = array(
                    'post_type'         => 'wpestate_message',
                    'post_status'       => 'publish',
                    'paged'             => 1,
                    'posts_per_page'    => 30,
                    'order'             => 'DESC',
                    'post_parent'       => $post_id,
                 );

        $message_selection = new WP_Query($args);
        while ($message_selection->have_posts()): $message_selection->the_post(); 
            print  get_the_title().'</br>';
        endwhile;
        wp_reset_query();      
    }
endif;





add_filter( 'manage_edit-wpestate_message_columns', 'wpestate_my_mess_columns' );
if( !function_exists('wpestate_my_mess_columns') ):
    function wpestate_my_mess_columns( $columns ) {
        $slice=array_slice($columns,2,2);
        unset( $columns['comments'] );
        unset( $slice['comments'] );
        $splice=array_splice($columns, 2);   
        $columns['mess_from_who']= esc_html__( 'From','wpestate');
        $columns['mess_to_who']  = esc_html__( 'To','wpestate');
        return  array_merge($columns,array_reverse($slice));
    }
endif; // end   wpestate_my_columns  


add_action( 'manage_posts_custom_column', 'wpestate_populate_messages_columns' );
if( !function_exists('wpestate_populate_messages_columns') ):
    function wpestate_populate_messages_columns( $column ) {
    $the_id=get_the_ID();
   
    $from_value =   esc_html(get_post_meta($the_id, 'message_from_user', true));
    $to_val     =   esc_html(get_post_meta($the_id, 'message_to_user', true));
        
    if( 'mess_from_who' == $column){
   
     if(intval($from_value)!=0){
        $user = get_user_by( 'id', $from_value );
        echo $user->user_login;  
     }else{
        echo $from_value;
     }
    
    }

    if( 'mess_to_who' == $column){        
        $user = get_user_by( 'id', $to_val );
        echo $user->user_login;
    }

    }

endif;



add_action('wp_ajax_wpestate_message_reply', 'wpestate_message_reply' );  
if( !function_exists('wpestate_message_reply') ):
    function wpestate_message_reply(){

        $current_user = wp_get_current_user();
        $userID                         =   $current_user->ID;
        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }
        
        echo'masas ';
        
        wp_reset_postdata();
        wp_reset_query();
        
        $messid         =   intval($_POST['messid']);
        $title          =   esc_html($_POST['title']);  
        $content        =   esc_html($_POST['content']);
        $receiver_id    =   wpsestate_get_author($messid);
        
        $message_to_user    = get_post_meta($messid,'message_to_user',true);
       
      
        if( $current_user->ID != $message_to_user && $current_user->ID != $receiver_id ) {
            exit('you don\'t have the right');
        }

        
        $my_post = array(
            'post_title'    => $title,
            'post_content'  => $content,
            'post_status'   => 'publish',
            'post_type'     => 'wpestate_message',
            'post_author'   => $userID, 
            'post_parent'   => $messid
        );

        $post_id = wp_insert_post( $my_post );
       
        //update_post_meta($post_id, 'message_status', 'unread');
        update_post_meta($post_id, 'delete_source', 0);
        update_post_meta($post_id, 'delete_destination', 0);
        update_post_meta($post_id, 'message_to_user', $receiver_id);
    
      
        $mes_to     =   get_post_meta($messid, 'message_to_user',true );
        $mess_from  =   get_post_meta($messid, 'message_from_user',true );
        
        if($userID != $mes_to){
            wpestate_increment_mess_mo($mes_to);   
        }else{
            wpestate_increment_mess_mo($mess_from);  
        }
        
        update_post_meta($messid, 'message_status'.$mes_to, 'unread' );
        update_post_meta($messid, 'message_status'.$mess_from, 'unread' );
        update_post_meta($messid, 'message_status'.$userID, 'read' );
         
        $email_sender   =   get_userdata($userID);
        update_post_meta($post_id, 'message_from_user', $userID);

  
        // decide who is receiver 
//        if($userID == $mes_to ){
//            $receiver           =   get_userdata($mess_from);
//            $receiver_email     =   $receiver->user_email;
//        }else{
//            $receiver           =   get_userdata($mes_to);
//            $receiver_email     =   $receiver->user_email;
//        }

        //wpestate_send_booking_email('inbox',$receiver_email);
       
        die();
    }
endif;



add_action('wp_ajax_wpestate_booking_mark_as_read', 'wpestate_booking_mark_as_read' );  
 
if( !function_exists('wpestate_booking_mark_as_read') ):
    function wpestate_booking_mark_as_read(){
        
        $current_user = wp_get_current_user();
        $userID                         =   $current_user->ID;


        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }
    
        $messid             =   intval($_POST['messid']);
        $receiver_id        =   wpsestate_get_author($messid);
        $message_to_user    =   get_post_meta($messid,'message_to_user',true);
      
        if( $current_user->ID != $message_to_user && $current_user->ID != $receiver_id ) {
            exit('you don\'t have the right');
        }

        $mess_status =      get_post_meta($messid, 'message_status'.$current_user->ID, true);
        if($mess_status!=='read'){
            update_post_meta($messid, 'message_status'.$current_user->ID, 'read');
            $unread=abs(intval ( get_user_meta($current_user->ID,'unread_mess',true) - 1));
            update_user_meta($current_user->ID,'unread_mess',$unread);
        }
        die();
    }
endif;




add_action('wp_ajax_wpestate_booking_delete_mess', 'wpestate_booking_delete_mess' );  
 
if( !function_exists('wpestate_booking_delete_mess') ):
    function wpestate_booking_delete_mess(){
       
        $current_user   =   wp_get_current_user();
        $userID         =   $current_user->ID;

        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
      
        if($userID === 0 ){
            exit('out pls');
        }


        $userID             =   $current_user->ID;
        $messid             =   intval($_POST['messid']);
        $receiver_id        =   wpsestate_get_author($messid);
        $message_to_user    =   get_post_meta($messid,'message_to_user',true);
      
        if( $current_user->ID != $message_to_user && $current_user->ID != $receiver_id ) {
            exit('you don\'t have the right');
        }

        update_post_meta($messid, 'delete_destination'.$userID, 1);
        
        $mess_status =      get_post_meta($messid, 'message_status'.$current_user->ID, true);
        if($mess_status!=='read'){
            $unread=abs(intval ( get_user_meta($current_user->ID,'unread_mess',true) - 1));
            update_user_meta($current_user->ID,'unread_mess',$unread);
        }
        

        
        $starter        =   get_post_meta($messid,'message_from_user',true);       
        $destination    =   get_post_meta($messid,'message_to_user',true);
        
        $delete_start   =   get_post_meta($messid,'delete_destination'.$starter,true);    
        $delete_dest    =   get_post_meta($messid,'delete_destination'.$destination,true);    
        
        if($delete_start ==1 && $delete_dest==1){
            $args_child = array(
                'post_type'         => 'wpestate_message',
                'posts_per_page'    => -1,
                'post_parent'       => $messid,
            );

        
            $message_selection_child = new WP_Query($args_child);
            while ($message_selection_child->have_posts()): $message_selection_child->the_post(); 
                $delete_id=get_the_ID();
                print 'delete '.$delete_id;
                wp_delete_post($delete_id);
            endwhile;
            print 'end delete';
              print 'sss delete'.$messid;
            wp_delete_post ($messid);
            wp_reset_query();
            wp_reset_post_data();
          
        }
        
        die();
    }
endif;






add_action('wp_ajax_nopriv_wpestate_mess_front_end', 'wpestate_mess_front_end');  
add_action('wp_ajax_wpestate_mess_front_end', 'wpestate_mess_front_end' );  
if( !function_exists('wpestate_mess_front_end') ):
    function wpestate_mess_front_end(){
        //  check_ajax_referer( 'mess_ajax_nonce_front', 'security-register' );       
        $current_user = wp_get_current_user();
        $allowed_html       =   array();
        $userID             =   $current_user->ID;
        $user_login         =   $current_user->user_login;
        $subject            =   esc_html__( 'Message from ','wpestate').$user_login;
        $message_from_user       =   esc_html($_POST['message']);
        $property_id        =   intval ( $_POST['agent_property_id']);
        $agent_id           =   intval ( $_POST['agent_id'] );
        
        if($agent_id === 0){
            $owner_id           =   wpsestate_get_author($property_id);
        }else{
            $owner_id           =   get_post_meta($agent_id, 'user_agent_id', true);
        }

        $owner              =   get_userdata($owner_id);
        $owner_email        =   $owner->user_email;
        $owner_login        =   $owner->ID;
        $subject            =   esc_html__( 'Message from ','wpestate').$user_login;
     

        $booking_guest_no   =   intval  ( $_POST['booking_guest_no'] );
        $booking_from_date  =   wp_kses ( $_POST['booking_from_date'],$allowed_html  );
        $booking_to_date    =   wp_kses ( $_POST['booking_to_date'],$allowed_html  );
        
        if($property_id!=0 && get_post_type($property_id) === 'estate_property' ){
            $message_user .= esc_html__(' Sent for property ','wpestate').get_the_title($property_id).', '.esc_html__('with the link:','wpestate').' '.get_permalink($property_id).' ';
        }
        $message_user .=    esc_html__( 'Selected dates: ','wpestate').$booking_from_date.esc_html__( ' to ','wpestate').$booking_to_date.", ".esc_html__( ' guests:','wpestate').$booking_guest_no." ".esc_html__('Content','wpestate').": ".$message_from_user;
        
       
        
        

        // add into inbox
        wpestate_add_to_inbox($userID,$userID,$owner_login,$subject,$message_user,1);

        esc_html_e('Your message was sent! You will be notified by email when a reply is received.','wpestate'); 
        die();            
    }
endif;





if(!function_exists('wpestate_calculate_new_mess')):
    function wpestate_calculate_new_mess(){
        global $current_user;
        $current_user = wp_get_current_user();
        $userID                         =   $current_user->ID;
        
        $args_mess = array(
                  'post_type'         => 'wpestate_message',
                  'post_status'       => 'publish',
                  'posts_per_page'    => -1,
                  'order'             => 'DESC',

                  'meta_query' => array(
                                      'relation' => 'AND',
                                      array(
                                          'relation' => 'OR',
                                          array(
                                                  'key'       => 'message_to_user',
                                                  'value'     => $userID,
                                                  'compare'   => '='
                                          ),
                                          array(
                                                  'key'       => 'message_from_user',
                                                  'value'     => $userID,
                                                  'compare'   => '='
                                          ),
                                      ),
                                      array(
                                          'key'       => 'first_content',
                                          'value'     => 1,
                                          'compare'   => '='
                                      ),  
                                      array(
                                          'key'       => 'delete_destination'.$userID,
                                          'value'     => 1,
                                          'compare'   => '!='
                                      ),
                                      array(
                                          'key'       =>  'message_status'.$userID,
                                          'value'     => 'unread',
                                          'compare'   => '=='
                                      ),
                              )
          );

     $args_mess_selection = new WP_Query($args_mess);

        update_user_meta($userID,'unread_mess',$args_mess_selection->found_posts);
        //return $args_mess_selection->found_posts;
        
    }
endif;




add_action( 'wp_ajax_wpestate_ajax_send_message', 'wpestate_ajax_send_message' );  
if( !function_exists('wpestate_ajax_send_message') ):

    function wpestate_ajax_send_message(){
        $current_user   =   wp_get_current_user();
        $prop_id        =   intval($_POST['propid']);
        $userID         =   $current_user->ID;
        $post           =   get_post($prop_id); 

        if ( !is_user_logged_in() ) {   
            exit('ko');
        }

        if($userID === 0 ){
            exit('out pls');
        }
        // check for POST vars
        $hasError       =   false; 
        $allowed_html   =   array();
        $to_print       =   '';
        
        if ( !wp_verify_nonce( $_POST['nonce'], 'ajax-property-contact')) {
            exit("No naughty business please");
        }   
       
        
        if ( isset($_POST['name']) ) {
            if( trim($_POST['name']) =='' || trim($_POST['name']) ==__('Your Name','wpestate') ){
                echo json_encode(array('sent'=>false, 'response'=>__('The name field is empty !','wpestate') ));         
                exit(); 
            }else {
                $name = sanitize_text_field (wp_kses( trim($_POST['name']),$allowed_html) );
            }          
        } 

        //Check email
        if ( isset($_POST['email']) || trim($_POST['name']) ==__('Your Email','wpestate') ) {
            if( trim($_POST['email']) ==''){
                echo json_encode(array('sent'=>false, 'response'=>__('The email field is empty','wpestate' ) ) );      
                exit(); 
            } else if( filter_var($_POST['email'],FILTER_VALIDATE_EMAIL) === false) {
                echo json_encode(array('sent'=>false, 'response'=>__('The email doesn\'t look right !','wpestate') ) ); 
                exit();
            } else {
                $email = sanitize_text_field ( wp_kses( trim($_POST['email']),$allowed_html) );
            }
        }

        
        
        $phone   = sanitize_text_field(wp_kses( trim($_POST['phone']),$allowed_html) );
        $subject =__('Contact form from ','wpestate') . home_url() ;

        //Check comments 
        if ( isset($_POST['comment']) ) {
            if( trim($_POST['comment']) =='' || trim($_POST['comment']) ==__('Your Message','wpestate')){
                echo json_encode(array('sent'=>false, 'response'=>__('Your message is empty !','wpestate') ) ); 
                exit();
            }else {
                $comment = sanitize_text_field(wp_kses($_POST['comment'] ,$allowed_html ));
            }
        } 

        $message    =   '';
        $propid     =   intval($_POST['propid']);
        $agent_id   =   intval($_POST['agent_id']);
        
        $schedule_mesaj =   '';
        $schedule_hour  =   esc_html($_POST['schedule_hour']);
        $schedule_day   =   esc_html($_POST['schedule_day']);
        
        if($schedule_hour!='' && $schedule_day!=''){
            $schedule_mesaj = sprintf (__('I would like to schedule a viewing on %s at %s. Please confirm the meeting via email or private message. ','wpestate'),$schedule_day,$schedule_hour);
        }
//        if($agent_id!=0){
//           wpestate_insert_calendar($agent_id,$name,$email,$phone,$schedule_day,$schedule_hour);
//        }
        $author_id = '';
        if($propid!=0){
            $permalink  = get_permalink(  $propid );
              
            if($agent_id!=0){
                $receiver_email= esc_html( get_post_meta($agent_id, 'agent_email', true) );
            }else{
                $the_post       =   get_post( $propid); 
                $author_id      =   $the_post->post_author;
                $receiver_email =   get_the_author_meta( 'user_email' ,$author_id ); 
              
            }
        }else if($agent_id!=0){
            $permalink      =   get_permalink(  $agent_id );
            $receiver_email =   esc_html( get_post_meta($agent_id, 'agent_email', true) );
        }else{
            $permalink      =   'contact page';
            $receiver_email =   esc_html( get_option('wp_estate_email_adr', ''));
        }
        
      
     
        
        
        $message    .=  __('Client Name','wpestate').": " . $name . "\n\n ".__('Email','wpestate').": " . $email . " \n\n ".__('Phone','wpestate').": " . $phone . " \n\n ".__('Subject','wpestate').": " . $subject . " \n\n".__('Message','wpestate').": \n " . $comment;
        $message    .=  "\n\n".__('Message sent from ','wpestate').$permalink;
        if($schedule_mesaj!=''){
            $message .="\n\n".$schedule_mesaj;
        }
        
        
        
        $headers    =   'From: No Reply <noreply@'.$_SERVER['HTTP_HOST'].'>' . "\r\n";
        $message    =   stripslashes($message);
        $mail                       =  @wp_mail($receiver_email, $subject, $message, $headers);
        $duplicate_email_adr        =   esc_html ( get_option('wp_estate_duplicate_email_adr','') );
        
        if( $duplicate_email_adr!='' ){
            $message = $message.' '.__('Message was also sent to ','wpestate').$receiver_email.'.';
            wp_mail($duplicate_email_adr, $subject, $message, $headers);
        }
        
        if($propid!=0){
            $agents_secondary   =   get_post_meta($propid, 'property_agent_secondary', true);
            foreach($agents_secondary  as $key=>$value){
                $receiver_email= esc_html( get_post_meta($value, 'agent_email', true) );
                wp_mail($receiver_email, $subject, $message, $headers);
            }
        
        }
          
          
       
        $from   =   $userID;
        $to     =   get_post_meta($agent_id,'user_meda_id',true);
        
        if( intval ($to) ==0 ){
            $to = $author_id;
        }
      
        $subject_new =  __('New Message on ','wpestate') . home_url() ;
        $description =  $message;
        wpestate_add_to_inbox($userID,$from,$to,$subject_new,$description,1);
     
        $response=__('The message was sent. You will be able to see any reply in your inbox page ! ','wpestate');
        if( $schedule_mesaj!=''){
            $response.=' '.__('Your showing request will be confirmed via email or private message.','wpestate');
        }  
        echo json_encode(array('sent'=>true, 'response'=>$response) ); 

        die(); 
        
        
}

endif; // end   wpestate_ajax_agent_contact_form 

if(!function_exists('wpestate_increment_mess_mo')):
    function wpestate_increment_mess_mo($userID){
        $unread =   intval ( get_user_meta($userID,'unread_mess',true) +1);
        update_user_meta($userID,'unread_mess',$unread);
    }
endif;



if( !function_exists('wpestate_add_to_inbox') ):
    function wpestate_add_to_inbox($userID,$from,$to,$subject,$description,$first_content=''){
    
        if($subject!=''){
            $subject = $subject.' '.$from;
        }else{
            $subject = esc_html__( 'Message from ','wpestate').$from;
        }
        
        
        $user = get_user_by( 'id',$from );
       
        $post = array(
            'post_title'	=> esc_html__( 'Message from ','wpestate').$user->user_login,
            'post_content'	=> $description,
            'post_status'	=> 'publish', 
            'post_type'         => 'wpestate_message' ,
            'post_author'       => $userID
        );
        $post_id =  wp_insert_post($post );  
        update_post_meta($post_id, 'mess_status', 'new' );
        update_post_meta($post_id, 'message_from_user', $from );
        update_post_meta($post_id, 'message_to_user', $to );   
        wpestate_increment_mess_mo($to);
        update_post_meta($post_id, 'delete_destination'.$from,0  );
        update_post_meta($post_id, 'delete_destination'.$to, 0 );     
        update_post_meta($post_id, 'message_status', 'unread');
        update_post_meta($post_id, 'delete_source', 0);
        update_post_meta($post_id, 'delete_destination', 0);  
        if($first_content!=''){
            update_post_meta($post_id, 'first_content', 1);  
            update_post_meta($post_id, 'message_status'.$to, 'unread' );           
        }
    }
endif;
?>