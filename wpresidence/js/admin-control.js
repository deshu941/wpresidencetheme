/*global $, jQuery, document, window */

jQuery(document).ready(function ($) {
<<<<<<< HEAD
    "use strict";
    
     ///////////////////////////////////////////////////////////////////////////////
    /// activate purchase lsitings
    ///////////////////////////////////////////////////////////////////////////////
=======
  
    
    $('#adv6_taxonomy').change(function(){
        var select_tax  =   jQuery('#adv6_taxonomy').val();
        var ajaxurl     =   admin_control_vars.admin_url + 'admin-ajax.php';

      

        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
          
            data: {
                'action'            :   'wpestate_load_adv6_tax',
                'select_tax'        :   select_tax
            },
            success: function (data) {  
                jQuery('#adv6_taxonomy_terms').html('').append(data).show();
            },
            error: function (errorThrown) {
                
            }
        });//end ajax     
        
    });
   
     ///////////////////////////////////////////////////////////////////////////////
    /// activate purchase lsitings
    ///////////////////////////////////////////////////////////////////////////////
    $('#save_prop_design').click(function(){
        var acesta,content,sidebar_right,sidebar_left,content_to_parse,use_unit;
        
        use_unit =0;
        if( $('#use_unit_design').is(":checked") ){
            use_unit = 1;
        }
        content = $('#property_page_content .property_page_content_wrapper').html();
       
      
      
        acesta=$(this);
        acesta.empty().text('saving....');
        jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
            data: {
                'action'        :   'wpestate_save_property_page_design',
                'content'       :   content,
                'use_unit'      :   use_unit,
            },
            success: function (data) {
                acesta.empty().text('saved....');
            },
            error: function (errorThrown) {
               
            }
        });//end ajax  
        
        
    })
    
    
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    
    $('#activate_pack_listing').click(function(){
        var item_id, invoice_id,ajaxurl,type;
        
        item_id     = $(this).attr('data-item');
        invoice_id  = $(this).attr('data-invoice');
        type        = $(this).attr('data-type');
        ajaxurl     =   admin_control_vars.ajaxurl;
    
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
        data: {
            'action'        :   'wpestate_activate_purchase_listing',
            'item_id'       :   item_id,
            'invoice_id'    :   invoice_id,
            'type'          :   type
           
        },
        success: function (data) {  
            jQuery("#activate_pack_listing").remove();
            jQuery("#invnotpaid").remove(); 
          
           
        },
        error: function (errorThrown) {}
    });//end ajax  
        
    });
    
     ///////////////////////////////////////////////////////////////////////////////
    /// activate purchase
    ///////////////////////////////////////////////////////////////////////////////
    
     $('#activate_pack').click(function(){
        var item_id, invoice_id,ajaxurl;
        
        item_id     = $(this).attr('data-item');
        invoice_id  = $(this).attr('data-invoice');
        ajaxurl     =   admin_control_vars.ajaxurl;
    
    
      
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
        data: {
            'action'        :   'wpestate_activate_purchase',
            'item_id'       :   item_id,
            'invoice_id'    :   invoice_id
           
        },
        success: function (data) {   
            jQuery("#activate_pack").remove();
            jQuery("#invnotpaid").remove(); 
           
        },
        error: function (errorThrown) {}
    });//end ajax  
        
    });
<<<<<<< HEAD
    
=======

    $('#spash_header_type').change(function(){
        var value = $(this).val();
        $('.splash_image_info,.splash_slider_info,.splash_video_info,#splash_slider_images.splash_slider_info').hide();
       
        if(value=='image'){
            $('.splash_image_info').show();
        }else  if(value=='video'){
            $('.splash_video_info').show();
        }else  if(value=='image slider'){
            $('.splash_slider_info').show();
            $('#splash_slider_images.splash_slider_info').css('display','inline-block');
        }
        
    });
    
    $('#spash_header_type').trigger('change');
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    
    
    
    
<<<<<<< HEAD
    
    
    
    
    ///////////////////////////////////////////////////////////////////////////////
    /// upload custom image on page - jslint checked
    ///////////////////////////////////////////////////////////////////////////////
    var formfield, imgurl;
=======
    $('#splash_slider_gallery_button').on( 'click', function(event) {
        event.stopPropagation();
        event.preventDefault();
        var  metaBox = $('#splash_slider_images');
        var imgContainer = metaBox.find( '.splash_thumb_wrapepr');
                    
        var imgIdInput = metaBox.find( '#splash_slider_gallery').val();
      
                    
                 
        // Accepts an optional object hash to override default values.
        var frame = new wp.media.view.MediaFrame.Select({
                // Modal title
                title: 'Select Images',

                // Enable/disable multiple select
                multiple: true,

                // Library WordPress query arguments.
                library: {
                        order: 'DESC',

                        // [ 'name', 'author', 'date', 'title', 'modified', 'uploadedTo',
                        // 'id', 'post__in', 'menuOrder' ]
                        orderby: 'id',

                        // mime type. e.g. 'image', 'image/jpeg'
                        type: 'image',



                        // Attached to a specific post (ID).
                        //uploadedTo: post_id
                },

                button: {
                        text: 'Set Image'
                }
        });

                // Fires after the frame markup has been built, but not appended to the DOM.
                // @see wp.media.view.Modal.attach()
                frame.on( 'ready', function() { } );

                // Fires when the frame's $el is appended to its DOM container.
                // @see media.view.Modal.attach()
                frame.on( 'attach', function() {} );

                // Fires when the modal opens (becomes visible).
                // @see media.view.Modal.open()
                frame.on( 'open', function() {} );

                // Fires when the modal closes via the escape key.
                // @see media.view.Modal.close()
                frame.on( 'escape', function() {} );

                // Fires when the modal closes.
                // @see media.view.Modal.close()
                frame.on( 'close', function() {} );

                // Fires when a user has selected attachment(s) and clicked the select button.
                // @see media.view.MediaFrame.Post.mainInsertToolbar()
                frame.on( 'select', function(arguments) {
                        var attachment = frame.state().get('selection').toJSON();


                        var arrayLength = attachment.length;
                        for (var i = 0; i < arrayLength; i++) {
                            imgIdInput = metaBox.find( '#splash_slider_gallery' ).val();
                            if(imgIdInput!==''){
                                imgIdInput=imgIdInput+",";
                            }
                            
                            $( '#splash_slider_gallery' ).val(imgIdInput+attachment[i].id+",")
                            
                            imgContainer.append( '<div class="uploaded_thumb" data-imageid="'+attachment[i].id+'">\n\
                                <img src="'+attachment[i].sizes.thumbnail.url+'" alt="" style="max-width:100%;"/>\n\
                               <a class="splash_attach_delete"><i class="fa fa-trash-o" aria-hidden="true"></i></span></div>' );

                        }

                        //$( '#image_to_attach' ).val(imgIdInput+attachment.id+",")
                        //imgContainer.append( '<img src="'+attachment.sizes.thumbnail.url+'" alt="" style="max-width:100%;"/>' );

                        // Send the attachment id to our hidden input
                       // imgIdInput.val( attachment.id );



                } );

                // Fires when a state activates.
                frame.on( 'activate', function() {} );

                // Fires when a mode is deactivated on a region.
                frame.on( '{region}:deactivate', function() {} );
                // and a more specific event including the mode.
                frame.on( '{region}:deactivate:{mode}', function() {} );

                // Fires when a region is ready for its view to be created.
                frame.on( '{region}:create', function() {} );
                // and a more specific event including the mode.
                frame.on( '{region}:create:{mode}', function() {} );

                // Fires when a region is ready for its view to be rendered.
                frame.on( '{region}:render', function() {} );
                // and a more specific event including the mode.
                frame.on( '{region}:render:{mode}', function() {} );

                // Fires when a new mode is activated (after it has been rendered) on a region.
                frame.on( '{region}:activate', function() {} );
                // and a more specific event including the mode.
                frame.on( '{region}:activate:{mode}', function() {} );

                // Get an object representing the current state.
        frame.state();


                // Get an object representing the previous state.
        frame.lastState();

                // Open the modal.
                frame.open();  
        });
    
    
     $('.splash_attach_delete').click(function(){
        var curent;
        var img_remove= jQuery(this).parent().attr('data-imageid');
                jQuery(this).parent().remove();
                
                jQuery('#splash_slider_images .uploaded_thumb').each(function(){
                    remove  =   jQuery(this).attr('data-imageid');
                    curent  =   curent+','+remove; 
         
                });
                jQuery('#splash_slider_gallery').val(curent); 
  
                jQuery.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: {
                        'action'            :   'wpestate_delete_file',
                        'attach_id'     :   img_remove,

                    },
                    success: function (data) {     
                    

                    },
                    error: function (errorThrown) { 
                     
                    }
                });//end ajax   
  
            });
    ///////////////////////////////////////////////////////////////////////////////
    /// upload custom image on page - jslint checked
    ///////////////////////////////////////////////////////////////////////////////
    
    
   
    
    var formfield, imgurl;
    $('#splash_video_mp4_button').click(function () {
     
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.send_to_editor = function (html) {
            var pathArray = html.match(/<media>(.*)<\/media>/);
            var mediaUrl = pathArray != null && typeof pathArray[1] != 'undefined' ? pathArray[1] : '';
            jQuery('#splash_video_mp4').val(mediaUrl);
            tb_remove();
        };
        return false;
    });
    
      
    $('#splash_video_webm_button').click(function () {
       
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.send_to_editor = function (html) {
            var pathArray = html.match(/<media>(.*)<\/media>/);
            var mediaUrl = pathArray != null && typeof pathArray[1] != 'undefined' ? pathArray[1] : '';
            jQuery('#splash_video_webm').val(mediaUrl);
            tb_remove();
        };
        return false;
    });
    
      
    $('#splash_video_ogv_button').click(function () {
    
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.send_to_editor = function (html) {
            var pathArray = html.match(/<media>(.*)<\/media>/);
            var mediaUrl = pathArray != null && typeof pathArray[1] != 'undefined' ? pathArray[1] : '';
            jQuery('#splash_video_ogv').val(mediaUrl);
            tb_remove();
        };
        return false;
    });



    $('#splash_video_cover_img_button').click(function () {
     
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.send_to_editor = function (html) {
            imgurl = $('img', html).attr('src');
            $('#splash_video_cover_img').val(imgurl);
            tb_remove();
        };
        return false;
    });
    
    

    $('#splash_image_button').click(function () {
        formfield = $('#page_custom_image').attr('name');
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.send_to_editor = function (html) {
            imgurl = $('img', html).attr('src');
            $('#splash_image').val(imgurl);
            tb_remove();
        };
        return false;
    });
    
     $('#wp_estate_splash_overlay_image_button').click(function () {
        formfield = $('#page_custom_image').attr('name');
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.send_to_editor = function (html) {
            imgurl = $('img', html).attr('src');
            $('#wp_estate_splash_overlay_image').val(imgurl);
            tb_remove();
        };
        return false;
    });
    
    
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    $('#page_custom_image_button').click(function () {
        formfield = $('#page_custom_image').attr('name');
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.send_to_editor = function (html) {
            imgurl = $('img', html).attr('src');
            $('#page_custom_image').val(imgurl);
            tb_remove();
        };
        return false;
    });
<<<<<<< HEAD
=======
    $('#page_custom_video_cover_image_button').click(function () {
        formfield = $('#page_custom_image').attr('name');
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.send_to_editor = function (html) {
            imgurl = $('img', html).attr('src');
            $('#page_custom_video_cover_image').val(imgurl);
            tb_remove();
        };
        return false;
    });
    
    
    
    $('#page_custom_video_button').click(function () {
        formfield = $('#page_custom_video').attr('name');
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.send_to_editor = function (html) {
            var pathArray = html.match(/<media>(.*)<\/media>/);
            var mediaUrl = pathArray != null && typeof pathArray[1] != 'undefined' ? pathArray[1] : '';
          
            if(mediaUrl===''){
               mediaUrl = jQuery(html).attr("href");
            }
            jQuery('#page_custom_video').val(mediaUrl);
            tb_remove();
        };
        return false;
    });
     $('#page_custom_video_webbm_button').click(function () {
     
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.send_to_editor = function (html) {
            var pathArray = html.match(/<media>(.*)<\/media>/);
            var mediaUrl = pathArray != null && typeof pathArray[1] != 'undefined' ? pathArray[1] : '';
            jQuery('#page_custom_video_webbm').val(mediaUrl);
            tb_remove();
        };
        return false;
    });
     $('#page_custom_video_ogv_button').click(function () {
       
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.send_to_editor = function (html) {
            var pathArray = html.match(/<media>(.*)<\/media>/);
            var mediaUrl = pathArray != null && typeof pathArray[1] != 'undefined' ? pathArray[1] : '';
            jQuery('#page_custom_video_ogv').val(mediaUrl);
            tb_remove();
        };
        return false;
    });
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    
    $('.deleter_floor').click(function(){
       $(this).parent().remove();
        
    });
   
     jQuery(".floorbuttons").click(function () {
                        var parent = jQuery(this).parent();
                        formfield  = parent.find("#plan_image").attr("name");
                        tb_show("", "media-upload.php?type=image&amp;TB_iframe=true");
                        window.send_to_editor = function (html) {

                            imgurl = jQuery("img", html).attr("src");
                            var theid = jQuery("img", html).attr("class");
                          
                            var thenum = theid.match(/\d+$/)[0];
                            
                            parent.find("#plan_image").val(imgurl);
                            parent.find("#plan_image_attach").val(thenum);
                            tb_remove();
                        };
                        return false;
                    });
    
    $('#add_new_plan').click(function () {
        var to_insert;
      
        to_insert='<div class="plan_row"><p class="meta-options floor_p">\n\
                <label for="plan_title">'+admin_control_vars.plan_title+'</label><br />\n\
                <input id="plan_title" type="text" size="36" name="plan_title[]" value="" />\n\
            </p>\n\
            \n\
            <p class="meta-options floor_p"> \n\
                <label for="plan_description">'+admin_control_vars.plan_desc+'</label><br /> \n\
                <textarea class="plan_description" type="text" size="36" name="plan_description[]" ></textarea> \n\
            </p>\n\
<<<<<<< HEAD
            <p class="meta-options floor_p"> \n\
                <label for="plan_image">'+admin_control_vars.plan_image+'</label><br /> \n\
                <input id="plan_image" type="text" size="36" name="plan_image[]" value="" /> \n\
                <input id="plan_image_button" type="button"   size="40" class="upload_button button floorbuttons" value="Upload Image" /> \n\
                <input type="hidden" id="plan_image_attach" name="plan_image_attach[]" value="">\n\
            </p> \n\
=======
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
             \n\
            <p class="meta-options floor_p"> \n\
                <label for="plan_size">'+admin_control_vars.plan_size+'</label><br /> \n\
                <input id="plan_size" type="text" size="36" name="plan_size[]" value="" /> \n\
            </p> \n\
            \n\
            <p class="meta-options floor_p"> \n\
                <label for="plan_rooms">'+admin_control_vars.plan_rooms+'</label><br /> \n\
                <input id="plan_rooms" type="text" size="36" name="plan_rooms[]" value="" /> \n\
            </p> \n\
            <p class="meta-options floor_p"> \n\
                <label for="plan_bath">'+admin_control_vars.plan_bathrooms+'</label><br /> \n\
                <input id="plan_bath" type="text" size="36" name="plan_bath[]" value="" /> \n\
            </p> \n\
            <p class="meta-options floor_p"> \n\
                <label for="plan_price">'+admin_control_vars.plan_price+'</label><br /> \n\
                <input id="plan_price" type="text" size="36" name="plan_price[]" value="" /> \n\
            </p> \n\
<<<<<<< HEAD
=======
            \n\<p class="meta-options floor_p image_plan"> \n\
                <label for="plan_image">'+admin_control_vars.plan_image+'</label><br /> \n\
                <input id="plan_image" type="text" size="36" name="plan_image[]" value="" /> \n\
                <input id="plan_image_button" type="button"   size="40" class="upload_button button floorbuttons" value="Upload Image" /> \n\
                <input type="hidden" id="plan_image_attach" name="plan_image_attach[]" value="">\n\
            </p> \n\
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    </div>';
        
        $('#plan_wrapper').append(to_insert);
        
        $('.floorbuttons').unbind('click');
        
        
        
        $('.floorbuttons').click(function () {
            var parent = $(this).parent();
            formfield  = parent.find('#plan_image').attr('name');
            tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
            window.send_to_editor = function (html) {
                
               imgurl = $('img', html).attr('src');
               var theid = $('img', html).attr('class');
               var thenum = theid.match(/\d+$/)[0];
       
                parent.find('#plan_image').val(imgurl);
                parent.find('#plan_image_attach').val(thenum);
                tb_remove();
            };
            return false;
        });
        
        //alert('plan'); 
    });
<<<<<<< HEAD
=======
	
	
	// agent custom parameters processing

	$('body').on('click', '.add_custom_parameter', function(){
		var cloned = $('.cliche_row').clone();
		cloned.removeClass('cliche_row');
		
		
		$('input', cloned).val();
		$('.add_custom_data_cont').append( cloned );
	})	
	$('body').on('click', '.remove_parameter_button', function(){
		var pnt = $(this).parents( '.single_parameter_row' );
		pnt.fadeOut(500, function(){
			pnt.replaceWith('');
		})
		
	})

	// agent custom parameters processing END
>>>>>>> 64662fd89bea560852792d7203888072d7452d48
    
});
