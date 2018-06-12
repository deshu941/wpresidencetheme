<?php
class Agents_Agencies_Dev_Search_widget extends WP_Widget {
	function __construct(){
	//function Advanced_Search_widget(){
		$widget_ops = array('classname' => 'advanced_search_sidebar ag_ag_dev_search_widget boxed_widget', 'description' => 'Agents Agencies Developers Search Widget');
		$control_ops = array('id_base' => 'ag_ag_dev_search_widget');
		//$this->WP_Widget('advanced_search_widget', 'Wp Estate: Advanced Search', $widget_ops, $control_ops);
                parent::__construct('ag_ag_dev_search_widget', 'Wp Estate: Agents Agencies Developers Search Widget', $widget_ops, $control_ops);
                
	}
	
	function form($instance){
		$defaults = array('title' => 'Agents Search' );
		$instance = wp_parse_args((array) $instance, $defaults);
		$display='
                <p>
                    <label for="'.$this->get_field_id('title').'">Title:</label>
		</p><p>
                    <input id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" value="'.$instance['title'].'" />
		</p>';
		print $display;
	}


	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		
		return $instance;
	}



	function widget($args, $instance){
		extract($args);
                $display='';
                $select_tax_action_terms='';
                $select_tax_category_terms='';
                
		$title = apply_filters('widget_title', $instance['title']);

		print $before_widget;

		if($title) {
                    print $before_title.$title.$after_title;
		}else{
                    print '<div class="widget-title-sidebar_blank"></div>';
                }
                
                $search_link = wpestate_get_template_link( 'aag_search_results.php' );
                
                //  show cities or areas that are empty ?
                $args = wpestate_get_select_arguments();
          
				// main output structure of widegt
				$widget_taxonomies_filter = array(
					array(
						'post_type' => 'estate_agent',
						'selector_name' => __('Agent', 'wpestate'),
						'tax_to_query' => array(
							'property_city_agent' => __('Select City', 'wpestate'),
							'property_area_agent' => __('Select Area', 'wpestate'),
							'property_category_agent' => __('Select Category', 'wpestate'),
							'property_action_category_agent' => __('Select Action Category', 'wpestate'),
						),
					),
					array(
						'post_type' => 'estate_agency',
						'selector_name' => __('Agency', 'wpestate'),
						'tax_to_query' => array(
							'city_agency' => __('Select City', 'wpestate'),
							'area_agency' => __('Select Area', 'wpestate'),
							'category_agency' => __('Select Agency Category', 'wpestate'),
							'action_category_agency' => __('Select Action Category', 'wpestate'),
						),
					),
					array(
						'post_type' => 'estate_developer',
						'selector_name' => __('Developer', 'wpestate'),
						'tax_to_query' => array(
							'property_city_developer' => __('Select City', 'wpestate'),
							'property_area_developer' => __('Select Area', 'wpestate'),
							'property_category_developer' => __('Select Category', 'wpestate'),
							'property_action_developer' => __('Select Action Category', 'wpestate'),
						),
					),	
				);
 	
                print '
 
				<form role="search" method="get"   action="'.$search_link.'" >';
                   
					$_keyword_search = null;
					if( isset( $_GET['_keyword_search'] ) ){
						$_keyword_search = stripslashes( sanitize_text_field( htmlentities( $_GET['_keyword_search'] ) ) );
					}
					// name search ionput field
					 print'<input type="text" id="keyword_search" class="form-control" name="_keyword_search"  placeholder="'. __('Name','wpestate').'" value="'.$_keyword_search.'">';
				   
				   
					
					// get types list for registered post types
					$search_type_selector = '';
					foreach( $widget_taxonomies_filter as $single_post_type ){
						$search_type_selector .=  '<li role="presentation" data-value="'.$single_post_type['post_type'].'">'.$single_post_type['selector_name'].'</li>';
					}
					$search_type_title =   $widget_taxonomies_filter[0]['selector_name'];
                    $search_type_value   =   $widget_taxonomies_filter[0]['post_type'];
					//get initial post type selector and depending on it hide / show dropdowns
					if( isset($_GET['_search_post_type']) ){
						foreach( $widget_taxonomies_filter as $single_post_type ){
							if( $_GET['_search_post_type'] ==  $single_post_type['post_type'] ){
								$search_type_title = $single_post_type['selector_name'];
								$search_type_value = $single_post_type['post_type'];
							}
						}
					}
				   
				 
					 print '<div class="dropdown form-control " >
                            <div data-toggle="dropdown" id="sidebar-search_post_type" class="sidebar_filter_menu"  data-value="'.strtolower ( rawurlencode( $search_type_value )).'"> 
                                '.$search_type_title.'               
								<span class="caret caret_sidebar"></span> 
							</div>           
                            <input type="hidden" name="_search_post_type" value="'.strtolower ( rawurlencode( $search_type_value )).'">
                            <ul  class="dropdown-menu filter_menu aag_picker" role="menu" aria-labelledby="sidebar-search_post_type">
                                '.$search_type_selector.'
                            </ul>
                        </div>';
				   
					
				   
				   
				   // dynamicaly create all dropdowns
					foreach( $widget_taxonomies_filter as $single_post_type ){
					
						foreach( $single_post_type['tax_to_query'] as $key => $value  ){
						
							$taxonomy_values_to_process = wpestate_get_taxonomy_select_list( $args, $key, $value );
						
							 $initial_tax_value =   'all';
							 
							// if get parameter set  set selected value
							 if( isset($_GET['_'.$key]) ){
							 
								$initial_tax_value =   sanitize_text_field( $_GET['_'.$key] );
								foreach(  $taxonomy_values_to_process['values'] as  $single_value ){
									if( $single_value['slug'] == $initial_tax_value  ){
										$value = $single_value['text'];
									}
								}
								
							 }
						
							print '<div class="dropdown form-control ag_ag_dev_search_selector  selector_for_'.$single_post_type['post_type'].'"  '.( $search_type_value != $single_post_type['post_type'] ? ' style="display:none;" ' : ''  ).'  >
								<div data-toggle="dropdown" id="sidebar-'.$key.'" class="sidebar_filter_menu"  data-value="'.strtolower ( rawurlencode( $initial_tax_value )).'"> 
									'.$value.'               
								<span class="caret caret_sidebar"></span> </div>           
								<input type="hidden" name="_'.$key.'" value="'.strtolower ( rawurlencode( $initial_tax_value )).'">
								<ul  class="dropdown-menu filter_menu" role="menu" aria-labelledby="sidebar-'.$key.'">
									'.$taxonomy_values_to_process['text'].'
								</ul>
							</div>';
						}
					
						
					
					}
			
                    
          
                if (function_exists('icl_translate') ){
                    print do_action( 'wpml_add_language_form_field' );
                }
                
                print'<button class="wpresidence_button" id="advanced_submit_widget">'.__('Search','wpestate').'</button>
                </form>  
                '; 
		print $after_widget;
                
	}

       
    
}// end class
?>