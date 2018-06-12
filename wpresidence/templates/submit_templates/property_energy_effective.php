<?php
global $energy_class;
global $energy_index;
global $submission_page_fields;

 
?>



<?php if(   is_array($submission_page_fields) && 
            (   in_array('energy_index', $submission_page_fields) || 
                in_array('energy_class', $submission_page_fields)
            )
        ) { ?>   

    <div class="col-md-12 add-estate profile-page profile-onprofile row"> 
        <div class="submit_container"> 
            <div class="col-md-4 profile_label">
                <div class="user_details_row"><?php _e('Select Energy Class','wpestate');?></div> 
                <div class="user_profile_explain"><?php _e('Some energy class description','wpestate')?></div>
            </div> 


            <?php if(   is_array($submission_page_fields) && in_array('energy_class', $submission_page_fields)) { ?>
                <p class="col-md-4"><label for="energy_class"><?php _e('Energy Class','wpestate');?></label>
                    <?php 
						$energy_class_array = array( 'A+', 'A', 'B', 'C', 'D', 'E', 'F', 'G' );
					?>
					<select name="energy_class" id="energy_class">
						<option value=""><?php _e('Select Energy Class (EU regulation)','wpestate'); ?>
						<?php 
							foreach( $energy_class_array as $single_class ){
								print '<option value="'.$single_class.'"  '.( $energy_class == $single_class ? ' selected ' : '' ).'  >'.$single_class;
							}
						?>
					</select>
                </p>
            <?php }?>

             <?php if(   is_array($submission_page_fields) && in_array('energy_index', $submission_page_fields)) { ?>
                    <p class="col-md-4  ">
                        <label for="energy_index"> <?php _e('Energy Index in kWh/m2a','wpestate');  ?>  </label>
                        <input type="text" id="energy_index" class="form-control" size="40" name="energy_index" value="<?php print sanitize_text_field( $energy_index );?>">
                    </p>
                <?php }?>
        </div>
    </div>

<?php }?>