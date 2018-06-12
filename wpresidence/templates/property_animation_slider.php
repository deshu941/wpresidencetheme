<?php
global $post;

$all_images =  get_post_meta( $post->ID, 'image_to_attach', true ) ;
$all_images = explode(',', $all_images);    
$all_images = array_filter($all_images);


		$slider_cycle   =   get_option( 'wp_estate_slider_cycle', true); 
        if($slider_cycle == 0){
            $slider_cycle = false;
        }


	 $extended_search    =   get_option('wp_estate_show_adv_search_extended','');
        $extended_class     =   '';

        if ( $extended_search =='yes' ){
            $extended_class='theme_slider_extended';
        }
        $theme_slider_height   =   get_option( 'wp_estate_theme_slider_height', true);
        
        if($theme_slider_height==0){
            $theme_slider_height=900;
            $extended_class .= " full_screen_yes ";
        }



 //'.$slider_cycle.'
        print '<div class="theme_slider_wrapper '.$extended_class.'  property_animation_slider carousel  slide" data-ride="carousel" data-interval="8000" id="property_animation_slider"    >';
		
		$counter = 0;
		$slides = '';
		$indicators = '';
		$class_counter = 1;
		
		
        if( count($all_images) > 0 )
			foreach( $all_images as $single_image ){
				if( get_post_status( $single_image ) === false ){
				  continue;
				} 
				
				$theid=get_the_ID();
             
                $preview        =   wp_get_attachment_image_src( $single_image , 'property_full_map');
                if($preview[0]==''){
                    $preview[0]= get_template_directory_uri().'/img/defaults/default_property_featured.jpg';
                }

               if($counter==0){
                    $active=" active ";
                }else{
                    $active=" ";
                }
				
				$caption = get_post( $single_image ) ;
				$caption = $caption->post_excerpt;

				
               $slides.= '
               <div class="item   prop_animation_class_'.$class_counter.' '.$active.' " data-id="'.$counter.'"   style=" height:'.$theme_slider_height.'px;" >
                 	   
                    <div class="theme_slider_3_gradient"></div>
                      
                    <div class="image_div">
                        <img src="'.$preview[0].'" alt="slider">
                    </div>
                    
                    <div class="slide_caption">
                        <h2>'.$caption.'</h2>
                    </div>  
				
                    
                </div>';

               $indicators.= '
               <li data-target="#property_animation_slider" data-slide-to="'.($counter).'" class="'. $active.'">

               </li>';

               $counter++;
			 
			$class_counter++;
			if( $class_counter > 3 ){
				$class_counter = 1;
			}    
			   
        }
        print '<div class="carousel-inner" role="listbox">
                  '.$slides.'
               </div>
			   
			 
				 
            
 
                <a id="carousel-control-theme-next" class="carousel-control-theme-next" href="#property_animation_slider" data-slide="next"><i class="fa fa-angle-right"></i></a>
                <a id="carousel-control-theme-prev" class="carousel-control-theme-prev" href="#property_animation_slider" data-slide="prev"><i class="fa fa-angle-left"></i></a>


               </div>';
        
        
//        print '   <ol class="carousel-indicators">
//                    '.$indicators.'
//               </ol>'