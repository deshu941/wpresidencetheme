/*global google */
/*global Modernizr */
/*global InfoBox */
/*global googlecode_regular_vars*/
var gmarkers = [];
var current_place=0;
var actions=[];
var categories=[];
var vertical_pan=-190;
var map_open=0;
var vertical_off=150;
var pins='';
var markers='';
var infoBox = null;
var category=null;
var width_browser=null;
var infobox_width=null;
var wraper_height=null;
var info_image=null;
var map;
var found_id;
var selected_id         =   '';
var javamap;
var oms;
var idx_place;
var bounds;

function initialize(){
    "use strict";
    
    if(jQuery('#googleMap').hasClass('full_height_map')){
        var new_height = jQuery( window ).height() - jQuery('.master_header').height();
        jQuery('#googleMap,#gmap_wrapper').css('height',new_height);
    }
    
    
    
    var with_bound=0;
    var mapOptions = {
        flat:false,
        noClear:false,
        zoom: parseInt(googlecode_regular_vars.page_custom_zoom),
        scrollwheel: false,
        draggable: true,
        center: new google.maps.LatLng(googlecode_regular_vars.general_latitude, googlecode_regular_vars.general_longitude),
        mapTypeId: googlecode_regular_vars.type.toLowerCase(),
        streetViewControl:false,
        disableDefaultUI: true,
         gestureHandling: 'cooperative'
    };

    if(  document.getElementById('googleMap') ){
        map = new google.maps.Map(document.getElementById('googleMap'), mapOptions);
    }else{
        return;
    }
    google.maps.visualRefresh = true;
  
  
    
    if(mapfunctions_vars.show_g_search_status==='yes'){
        set_google_search(map)
    }

    if(mapfunctions_vars.map_style !==''){
       var styles = JSON.parse ( mapfunctions_vars.map_style );
       map.setOptions({styles: styles});
    }
  
    google.maps.event.addListener(map, 'tilesloaded', function() {
        jQuery('#gmap-loading').hide();
    });

    


    if(googlecode_regular_vars.generated_pins==='0'){
        pins        =   googlecode_regular_vars.markers;
        markers     =   jQuery.parseJSON(pins);
    }else{
        if( typeof( googlecode_regular_vars2) !== 'undefined' && googlecode_regular_vars2.markers2.length > 2){          
            pins        =   googlecode_regular_vars2.markers2;
            markers     =   jQuery.parseJSON(pins); 
            with_bound  =   1;
        }           
    }
    

    
    if (markers.length>0){
        setMarkers(map, markers,with_bound);
    }
   
    if(googlecode_regular_vars.idx_status==='1'){
        placeidx(map,markers);
    }

    //set map cluster
  
 
   
   // map.setCenter(idx_place);
   
   
   
}
///////////////////////////////// end initialize
/////////////////////////////////////////////////////////////////////////////////// 
 
 
if (typeof google === 'object' && typeof google.maps === 'object') {                                         
    google.maps.event.addDomListener(window, 'load', initialize);
}