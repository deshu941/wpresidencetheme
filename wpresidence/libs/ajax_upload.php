<?php

add_action('wp_ajax_me_upload',             'me_upload');
add_action('wp_ajax_aaiu_delete',           'me_delete_file');
add_action('wp_ajax_nopriv_me_upload',      'me_upload');
add_action('wp_ajax_nopriv_aaiu_delete',    'me_delete_file');

if( !function_exists('me_delete_file') ):
    function me_delete_file(){
        $attach_id = intval($_POST['attach_id']);
        wp_delete_attachment($attach_id, true);
        exit;
    }
endif;





if( !function_exists('me_upload') ):
    function me_upload(){
        $file = array(
            'name'      => $_FILES['aaiu_upload_file']['name'],
            'type'      => $_FILES['aaiu_upload_file']['type'],
            'tmp_name'  => $_FILES['aaiu_upload_file']['tmp_name'],
            'error'     => $_FILES['aaiu_upload_file']['error'],
            'size'      => $_FILES['aaiu_upload_file']['size']
        );
        $file = fileupload_process($file);
    }  
endif;    
    



    
if( !function_exists('fileupload_process') ):
    function fileupload_process($file){

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
endif;




if( !function_exists('handle_file') ):   
    function handle_file($upload_data){
        $return = false;
        $uploaded_file = wp_handle_upload($upload_data, array('test_form' => false));

        if (isset($uploaded_file['file'])) {
            $file_loc   =   $uploaded_file['file'];
            $file_name  =   basename($upload_data['name']);
            $file_type  =   wp_check_filetype($file_name);

            $attachment = array(
                'post_mime_type' => $file_type['type'],
                'post_title' => preg_replace('/\.[^.]+$/', '', basename($file_name)),
                'post_content' => '',
                'post_status' => 'inherit'
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
        $file='';
        $html='';

        if( isset($attachment['data']['file'])){
            $file       =   explode('/', $attachment['data']['file']);
            $file       =   array_slice($file, 0, count($file) - 1);
             $path       =   implode('/', $file);

            if(is_page_template('user_dashboard_add.php') ){
                $image      =   $attachment['data']['sizes']['thumbnail']['file'];
            }else{
                 $image      =   $attachment['data']['sizes']['user_picture_profile']['file'];
            }
            $post       =   get_post($attach_id);
            $dir        =   wp_upload_dir();
            $path       =   $dir['baseurl'] . '/' . $path;
            $html       =   '';
                global $current_user;
            get_currentuserinfo();
            $userID  =   $current_user->ID;
            $html   .=   $path.'/'.$image; 

        }



        return $html;
    }
endif;
?>