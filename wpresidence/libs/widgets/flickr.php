<?php
class Flickr_Widget extends WP_Widget {
	var $prefix; 
	var $textdomain;

function Flickr_Widget() {
	    $control_ops = array('width' => 525,'height' => 350,'id_base' => "flickr_widget");
		$widget_ops = array('classname' => 'Widget_Flickr', 'description' => 'Displays Flickr photos' );
		$this->WP_Widget('flickr_widget', 'Wp Estate Flickr Widget', $widget_ops, $control_ops);
	}

	function form($instance)
	{
		$defaults = array('title' => 'Photos from Flickr', 'username' => '', 'img_no' => 6);
		$instance = wp_parse_args((array) $instance, $defaults);
		$display='
                <p>
                    <label for="'.$this->get_field_id('title').'">Title:</label>
                </p>
                <p>	
                    <input id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" value="'.$instance['title'].'"/>
		</p>
                <p>
                    <label for="'.$this->get_field_id('username').'">Username:</label>
		</p>
                <p>
                    <input id="'.$this->get_field_id('username').'" name="'.$this->get_field_name('username').'>" value="'.$instance['username'].'" />
		</p>
                <p>
                    <label for="'.$this->get_field_id('img_no').'>">Number of photos to show:</label>
		</p>
                <p>
                    <input id="'.$this->get_field_id('img_no').'>" name="'.$this->get_field_name('img_no').'>" value="'.$instance['img_no'].'" />
		</p>';	
		print $display;
    }
	
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['username'] = $new_instance['username'];
		$instance['img_no'] = $new_instance['img_no'];
		return $instance;
	}
	
	
	
	function widget($args, $instance)
	{
		extract($args);
                $display='';
		$title = apply_filters('widget_title', $instance['title']);
		$username = $instance['username'];
		$img_no = $instance['img_no'];
		print $before_widget;
		if($title){
			print $before_title.$title.$after_title;
		}		
		if($username && $img_no) {			
			// api key for wp-estate
			$flickr_api = '2fc27422ee27bee87652d1132ae73777';			
			$http_query = wp_remote_get('http://api.flickr.com/services/rest/?method=flickr.people.findByUsername&api_key='.$flickr_api.'&username='.urlencode($username).'&format=json');
			$http_query = json_decode(trim($http_query['body'], 'jsonFlickrApi()'));			
			if($http_query->user->id) { // if username is ok
				$img_query = wp_remote_get('http://api.flickr.com/services/rest/?method=flickr.urls.getUserPhotos&api_key='.$flickr_api.'&user_id='.$http_query->user->id.'&format=json');
				$img_query = json_decode(trim($img_query['body'], 'jsonFlickrApi()'));			
				$user_pictures = wp_remote_get('http://api.flickr.com/services/rest/?method=flickr.people.getPublicPhotos&api_key='.$flickr_api.'&user_id='.$http_query->user->id.'&per_page='.$img_no.'&format=json');
				$user_pictures = json_decode(trim($user_pictures['body'], 'jsonFlickrApi()'));	
				$counter=1;
				$display='<div class="flickr_widget_internal">';
                                $class='flickr_widget';
                                
                                foreach($user_pictures->photos->photo as $img){
				    $img = (array) $img; 
                                    $display.='
                                            <a href="'.$img_query->user->url.$img['id'].'" target="_blank" class="link'.$class.'">
                                                <div class="listing-cover"></div>
                                                <img class="'.$class.'" src="http://farm'.$img['farm'].'.static.flickr.com/'.$img['server'].'/'.$img['id'].'_'.$img['secret'].'_s.jpg" alt="'.$img['title'].'" width="75" height="75"/>
                                            </a>';
                                    $counter++;
                                }
                                
                                
				$display.='</div>';	
			} else {
				$display= '<p>The flickr username is not correct.</p>';
			}
		}
		print $display;
		print $after_widget;
	}

}

?>