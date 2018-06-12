jQuery(document).ready(function ($) {
    
    
    $('.mess_send_reply_button').click(function () {
        var messid, ajaxurl, acesta, parent, title, content, container, mesage_container;
        ajaxurl    =   control_vars.admin_url + 'admin-ajax.php';
        parent     =   $(this).parent().parent();
        mesage_container = parent.find('.mess_content');
        container  =   $(this).parent();
        messid     =   parent.attr('data-messid');
        acesta     =   $(this);
        title      =   parent.find('.subject_reply').val();
        content    =   parent.find('.message_reply_content').val();
        parent.find('.mess_unread').remove();
        acesta.text(dashboard_vars.sending);
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'            :   'wpestate_message_reply',
                'messid'            :   messid,
                'title'             :   title,
                'content'           :   content
            },
            success: function (data) {
                mesage_container.hide();
                container.hide();
            },
            error: function (errorThrown) {
           
            }
        });
    });
    
    
    $('.message_header').click(function () {
        var messid, ajaxurl, acesta, parent;
        ajaxurl =   control_vars.admin_url + 'admin-ajax.php';
        parent  =   $(this).parent();
        messid  =   parent.attr('data-messid');
        acesta  =   $(this);
        $('.mess_content, .mess_reply_form').hide();
        $(this).parent().find('.mess_content').show();
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'            :   'wpestate_booking_mark_as_read',
                'messid'            :   messid
            },
            success: function (data) {
                parent.find('.mess_unread').remove();
            },
            error: function (errorThrown) {
            }
        });
    });
    
    
     $('.mess_reply').click(function (event) {
        var messid, ajaxurl, acesta, parent;
        event.stopPropagation();
        ajaxurl =   control_vars.admin_url + 'admin-ajax.php';
        parent  =   $(this).parent().parent().parent();
        messid  =   parent.attr('data-messid');
        acesta  =   $(this);
        $('.mess_content, .mess_reply_form').hide();
        parent.find('.mess_content').show();
        parent.find('.mess_reply_form').show();

        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'            :   'wpestate_booking_mark_as_read',
                'messid'            :   messid
            },
            success: function (data) {
                parent.find('.mess_unread').remove();
            },
            error: function (errorThrown) {
            }
        });
    });
    
    
    $('.mess_send_reply_button2').click(function (event) {
        var messid, ajaxurl, acesta, parent;
        event.stopPropagation();
        ajaxurl =   control_vars.admin_url + 'admin-ajax.php';
        parent  =   $(this).parent().parent().parent();
        acesta  =   $(this);
        $('.mess_content, .mess_reply_form').hide();
        parent.find('.mess_content').show();
        parent.find('.mess_reply_form').show();

     
    });
    
    
     $('.mess_delete').click(function (event) {
        var messid, ajaxurl, acesta, parent;
        event.stopPropagation();
        ajaxurl     =   control_vars.admin_url + 'admin-ajax.php';
        parent  =   $(this).parent().parent().parent().parent();
        messid  =   parent.attr('data-messid');
        acesta  =   $(this);
        //$(this).empty().removeClass('mess_delete').html(dashboard_vars.deleting);
        
        $(this).parent().parent().empty().addClass('delete_inaction').html(dashboard_vars.deleting);
        
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'            :   'wpestate_booking_delete_mess',
                'messid'            :   messid
            },
            success: function (data) {
                parent.parent().remove();
                $('.mess_content, .mess_reply_form').hide();
            },
            error: function (errorThrown) {

            }
        });
    });
    
});