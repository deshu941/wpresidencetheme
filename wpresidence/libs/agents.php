<?php
// register the custom post type
<<<<<<< HEAD
add_action( 'init', 'wpestate_create_agent_type' );
=======
add_action( 'init', 'wpestate_create_agent_type',1);
>>>>>>> 64662fd89bea560852792d7203888072d7452d48

if( !function_exists('wpestate_create_agent_type') ):

function wpestate_create_agent_type() {
<<<<<<< HEAD
register_post_type( 'estate_agent',
		array(
			'labels' => array(
				'name'          => __( 'Agents','wpestate'),
				'singular_name' => __( 'Agent','wpestate'),
				'add_new'       => __('Add New Agent','wpestate'),
                'add_new_item'          =>  __('Add Agent','wpestate'),
                'edit'                  =>  __('Edit' ,'wpestate'),
                'edit_item'             =>  __('Edit Agent','wpestate'),
                'new_item'              =>  __('New Agent','wpestate'),
                'view'                  =>  __('View','wpestate'),
                'view_item'             =>  __('View Agent','wpestate'),
                'search_items'          =>  __('Search Agent','wpestate'),
                'not_found'             =>  __('No Agents found','wpestate'),
                'not_found_in_trash'    =>  __('No Agents found','wpestate'),
                'parent'                =>  __('Parent Agent','wpestate')
			),
		'public' => true,
		'has_archive' => true,
		'rewrite' => array('slug' => 'agents'),
		'supports' => array('title', 'editor', 'thumbnail','comments'),
		'can_export' => true,
		'register_meta_box_cb' => 'wpestate_add_agents_metaboxes',
                 'menu_icon'=> get_template_directory_uri().'/img/agents.png'    
		)
	);
=======
    $rewrites =  get_option('wp_estate_url_rewrites');
    register_post_type( 'estate_agent',
            array(
                    'labels' => array(
                            'name'          => __( 'Agents','wpestate'),
                            'singular_name' => __( 'Agent','wpestate'),
                            'add_new'       => __('Add New Agent','wpestate'),
            'add_new_item'          =>  __('Add Agent','wpestate'),
            'edit'                  =>  __('Edit' ,'wpestate'),
            'edit_item'             =>  __('Edit Agent','wpestate'),
            'new_item'              =>  __('New Agent','wpestate'),
            'view'                  =>  __('View','wpestate'),
            'view_item'             =>  __('View Agent','wpestate'),
            'search_items'          =>  __('Search Agent','wpestate'),
            'not_found'             =>  __('No Agents found','wpestate'),
            'not_found_in_trash'    =>  __('No Agents found','wpestate'),
            'parent'                =>  __('Parent Agent','wpestate')
                    ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => $rewrites[6]),
            'supports' => array('title', 'editor', 'thumbnail','comments','excerpt'),
            'can_export' => true,
            'register_meta_box_cb' => 'wpestate_add_agents_metaboxes',
             'menu_icon'=> get_template_directory_uri().'/img/agents.png'    
            )
    );
    // add custom taxonomy
   
    // add custom taxonomy
    register_taxonomy('property_category_agent', array('estate_agent'), array(
        'labels' => array(
            'name'              => __('Agent Categories','wpestate'),
            'add_new_item'      => __('Add New Agent Category','wpestate'),
            'new_item_name'     => __('New Agent Category','wpestate')
        ),
        'hierarchical'  => true,
        'query_var'     => true,
        'rewrite'       => array( 'slug' => $rewrites[7] )
        )
    );


    
    register_taxonomy('property_action_category_agent', 'estate_agent', array(
        'labels' => array(
            'name'              => __('Agent Action Categories','wpestate'),
            'add_new_item'      => __('Add New Agent Action','wpestate'),
            'new_item_name'     => __('New Agent Action','wpestate')
        ),
        'hierarchical'  => true,
        'query_var'     => true,
        'rewrite'       => array( 'slug' => $rewrites[8] )
       )      
    );



    // add custom taxonomy
    register_taxonomy('property_city_agent','estate_agent', array(
        'labels' => array(
            'name'              => __('Agent City','wpestate'),
            'add_new_item'      => __('Add New Agent City','wpestate'),
            'new_item_name'     => __('New Agent City','wpestate')
        ),
        'hierarchical'  => true,
        'query_var'     => true,
        'rewrite'       => array( 'slug' => $rewrites[9],'with_front' => false)
        )
    );




    // add custom taxonomy
    register_taxonomy('property_area_agent', 'estate_agent', array(
        'labels' => array(
            'name'              => __('Agent Neighborhood','wpestate'),
            'add_new_item'      => __('Add New Agent Neighborhood','wpestate'),
            'new_item_name'     => __('New Agent Neighborhood','wpestate')
        ),
        'hierarchical'  => true,
        'query_var'     => true,
        'rewrite'       => array( 'slug' => $rewrites[10] )

        )
    );

    // add custom taxonomy
    register_taxonomy('property_county_state_agent', array('estate_agent'), array(
        'labels' => array(
            'name'              => __('Agent County / State','wpestate'),
            'add_new_item'      => __('Add New Agent County / State','wpestate'),
            'new_item_name'     => __('New Agent County / State','wpestate')
        ),
        'hierarchical'  => true,
        'query_var'     => true,
        'rewrite'       => array( 'slug' =>  $rewrites[11] )

        )
    );
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
}
endif; // end   wpestate_create_agent_type  


////////////////////////////////////////////////////////////////////////////////////////////////
// Add agent metaboxes
////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_add_agents_metaboxes') ):
function wpestate_add_agents_metaboxes() {	
  add_meta_box(  'estate_agent-sectionid', __( 'Agent Settings', 'wpestate' ), 'estate_agent', 'estate_agent' ,'normal','default');
}
endif; // end   wpestate_add_agents_metaboxes  



////////////////////////////////////////////////////////////////////////////////////////////////
// Agent details
////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('estate_agent') ):
function estate_agent( $post ) {
    wp_nonce_field( plugin_basename( __FILE__ ), 'estate_agent_noncename' );
    global $post;

<<<<<<< HEAD
    print'
    <p class="meta-options">
    <label for="agent_position">'.__('Position:','wpestate').' </label><br />
    <input type="text" id="agent_position" size="58" name="agent_position" value="'.  esc_html(get_post_meta($post->ID, 'agent_position', true)).'">
    </p>

    <p class="meta-options">
    <label for="agent_email">'.__('Email:','wpestate').' </label><br />
    <input type="text" id="agent_email" size="58" name="agent_email" value="'.  esc_html(get_post_meta($post->ID, 'agent_email', true)).'">
    </p>

    <p class="meta-options">
    <label for="agent_phone">'.__('Phone: ','wpestate').'</label><br />
    <input type="text" id="agent_phone" size="58" name="agent_phone" value="'.  esc_html(get_post_meta($post->ID, 'agent_phone', true)).'">
    </p>

    <p class="meta-options">
    <label for="agent_mobile">'.__('Mobile:','wpestate').' </label><br />
    <input type="text" id="agent_mobile" size="58" name="agent_mobile" value="'.  esc_html(get_post_meta($post->ID, 'agent_mobile', true)).'">
    </p>

    <p class="meta-options">
    <label for="agent_skype">'.__('Skype: ','wpestate').'</label><br />
    <input type="text" id="agent_skype" size="58" name="agent_skype" value="'.  esc_html(get_post_meta($post->ID, 'agent_skype', true)).'">
    </p>
    
                
    <p class="meta-options">
    <label for="agent_facebook">'.__('Facebook: ','wpestate').'</label><br />
    <input type="text" id="agent_facebook" size="58" name="agent_facebook" value="'.  esc_html(get_post_meta($post->ID, 'agent_facebook', true)).'">
    </p>
    
    <p class="meta-options">
    <label for="agent_twitter">'.__('Twitter: ','wpestate').'</label><br />
    <input type="text" id="agent_twitter" size="58" name="agent_twitter" value="'.  esc_html(get_post_meta($post->ID, 'agent_twitter', true)).'">
    </p>
    
    <p class="meta-options">
    <label for="agent_linkedin">'.__('Linkedin: ','wpestate').'</label><br />
    <input type="text" id="agent_linkedin" size="58" name="agent_linkedin" value="'.  esc_html(get_post_meta($post->ID, 'agent_linkedin', true)).'">
    </p>
    
    <p class="meta-options">
    <label for="agent_pinterest">'.__('Pinterest: ','wpestate').'</label><br />
    <input type="text" id="agent_pinterest" size="58" name="agent_pinterest" value="'.  esc_html(get_post_meta($post->ID, 'agent_pinterest', true)).'">
    </p>
    
    <p class="meta-options">
        <label for="agent_website">'.__('Website (without http): ','wpestate').'</label><br />
        <input type="text" id="agent_website" size="58" name="agent_website" value="'.  esc_html(get_post_meta($post->ID, 'agent_website', true)).'">
    </p>
    ';            
=======


    print'
    <p class="meta-options third-meta-options">
    <label for="agent_position third-meta-options">'.__('Agent First Name:','wpestate').' </label><br />
    <input type="text" id="first_name"  name="first_name" value="'.  esc_html(get_post_meta($post->ID, 'first_name', true)).'">
    </p> 
    
    <p class="meta-options third-meta-options">
    <label for="agent_position third-meta-options">'.__('Agent Last Name:','wpestate').' </label><br />
    <input type="text" id="last_name"  name="last_name" value="'.  esc_html(get_post_meta($post->ID, 'last_name', true)).'">
    </p>
    

    <p class="meta-options third-meta-options">
    <label for="agent_position third-meta-options">'.__('Position:','wpestate').' </label><br />
    <input type="text" id="agent_position"  name="agent_position" value="'.  esc_html(get_post_meta($post->ID, 'agent_position', true)).'">
    </p>

    <p class="meta-options third-meta-options">
    <label for="agent_email">'.__('Email:','wpestate').' </label><br />
    <input type="text" id="agent_email" name="agent_email" value="'.  esc_html(get_post_meta($post->ID, 'agent_email', true)).'">
    </p>

    <p class="meta-options third-meta-options">
    <label for="agent_phone">'.__('Phone: ','wpestate').'</label><br />
    <input type="text" id="agent_phone" name="agent_phone" value="'.  esc_html(get_post_meta($post->ID, 'agent_phone', true)).'">
    </p>

    <p class="meta-options third-meta-options">
    <label for="agent_mobile">'.__('Mobile:','wpestate').' </label><br />
    <input type="text" id="agent_mobile" name="agent_mobile" value="'.  esc_html(get_post_meta($post->ID, 'agent_mobile', true)).'">
    </p>

    <p class="meta-options third-meta-options">
    <label for="agent_skype">'.__('Skype: ','wpestate').'</label><br />
    <input type="text" id="agent_skype"  name="agent_skype" value="'.  esc_html(get_post_meta($post->ID, 'agent_skype', true)).'">
    </p>
    
    <p class="meta-options third-meta-options">
    <label for="agent_member">'.__('Member of: ','wpestate').'</label><br />
    <input type="text" id="agent_member"  name="agent_member" value="'.  esc_html(get_post_meta($post->ID, 'agent_member', true)).'">
    </p>
                
    <p class="meta-options third-meta-options">
    <label for="agent_facebook">'.__('Facebook: ','wpestate').'</label><br />
    <input type="text" id="agent_facebook"  name="agent_facebook" value="'.  esc_html(get_post_meta($post->ID, 'agent_facebook', true)).'">
    </p>
    
    <p class="meta-options third-meta-options">
    <label for="agent_twitter">'.__('Twitter: ','wpestate').'</label><br />
    <input type="text" id="agent_twitter"  name="agent_twitter" value="'.  esc_html(get_post_meta($post->ID, 'agent_twitter', true)).'">
    </p>
    
    <p class="meta-options third-meta-options">
    <label for="agent_linkedin">'.__('Linkedin: ','wpestate').'</label><br />
    <input type="text" id="agent_linkedin"  name="agent_linkedin" value="'.  esc_html(get_post_meta($post->ID, 'agent_linkedin', true)).'">
    </p>
    
    <p class="meta-options third-meta-options">
    <label for="agent_pinterest">'.__('Pinterest: ','wpestate').'</label><br />
    <input type="text" id="agent_pinterest"  name="agent_pinterest" value="'.  esc_html(get_post_meta($post->ID, 'agent_pinterest', true)).'">
    </p>
    
    <p class="meta-options third-meta-options">
    <label for="agent_instagram">'.__('Instagram: ','wpestate').'</label><br />
    <input type="text" id="agent_instagram"  name="agent_instagram" value="'.  esc_html(get_post_meta($post->ID, 'agent_instagram', true)).'">
    </p>



    <p class="meta-options third-meta-options">
        <label for="agent_website">'.__('Website (without http): ','wpestate').'</label><br />
        <input type="text" id="agent_website"  name="agent_website" value="'.  esc_html(get_post_meta($post->ID, 'agent_website', true)).'">
    </p>
    

    <p class="meta-options third-meta-options">
        <label for="user_meda_id">'.__('The user id for this profile: ','wpestate').'</label><br />
        <input type="text" id="user_meda_id"  name="user_meda_id" value="'. intval( get_post_meta($post->ID, 'user_meda_id',true ) ).'">
    </p>';
    $author = get_post_field( 'post_author', $post->ID) ;
    $agency_post = get_the_author_meta('user_agent_id',$author);
    print'
    <p class="meta-options third-meta-options">
        <label for="owner_author_id">'.__('The Agency id/Developer USER ID that has this agent: ','wpestate').'</label><br />
        <strong>'.__('Current Agency/Developer','wpestate').':</strong>'.get_the_title($agency_post).'</br>
        <input type="text" id="owner_author_id"  name="owner_author_id" value="'. $author.'">
    </p>
    

    '; 
    
    
    print '<div class="add_custom_data_cont">
            <div class="">'.__('Agent Custom fields','wpestate').'</div>
            <div class="">
                 <p class="meta-options third-meta-options">
                      <input type="button" class="button-primary add_custom_parameter" value="'.__('Add Custom Field','wpestate').'"   >
                  </p>
            </div>';
			
			
			  print '  
				<div class="single_parameter_row cliche_row">      
				<div class="meta-options third-meta-options">
					<label for="agent_custom_label">'.__('Field Label: ','wpestate').'</label><br />
					<input type="text" name="agent_custom_label[]" value="">
				</div>
				<div class="meta-options third-meta-options">
					<label for="agent_custom_value">'.__('Field Value: ','wpestate').'</label><br />
					<input type="text" name="agent_custom_value[]" value="">
				</div>
				<div class="meta-options third-meta-options">
					<label for="agent_website">&nbsp;</label><br />
					<input type="button" class="button-primary remove_parameter_button" value="'.__('Remove','wpestate').'"   >
				</div>
				</div>
				';
			
			
    $agent_custom_data = get_post_meta( $post->ID, 'agent_custom_data', true );
	
  
  
    if( count( $agent_custom_data )  > 0  && is_array( $agent_custom_data) ){
		for( $i=0; $i<count( $agent_custom_data ); $i++ ){
		print '  
		<div class="single_parameter_row  ">      
		<div class="meta-options third-meta-options">
			<label for="agent_website">'.__('Field Label: ','wpestate').'</label><br />
			<input type="text"   name="agent_custom_label[]" value="'.  esc_html( $agent_custom_data[$i]['label'] ).'">
		</div>
		<div class="meta-options third-meta-options">
			<label for="agent_website">'.__('Field Value: ','wpestate').'</label><br />
			<input type="text"    name="agent_custom_value[]" value="'.  esc_html( $agent_custom_data[$i]['value'] ).'">
		</div>
		<div class="meta-options third-meta-options">
			<label for="agent_website">&nbsp;</label><br />
			<input type="button" class="button-primary remove_parameter_button" value="'.__('Remove','wpestate').'"   >
		</div>
		</div>
		';
		
		
		}
    }        
  
            
  
    print '</div>';           
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
}
endif; // end   estate_agent  




add_action('save_post', 'wpsx_5688_update_post', 1, 2);

if( !function_exists('wpsx_5688_update_post') ):
function wpsx_5688_update_post($post_id,$post){
<<<<<<< HEAD
    
    if(!is_object($post) || !isset($post->post_type)) {
        return;
    }
    
     if($post->post_type!='estate_agent'){
        return;    
     }
     
     if( !isset($_POST['agent_email']) ){
         return;
     }
     if('yes' ==  esc_html ( get_option('wp_estate_user_agent','') )){  
            $allowed_html   =   array();
=======
   
    if(!is_object($post) || !isset($post->post_type)) {
        return;
    }
  
    if($post->post_type!='estate_agent'){
       return;    
    }

    if( !isset($_POST['agent_email']) ){
        return;
    }
     
    if( isset($_POST['owner_author_id']) ){
        remove_action('save_post', 'estate_save_postdata', 1, 2);
        remove_action('save_post', 'wpsx_5688_update_post', 1, 2);
        
        $old_author =   get_post_field( 'post_author', $post->ID) ;
        $new_author =   intval($_POST['owner_author_id']);
        $agent_id = intval( get_post_meta($post->ID, 'user_meda_id',true ) );
        //echo  $agent_id.'$old_authocccr '.$old_author.' / '.$new_author;
      
        //$agency_post = get_the_author_meta('user_agent_id',$author);
        if( $old_author != $new_author){
            $arg = array(
                'ID'            => $post_id,
                'post_author'   => $new_author,
            );
            wp_update_post( $arg );
        
            // remove from old agency
            $current_agent_list=(array)get_user_meta($old_author,'current_agent_list',true) ;
            $agent_list=array();
            if(is_array($current_agent_list)){
                $agent_list     = array_unique ( $current_agent_list );
            }
            
            if (is_array($agent_list) && ($key = array_search($agent_id, $agent_list)) !== false) {
                unset($agent_list[$key]);
            }
            
            if(is_array($agent_list)){
               $agent_list= array_unique($agent_list);
            }
            
            update_user_meta($old_author,'current_agent_list',$agent_list);
            
        
            $agent_list     =    ((array) get_user_meta($new_author,'current_agent_list',true) );
            if(is_array($agent_list)){
               $agent_list= array_unique($agent_list);
            }
            $agent_list[]   =   $agent_id;
     
            update_user_meta($new_author,'current_agent_list',array_unique($agent_list) );
        }

        
        add_action('save_post', 'estate_save_postdata', 1, 2);
        add_action('save_post', 'wpsx_5688_update_post', 1, 2);
        
        
    }
    
    
    if('yes' ==  'yes' ){  
            $allowed_html   =   array();
            $first_name    = wp_kses($_POST['first_name'],$allowed_html);
            $last_name    = wp_kses($_POST['last_name'],$allowed_html);
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
            $user_id    = get_post_meta($post_id, 'user_meda_id', true);
            $email      = wp_kses($_POST['agent_email'],$allowed_html);
            $phone      = wp_kses($_POST['agent_phone'],$allowed_html);
            $skype      = wp_kses($_POST['agent_skype'],$allowed_html);
            $position   = wp_kses($_POST['agent_position'],$allowed_html);
            $mobile     = wp_kses($_POST['agent_mobile'],$allowed_html);
            $desc       = wp_kses($_POST['content'],$allowed_html);
            $image_id   = get_post_thumbnail_id($post_id);
<<<<<<< HEAD
            $full_img   = wp_get_attachment_image_src($image_id, 'agent_picture_single_page');           
=======
            $full_img   = wp_get_attachment_image_src($image_id, 'property_listings');           
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
            $facebook   = wp_kses($_POST['agent_facebook'],$allowed_html);
            $twitter    = wp_kses($_POST['agent_twitter'],$allowed_html);
            $linkedin   = wp_kses($_POST['agent_linkedin'],$allowed_html);
            $pinterest  = wp_kses($_POST['agent_pinterest'],$allowed_html);
<<<<<<< HEAD
            $agent_website  = wp_kses($_POST['agent_website'],$allowed_html);
=======
            $instagram  = wp_kses($_POST['agent_instagram'],$allowed_html);
            $agent_website  = wp_kses($_POST['agent_website'],$allowed_html);
            $agent_member    = wp_kses($_POST['agent_member'],$allowed_html);
			
            $agent_custom_label    = wp_kses($_POST['agent_custom_label'],$allowed_html);
            $agent_custom_value    = wp_kses($_POST['agent_custom_value'],$allowed_html);
            
			// prcess fields data
			$agent_fields_array = array();
			for( $i=1; $i<count( $agent_custom_label  ); $i++ ){
				$agent_fields_array[] = array( 'label' => sanitize_text_field($agent_custom_label[$i] ), 'value' => sanitize_text_field($agent_custom_value[$i] ) );
			}
            //update_post_meta($user_id, 'agent_custom_data',   $agent_fields_array);
            update_post_meta($post_id, 'agent_custom_data',   $agent_fields_array);
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
            
            update_user_meta( $user_id, 'aim', '/'.$full_img[0].'/') ;
            update_user_meta( $user_id, 'phone' , $phone) ;
            update_user_meta( $user_id, 'mobile' , $mobile) ;
            update_user_meta( $user_id, 'description' , $desc) ;
            update_user_meta( $user_id, 'skype' , $skype) ;
            update_user_meta( $user_id, 'title', $position) ;
            update_user_meta( $user_id, 'custom_picture', $full_img[0]) ;
            update_user_meta( $user_id, 'facebook', $facebook) ;
            update_user_meta( $user_id, 'twitter', $twitter) ;
            update_user_meta( $user_id, 'linkedin', $linkedin) ;
            update_user_meta( $user_id, 'pinterest', $pinterest) ;
<<<<<<< HEAD
            update_user_meta( $user_id, 'website', $agent_website) ;
             
            update_user_meta( $user_id, 'small_custom_picture', $image_id) ;
           
=======
            update_user_meta( $user_id, 'instagram', $instagram) ;
            update_user_meta( $user_id, 'website', $agent_website) ;
            update_user_meta( $user_id, 'agent_member', $agent_member) ;
            update_user_meta( $user_id, 'small_custom_picture', $image_id) ;
            update_user_meta( $user_id, 'first_name', $first_name) ;
            update_user_meta( $user_id, 'last_name', $last_name) ;
            
            // custom fields for agent cf reprocess
            
            
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
            $new_user_id    =   email_exists( $email ) ;
            if ( $new_user_id){
             //   _e('The email was not saved because it is used by another user.</br>','wpestate');
            } else{
                $args = array(
                     'ID'         => $user_id,
                     'user_email' => $email
                ); 
                wp_update_user( $args );
            } 
    }//end if
}
endif;
<<<<<<< HEAD
=======




add_filter( 'manage_edit-estate_agent_columns', 'wpestate_my_columns_agent' );

if( !function_exists('wpestate_my_columns_agent') ):
function wpestate_my_columns_agent( $columns ) {
    $slice=array_slice($columns,2,2);
    unset( $columns['comments'] );
    unset( $slice['comments'] );
    $splice=array_splice($columns, 2);
    $columns['estate_ID']               = __('ID','wpestate');
    $columns['estate_agent_thumb']      = __('Image','wpestate');
    $columns['estate_agent_city']       = __('City','wpestate');
    $columns['estate_agent_action']     = __('Action','wpestate');
    $columns['estate_agent_category']   = __( 'Category','wpestate');
    $columns['estate_agent_email']      = __('Email','wpestate');
    $columns['estate_agent_phone']      = __('Phone','wpestate');

    return  array_merge($columns,array_reverse($slice));
}
endif; // end   wpestate_my_columns  


$restrict_manage_posts = function($post_type, $taxonomy) {
    return function() use($post_type, $taxonomy) {
        global $typenow;

        if($typenow == $post_type) {
            $selected = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
            $info_taxonomy = get_taxonomy($taxonomy);

            wp_dropdown_categories(array(
                'show_option_all'   => __("Show All {$info_taxonomy->label}"),
                'taxonomy'          => $taxonomy,
                'name'              => $taxonomy,
                'orderby'           => 'name',
                'selected'          => $selected,
                'show_count'        => TRUE,
                'hide_empty'        => TRUE,
                'hierarchical'      => true
            ));

        }

    };

};

$parse_query = function($post_type, $taxonomy) {

    return function($query) use($post_type, $taxonomy) {
        global $pagenow;

        $q_vars = &$query->query_vars;

        if( $pagenow == 'edit.php'
            && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type
            && isset($q_vars[$taxonomy])
            && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0
        ) {
            $term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
            $q_vars[$taxonomy] = $term->slug;
        }

    };

};

add_action('restrict_manage_posts', $restrict_manage_posts('estate_agent', 'property_category_agent') );
add_filter('parse_query', $parse_query('estate_agent', 'property_category_agent') );


add_action('restrict_manage_posts', $restrict_manage_posts('estate_agent', 'property_action_category_agent') );
add_filter('parse_query', $parse_query('estate_agent', 'property_action_category_agent') );


add_action('restrict_manage_posts', $restrict_manage_posts('estate_agent', 'property_city_agent') );
add_filter('parse_query', $parse_query('estate_agent', 'property_city_agent') );


>>>>>>> 64662fd89bea560852792d7203888072d7452d48
?>