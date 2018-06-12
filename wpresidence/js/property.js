jQuery(document).ready(function ($) {
    "use strict";
    enable_star_action();

    
    $('#schedule_meeting').click(function(){
        $('.schedule_wrapper').slideToggle();
    });
    
    jQuery("#schedule_day").datepicker({
            dateFormat : "yy-mm-dd",
    }).datepicker('widget').wrap('<div class="ll-skin-melon"/>');




    
    
    jQuery('#edit_review').click(function () {
      
        var  listing_id  =   jQuery(this).attr('data-listing_id');
        var  title       =   jQuery(this).parent().find('#wpestate_review_title').val();
        var  content     =   jQuery(this).parent().find('#wpestare_review_content').val();
        var  stars       =   jQuery(this).parent().find('.starselected_click').length;
        var  ajaxurl     =   control_vars.admin_url + 'admin-ajax.php';
        var  acesta      =   jQuery(this);
        var  parent      =   jQuery(this).parent().parent();
        var  coment      =  jQuery(this).attr('data-coment_id');
        
        
        if( stars>0 && content!=''){
            jQuery('.rating').text(control_vars.posting);
        }
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'            :   'wpestate_edit_review',
                'listing_id'        :   listing_id,
                'title'             :   title,
                'stars'             :   stars,
                'content'           :   content,
                'coment'            :   coment
            },
            success: function (data) {
                jQuery('.rating').text(control_vars.review_edited);
                
            },
            error: function (errorThrown) {
            }
        });
    });
    
    jQuery('#submit_review').click(function () {
      
        var  listing_id  =   jQuery(this).attr('data-listing_id');
        var  title       =   jQuery(this).parent().find('#wpestate_review_title').val();
        var  content     =   jQuery(this).parent().find('#wpestare_review_content').val();
        var  stars       =   jQuery(this).parent().find('.starselected_click').length;
        var  ajaxurl     =   control_vars.admin_url + 'admin-ajax.php';
        var  acesta      =   jQuery(this);
        var  parent      =   jQuery(this).parent().parent();
        
        
        if( stars>0 && content!=''){
            jQuery('.rating').text(control_vars.posting);
        }

        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'            :   'wpestate_post_review',
                'listing_id'        :   listing_id,
                'title'             :   title,
                'stars'             :   stars,
                'content'           :   content
            },
            success: function (data) {

                jQuery('.rating').text(control_vars.review_posted);
                jQuery('#wpestate_review_title').val('');
                jQuery('#wpestare_review_content').val('');
            },
            error: function (errorThrown) {
            }
        });
    });
   
});

function enable_star_action() {
    jQuery('.empty_star').hover(
        function () {
            var loop, index;
            index = jQuery('.empty_star').index(this);
            jQuery('.empty_star').each(function () {
                loop = jQuery('.empty_star').index(this);
                if (loop <= index) {
                    jQuery(this).addClass('starselected');
                } else {
                    jQuery(this).removeClass('starselected');
                }
            });
        },
        function () {
        }
    );
    
	 
    jQuery('.rating').mouseleave(function(){
        jQuery('.empty_star').removeClass('starselected');
    });
	 
    
    jQuery('.empty_star').click(function(){
        jQuery('.empty_star').removeClass('starselected_click');
        var index   =   jQuery('.empty_star').index(this);
        var loop    =   '';
        jQuery('.empty_star').each(function () {
            loop = jQuery('.empty_star').index(this);
            if (loop <= index) {
                jQuery(this).addClass('starselected_click');
            } 
        });
            
    });
    
}   
    

    
function wpestate_show_stat_accordion(){
    if(  !document.getElementById('myChart') ){
        return;
    }
  
    var ctx = jQuery("#myChart").get(0).getContext("2d");
    var myNewChart  =    new Chart(ctx);
    var labels      =   '';
    var traffic_data='  ';
   
    labels          =   jQuery.parseJSON ( wpestate_property_vars.singular_label);
    traffic_data    =   jQuery.parseJSON ( wpestate_property_vars.singular_values);
   
    var data = {
    labels:labels ,
    datasets: [
         {
            label: "My First dataset",
            fillColor: "rgba(220,220,220,0.5)",
            strokeColor: "rgba(220,220,220,0.8)",
            highlightFill: "rgba(220,220,220,0.75)",
            highlightStroke: "rgba(220,220,220,1)",
            data: traffic_data
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