
// front property submit page-template-front_property_submit
jQuery(document).ready(function ($){
	
        $('#front_end_submit_register').click(function(){
            "use strict";
            var post_id, securitypass, ajaxurl;
            securitypass    =  jQuery('#security-pass').val();
            ajaxurl         =  ajaxcalls_vars.admin_url + 'admin-ajax.php';

            if (parseInt(ajaxcalls_vars.userid, 10) === 0 ) {



                if (!Modernizr.mq('only all and (max-width: 768px)')) {
                    jQuery('#modal_login_wrapper').show(); 
                    jQuery('#loginpop').val('2');
                }else{
                    jQuery('.mobile-trigger-user').trigger('click');
                }


            } 
              jQuery('#loginpop').val('2');
        });
        
        
	// inner navigation processing
	$('.inner_navigation').click(function(e){
		e.preventDefault();
		var current_step = parseInt( $('.page-template-front_property_submit #current_step').val() );	
		$('.page-template-front_property_submit .step_'+current_step).hide();
		
		var id = $(this).attr('data-id');
	 
		$('.page-template-front_property_submit .step_'+id).fadeIn();
		$('.page-template-front_property_submit .inner_navigation').removeClass('active');
		$(this).addClass('active');
		$('.page-template-front_property_submit #current_step').val( id );
		
		if( id < 7 ){
			$('#front_submit_prev_step,#front_submit_prev_step_top').fadeIn();
			$('#front_submit_next_step,#front_submit_next_step_top').fadeIn();
			google.maps.event.trigger(map, 'resize');
			$('.page-template-front_property_submit #submit_property').hide();
		}
		if( id == 7 ){
			$('#front_submit_next_step,#front_submit_next_step_top').fadeOut();
			$('.page-template-front_property_submit #submit_property').fadeIn();
                        if (parseInt(ajaxcalls_vars.userid, 10) === 0 ) {
                            jQuery("#modal_login_wrapper").show(); 
                        }
		}
		if( id == 1 ){
			$('#front_submit_prev_step,#front_submit_prev_step_top').fadeOut();
			$('#front_submit_next_step,#front_submit_next_step_top').fadeIn();
			$('.page-template-front_property_submit #submit_property').hide();
		}
	})
	
	// process next step action
	$('#front_submit_next_step,#front_submit_next_step_top').click(function(){
		var current_step = parseInt( $('.page-template-front_property_submit #current_step').val() );		
		if( current_step < 7 ){
			$('.page-template-front_property_submit .step_'+current_step).hide();
			current_step++;
			
			// innner navigaton
			$('.page-template-front_property_submit .inner_navigation').removeClass('active');
			$('.page-template-front_property_submit .navigation_'+current_step).addClass('active');
			
			$('.page-template-front_property_submit #current_step').val( current_step );
			$('.page-template-front_property_submit .step_'+current_step).fadeIn();
			$('#front_submit_prev_step,#front_submit_prev_step_top').fadeIn();
			google.maps.event.trigger(map, 'resize');
		}
		if( current_step == 7 ){
			$('#front_submit_next_step,#front_submit_next_step_top').fadeOut();
			$('.page-template-front_property_submit #submit_property').fadeIn();
                         if (parseInt(ajaxcalls_vars.userid, 10) === 0 ) {
                            jQuery("#modal_login_wrapper").show(); 
                        }
            }
	})
	
	// process prev step action
	$('#front_submit_prev_step,#front_submit_prev_step_top').click(function(){
		var current_step = parseInt( $('.page-template-front_property_submit #current_step').val() );		
		if( current_step <= 7 ){
			$('.page-template-front_property_submit .step_'+current_step).hide();
			current_step--;
			
			// innner navigaton
			$('.page-template-front_property_submit .inner_navigation').removeClass('active');
			$('.page-template-front_property_submit .navigation_'+current_step).addClass('active');
			
			$('.page-template-front_property_submit #current_step').val( current_step );
			$('.page-template-front_property_submit .step_'+current_step).fadeIn();
			$('#front_submit_next_step,#front_submit_next_step_top').fadeIn();
			google.maps.event.trigger(map, 'resize');
		}
		if( current_step == 1 ){
			$('#front_submit_prev_step,#front_submit_prev_step_top').fadeOut();
		}
	})
	
	// login link / register link swap fn
	$('#register_link').click(function(e){
		e.preventDefault();
		$('.page-template-front_property_submit #register_link').hide();
		$('.page-template-front_property_submit #login_link').show();
		
		$('.page-template-front_property_submit .register_row').show();
		$('.page-template-front_property_submit .login_row').hide();
		$('#submit_type').val('register');
	})
	$('#login_link').click(function(e){
		e.preventDefault();
		$('.page-template-front_property_submit #register_link').show();
		$('.page-template-front_property_submit #login_link').hide();
		
		$('.page-template-front_property_submit .register_row').hide();
		$('.page-template-front_property_submit .login_row').show();
		$('#submit_type').val('login');
	})
	
//	$('#submit_property').click(function(e){
//		
//		var error_submit = 0;
//		/*
//		if( !validateEmail( $('#front_user_email').val() ) || $('#front_user_email').val() == '' ){
//			$('#status_container').html( obj.message );
//		}
//		*/
//	 
//		// check obligatory fields
//		var obj = jQuery.parseJSON( $('#mandatory_fields').val() );
//		$('#status_container').html('');
//		$.each( obj, function(index, value){
//			console.log( index );
//			console.log( value );
//			if( $('[name='+index+']').val() == '' ){
//				$('#status_container').append('<div class="error">'+ajaxcalls_vars.error_field+' '+value+'</div>');
//				error_submit = 1;
//			}
//			
//		})
//		
//		// check title
//		if( $('#title').val() == '' || !$('#title').val() ){
//			$('#status_container').append('<div class="error">'+ajaxcalls_vars.notitle+'</div>');
//			error_submit = 1;
//		}
//		
//		// check images
//		if( $('#attachid').val() == '' || !$('#attachid').val() ){
//			$('#status_container').append('<div class="error">'+ajaxcalls_vars.noimages+'</div>');
//			error_submit = 1;
//		}
//		
//		
//		if( error_submit == 1 ){
//			return true;
//		}
//	 
//		if( $('.page-template-front_property_submit #title').val() == '' ){			
//			$('#status_container').html( ajaxcalls_vars.no_title );
//			return true;
//		}
//		
//		ajaxurl     =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
//        jQuery.ajax({
//            type: 'POST',
//            url: ajaxurl,
//            data: {
//                'action'    :   'wpestate_front_property_submit',
//                'action_type'      :   $('#submit_type').val(),
//                'front_user_login'       :   $('#front_user_login').val(),
//                'front_user_name'       :   $('#front_user_name').val(),
//                'front_user_pass'       :   $('#front_user_pass').val(),
//                'front_user_email'       :   $('#front_user_email').val(),
//           
//            },
//			beforeSend: function(msg){
//						jQuery('.page-template-front_property_submit .loadersmall' ).removeClass('hidden');
//						jQuery('.page-template-front_property_submit .loadersmall' ).attr('disabled', 'disabled');
//			},
//            success: function (data) {  
//				console.log( data );
//			 
//				jQuery('.page-template-front_property_submit .loadersmall' ).addClass('hidden');
//				var obj = jQuery.parseJSON( data );
//				if( obj.result == 'error' ){
//					$('#status_container').html( obj.message );
//				}
//				if( obj.result == 'success' ){
//					$('#front_submit_form').submit();
//				}
//			},
//            error: function (errorThrown) {}
//        });//end ajax  
//	})
	   
	
})
function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}
// front property submit page-template-front_property_submit END
