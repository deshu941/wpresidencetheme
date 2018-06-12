/*global $, jQuery, ajaxcalls_vars, document, control_vars, window, control_vars*/
///////////////////////////////////////////////////////////////////////////////////////////


<<<<<<< HEAD
=======

function wpestate_load_stats_tabs(listing_id) {
    "use strict";
    var ajaxurl     =   ajaxcalls_vars.admin_url + 'admin-ajax.php';

    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        dataType: 'json',
        data: {
            'action'            :   'wpestate_load_stats_property',
            'postid'            :   listing_id
        },
        success: function (data) {  
            wpestate_show_prop_stat_graph_tab (data.array_values , data.labels,listing_id);
        },
        error: function (errorThrown) {}
    });//end ajax     
}

function wpestate_show_prop_stat_graph_tab(values,labels ,listing_id){
    var ctx         =   jQuery("#myChart").get(0).getContext('2d');
    var myNewChart  =   new Chart(ctx);
   
   
    var data = {
    labels:labels ,
    datasets: [
         {
            label: "My First dataset",
            fillColor: "rgba(220,220,220,0.5)",
            strokeColor: "rgba(220,220,220,0.8)",
            highlightFill: "rgba(220,220,220,0.75)",
            highlightStroke: "rgba(220,220,220,1)",
            data: values
        },
    ]
    };
    
    var options = {
       //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
       scaleBeginAtZero : true,

       //Boolean - Whether grid lines are shown across the chart
       scaleShowGridLines : true,

       //String - Colour of the grid lines
       scaleGridLineColor : "rgba(0,0,0,.05)",

       //Number - Width of the grid lines
       scaleGridLineWidth : 1,

       //Boolean - Whether to show horizontal lines (except X axis)
       scaleShowHorizontalLines: true,

       //Boolean - Whether to show vertical lines (except Y axis)
       scaleShowVerticalLines: true,

       //Boolean - If there is a stroke on each bar
       barShowStroke : true,

       //Number - Pixel width of the bar stroke
       barStrokeWidth : 2,

       //Number - Spacing between each of the X value sets
       barValueSpacing : 5,

       //Number - Spacing between data sets within X values
       barDatasetSpacing : 1,

       //String - A legend template
       legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"

    }
 
    var myBarChart = new Chart(ctx).Bar(data, options);
}



function wpestate_load_stats(listing_id) {
    "use strict";
    var ajaxurl     =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        dataType: 'json',
        data: {
            'action'            :   'wpestate_load_stats_property',
            'postid'            :   listing_id
        },
        success: function (data) {  
            wpestate_show_prop_stat_graph (data.array_values , data.labels,listing_id);
        },
        error: function (errorThrown) {}
    });//end ajax     
}

function wpestate_show_prop_stat_graph(values,labels ,listing_id){
    var ctx         =   jQuery("#myChart_"+listing_id).get(0).getContext('2d');
    var myNewChart  =   new Chart(ctx);
   
   
    var data = {
    labels:labels ,
    datasets: [
         {
            label: "My First dataset",
            fillColor: "rgba(220,220,220,0.5)",
            strokeColor: "rgba(220,220,220,0.8)",
            highlightFill: "rgba(220,220,220,0.75)",
            highlightStroke: "rgba(220,220,220,1)",
            data: values
        },
    ]
    };
    
    var options = {
       //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
       scaleBeginAtZero : true,

       //Boolean - Whether grid lines are shown across the chart
       scaleShowGridLines : true,

       //String - Colour of the grid lines
       scaleGridLineColor : "rgba(0,0,0,.05)",

       //Number - Width of the grid lines
       scaleGridLineWidth : 1,

       //Boolean - Whether to show horizontal lines (except X axis)
       scaleShowHorizontalLines: true,

       //Boolean - Whether to show vertical lines (except Y axis)
       scaleShowVerticalLines: true,

       //Boolean - If there is a stroke on each bar
       barShowStroke : true,

       //Number - Pixel width of the bar stroke
       barStrokeWidth : 2,

       //Number - Spacing between each of the X value sets
       barValueSpacing : 5,

       //Number - Spacing between data sets within X values
       barDatasetSpacing : 1,

       //String - A legend template
       legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"

    }
 
    var myBarChart = new Chart(ctx).Bar(data, options);
}

>>>>>>> 64662fd89bea560852792d7203888072d7452d48
//////////////////////////////////////////////////////////////////////////////////////////////
/// ajax filtering on header search ; jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function get_filtering_ajax_result() {
    "use strict";
<<<<<<< HEAD

=======
    console.log('get_filtering_ajax_result');
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    var action, category, city, area, rooms, baths, min_price, price_max, ajaxurl,postid;
    action      =   jQuery('#adv_actions').attr('data-value');
    category    =   jQuery('#adv_categ').attr('data-value');
    city        =   jQuery('#advanced_city').attr('data-value');
    area        =   jQuery('#advanced_area').attr('data-value');
    rooms       =   parseInt(jQuery('#adv_rooms').val(), 10);
    baths       =   parseInt(jQuery('#adv_bath').val(), 10);
    min_price   =   parseInt(jQuery('#price_low').val(), 10);
    price_max   =   parseInt(jQuery('#price_max').val(), 10);
    postid      =   parseInt(jQuery('#adv-search-1').attr('data-postid'), 10);
    ajaxurl     =   ajaxcalls_vars.admin_url + 'admin-ajax.php';



    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'            :   'get_filtering_ajax_result',
            'action_values'     :   action,
            'category_values'   :   category,
            'city'              :   city,
            'area'              :   area,
            'advanced_rooms'    :   rooms,
            'advanced_bath'     :   baths,
            'price_low'         :   min_price,
            'price_max'         :   price_max,
            'postid'            :   postid
        },
        success: function (data) {     
            jQuery("#results, #showinpage,#showinpage_mobile").show();
            jQuery("#results_no").show().empty().append(data); 
<<<<<<< HEAD
=======
      
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
          
        },
        error: function (errorThrown) {}
    });//end ajax     
}

//////////////////////////////////////////////////////////////////////////////////////////////
/// ajax filtering on header search ; jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function custom_get_filtering_ajax_result() {
    "use strict";
<<<<<<< HEAD

    var  newpage, halfmap, val1, val2, val3, val4, val5, val6, val7, val8, ajaxurl, postid, slider_min, slider_max, all_checkers;
    newpage =0;
    val1 =  get_custom_value (mapfunctions_vars.slugs[0]);
    val2 =  get_custom_value (mapfunctions_vars.slugs[1]);
    val3 =  get_custom_value (mapfunctions_vars.slugs[2]);
    val4 =  get_custom_value (mapfunctions_vars.slugs[3]);
    val5 =  get_custom_value (mapfunctions_vars.slugs[4]);
    val6 =  get_custom_value (mapfunctions_vars.slugs[5]);
    val7 =  get_custom_value (mapfunctions_vars.slugs[6]);
    val8 =  get_custom_value (mapfunctions_vars.slugs[7]);
 
    
    postid      =   parseInt(jQuery('#adv-search-1').attr('data-postid'), 10);
    ajaxurl     =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
    slider_min  =   parseFloat ( jQuery('#price_low').val() );
    slider_max  =   parseFloat ( jQuery('#price_max').val() );
    
    halfmap    = 0;
    if( jQuery('#google_map_prop_list_sidebar').length ){
        halfmap    = 1;
    } 
    
    all_checkers = '';
    jQuery('.halfsearch  input[type="checkbox"]').each(function () {
        if (jQuery(this).is(":checked")) {
            all_checkers = all_checkers + "," + jQuery(this).attr("name");
        }
    });
    
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'            :   'custom_adv_get_filtering_ajax_result',
            'val1'              :   val1,
            'val2'              :   val2,
            'val3'              :   val3,
            'val4'              :   val4,
            'val5'              :   val5,
            'val6'              :   val6,
            'val7'              :   val7,
            'val8'              :   val8,
            'newpage'           :   newpage,
            'postid'            :   postid,
            'slider_min'        :   slider_min,
            'slider_max'        :   slider_max,
            'halfmap'           :   halfmap,
            'all_checkers'      :   all_checkers
        },
        success: function (data) {  
            
            jQuery("#results, #showinpage,#showinpage_mobile").show();
            jQuery("#results_no").show().empty().append(data); 
          
        },
        error: function (errorThrown) {}
    });//end ajax     
=======
    //obsolte;
    return;
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
}

//////////////////////////////////////////////////////////////////////////////////////////////
/// ajax filtering on header search ; jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function start_filtering_ajax(newpage) {
    "use strict";
<<<<<<< HEAD
        
=======
    console.log('start_filtering_ajax');    
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    var action, category, city, area, rooms, baths, min_price, price_max, ajaxurl,postid,halfmap, all_checkers;
    action      =   jQuery('#adv_actions').attr('data-value');
    category    =   jQuery('#adv_categ').attr('data-value');
    city        =   jQuery('#advanced_city').attr('data-value');
    area        =   jQuery('#advanced_area').attr('data-value');
<<<<<<< HEAD
    rooms       =   parseInt(jQuery('#adv_rooms').val(), 10);
    baths       =   parseInt(jQuery('#adv_bath').val(), 10);
    min_price   =   parseInt(jQuery('#price_low').val(), 10);
    price_max   =   parseInt(jQuery('#price_max').val(), 10);
    postid      =   parseInt(jQuery('#adv-search-1').attr('data-postid'), 10);
    ajaxurl     =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
    
    halfmap    = 0;
=======
    rooms       =   parseFloat(jQuery('#adv_rooms').val(), 10);
    baths       =   parseFloat(jQuery('#adv_bath').val(), 10);
    min_price   =   parseFloat(jQuery('#price_low').val(), 10);
    price_max   =   parseFloat(jQuery('#price_max').val(), 10);
    postid      =   parseFloat(jQuery('#adv-search-1').attr('data-postid'), 10);
    ajaxurl     =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
    var order= jQuery('#a_filter_order').attr('data-value');
    halfmap    = 0;
    
  
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
  
    if( jQuery('#google_map_prop_list_sidebar').length ){
        halfmap    = 1;
    }   
  
    postid=1;
    if(  document.getElementById('search_wrapper') ){
        postid      =   parseInt(jQuery('#search_wrapper').attr('data-postid'), 10);
    }
    
    all_checkers = '';
<<<<<<< HEAD
    jQuery('.halfsearch  input[type="checkbox"]').each(function () {
=======
    jQuery('.extended_search_check_wrapper  input[type="checkbox"]').each(function () {
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        if (jQuery(this).is(":checked")) {
            all_checkers = all_checkers + "," + jQuery(this).attr("name");
        }
    });
    
    halfmap    = 0;
    
    if( jQuery('#google_map_prop_list_sidebar').length ){
        halfmap    = 1;
    }   
<<<<<<< HEAD
    
=======
     
    var geo_lat     =   '';
    var geo_long    =   '';
    var geo_rad     =   '';
    
    if( jQuery("#geolocation_search").length > 0){    
        geo_lat     =   jQuery('#geolocation_lat').val();;
        geo_long    =   jQuery('#geolocation_long').val();
        geo_rad     =   jQuery('#geolocation_radius').val();

    }
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    jQuery('#listing_ajax_container').empty();
    jQuery('#listing_loader').show();
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
<<<<<<< HEAD
=======
           dataType: 'json',
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        data: {
            'action'            :   'wpestate_ajax_filter_listings_search',
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
<<<<<<< HEAD
            'all_checkers'      :   all_checkers
        },
        success: function (data) {      
            jQuery('#listing_loader').hide();
            jQuery('.listing_loader_title').show();
            jQuery('.pagination_nojax').hide();
            jQuery('#listing_ajax_container').empty().append(data);
        
=======
            'all_checkers'      :   all_checkers,
            'geo_lat'           :   geo_lat,
            'geo_long'          :   geo_long,
            'geo_rad'           :   geo_rad,
            'order'             :   order
        },
        success: function (data) { 

            jQuery('#listing_loader').hide();
            jQuery('.listing_loader_title').show();
            jQuery('.pagination_nojax').hide();
            //jQuery('#listing_ajax_container').empty().append(data);
            jQuery('.entry-title.title_prop').addClass('half_results').text(data.no_founs);
            
            jQuery('#listing_ajax_container').empty().append(data.cards);
            
            
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
            restart_js_after_ajax();
          
        },
        error: function (errorThrown) {}
    });//end ajax     
}



<<<<<<< HEAD

=======
function typeof_value(val1, slug){
    "use strict";

    if( typeof(val1)!=="undefined"){
        if( !jQuery('#'+slug).hasClass('filter_menu_trigger') ){ 
         
            if(slug !== 'adv_categ' && slug !== 'adv_actions' &&  
                slug !== 'advanced_city' &&  slug !== 'advanced_area'  &&  
                slug !== 'county-state' && slug !== 'property-country'   ){
                val1=val1;
              
            }  else{
                val1=val1.replace("-"," ");
            }
        }
        
    }else{
        val1='';
    }
    return val1;
}
>>>>>>> 64662fd89bea560852792d7203888072d7452d48

//////////////////////////////////////////////////////////////////////////////////////////////
/// ajax filtering on header search ; jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function custom_search_start_filtering_ajax(newpage) {
    "use strict";
<<<<<<< HEAD
    var   val1, val2, val3, val4, val5, val6, val7, val8, ajaxurl,postid , slider_min, slider_max, halfmap, all_checkers;
    
    val1 =  get_custom_value (mapfunctions_vars.slugs[0]);
    val2 =  get_custom_value (mapfunctions_vars.slugs[1]);
    val3 =  get_custom_value (mapfunctions_vars.slugs[2]);
    val4 =  get_custom_value (mapfunctions_vars.slugs[3]);
    val5 =  get_custom_value (mapfunctions_vars.slugs[4]);
    val6 =  get_custom_value (mapfunctions_vars.slugs[5]);
    val7 =  get_custom_value (mapfunctions_vars.slugs[6]);
    val8 =  get_custom_value (mapfunctions_vars.slugs[7]);
    
    /* 
    console.log("val1:"+val1+" val2:"+val2+" val3:"+val3+" val4:"+val4+" val5:"+val5);
    console.log("val6:"+val6+" val7:"+val7+" val8:"+val8);
   */
    
    slider_min  = parseFloat ( jQuery('#price_low').val() );
    slider_max  = parseFloat ( jQuery('#price_max').val() );
     
    all_checkers = '';
    jQuery('.halfsearch  input[type="checkbox"]').each(function () {
=======
    console.log('custom_search_start_filtering_ajax');
    var   temp_val,array_last_item,how_holder,slug_holder,val_holder, ajaxurl,postid , slider_min, slider_max, halfmap, all_checkers,term_id;
  
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
  
    console.log(" mapfunctions_vars.adv_search_type "+mapfunctions_vars.adv_search_type);
           
    if( (mapfunctions_vars.adv_search_type==='6' || mapfunctions_vars.adv_search_type==='7'||  mapfunctions_vars.adv_search_type==='8' || mapfunctions_vars.adv_search_type==='9') ){
    
      
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
 
     
    all_checkers = '';
    jQuery('.extended_search_check_wrapper  input[type="checkbox"]').each(function () {
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        if (jQuery(this).is(":checked")) {
            all_checkers = all_checkers + "," + jQuery(this).attr("name");
        }
    });
    
 
    halfmap    = 0;
    
    if( jQuery('#google_map_prop_list_sidebar').length ){
        halfmap    = 1;
    }   
    postid=1;
    if(  document.getElementById('search_wrapper') ){
        postid      =   parseInt(jQuery('#search_wrapper').attr('data-postid'), 10);
    }
    ajaxurl     =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
 
 
<<<<<<< HEAD
   
 
=======
 
    var filter_search_action10 ='';
    var adv_location10 ='';
    
    if( mapfunctions_vars.adv_search_type==='10' ){
        filter_search_action10   = jQuery('#adv_actions').attr('data-value');
        adv_location10           = jQuery('#adv_location').val();
    }
   

    var filter_search_action11   =  '';
    var filter_search_categ11    =  '';
    var keyword_search           =  '';
    if( mapfunctions_vars.adv_search_type==='11' ){
        filter_search_action11      = jQuery('#adv_actions').attr('data-value');
        filter_search_categ11       = jQuery('#adv_categ').attr('data-value');
        keyword_search              = jQuery('#keyword_search').val();
    }
    var geo_lat     =   '';
    var geo_long    =   '';
    var geo_rad     =   '';
    
    if( jQuery("#geolocation_search").length > 0){    
        geo_lat     =   jQuery('#geolocation_lat').val();;
        geo_long    =   jQuery('#geolocation_long').val();
        geo_rad     =   jQuery('#geolocation_radius').val();

    }
    
    var order= jQuery('#a_filter_order').attr('data-value');
   
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    jQuery('#listing_ajax_container').empty();
    jQuery('#listing_loader').show();
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
<<<<<<< HEAD
        data: {
            'action'            :   'wpestate_custom_adv_ajax_filter_listings_search',
            'val1'              :   val1,
            'val2'              :   val2,
            'val3'              :   val3,
            'val4'              :   val4,
            'val5'              :   val5,
            'val6'              :   val6,
            'val7'              :   val7,
            'val8'              :   val8,
            'newpage'           :   newpage,
            'postid'            :   postid,
            'slider_min'        :   slider_min,
            'slider_max'        :   slider_max,
            'halfmap'           :   halfmap,
            'all_checkers'      :   all_checkers
        },
        success: function (data) {  
         //   console.log(data);
            jQuery('#listing_loader').hide();
            jQuery('.listing_loader_title').show();
            jQuery('#listing_ajax_container').empty().append(data);
            restart_js_after_ajax();
          
        },
        error: function (errorThrown) {}
=======
        dataType: 'json',
        data: {
            'action'                    :   'wpestate_custom_adv_ajax_filter_listings_search',
            'val_holder'                :   val_holder,
            'newpage'                   :   newpage,
            'postid'                    :   postid,
            'slider_min'                :   slider_min,
            'slider_max'                :   slider_max,
            'halfmap'                   :   halfmap,
            'all_checkers'              :   all_checkers,
            'filter_search_action10'    :   filter_search_action10,
            'adv_location10'            :   adv_location10,
            'filter_search_action11'    :   filter_search_action11,
            'filter_search_categ11'     :   filter_search_categ11,
            'keyword_search'            :   keyword_search,
            'geo_lat'                   :   geo_lat,
            'geo_long'                  :   geo_long,
            'geo_rad'                   :   geo_rad,
            'order'                     :   order
        },
        success: function (data) {  
         
            jQuery('#listing_loader').hide();
            jQuery('.listing_loader_title').show();
            jQuery('.entry-title.title_prop').addClass('half_results').text(data.no_founs);
            
            jQuery('#listing_ajax_container').empty().append(data.cards);
            
            
            
            restart_js_after_ajax();
            jQuery('.col-md-12.listing_wrapper .property_unit_custom_element.image').each(function(){
                jQuery(this).parent().addClass('wrap_custom_image'); 
            });
        },
        error: function (errorThrown) {
         
        }
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    });//end ajax     
}





////////////////////////////////////////////////////////////////////////////////////////////
/// redo js after ajax calls - jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function restart_js_after_ajax() {
    "use strict";
<<<<<<< HEAD
=======
    wpestate_lazy_load_carousel_property_unit();
    
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    // enable_half_map_pin_action();
    if (typeof enable_half_map_pin_action == 'function'){
        enable_half_map_pin_action();
    }
    var newpage, post_id, post_image, to_add, icon;
    
<<<<<<< HEAD
    jQuery('.prop-compare:first-of-type').remove();
=======


>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    
    
    jQuery('.pagination_ajax_search a').click(function (event) {
        event.preventDefault();
<<<<<<< HEAD
        newpage = parseInt(jQuery(this).attr('data-future'), 10);
        document.getElementById('scrollhere').scrollIntoView();
        start_filtering_ajax(newpage);
    });

=======
      
        newpage = parseInt(jQuery(this).attr('data-future'), 10);
        document.getElementById('scrollhere').scrollIntoView();
        if( mapfunctions_vars.custom_search==='yes' ){
           custom_search_start_filtering_ajax(newpage);  // should be custom
        }else{
            start_filtering_ajax(newpage);// 
        }
    });





>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    jQuery('.pagination_ajax a').click(function (event) {
        event.preventDefault();
        newpage = parseInt(jQuery(this).attr('data-future'), 10);
        document.getElementById('scrollhere').scrollIntoView();
        start_filtering(newpage);
    });
    
    jQuery('.property_listing').click(function(){
        var link;
        link = jQuery(this).attr('data-link'); 
        window.open(link, '_self');
    });
   
    jQuery('.share_unit').click(function(event){
        event.stopPropagation();
    });
   
    var already_in=[];
<<<<<<< HEAD
=======
  
    jQuery('.compare-action').unbind('click');
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    jQuery('.compare-action').click(function (e) {
        
        e.preventDefault();
        e.stopPropagation();
<<<<<<< HEAD
        jQuery('.prop-compare').show();
=======
        jQuery('.prop-compare').animate({
                            right: "0px"
                        });

>>>>>>> 64662fd89bea560852792d7203888072d7452d48

        post_id = jQuery(this).attr('data-pid');
        
     
         for(var i = 0; i < already_in.length; i++) {
            if(already_in[i] === post_id) {
                return;
            }
        }
        
        already_in.push(post_id); 
        post_image = jQuery(this).attr('data-pimage');

        to_add = '<div class="items_compare ajax_compare" style="display:none;"><img src="' + post_image + '" alt="compare_thumb" class="img-responsive"><input type="hidden" value="' + post_id + '" name="selected_id[]" /></div>';
        jQuery('div.items_compare:first-child').css('background', 'red');
        if (parseInt(jQuery('.items_compare').length, 10) > 3) {
            jQuery('.items_compare:first').remove();
        }
        jQuery('#submit_compare').before(to_add);
        jQuery('.items_compare').fadeIn(800);
    });

<<<<<<< HEAD
=======
    jQuery('#submit_compare').unbind('click');
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    jQuery('#submit_compare').click(function () {
        jQuery('#form_compare').trigger('submit');
    });
    
    jQuery('.icon-fav').click(function (event) {
        event.stopPropagation();
        icon = jQuery(this);
        add_remove_favorite(icon);
    });
   
    jQuery(".share_list, .icon-fav, .compare-action").hover(
        function () {
            jQuery(this).tooltip('show');
        },
        function () {
            jQuery(this).tooltip('hide');
    });
       
    jQuery('.share_list').click(function (event) {
        event.stopPropagation();
        var sharediv = jQuery(this).parent().find('.share_unit');
        sharediv.toggle();
        jQuery(this).toggleClass('share_on');
    });
    
<<<<<<< HEAD
  
=======
    setTimeout(function() {  jQuery('.property_listing').matchHeight(); }, 1000);
   
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
}

////////////////////////////////////////////////////////////////////////////////////////////
/// add remove from favorite-jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function add_remove_favorite(icon) {
    "use strict";
    var post_id, securitypass, ajaxurl;
    post_id         =  icon.attr('data-postid');
    securitypass    =  jQuery('#security-pass').val();
    ajaxurl         =  ajaxcalls_vars.admin_url + 'admin-ajax.php';
  
    if (parseInt(ajaxcalls_vars.userid, 10) === 0 ) {
<<<<<<< HEAD
        show_login_form();
=======
      
  
       
        if (!Modernizr.mq('only all and (max-width: 768px)')) {
            jQuery('#modal_login_wrapper').show(); 
            jQuery('#loginpop').val('1');
        }else{
            jQuery('.mobile-trigger-user').trigger('click');
        }
       
       
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    } else {
        icon.toggleClass('icon-fav-off');
        icon.toggleClass('icon-fav-on');

        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            dataType: 'json',
              data: {
                  'action'            :   'wpestate_ajax_add_fav',
                  'post_id'           :   post_id
                  },
           success: function (data) {          
               if (data.added) {
                    icon.removeClass('icon-fav-off').addClass('icon-fav-on');
               } else {
                    icon.removeClass('icon-fav-on').addClass('icon-fav-off');
               }
           },
           error: function (errorThrown) {

           }
         });//end ajax
    }// end login use
} 

////////////////////////////////////////////////////////////////////////////////////////////
/// resend listing for approval-jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function resend_for_approval(prop_id, selected_div) {
    "use strict";
    var ajaxurl, normal_list_no;
    ajaxurl   =   control_vars.admin_url + 'admin-ajax.php';

    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'        :   'wpestate_ajax_resend_for_approval',
            'propid'        :   prop_id
        },
        success: function (data) {
<<<<<<< HEAD
=======
  
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
            if (data === 'pending') {
                selected_div.parent().empty().append('<span class="featured_prop">Sent for approval</span>');
                normal_list_no    =  parseInt(jQuery('#normal_list_no').text(), 10);
                jQuery('#normal_list_no').text(normal_list_no - 1);
            } else {
                selected_div.parent().empty().append(data);
            }
        },
        error: function (errorThrown) {

        }
    });//end ajax
}

////////////////////////////////////////////////////////////////////////////////////////////
/// make property featured-jslint checked
//////////////////////////////////////////////////////////////////////////////////////////// 
function make_prop_featured(prop_id, selectedspan) {
    "use strict";
    var ajaxurl      =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'        :   'wpestate_ajax_make_prop_featured',
            'propid'        :   prop_id
        },
        success: function (data) {
            
<<<<<<< HEAD
           
=======
         
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
            if (data.trim() === 'done') {
                selectedspan.empty().html('<span class="label label-success">'+ajaxcalls_vars.prop_featured+'</span>');
                var featured_list_no = parseInt(jQuery('#featured_list_no').text(), 10);
                jQuery('#featured_list_no').text(featured_list_no - 1);
            } else {
                selectedspan.empty().removeClass('make_featured').addClass('featured_exp').text(ajaxcalls_vars.no_prop_featured);
            }

        },
        error: function (errorThrown) {
        }

    });//end ajax
}

////////////////////////////////////////////////////////////////////////////////////////////
/// pay package via paypal recuring-jslint checked
////////////////////////////////////////////////////////////////////////////////////////////   
function recuring_pay_pack_via_paypal() {
    "use strict";
    var ajaxurl, packName, packId;
    ajaxurl      =   control_vars.admin_url + 'admin-ajax.php';
<<<<<<< HEAD
    packName     =   jQuery('#pack_select :selected').text();
    packId       =   jQuery('#pack_select :selected').val();

=======
     
    packName = jQuery('.package_selected .pack-listing-title').text();
    packId = jQuery('.package_selected .pack-listing-title').attr('data-packid');
  
 
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
<<<<<<< HEAD
            'action'        :   'wpestate_ajax_paypal_pack_recuring_generation',
=======
            'action'        :   'wpestate_ajax_paypal_pack_recuring_generation_rest_api',
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
            'packName'      :   packName,
            'packId'        :   packId
        },
        success: function (data) {      
            window.location.href = data;
        },
        error: function (errorThrown) {
        }
    });//end ajax    
}

<<<<<<< HEAD
=======
jQuery(".pack-listing .buypackage").click(function(){
    
    var stripe_pack_id,stripetitle2,stripetitle,stripepay;
    jQuery(".pack-listing input").each(function(){
        if( jQuery(this).is(":checked")){
            jQuery(this).attr('checked', false); 
            jQuery(this).parent().parent().removeClass("package_selected");
        }
    });
    jQuery(this).find('input').attr('checked', true); 
    jQuery(this).parent().addClass("package_selected");
    
    stripetitle         = jQuery(this).parent().find('.pack-listing-title').attr('data-stripetitle');
    stripetitle2        = jQuery(this).parent().find('.pack-listing-title').attr('data-stripetitle2');
    stripepay           = jQuery(this).parent().find('.pack-listing-title').attr('data-stripepay');
    stripe_pack_id      = jQuery(this).parent().find('.pack-listing-title').attr('data-packid');
 
    jQuery('.stripe_buttons').attr("id",stripetitle2);
    jQuery('#stripe_script').attr("data-amount",stripepay);
    jQuery('#stripe_script').attr("data-description",stripetitle);
  
    jQuery('#pack_id').val(stripe_pack_id);
    jQuery('#pay_ammout').val(stripepay);
    jQuery('#stripe_form').attr('data-amount',stripepay);
    
    // enable stripe code
      
      
});



>>>>>>> 64662fd89bea560852792d7203888072d7452d48
////////////////////////////////////////////////////////////////////////////////////////////
/// pay package via paypal-jslint checked
////////////////////////////////////////////////////////////////////////////////////////////   
function pay_pack_via_paypal() {
    "use strict";
    var  ajaxurl, packName, packId;
    ajaxurl     =   control_vars.admin_url + 'admin-ajax.php';
<<<<<<< HEAD
    packName    =   jQuery('#pack_select :selected').text();
    packId      =   jQuery('#pack_select :selected').val();
=======
//    packName    =   jQuery('#pack_select :selected').text();
//    packId      =   jQuery('#pack_select :selected').val();
    
    packName = jQuery('.package_selected .pack-listing-title').text();
    packId = jQuery('.package_selected .pack-listing-title').attr('data-packid');
    
    
    
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'        :   'wpestate_ajax_paypal_pack_generation',
            'packName'      :   packName,
            'packId'        :   packId
        },
        success: function (data) {
            window.location.href = data;
        },
        error: function (errorThrown) {
        }
    });//end ajax

}
////////////////////////////////////////////////////////////////////////////////////////////
/// listing pay -jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function listing_pay(prop_id, selected_div, is_featured, is_upgrade) {
    "use strict";
    var ajaxurl      =   control_vars.admin_url + 'admin-ajax.php';
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'        :   'wpestate_ajax_listing_pay',
            'propid'        :   prop_id,
            'is_featured'   :   is_featured,
            'is_upgrade'    :   is_upgrade
        },
        success: function (data) {
            window.location.href = data;
        },
        error: function (errorThrown) {
        }
    });//end ajax
}

////////////////////////////////////////////////////////////////////////////////////////////
/// start filtering -jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function start_filtering(newpage) {
    "use strict";
<<<<<<< HEAD
    jQuery('#grid_view').addClass('icon_selected');
    jQuery('#list_view').removeClass('icon_selected');
    var action, category, city, area, order, ajaxurl,page_id;
=======
    console.log('start_filtering');
    jQuery('#gmap-loading').show();
    jQuery('#grid_view').addClass('icon_selected');
    jQuery('#list_view').removeClass('icon_selected');
    
    var action, category, county, city, area, order, ajaxurl,page_id;
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    // get action vars
    action = jQuery('#a_filter_action').attr('data-value');
    // get category
    category = jQuery('#a_filter_categ').attr('data-value');
<<<<<<< HEAD
=======
    
    // get county
    county = jQuery('#a_filter_county').attr('data-value');
 
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    // get city
    city = jQuery('#a_filter_cities').attr('data-value');
    // get area
    area = jQuery('#a_filter_areas').attr('data-value');
    // get order
    order = jQuery('#a_filter_order').attr('data-value');
    ajaxurl =  ajaxcalls_vars.admin_url + 'admin-ajax.php';
    page_id =   jQuery('#page_idx').val();
    
    jQuery('#listing_ajax_container').empty();
    jQuery('#listing_loader').show();
 
<<<<<<< HEAD
 
=======

>>>>>>> 64662fd89bea560852792d7203888072d7452d48

    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
<<<<<<< HEAD
=======
        dataType: 'json',
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        data: {
            'action'            :   'ajax_filter_listings',
            'action_values'     :   action,
            'category_values'   :   category,
<<<<<<< HEAD
=======
            'county'              :   county,
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
            'city'              :   city,
            'area'              :   area,
            'order'             :   order,
            'newpage'           :   newpage,
            'page_id'           :   page_id
        },
        success: function (data) {
<<<<<<< HEAD
            jQuery('#listing_loader').hide();
            jQuery('#listing_ajax_container').empty().append(data);
            jQuery('.pagination_nojax').hide();
            restart_js_after_ajax();

        },
        error: function (errorThrown) {

=======
              
            jQuery('#listing_loader').hide();
            jQuery('#listing_ajax_container').empty().append(data.to_show);
            jQuery('.pagination_nojax').hide();
            restart_js_after_ajax();
            
            // map update
            var no_results = parseInt(data.no_results);
             if(no_results!==0){
                wpestate_load_on_demand_pins(data.markers,no_results,0);
            }else{
                wpestate_show_no_results();
            }
            
            jQuery('.col-md-12.listing_wrapper .property_unit_custom_element.image').each(function(){
                jQuery(this).parent().addClass('wrap_custom_image'); 
            });
            
            jQuery('#gmap-loading').hide();

        },
        error: function (errorThrown) {
          
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        }
    });//end ajax
}

<<<<<<< HEAD
////////////////////////////////////////////////////////////////////////////////////////////
/// show login form on fav login-jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function show_login_form() {
    "use strict";
    var  ajaxurl    =  ajaxcalls_vars.admin_url + 'admin-ajax.php';
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'    :   'wpestate_ajax_show_login_form'
        },
        success: function (data) {
            jQuery('body').append(data);
            jQuery('#loginmodal').modal();
            enable_actions_modal();
        },
        error: function (errorThrown) {
        }
    }); //end ajax

}
=======
>>>>>>> 64662fd89bea560852792d7203888072d7452d48

////////////////////////////////////////////////////////////////////////////////////////////
/// change pass on profile-jslint checked
////////////////////////////////////////////////////////////////////////////////////////////   
function wpestate_change_pass_profile() {
    "use strict";
    var oldpass, newpass, renewpass, securitypass, ajaxurl;
    oldpass         =  jQuery('#oldpass').val();
    newpass         =  jQuery('#newpass').val();
    renewpass       =  jQuery('#renewpass').val();
    securitypass    =  jQuery('#security-pass').val();
    ajaxurl         =  ajaxcalls_vars.admin_url + 'admin-ajax.php';

    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'            :   'wpestate_ajax_update_pass',
            'oldpass'           :   oldpass,
            'newpass'           :   newpass,
            'renewpass'         :   renewpass,
            'security-pass'     :   securitypass
        },
        success: function (data) {
            jQuery('#profile_pass').empty().append('<div class="login-alert">' + data + '<div>');
            jQuery('#oldpass, #newpass, #renewpass').val('');
        },
        error: function (errorThrown) {
        }
    });
}


////////////////////////////////////////////////////////////////////////////////////////////
/// user register -jslint checked
////////////////////////////////////////////////////////////////////////////////////////////

function wpestate_register_user(type) {
    "use strict";
<<<<<<< HEAD
    var user_login_register, user_email_register, user_pass, user_pass_retype, nonce, ajaxurl;
=======
    var capthca,user_login_register, user_email_register, user_pass, user_pass_retype, nonce, ajaxurl,new_user_type;
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    /* 1- topbar
     * 2- widget
     * 3- shortcode
     * 4- modal !?
<<<<<<< HEAD
     */
    
    ajaxurl             =  ajaxcalls_vars.admin_url + 'admin-ajax.php'; 
    jQuery('#register_message_area_topbar').empty().append('<div class="login-alert">'+control_vars.procesing+'</div>');
    
    if(type===1){
=======
     * 5 -mobile
     */
    
    capthca='';
  
    ajaxurl             =  ajaxcalls_vars.admin_url + 'admin-ajax.php'; 
    jQuery('#register_message_area_topbar').empty().append('<div class="login-alert">'+control_vars.procesing+'</div>');
   
    if(type===1){
        if(control_vars.usecaptcha==='yes'){
            capthca= grecaptcha.getResponse(
                widgetId1
            )
        }
        
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        user_login_register =  jQuery('#user_login_register_topbar').val();
        user_email_register =  jQuery('#user_email_register_topbar').val();
        nonce               =  jQuery('#security-register-topbar').val(); 
        if(ajaxcalls_vars.userpass === 'yes'){
            user_pass           =  jQuery('#user_password_topbar').val();
            user_pass_retype    =  jQuery('#user_password_topbar_retype').val();
        }
        
<<<<<<< HEAD
=======
        
        new_user_type= jQuery('#new_user_type_topbar').val();
        
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        if ( !jQuery('#user_terms_register_topbar').is(":checked") ) {
            jQuery('#register_message_area_topbar').empty().append('<div class="login-alert">'+control_vars.terms_cond+'</div>');
            return;
        }
    }else if(type===2){
<<<<<<< HEAD
=======
       
        if(control_vars.usecaptcha==='yes'){
            capthca= grecaptcha.getResponse(
                widgetId3
            )
        }
        
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        user_login_register =  jQuery('#user_login_register_wd').val();
        user_email_register =  jQuery('#user_email_register_wd').val();
        nonce               =  jQuery('#security-register').val(); 
        if(ajaxcalls_vars.userpass === 'yes'){
            user_pass           =  jQuery('#user_password_wd').val();
            user_pass_retype    =  jQuery('#user_password_wd_retype').val();
        }
        
<<<<<<< HEAD
=======
        new_user_type= jQuery('#new_user_type_wd').val();
        
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        if ( !jQuery('#user_terms_register_wd').is(":checked") ) {
            jQuery('#register_message_area_wd').empty().append('<div class="login-alert">'+control_vars.terms_cond+'</div>');
            return;
        }
    }else if(type===3){
<<<<<<< HEAD
=======
        
        if(control_vars.usecaptcha==='yes'){
            capthca= grecaptcha.getResponse(
                widgetId4
            )
        }
        
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        user_login_register =  jQuery('#user_login_register').val();
        user_email_register =  jQuery('#user_email_register').val();
        nonce               =  jQuery('#security-register').val(); 
        if(ajaxcalls_vars.userpass === 'yes'){
            user_pass           =  jQuery('#user_password').val();
            user_pass_retype    =  jQuery('#user_password_retype').val();
        }
<<<<<<< HEAD
       
=======
        
        new_user_type= jQuery('#new_user_type').val();
        
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        if ( !jQuery('#user_terms_register_sh').is(":checked") ) {
            jQuery('#register_message_area').empty().append('<div class="login-alert">'+control_vars.terms_cond+'</div>');
            return;
        }
<<<<<<< HEAD
    }
    
 
  

     
=======
    }else if(type===5){
        
        if(control_vars.usecaptcha==='yes'){
            capthca= grecaptcha.getResponse(
                widgetId2
            )
        }
        user_login_register =  jQuery('#user_login_register_mobile').val();
        user_email_register =  jQuery('#user_email_register_mobile').val();
        nonce               =  jQuery('#security-register-mobile').val(); 
        if(ajaxcalls_vars.userpass === 'yes'){
            user_pass           =  jQuery('#user_password_mobile').val();
            user_pass_retype    =  jQuery('#user_password_mobile_retype').val();
        }
        
        new_user_type= jQuery('#new_user_type_mobile').val();
         
   
         
         
        if ( !jQuery('#user_terms_register_mobile').is(":checked") ) {
            jQuery('#register_message_area_mobile').empty().append('<div class="login-alert">'+control_vars.terms_cond+'</div>');
            return;
        }
    }
    
 


  
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'                    :   'wpestate_ajax_register_user',
            'user_login_register'       :   user_login_register,
            'user_email_register'       :   user_email_register,
            'user_pass'                 :   user_pass,
            'user_pass_retype'          :   user_pass_retype,
            'type'                      :   type,
<<<<<<< HEAD
            'security-register'         :   nonce
=======
            'security-register'         :   nonce,
            'capthca'                   :   capthca,
            'new_user_type'             :   new_user_type
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        },

        success: function (data) {
           // This outputs the result of the ajax request
<<<<<<< HEAD
           
=======
         
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
            if(type===1){
                jQuery('#register_message_area_topbar').empty().append('<div class="login-alert">' + data + '</div>');
                jQuery('#user_login_register_topbar').val('');
                jQuery('#user_email_register_topbar').val('');
                jQuery('#user_password_topbar').val('');
                jQuery('#user_password_topbar_retype').val('');
<<<<<<< HEAD
=======
                jQuery('#new_user_type_topbar').val('0');
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
            }else  if(type===2){
                jQuery('#register_message_area_wd').empty().append('<div class="login-alert">' + data + '</div>');
                jQuery('#user_login_register_wd').val('');
                jQuery('#user_email_register_wd').val('');
                jQuery('#user_password_wd').val('');
                jQuery('#user_password_wd_retype').val('');
<<<<<<< HEAD
=======
                jQuery('#new_user_type_wd').val('0');
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
            }else  if(type===3){
                jQuery('#register_message_area').empty().append('<div class="login-alert">' + data + '</div>');
                jQuery('#user_login_register').val('');
                jQuery('#user_email_register').val('');
                jQuery('#user_password').val('');
                jQuery('#user_password_retype').val('');
<<<<<<< HEAD
=======
                jQuery('#new_user_type').val('0');
            }else  if(type===5){
                jQuery('#register_message_area_mobile').empty().append('<div class="login-alert">' + data + '</div>');
                jQuery('#user_login_register_mobile').val('');
                jQuery('#user_email_register_mobile').val('');
                jQuery('#user_password_mobile').val('');
                jQuery('#user_password_mobile_retype').val('');
                jQuery('#new_user_type_mobile').val('0');
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
            }
        },
        error: function (errorThrown) {
        }
    });
}





////////////////////////////////////////////////////////////////////////////////////////////
/// on ready -jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
function wpestate_forgot(type) {
    "use strict";
   
    var  forgot_email, securityforgot, postid, ajaxurl;
    if(type===1){
        forgot_email          =  jQuery('#forgot_email').val();
        securityforgot        =  jQuery('#security-forgot').val();
    }
    if(type===2){
        forgot_email          =  jQuery('#forgot_email_topbar').val();
        securityforgot        =  jQuery('#security-forgot-topbar').val();
    }
    if(type===3){
        forgot_email          =  jQuery('#forgot_email_shortcode').val();
        securityforgot        =  jQuery('#security-login-forgot_wd').val();
    }
<<<<<<< HEAD
=======
    if(type===5){
        forgot_email          =  jQuery('#forgot_email_mobile').val();
        securityforgot        =  jQuery('#security-forgot-mobile').val();
    }
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    
    postid                =  jQuery('#postid').val();
    ajaxurl               =  ajaxcalls_vars.admin_url + 'admin-ajax.php';

    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'            :   'wpestate_ajax_forgot_pass',
            'forgot_email'      :   forgot_email,
            'security-forgot'    :   securityforgot,
            'postid'            :   postid,
            'type'              :   type
        },

        success: function (data) {
        
            if(type===1){
                jQuery('#forgot_email').val('');
                jQuery('#forgot_pass_area').empty().append('<div class="login-alert">' + data + '<div>');        
            }
            if(type===2){
                jQuery('#forgot_email_topbar').val('');
                jQuery('#forgot_pass_area_topbar').empty().append('<div class="login-alert">' + data + '<div>');        
            }
            if(type===3){
                jQuery('#forgot_email_shortcode').val('');
                jQuery('#forgot_pass_area_shortcode').empty().append('<div class="login-alert">' + data + '<div>');        
            }
<<<<<<< HEAD
            
=======
            if(type===5){
                jQuery('#forgot_email_mobile').val('');
                jQuery('#forgot_pass_area_mobile').empty().append('<div class="login-alert">' + data + '<div>');        
            }
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        },
        error: function (errorThrown) {
        }
    });
}

////////////////////////////////////////////////////////////////////////////////////////////
/// on ready-jslint checked
////////////////////////////////////////////////////////////////////////////////////////////   
function wpestate_login_wd() {
    "use strict";
    var login_user, login_pwd, ispop, ajaxurl, security;

    login_user          =  jQuery('#login_user_wd').val();
    login_pwd           =  jQuery('#login_pwd_wd').val();
    security            =  jQuery('#security-login').val();
    ispop               =  jQuery('#loginpop_wd').val();
    ajaxurl             =  ajaxcalls_vars.admin_url + 'admin-ajax.php';

    jQuery('#login_message_area_wd').empty().append('<div class="login-alert">' + ajaxcalls_vars.login_loading + '</div>');
    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajaxurl,
        data: {
            'action'            :   'ajax_loginx_form',
            'login_user'        :   login_user,
            'login_pwd'         :   login_pwd,
            'ispop'             :   ispop,
            'security-login'    :   security
        },

        success: function (data) {
            jQuery('#login_message_area_wd').empty().append('<div class="login-alert">' + data.message + '<div>');
            if (data.loggedin === true) {
                if (parseInt(data.ispop, 10) === 1) {
                    ajaxcalls_vars.userid = data.newuser;
                    jQuery('#ajax_login_container').remove();
                } else {
                    document.location.href = ajaxcalls_vars.login_redirect;
                }
                jQuery('#user_not_logged_in').hide();
                jQuery('#user_logged_in').show();
            } else {
                jQuery('#login_user').val('');
                jQuery('#login_pwd').val('');
            }
        },
        error: function (errorThrown) {
<<<<<<< HEAD

=======
          
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        }
    });
}


////////////////////////////////////////////////////////////////////////////////////////////
/// on ready-jslint checked
////////////////////////////////////////////////////////////////////////////////////////////   
function wpestate_login_topbar() {
    "use strict";
<<<<<<< HEAD
    var login_user, login_pwd, ispop, ajaxurl, security;
=======
    var login_user, login_pwd, ispop, ajaxurl, security,ispop;
>>>>>>> 64662fd89bea560852792d7203888072d7452d48

    login_user          =  jQuery('#login_user_topbar').val();
    login_pwd           =  jQuery('#login_pwd_topbar').val();
    security            =  jQuery('#security-login-topbar').val();
    ajaxurl             =  ajaxcalls_vars.admin_url + 'admin-ajax.php';
<<<<<<< HEAD
=======
    ispop               =  jQuery('#loginpop').val();

>>>>>>> 64662fd89bea560852792d7203888072d7452d48

    jQuery('#login_message_area_topbar').empty().append('<div class="login-alert">' + ajaxcalls_vars.login_loading + '</div>');
    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajaxurl,
        data: {
            'action'            :   'ajax_loginx_form_topbar',
            'login_user'        :   login_user,
            'login_pwd'         :   login_pwd,
<<<<<<< HEAD
=======
            'ispop'             :   ispop,
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
            'security'          :   security
        },

        success: function (data) {
<<<<<<< HEAD
     
            jQuery('#login_message_area_topbar').empty().append('<div class="login-alert">' + data.message + '<div>');
            if (data.loggedin === true) {
              document.location.href = ajaxcalls_vars.login_redirect;
=======
         
            
            console.log("data.ispop "+data.ispop);
            
            
            jQuery('#login_message_area_topbar').empty().append('<div class="login-alert">' + data.message + '<div>');
            if (data.loggedin === true) {
                 if (parseInt(data.ispop, 10) === 1) {
                   
                    ajaxcalls_vars.userid = data.newuser;
                   
                    jQuery('#user_menu_u.user_not_loged').unbind('click');
                    jQuery('#user_menu_u').removeClass('user_not_loged').addClass('user_loged');
                    jQuery('#modal_login_wrapper').hide();
                    update_menu_bar(data.newuser);
                    wpestate_open_menu();
                }else if (parseInt(data.ispop, 10) === 2) {
                    location.reload();
                }else if (parseInt(data.ispop, 10) === 3) {
                    ajaxcalls_vars.userid = data.newuser;
                    jQuery('#user_menu_u.user_not_loged').unbind('click');
                    jQuery('#user_menu_u').removeClass('user_not_loged').addClass('user_loged');
                    jQuery('#modal_login_wrapper').hide();
                    update_menu_bar(data.newuser);
                    wpestate_open_menu();
                 }else {
                    document.location.href = ajaxcalls_vars.login_redirect;
                }
                
             
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
            } else {
                jQuery('#login_user').val('');
                jQuery('#login_pwd').val('');
            }
        },
        error: function (errorThrown) {
<<<<<<< HEAD
           
=======
         
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        }
    });
}


<<<<<<< HEAD

////////////////////////////////////////////////////////////////////////////////
// enable actions modal -jslint checked
////////////////////////////////////////////////////////////////////////////////
function enable_actions_modal() {
    "use strict";
    jQuery('#facebooklogin').click(function () {
        jQuery('#cover').hide();
        login_via_facebook(jQuery(this));
    });

    jQuery('#googlelogin,#yahoologin').click(function () {
        jQuery('#cover').hide();
        login_via_google(jQuery(this));
    });

    jQuery('#closeadvancedlogin').click(function () {
        jQuery('#ajax_login_container').remove();
        jQuery('#cover').remove();
    });

    jQuery('#reveal_register').click(function () {
        jQuery('#ajax_login_div').fadeOut(400, function () {
            jQuery('#ajax_register_div').fadeIn();
        });
    });

    jQuery('#reveal_login').click(function () {
        jQuery('#ajax_register_div').fadeOut(400, function () {
            jQuery('#ajax_login_div').fadeIn();
        });
    });


    jQuery('#wp-login-but').click(function () {
        wpestate_login();
    });

    jQuery('#login_pwd, #login_user').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_login();
        }
    });


    jQuery('#wp-submit-register').click(function () {
        wpestate_register_user(3);
    });

    jQuery('#user_email_register, #user_login_register, #user_password, #user_password_retype').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_register_user(3);
=======
function wpestate_login_mobile() {
    "use strict";
    var login_user, login_pwd, ispop, ajaxurl, security;

    login_user          =  jQuery('#login_user_mobile').val();
    login_pwd           =  jQuery('#login_pwd_mobile').val();
    security            =  jQuery('#security-login-mobile').val();
    ajaxurl             =  ajaxcalls_vars.admin_url + 'admin-ajax.php';

    jQuery('#login_message_area_mobile').empty().append('<div class="login-alert">' + ajaxcalls_vars.login_loading + '</div>');
    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajaxurl,
        data: {
            'action'            :   'wpestate_ajax_loginx_form_mobile',
            'login_user'        :   login_user,
            'login_pwd'         :   login_pwd,
            'security'          :   security
        },

        success: function (data) {
     
            jQuery('#login_message_area_mobile').empty().append('<div class="login-alert">' + data.message + '<div>');
            if (data.loggedin === true) {
               
               if (parseInt(jQuery('#loginpop').val(), 10) === 2) {
                    location.reload();
                } else {
                    document.location.href = ajaxcalls_vars.login_redirect;
                }
            } else {
                jQuery('#login_user_mobile').val('');
                jQuery('#login_pwd_mobile').val('');
            }
        },
        error: function (errorThrown) {
           
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        }
    });
}

<<<<<<< HEAD

////////////////////////////////////////////////////////////////////////////////
=======
////////////////////////////////////////////////////////////////////////////////
// enable actions modal -jslint checked
////////////////////////////////////////////////////////////////////////////////
//function enable_actions_modal() {
//    "use strict";
//    jQuery('#facebooklogin').click(function () {
//        jQuery('#cover').hide();
//        login_via_facebook(jQuery(this));
//    });
//
//    jQuery('#yahoologin').click(function () {
//        jQuery('#cover').hide();
//        login_via_google(jQuery(this));
//    });
//
//    jQuery('#googlelogin').click(function () {
//        jQuery('#cover').hide();
//         login_via_google_oauth();
//    });
//    ///////////////////////////////////////////////////////////////////////////////////////////  
//    ////////  open id login - via google
//    //////////////////////////////////////////////////////////////////////////////////////////// 
//
// 
//
//
// 
//
//
//    jQuery('#closeadvancedlogin').click(function () {
//        jQuery('#ajax_login_container').remove();
//        jQuery('#cover').remove();
//    });
//
//    jQuery('#reveal_register').click(function () {
//        jQuery('#ajax_login_div').fadeOut(400, function () {
//            jQuery('#ajax_register_div').fadeIn();
//        });
//    });
//
//    jQuery('#reveal_login').click(function () {
//        jQuery('#ajax_register_div').fadeOut(400, function () {
//            jQuery('#ajax_login_div').fadeIn();
//        });
//    });
//
//
//    jQuery('#wp-login-but').click(function () {
//        wpestate_login();
//    });
//
//    jQuery('#login_pwd, #login_user').keydown(function (e) {
//        if (e.keyCode === 13) {
//            e.preventDefault();
//            wpestate_login();
//        }
//    });
//
//
//    jQuery('#wp-submit-register').click(function () {
//        wpestate_register_user(3);
//    });
//
//    jQuery('#user_email_register, #user_login_register, #user_password, #user_password_retype').keydown(function (e) {
//        if (e.keyCode === 13) {
//            e.preventDefault();
//            wpestate_register_user(3);
//        }
//    });
//}
//
//
//////////////////////////////////////////////////////////////////////////////////
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
// login function -jslint checked
////////////////////////////////////////////////////////////////////////////////
function wpestate_login() {
    "use strict";
    var login_user, login_pwd, security, ispop, ajaxurl;
    login_user          =  jQuery('#login_user').val();
    login_pwd           =  jQuery('#login_pwd').val();
    security            =  jQuery('#security-login').val();
    ispop               =  jQuery('#loginpop').val();
    ajaxurl             =  ajaxcalls_vars.admin_url + 'admin-ajax.php';

    jQuery('#login_message_area').empty().append('<div class="login-alert">' + ajaxcalls_vars.login_loading + '</div>');
    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajaxurl,
        data: {
            'action'            :   'ajax_loginx_form',
            'login_user'        :   login_user,
            'login_pwd'         :   login_pwd,
            'ispop'             :   ispop,
            'security-login'    :   security
        },
        success: function (data) {
            jQuery('#login_message_area').empty().append('<div class="login-alert">' + data.message + '<div>');
            if (data.loggedin === true) {
                if (parseInt(data.ispop, 10) === 1) {
<<<<<<< HEAD
=======
                   
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
                    ajaxcalls_vars.userid = data.newuser;
                    jQuery('#loginmodal').modal('hide');
                    update_menu_bar(data.newuser);
                } else {
                    document.location.href = ajaxcalls_vars.login_redirect;
                }
                jQuery('#user_not_logged_in').hide();
                jQuery('#user_logged_in').show();
            } else {
                jQuery('#login_user').val('');
                jQuery('#login_pwd').val('');
            }
        },
        error: function (errorThrown) {
        }
    });
}

////////////////////////////////////////////////////////////////////////////////
// login via facebook-jslint checked
////////////////////////////////////////////////////////////////////////////////    
function login_via_facebook(button) {
    "use strict";
    var login_type, ajaxurl;
    ajaxurl     =   control_vars.admin_url + 'admin-ajax.php';
    login_type  =   'facebook';

<<<<<<< HEAD
    jQuery.ajax({
=======
   
     jQuery.ajax({
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'            :   'wpestate_ajax_facebook_login',
<<<<<<< HEAD
            'login_type'        :   login_type
=======
            'login_type'        :   login_type,
         
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        },
        success: function (data) {
            window.location.href = data;
        },
        error: function (errorThrown) {
<<<<<<< HEAD
=======
           
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        }
    });//end ajax
}

////////////////////////////////////////////////////////////////////////////////
// login via google / openid -jslint checked
////////////////////////////////////////////////////////////////////////////////
function login_via_google(button) {
    "use strict";
    var ajaxurl, login_type;
    ajaxurl         =  control_vars.admin_url + 'admin-ajax.php';
    login_type      =  button.attr('data-social');

    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'            :   'wpestate_ajax_google_login',
            'login_type'        :   login_type
        },
        success: function (data) {
            window.location.href = data;
        },
        error: function (errorThrown) {
        }
    });//end ajax
}
////////////////////////////////////////////////////////////////////////////////
// login via google / openid -jslint checked
////////////////////////////////////////////////////////////////////////////////

function login_via_google_oauth() {
    "use strict";
    var ajaxurl, login_type;
    ajaxurl         =  control_vars.admin_url + 'admin-ajax.php';

    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            'action'            :   'wpestate_ajax_google_login_oauth'
        },
        success: function (data) {
            window.location.href = data;
        },
        error: function (errorThrown) {
        }
    });//end ajax
}

////////////////////////////////////////////////////////////////////////////////
// update bar after login -jslint checked
////////////////////////////////////////////////////////////////////////////////
function update_menu_bar(newuser) {
    "use strict";
    var usericon, ajaxurl;
    ajaxurl =   control_vars.admin_url + 'admin-ajax.php';

    jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajaxurl,
        data: {
            'action'            :   "wpestate_update_menu_bar",
            'newuser'           :    newuser
        },
        success: function (data) {
<<<<<<< HEAD
            jQuery('#user_menu_open').empty().append(data.menu).addClass('menulist');
            usericon = '<div class="menu_user_picture" style="background-image: url(' + data.picture + ')"></div>';
            jQuery('#user_menu_u').append(usericon).addClass('user_loged');
            jQuery('.submit_action').remove();
=======
      
            jQuery('#user_menu_u').after(data.menu);
          
            usericon = '<div class="menu_user_picture" style="background-image: url(' + data.picture + ')"></div>';
            jQuery('#user_menu_u').append(usericon).addClass('user_loged');
            jQuery('.submit_action').remove();
            jQuery('#agent_property_ajax_nonce').val(data.nonce_contact);
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
            
        },
        error: function (errorThrown) {
        }
    });//end ajax
}

////////////////////////////////////////////////////////////////////////////////////////////
<<<<<<< HEAD
/// on ready -jslint checked
////////////////////////////////////////////////////////////////////////////////////////////
jQuery(document).ready(function ($) {
    "use strict";

=======
// on ready -jslint checked
//  developer listing on tab click !!
////////////////////////////////////////////////////////////////////////////////////////////
jQuery(document).ready(function ($) {
    "use strict";
    
    $('.developer_listing .term_bar_item').click(function(event){
		
        // display load more
        var listing_parent_pointer = $(this).parents('.single_listing_block');	
        $('.load_more_ajax_cont .listing_load_more', listing_parent_pointer).fadeIn();
		
        $('.term_bar_item').removeClass('active_term');
        $(this).addClass('active_term');
        var ajaxurl         =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
        var term_name       =   $(this).attr('data-term_name');
        var agency_id       =   $('.term_bar_wrapper').attr('data-agency_id');
        var post_id         =   $('.term_bar_wrapper').attr('data-post_id');
        var is_agency       =   0;
        
        if( $('.single-estate_agency').length >0){
            is_agency=1;
        }
      
        $('.agency_listings_wrapper').empty();
        $('#listing_loader').show();
      

       
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'        :   'wpestate_agency_listings',
                'term_name'     :   term_name,
                'agency_id'     :   agency_id,
		'post_id'       :   post_id,
                'is_agency'     :   is_agency
               
            },
            success: function (data) {
              
                $('#listing_loader').hide();
                $('.agency_listings_wrapper').append(data);
                restart_js_after_ajax();
               
                
            },
            error: function (errorThrown) {
            }
        });
       
       
        
    });


////////////////////////////////////////////////////////////////////////////////////////////
// agent page listing tabs processing
////////////////////////////////////////////////////////////////////////////////////////////
 
    $('.agent_listing .term_bar_item').click(function(event){
		
        // display load more
        var listing_parent_pointer = $(this).parents('.single_listing_block');	
        $('.load_more_ajax_cont .listing_load_more', listing_parent_pointer).fadeIn();
		
		
        $('.term_bar_item').removeClass('active_term');
        $(this).addClass('active_term');
        var ajaxurl         =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
        var term_name       =   $(this).attr('data-term_name');
        var agent_id       =   $('.term_bar_wrapper').attr('data-agent_id');
        var post_id       =   $('.term_bar_wrapper').attr('data-post_id');
        
        $('.agency_listings_wrapper').empty();
        $('#listing_loader', listing_parent_pointer).show();
      

       
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'        :   'wpestate_agent_listings',
                'term_name'     :   term_name,
                'agent_id'     :   agent_id,
                'post_id'     :   post_id,                
            },
            success: function (data) {
				
                $('#listing_loader', listing_parent_pointer).hide();
                $('.agency_listings_wrapper').append(data);
                restart_js_after_ajax();
               
                
            },
            error: function (errorThrown) {
            }
        });
       
       
        
    });
	
	
////////////////////////////////////////////////////////////////////////////////////////////
// agent / developer load more processing
////////////////////////////////////////////////////////////////////////////////////////////
 
    $('body').on( 'click', '.listing_load_more', function(event){
		
        var this_point = $(this);
        var listing_parent_pointer = $(this).parents('.single_listing_block');		
        var loaded_items = $('.agency_listings_wrapper .listing_wrapper', listing_parent_pointer).length;

        var active_tab = $('.active_term', listing_parent_pointer );
	
        var ajaxurl         =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
        var term_name       =   $(active_tab).attr('data-term_name');
        var agent_id       =   $('.term_bar_wrapper', listing_parent_pointer).attr('data-agent_id');
        var post_id       =   $('.term_bar_wrapper', listing_parent_pointer).attr('data-post_id');
      
        var agency_id       =   $('.term_bar_wrapper', listing_parent_pointer).attr('data-agency_id');
     
		 var is_agency       =   0;
        
        if( $('.single-estate_agency').length >0){
            is_agency=1;
        }
         
	 
        

      
        $('#listing_loader', listing_parent_pointer).fadeIn();

	
        if( agent_id ){
            var action_name = 'wpestate_agent_listings';
        }
        if( agency_id ){
            var action_name = 'wpestate_agency_listings';
        }
	  
  
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'        :   action_name ,
                'term_name'     :   term_name,
                'agent_id'      :   agent_id,  
                'agency_id'     :   agency_id,
                'post_id'       :   post_id,  
                'loaded'        :   loaded_items,
				'is_agency' : is_agency
            },
            success: function (data) {
 
				$('#listing_loader', listing_parent_pointer).fadeOut();
				/*
				$('.load_more_ajax_cont .load_more_progress_bar', listing_parent_pointer).hide();
				*/
				// hide load more if no results
				var count = (data.match(/is/g) || []).length;
				
				 
				if( count === 0 ){
					this_point.fadeOut();
				}else{
					$('.agency_listings_wrapper').append(data);
				}
 
                restart_js_after_ajax();
            },
            error: function (errorThrown) {
            
            }
        });
       
       
        
    });
	
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////
    //// stripe cancel
    ///////////////////////////////////////////////////////////////////////////////////////////
   $('.disable_listing').click(function (event) {
       event.stopPropagation();
       var prop_id     =   $(this).attr('data-postid');
        var ajaxurl     =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
        var is_disabled =   0;
        if ( $(this).hasClass('disabledx') ){
            is_disabled=1;
            $(this).removeClass('disabledx');
        }else{
              $(this).addClass('disabledx');
        }
        var element     = $(this);
        var container   = $(this).parent().parent().parent(); 
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'       :   'wpestate_disable_listing',
                'prop_id'      :   prop_id,
               
            },
            success: function (data) {
                var label_text=''
                if (is_disabled===1){
                    element.empty().append('<i class="fa fa-play"></i>');
                    container.find('.user_dashboard_status').empty().append('<span class="label label-info">'+ajaxcalls_vars.disabled+'</span>');
                 
                  
                    if( jQuery('.page-template-user_dashboard_agent_list').length > 0){
                        label_text= ajaxcalls_vars.enableagent;
                    }else{
                        label_text= ajaxcalls_vars.enablelisting;
                    }
                    
                    element.tooltip('hide')
                    .attr('data-original-title',label_text )
                    .tooltip('fixTitle')
                    .tooltip('show');
                    

  
                }else{
                    if( jQuery('.page-template-user_dashboard_agent_list').length > 0){
                        label_text= ajaxcalls_vars.disableagent;
                    }else{
                        label_text= ajaxcalls_vars.disablelisting;
                    }
                     
                    element.empty().append('<i class="fa fa-pause"></i>');
                    container.find('.user_dashboard_status').empty().append('<span class="label label-success">'+ajaxcalls_vars.published+'</span>');
                    element.tooltip('hide')
                    .attr('data-original-title', label_text)
                    .tooltip('fixTitle')
                    .tooltip('show');
                    
                }
               
                
            },
            error: function (errorThrown) {
            }
        });
    });
>>>>>>> 64662fd89bea560852792d7203888072d7452d48

    ///////////////////////////////////////////////////////////////////////////////////////////
    //// stripe cancel
    ///////////////////////////////////////////////////////////////////////////////////////////
    $('#stripe_cancel').click(function(){
        var stripe_user_id, ajaxurl;
        stripe_user_id    =   $(this).attr('data-stripeid');
        ajaxurl         =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
        $('#stripe_cancel').text(ajaxcalls_vars.saving);
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'                  :   'wpestate_cancel_stripe',
                'stripe_customer_id'      :   stripe_user_id,
               
            },
            success: function (data) {
                $('#stripe_cancel').text(ajaxcalls_vars.stripecancel);
            },
            error: function (errorThrown) {
            }
        });
    });


    ////////////////////////////////////////////////////////////////////////////////////////////
    /// resend for approval  
    ///////////////////////////////////////////////////////////////////////////////////////////
    $('.resend_pending').click(function () {
        var prop_id = $(this).attr('data-listingid');
        resend_for_approval(prop_id, $(this));
    });

    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  set featured inside membership
    ///////////////////////////////////////////////////////////////////////////////////////////  
    $('.make_featured').click(function () {
        var prop_id = $(this).attr('data-postid');
        make_prop_featured(prop_id, $(this));
        $(this).unbind( "click" );
    });


    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  pack upgrade via paypal    
    ///////////////////////////////////////////////////////////////////////////////////////////  
    $('#pick_pack').click(function () {
        var pay_paypal;
        pay_paypal='<div class="modal fade" id="paypal_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-body listing-submit">'+ajaxcalls_vars.paypal+'</div></div></div></div></div>';
        jQuery('body').append(pay_paypal);
        jQuery('#paypal_modal').modal();
            
            
        if ($('#pack_recuring').is(':checked')) {
            recuring_pay_pack_via_paypal();
        } else {
            pay_pack_via_paypal();
        }
    });

    ///////////////////////////////////////////////////////////////////////////////////////////  
    //////// listing pay via paypal
    ///////////////////////////////////////////////////////////////////////////////////////////  
    $('.listing_submit_normal').click(function () {
        var prop_id, featured_checker, is_featured, is_upgrade,pay_paypal;
        pay_paypal='<div class="modal fade" id="paypal_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-body listing-submit">'+ajaxcalls_vars.paypal+'</div></div></div></div></div>';
        jQuery('body').append(pay_paypal);
        jQuery('#paypal_modal').modal();
        
        
        prop_id = $(this).attr('data-listingid');
        featured_checker = $(this).parent().find('input');
        is_featured = 0;
        is_upgrade = 0;

        if (featured_checker.prop('checked')) {
            is_featured = 1;
        } else {
            is_featured = 0;
        }

        listing_pay(prop_id, $(this), is_featured, is_upgrade);
    });


    $('.listing_upgrade').click(function () {
        var is_upgrade, is_featured, prop_id;
        is_upgrade = 1;
        is_featured = 0;
        prop_id = $(this).attr('data-listingid');
        listing_pay(prop_id, $(this), is_featured, is_upgrade);
    });

    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  login via facebook conect    
    ///////////////////////////////////////////////////////////////////////////////////////////  

<<<<<<< HEAD
    $('#facebooklogin, #facebookloginsidebar, #facebookloginsidebar_topbar').click(function () {
=======
    $('#facebooklogin, #facebookloginsidebar, #facebookloginsidebar_topbar,#facebookloginsidebar_mobile').click(function () {
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        login_via_facebook($(this));
    });

    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  open id login - via google
    //////////////////////////////////////////////////////////////////////////////////////////// 

<<<<<<< HEAD
    $('#yahoologin, #aollogin,  #yahoologinsidebar, #yahoologinsidebar_topbar').click(function () {
        login_via_google($(this));
    });

  $('#googlelogin, #googleloginsidebar, #googleloginsidebar_topbar').click(function () {
=======
    $('#yahoologin, #aollogin,  #yahoologinsidebar, #yahoologinsidebar_topbar,#yahoologinsidebar_mobile').click(function () {
        login_via_google($(this));
    });

  $('#googlelogin, #googleloginsidebar, #googleloginsidebar_topbar,#googleloginsidebar_mobile').click(function () {
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        login_via_google_oauth();
    });

    ///////////////////////////////////////////////////////////////////////////////////////////
    /////// Property page  + ajax call on contact
    ///////////////////////////////////////////////////////////////////////////////////////////
<<<<<<< HEAD
    $('#agent_submit').click(function () {
        var contact_name, contact_email, contact_phone, contact_coment, agent_email, property_id, nonce, ajaxurl;
        contact_name    =   $('#agent_contact_name').val();
        contact_email   =   $('#agent_user_email').val();
        contact_phone   =   $('#agent_phone').val();
        contact_coment  =   $('#agent_comment').val();
        agent_email     =   $('#agent_email').val();
        property_id     =   $('#agent_property_id').val();
        nonce           =   $('#agent_property_ajax_nonce').val();
        ajaxurl         =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
        
        $('#alert-agent-contact').empty().append(ajaxcalls_vars.sending);

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxurl,
=======
   // $('#agent_submit').click(function () {
        
    $('.agent_submit_class').click(function () {
        var parent,contact_name, contact_email, contact_phone, contact_coment, agent_id, property_id, nonce, ajaxurl;
        parent=$(this).parent();
        contact_name    =   parent.find('#agent_contact_name').val();
        contact_email   =   parent.find('#agent_user_email').val();
        contact_phone   =   parent.find('#agent_phone').val();
        contact_coment  =   parent.find('#agent_comment').val();
        agent_id        =   parent.find('#agent_id').val();
        property_id     =   parent.find('#agent_property_id').val();
        nonce           =   parent.find('#agent_property_ajax_nonce').val();
        ajaxurl         =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
        var schedule_day    =   parent.find('#schedule_day').val();
        var schedule_hour   =   parent.find('#schedule_hour').val();
        parent.find('#alert-agent-contact').empty().append(ajaxcalls_vars.sending);
// 
        $.ajax({
            type: 'POST',
            dataType: 'json',
           url: ajaxurl,
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
            data: {
                'action'    :   'wpestate_ajax_agent_contact_form',
                'name'      :   contact_name,
                'email'     :   contact_email,
                'phone'     :   contact_phone,
                'comment'   :   contact_coment,
<<<<<<< HEAD
                'agentemail':   agent_email,
                'propid'    :   property_id,
                'nonce'     :   nonce
            },
            success: function (data) {
               // This outputs the result of the ajax request
         
                if (data.sent) {
                    $('#agent_contact_name').val('');
                    $('#agent_user_email').val('');
                    $('#agent_phone').val('');
                    $('#agent_comment').val('');
                }
                $('#alert-agent-contact').empty().append(data.response);
            },
            error: function (errorThrown) {
=======
                'agent_id'  :   agent_id,
                'propid'    :   property_id,
                'schedule_day'  :   schedule_day,
                'schedule_hour' :   schedule_hour,
                'nonce'     :   nonce
            },
            success: function (data) {
             
                if (data.sent) {
                    parent.find('#agent_contact_name').val('');
                    parent.find('#agent_user_email').val('');
                    parent.find('#agent_phone').val('');
                    parent.find('#agent_comment').val('');
                    parent.find('#schedule_day').val('');
                    parent.find('#schedule_hour').val('');
                }
                parent.find('#alert-agent-contact').empty().append(data.response);
            },
            error: function (errorThrown) {
            
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
            }
        });
    });

<<<<<<< HEAD
    
=======
   
    $('.message_submit').click(function(){
        
        if (parseInt(ajaxcalls_vars.userid, 10) === 0 ) { 
            if (!Modernizr.mq('only all and (max-width: 768px)')) {
                jQuery('#modal_login_wrapper').show(); 
                jQuery('#loginpop').val('1');
            }else{
                jQuery('.mobile-trigger-user').trigger('click');
            }
        } else {
          
            var parent=$(this).parent();
            var contact_name    =   parent.find('#agent_contact_name').val();
            var contact_email   =   parent.find('#agent_user_email').val();
            var contact_phone   =   parent.find('#agent_phone').val();
            var contact_coment  =   parent.find('#agent_comment').val();
            var agent_id        =   parent.find('#agent_id').val();
            var property_id     =   parent.find('#agent_property_id').val();
            var nonce           =   parent.find('#agent_property_ajax_nonce').val();
            var ajaxurl         =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
            var schedule_day    =   parent.find('#schedule_day').val();
            var schedule_hour   =   parent.find('#schedule_hour').val();
            
            
            
            parent.find('#alert-agent-contact').empty().append(ajaxcalls_vars.sending);

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: ajaxurl,
                data: {
                    'action'        :   'wpestate_ajax_send_message',
                    'name'          :   contact_name,
                    'email'         :   contact_email,
                    'phone'         :   contact_phone,
                    'comment'       :   contact_coment,
                    'agent_id'      :   agent_id,
                    'propid'        :   property_id,
                    'schedule_day'  :   schedule_day,
                    'schedule_hour' :   schedule_hour,
                    'nonce'         :   nonce
                },
                success: function (data) {
                  
                    if (data.sent) {
                        parent.find('#agent_contact_name').val('');
                        parent.find('#agent_user_email').val('');
                        parent.find('#agent_phone').val('');
                        parent.find('#agent_comment').val('');
                        parent.find('#schedule_day').val('');
                        parent.find('#schedule_hour').val('');
                    }
                    parent.find('#alert-agent-contact').empty().append(data.response);
                },
                error: function (errorThrown) {
                
                }
            });
        }
    });
>>>>>>> 64662fd89bea560852792d7203888072d7452d48

    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  property listing listing
    ////////////////////////////////////////////////////////////////////////////////////////////       

    $('.listing_filters_head li').click(function () {
        var pick, value, parent;
        pick = $(this).text();
        value = $(this).attr('data-value');
        parent = $(this).parent().parent();
<<<<<<< HEAD
        parent.find('.filter_menu_trigger').text(pick).append('<span class="caret caret_filter"></span>').attr('data-value', value);
=======
        parent.find('.filter_menu_trigger').text(pick).append('<span class="caret caret_filter"></span>').attr('data-value',value);
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        parent.find('input:hidden'). val(value);
       
        start_filtering(1);
        
       
<<<<<<< HEAD
        show_pins_filters_from_file();       
=======
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    });
    
    
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////  
    //////// advanced search filtering
    ////////////////////////////////////////////////////////////////////////////////////////////       

    $('.adv_listing_filters_head li').click(function () {
<<<<<<< HEAD

        var pick, value, parent, args,page_id,ajaxurl;
        ajaxurl         =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
        pick = $(this).text();
        value = $(this).attr('data-value');
        parent = $(this).parent().parent();
        parent.find('.filter_menu_trigger').text(pick).append('<span class="caret caret_filter"></span>').attr('data-value', value);
        args = $('#searcharg').val();
        page_id = $('#page_idx').val();
=======
        console.log('adv_listing_filters_head');
        var pick, value, parent, args,page_id,ajaxurl;
        ajaxurl         =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
        pick        = $(this).text();
        value       = $(this).attr('data-value');
        parent      = $(this).parent().parent();
        parent.find('.filter_menu_trigger').text(pick).append('<span class="caret caret_filter"></span>').attr('data-value',value);
        args        = $('#searcharg').val();
        page_id     = $('#page_idx').val();
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        $('#listing_ajax_container').empty();
        $('#listing_loader').show();
        
        $.ajax({
                type: 'POST',
                url: ajaxurl,
              
                data: {
                    'action'    :   'wpestate_advanced_search_filters',
                    'args'      :   args,
                    'value'     :   value,
                    'page_id'   :   page_id
                },
                success: function (data) {
<<<<<<< HEAD
               
                    $('#listing_loader').hide();
                    $('#listing_ajax_container').append(data);
                     restart_js_after_ajax();
=======
                    $('#listing_loader').hide();
                    $('#listing_ajax_container').append(data);
                    restart_js_after_ajax();
                    add_pagination_orderby();
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
                },
                error: function (errorThrown) {
                }
            }); //end ajax
    });

<<<<<<< HEAD

=======
   
    function add_pagination_orderby(){
         
        var   order = $('#a_filter_order').attr('data-value');
        
        jQuery('.pagination a').each(function(){
            var href = $(this).attr('href');
            href=href+"&order_search="+order;
            $(this).attr('href',href);

        });

     

    }
>>>>>>> 64662fd89bea560852792d7203888072d7452d48

    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  Ajax add to favorites on listing
    ////////////////////////////////////////////////////////////////////////////////////////////        
    $('.icon-fav').click(function (event) {
        event.stopPropagation();
        var icon = $(this);
        add_remove_favorite(icon);
    });

    // remove from fav listing on user profile
    $('.icon-fav-on-remove').click(function (event) {
        event.stopPropagation();
        $(this).parent().parent().remove();
        
    });

    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  Ajax add to favorites on propr
    ////////////////////////////////////////////////////////////////////////////////////////////        
    $('#add_favorites').click(function () {
        var post_id, securitypass, ajaxurl;
        post_id         =  $('#add_favorites').attr('data-postid');
        securitypass    =  $('#security-pass').val();
        ajaxurl         =  ajaxcalls_vars.admin_url + 'admin-ajax.php';

        if (parseInt(ajaxcalls_vars.userid, 10)  === 0) {
<<<<<<< HEAD
            show_login_form();
=======
            if (!Modernizr.mq('only all and (max-width: 768px)')) {
                jQuery('#modal_login_wrapper').show(); 
                jQuery('#loginpop').val('1');
            }else{
                jQuery('.mobile-trigger-user').trigger('click');
            }
       
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        } else {
            $('#add_favorites').text(ajaxcalls_vars.saving);
            $.ajax({
                type: 'POST',
                url: ajaxurl,
                dataType: 'json',
                data: {
                    'action'            :   'wpestate_ajax_add_fav',
                    'post_id'           :    post_id
                },
                success: function (data) {
                    if (data.added) {
                        $('#add_favorites').text(ajaxcalls_vars.favorite).removeClass('isnotfavorite').addClass('isfavorite');
                    } else {
                        $('#add_favorites').text(ajaxcalls_vars.add_favorite).removeClass('isfavorite').addClass('isnotfavorite');
                    }
                },
                error: function (errorThrown) {
                }
            }); //end ajax
        }// end check login
    });


    ////////////////////////////////////////////////////////////////////////////////
    // register calls and functions
    ////////////////////////////////////////////////////////////////////////////////
    $('#wp-submit-register').click(function () {
        wpestate_register_user(3);
    });

    jQuery('#user_email_register, #user_login_register, #user_password, #user_password_retype').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_register_user(3);
        }
    });

    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  WIDGET Register ajax
    ////////////////////////////////////////////////////////////////////////////////////////////
    $('#wp-submit-register_wd').click(function () {
        wpestate_register_user(2);
    });

    $('#user_email_register_wd, #user_login_register_wd').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_register_user(2);
        }
    });
   
    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  TOPBAR Register ajax
    ////////////////////////////////////////////////////////////////////////////////////////////
    $('#wp-submit-register_topbar').click(function () {
        wpestate_register_user(1);
    });

    $('#user_email_register_topbar, #user_login_register_topbar, #user_password_topbar, #user_password_topbar_retype').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_register_user(1);
        }
    });
    
<<<<<<< HEAD
=======
     $('#wp-submit-register_mobile').click(function () {
        wpestate_register_user(5);
    });

    $('#user_email_register_mobile, #user_login_register_mobile, #user_password_mobile, #user_password_mobile_retype').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_register_user(5);
        }
    });
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  login/forgot password  actions
    ////////////////////////////////////////////////////////////////////////////////////////////  
    $('#forgot_pass').click(function (event) {
        event.preventDefault();
        $("#login-div").hide();
        $("#forgot-pass-div-sh").show();
    });

    $('#return_login').click(function (event) {
        event.preventDefault();
        $("#forgot-pass-div-sh").hide();
        $("#login-div").show();
    });


    $('#forgot_pass_topbar').click(function (event) {
        event.preventDefault();
<<<<<<< HEAD
        $("#login-div_topbar,#login-div-title-topbar").hide();
        $("#forgot-div-title-topbar,#forgot-pass-div").show();
    });

=======
        $("#login-div_topbar,#login-div-title-topbar,#register-div-topbar,#login-div_topbar,#register-div-title-topbar").hide();
        $("#forgot-div-title-topbar,#forgot-pass-div").show();
        $('#forgot_pass_topbar').hide();
    });


    $('#forgot_pass_mobile').click(function (event) {
        event.preventDefault();
        $("#login-div_mobile,#login-div-title-mobile").hide();
        $("#forgot-div-title-mobile,#forgot-pass-div").show();
    });


>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    $('#return_login_topbar').click(function (event) {
        event.preventDefault();
        $("#forgot-div-title-topbar,#forgot-pass-div").hide();
        $("#login-div_topbar,#login-div-title-topbar").show();
    });

<<<<<<< HEAD

=======
    $('#return_login_mobile').click(function (event) {
        event.preventDefault();
        $("#forgot-div-title-mobile,#forgot-pass-div").hide();
        $("#login-div_mobile,#login-div-title-mobile").show();
    });
>>>>>>> 64662fd89bea560852792d7203888072d7452d48

    $('#forgot_pass_widget').click(function (event) {
        event.preventDefault();
        $("#login-div-title,#login-div").hide();
        $("#forgot-pass-div_shortcode,#forgot-div-title_shortcode").show();
    });

    $('#return_login_shortcode').click(function (event) {
        event.preventDefault();
        $("#forgot-pass-div_shortcode,#forgot-div-title_shortcode").hide();
        $("#login-div-title,#login-div").show();
    });

    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  forgot pass  
    ////////////////////////////////////////////////////////////////////////////////////////////
    $('#wp-forgot-but').click(function () {
        wpestate_forgot(1);
    });
    
    $('#wp-forgot-but-topbar').click(function () {
        wpestate_forgot(2);
    });
<<<<<<< HEAD
=======
     
    $('#wp-forgot-but-mobile').click(function () {
        wpestate_forgot(5);
    });
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    
    
    $('#wp-forgot-but_shortcode').click(function () {
        wpestate_forgot(3);
    });
    

    $('#forgot_email').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_forgot(1);
        }
    });

    $('#forgot_email_topbar').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_forgot(2);
        }
    });
    
    $('#forgot_email_topbar').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_forgot(3);
        }
    });
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////  
    //////// TOPBAR  login/forgot password  actions
    ////////////////////////////////////////////////////////////////////////////////////////////     
    $('#widget_register_topbar').click(function (event) {
        event.preventDefault();
<<<<<<< HEAD
        $('#login-div_topbar').hide();
        $('#register-div-topbar').show();
        $('#login-div-title-topbar').hide();
        $('#register-div-title-topbar').show();
=======
        $('#login-div_topbar,#widget_register_topbar,#login-div-title-topbar,#forgot-div-title-topbar,#forgot-pass-div').hide();
        $('#register-div-topbar,#register-div-title-topbar,#widget_login_topbar,#forgot_pass_topbar').show();
   
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    });

    $('#widget_login_topbar').click(function (event) {
        event.preventDefault();
<<<<<<< HEAD
        $('#login-div_topbar').show();
        $('#register-div-topbar').hide();
        $('#login-div-title-topbar').show();
        $('#register-div-title-topbar').hide();
    });
    
=======
        $('#login-div_topbar,#widget_register_topbar,#login-div-title-topbar,#forgot_pass_topbar').show();
        $('#register-div-topbar,#register-div-title-topbar,#widget_login_topbar,#forgot-div-title-topbar,#forgot-pass-div').hide();
    });
    
    $('#widget_register_mobile').click(function (event) {
        event.preventDefault();
        $('#login-div_mobile').hide();
        $('#register-div-mobile').show();
        $('#login-div-title-mobile').hide();
        $('#register-div-title-mobile').show();
    });

    $('#widget_login_mobile').click(function (event) {
        event.preventDefault();
        $('#login-div_mobile').show();
        $('#register-div-mobile').hide();
        $('#login-div-title-mobile').show();
        $('#register-div-title-mobile').hide();
    });
    
    
    
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    
    ///////////////////////////////////////////////////////////////////////////////////////////  
    //////// WIDGET  login/forgot password  actions
    ////////////////////////////////////////////////////////////////////////////////////////////     
    $('#widget_register_sw').click(function (event) {
        event.preventDefault();
        $('.loginwd_sidebar #login-div').hide();
        $('.loginwd_sidebar #register-div').show();
        $('.loginwd_sidebar #login-div-title').hide();
        $('.loginwd_sidebar #register-div-title').show();
    });

    $('#widget_login_sw').click(function (event) {
        event.preventDefault();
        $('.loginwd_sidebar #register-div').hide();
        $('.loginwd_sidebar #login-div').show();
        $('.loginwd_sidebar #register-div-title').hide();
        $('.loginwd_sidebar #login-div-title').show();
    });

    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  login  ajax
    ////////////////////////////////////////////////////////////////////////////////////////////
    $('#wp-login-but').click(function () {
        wpestate_login();
    });

    $('#login_pwd, #login_user').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_login();
        }
    });

    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  WIDGET login  ajax
    ////////////////////////////////////////////////////////////////////////////////////////////

    $('#wp-login-but-wd').click(function () {
        wpestate_login_wd();
    });

    $('#login_pwd_wd, #login_user_wd').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_login_wd();
        }
    });

    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  TOPBAR  login  ajax
    ////////////////////////////////////////////////////////////////////////////////////////////

    $('#wp-login-but-topbar').click(function () {
        wpestate_login_topbar();
    });

    $('#login_pwd_topbar, #login_user_topbar').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_login_topbar();
        }
    });

<<<<<<< HEAD
=======
    $('#wp-login-but-mobile').click(function () {
        wpestate_login_mobile();
    });

    $('#login_pwd_mobile, #login_user_mobile').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_login_mobile();
        }
    });
    
>>>>>>> 64662fd89bea560852792d7203888072d7452d48

    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  Ajax update password
    //////////////////////////////////////////////////////////////////////////////////////////// 
    $('#oldpass, #newpass, #renewpass').keydown(function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            wpestate_change_pass_profile();
        }
    });

    $('#change_pass').click(function () {
        wpestate_change_pass_profile();
    });
  
    ///////////////////////////////////////////////////////////////////////////////////////////  
    ////////  update profile
    ////////////////////////////////////////////////////////////////////////////////////////////   
<<<<<<< HEAD

    $('#update_profile').click(function () {
        var  userurl,usermobile, userpinterest, userlinkedin, usertwitter, userfacebook, profile_image_url, profile_image_url_small, firstname, secondname, useremail, userphone, userskype, usertitle, description, ajaxurl, securityprofile, upload_picture;
=======
   $('#register_agent').click(function () {
        var firstname       =  $('#firstname').val();
        var secondname      =  $('#secondname').val();
        var useremail       =  $('#useremail').val();
        var userphone       =  $('#userphone').val();
        var usermobile      =  $('#usermobile').val();
        var userskype       =  $('#userskype').val();
        var usertitle       =  $('#usertitle').val();
        var description     =  $('#about_me').val();
        var userfacebook    =  $('#userfacebook').val();
        var usertwitter     =  $('#usertwitter').val();
        var userlinkedin    =  $('#userlinkedin').val();
        var userpinterest   =  $('#userpinterest').val();
        var userinstagram   =  $('#userinstagram').val();
        var userurl         =  $('#website').val();
        var agent_username          =   $('#agent_username').val();
        var agent_password          =   $('#agent_password').val();
        var agent_repassword        =   $('#agent_repassword').val();        
        var agent_category_submit   =   $('#agent_category_submit').val();
        var agent_action_submit     =   $('#agent_action_submit').val();
        var agent_city              =   $('#agent_city').val();
        var agent_county            =   $('#agent_county').val();
        
        var agent_member            =   $('#agent_member').val();
        
        var agent_area              =   $('#agent_area').val();
        var is_agent_edit           =   $('#is_agent_edit').val();
        var user_id                 =   $('#user_id').val();
        var agent_id                =   $('#agent_id').val();
        
        var ajaxurl                     =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
        var securityprofile             =   $('#security-profile').val();
        var upload_picture              =   $('#upload_picture').val();
        var profile_image_url           =   $('#profile-image').attr('data-profileurl');
        var profile_image_url_small     =   $('#profile-image').attr('data-smallprofileurl');
       

	   
	   // customparameters
		var agent_custom_label = [];
		$('.agent_custom_label').each(function(){
			agent_custom_label.push( $(this).val() );
		})
	 
		var agent_custom_value = [];
		$('.agent_custom_value').each(function(){
			agent_custom_value.push( $(this).val() );
		})
       
   
        window.scrollTo(0,0);
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            dataType: 'json',
            data: {
                'action'            :   'wpestate_ajax_register_agent',
                'agent_username'    :   agent_username,
                'agent_password'    :   agent_password,
                'agent_repassword'  :   agent_repassword,
                'firstname'         :   firstname,
                'secondname'        :   secondname,
                'useremail'         :   useremail,
                'userphone'         :   userphone,
                'usermobile'        :   usermobile,
                'userskype'         :   userskype,
                'usertitle'         :   usertitle,
                'description'       :   description,
                'upload_picture'    :   upload_picture,
                'security-profile'  :   securityprofile,
                'profile_image_url' :   profile_image_url,
                'profile_image_url_small':profile_image_url_small,
                'userfacebook'      :   userfacebook,
                'usertwitter'       :   usertwitter,
                'userlinkedin'      :   userlinkedin,
                'userpinterest'     :   userpinterest,
                'userinstagram'     :   userinstagram,
                'userurl'           :   userurl,
                'agent_category_submit'     :   agent_category_submit,
                'agent_action_submit'       :   agent_action_submit,
                'agent_city'                :   agent_city,
                'agent_county'              :   agent_county,
                'agent_area'                :   agent_area,
                'agentedit'                 :   is_agent_edit,
                'userid'                    :   user_id,
                'agentid'                   :   agent_id,
				        'agent_member' : agent_member,
				
				'agent_custom_label' 	: agent_custom_label,
				'agent_custom_value' 	: agent_custom_value
				
            },
            success: function (data) {
                $('#profile_message').empty().append('<div class="login-alert">' + data.mesaj + '<div>');
                if(data.added ){
                    setTimeout(function() {      window.open (ajaxcalls_vars.agent_list,'_self',false)  }, 1500);
                }else{
                    
                }
            },
            error: function (errorThrown) {
             
            }
        });
    });


    $('#update_profile').click(function () {
        var  firstname,secondname,userurl,usermobile, userinstagram,userpinterest, userlinkedin, usertwitter, userfacebook, profile_image_url, profile_image_url_small, firstname, secondname, useremail, userphone, userskype, usertitle, description, ajaxurl, securityprofile, upload_picture;
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        firstname       =  $('#firstname').val();
        secondname      =  $('#secondname').val();
        useremail       =  $('#useremail').val();
        userphone       =  $('#userphone').val();
        usermobile      =  $('#usermobile').val();
        userskype       =  $('#userskype').val();
        usertitle       =  $('#usertitle').val();
        description     =  $('#about_me').val();
        userfacebook    =  $('#userfacebook').val();
        usertwitter     =  $('#usertwitter').val();
        userlinkedin    =  $('#userlinkedin').val();
        userpinterest   =  $('#userpinterest').val();
<<<<<<< HEAD
        userurl         =  $('#website').val();
=======
        userinstagram   =  $('#userinstagram').val();
        userurl         =  $('#website').val();
        var agent_member    =   $('#agent_member').val();
        
        var agent_category_submit  =   $('#agent_category_submit').val();
        var agent_action_submit    =   $('#agent_action_submit').val();
        var agent_city     =   $('#agent_city').val();
        var agent_county   =   $('#agent_county').val();
        var agent_area     =   $('#agent_area').val();    
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        
        ajaxurl         =  ajaxcalls_vars.admin_url + 'admin-ajax.php';
        securityprofile =  $('#security-profile').val();
        upload_picture  =  $('#upload_picture').val();
        profile_image_url  = $('#profile-image').attr('data-profileurl');
        profile_image_url_small  = $('#profile-image').attr('data-smallprofileurl');
       
<<<<<<< HEAD

=======
       // customparameters
  		var agent_custom_label = [];
  		$('.agent_custom_label').each(function(){
  			agent_custom_label.push( $(this).val() );
  		})
  	 
  		var agent_custom_value = [];
  		$('.agent_custom_value').each(function(){
  			agent_custom_value.push( $(this).val() );
  		})
       
       
        window.scrollTo(0,0);
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'            :   'wpestate_ajax_update_profile',
                'firstname'         :   firstname,
                'secondname'        :   secondname,
                'useremail'         :   useremail,
                'userphone'         :   userphone,
                'usermobile'        :   usermobile,
                'userskype'         :   userskype,
                'usertitle'         :   usertitle,
                'description'       :   description,
                'upload_picture'    :   upload_picture,
                'security-profile'  :   securityprofile,
                'profile_image_url' :   profile_image_url,
                'profile_image_url_small':profile_image_url_small,
                'userfacebook'      :   userfacebook,
                'usertwitter'       :   usertwitter,
                'userlinkedin'      :   userlinkedin,
                'userpinterest'     :   userpinterest,
<<<<<<< HEAD
                'userurl'           :   userurl
            },
            success: function (data) {
                $('#profile_message').append('<div class="login-alert">' + data + '<div>');
=======
                'userinstagram'     :   userinstagram,
                'userurl'           :   userurl,
                'agent_category_submit'     :   agent_category_submit,
                'agent_action_submit'       :   agent_action_submit,
                'agent_city'                :   agent_city,
                'agent_county'              :   agent_county,
                'agent_area'                :   agent_area,
                'agent_member'              :   agent_member,
        
        
                'agent_custom_label' 	: agent_custom_label,
				        'agent_custom_value' 	: agent_custom_value
        
            },
            success: function (data) {
            
                $('#profile_message').append('<div class="login-alert">' + data + '<div>');
                window.scrollTo(0,0);
            },
            error: function (errorThrown) {
            }
        });
    });


    
    $('#update_profile_agency').click(function () {
        var agency_opening_hours,agency_license,agency_long,agency_lat, agency_address,agency_area,agency_county,agency_city,agency_action_submit, agency_action_submit,agency_category_submit, agency_taxes,agency_website,agency_languages,agency_name,userurl,usermobile, userinstagram,userpinterest, userlinkedin, usertwitter, userfacebook, profile_image_url, profile_image_url_small, firstname, secondname, useremail, userphone, userskype, usertitle, description, ajaxurl, securityprofile, upload_picture;
        agency_name     =  $('#agency_title').val();
        useremail       =  $('#useremail').val();
        userphone       =  $('#userphone').val();
        usermobile      =  $('#usermobile').val();
        userskype       =  $('#userskype').val();
  
        description     =  $('#about_me').val();
        userfacebook    =  $('#userfacebook').val();
        usertwitter     =  $('#usertwitter').val();
        userlinkedin    =  $('#userlinkedin').val();
        userpinterest   =  $('#userpinterest').val();
        userinstagram   =  $('#userinstagram').val();
      
        
        agency_languages=  $('#agency_languages').val();
        agency_website  =  $('#agency_website').val();
        agency_taxes    =  $('#agency_taxes').val();
        agency_license  =  $('#agency_license').val();
     
        
        agency_category_submit  =   $('#agency_category_submit').val();
        agency_action_submit    =   $('#agency_action_submit').val();
        agency_city     =   $('#agency_city').val();
        agency_county   =   $('#agency_county').val();
        agency_area     =   $('#agency_area').val();
        agency_address  =   $('#agency_address').val();
        agency_lat      =   $('#agency_lat').val();
        agency_long     =   $('#agency_long').val();
        agency_opening_hours  = $('#agency_opening_hours ').val();
        securityprofile             = $('#security-profile').val();
        upload_picture              = $('#upload_picture').val();
        profile_image_url           = $('#profile-image').attr('data-profileurl');
        profile_image_url_small     = $('#profile-image').attr('data-smallprofileurl');
      
        
        ajaxurl         =  ajaxcalls_vars.admin_url + 'admin-ajax.php';
      
        
        window.scrollTo(0,0);
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'            :   'wpestate_ajax_update_profile_agency',
                'agency_name'         :   agency_name,
                'useremail'         :   useremail,
                'userphone'         :   userphone,
                'usermobile'        :   usermobile,
                'userskype'         :   userskype,
                'usertitle'         :   usertitle,
                'description'       :   description,
                'upload_picture'    :   upload_picture,
                'security-profile'  :   securityprofile,
                'profile_image_url' :   profile_image_url,
                'profile_image_url_small':profile_image_url_small,
                'userfacebook'      :   userfacebook,
                'usertwitter'       :   usertwitter,
                'userlinkedin'      :   userlinkedin,
                'userpinterest'     :   userpinterest,
                'userinstagram'     :   userinstagram,
                'userurl'           :   userurl,
                'agency_languages'  :   agency_languages,
                'agency_website'    :   agency_website,
                'agency_taxes'      :   agency_taxes,
                'agency_license'    :   agency_license,
                'agency_category_submit':agency_category_submit,
                'agency_action_submit':agency_action_submit,
                'agency_city'       :   agency_city,
                'agency_county'     :   agency_county,
                'agency_area'       :   agency_area,
                'agency_address'    :   agency_address,
                'agency_lat'        :   agency_lat,
                'agency_opening_hours' : agency_opening_hours,
                'agency_long'       :   agency_long
            },
            success: function (data) {
                $('#profile_message').append('<div class="login-alert">' + data + '<div>');
                window.scrollTo(0,0);
            },
            error: function (errorThrown) {
            }
        });
    });
    
    
    
//    update developer profile 
       $('#update_profile_developer').click(function () {
        var developer_license ,developer_long,developer_lat, developer_address,developer_area,developer_county,developer_city,developer_action_submit, developer_action_submit,developer_category_submit, developer_taxes,developer_website,developer_languages,developer_name,userurl,usermobile, userinstagram,userpinterest, userlinkedin, usertwitter, userfacebook, profile_image_url, profile_image_url_small, firstname, secondname, useremail, userphone, userskype, usertitle, description, ajaxurl, securityprofile, upload_picture;
        developer_name  =  $('#developer_title').val();
        useremail       =  $('#useremail').val();
        userphone       =  $('#userphone').val();
        usermobile      =  $('#usermobile').val();
        userskype       =  $('#userskype').val();
  
        description     =  $('#about_me').val();
        userfacebook    =  $('#userfacebook').val();
        usertwitter     =  $('#usertwitter').val();
        userlinkedin    =  $('#userlinkedin').val();
        userpinterest   =  $('#userpinterest').val();
        userinstagram   =  $('#userinstagram').val();
      
        
        developer_languages =  $('#developer_languages').val();
        developer_website   =  $('#developer_website').val();
        developer_taxes     =  $('#developer_taxes').val();
        developer_license   =  $('#developer_license').val();
     
        
        developer_category_submit  =   $('#developer_category_submit').val();
        developer_action_submit    =   $('#developer_action_submit').val();
        developer_city             =   $('#developer_city').val();
        developer_county           =   $('#developer_county').val();
        developer_area             =   $('#developer_area').val();
        developer_address          =   $('#developer_address').val();
        developer_lat              =   $('#developer_lat').val();
        developer_long             =   $('#developer_long').val();
        securityprofile             = $('#security-profile').val();
        upload_picture              = $('#upload_picture').val();
        profile_image_url           = $('#profile-image').attr('data-profileurl');
        profile_image_url_small     = $('#profile-image').attr('data-smallprofileurl');
      
        
        ajaxurl         =  ajaxcalls_vars.admin_url + 'admin-ajax.php';
        
        window.scrollTo(0,0);
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'            :   'wpestate_ajax_update_profile_developer',
                'developer_name'    :   developer_name,
                'useremail'         :   useremail,
                'userphone'         :   userphone,
                'usermobile'        :   usermobile,
                'userskype'         :   userskype,
                'usertitle'         :   usertitle,
                'description'       :   description,
                'upload_picture'    :   upload_picture,
                'security-profile'  :   securityprofile,
                'profile_image_url' :   profile_image_url,
                'profile_image_url_small':profile_image_url_small,
                'userfacebook'      :   userfacebook,
                'usertwitter'       :   usertwitter,
                'userlinkedin'      :   userlinkedin,
                'userpinterest'     :   userpinterest,
                'userinstagram'     :   userinstagram,
                'userurl'           :   userurl,
                'developer_languages'  :   developer_languages,
                'developer_website'   :   developer_website,
                'developer_taxes'      :   developer_taxes,
                'developer_license'    :   developer_license,
                'developer_category_submit': developer_category_submit,
                'developer_action_submit'  : developer_action_submit,
                'developer_city'       :   developer_city,
                'developer_county'     :   developer_county,
                'developer_area'       :   developer_area,
                'developer_address'    :   developer_address,
                'developer_lat'        :   developer_lat,
                'developer_long'       :   developer_long
            },
            success: function (data) {
                $('#profile_message').append('<div class="login-alert">' + data + '<div>');
                window.scrollTo(0,0);
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
            },
            error: function (errorThrown) {
            }
        });
    });
<<<<<<< HEAD

=======
    
    //delete profile

    $('#delete_profile').click(function () {
        var ajaxurl;
        ajaxurl         =  ajaxcalls_vars.admin_url + 'admin-ajax.php';

        var result = confirm(ajaxcalls_vars.delete_account);
        if (result) {
            //Logic to delete the item

            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'action'       :   'wpestate_delete_profile'
                },
                success: function (data) {
                   window.location = '/';
                },
                error: function (errorThrown) {

                }
            });
        }
    });
    
//end delete profile 
    
    
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    function progressHandlingFunction(e) {
        if (e.lengthComputable) {
            $('#profile_message').attr({value: e.loaded, max: e.total});
        }
    }

}); // end ready jquery
//End ready ********************************************************************