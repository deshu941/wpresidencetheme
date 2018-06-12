<?php
add_action( 'show_user_profile', 'wpestate_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'wpestate_show_extra_profile_fields' );
if( !function_exists('wpestate_show_extra_profile_fields') ):
function wpestate_show_extra_profile_fields( $user ) { ?>

	<?php 
	//check if user have assigned role and idate
	$assigned_id = get_user_meta( $user->ID, 'user_agent_id', true );
	$assigned_role = get_user_meta( $user->ID, 'user_estate_role', true );
	

	
	if( $assigned_id  && $assigned_role == '2' ):	
	?>


	<h3><?php echo __( 'Agent custom data', 'wpestate' ); ?></h3>

	<table class="form-table">

		<tr>
			<td colspan="4">
				<input type="button"   value="<?php echo __( 'Add Custom Field', 'wpestate' ); ?>" class="button button-primary add_custom_parameter" /> 
			</td>
		</tr>
		
		<tr>
			<td>
				<label for="twitter"><?php echo __( 'Parameters list', 'wpestate' ); ?></label>
			</td>

			
			
			<td>
				<table class="table">  
  
				<tbody class="add_custom_data_cont">  
					<tr class="single_parameter_row cliche_row">  
						<td>
							<label><?php echo __( 'Field Label:', 'wpestate' ); ?></label>
							<input name="agent_custom_label[]" />
						</td>  
						<td>
							<label><?php echo __( 'Field Value: ', 'wpestate' ); ?></label>
							<input name="agent_custom_value[]" />
						</td>  
						<td>
							<input type="button"   value="<?php echo __( 'Remove', 'wpestate' ); ?>" class="button button-primary remove_parameter_button" />
						</td>  
						 
					  </tr> 
					<?php 
					
					$agent_custom_data = get_post_meta( $assigned_id, 'agent_custom_data', true );
  
					if( count( $agent_custom_data )  > 0  && is_array( $agent_custom_data) ){
						for( $i=0; $i<count( $agent_custom_data ); $i++ ){
							?>
							
							<tr class="single_parameter_row ">  
								<td>
									<label><?php echo __( 'Field Label:', 'wpestate' ); ?></label>
									<input name="agent_custom_label[]" value="<?php echo  esc_html( $agent_custom_data[$i]['label'] ); ?>" />
								</td>  
								<td>
									<label><?php echo __( 'Field Value: ', 'wpestate' ); ?></label>
									<input name="agent_custom_value[]" value="<?php echo  esc_html( $agent_custom_data[$i]['value'] ); ?>" />
								</td>  
								<td>
									<input type="button"   value="<?php echo __( 'Remove', 'wpestate' ); ?>" class="button button-primary remove_parameter_button" />
								</td>  
							</tr> 
							
							<?php
						}
					}
					?>
				
				
				 
				  
				</tbody>  
			  </table>  
			</td>
		</tr>

	</table>
<?php 
	else:
		return false;
	endif;

}
endif;


add_action( 'personal_options_update', 'wpestate_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'wpestate_save_extra_profile_fields' );
if( !function_exists('wpestate_save_extra_profile_fields') ):
	function wpestate_save_extra_profile_fields( $user_id ) {


		if ( !current_user_can( 'edit_user', $user_id ) )
			return false;

		$assigned_id = get_user_meta( $user_id, 'user_agent_id', true );

		if( $assigned_id ){
	 
			$agent_custom_label          =   array();
			$agent_custom_value          =   array();
			
			if( isset($_POST['agent_custom_label']) ){
				$agent_custom_label          =   $_POST['agent_custom_label'];
			}
			if( isset($_POST['agent_custom_value']) ){
				$agent_custom_value          =   $_POST['agent_custom_value'];
			}
		 
		 
		 
			// prcess fields data
			$agent_fields_array = array();
			for( $i=1; $i<count( $agent_custom_label  ); $i++ ){
				$agent_fields_array[] = array( 'label' => sanitize_text_field( $agent_custom_label[$i] ), 'value' => sanitize_text_field( $agent_custom_value[$i] ) );
			}
			
		 
			update_post_meta( $assigned_id, 'agent_custom_data', $agent_fields_array );
			
		}
	
	}
endif;
?>