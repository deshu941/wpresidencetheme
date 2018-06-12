var pin_images=mapfunctions_vars.pin_images;
var images = jQuery.parseJSON(pin_images);
var ipad_time=0;
var infobox_id=0;
var shape = {
        coord: [1, 1, 1, 38, 38, 59, 59 , 1],
        type: 'poly'
    };

var mcOptions;
var mcluster;
var clusterStyles;
var pin_hover_storage;
<<<<<<< HEAD
=======
var first_time_wpestate_show_inpage_ajax_half=0;
var panorama;
var infoBox_sh=null;
var poi_marker_array=[];
var poi_type='';
var placeCircle='';
var initialGeop=0;

function wpestate_agency_map_function(){
    var curent_gview_lat    =   jQuery('#agency_map').attr('data-cur_lat');
    var curent_gview_long   =   jQuery('#agency_map').attr('data-cur_long');
    var mapOptions_intern = {
        flat:false,
        noClear:false,
        zoom:  5,
        scrollwheel: false,
        draggable: true,
        center: new google.maps.LatLng(curent_gview_lat,curent_gview_long ),
        streetViewControl:false,
        disableDefaultUI: true,
        mapTypeId: mapfunctions_vars.type.toLowerCase(),
        gestureHandling: 'cooperative'
    };
   
    
    map_agency= new google.maps.Map(document.getElementById('agency_map'), mapOptions_intern);
     if(mapfunctions_vars.map_style !==''){
       var styles = JSON.parse ( mapfunctions_vars.map_style );
       map_agency.setOptions({styles: styles});
    }
   
    google.maps.visualRefresh = true;
    google.maps.event.trigger(map_agency, 'resize');
    
    var myLatLng = new google.maps.LatLng(curent_gview_lat, curent_gview_long);
    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map_agency,
        icon: wpesate_custompin_agency(),
        shape: shape,
        title: 'we are here',
        zIndex: 1,
        infoWindowIndex : 0 
     });
 

}

function wpesate_custompin_agency(){
    "use strict";
    var image = {
        url: mapfunctions_vars.path+'/sale.png', 
        size: new google.maps.Size(59, 59),
        origin: new google.maps.Point(0,0),
        anchor: new google.maps.Point(16,59 )
    };
    return image;
}




function wpestate_map_shortcode_function(){
    var selected_id         =   parseInt( jQuery('#googleMap_shortcode').attr('data-post_id'),10 );
    var curent_gview_lat    =   jQuery('#googleMap_shortcode').attr('data-cur_lat');
    var curent_gview_long   =   jQuery('#googleMap_shortcode').attr('data-cur_long');
    var zoom;
    var map2;
    var gmarkers_sh = [];
   
    if (typeof googlecode_property_vars === 'undefined') {
        zoom=5;
        heading=0;
    }else{
        zoom=googlecode_property_vars.page_custom_zoom;
        heading  = parseInt(googlecode_property_vars.camera_angle);
    }
    var mapOptions_intern = {
        flat:false,
        noClear:false,
        zoom:  parseInt(zoom),
        scrollwheel: false,
        draggable: true,
        center: new google.maps.LatLng(curent_gview_lat,curent_gview_long ),
        streetViewControl:false,
        disableDefaultUI: true,
        mapTypeId: mapfunctions_vars.type.toLowerCase(),
        gestureHandling: 'cooperative'
    };

    map2= new google.maps.Map(document.getElementById('googleMap_shortcode'), mapOptions_intern);
    
   
    google.maps.visualRefresh = true;
    google.maps.event.trigger(map2, 'resize');
    

    width_browser       =   jQuery(window).width();
    
    infobox_width=700;
    vertical_pan=-215;
    if (width_browser<900){
      infobox_width=500;
    }
    if (width_browser<600){
      infobox_width=400;
    }
    if (width_browser<400){
      infobox_width=200;
    }
   var boxText         =   document.createElement("div");
 
    var myOptions = {
        content: boxText,
        disableAutoPan: true,
        maxWidth: infobox_width,
        boxClass:"mybox",
        zIndex: null,			
        closeBoxMargin: "-13px 0px 0px 0px",
        closeBoxURL: "",
        infoBoxClearance: new google.maps.Size(1, 1),
        isHidden: false,
        pane: "floatPane",
        enableEventPropagation: true                   
    };              
    infoBox_sh = new InfoBox(myOptions);    
    
    
    if(mapfunctions_vars.map_style !==''){
       var styles = JSON.parse ( mapfunctions_vars.map_style );
       map2.setOptions({styles: styles});
    }
    var i = 1;
    var id                          =   selected_id;
    var lat                         =   curent_gview_lat;
    var lng                         =   curent_gview_long;
    var title                       =   decodeURIComponent ( jQuery('#googleMap_shortcode').attr('data-title') ); 
    var pin                         =   jQuery('#googleMap_shortcode').attr('data-pin');
    var counter                     =   1;
    var image                       =   decodeURIComponent ( jQuery('#googleMap_shortcode').attr('data-thumb' ));
    var price                       =   decodeURIComponent ( jQuery('#googleMap_shortcode').attr('data-price' ));
    var single_first_type           =   decodeURIComponent ( jQuery('#googleMap_shortcode').attr('data-single-first-type') );        
    var single_first_action         =   decodeURIComponent ( jQuery('#googleMap_shortcode').attr('data-single-first-action') );
    var link                        =   decodeURIComponent ( jQuery('#googleMap_shortcode').attr('data-prop_url' ));
    var city                        =   '';
    var area                        =   '';
    var rooms                       =   jQuery('#googleMap_shortcode').attr('data-rooms') ;
    var baths                       =   jQuery('#googleMap_shortcode').attr('data-bathrooms') ;
    var size                        =   jQuery('#googleMap_shortcode').attr('data-size') ;
    var single_first_type_name      =   decodeURIComponent ( jQuery('#googleMap_shortcode').attr('data-single-first-type') );  
    var single_first_action_name    =   decodeURIComponent ( jQuery('#googleMap_shortcode').attr('data-single-first-action') );
    var agent_id                    =   '' ;   
    var county_state                =   '' ;  
    var price_pin                   =   decodeURIComponent ( jQuery('#googleMap_shortcode').attr('data-pin_price' )); 
    var cleanprice                 =   decodeURIComponent ( jQuery('#googleMap_shortcode').attr('data-clean_price' ));
    createMarker_sh (price_pin,infoBox_sh,gmarkers_sh,map2,county_state, size, i,id,lat,lng,pin,title,counter,image,price,single_first_type,single_first_action,link,city,area,rooms,baths,cleanprice,single_first_type_name, single_first_action_name );
  
    
    var viewPlace   =   new google.maps.LatLng(curent_gview_lat,curent_gview_long);
    panorama        =   map2.getStreetView();
    panorama.setPosition(viewPlace);


    panorama.setPov(/** @type {google.maps.StreetViewPov} */({
      heading: heading,
      pitch: 0
    }));
    
    jQuery('#slider_enable_street_sh').click(function(){
        cur_lat     =   jQuery('#googleMap_shortcode').attr('data-cur_lat');
        cur_long    =   jQuery('#googleMap_shortcode').attr('data-cur_long');
        myLatLng    =   new google.maps.LatLng(cur_lat,cur_long);
      
        panorama.setPosition(myLatLng);
        panorama.setVisible(true); 
        jQuery('#gmapzoomminus_sh,#gmapzoomplus_sh,#slider_enable_street_sh').hide();
     
    });
    google.maps.event.addListener(panorama, "closeclick", function() {
         jQuery('#gmapzoomminus_sh,#gmapzoomplus_sh,#slider_enable_street_sh').show();
    });
    
    
    
    
    if(  document.getElementById('gmapzoomplus_sh') ){
         google.maps.event.addDomListener(document.getElementById('gmapzoomplus_sh'), 'click', function () {      
           var current= parseInt( map2.getZoom(),10);
           current++;
           if(current>20){
               current=20;
           }
           map2.setZoom(current);
        });  
    }
    
    
    if(  document.getElementById('gmapzoomminus_sh') ){
         google.maps.event.addDomListener(document.getElementById('gmapzoomminus_sh'), 'click', function () {      
           var current= parseInt( map2.getZoom(),10);
           current--;
           if(current<0){
               current=0;
           }
           map2.setZoom(current);
        });  
    }
  
    google.maps.event.trigger(gmarkers_sh[0], 'click');  
    setTimeout(function(){
        google.maps.event.trigger(map2, "resize"); 
        map2.setCenter(gmarkers_sh[0].position);  
            switch (infobox_width){
                case 700:
                     map2.panBy(100,-150);

                     vertical_off=0;
                     break;
                case 500: 
                     map2.panBy(50,-120);
                     break;
                case 400: 
                     map2.panBy(100,-220);
                     break;
                case 200: 
                     map2.panBy(20,-170);
                     break;               
            }
    }, 300);
    


    wpestate_initialize_poi(map2,2);
    
    
}






function createMarker_sh (pin_price,infoBox_sh,gmarkers_sh,map2,county_state, size, i,id,lat,lng,pin,title,counter,image,price,single_first_type,single_first_action,link,city,area,rooms,baths,cleanprice,single_first_type_name, single_first_action_name ){
    var new_title   =   '';
    var myLatLng    =   new google.maps.LatLng(lat,lng);
    var poss=0;
    var infobox_class=" price_infobox ";
    if(mapfunctions_vars.useprice === 'yes'){
 

        var myLatLng        =   new google.maps.LatLng(lat,lng);
        var Titlex          =   jQuery('<textarea />').html(title).text();
        var myLatlng        =   new google.maps.LatLng(lat,lng);
        var infoWindowIndex =   999;
        var poss=11;
 
        var price2=price;
        var my_custom_curr_pos     =   parseFloat( getCookie_map('my_custom_curr_pos'));
        if (!isNaN(my_custom_curr_pos) && my_custom_curr_pos !== -1) {
                 
            var converted_price= wpestate_get_price_currency(cleanprice,cleanprice);
            var testRE = price.match('</span>(.*)<span class=');
            if (testRE !== null ){
                var price2=price.replace(testRE[1],converted_price)
            }
        }
            
     
        marker= new WpstateMarker(
            poss,
            myLatlng, 
            map2, 
            Titlex,
            counter,
            image,
            id,
            
            price2,
            pin_price,
            single_first_type,
            single_first_action,
            link,
            i,
            rooms,
            baths,
            cleanprice,
            size,
            single_first_type_name,
            single_first_action_name,
            pin,
            infoWindowIndex
        );
        
    
    }else{
        infobox_class=" classic_info "
        var marker = new google.maps.Marker({
               position: myLatLng,
               map: map2,
               icon: custompin(pin),
               shape: shape,
               title: title,
               zIndex: counter,
               image:image,
               idul:id,
               price:price,
               category:single_first_type,
               action:single_first_action,
               link:link,
               city:city,
               area:area,
               infoWindowIndex : i,
               rooms:rooms,
               baths:baths,
               cleanprice:cleanprice,
               size:size,
               county_state:county_state,
               category_name:single_first_type_name,
               action_name:single_first_action_name
              });
    }
    
    gmarkers_sh.push(marker);
 
    google.maps.event.addListener(marker, 'click', function(event) {

            if(this.image===''){
                info_image='<img src="' + mapfunctions_vars.path + '/idxdefault.jpg" alt="image" />';
             }else{
                info_image=this.image;
             }
            
            var category         =   decodeURIComponent ( this.category.replace(/-/g,' ') );
            var action           =   decodeURIComponent ( this.action.replace(/-/g,' ') );
            var category_name    =   decodeURIComponent ( this.category_name.replace(/-/g,' ') );
            var action_name      =   decodeURIComponent ( this.action_name.replace(/-/g,' ') );
            var in_type          =   mapfunctions_vars.in_text;
            if(category==='' || action===''){
                in_type=" ";
            }
            
           var infobaths; 
           if(this.baths!=''){
               infobaths ='<span id="infobath">'+this.baths+'</span>';
           }else{
               infobaths =''; 
           }
           
           var inforooms;
           if(this.rooms!=''){
               inforooms='<span id="inforoom">'+this.rooms+'</span>';
           }else{
               inforooms=''; 
           }
           
           var infosize;
           if(this.size!=''){
                infosize ='<span id="infosize">'+this.size;
                infosize =infosize+'</span>';
           }else{
               infosize=''; 
           }
        
        
           var title=  this.title.substr(0, 45)
           if(this.title.length > 45){
               title=title+"...";
           }
        
            infoBox_sh.setContent('<div class="info_details '+infobox_class+'"><span id="infocloser" onClick=\'javascript:infoBox_sh.close();\' ></span><a href="'+this.link+'">'+info_image+'</a><a href="'+this.link+'" id="infobox_title">'+title+'</a><div class="prop_detailsx">'+category_name+" "+in_type+" "+action_name+'</div><div class="prop_pricex">'+wpestate_get_price_currency(this.price,this.cleanprice)+infosize+infobaths+inforooms+'</div></div>' );
            infoBox_sh.open(map2, this);    
            map2.setCenter(this.position);   

            
           
    


//            switch (infobox_width){
//                case 700:
//                     map2.panBy(100,-150);
//
//                     vertical_off=0;
//                     break;
//                case 500: 
//                     map2.panBy(50,-120);
//                     break;
//                case 400: 
//                     map2.panBy(100,-220);
//                     break;
//                case 200: 
//                     map2.panBy(20,-170);
//                     break;               
//            }
//            
            if (control_vars.show_adv_search_map_close === 'no') {
                $('.search_wrapper').addClass('adv1_close');
                adv_search_click();
            }
            
             close_adv_search();
            });/////////////////////////////////// end event listener
            
         
        
}

>>>>>>> 64662fd89bea560852792d7203888072d7452d48


/////////////////////////////////////////////////////////////////////////////////////////////////
// change map
/////////////////////////////////////////////////////////////////////////////////////////////////  

function  wpestate_change_map_type(map_type){
 
    if(map_type==='map-view-roadmap'){
         map.setMapTypeId(google.maps.MapTypeId.ROADMAP);
    }else if(map_type==='map-view-satellite'){
         map.setMapTypeId(google.maps.MapTypeId.SATELLITE);
    }else if(map_type==='map-view-hybrid'){
         map.setMapTypeId(google.maps.MapTypeId.HYBRID);
    }else if(map_type==='map-view-terrain'){
         map.setMapTypeId(google.maps.MapTypeId.TERRAIN);
    }
   
}

/////////////////////////////////////////////////////////////////////////////////////////////////
//  set markers... loading pins over map
/////////////////////////////////////////////////////////////////////////////////////////////////  

<<<<<<< HEAD
function setMarkers(map, locations) {
   "use strict";
    var map_open;    
=======
function setMarkers(map, locations, with_bound) {
    "use strict";
    var map_open;          
     
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    var myLatLng;
    var selected_id     =   parseInt( jQuery('#gmap_wrapper').attr('data-post_id') );
    if( isNaN(selected_id) ){
        selected_id     =   parseInt( jQuery('#googleMapSlider').attr('data-post_id'),10 );
    }
<<<<<<< HEAD

=======
   
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    var open_height     =   parseInt(mapfunctions_vars.open_height,10);
    var closed_height   =   parseInt(mapfunctions_vars.closed_height,10);
    var boxText         =   document.createElement("div");
    width_browser       =   jQuery(window).width();
    
    infobox_width=700;
    vertical_pan=-215;
    if (width_browser<900){
      infobox_width=500;
    }
    if (width_browser<600){
      infobox_width=400;
    }
    if (width_browser<400){
      infobox_width=200;
    }
 
 
    var myOptions = {
<<<<<<< HEAD
                     content: boxText,
                     disableAutoPan: true,
                     maxWidth: infobox_width,
                     boxClass:"mybox",
                     zIndex: null,			
                     closeBoxMargin: "-13px 0px 0px 0px",
                     closeBoxURL: "",
                     infoBoxClearance: new google.maps.Size(1, 1),
                     isHidden: false,
                     pane: "floatPane",
                     enableEventPropagation: true                   
                  };              
   infoBox = new InfoBox(myOptions);         
                                

    for (var i = 0; i < locations.length; i++) {
        var beach                 = locations[i];
        var id                    = beach[10];
        var lat                   = beach[1];
        var lng                   = beach[2];
        var title                 = decodeURIComponent ( beach[0] );
        var pin                   = beach[8];
        var counter               = beach[3];
        var image                 = decodeURIComponent ( beach[4] );
        var price                 = decodeURIComponent ( beach[5] );
        var single_first_type     = decodeURIComponent ( beach[6] );          
        var single_first_action   = decodeURIComponent ( beach[7] );
        var link                  = decodeURIComponent ( beach[9] );
        var city                  = decodeURIComponent ( beach[11] );
        var area                  = decodeURIComponent ( beach[12] );
        var cleanprice            = beach[13];
        var rooms                 = beach[14];
        var baths                 = beach[15];
        var size                  = beach[16];
        var single_first_type_name= decodeURIComponent ( beach[17] );
        var single_first_action_name= decodeURIComponent ( beach[18] );
           
        if(mapfunctions_vars.custom_search==='yes'){
            var slug1                 = beach[19];
            var val1                  = beach[20];
            var how1                  = beach[21];
            
            var slug2                 = beach[22];
            var val2                  = beach[23];
            var how2                  = beach[24];
            
            var slug3                 = beach[25];
            var val3                  = beach[26];
            var how3                  = beach[27];
           
            var slug4                 = beach[28];
            var val4                  = beach[29];
            var how4                  = beach[30];
            
            var slug5                 = beach[31];
            var val5                  = beach[32];
            var how5                  = beach[33];
            
            var slug6                 = beach[34];
            var val6                  = beach[35];
            var how6                  = beach[36];
            
            var slug7                 = beach[37];
            var val7                  = beach[38];
            var how7                  = beach[39];
            
            var slug8                 = beach[40];
            var val8                  = beach[41];
            var how8                  = beach[42];
        } 
       
        if( typeof( googlecode_regular_vars2) !== 'undefined' && typeof( googlecode_regular_vars2.markers2 )!=='undefined' && googlecode_regular_vars2.markers2.length > 2 &&  typeof (googlecode_regular_vars2.taxonomy )!=='undefined'){      
            //single_first_type single_first_action city area
     
            if(googlecode_regular_vars2.taxonomy === 'property_city'){
                if( googlecode_regular_vars2.term === city){
                    createMarker (size, i,id,lat,lng,pin,title,counter,image,price,single_first_type,single_first_action,link,city,area,rooms,baths,cleanprice,slug1,val1,how1,slug2,val2,how2,slug3,val3,how3,slug4,val4,how4, slug5, val5, how5, slug6, val6, how6 ,slug7 ,val7, how7, slug8, val8, how8,single_first_type_name, single_first_action_name)
                }
            }
            
            if(googlecode_regular_vars2.taxonomy === 'property_area'){
                if( googlecode_regular_vars2.term === area){
                    createMarker (size, i,id,lat,lng,pin,title,counter,image,price,single_first_type,single_first_action,link,city,area,rooms,baths,cleanprice,slug1,val1,how1,slug2,val2,how2,slug3,val3,how3,slug4,val4,how4, slug5, val5, how5, slug6, val6, how6 ,slug7 ,val7, how7, slug8, val8, how8,single_first_type_name, single_first_action_name)
                }    
            }
            
            if(googlecode_regular_vars2.taxonomy === 'property_category'){
                if( googlecode_regular_vars2.term === single_first_type){
                    createMarker (size, i,id,lat,lng,pin,title,counter,image,price,single_first_type,single_first_action,link,city,area,rooms,baths,cleanprice,slug1,val1,how1,slug2,val2,how2,slug3,val3,how3,slug4,val4,how4, slug5, val5, how5, slug6, val6, how6 ,slug7 ,val7, how7, slug8, val8, how8,single_first_type_name, single_first_action_name)
                }  
            }
            
            if(googlecode_regular_vars2.taxonomy === 'property_action_category'){
                if( googlecode_regular_vars2.term === single_first_action){
                    createMarker (size, i,id,lat,lng,pin,title,counter,image,price,single_first_type,single_first_action,link,city,area,rooms,baths,cleanprice,slug1,val1,how1,slug2,val2,how2,slug3,val3,how3,slug4,val4,how4, slug5, val5, how5, slug6, val6, how6 ,slug7 ,val7, how7, slug8, val8, how8,single_first_type_name, single_first_action_name)
                }  
            }
            
            
            
        }else{
            createMarker (size, i,id,lat,lng,pin,title,counter,image,price,single_first_type,single_first_action,link,city,area,rooms,baths,cleanprice,slug1,val1,how1,slug2,val2,how2,slug3,val3,how3,slug4,val4,how4, slug5, val5, how5, slug6, val6, how6 ,slug7 ,val7, how7, slug8, val8, how8,single_first_type_name, single_first_action_name)
        }
=======
        content: boxText,
        disableAutoPan: true,
        maxWidth: infobox_width,
        boxClass:"mybox",
        zIndex: null,			
        closeBoxMargin: "-13px 0px 0px 0px",
        closeBoxURL: "",
        infoBoxClearance: new google.maps.Size(1, 1),
        isHidden: false,
        pane: "floatPane",
        enableEventPropagation: true                   
    };              
    infoBox = new InfoBox(myOptions);         
                                
    bounds = new google.maps.LatLngBounds();

    for (var i = 0; i < locations.length; i++) {
        var beach                       =   locations[i];
        var id                          =   beach[10];
        var lat                         =   beach[1];
        var lng                         =   beach[2];
        var title                       =   decodeURIComponent ( beach[0] );
        var pin                         =   beach[8];
        var counter                     =   beach[3];
        var image                       =   decodeURIComponent ( beach[4] );
        var price                       =   decodeURIComponent ( beach[5] );
        var single_first_type           =   decodeURIComponent ( beach[6] );          
        var single_first_action         =   decodeURIComponent ( beach[7] );
        var link                        =   decodeURIComponent ( beach[9] );
        var cleanprice                  =   beach[11];
        var rooms                       =   beach[12];
        var baths                       =   beach[13];
        var size                        =   beach[14];
        var single_first_type_name      =   decodeURIComponent ( beach[15] );
        var single_first_action_name    =   decodeURIComponent ( beach[16] );
        var pin_price                   =   decodeURIComponent ( beach[17] );
      
           
        createMarker ( pin_price,size, i,id,lat,lng,pin,title,counter,image,price,single_first_type,single_first_action,link,rooms,baths,cleanprice,single_first_type_name, single_first_action_name);
        
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        // found the property
        if(selected_id===id){
            found_id=i;
        }
       
<<<<<<< HEAD
       // createMarker (i,id,lat,lng,pin,title,counter,image,price,single_first_type,single_first_action,link,city,area,rooms,baths,cleanprice )
    }//end for



    // pan to the latest pin for taxonmy and adv search  
    if(mapfunctions_vars.generated_pins!=='0'){
        myLatLng  = new google.maps.LatLng(lat, lng);
        pan_to_last_pin(myLatLng);
    }
    
    if(mapfunctions_vars.is_prop_list==='1' || mapfunctions_vars.is_tax==='1' ){
      
      show_pins_filters_from_file();
    }
=======
      
    }//end for

  
    map_cluster();
    if( !jQuery('body').hasClass('single-estate_property') ){
        oms = new OverlappingMarkerSpiderfier(map, {markersWontMove: true, markersWontHide: true,keepSpiderfied :true,legWeight:2});
        setOms(gmarkers); 
    }

    if(with_bound===1){
        if (!bounds.isEmpty()) {
          
            wpestate_fit_bounds(bounds);
        }else{
            wpestate_fit_bounds_nolsit();
        }
    }          
    
    // pan to the latest pin for taxonmy and adv search  
    if(mapfunctions_vars.generated_pins!=='0'){
        myLatLng  = new google.maps.LatLng(lat, lng);
    }
    
  
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
   
   
}// end setMarkers


/////////////////////////////////////////////////////////////////////////////////////////////////
//  create marker
/////////////////////////////////////////////////////////////////////////////////////////////////  

<<<<<<< HEAD
function createMarker (size, i,id,lat,lng,pin,title,counter,image,price,single_first_type,single_first_action,link,city,area,rooms,baths,cleanprice,slug1,val1,how1,slug2,val2,how2,slug3,val3,how3,slug4,val4,how4,slug5, val5, how5, slug6, val6, how6 ,slug7 ,val7, how7, slug8, val8, how8, single_first_type_name, single_first_action_name ){

    var new_title='';
    var myLatLng = new google.maps.LatLng(lat,lng);
    if(mapfunctions_vars.custom_search==='yes'){
        new_title =  title.replace('%',' ');
        new_title = decodeURIComponent(  new_title.replace(/\+/g,' '));
 
    
        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            icon: custompin(pin),
            shape: shape,
            title:new_title,
            zIndex: counter,
            image:image,
            idul:id,
            price:price,
            category:single_first_type,
            action:single_first_action,
            link:link,
            city:city,
            area:area,
            infoWindowIndex : i,
            rooms:rooms,
            baths:baths,
            size:size,
            cleanprice:cleanprice,
            size:size,
            category_name:single_first_type_name,
            action_name:single_first_action_name,
            slug1: slug1,
            val1: val1,
            howto1:how1,
            slug2:slug2,
            val2: val2,
            howto2:how2,
            slug3:slug3,
            val3: val3,
            howto3:how3,
            slug4:slug4,
            val4: val4,
            howto4:how4,
            slug5:slug5,
            val5: val5,
            howto5:how5,
            slug6:slug6,
            val6: val6,
            howto6:how7,
            slug7:slug7,
            val7: val7,
            howto7:how7,
            slug8:slug8,
            val8: val8,
            howto8:how8
            });
            
    }else{
         var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                icon: custompin(pin),
                shape: shape,
                title: title,
                zIndex: counter,
                image:image,
                idul:id,
                price:price,
                category:single_first_type,
                action:single_first_action,
                link:link,
                city:city,
                area:area,
                infoWindowIndex : i,
                rooms:rooms,
                baths:baths,
                cleanprice:cleanprice,
                size:size,
                category_name:single_first_type_name,
                action_name:single_first_action_name
               });
              
                  
    }

    gmarkers.push(marker);
 
    google.maps.event.addListener(marker, 'click', function(event) {
            
          //  new_open_close_map(1);

            map_callback( new_open_close_map );
            google.maps.event.trigger(map, 'resize');

            if(this.image===''){
                 info_image='<img src="' + mapfunctions_vars.path + '/idxdefault.jpg" alt="image" />';
             }else{
                 info_image=this.image;
             }
            
            var category         =   decodeURIComponent ( this.category.replace(/-/g,' ') );
            var action           =   decodeURIComponent ( this.action.replace(/-/g,' ') );
            var category_name    =   decodeURIComponent ( this.category_name.replace(/-/g,' ') );
            var action_name      =   decodeURIComponent ( this.action_name.replace(/-/g,' ') );
            var in_type          =   mapfunctions_vars.in_text;
            if(category==='' || action===''){
                in_type=" ";
            }
            
           var infobaths; 
           if(this.baths!=''){
               infobaths ='<span id="infobath">'+this.baths+'</span>';
           }else{
               infobaths =''; 
           }
           
           var inforooms;
           if(this.rooms!=''){
               inforooms='<span id="inforoom">'+this.rooms+'</span>';
           }else{
               inforooms=''; 
           }
           
           var infosize;
           if(this.size!=''){
               infosize ='<span id="infosize">'+this.size;
               if(mapfunctions_vars.measure_sys==='ft'){
                   infosize = infosize+ ' ft<sup>2</sup>';
               }else{
                   infosize = infosize+' m<sup>2</sup>';
               }
               infosize =infosize+'</span>';
           }else{
               infosize=''; 
           }
        
        
           var title=  this.title.substr(0, 45)
           if(this.title.length > 45){
               title=title+"...";
           }
        
            infoBox.setContent('<div class="info_details"><span id="infocloser" onClick=\'javascript:infoBox.close();\' ></span><a href="'+this.link+'">'+info_image+'</a><a href="'+this.link+'" id="infobox_title">'+title+'</a><div class="prop_detailsx">'+category_name+" "+in_type+" "+action_name+'</div><div class="prop_pricex">'+this.price+infosize+infobaths+inforooms+'</div></div>' );
            infoBox.open(map, this);    
            map.setCenter(this.position);   
=======

function   createMarker ( pin_price,size, i,id,lat,lng,pin,title,counter,image,price,single_first_type,single_first_action,link,rooms,baths,cleanprice,single_first_type_name, single_first_action_name){
        

    var myLatLng = new google.maps.LatLng(lat,lng);
    var Titlex = jQuery('<textarea />').html(title).text();
    var poss=0;
    var infobox_class=" price_infobox ";
 
    if(mapfunctions_vars.useprice === 'yes'){
   

   
        var price2=price;
        var my_custom_curr_pos     =   parseFloat( getCookie_map('my_custom_curr_pos'));
        if (!isNaN(my_custom_curr_pos) && my_custom_curr_pos !== -1) {
            var converted_price= wpestate_get_price_currency(cleanprice,cleanprice);
            var testRE = price.match('</span>(.*)<span class=');
            if (testRE !== null ){
                var price2=price.replace(testRE[1],converted_price)
            }
        }
      
       
	var myLatlng = new google.maps.LatLng(lat,lng);
        marker= new WpstateMarker( 
            poss,
            myLatlng, 
            map, 
            Titlex,
            counter,
            image,
            id,
    
            price2,
            pin_price,
            single_first_type,
            single_first_action,
            link,
            i,
            rooms,
            baths,
            cleanprice,
            size,
            single_first_type_name,
            single_first_action_name,
            pin,
            i
        );
    }else{
        infobox_class=" classic_info "
        var marker = new google.maps.Marker({
            position:           myLatLng,
            map:                map,
            icon:               custompin(pin),
            shape:              shape,
            title:              Titlex,
            zIndex:             counter,
            image:              image,
            idul:               id,
            price:              price,
            category:           single_first_type,
            action:             single_first_action,
            link:               link,
            infoWindowIndex :   i,
            rooms:              rooms,
            baths:              baths,
            cleanprice:         cleanprice,
            size:               size,
            category_name:      single_first_type_name,
            action_name:        single_first_action_name
        });

    }           
    
   
    gmarkers.push(marker);
    bounds.extend(marker.getPosition());
    google.maps.event.addListener(marker, 'click', function(event) {
            
        //  new_open_close_map(1);

        map_callback( new_open_close_map );
        google.maps.event.trigger(map, 'resize');

        if(this.image===''){
            info_image='<img src="' + mapfunctions_vars.path + '/idxdefault.jpg" alt="image" />';
        }else{
            info_image=this.image;
        }

        var category         =   decodeURIComponent ( this.category.replace(/-/g,' ') );
        var action           =   decodeURIComponent ( this.action.replace(/-/g,' ') );
        var category_name    =   decodeURIComponent ( this.category_name.replace(/-/g,' ') );
        var action_name      =   decodeURIComponent ( this.action_name.replace(/-/g,' ') );
        var in_type          =   mapfunctions_vars.in_text;
        if(category==='' || action===''){
            in_type=" ";
        }

        var infobaths; 
        if(this.baths!=''){
            infobaths ='<span id="infobath">'+this.baths+'</span>';
        }else{
            infobaths =''; 
        }

        var inforooms;
        if(this.rooms!=''){
            inforooms='<span id="inforoom">'+this.rooms+'</span>';
        }else{
            inforooms=''; 
        }
           
        var infosize;
        if(this.size!=''){
            infosize ='<span id="infosize">'+this.size;
			/*
            if(mapfunctions_vars.measure_sys==='ft'){
                infosize = infosize+ ' ft<sup>2</sup>';
            }else{
                infosize = infosize+' m<sup>2</sup>';
            }
			*/
            infosize =infosize+'</span>';
        }else{
            infosize=''; 
        }
        
        
        var title=  this.title.substr(0, 45)
        if(this.title.length > 45){
            title=title+"...";
        }
        
        infoBox.setContent('<div class="info_details '+infobox_class+'"><span id="infocloser" onClick=\'javascript:infoBox.close();\' ></span><a href="'+this.link+'">'+info_image+'</a><a href="'+this.link+'" id="infobox_title">'+title+'</a><div class="prop_detailsx">'+category_name+" "+in_type+" "+action_name+'</div><div class="prop_pricex">'+wpestate_get_price_currency(this.price,this.cleanprice)+infosize+infobaths+inforooms+'</div></div>' );
        infoBox.open(map, this);    
        map.setCenter(this.position);   
>>>>>>> 64662fd89bea560852792d7203888072d7452d48

            
           
    


<<<<<<< HEAD
            switch (infobox_width){
              case 700:
                 
                    if(mapfunctions_vars.listing_map === 'top'){
                        map.panBy(100,-150);
                    }else{
                        if(mapfunctions_vars.small_slider_t==='vertical'){
                            map.panBy(300,-300);
                          
                        }else{
                            map.panBy(10,-110);
                        }    
                   }
                 
                   vertical_off=0;
                   break;
              case 500: 
                   map.panBy(50,-120);
                   break;
              case 400: 
                   map.panBy(100,-220);
                   break;
              case 200: 
                   map.panBy(20,-170);
                   break;               
             }
=======
        switch (infobox_width){
            case 700:
               
                if(mapfunctions_vars.listing_map === 'top'){
                    map.panBy(100,-150);
                }else{
                    if(mapfunctions_vars.small_slider_t==='vertical'){
                        map.panBy(300,-300);

                    }else{
                        map.panBy(10,-110);
                    }    
                }

                vertical_off=0;
                break;
            case 500: 
                map.panBy(50,-120);
                break;
            case 400: 
                map.panBy(20,-150);
                break;
            case 200: 
                map.panBy(20,-170);
                break;               
            }
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
            
            if (control_vars.show_adv_search_map_close === 'no') {
                $('.search_wrapper').addClass('adv1_close');
                adv_search_click();
            }
            
<<<<<<< HEAD
             close_adv_search();
            });/////////////////////////////////// end event listener
            
        if(mapfunctions_vars.generated_pins!=='0'){
            pan_to_last_pin(myLatLng);
        }    
            
=======
            close_adv_search();
    });/////////////////////////////////// end event listener
            
         
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        
}

function  pan_to_last_pin(myLatLng){
<<<<<<< HEAD
       map.setCenter(myLatLng);   
=======
    map.setCenter(myLatLng);   
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
}



<<<<<<< HEAD
=======

>>>>>>> 64662fd89bea560852792d7203888072d7452d48
/////////////////////////////////////////////////////////////////////////////////////////////////
//  map set search
/////////////////////////////////////////////////////////////////////////////////////////////////  
function setOms(gmarkers){
    for (var i = 0; i < gmarkers.length; i++) {
        if(typeof oms !== 'undefined'){
           oms.addMarker(gmarkers[i]);
        }else{
      
        }
    }
    
}

/////////////////////////////////////////////////////////////////////////////////////////////////
//  map set search
/////////////////////////////////////////////////////////////////////////////////////////////////  

function set_google_search(map){
    var input,searchBox,places;
    
    input = (document.getElementById('google-default-search'));
<<<<<<< HEAD
 //   map.controls[google.maps.ControlPosition.TOP_RIGHT].push(input);
=======
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    searchBox = new google.maps.places.SearchBox(input);
    
   
    google.maps.event.addListener(searchBox, 'places_changed', function() {
    places = searchBox.getPlaces();
        
        if (places.length == 0) {
          return;
        }
        
        var bounds = new google.maps.LatLngBounds();
        for (var i = 0, place; place = places[i]; i++) {
          var image = {
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(25, 25)
          };

        // Create a marker for each place.
        var marker = new google.maps.Marker({
          map: map,
          icon: image,
          title: place.name,
          position: place.geometry.location
        });

        gmarkers.push(marker);

        bounds.extend(place.geometry.location);
    
    }

    map.fitBounds(bounds);
<<<<<<< HEAD
=======
    if (!bounds.isEmpty()) {
        wpestate_fit_bounds(bounds);
    }else{
        wpestate_fit_bounds_nolsit();
    }
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    map.setZoom(15);
  });

  
    google.maps.event.addListener(map, 'bounds_changed', function() {
    var bounds = map.getBounds();
    searchBox.setBounds(bounds);
  });
    
}

<<<<<<< HEAD



=======
function wpestate_fit_bounds_nolsit(){
    map.setZoom(3);       
}



function wpestate_fit_bounds(bounds){
   
    if(placeCircle!=''){
        map.fitBounds(placeCircle.getBounds());
    }else{
         map.fitBounds(bounds);
        google.maps.event.addListenerOnce(map, 'idle', function() {
            if( map.getZoom()>15 ) {
                map.setZoom(15);
            }
        });
    }

  
}


>>>>>>> 64662fd89bea560852792d7203888072d7452d48
/////////////////////////////////////////////////////////////////////////////////////////////////
//  open close map
/////////////////////////////////////////////////////////////////////////////////////////////////  

function new_open_close_map(type){
    
    if( jQuery('#gmap_wrapper').hasClass('fullmap') ){
        return;
    }
    
    if(mapfunctions_vars.open_close_status !== '1'){ // we can resize map
        
        var current_height  =   jQuery('#googleMap').outerHeight();
        var closed_height   =   parseInt(mapfunctions_vars.closed_height,10);
        var open_height     =   parseInt(mapfunctions_vars.open_height,10);
        var googleMap_h     =   open_height;
        var gmapWrapper_h   =   open_height;
          
        if( infoBox!== null){
            infoBox.close(); 
        }
     
        if ( current_height === closed_height )  {                       
            googleMap_h = open_height;                                
            if (Modernizr.mq('only all and (max-width: 940px)')) {
               gmapWrapper_h = open_height;
            } else {
                jQuery('#gmap-menu').show(); 
                gmapWrapper_h = open_height;
            }
        
            new_show_advanced_search();
            vertical_off=0;
            jQuery('#openmap').empty().append('<i class="fa fa-angle-up"></i>'+mapfunctions_vars.close_map);

        } else if(type===2) {
            jQuery('#gmap-menu').hide();
            jQuery('#advanced_search_map_form').hide();
            googleMap_h = gmapWrapper_h = closed_height;
           
            // hide_advanced_search();
            new_hide_advanced_search();
            vertical_off=150;           
        }
<<<<<<< HEAD

        jQuery('#googleMap').animate({'height': googleMap_h+'px'});
        jQuery('#gmap_wrapper').animate({'height': gmapWrapper_h+'px'},300,function(){
            google.maps.event.trigger(map, "resize");
            jQuery('.tooltip').fadeOut("fast");
        })
      
=======
        jQuery('#gmap_wrapper').css('height', gmapWrapper_h+'px');
        jQuery('#googleMap').css('height', googleMap_h+'px');
        jQuery('.tooltip').fadeOut("fast");
        
        
        setTimeout(function(){google.maps.event.trigger(map, "resize"); }, 300);
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    }
}





/////////////////////////////////////////////////////////////////////////////////////////////////
//  build map cluter
/////////////////////////////////////////////////////////////////////////////////////////////////   
<<<<<<< HEAD
  function map_cluster(){
=======
function map_cluster(){
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
       if(mapfunctions_vars.user_cluster==='yes'){
        clusterStyles = [
            {
            textColor: '#ffffff',    
            opt_textColor: '#ffffff',
            url: mapfunctions_vars.path+'/cloud.png',
            height: 72,
            width: 72,
            textSize:15,
           
            }
        ];
        mcOptions = {gridSize: 50,
                    ignoreHidden:true, 
<<<<<<< HEAD
                    maxZoom: mapfunctions_vars.zoom_cluster, 
=======
                    maxZoom: parseInt( mapfunctions_vars.zoom_cluster,10), 
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
                    styles: clusterStyles
                };
        mcluster = new MarkerClusterer(map, gmarkers, mcOptions);
        mcluster.setIgnoreHidden(true);
    }
   
  }  
    
    
      
/////////////////////////////////////////////////////////////////////////////////////////////////
/// zoom
/////////////////////////////////////////////////////////////////////////////////////////////////
  
    
if(  document.getElementById('gmapzoomplus') ){
     google.maps.event.addDomListener(document.getElementById('gmapzoomplus'), 'click', function () {      
       var current= parseInt( map.getZoom(),10);
       current++;
       if(current>20){
           current=20;
       }
       map.setZoom(current);
    });  
}
    
    
if(  document.getElementById('gmapzoomminus') ){
     google.maps.event.addDomListener(document.getElementById('gmapzoomminus'), 'click', function () {      
       var current= parseInt( map.getZoom(),10);
       current--;
       if(current<0){
           current=0;
       }
       map.setZoom(current);
    });  
}
        
    
    
/////////////////////////////////////////////////////////////////////////////////////////////////
/// geolocation
/////////////////////////////////////////////////////////////////////////////////////////////////

if(  document.getElementById('geolocation-button') ){
    google.maps.event.addDomListener(document.getElementById('geolocation-button'), 'click', function () {      
<<<<<<< HEAD
         myposition(map);
         close_adv_search();
=======
        myposition(map);
        close_adv_search();
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    });  
}


if(  document.getElementById('mobile-geolocation-button') ){
    google.maps.event.addDomListener(document.getElementById('mobile-geolocation-button'), 'click', function () {   
         myposition(map);
         close_adv_search();
    });  
}


<<<<<<< HEAD
jQuery('#mobile-geolocation-button,#geolocation-button').click(function(){   
     myposition(map);
})
=======
>>>>>>> 64662fd89bea560852792d7203888072d7452d48



function myposition(map){    
<<<<<<< HEAD
    if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(showMyPosition,errorCallback,{timeout:10000});
    }
    else
    {
=======
    
    if(navigator.geolocation){
        var latLong;
        if (location.protocol === 'https:') {
            navigator.geolocation.getCurrentPosition(showMyPosition_original,errorCallback,{timeout:10000});
        }else{
            jQuery.getJSON("http://ipinfo.io", function(ipinfo){
                latLong = ipinfo.loc.split(",");
                showMyPosition (latLong);
            });
        }
      
    }else{
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        alert(mapfunctions_vars.geo_no_brow);
    }
}


function errorCallback(){
    alert(mapfunctions_vars.geo_no_pos);
}




<<<<<<< HEAD

function showMyPosition(pos){
=======
function showMyPosition_original(pos){
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
   
    var shape = {
       coord: [1, 1, 1, 38, 38, 59, 59 , 1],
       type: 'poly'
   }; 
   
   var MyPoint=  new google.maps.LatLng( pos.coords.latitude, pos.coords.longitude);
   map.setCenter(MyPoint);   
   
   var marker = new google.maps.Marker({
             position: MyPoint,
             map: map,
             icon: custompinchild(),
             shape: shape,
             title: '',
             zIndex: 999999999,
             image:'',
             price:'',
             category:'',
             action:'',
             link:'' ,
             infoWindowIndex : 99 ,
             radius: parseInt(mapfunctions_vars.geolocation_radius,10)+' '+mapfunctions_vars.geo_message
            });
    
     var populationOptions = {
      strokeColor: '#67cfd8',
      strokeOpacity: 0.6,
      strokeWeight: 1,
      fillColor: '#67cfd8',
      fillOpacity: 0.2,
      map: map,
      center: MyPoint,
      radius: parseInt(mapfunctions_vars.geolocation_radius,10)
    };
    var cityCircle = new google.maps.Circle(populationOptions);
    
        var label = new Label({
          map: map
        });
        label.bindTo('position', marker);
        label.bindTo('text', marker, 'radius');
        label.bindTo('visible', marker);
        label.bindTo('clickable', marker);
        label.bindTo('zIndex', marker);

}
    
    
<<<<<<< HEAD
    
function custompinchild(){
    "use strict";
    var custom_img;
    if(images['userpin']===''){
        custom_img= mapfunctions_vars.path+'/'+'userpin'+'.png';     
    }else{
        custom_img=images['userpin'];
    }
   
 var   image = {
      url: custom_img, 
      size: new google.maps.Size(59, 59),
      origin: new google.maps.Point(0,0),
      anchor: new google.maps.Point(16,59 )
    };
    return image;
  
}



// same thing as above but with ipad double click workaroud solutin
jQuery('#googleMap').click(function(event){
    var time_diff; 
    time_diff=event.timeStamp-ipad_time;
    
    if(time_diff>300){
       // alert(event.timeStamp-ipad_time);
        ipad_time=event.timeStamp;
       /* if(map.scrollwheel===false){
            map.setOptions({'scrollwheel': true});
            jQuery('#googleMap').addClass('scrollon');
        }else{
            map.setOptions({'scrollwheel': false});
             jQuery('#googleMap').removeClass('scrollon');
        }
        */
        jQuery('.tooltip').fadeOut("fast"); 


        if (Modernizr.mq('only all and (max-width: 1025px)')) {    
           if(map.draggable === false){
                 map.setOptions({'draggable': true});
            }else{
                 map.setOptions({'draggable': false});
            }    
         }
         
     }     
});





=======
var geo_markers =   [];
var geo_circle  =   [];
var geo_label   =   [];

function showMyPosition(pos){
   
    for (var i = 0; i < geo_markers.length; i++) {
        geo_markers[i].setMap(null);
        geo_circle[i].setMap(null);
        geo_label[i].setMap(null);
    }
    
    geo_markers =   [];  
    geo_circle  =   [];
    geo_label   =   [];
    
    
    var shape = {
        coord: [1, 1, 1, 38, 38, 59, 59 , 1],
        type: 'poly'
    }; 
   
    // var MyPoint=  new google.maps.LatLng( pos.coords.latitude, pos.coords.longitude);
   
    var MyPoint=  new google.maps.LatLng( pos[0], pos[1]);
    map.setCenter(MyPoint);   
    map.setZoom(13);
    var marker = new google.maps.Marker({
            position: MyPoint,
            map: map,
            icon: custompinchild(),
            shape: shape,
            title: '',
            zIndex: 999999999,
            image:'',
            price:'',
            category:'',
            action:'',
            link:'' ,
            infoWindowIndex : 99 ,
            radius: parseInt(mapfunctions_vars.geolocation_radius,10)+' '+mapfunctions_vars.geo_message
            });
    geo_markers.push(marker);
    
    
    var populationOptions = {
        strokeColor: '#67cfd8',
        strokeOpacity: 0.6,
        strokeWeight: 1,
        fillColor: '#67cfd8',
        fillOpacity: 0.2,
        map: map,
        center: MyPoint,
        radius: parseInt(mapfunctions_vars.geolocation_radius,10)
    };
    
    
    
    var cityCircle = new google.maps.Circle(populationOptions);
    geo_circle.push(cityCircle);
    
    var label = new Label({
        map: map
    });
        
    label.bindTo('position', marker);
    label.bindTo('text', marker, 'radius');
    label.bindTo('visible', marker);
    label.bindTo('clickable', marker);
    label.bindTo('zIndex', marker);
    geo_label.push(cityCircle);
}
    
    
    
function custompinchild(){
    "use strict";

    var custom_img;
    var extension='';
    var ratio = jQuery(window).dense('devicePixelRatio');
    
    if(ratio>1){
        extension='_2x';
    }
    
    
    if( typeof( images['userpin'] )=== 'undefined' ||  images['userpin']===''){
        custom_img= mapfunctions_vars.path+'/'+'userpin'+extension+'.png';     
    }else{
        custom_img=images['userpin'];
        if(ratio>1){
            custom_img=custom_img.replace(".png","_2x.png");
        }
    }
   
   
    
    
    
    if(ratio>1){
         
        var   image = {
            url: custom_img, 
            size: new google.maps.Size(88, 96),
            scaledSize   :  new google.maps.Size(44, 48),
            origin: new google.maps.Point(0,0),
            anchor: new google.maps.Point(16,59 )
        };
     
    }else{
       var   image = {
            url: custom_img, 
            size: new google.maps.Size(59, 59),
            origin: new google.maps.Point(0,0),
            anchor: new google.maps.Point(16,59 )
        };
    }
    
    
    return image;
  
}
>>>>>>> 64662fd89bea560852792d7203888072d7452d48




/////////////////////////////////////////////////////////////////////////////////////////////////
/// 
/////////////////////////////////////////////////////////////////////////////////////////////////

if( document.getElementById('gmap') ){
    google.maps.event.addDomListener(document.getElementById('gmap'), 'mouseout', function () {           
<<<<<<< HEAD
      //  map.setOptions({'scrollwheel': true});
=======
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        google.maps.event.trigger(map, "resize");
    });  
}     


if(  document.getElementById('search_map_button') ){
    google.maps.event.addDomListener(document.getElementById('search_map_button'), 'click', function () {  
        infoBox.close();
    });  
}



if(  document.getElementById('advanced_search_map_button') ){
    google.maps.event.addDomListener(document.getElementById('advanced_search_map_button'), 'click', function () {  
       infoBox.close();
    }); 
}
 
////////////////////////////////////////////////////////////////////////////////////////////////
/// navigate troguh pins 
///////////////////////////////////////////////////////////////////////////////////////////////

jQuery('#gmap-next').click(function(){
    current_place++;  
    if (current_place>gmarkers.length){
        current_place=1;
    }
    while(gmarkers[current_place-1].visible===false){
        current_place++; 
        if (current_place>gmarkers.length){
            current_place=1;
        }
    }
    
    if( map.getZoom() <15 ){
        map.setZoom(15);
    }
    google.maps.event.trigger(gmarkers[current_place-1], 'click');
});


jQuery('#gmap-prev').click(function(){
    current_place--;
    if (current_place<1){
        current_place=gmarkers.length;
    }
    while(gmarkers[current_place-1].visible===false){
        current_place--; 
        if (current_place>gmarkers.length){
            current_place=1;
        }
    }
    if( map.getZoom() <15 ){
        map.setZoom(15);
    }
    google.maps.event.trigger(gmarkers[current_place-1], 'click');
});








///////////////////////////////////////////////////////////////////////////////////////////////////////////
/// filter pins 
//////////////////////////////////////////////////////////////////////////////////////////////////////////

jQuery('.advanced_action_div li').click(function(){
   var action = jQuery(this).val();
<<<<<<< HEAD
   //alert ('action: '+action);

=======
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
});





if(  document.getElementById('gmap-menu') ){
    google.maps.event.addDomListener(document.getElementById('gmap-menu'), 'click', function (event) {
        infoBox.close();

        if (event.target.nodeName==='INPUT'){
            category=event.target.className; 

                if(event.target.name==="filter_action[]"){            
                    if(actions.indexOf(category)!==-1){
                        actions.splice(actions.indexOf(category),1);
                    }else{
                        actions.push(category);
                    }
                }

                if(event.target.name==="filter_type[]"){            
                    if(categories.indexOf(category)!==-1){
                        categories.splice(categories.indexOf(category),1);
                    }else{
                        categories.push(category);
                    }
                }

          show(actions,categories);
        }

    }); 
}
<<<<<<< HEAD
  //!visible_or_not(mapfunctions_vars.hows[0], gmarkers[i].val1, val1, mapfunctions_vars.slugs[0])
  
function visible_or_not(how, slug, value, read){
  
    // console.log ("how "+how+"/ slug x "+slug+" /value x , "+value+"/ read "+read);

    if(value!=='' && typeof(value)!=='undefined' ){
       // value = value.replace('%',''); 
    }
    if(slug!=='' && typeof(slug)!=='undefined'){
       // slug = slug.replace('%',''); 
    }

 

    //////////////////////////////////////////////
    // in case of slider - 
    if(read==='property_price' && mapfunctions_vars.slider_price==='yes' ){
        var slider_min= parseInt ( jQuery('#price_low').val() );
        var slider_max= parseInt ( jQuery('#price_max').val() );    
        if( slug >=  slider_min && slug<= slider_max){
            return true;
        }else{
            return  false;
        } 
    }
    //////////////////////////////////////////////
    // END in case of slider - 

    if(read==='none'){
        return true;
    }
    
    
    
    if (value !=='' && value !==' ' && value !=='all' ){
       
        var parsevalue = parseInt(value, 10);
        
        if( how === 'greater' ){
          
            if( slug >=  parsevalue){
                return true
            }else{
                return false;
            }
        } else if( how === 'smaller' ){
         
            slug=parseInt(slug, 10);
            if( slug <= parsevalue ){
               return true;
             
            } else{
                return false;
            }
        } else if( how === 'equal' ){
            if( slug === value || value == 'all' ){
            
                return true;
            } else{
              
                return false;
            }
        } else if( how === 'like' ){
//            value=encodeURIComponent(value);
         
            slug = slug.toLowerCase();
           // slug = str.replace("%20"," ");
            slug = decodeURI(slug);
            value = value.toLowerCase();
              
            if(slug.indexOf(value)> -1 ){
                return true;
            } else{
                return false;
            }
        } else if( how === 'date bigger' ){
          
            slug    =   new Date(slug);
            value   =   new Date(value);
            
            if( slug >= value ){
                return true;
            } else{
                return false;
            }
        } else if( how === 'date smaller' ){
        
            slug    =   new Date(slug);
            value   =   new Date(value);
            
            if( slug <= value ){
                return true;
            } else{
                return false;
            }
        }

        //return false;
    }else{
        return true;
    }
        
}


function get_custom_value(slug){
    var value;
    //console.log("get value for "+ slug);
    if(slug === 'adv_categ' || slug === 'adv_actions' ||  slug === 'advanced_city' ||  slug === 'advanced_area'  ||  slug === 'county-state'){     
        value = jQuery('#'+slug).attr('data-value');
=======
 
function getCookieMap(cname) {
   var name = cname + "=";
   var ca = document.cookie.split(';');
   for(var i=0; i<ca.length; i++) {
       var c = ca[i];
       while (c.charAt(0)==' ') c = c.substring(1);
       if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
   }
   return "";
}



function get_custom_value_tab_search(slug){

    var value='';
    var is_drop=0;
    if(slug === 'adv_categ' || slug === 'adv_actions' ||  slug === 'advanced_city' ||  slug === 'advanced_area'  ||  slug === 'county-state'){     
        value = jQuery('.tab-pane.active #'+slug).attr('data-value');
    } else if(slug === 'property_price' && mapfunctions_vars.slider_price==='yes'){
        value = jQuery('.tab-pane.active #price_low').val();
    }else if(slug === 'property-country'){
        value = jQuery('.tab-pane.active #advanced_country').attr('data-value');
    }else{
  
        if(slug!==''){
            if( jQuery('.tab-pane.active #'+slug).hasClass('filter_menu_trigger') ){ 
                value = jQuery('.tab-pane.active #'+slug).attr('data-value');
                is_drop=1;
            }else{
                value = jQuery('.tab-pane.active #'+slug).val() ;
            }
        }
    }
    
    return value;
 
}
  
  
function get_custom_value(slug){
    /*ok*/
    var value;
    var is_drop=0;
    if(slug === 'adv_categ' || slug === 'adv_actions' ||  slug === 'advanced_city' ||  slug === 'advanced_area'  ||  slug === 'county-state'){     
        value = jQuery('#'+slug).attr('data-value');
    } else if(slug === 'property_price' && mapfunctions_vars.slider_price==='yes'){
        value = jQuery('#price_low').val();
    }else if(slug === 'property-country'){
        value = jQuery('#advanced_country').attr('data-value');
    }else{
      
        if( jQuery('#'+slug).hasClass('filter_menu_trigger') ){ 
            value = jQuery('#'+slug).attr('data-value');
            is_drop=1;
        }else{
            value = jQuery('#'+slug).val() ;
            
        }
    }
    
  
    if (typeof(value)!=='undefined'&& is_drop===0){
      //  value=  value .replace(" ","-");
    }
    
    return value;
 
}
  


function get_custom_value_onthelist(slug){
   
    var value;
    var is_drop=0;
    if(slug === 'adv_categ' || slug === 'adv_actions' ||  slug === 'advanced_city' ||  slug === 'advanced_area'  ||  slug === 'county-state'){     
        value = jQuery('#'+slug).attr('data-value');
        if( slug === 'adv_categ'){
            value =  jQuery('#tax_categ_picked').val();
        }else  if( slug === 'adv_actions'){
            value = jQuery('#tax_action_picked').val();
        }else if( slug === 'advanced_city'){
            value =  jQuery('#tax_city_picked').val();
        }else if( slug === 'advanced_area'){
            value = jQuery('#taxa_area_picked').val();   
        }
         
         
         
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    } else if(slug === 'property_price' && mapfunctions_vars.slider_price==='yes'){
        value = jQuery('#price_low').val();
    }else if(slug === 'property-country'){
        value = jQuery('#advanced_country').attr('data-value');
<<<<<<< HEAD
      
    }else{
        if( jQuery('#'+slug).hasClass('filter_menu_trigger') ){
            value = jQuery('#'+slug).attr('data-value');
        }else{
            value = jQuery('#'+slug).val() ;
        }
        
       
=======
    }else{
      
        if( jQuery('#'+slug).hasClass('filter_menu_trigger') ){ 
            value = jQuery('#'+slug).attr('data-value');
            is_drop=1;
        }else{
            value = jQuery('#'+slug).val() ;
        }
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    }
    
    return value;
}
<<<<<<< HEAD
  
  
  
  
  
function show_pins_custom_search(){
    var val1, val2, val3, val4, val5, val6, val7, val8, position;
    
    val1 =  get_custom_value (mapfunctions_vars.slugs[0]);
    val2 =  get_custom_value (mapfunctions_vars.slugs[1]);
    val3 =  get_custom_value (mapfunctions_vars.slugs[2]);
    val4 =  get_custom_value (mapfunctions_vars.slugs[3]);
    val5 =  get_custom_value (mapfunctions_vars.slugs[4]);
    val6 =  get_custom_value (mapfunctions_vars.slugs[5]);
    val7 =  get_custom_value (mapfunctions_vars.slugs[6]);
    val8 =  get_custom_value (mapfunctions_vars.slugs[7]);

    position = parseInt( mapfunctions_vars.slider_price_position );
    
    if( mapfunctions_vars.slider_price ==='yes' ){
       eval("val"+String(mapfunctions_vars.slider_price_position)+"="+jQuery('#price_low').val()+";");   
       eval("val"+String(position+1)+"="+jQuery('#price_max').val()+";");
    }
  
    if(typeof(val1)==='undefined'){
         val1='';
     }
     if(typeof(val2)==='undefined'){
         val2='';
     }
     if(typeof(val3)==='undefined'){
         val3='';
     }
     if(typeof(val4)==='undefined'){
         val4='';
     }
     if(typeof(val5)==='undefined'){
         val5='';
     }
     if(typeof(val6)==='undefined'){
         val6='';
     }
     if(typeof(val7)==='undefined'){
         val7='';
     }
     if(typeof(val8)==='undefined'){
         val8='';
     }
 
   
 
   
    if(  typeof infoBox!=='undefined' && infoBox!== null ){
        infoBox.close(); 
    }
    
    var results_no  =   0;    
    var bounds = new google.maps.LatLngBounds();
   
    if(!isNaN(mcluster) ){
        mcluster.setIgnoreHidden(true);
    }
    

    //console.log("val1:"+val1+" val2:"+val2+" val3:"+val3+" val4:"+val4+" val5:"+val5);
    //console.log("val6:"+val6+" val7:"+val7+" val8:"+val8);
    if(  typeof gmarkers!=='undefined'){
        for (var i=0; i<gmarkers.length; i++) {  
         
                if ( !visible_or_not(mapfunctions_vars.hows[0], gmarkers[i].val1, val1, mapfunctions_vars.slugs[0]) ){
                    gmarkers[i].setVisible(false);
                } else if ( !visible_or_not(mapfunctions_vars.hows[1],gmarkers[i].val2, val2, mapfunctions_vars.slugs[1]) ){
                    gmarkers[i].setVisible(false);
                } else if ( !visible_or_not(mapfunctions_vars.hows[2],gmarkers[i].val3, val3, mapfunctions_vars.slugs[2]) ){
                    gmarkers[i].setVisible(false);
                } else if ( !visible_or_not(mapfunctions_vars.hows[3],gmarkers[i].val4, val4, mapfunctions_vars.slugs[3]) ){
                    gmarkers[i].setVisible(false);
                } else if ( !visible_or_not(mapfunctions_vars.hows[4],gmarkers[i].val5, val5, mapfunctions_vars.slugs[4]) ){
                     gmarkers[i].setVisible(false);
                } else if ( !visible_or_not(mapfunctions_vars.hows[5],gmarkers[i].val6, val6, mapfunctions_vars.slugs[5]) ){
                    gmarkers[i].setVisible(false);
                } else if ( !visible_or_not(mapfunctions_vars.hows[6],gmarkers[i].val7, val7, mapfunctions_vars.slugs[6]) ){
                    gmarkers[i].setVisible(false);
                } else if ( !visible_or_not(mapfunctions_vars.hows[7],gmarkers[i].val8, val8, mapfunctions_vars.slugs[7]) ){
                    gmarkers[i].setVisible(false);
                } else{
                    gmarkers[i].setVisible(true);
                    results_no++;
                    bounds.extend( gmarkers[i].getPosition() );           
                }
                
         }//end for   
        if(!isNaN(mcluster) ){
            mcluster.repaint();   
        }
    }//end if


    if(mapfunctions_vars.generated_pins==='0' || googlecode_regular_vars2.half_map_results=='1'){
        if(results_no===0){         
            jQuery('#gmap-noresult').show();
            jQuery('#results').hide();
        }else{
            jQuery('#gmap-noresult').hide(); 
            if( !bounds.isEmpty() ){
                map.fitBounds(bounds);
            } 
            jQuery("#results, #showinpage,#showinpage_mobile").show();
            jQuery("#results_no").show().empty().append(results_no); 
          
            if ( parseInt(mapfunctions_vars.is_half)===1 ){
        
                wpestate_show_inpage_ajax_half();
            }
        }
    }else{
        custom_get_filtering_ajax_result(); 
    }
}  
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
function show_pins() {
    "use strict";

    if(mapfunctions_vars.custom_search==='yes'){
       show_pins_custom_search();
       return;
    }    
    
    var results_no  =   0;
    var action      =   jQuery('#adv_actions').attr('data-value');
    var category    =   jQuery('#adv_categ').attr('data-value');
    var city        =   jQuery('#advanced_city').attr('data-value');
    var area        =   jQuery('#advanced_area').attr('data-value');   
    var rooms       =   parseInt( jQuery('#adv_rooms').val(),10 );
    var baths       =   parseInt( jQuery('#adv_bath').val(),10 );
    var min_price   =   parseInt( jQuery('#price_low').val() );
    var price_max   =   parseInt( jQuery('#price_max').val() );
       
    action      =   action.trim().toLowerCase();
    action      =   action.replace(/ /g,'-',action);
    
    category    =   category.trim().toLowerCase();
    category    =   category.replace(/ /g,'-',category);
    
    city        =   city.trim().toLowerCase();
    city        =   city.replace(/ /g,'-',city);
    
    area        =   area.trim().toLowerCase();
    area        =   area.replace(/ /g,'-',area);
    
    if(isNaN(rooms)){
        rooms=0;
    }
    
    if(isNaN(baths)){
        baths=0;
    }
    
     if(isNaN(min_price)){
        min_price=0;
    }
    
     if(isNaN(price_max)){
        price_max=0;
    }
    
    //console.log ("action " + action + " category "+ category + " city "+ city + " area "+ area);  
    //console.log("rooms "+ rooms + " baths "+ baths+"min_price "+min_price+" price_max "+price_max );
    
     
    if(  typeof infoBox!=='undefined' && infoBox!== null ){
        infoBox.close(); 
    }
   
    var bounds = new google.maps.LatLngBounds();
    
    if(!isNaN(mcluster) ){
        mcluster.setIgnoreHidden(true);
    }
    
    if(  typeof gmarkers!=='undefined'){
   
        for (var i=0; i<gmarkers.length; i++) {
                if(gmarkers[i].action !== action && action!='all' ){
                    gmarkers[i].setVisible(false);   
                }else if ( gmarkers[i].category !== category && category!='all' ) {   
                    gmarkers[i].setVisible(false); 
                }else if( gmarkers[i].area !== area && area!='all'  ){
                    gmarkers[i].setVisible(false);
                }else if( gmarkers[i].city !== city  && city!='all'){
                    gmarkers[i].setVisible(false);
                }else if( parseInt(gmarkers[i].rooms,10) !== rooms  && rooms!==0){
                    gmarkers[i].setVisible(false);
                }else if( parseInt(gmarkers[i].baths,10 ) !== baths  && baths!==0){
                    gmarkers[i].setVisible(false);
                }else if( parseInt(gmarkers[i].cleanprice,10 ) < min_price  && min_price!==0){
                    gmarkers[i].setVisible(false);
                }else if( parseInt(gmarkers[i].cleanprice,10 ) > price_max  && price_max!==0){
                     gmarkers[i].setVisible(false);
                }else{
                    gmarkers[i].setVisible(true);
                    results_no++;
                    bounds.extend( gmarkers[i].getPosition() );       
                }                    
        }//end for
        if(!isNaN(mcluster) ){
            mcluster.repaint();
        }
    }//end if
       

    
    if(mapfunctions_vars.generated_pins==='0' || googlecode_regular_vars2.half_map_results=='1'){
        if(results_no===0){
        
            jQuery('#gmap-noresult').show();
            jQuery('#results').hide();
        }else{
            jQuery('#gmap-noresult').hide(); 
        
            if( !bounds.isEmpty() ){
                map.fitBounds(bounds);
            } 
            jQuery("#results, #showinpage,#showinpage_mobile").show();
            jQuery("#results_no").show().empty().append(results_no); 
        
            
            if ( parseInt(mapfunctions_vars.is_half)===1 ){
                wpestate_show_inpage_ajax_half();
            }
        }
        
                
    }else{
    
        get_filtering_ajax_result();  
        if( !bounds.isEmpty() ){
            map.fitBounds(bounds);
        } 
        
        if( mapfunctions_vars.adv_search_type ===2 || mapfunctions_vars.adv_search_type ==='2' ){
            wpestate_show_inpage_ajax_tip2();
        }
    }      
}
 
    function wpestate_show_inpage_ajax_tip2(){
        if( jQuery('#gmap-full').hasClass('spanselected')){
            jQuery('#gmap-full').trigger('click');
        }
        
        if(mapfunctions_vars.custom_search==='yes'){
            custom_search_start_filtering_ajax(1);
        }else{
            start_filtering_ajax(1);  
        } 
    }
 
 
 
    function wpestate_show_inpage_ajax_half(){
        jQuery('.half-pagination').remove();
        if(mapfunctions_vars.custom_search==='yes'){
            custom_search_start_filtering_ajax(1);
        }else{
            start_filtering_ajax(1);  
        } 
        
    }


    function enable_half_map_pin_action (){
      
        jQuery('#google_map_prop_list_sidebar .listing_wrapper').hover(
            function() {

                var listing_id = jQuery(this).attr('data-listid');
                wpestate_hover_action_pin(listing_id);
            }, function() {
                var listing_id = jQuery(this).attr('data-listid');         
                wpestate_return_hover_action_pin(listing_id);
            }
        );
    }
=======
    
  

 
 
 function wpestate_show_pins() {
    console.log('wpestate_show_pins');
    jQuery("#results").show();
    jQuery("#results_wrapper").empty().append('<div class="preview_results_loading">'+mapfunctions_vars.loading_results+'</div>').show();
    
    var action, category, city, area, rooms, baths, min_price, price_max, ajaxurl,postid,halfmap, all_checkers,newpage;
     
    if(  typeof infoBox!=='undefined' && infoBox!== null ){
        infoBox.close(); 
    }
  
   
 
    jQuery('#gmap-loading').show();
    console.log("mapfunctions_vars.adv_search_type "+mapfunctions_vars.adv_search_type);
   
    //- removed &&  googlecode_regular_vars.is_adv_search!=='1'
    
    if( typeof(googlecode_regular_vars)!='undefined' ) {
        if( (mapfunctions_vars.adv_search_type==='8' || mapfunctions_vars.adv_search_type==='9') &&  googlecode_regular_vars.is_half_map_list!=='1'   ){
            wpestate_show_pins_type2_tabs();
            return;
        }
        
        if(mapfunctions_vars.adv_search_type==='2' && googlecode_regular_vars.is_half_map_list!=='1' &&  googlecode_regular_vars.is_adv_search!=='1' ){
            wpestate_show_pins_type2();
            return;
        }
    }else{
        if( (mapfunctions_vars.adv_search_type==='8' || mapfunctions_vars.adv_search_type==='9')   ){
            wpestate_show_pins_type2_tabs();
            return;
        }
        
        if(mapfunctions_vars.adv_search_type==='2' && googlecode_regular_vars.is_half_map_list!=='1'  ){
            wpestate_show_pins_type2();
            return;
        }
    }
    
    

    
    
    //
   
  
    if(mapfunctions_vars.custom_search==='yes'){
       wpestate_show_pins_custom_search();
       return;
    }    

    
  
    action      =   jQuery('#adv_actions').attr('data-value');
    category    =   jQuery('#adv_categ').attr('data-value');
    city        =   jQuery('#advanced_city').attr('data-value');
    area        =   jQuery('#advanced_area').attr('data-value');
    rooms       =   parseFloat(jQuery('#adv_rooms').val(), 10);
    baths       =   parseFloat(jQuery('#adv_bath').val(), 10);
    min_price   =   parseFloat(jQuery('#price_low').val(), 10);
    price_max   =   parseFloat(jQuery('#price_max').val(), 10);
    postid      =   parseFloat(jQuery('#adv-search-1').attr('data-postid'), 10);
    ajaxurl     =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
     
  
    
    if ( parseInt(mapfunctions_vars.is_half)===1 ){
        if(first_time_wpestate_show_inpage_ajax_half===0){
            first_time_wpestate_show_inpage_ajax_half=1
        }else{
          
            wpestate_show_inpage_ajax_half();
        }
     
    } 
     
    all_checkers = '';
    jQuery('.extended_search_check_wrapper  input[type="checkbox"]').each(function () {
        if (jQuery(this).is(":checked")) {
            all_checkers = all_checkers + "," + jQuery(this).attr("name");
        }
    });
    
    halfmap     =   0;
    newpage     =   0;
    if( jQuery('#google_map_prop_list_sidebar').length ){
        halfmap    = 1;
    }   
  
    postid=1;
    if(  document.getElementById('search_wrapper') ){
        postid      =   parseInt(jQuery('#search_wrapper').attr('data-postid'), 10);
    }
   
   
    var geo_lat     =   '';
    var geo_long    =   '';
    var geo_rad     =   '';
    
    if( jQuery("#geolocation_search").length > 0){    
        geo_lat     =   jQuery('#geolocation_lat').val();;
        geo_long    =   jQuery('#geolocation_long').val();
        geo_rad     =   jQuery('#geolocation_radius').val();

    }
    
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        dataType: 'json',
        data: {
            'action'            :   'wpestate_classic_ondemand_pin_load',
            'action_values'     :   action,
            'category_values'   :   category,
            'city'              :   city,
            'area'              :   area,
            'advanced_rooms'    :   rooms,
            'advanced_bath'     :   baths,
            'price_low'         :   min_price,
            'price_max'         :   price_max,
            'newpage'           :   newpage,
            'postid'            :   postid,
            'halfmap'           :   halfmap,
            'all_checkers'      :   all_checkers,
            'geo_lat'           :   geo_lat,
            'geo_long'          :   geo_long,
            'geo_rad'           :   geo_rad
        },
        success: function (data) { 
            var no_results = parseInt(data.no_results);
           
            if(no_results!==0){
                wpestate_load_on_demand_pins(data.markers,no_results,1);
            }else{
                wpestate_show_no_results();
            }
               jQuery('#gmap-loading').hide();
          
        },
        error: function (errorThrown) {
          
        }
    });//end ajax     
    
 }
 
 
 
 
 
 function wpestate_show_pins_type2(){
     console.log('wpestate_show_pins_type2');
    var action, category, location_search, ajaxurl,postid,halfmap, all_checkers,newpage;
    action      =   jQuery('#adv_actions').attr('data-value');
    category    =   jQuery('#adv_categ').attr('data-value');
    location_search    =   jQuery('#adv_location').val();
    postid      =   parseInt(jQuery('#adv-search-1').attr('data-postid'), 10);
    ajaxurl     =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
   
    halfmap     =   0;
    newpage     =   0;
    
     if( jQuery('#google_map_prop_list_sidebar').length ){
        halfmap    = 1;
    }   
  
    postid=1;
    
    if(  document.getElementById('search_wrapper') ){
        postid      =   parseInt(jQuery('#search_wrapper').attr('data-postid'), 10);
    }
   //   
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        dataType: 'json',
     
        data: {
            'action'            :   'wpestate_classic_ondemand_pin_load_type2',
            'action_values'     :   action,
            'category_values'   :   category,
            'location'          :   location_search
        },
        success: function (data) { 
            var no_results = parseInt(data.no_results);
            
            if(no_results!==0){
                wpestate_load_on_demand_pins(data.markers,no_results,1);
            }else{
                wpestate_show_no_results();
            }
            jQuery('#gmap-loading').hide();
          
        },
        error: function (errorThrown) {
        }
    });//end ajax 
    
       
    if ( parseInt(mapfunctions_vars.is_half)===1 ){
        if(first_time_wpestate_show_inpage_ajax_half===0){
            first_time_wpestate_show_inpage_ajax_half=1
        }else{
          
            wpestate_show_inpage_ajax_half();
        }
     
    } 
 }
 
 
 

 
 
 function wpestate_show_pins_type2_tabs(){
   console.log('wpestate_show_pins 2tavs');
    var action, category, location_search, ajaxurl,postid,halfmap, all_checkers,newpage,picked_tax;
     
    action              =   jQuery('.tab-pane.active #adv_actions').attr('data-value');
    if(typeof action === 'undefined'){
        action='';
    }
    category            =   jQuery('.tab-pane.active #adv_categ').attr('data-value');
    if(typeof category === 'undefined'){
        category='';
    }
    location_search     =   jQuery('.tab-pane.active #adv_location').val();
    picked_tax          =   jQuery('.tab-pane.active .picked_tax').val();
    
    
    postid      =   parseInt(jQuery('#adv-search-1').attr('data-postid'), 10);
    ajaxurl     =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
   
    halfmap     =   0;
    newpage     =   0;
   
    
    if( jQuery('#google_map_prop_list_sidebar').length ){
        halfmap    = 1;
    }   
  
    postid=1;
    
    if(  document.getElementById('search_wrapper') ){
        postid      =   parseInt(jQuery('#search_wrapper').attr('data-postid'), 10);
    }
   
    term_id=jQuery('.tab-pane.active .term_id_class').val();   
      
    all_checkers = '';
    jQuery('.tab-pane.active .extended_search_check_wrapper input[type="checkbox"]').each(function () {
        if (jQuery(this).is(":checked")) {
            all_checkers = all_checkers + "," + jQuery(this).attr("name");
        }
    });
   
   
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        dataType: 'json',
     
        data: {
            'action'            :   'wpestate_classic_ondemand_pin_load_type2_tabs',
            'action_values'     :   action,
            'category_values'   :   category,
            'location'          :   location_search,
            'picked_tax'        :   picked_tax,
            'all_checkers'      :   all_checkers
        },
        success: function (data) { 
       
            var no_results = parseInt(data.no_results);
            
            if(no_results!==0){
                wpestate_load_on_demand_pins(data.markers,no_results,1);
            }else{
                wpestate_show_no_results();
            }
               jQuery('#gmap-loading').hide();
          
        },
        error: function (errorThrown) {
           
        }
    });//end ajax 
    
    if ( parseInt(mapfunctions_vars.is_half)===1 ){
        if(first_time_wpestate_show_inpage_ajax_half===0){
            first_time_wpestate_show_inpage_ajax_half=1
        }else{
          
            wpestate_show_inpage_ajax_half();
        }
     
    } 
 }
 

 function wpestate_show_pins_custom_search(){
     
   console.log('wpestate_show_pins_custom_search ');

   
    var ajaxurl,array_last_item,how_holder,slug_holder,val_holder,position, inserted_val,temp_val,term_id,halfmap,newpage,postid,slider_min,slider_max;
    ajaxurl             =   ajaxcalls_vars.admin_url + 'admin-ajax.php';   
    inserted_val        =   0;
    array_last_item     =   parseInt( mapfunctions_vars.fields_no,10);
    val_holder          =   [];
    slug_holder         =   [];
    how_holder          =   [];
 
    slug_holder         =   mapfunctions_vars.slugs;
    how_holder          =   mapfunctions_vars.hows;
     
   
    
    
    if( mapfunctions_vars.slider_price ==='yes' ){
        slider_min = jQuery('#price_low').val();
        slider_max = jQuery('#price_max').val();
 
    }
   
    
    if( (mapfunctions_vars.adv_search_type==='6' || mapfunctions_vars.adv_search_type==='7' ) &&  !jQuery('.halfsearch')[0]){
        term_id=jQuery('.tab-pane.active .term_id_class').val();   
      
        if( mapfunctions_vars.slider_price ==='yes' ){
            slider_min = jQuery('#price_low_'+term_id).val();
            slider_max = jQuery('#price_max_'+term_id).val();
        }
    
         for (var i=0; i<array_last_item;i++){
            if ( how_holder[i]=='date bigger' || how_holder[i]=='date smaller'){
                temp_val = get_custom_value_tab_search (term_id+slug_holder[i]);
            }else{
                temp_val = get_custom_value_tab_search (slug_holder[i]);
            }
            
            if(typeof(temp_val)==='undefined'){
                temp_val='';
            }
            val_holder.push(  temp_val );
        }
        
    }else{
        for (var i=0; i<array_last_item;i++){
            temp_val = get_custom_value (slug_holder[i]);
            if(typeof(temp_val)==='undefined'){
                temp_val='';
            }
            val_holder.push(  temp_val );
        }
       
    }
  
   

 
 
    if( (mapfunctions_vars.adv_search_type==='6' || mapfunctions_vars.adv_search_type==='7' || mapfunctions_vars.adv_search_type==='8' || mapfunctions_vars.adv_search_type==='9' ) ){
        var tab_tax=jQuery('.adv_search_tab_item.active').attr('data-tax');
        
        if( jQuery('.halfsearch')[0] ){
            tab_tax=jQuery('.halfsearch').attr('data-tax');
        }
       
        
        if(tab_tax === 'property_category'){
            slug_holder[array_last_item]='adv_categ';
        }else if(tab_tax === 'property_action_category'){
            slug_holder[array_last_item]='adv_actions';
        }else if(tab_tax === 'property_city'){
            slug_holder[array_last_item]='advanced_city';
        }else if(tab_tax === 'property_area'){
            slug_holder[array_last_item]='advanced_area';
        }else if(tab_tax === 'property_county_state'){
            slug_holder[array_last_item]='county-state';
        }
        
        how_holder[array_last_item]='like';
  
        if( jQuery('.halfsearch')[0] ){
            val_holder[array_last_item] = jQuery('#'+slug_holder[array_last_item]) .parent().find('input:hidden').val();
        }else{
            val_holder[array_last_item]=jQuery('.adv_search_tab_item.active').attr('data-term');
        }
 
    }
    

    if ( parseInt(mapfunctions_vars.is_half)===1 ){
        if(first_time_wpestate_show_inpage_ajax_half===0){
            first_time_wpestate_show_inpage_ajax_half=1
        }else{
            wpestate_show_inpage_ajax_half();
        }
     
    } 
    //was 2 times !
      
   all_checkers = '';
 
    jQuery('.search_wrapper .extended_search_check_wrapper  input[type="checkbox"]').each(function () {
        if (jQuery(this).is(":checked")) {
            all_checkers = all_checkers + "," + jQuery(this).attr("name");
        }
    });
 
    
    halfmap     =   0;
    newpage     =   0;
    if( jQuery('#google_map_prop_list_sidebar').length ){
        halfmap    = 1;
    }   
  
    postid=1;
    if(  document.getElementById('search_wrapper') ){
        postid      =   parseInt(jQuery('#search_wrapper').attr('data-postid'), 10);
    }
    
    var filter_search_action10 ='';
    var adv_location10 ='';
    
    if( mapfunctions_vars.adv_search_type==='10' ){
        filter_search_action10   = jQuery('#adv_actions').attr('data-value');
        adv_location10           = jQuery('#adv_location').val();
     
    }
    
 
    var filter_search_action11   ='';
    var filter_search_categ11    =''
    var keyword_search          =''
    if( mapfunctions_vars.adv_search_type==='11' ){
        filter_search_action11   = jQuery('#adv_actions').attr('data-value');
        filter_search_categ11    = jQuery('#adv_categ').attr('data-value');
        keyword_search          = jQuery('#keyword_search').val();
    }
    
  
    var geo_lat     =   '';
    var geo_long    =   '';
    var geo_rad     =   '';
    
    if( jQuery("#geolocation_search").length > 0){    
        geo_lat     =   jQuery('#geolocation_lat').val();;
        geo_long    =   jQuery('#geolocation_long').val();
        geo_rad     =   jQuery('#geolocation_radius').val();

    }
 
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        dataType: 'json',
        data: {
            'action'                    :   'wpestate_custom_ondemand_pin_load',
            'search_type'               :   mapfunctions_vars.adv_search_type,
            'val_holder'                :   val_holder,
            'newpage'                   :   newpage,
            'postid'                    :   postid,
            'halfmap'                   :   halfmap,
            'slider_min'                :   slider_min,
            'slider_max'                :   slider_max,
            'all_checkers'              :   all_checkers,
            'filter_search_action10'    :   filter_search_action10,
            'adv_location10'            :   adv_location10,
            'filter_search_action11'    :   filter_search_action11,
            'filter_search_categ11'     :   filter_search_categ11,
            'keyword_search'            :   keyword_search,
            'geo_lat'                   :   geo_lat,
            'geo_long'                  :   geo_long,
            'geo_rad'                   :   geo_rad
        },
        success: function (data) { 
        

            var no_results = parseInt(data.no_results);
            if(no_results!==0){
                wpestate_load_on_demand_pins(data.markers,no_results,1);
            }else{
                wpestate_show_no_results();
            }
            jQuery('#gmap-loading').hide();
          
        },
        error: function (errorThrown) {
         
            
        }
    });//end ajax     
     

 }
 
 
  
 
function wpestate_empty_map(){
    if (typeof gmarkers !== 'undefined') {
        for (var i = 0; i < gmarkers.length; i++) {
            gmarkers[i].setVisible(false);
            gmarkers[i].setMap(null);
        }
        gmarkers = [];


        if( typeof (mcluster)!=='undefined'){
            mcluster.clearMarkers();  
        }
    }
} 
 
 
 
 function wpestate_load_on_demand_pins(markers,no_results,show_results_bar){
    console.log('wpestate_load_on_demand_pins');
    jQuery('#gmap-noresult').hide(); 

    
    wpestate_empty_map();
    if(  document.getElementById('googleMap') ){
        setMarkers(map, markers);
        wpestate_preview_listings(markers);
        if (!bounds.isEmpty()) {
            wpestate_fit_bounds(bounds);
        }else{
            wpestate_fit_bounds_nolsit();
        } 
    }else{
        wpestate_preview_listings(markers);
    }
    
    if( jQuery("#geolocation_search").length > 0 && initialGeop === 0){
        var place_lat = jQuery('#geolocation_lat').val();
        var place_lng = jQuery('#geolocation_long').val();

        if(place_lat!=='' && place_lng!=''){
            initialGeop=1;
            wpestate_geolocation_marker(place_lat,place_lng);
        }
    }
} 


function  wpestate_preview_listings(markers){

  console.log('wpestate_preview_listings');
    var i           =   0;
    var to_append   =   '';
    var image       =   '';
    var title       =   '';
    var link        =   '';
    var clean_price =   '';
    var price       =   '';
    for (var i = 0; i < markers.length; i++) {
        image       =   decodeURIComponent(markers[i][18]);
        title       =   decodeURIComponent(markers[i][0]);
        link        =   decodeURIComponent(markers[i][9]);
        clean_price =   decodeURIComponent(markers[i][11]);
        price       =   wpestate_get_price_currency ( decodeURIComponent(markers[i][5]),clean_price );
            
        to_append=to_append+'<div class="preview_listing_unit" data-href="'+link+'">'+image+' <h4>'+title+'</h4><div class="preview_details">'+price+'</div></div>';
     
      
    }
    
    jQuery('#results_wrapper').empty();
    jQuery('#results_no').show().text( markers.length);

    jQuery('#results_wrapper').append(to_append);
    
    jQuery('.preview_listing_unit').click(function(event){
        event.preventDefault();
        var new_link;
        new_link =  jQuery(this).attr('data-href');
        window.open (new_link,'_self',false)
    });
    
    
}


function wpestate_get_price_currency(price,clean_price){
    var new_price ='';
     
    var my_custom_curr_symbol  =   decodeURIComponent ( getCookie_map('my_custom_curr_symbol') );
    var my_custom_curr_coef    =   parseFloat( getCookie_map('my_custom_curr_coef'));
    var my_custom_curr_pos     =   parseFloat( getCookie_map('my_custom_curr_pos'));
    var my_custom_curr_cur_post=   getCookie_map('my_custom_curr_cur_post');
    var slider_counter = 0;
    
 
    if (!isNaN(my_custom_curr_pos) && my_custom_curr_pos !== -1) {
                if (my_custom_curr_cur_post === 'before') {
                    new_price = my_custom_curr_symbol+' '+clean_price*my_custom_curr_coef;
                } else {
                    new_price = my_custom_curr_coef*clean_price+' '+my_custom_curr_symbol;
                }

        } else {
          
            new_price=price
        }
        
    return new_price;
}

  function getCookie_map(cname) {
       var name = cname + "=";
       var ca = document.cookie.split(';');
       for(var i=0; i<ca.length; i++) {
           var c = ca[i];
           while (c.charAt(0)==' ') c = c.substring(1);
           if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
       }
       return "";
   }



function wpestate_show_no_results(){
    jQuery('#results_no').show().text('0');
 
    jQuery("#results_wrapper").empty().append('<div class="preview_results_loading">'+mapfunctions_vars.half_no_results+'</div>').show();
    jQuery('#gmap-noresult').show();
    if(  document.getElementById('google_map_prop_list_wrapper') ){
        jQuery('#listing_ajax_container').empty().append('<p class=" no_results_title ">'+mapfunctions_vars.half_no_results+'</p>');
    }
}



function wpestate_show_inpage_ajax_tip2(){
    console.log('wpestate_show_inpage_ajax_tip2');

    if( jQuery('#gmap-full').hasClass('spanselected')){
        jQuery('#gmap-full').trigger('click');
    }


    if(mapfunctions_vars.custom_search==='yes'){
        custom_search_start_filtering_ajax(1);
    }else{
        start_filtering_ajax(1);  
    } 
}
 
 
 
function wpestate_show_inpage_ajax_half(){
    console.log('wpestate_show_inpage_ajax_half')
    jQuery('.half-pagination').remove();
    if(mapfunctions_vars.custom_search==='yes'){
        custom_search_start_filtering_ajax(1);
    }else{
        start_filtering_ajax(1);  
    } 

}


function enable_half_map_pin_action (){
    console.log('enable_half_map_pin_action');
    /*ok*/
    jQuery('#google_map_prop_list_sidebar .listing_wrapper').hover(
        function() {
            var listing_id = jQuery(this).attr('data-listid');
            wpestate_hover_action_pin(listing_id);
        }, function() {
            var listing_id = jQuery(this).attr('data-listid');         
            wpestate_return_hover_action_pin(listing_id);
        }
    );
}
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    
    
/////////////////////////////////////////////////////////////////////////////////////////////////
/// get pin image
/////////////////////////////////////////////////////////////////////////////////////////////////
<<<<<<< HEAD
function convertToSlug(Text)
{
=======
function convertToSlug(Text){
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    return Text
        .toLowerCase()
        .replace(/ /g,'-')
        .replace(/[^\w-]+/g,'')
        ;
}


function custompin(image){
    "use strict";    
<<<<<<< HEAD
 
  
    var custom_img;
 
    if(image!==''){
        if(images[image]===''){
            custom_img= mapfunctions_vars.path+'/'+image+'.png';     
        }else{
            custom_img=images[image];
        }
    }else{
         custom_img= mapfunctions_vars.path+'/none.png';   
    }

    if(typeof (custom_img)=== 'undefined'){
        custom_img= mapfunctions_vars.path+'/none.png'; 
    }
   
    image = {
      url: custom_img, 
      size: new google.maps.Size(59, 59),
      origin: new google.maps.Point(0,0),
      anchor: new google.maps.Point(16,49 )
    };
    return image;
}



function custompin2(image){
    "use strict";
   
    image = {
      url: mapfunctions_vars.path+'/'+image+'.png',  
      size: new google.maps.Size(59, 59),
      origin: new google.maps.Point(0,0),
      anchor: new google.maps.Point(16,59 )
    };
=======
  
    var extension='';
    var ratio = jQuery(window).dense('devicePixelRatio');
  
    if(ratio>1){
    
        extension='_2x';
    }


    var custom_img;
    
    if(mapfunctions_vars.use_single_image_pin==='no'){
        if(image!==''){
            if( typeof( images[image] )=== 'undefined' || images[image]===''){
                custom_img= mapfunctions_vars.path+'/'+image+extension+'.png';     
            }else{
                custom_img=images[image];   

                if(ratio>1){
                    custom_img=custom_img.replace(".png","_2x.png");
                }
            }
        }else{
            custom_img= mapfunctions_vars.path+'/none.png';   
        }

        if(typeof (custom_img)=== 'undefined'){
            custom_img= mapfunctions_vars.path+'/none.png'; 
        }
    }else{
      
        if(ratio>1){
            custom_img= mapfunctions_vars.path+'/single_2x.png'; 
        }else{
            custom_img= mapfunctions_vars.path+'/single.png'; 
        }
    }
   

    if(ratio>1){
        image = {
            url: custom_img, 
            size :  new google.maps.Size(118, 118),
            scaledSize   :  new google.maps.Size(44, 48),
            origin: new google.maps.Point(0,0),
            anchor: new google.maps.Point(16,49 ),
            optimized:false
        };
     
    }else{
        image = {
            url: custom_img, 
            size :  new google.maps.Size(59, 59),
            origin: new google.maps.Point(0,0),
            anchor: new google.maps.Point(16,49 )
        };
    }
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    return image;
}


<<<<<<< HEAD





=======
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
/////////////////////////////////////////////////////////////////////////////////////////////////
//// Circle label
/////////////////////////////////////////////////////////////////////////////////////////////////

function Label(opt_options) {
  // Initialization
  this.setValues(opt_options);


  // Label specific
  var span = this.span_ = document.createElement('span');
  span.style.cssText = 'position: relative; left: -50%; top: 8px; ' +
  'white-space: nowrap;  ' +
  'padding: 2px; background-color: white;opacity:0.7';


  var div = this.div_ = document.createElement('div');
  div.appendChild(span);
  div.style.cssText = 'position: absolute; display: none';
};
<<<<<<< HEAD
Label.prototype = new google.maps.OverlayView;

=======
if (typeof google !== 'undefined') {
    Label.prototype = new google.maps.OverlayView;
}
>>>>>>> 64662fd89bea560852792d7203888072d7452d48

// Implement onAdd
Label.prototype.onAdd = function() {
  var pane = this.getPanes().overlayImage;
  pane.appendChild(this.div_);


  // Ensures the label is redrawn if the text or position is changed.
  var me = this;
  this.listeners_ = [
    google.maps.event.addListener(this, 'position_changed', function() { me.draw(); }),
    google.maps.event.addListener(this, 'visible_changed', function() { me.draw(); }),
    google.maps.event.addListener(this, 'clickable_changed', function() { me.draw(); }),
    google.maps.event.addListener(this, 'text_changed', function() { me.draw(); }),
    google.maps.event.addListener(this, 'zindex_changed', function() { me.draw(); }),
    google.maps.event.addDomListener(this.div_, 'click', function() { 
      if (me.get('clickable')) {
        google.maps.event.trigger(me, 'click');
      }
    })
  ];
};


// Implement onRemove
Label.prototype.onRemove = function() {
  this.div_.parentNode.removeChild(this.div_);


  // Label is removed from the map, stop updating its position/text.
  for (var i = 0, I = this.listeners_.length; i < I; ++i) {
    google.maps.event.removeListener(this.listeners_[i]);
  }
};


// Implement draw
Label.prototype.draw = function() {
  var projection = this.getProjection();
  var position = projection.fromLatLngToDivPixel(this.get('position'));


  var div = this.div_;
  div.style.left = position.x + 'px';
  div.style.top = position.y + 'px';


  var visible = this.get('visible');
  div.style.display = visible ? 'block' : 'none';


  var clickable = this.get('clickable');
  this.span_.style.cursor = clickable ? 'pointer' : '';


  var zIndex = this.get('zIndex');
  div.style.zIndex = zIndex;


  this.span_.innerHTML = this.get('text').toString();
};



/////////////////////////////////////////////////////////////////////////////////////////////////
/// close advanced search
/////////////////////////////////////////////////////////////////////////////////////////////////
<<<<<<< HEAD
function close_adv_search(){
    
}
/*

function close_adv_search(){
    // for advanced search 2
    
    if (!Modernizr.mq('only all and (max-width: 960px)')) {
        if(mapfunctions_vars.adv_search === '2' || mapfunctions_vars.adv_search === 2 ){
            adv_search2=0;
            jQuery('#adv-search-2').fadeOut(50,function(){
                jQuery('#search_wrapper').animate({
                    top:112+"px"
                    },200);             
            });        
            jQuery(this).removeClass('adv2_close');
        }
        
        // for advanced search 2           
        if(mapfunctions_vars.adv_search === '4' || mapfunctions_vars.adv_search === 4){
            adv_search4=0;
            jQuery('#adv-search-4').fadeOut(50,function(){
                    jQuery('#search_wrapper').animate({
                        top:112+"px"
                        },200);
                 });  
            jQuery(this).addClass('adv4_close');
        }
   }
}
*/
=======
function close_adv_search(){  
}
>>>>>>> 64662fd89bea560852792d7203888072d7452d48

//////////////////////////////////////////////////////////////////////
/// show advanced search
//////////////////////////////////////////////////////////////////////


function new_show_advanced_search(){
    jQuery("#search_wrapper").removeClass("hidden");
}

function new_hide_advanced_search(){
    if( mapfunctions_vars.show_adv_search ==='no' ){
        jQuery("#search_wrapper").addClass("hidden"); 
    }

}

function wpestate_hover_action_pin(listing_id){
<<<<<<< HEAD

    for (var i = 0; i < gmarkers.length; i++) {        
        if ( parseInt( gmarkers[i].idul,10) === parseInt( listing_id,10) ){
           pin_hover_storage=gmarkers[i].icon;
           gmarkers[i].setIcon(custompinhover());
           // var pin_latLng = gmarkers[i].getPosition(); // returns LatLng object
           // map.setCenter(pin_latLng)
=======
   
    for (var i = 0; i < gmarkers.length; i++) {        
        if ( parseInt( gmarkers[i].idul,10) === parseInt( listing_id,10) ){
            google.maps.event.trigger(gmarkers[i], 'click');
            if(mapfunctions_vars.useprice !== 'yes'){
                pin_hover_storage=gmarkers[i].icon;
                gmarkers[i].setIcon(custompinhover());
            }
          
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        }
    }
}

function wpestate_return_hover_action_pin(listing_id){
    
    for (var i = 0; i < gmarkers.length; i++) {  
        if ( parseInt( gmarkers[i].idul,10) === parseInt( listing_id,10) ){
<<<<<<< HEAD
            gmarkers[i].setIcon(pin_hover_storage);
=======
            infoBox.close()
            if(mapfunctions_vars.useprice !== 'yes'){
                gmarkers[i].setIcon(pin_hover_storage);
            }
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        }
    }
    
}


function custompinhover(){
    "use strict";    
<<<<<<< HEAD
    var custom_img,image;
    custom_img= mapfunctions_vars.path+'/hover.png'; 
  
   
    image = {
      url: custom_img, 
      size: new google.maps.Size(90, 90),
      origin: new google.maps.Point(0,0),
      anchor: new google.maps.Point(25,72 )
    };
=======
 
    var custom_img,image;
    var extension='';
    var ratio = jQuery(window).dense('devicePixelRatio');
    
    if(ratio>1){
        extension='_2x';
    }
    custom_img= mapfunctions_vars.path+'/hover'+extension+'.png'; 
 
    if(ratio>1){
  
        image = {
            url: custom_img, 
            size :  new google.maps.Size(132, 144),
            scaledSize   :  new google.maps.Size(66, 72),
            origin: new google.maps.Point(0,0),
            anchor: new google.maps.Point(25,72 )
          };
    
    }else{
        image = {
            url: custom_img, 
            size: new google.maps.Size(90, 90),
            origin: new google.maps.Point(0,0),
            anchor: new google.maps.Point(25,72 )
        };
    }
   
    
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    return image;
}




<<<<<<< HEAD
/*
function show_advanced_search(closer){
    if (!Modernizr.mq('only all and (max-width: 960px)')) {
         jQuery('#search_map_button,#advanced_search_map_button').show();
         jQuery('#adv-contact-3,#adv-search-header-contact-3,#adv-search-header-3,#adv-search-3').show();
    }
   

    if(closer==='close'){
         close_adv_search();
         if (!Modernizr.mq('only all and (max-width: 960px)')) {
            if(mapfunctions_vars.adv_search === '4' ){
               jQuery('#adv-search-header-4').show();
               jQuery('#adv-search-4').css({display:'none'});
               jQuery('#search_wrapper') .css({top:'112px'});
            }
            if(mapfunctions_vars.adv_search === '2'){            
               jQuery('#adv-search-header-2').show();
               jQuery('#adv-search-2').css({display:'none'});
               jQuery('#search_wrapper') .css({top:'112px'});
       
            }
         }
        
         
         
    }else{
          jQuery('#adv-search-header-4,#adv-search-4').show();
          jQuery('#adv-search-header-2,#adv-search-2').show();
          jQuery('#search_wrapper') .css({top:'200px'});
    }
    
    
    
    
    jQuery('#openmap').addClass('mapopen');
}


//////////////////////////////////////////////////////////////////////
/// show advanced search
//////////////////////////////////////////////////////////////////////

function hide_advanced_search(){
    jQuery('#search_map_button,#search_map_form, #advanced_search_map_button,#advanced_search_map_form').hide();
    jQuery('#adv-search-header-4,#adv-search-4').hide();
    jQuery('#adv-contact-3,#adv-search-header-contact-3,#adv-search-header-3,#adv-search-3').hide();
    jQuery('#adv-search-header-2,#adv-search-2').hide();
     jQuery('#advanced_search_map_form').hide();
   jQuery('#openmap').removeClass('mapopen');
}

*/


 
function show_pins_filters_from_file() {
    "use strict";
 
   
   
   if(jQuery("#a_filter_action").length == 0) {
        var action      =   jQuery('#second_filter_action').attr('data-value');
        var category    =   jQuery('#second_filter_categ').attr('data-value');
        var city        =   jQuery('#second_filter_cities').attr('data-value');
        var area        =   jQuery('#second_filter_areas').attr('data-value');   
    
    }else{
        var action      =   jQuery('#a_filter_action').attr('data-value');
        var category    =   jQuery('#a_filter_categ').attr('data-value');
        var city        =   jQuery('#a_filter_cities').attr('data-value');
        var area        =   jQuery('#a_filter_areas').attr('data-value');      
    }
   
 
    if( typeof(action)!=='undefined'){
        action      = action.toLowerCase().trim().replace(" ", "-");
    }
    
    if( typeof(action)!=='undefined'){
        category    = category.toLowerCase().trim().replace(" ", "-");
    }
    
    if( typeof(action)!=='undefined'){
        city        = city.toLowerCase().trim().replace(" ", "-");
    }
    
    if( typeof(action)!=='undefined'){
        area        = area.toLowerCase().trim().replace(" ", "-");
    }
    
    if(  typeof infoBox!=='undefined' && infoBox!== null ){
        infoBox.close(); 
    }
   
    var bounds = new google.maps.LatLngBounds();
    
    if(!isNaN(mcluster) ){
        mcluster.setIgnoreHidden(true);
    }
    
    if(  typeof gmarkers!=='undefined'){

        for (var i=0; i<gmarkers.length; i++) {
                if(gmarkers[i].action !== action && action!='all' && action!='all' && action!='all-actions' ){
                    gmarkers[i].setVisible(false);  
                }else if ( gmarkers[i].category !== category && category!='all' && category!='all-types') {   
                    gmarkers[i].setVisible(false);
                }else if( gmarkers[i].area !== area && area!='all'  && area!='all-areas'){
                    gmarkers[i].setVisible(false);
                }else if( gmarkers[i].city !== city  && city!='all' && city!='all-cities' ){
                    gmarkers[i].setVisible(false);
                }else{
                    gmarkers[i].setVisible(true);
                    bounds.extend( gmarkers[i].getPosition() );       
                }                    
        }//end for
        if(!isNaN(mcluster) ){
            mcluster.repaint();
        }
    }//end if
       
        if( !bounds.isEmpty() ){
            map.fitBounds(bounds);
        } 
        
}


function map_callback(callback){
    callback(1);
}
=======
function map_callback(callback){
    callback(1);
}




var wpestate_initialize_poi = function ( map_for_poi,what){
    var poi_service         =   new google.maps.places.PlacesService( map_for_poi );
    var already_serviced    =   ''
    var show_poi            =   '';
    var map_bounds          =   map_for_poi.getBounds();
    var selector            =   '.google_poi';
    if(what==2){
        selector = '.google_poish';
    }

    

    jQuery(selector).click(function(event){
        event.stopPropagation();
        poi_type        =   jQuery(this).attr('id');
        var position    =   map_for_poi.getCenter();
        var show_poi    =   wpestate_return_poi_values(poi_type);


        if( jQuery(this).hasClass('poi_active')){
            wpestate_show_hide_poi(poi_type,'hide');
        }else{
    
            already_serviced = wpestate_show_hide_poi(poi_type,'show');
            if(already_serviced===1){ 
               
                var request = {
                    location:   position,
                    types:      show_poi,        
                    bounds:     map_bounds,
                    radius:     2500,
                };
                poi_service.nearbySearch( request,function (results, status){
                    wpestate_googlemap_display_poi(results, status,map_for_poi)
                });
            }
        }
        jQuery(this).toggleClass('poi_active');
    });
 
    
   
    
    
    // return google poi types for selected poi
    var wpestate_return_poi_values = function (poi_type){
        var  show_poi;
        switch(poi_type) {
                case 'transport':
                    show_poi = ['bus_station', 'airport', 'train_station', 'subway_station'];
                    break;
                case 'supermarkets':
                    show_poi = ['grocery_or_supermarket', 'shopping_mall'];
                    break;
                case 'schools':
                    show_poi = ['school', 'university'];
                    break;
                case 'restaurant':
                    show_poi=['restaurant'];
                    break
                case 'pharma':
                    show_poi = ['pharmacy'];
                    break;
                case 'hospitals':
                    show_poi = ['hospital'];
                    break;
            }
        return show_poi;
    }

    
    // add poi markers on the map
    var wpestate_googlemap_display_poi = function (results, status,map_for_poi) {
        var place, poi_marker;
        if ( google.maps.places.PlacesServiceStatus.OK == status  ) {
            for (var i = 0; i < results.length; i++) {
                poi_marker  =   wpestate_create_poi_marker(results[i],map_for_poi);
                poi_marker_array.push(poi_marker);
            }
        }
    }

    // create the poi markers
    var wpestate_create_poi_marker = function (place,map_for_poi){
        marker = new google.maps.Marker({
            map: map_for_poi,
            position: place.geometry.location,
            show_poi:poi_type,
            icon: mapfunctions_vars.path+'/poi/'+poi_type+'.png'
        });


        var boxText         =   document.createElement("div");
        var infobox_poi     =   new InfoBox({
                    content: boxText,
                    boxClass:"estate_poi_box",
                    pixelOffset: new google.maps.Size(-30, -70),
                    zIndex: null,
                    maxWidth: 275,
                    closeBoxMargin: "-13px 0px 0px 0px",
                    closeBoxURL: "",
                    infoBoxClearance: new google.maps.Size(1, 1),
                    pane: "floatPane",
                    enableEventPropagation: false
                });

        google.maps.event.addListener(marker, 'mouseover', function(event) {
            infobox_poi.setContent(place.name);
            infobox_poi.open(map, this);
        });

        google.maps.event.addListener(marker, 'mouseout', function(event) {
            if( infobox_poi!== null){
                infobox_poi.close(); 
            }
        });
        return marker;
    }


    
    // hide-show poi
    var wpestate_show_hide_poi = function (poi_type,showhide){
        var is_hiding=1;

        for (var i = 0; i < poi_marker_array.length; i++) {
            if (poi_marker_array[i].show_poi === poi_type){
                if(showhide==='hide'){
                    poi_marker_array[i].setVisible(false);
                }else{
                    poi_marker_array[i].setVisible(true);
                    is_hiding=0;
                }
            }
        }

        return is_hiding;
    }
}



function wpestate_geolocation_marker (place_lat, place_lng){

    var place_position=new google.maps.LatLng(place_lat, place_lng);
    map.setCenter(place_position);
 
    if(placeCircle!=''){
        placeCircle.setMap(null);
        placeCircle='';
    }
 
    marker = new google.maps.Marker({
        map: map,
        position:  place_position,

        icon: mapfunctions_vars.path+'/poi/location.png'
    });
   
    var place_radius
    if(control_vars.geo_radius_measure==='miles'){
        place_radius =parseInt( jQuery('#geolocation_radius').val(),10)*1609.34 ; 
    }else{
        place_radius =parseInt( jQuery('#geolocation_radius').val(),10)*1000 ;    
    }
    var populationOptions = {
        strokeColor: '#67cfd8',
        strokeOpacity: 0.6,
        strokeWeight: 1,
        fillColor: '#1CA8DD',
        fillOpacity: 0.2,
        map: map,
        center: place_position,
        radius: parseInt(place_radius,10)
    };
    placeCircle = new google.maps.Circle(populationOptions);
    map.fitBounds(placeCircle.getBounds());
}


















/////////////////////////////////
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
