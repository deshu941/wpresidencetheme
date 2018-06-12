<?php
// register the custom post type
add_action( 'init', 'wpestate_create_developer_type',1);

if( !function_exists('wpestate_create_developer_type') ):
    function wpestate_create_developer_type() {
        $rewrites =  get_option('wp_estate_url_rewrites');
        
        $slug='developer';
        if(isset( $rewrites[23])){
            $slug=$rewrites[23];
        }
        register_post_type( 'estate_developer',
                array(
                        'labels' => array(
                                'name'          => __( 'Developer','wpestate'),
                                'singular_name' => __( 'Developer','wpestate'),
                                'add_new'       => __('Add New Developer','wpestate'),
                'add_new_item'          =>  __('Add Developer','wpestate'),
                'edit'                  =>  __('Edit' ,'wpestate'),
                'edit_item'             =>  __('Edit Developer','wpestate'),
                'new_item'              =>  __('New Developer','wpestate'),
                'view'                  =>  __('View','wpestate'),
                'view_item'             =>  __('View Developer','wpestate'),
                'search_items'          =>  __('Search Developer','wpestate'),
                'not_found'             =>  __('No Developer found','wpestate'),
                'not_found_in_trash'    =>  __('No Developer found','wpestate'),
                'parent'                =>  __('Parent Developer','wpestate')
                        ),
                'public' => true,
                'has_archive' => true,
                'rewrite' => array('slug' => $slug),
                'supports' => array('title', 'editor', 'thumbnail','comments','excerpt'),
                'can_export' => true,
                'register_meta_box_cb' => 'wpestate_add_developer_metaboxes',
                 'menu_icon'=> get_template_directory_uri().'/img/developer.png'    
                )
        );
        // add custom taxonomy

        if(!isset($rewrites[17]) || $rewrites[17]==''){
            $property_category_developer    =   'developer-category';
        }else{
            $property_category_developer  =  $rewrites[17];
        }

        
        // add custom taxonomy
        register_taxonomy('property_category_developer', array('estate_developer'), array(
            'labels' => array(
                'name'              => __('Developer Categories','wpestate'),
                'add_new_item'      => __('Add New Developer Category','wpestate'),
                'new_item_name'     => __('New Developer Category','wpestate')
            ),
            'hierarchical'  => true,
            'query_var'     => true,
             'rewrite'       => array( 'slug' => $property_category_developer )
            )
        );


        if(!isset($rewrites[18]) || $rewrites[18]==''){
            $property_action_developer    =   'developer-action-category';
        }else{
            $property_action_developer =  $rewrites[18];
        }


        register_taxonomy('property_action_developer', 'estate_developer', array(
            'labels' => array(
                'name'              => __('Developer Action Categories','wpestate'),
                'add_new_item'      => __('Add New Developer Action','wpestate'),
                'new_item_name'     => __('New Developer Action','wpestate')
            ),
            'hierarchical'  => true,
            'query_var'     => true,
             'rewrite'       => array( 'slug' =>$property_action_developer )
           )      
        );

        if(!isset($rewrites[19]) || $rewrites[19]==''){
            $property_city_developer   =   'developer-city';
        }else{
            $property_city_developer =  $rewrites[19];
        }


        // add custom taxonomy
        register_taxonomy('property_city_developer','estate_developer', array(
            'labels' => array(
                'name'              => __('Developer City','wpestate'),
                'add_new_item'      => __('Add New Developer City','wpestate'),
                'new_item_name'     => __('New Developer City','wpestate')
            ),
            'hierarchical'  => true,
            'query_var'     => true,
             'rewrite'       => array( 'slug' =>    $property_city_developer )
            )
        );


        if(!isset($rewrites[20]) || $rewrites[20]==''){
            $property_area_developer   =   'developer-area';
        }else{
            $property_area_developer =  $rewrites[20];
        }

        // add custom taxonomy
        register_taxonomy('property_area_developer', 'estate_developer', array(
            'labels' => array(
                'name'              => __('Developer Neighborhood','wpestate'),
                'add_new_item'      => __('Add New Developer Neighborhood','wpestate'),
                'new_item_name'     => __('New Developer Neighborhood','wpestate')
            ),
            'hierarchical'  => true,
            'query_var'     => true,
             'rewrite'       => array( 'slug' => $property_area_developer )

            )
        );

        
        
        if(!isset($rewrites[21]) || $rewrites[21]==''){
            $property_county_state_developer   =   'developer-county';
        }else{
            $property_county_state_developer =  $rewrites[21];
        }
        
        // add custom taxonomy
        register_taxonomy('property_county_state_developer', array('estate_developer'), array(
            'labels' => array(
                'name'              => __('Developer County / State','wpestate'),
                'add_new_item'      => __('Add New Developer County / State','wpestate'),
                'new_item_name'     => __('New Developer County / State','wpestate')
            ),
            'hierarchical'  => true,
            'query_var'     => true,
             'rewrite'       => array( 'slug' => $property_county_state_developer )

            )
        );
    }
endif; // end   wpestate_create_developer_type  


////////////////////////////////////////////////////////////////////////////////////////////////
// Add agent metaboxes
////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_add_developer_metaboxes') ):
function wpestate_add_developer_metaboxes() {	
    add_meta_box(  'estate_developer-sectionid', __( 'Developer Settings', 'wpestate' ), 'estate_developer', 'estate_developer' ,'normal','default');
}
endif; // end   wpestate_add_developer_metaboxes  



////////////////////////////////////////////////////////////////////////////////////////////////
// Developer details
////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('estate_developer') ):
    function estate_developer( $post ) {
        wp_nonce_field( plugin_basename( __FILE__ ), 'estate_developer_noncename' );
        global $post;

        print'
        <p class="meta-options third-meta-options">
        <label for="developer_address third-meta-options">'.__('Address:','wpestate').' </label><br />
        <input type="text" id="developer_address"  name="developer_address" value="'.  esc_html(get_post_meta($post->ID, 'developer_address', true)).'">
        </p>


        <p class="meta-options third-meta-options">
        <label for="developer_phone">'.__('Phone: ','wpestate').'</label><br />
        <input type="text" id="developer_phone" name="developer_phone" value="'.  esc_html(get_post_meta($post->ID, 'developer_phone', true)).'">
        </p>

        <p class="meta-options third-meta-options">
        <label for="developer_mobile">'.__('Mobile:','wpestate').' </label><br />
        <input type="text" id="developer_mobile" name="developer_mobile" value="'.  esc_html(get_post_meta($post->ID, 'developer_mobile', true)).'">
        </p>

        <p class="meta-options third-meta-options">
        <label for="developer_skype">'.__('Skype: ','wpestate').'</label><br />
        <input type="text" id="developer_skype"  name="developer_skype" value="'.  esc_html(get_post_meta($post->ID, 'developer_skype', true)).'">
        </p>


        <p class="meta-options third-meta-options">
        <label for="developer_facebook">'.__('Facebook: ','wpestate').'</label><br />
        <input type="text" id="developer_facebook"  name="developer_facebook" value="'.  esc_html(get_post_meta($post->ID, 'developer_facebook', true)).'">
        </p>

        <p class="meta-options third-meta-options">
        <label for="developer_twitter">'.__('Twitter: ','wpestate').'</label><br />
        <input type="text" id="developer_twitter"  name="developer_twitter" value="'.  esc_html(get_post_meta($post->ID, 'developer_twitter', true)).'">
        </p>

        <p class="meta-options third-meta-options">
        <label for="developer_linkedin">'.__('Linkedin: ','wpestate').'</label><br />
        <input type="text" id="developer_linkedin"  name="developer_linkedin" value="'.  esc_html(get_post_meta($post->ID, 'developer_linkedin', true)).'">
        </p>

        <p class="meta-options third-meta-options">
        <label for="developer_pinterest">'.__('Pinterest: ','wpestate').'</label><br />
        <input type="text" id="developer_pinterest"  name="developer_pinterest" value="'.  esc_html(get_post_meta($post->ID, 'developer_pinterest', true)).'">
        </p>

        <p class="meta-options third-meta-options">
        <label for="developer_instagram">'.__('Instagram: ','wpestate').'</label><br />
        <input type="text" id="developer_instagram"  name="developer_instagram" value="'.  esc_html(get_post_meta($post->ID, 'developer_instagram', true)).'">
        </p>



        <p class="meta-options third-meta-options">
            <label for="developer_website">'.__('Website (without http): ','wpestate').'</label><br />
            <input type="text" id="developer_website"  name="developer_website" value="'.  esc_html(get_post_meta($post->ID, 'developer_website', true)).'">
        </p>
        
        <p class="meta-options third-meta-options">
            <label for="agency_website">'.__('License: ','wpestate').'</label><br />
            <input type="text" id="developer_license"  name="developer_license" value="'.  esc_html(get_post_meta($post->ID, 'developer_license', true)).'">
        </p>
        

        <p class="meta-options third-meta-options">
            <label for="agency_website">'.__('Taxes: ','wpestate').'</label><br />
            <input type="text" id="developer_taxes"  name="developer_taxes" value="'.  esc_html(get_post_meta($post->ID, 'developer_taxes', true)).'">
        </p>
        
        <p class="meta-options third-meta-options">
            <label for="user_meda_id">'.__('The user id for this profile: ','wpestate').'</label><br />
            <input type="text" id="user_meda_id"  name="user_meda_id" value="'. intval( get_post_meta($post->ID, 'user_meda_id',true ) ).'">
        </p>
            
        <p class="meta-options">
            <label for="developer_website">'.__('Location on Map: ','wpestate').'</label><br />
            <div id="googleMap" style="width:100%;height:380px;margin-bottom:30px;"></div>  
            <input type="hidden" name="developer_lat" id="developer_lat" value="'.esc_html(get_post_meta($post->ID, 'developer_lat', true)).'">
            <input type="hidden" name="developer_long" id="developer_long"  value="'.esc_html(get_post_meta($post->ID, 'developer_long', true)).'">
        </p>
        
        ';            
    }
endif; // end   estate_developer  




add_action('save_post', 'wpestate_update_developer_post', 1, 2);

if( !function_exists('wpestate_update_developer_post') ):
    function wpestate_update_developer_post($post_id,$post){

        if(!is_object($post) || !isset($post->post_type)) {
            return;
        }

         if($post->post_type!='estate_developer'){
            return;    
         }

         if( !isset($_POST['developer_email']) ){
             return;
         }
         if('yes' ==  esc_html ( get_option('wp_estate_user_developer','') )){  
                $allowed_html   =   array();
                $user_id    = get_post_meta($post_id, 'user_meda_id', true);
                $email      = wp_kses($_POST['developer_email'],$allowed_html);
                $phone      = wp_kses($_POST['developer_phone'],$allowed_html);
                $skype      = wp_kses($_POST['developer_skype'],$allowed_html);
                $position   = wp_kses($_POST['developer_address'],$allowed_html);
                $mobile     = wp_kses($_POST['developer_mobile'],$allowed_html);
                $desc       = wp_kses($_POST['content'],$allowed_html);
                $image_id   = get_post_thumbnail_id($post_id);
                $full_img   = wp_get_attachment_image_src($image_id, 'property_listings');           
                $facebook   = wp_kses($_POST['developer_facebook'],$allowed_html);
                $twitter    = wp_kses($_POST['developer_twitter'],$allowed_html);
                $linkedin   = wp_kses($_POST['developer_linkedin'],$allowed_html);
                $pinterest  = wp_kses($_POST['developer_pinterest'],$allowed_html);
                $instagram  = wp_kses($_POST['developer_instagram'],$allowed_html);
                $developer_website  = wp_kses($_POST['developer_website'],$allowed_html);
                $developer_license  = wp_kses($_POST['developer_license'],$allowed_html);
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
                update_user_meta( $user_id, 'instagram', $pinterest) ;
                update_user_meta( $user_id, 'website', $developer_website) ;
                update_user_meta( $user_id, 'developer_license', $developer_license) ;

                update_user_meta( $user_id, 'small_custom_picture', $image_id) ;

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




add_filter( 'manage_edit-estate_developer_columns', 'wpestate_my_columns_developer' );

if( !function_exists('wpestate_my_columns_developer') ):
    function wpestate_my_columns_developer( $columns ) {
        $slice=array_slice($columns,2,2);
        unset( $columns['comments'] );
        unset( $slice['comments'] );
        $splice=array_splice($columns, 2);
        $columns['estate_ID']               = __('ID','wpestate');
        $columns['estate_developer_thumb']      = __('Image','wpestate');
        $columns['estate_developer_city']       = __('City','wpestate');
        $columns['estate_developer_action']     = __('Action','wpestate');
        $columns['estate_developer_category']   = __( 'Category','wpestate');
        $columns['estate_developer_email']      = __('Email','wpestate');
        $columns['estate_developer_phone']      = __('Phone','wpestate');

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

add_action('restrict_manage_posts', $restrict_manage_posts('estate_developer', 'property_category_developer') );
add_filter('parse_query', $parse_query('estate_developer', 'property_category_developer') );


add_action('restrict_manage_posts', $restrict_manage_posts('estate_developer', 'property_action_developer') );
add_filter('parse_query', $parse_query('estate_developer', 'property_action_developer') );


add_action('restrict_manage_posts', $restrict_manage_posts('estate_developer', 'property_city_developer') );
add_filter('parse_query', $parse_query('estate_developer', 'property_city_developer') );


?>