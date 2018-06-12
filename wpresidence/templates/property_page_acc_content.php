<?php
global $property_adr_text;
global $property_details_text;
global $property_features_text;
global $feature_list_array;
global $use_floor_plans;
global $post;
$content = get_the_content();
$content = apply_filters('the_content', $content);
$content = str_replace(']]>', ']]&gt;', $content);
<<<<<<< HEAD

if($content!=''){                            
    print $content;     
}

get_template_part ('/templates/download_pdf');

?>
=======
$header_type                    =   get_post_meta ( $post->ID, 'header_type', true);

if($content!=''){                            
    print '<div class="wpestate_property_description">'.$content.'</div>';     
}
?>

<!-- Energy saving -->
<?php          

	$energy_index       = get_post_meta($post->ID, 'energy_index', true) ;
	$energy_class       = get_post_meta($post->ID, 'energy_class', true) ;

if ( $energy_index != ''    || $energy_class != ''  ){ //  if energy data  exists
?>      
<div class="property_energy_saving_info"  >  

          <?php print energy_save_features($post->ID); ?>
 
</div>  
<?php
} // end if energy data  exists
?>
<!-- END Energy saving -->


<?php
get_template_part ('/templates/download_pdf');
$show_graph_prop_page= esc_html( get_option('wp_estate_show_graph_prop_page', '') );
?>




>>>>>>> 64662fd89bea560852792d7203888072d7452d48

            
<div class="panel-group property-panel" id="accordion_prop_addr">
    <div class="panel panel-default">
       <div class="panel-heading">
<<<<<<< HEAD
           <a data-toggle="collapse" data-parent="#accordion_prop_addr" href="#collapseTwo">
             <h4 class="panel-title">  
             <?php if($property_adr_text!=''){
                 echo $property_adr_text;
             } else{
                 _e('Property Address','wpestate');
             }
             ?>
             </h4>    
           </a>
=======
            <a data-toggle="collapse" data-parent="#accordion_prop_addr" href="#collapseTwo">
                <h4 class="panel-title">  
                <?php if($property_adr_text!=''){
                    echo esc_html($property_adr_text);
                } else{
                    _e('Property Address','wpestate');
                }
               
                ?>
                    
                </h4>   
                
            </a>
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
       </div>
       <div id="collapseTwo" class="panel-collapse collapse in">
         <div class="panel-body">

         <?php print estate_listing_address($post->ID); ?>
         </div>
       </div>
    </div>            
</div>     



<div class="panel-group property-panel" id="accordion_prop_details">  
    <div class="panel panel-default">
        <div class="panel-heading">
             <?php                      
             if($property_details_text=='') {
                 print'<a data-toggle="collapse" data-parent="#accordion_prop_details" href="#collapseOne"><h4 class="panel-title" id="prop_det">'.__('Property Details', 'wpestate').'  </h4></a>';
             }else{
                 print'<a data-toggle="collapse" data-parent="#accordion_prop_details" href="#collapseOne"><h4 class="panel-title"  id="prop_det">'.$property_details_text.'  </h4></a>';
             }
             ?>
        </div>
        <div id="collapseOne" class="panel-collapse collapse in">
          <div class="panel-body">
          <?php print estate_listing_details($post->ID);?>
          </div>
        </div>
    </div>
</div>


<<<<<<< HEAD
=======



>>>>>>> 64662fd89bea560852792d7203888072d7452d48
<!-- Features and Ammenties -->
<?php          
if ( count( $feature_list_array )!= 0 && count($feature_list_array)!=1 ){ //  if are features and ammenties
?>      
<div class="panel-group property-panel" id="accordion_prop_features">  
    <div class="panel panel-default">
        <div class="panel-heading">
            <a data-toggle="collapse" data-parent="#accordion_prop_features" href="#collapseThree">
              <?php
                if($property_features_text ==''){
<<<<<<< HEAD
                    print '<coreh4 class="panel-title" id="prop_ame">'.__('Amenities and Features', 'wpestate').'</h4>';
=======
                    print '<h4 class="panel-title" id="prop_ame">'.__('Amenities and Features', 'wpestate').'</h4>';
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
                }else{
                    print '<h4 class="panel-title" id="prop_ame">'. $property_features_text.'</h4>';
                }
              ?>
            </a>
        </div>
        <div id="collapseThree" class="panel-collapse collapse in">
          <div class="panel-body">
          <?php print estate_listing_features($post->ID); ?>
          </div>
        </div>
    </div>
</div>  
<?php
} // end if are features and ammenties
?>
<!-- END Features and Ammenties -->

<<<<<<< HEAD
=======

<?php

$prpg_slider_type_status= esc_html ( get_option('wp_estate_global_prpg_slider_type','') );    
$local_pgpr_slider_type_status  =   get_post_meta($post->ID, 'local_pgpr_slider_type', true);

    if( $local_pgpr_slider_type_status=='global' && ( $prpg_slider_type_status == 'full width header'||  $prpg_slider_type_status=='multi image slider'  ||  $prpg_slider_type_status=='gallery'  ) 
            || $local_pgpr_slider_type_status=='full width header'  ||  $local_pgpr_slider_type_status=='multi image slider'  ||  $local_pgpr_slider_type_status=='gallery' || 
            $local_pgpr_slider_type_status=='animation slider'){     
   
    ?>
    <div class="panel-group property-panel" id="accordion_prop_map">  
        <div class="panel panel-default">
            <div class="panel-heading">
                <a data-toggle="collapse" data-parent="#accordion_prop_map" href="#collapsemap">
                    <h4 class="panel-title" id="prop_ame"><?php _e('Map', 'wpestate');?></h4>
                  
                </a>
            </div>
            <div id="collapsemap" class="panel-collapse collapse in">
              <div class="panel-body">
              <?php print do_shortcode('[property_page_map propertyid="'.$post->ID.'"][/property_page_map]') ?>
              </div>
            </div>
        </div>
    </div> 


    <?php
    }
?>


<!-- Walkscore -->    

<?php

$virtual_tour                   =   get_post_meta($post->ID, 'embed_virtual_tour', true);
if($virtual_tour!='' && $header_type!=11 ){?>

    
<div class="panel-group property-panel" id="accordion_virtual_tour">  
    <div class="panel panel-default">
        <div class="panel-heading">
            <a data-toggle="collapse" data-parent="#accordion_virtual_tour" href="#collapsenine">
                <?php
                    print '<h4 class="panel-title" id="prop_ame">'.__('Virtual Tour', 'wpestate').'</h4>';
                ?>
            </a>
        </div>

        <div id="collapsenine" class="panel-collapse collapse in">
            <div class="panel-body">
                <?php wpestate_virtual_tour_details($post->ID); ?>
            </div>
        </div>
    </div>
</div>  



       
<?php       
    }
?>


>>>>>>> 64662fd89bea560852792d7203888072d7452d48
<!-- Walkscore -->    

<?php
    $walkscore_api= esc_html ( get_option('wp_estate_walkscore_api','') );
    if($walkscore_api!=''){?>

    
<div class="panel-group property-panel" id="accordion_walkscore">  
    <div class="panel panel-default">
        <div class="panel-heading">
            <a data-toggle="collapse" data-parent="#accordion_walkscore" href="#collapseFour">
                <?php
                    print '<h4 class="panel-title" id="prop_ame">'.__('WalkScore', 'wpestate').'</h4>';
                ?>
            </a>
        </div>

        <div id="collapseFour" class="panel-collapse collapse in">
            <div class="panel-body">
                <?php wpestate_walkscore_details($post->ID); ?>
            </div>
        </div>
    </div>
</div>  



       
<?php       
    }
?>



<<<<<<< HEAD


=======
<?php
$yelp_client_id         =   get_option('wp_estate_yelp_client_id','');
$yelp_client_secret     =   get_option('wp_estate_yelp_client_secret','');
$yelp_client_api_key_2018  =   get_option('wp_estate_yelp_client_api_key_2018','');
if($yelp_client_api_key_2018!=='' && $yelp_client_id!==''  ){
?>

<div class="panel-group property-panel" id="accordion_yelp">  
    <div class="panel panel-default">
        <div class="panel-heading">
            <a data-toggle="collapse" data-parent="#accordion_yelp" href="#collapseyelp">
                <?php
                    print '<h4 class="panel-title" id="prop_ame">'.__('What\'s Nearby', 'wpestate').'</h4>';
                ?>
            </a>
        </div>

        <div id="collapseyelp" class="panel-collapse collapse in">
            <div class="panel-body">
                <?php wpestate_yelp_details($post->ID); ?>
            </div>
        </div>
    </div>
</div>  

<?php
}
?>
>>>>>>> 64662fd89bea560852792d7203888072d7452d48




<?php // floor plans
if ( $use_floor_plans==1 ){ 
?>

<div class="panel-group property-panel" id="accordion_prop_floor_plans">  
    <div class="panel panel-default">
        <div class="panel-heading">
            <a data-toggle="collapse" data-parent="#accordion_prop_floor_plans" href="#collapseflplan">
                <?php
                    print '<h4 class="panel-title" id="prop_ame">'.__('Floor Plans', 'wpestate').'</h4>';
                ?>
            </a>
        </div>

        <div id="collapseflplan" class="panel-collapse collapse in">
            <div class="panel-body">
                <?php print estate_floor_plan($post->ID); ?>
            </div>
        </div>
    </div>
</div>  


<?php
}
<<<<<<< HEAD
=======
?>


<?php
if($show_graph_prop_page=='yes'){
?>
    <div class="panel-group property-panel" id="accordion_prop_stat">
        <div class="panel panel-default">
           <div class="panel-heading">
               <a data-toggle="collapse" data-parent="#accordion_prop_stat" href="#collapseSeven">
                <h4 class="panel-title">  
                <?php 
                    _e('Page Views Statistics','wpestate');
               
                ?>
                </h4>    
               </a>
           </div>
           <div id="collapseSeven" class="panel-collapse collapse in">
             <div class="panel-body">
                <canvas id="myChart"></canvas>
             </div>
           </div>
        </div>            
    </div>    
    <script type="text/javascript">
    //<![CDATA[
        jQuery(document).ready(function(){
             wpestate_show_stat_accordion();
        });
    
    //]]>
    </script>
<?php
}

>>>>>>> 64662fd89bea560852792d7203888072d7452d48
?>