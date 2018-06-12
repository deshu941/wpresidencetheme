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

if($content!=''){                            
    print $content;     
}

get_template_part ('/templates/download_pdf');

?>

            
<div class="panel-group property-panel" id="accordion_prop_addr">
    <div class="panel panel-default">
       <div class="panel-heading">
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
                    print '<coreh4 class="panel-title" id="prop_ame">'.__('Amenities and Features', 'wpestate').'</h4>';
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
?>