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
<<<<<<< HEAD

function initialize(){
    "use strict";

    //var map_type='google.maps.MapTypeId.'+googlecode_regular_vars.type;
=======
var bounds;

function initialize(){
    "use strict";
    
    if(jQuery('#googleMap').hasClass('full_height_map')){
        var new_height = jQuery( window ).height() - jQuery('.master_header').height();
        jQuery('#googleMap,#gmap_wrapper').css('height',new_height);
    }
    
    
    
    var with_bound=0;
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    var mapOptions = {
        flat:false,
        noClear:false,
        zoom: parseInt(googlecode_regular_vars.page_custom_zoom),
        scrollwheel: false,
        draggable: true,
        center: new google.maps.LatLng(googlecode_regular_vars.general_latitude, googlecode_regular_vars.general_longitude),
        mapTypeId: googlecode_regular_vars.type.toLowerCase(),
        streetViewControl:false,
<<<<<<< HEAD
        disableDefaultUI: true
=======
        disableDefaultUI: true,
         gestureHandling: 'cooperative'
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    };

    if(  document.getElementById('googleMap') ){
        map = new google.maps.Map(document.getElementById('googleMap'), mapOptions);
    }else{
        return;
    }
    google.maps.visualRefresh = true;
<<<<<<< HEAD
    
  
    if(mapfunctions_vars.show_g_search_status==='yes'){
        set_google_search(map)
    }
  

=======
  
  
    
    if(mapfunctions_vars.show_g_search_status==='yes'){
        set_google_search(map)
    }
>>>>>>> 64662fd89bea560852792d7203888072d7452d48

    if(mapfunctions_vars.map_style !==''){
       var styles = JSON.parse ( mapfunctions_vars.map_style );
       map.setOptions({styles: styles});
    }
  
<<<<<<< HEAD
  
  
  
    
    google.maps.event.addListener(map, 'tilesloaded', function() {
     jQuery('#gmap-loading').remove();
    });

    if (Modernizr.mq('only all and (max-width: 1025px)')) {
        map.setOptions({'draggable': false});
    }

    
    if(googlecode_regular_vars.generated_pins==='0'){
        pins=googlecode_regular_vars.markers;
        markers = jQuery.parseJSON(pins);
    }else{
        if( typeof( googlecode_regular_vars2) !== 'undefined' && googlecode_regular_vars2.markers2.length > 2){          
            pins=googlecode_regular_vars2.markers2;
            markers = jQuery.parseJSON(pins);         
=======
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
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        }           
    }
    

    
    if (markers.length>0){
<<<<<<< HEAD
        setMarkers(map, markers);
=======
        setMarkers(map, markers,with_bound);
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    }
   
    if(googlecode_regular_vars.idx_status==='1'){
        placeidx(map,markers);
    }

<<<<<<< HEAD
    if (googlecode_regular_vars.is_adv_search ==='1'){
        show_pins();
        jQuery('#results').hide();
    }

    //set map cluster
    map_cluster();
    
    if ( mapfunctions_vars.adv_search_type==='2'){
        if(  document.getElementById('basepoint') ){
            var last_lng=document.getElementById("basepoint").getAttribute("data-long");
            var last_lat=document.getElementById("basepoint").getAttribute("data-lat");
            var lastmyLatLng  = new google.maps.LatLng(last_lat, last_lng);
            map.setCenter(lastmyLatLng);  
        }
    }
    
    oms = new OverlappingMarkerSpiderfier(map, {markersWontMove: true, markersWontHide: true,keepSpiderfied :true,legWeight:3});
    setOms(gmarkers);
  
=======
    //set map cluster
  
 
   
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
   // map.setCenter(idx_place);
   
   
   
}
///////////////////////////////// end initialize
/////////////////////////////////////////////////////////////////////////////////// 
 
 
if (typeof google === 'object' && typeof google.maps === 'object') {                                         
    google.maps.event.addDomListener(window, 'load', initialize);
}