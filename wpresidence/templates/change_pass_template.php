<div class="add-estate profile-page profile-onprofile row"> 
    <div class="col-md-4 profile_label">
        <div class="change_pass"><?php _e('Change Password','wpestate');?></div> 
        <div class="pass_note"><?php _e('*After you change the password you will have to login again.','wpestate')?></div>

    </div>  
    <div class="col-md-8 dashboard_password">
        <div id="profile_pass"></div>
        <p  class="col-md-12">
            <label for="oldpass"><?php _e('Old Password','wpestate');?></label>
            <input  id="oldpass" value=""  class="form-control" name="oldpass" type="password">
        </p>

        <p  class="col-md-6">
            <label for="newpass"><?php _e('New Password ','wpestate');?></label>
            <input  id="newpass" value="" class="form-control" name="newpass" type="password">
        </p>
        <p  class="col-md-6">
            <label for="renewpass"><?php _e('Confirm New Password','wpestate');?></label>
            <input id="renewpass" value=""  class="form-control" name="renewpass"type="password">
        </p>

        <?php   wp_nonce_field( 'pass_ajax_nonce', 'security-pass' );   ?>
        <p class="fullp-button">
            <button class="wpresidence_button" id="change_pass"><?php _e('Reset Password','wpestate');?></button>

        </p>
    </div>
</div>   