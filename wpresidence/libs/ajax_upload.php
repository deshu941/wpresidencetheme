<?php
<<<<<<< HEAD

add_action('wp_ajax_me_upload',             'me_upload');
add_action('wp_ajax_aaiu_delete',           'me_delete_file');
add_action('wp_ajax_nopriv_me_upload',      'me_upload');
add_action('wp_ajax_nopriv_aaiu_delete',    'me_delete_file');

if( !function_exists('me_delete_file') ):
    function me_delete_file(){
        $attach_id = intval($_POST['attach_id']);
=======
add_action('wp_ajax_wpestate_image_caption',  'wpestate_image_caption');
if( !function_exists('wpestate_image_caption') ):
    function wpestate_image_caption(){
       
        $current_user   =   wp_get_current_user();
        $userID         =   $current_user->ID;
      
        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }
     
        
        $attach_id  =   intval($_POST['attach_id']);
        $caption    =   esc_html($_POST['caption']);
        $the_post   =   get_post( $attach_id); 
        $agent_list                     =  (array) get_user_meta($userID,'current_agent_list',true);
        
        
        echo $attach_id.'////'.$userID .' / '.$the_post->post_author;
        if (!current_user_can('manage_options') ){
            if( $userID != $the_post->post_author  &&  !in_array($the_post->post_author , $agent_list)) {
                exit('you don\'t have the right to edit this');;
            }
        }
        $my_post = array(
            'ID'           => $attach_id,
            'post_excerpt' => $caption,
        );

      // Update the post into the database
        wp_update_post( $my_post );

        exit;
    }
endif;


add_action('wp_ajax_nopriv_wpestate_me_upload',             'wpestate_me_upload');
add_action('wp_ajax_wpestate_me_upload',             'wpestate_me_upload');
add_action('wp_ajax_aaiu_delete',           'me_delete_file');
add_action('wp_ajax_wpestate_delete_file',  'wpestate_delete_file');


if( !function_exists('wpestate_delete_file') ):
    function wpestate_delete_file(){
       
        $current_user   =   wp_get_current_user();
        $userID         =   $current_user->ID;
      
        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }
     
        
        $attach_id  = intval($_POST['attach_id']);
        $the_post   = get_post( $attach_id); 

        if (!current_user_can('manage_options') ){
            if( $userID != $the_post->post_author ) {
                exit('you don\'t have the right to delete this');;
            }
        }
        
        wp_delete_attachment($attach_id, true);
        exit;
    }
endif;


if( !function_exists('me_delete_file') ):
    function me_delete_file(){
   
        $current_user   =   wp_get_current_user();
        $userID         =   $current_user->ID;
       
        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }
        
        
        $attach_id  =   intval($_POST['attach_id']);
        $the_post   =   get_post( $attach_id); 

        if( $current_user->ID != $the_post->post_author ) {
            exit('you don\'t have the right to delete this');;
        }
        
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        wp_delete_attachment($attach_id, true);
        exit;
    }
endif;




<<<<<<< HEAD

if( !function_exists('me_upload') ):
    function me_upload(){
        $file = array(
            'name'      => $_FILES['aaiu_upload_file']['name'],
            'type'      => $_FILES['aaiu_upload_file']['type'],
            'tmp_name'  => $_FILES['aaiu_upload_file']['tmp_name'],
            'error'     => $_FILES['aaiu_upload_file']['error'],
            'size'      => $_FILES['aaiu_upload_file']['size']
=======
if( !function_exists('wpestate_me_upload') ):
    function wpestate_me_upload(){
        $current_user   =   wp_get_current_user();
        $userID         =   $current_user->ID;
//    
//        if ( !is_user_logged_in() ) {   
//            exit('ko');
//        }
//        if($userID === 0 ){
//            exit('out pls');
//        }
        
        $filename       =   convertAccentsAndSpecialToNormal($_FILES['aaiu_upload_file']['tmp_name']);
        $base           =   '';
        $allowed_html   =   array();
        
        list($width, $height) = getimagesize($filename);
        
        if(isset($_GET['base'])){
            $base   =   esc_html( wp_kses( $_GET['base'], $allowed_html ) );
        }
        
        $file = array(
            'name'      => convertAccentsAndSpecialToNormal($_FILES['aaiu_upload_file']['name']),
            'type'      => $_FILES['aaiu_upload_file']['type'],
            'tmp_name'  => $_FILES['aaiu_upload_file']['tmp_name'],
            'error'     => $_FILES['aaiu_upload_file']['error'],
            'size'      => $_FILES['aaiu_upload_file']['size'],
            'width'     =>  $width,
            'height'    =>  $height,
            'base'      =>  $base
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        );
        $file = fileupload_process($file);
    }  
endif;    
    



    
if( !function_exists('fileupload_process') ):
    function fileupload_process($file){

<<<<<<< HEAD
        $attachment = handle_file($file);

        if (is_array($attachment)) {
            $html = getHTML($attachment);

            $response = array(
                'success'   => true,
                'html'      => $html,
                'attach'    => $attachment['id']
            );

            echo json_encode($response);
            exit;
        }

        $response = array('success' => false);
        echo json_encode($response);
        exit;
    }
=======
    
        
    if( $file['type']!='application/pdf'    ){
        if( intval($file['height'])<500 || intval($file['width']) <500 ){
            $response = array('success' => false,'image'=>true);
            echo json_encode($response);
            exit;
        }
    }
        
  
    
    $attachment = handle_file($file);

    if (is_array($attachment)) {
        $html = getHTML($attachment);

        $response = array(
            'base' =>  $file['base'],
            'type'      =>  $file['type'],
            'height'      =>  $file['height'],
            'width'      =>  $file['width'],
            'success'   => true,
            'html'      => $html,
            'attach'    => $attachment['id'],


        );

        echo json_encode($response);
        exit;
    }

    $response = array('success' => false);
    echo json_encode($response);
    exit;
    }
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
endif;




if( !function_exists('handle_file') ):   
    function handle_file($upload_data){
        $return = false;
<<<<<<< HEAD
=======
        
        
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        $uploaded_file = wp_handle_upload($upload_data, array('test_form' => false));

        if (isset($uploaded_file['file'])) {
            $file_loc   =   $uploaded_file['file'];
            $file_name  =   basename($upload_data['name']);
            $file_type  =   wp_check_filetype($file_name);

            $attachment = array(
<<<<<<< HEAD
                'post_mime_type' => $file_type['type'],
                'post_title' => preg_replace('/\.[^.]+$/', '', basename($file_name)),
                'post_content' => '',
                'post_status' => 'inherit'
=======
                'post_mime_type'    => $file_type['type'],
                'post_title'        => preg_replace('/\.[^.]+$/', '', basename($file_name)),
                'post_content'      => '',
                'post_status'       => 'inherit'
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
            );

            $attach_id      =   wp_insert_attachment($attachment, $file_loc);
            $attach_data    =   wp_generate_attachment_metadata($attach_id, $file_loc);
            wp_update_attachment_metadata($attach_id, $attach_data);

            $return = array('data' => $attach_data, 'id' => $attach_id);

            return $return;
        }

        return $return;
    }
endif;    
    


if( !function_exists('getHTML') ):   
    function getHTML($attachment){
        $attach_id  =   $attachment['id'];
<<<<<<< HEAD
        $file='';
        $html='';
=======
        $file       =   '';
        $html       =   '';
>>>>>>> 64662fd89bea560852792d7203888072d7452d48

        if( isset($attachment['data']['file'])){
            $file       =   explode('/', $attachment['data']['file']);
            $file       =   array_slice($file, 0, count($file) - 1);
<<<<<<< HEAD
             $path       =   implode('/', $file);
=======
            $path       =   implode('/', $file);
>>>>>>> 64662fd89bea560852792d7203888072d7452d48

            if(is_page_template('user_dashboard_add.php') ){
                $image      =   $attachment['data']['sizes']['thumbnail']['file'];
            }else{
<<<<<<< HEAD
                 $image      =   $attachment['data']['sizes']['user_picture_profile']['file'];
=======
                $image      =   $attachment['data']['sizes']['user_picture_profile']['file'];
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
            }
            $post       =   get_post($attach_id);
            $dir        =   wp_upload_dir();
            $path       =   $dir['baseurl'] . '/' . $path;
            $html       =   '';
<<<<<<< HEAD
                global $current_user;
            get_currentuserinfo();
=======
            $current_user = wp_get_current_user();
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
            $userID  =   $current_user->ID;
            $html   .=   $path.'/'.$image; 

        }



        return $html;
    }
endif;
?>