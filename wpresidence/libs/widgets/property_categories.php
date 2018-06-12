<?php
class Property_Categories extends WP_Widget {
        function __construct(){
	//function Social_widget(){
		$widget_ops = array('classname' => 'property_categories', 'description' => 'List Properties by Categories');
		$control_ops = array('id_base' => 'property_categories');
	
		parent::__construct('property_categories', 'Wp Estate: List Properties by Categories', $widget_ops, $control_ops);
	}
	
function form($instance){
		$defaults = array(  'title'                 =>  'Our Listings',
                                    'taxonony'              =>  'property_category',
                                    'show_count'            =>  'yes',
                                    'show_child'            =>  'yes',
                                );
		$instance = wp_parse_args((array) $instance, $defaults);
		
                $taxonomies = array(
                    'property_category'         =>  __('Property Category','wpestate'),
                    'property_action_category'  =>  __('Property Action','wpestate'),
                    'property_city'             =>  __('Property City','wpestate'),
                    'property_area'             =>  __('Property Area','wpestate'),
                    'property_county_state'     =>  __('Property County/State','wpestate')
                );
                
                $show_cont = array('yes','no');
                
                
                $display='
                <p>
                    <label for="'.$this->get_field_id('title').'">Title:</label>
		</p>
                <p>
                    <input id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" value="'.$instance['title'].'" />
		</p>
                

                <p>
                    <label for="'.$this->get_field_id('taxonony').'">Category / Taxonomy:</label>
		</p>
                <p>		
                    <select id="'.$this->get_field_id('taxonony').'" name="'.$this->get_field_name('taxonony').'">';
                        foreach($taxonomies as $tax=>$name){
                            $display .='<option value ="'.$tax.'"';
                                if($instance['taxonony']=== $tax){
                                   $display .=' selected '; 
                                }
                            $display .='>'.$name.'</option>';
                        }
                    $display .='</select>
                </p>
                
                <p>
                    <label for="'.$this->get_field_id('show_count').'">Show Categories Count</label>
		</p>
                
                <p>
                    <select id="'.$this->get_field_id('show_count').'" name="'.$this->get_field_name('show_count').'">';
                    foreach($show_cont as $tax=>$name){
                        $display .='<option value ="'.$name.'"';
                            if($instance['show_count']=== $name){
                               $display .=' selected '; 
                            }
                        $display .='>'.$name.'</option>';
                    }
                    $display .='</select>
		</p>
                
                <p>
                    <label for="'.$this->get_field_id('show_child').'">Show Child Categories:</label>
		</p>
                
                <p>
                    <select id="'.$this->get_field_id('show_child').'" name="'.$this->get_field_name('show_child').'">';
                    foreach($show_cont as $tax=>$name){
                        $display .='<option value ="'.$name.'"';
                            if($instance['show_child']=== $name){
                               $display .=' selected '; 
                            }
                        $display .='>'.$name.'</option>';
                    }
                    $display .='</select>
		</p>';
		print $display;
	}

	function update($new_instance, $old_instance){
		$instance               = $old_instance;
		$instance['title']      = $new_instance['title'];
		$instance['taxonony']   = $new_instance['taxonony'];
		$instance['show_count'] = $new_instance['show_count'];
		$instance['show_child'] = $new_instance['show_child'];
		
		return $instance;
	}

        
	function widget($args, $instance){
		extract($args);
      
		$title      =   apply_filters('widget_title', $instance['title']);
                $show_count =   $instance['show_count'];
                $show_child =   $instance['show_child'];
                $taxonony   =   $instance['taxonony'];

               
        
                $display='';
		print $before_widget;

		if($title) {
                    print $before_title.$title.$after_title;
		}
                
		$display.='<div class="category_list_widget">';
		 
                $items  = get_terms( 
                            $taxonony , 
                            array( 'parent'=> 0 )
                            );
                $count = count($items);
		
                $display.=wpestate_recursive_category_list($items,$taxonony,$show_child,$show_count);
                
                
                
		
		$display.='</div>';
		print $display;
		print $after_widget;
	}
}



function wpestate_recursive_category_list($items,$taxonony,$show_child,$show_count){
  
    $return_string='';
    if($show_child=='yes'){
        $return_string.='<ul>';
    }else{
         $return_string.='<ul class="child_category" >';
    }
    
    foreach($items as $item){
        $return_string.= '<li><a href="' . esc_url( get_term_link( $item->slug, $item->taxonomy) ). '">'.esc_attr( $item->name ).'</a>';
        
        if( $show_count == 'yes') {
            $return_string.= '<span class="category_no">(' . esc_attr( $item->count ) . ')</span>';
        }
        if( $show_child == 'yes' ) {
            $child_categories = get_terms( $taxonony, array('parent' => $item->term_id));
                if ($child_categories) {
                    $return_string.= wpestate_recursive_category_list($child_categories,$taxonony,false,$show_count );
                }
        }
        
        $return_string.= '</li>';

    }
    $return_string.='</ul>';
    return $return_string;
}











?>