<?php
global $submit_title;
global $submit_description;
global $property_price; 
global $property_label; 
?>

<div class="submit_container">
<div class="submit_container_header"><?php _e('Property Description & Price','wpestate');?></div>

<p class="full_form">
   <label for="title"><?php _e('*Title (mandatory)','wpestate'); ?> </label>
   <input type="text" id="title" class="form-control" value="<?php print $submit_title; ?>" size="20" name="title" />
</p>

<p class="full_form">
   <label for="description"><?php _e('*Description (mandatory)','wpestate');?></label>
   <textarea id="description"  class="form-control"  name="description" cols="50" rows="6"><?php print $submit_description; ?></textarea>
</p>

 <p class="half_form">
   <label for="property_price"> <?php _e('Price in ','wpestate');print esc_html( get_option('wp_estate_currency_symbol', '') ).' '; _e('(only numbers)','wpestate'); ?>  </label>
   <input type="text" id="property_price" class="form-control" size="40" name="property_price" value="<?php print $property_price;?>">
 </p>

<p class="half_form half_form_last">
   <label for="property_label"><?php _e('After Price Label (ex: "per month")','wpestate');?></label>
   <input type="text" id="property_label" class="form-control" size="40" name="property_label" value="<?php print $property_label;?>">
</p> 
</div>