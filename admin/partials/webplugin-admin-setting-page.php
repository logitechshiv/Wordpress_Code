<?php

/**
 * Provide a admin area view for a settings page
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 * 
 *
 * @link       http://shivweb.com
 * @since      1.0.0
 *
 * @package    Webplugin
 * @subpackage Webplugin/includes
 */
?>
<script type="text/javascript">
	jQuery(document).ready(function() {
    jQuery('.datepicker').datepicker();
    jQuery('.web-color-field').wpColorPicker();

	var mediaUploader;
	jQuery('#wp_image_button').click(function(e) {
		e.preventDefault();
		  if (mediaUploader) {
		  mediaUploader.open();
		  return;
		}
		mediaUploader = wp.media.frames.file_frame = wp.media({
		  title: 'Choose Image',
		  button: {
		  text: 'Choose Image'
		}, multiple: false });
		mediaUploader.on('select', function() {
		  var attachment = mediaUploader.state().get('selection').first().toJSON();
		  jQuery('#wp_image').val(attachment.url);
		});
		mediaUploader.open();
	});

    // Reset Setting Ajax call Script code
    jQuery( "#reset_setting" ).click(function( event ) {
        event.preventDefault();
        jQuery.ajax({
            url : "<?php echo admin_url('admin-ajax.php'); ?>",
            type : 'post',
            data : {
                action : 'webp_set_default'
            },
            success : function( response ) {
                location.reload(true);
            }
        });
    });
});
</script>
<div class="wrap">
   
    <h3><?php echo __('WebPluing Settings Page')?></h3>
     <?php submit_button( 'Reset All Setting', 'primary', 'reset_setting', TRUE ); ?> 
    
    <div class="setting_wrap">
    <h2><?php echo esc_html(get_admin_page_title()); ?></h2>
    <form method="post" name="webp_setting_form" class="webp_setting_form" action="options.php" enctype="multipart/form-data">
        <?php settings_errors(); ?>
        <?php settings_fields('webplugin_widget_setting'); ?>
        <?php do_settings_sections('webplugin_widget_setting'); ?>
        <table class="form-table user-table">
            <tr valign="top">
                <th scope="row">Title:</th>
                <td>
                    <fieldset>
                        <input type="text" name="wp_title" size="40" value="<?php echo esc_attr(get_option('wp_title')); ?>" />
                        <p class="description">Enter a title</p>
                    </fieldset>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Description:</th>
                <td>
                    <fieldset>
                    	<textarea id="wp_description" name="wp_description" rows="3" cols="40">
                    	<?php echo esc_attr(get_option('wp_description')); ?>
                    	</textarea>
                    	<p class="description">Enter a description</p>
                    </fieldset>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Enter Content:</th>
                <td>
                    <fieldset>
                    	<?php     
                    	    $wp_enter_content = get_option( 'wp_enter_content' );
                    	echo wp_editor( $wp_enter_content, 'uspartnersdesc', array('textarea_name' => 'wp_enter_content', 'editor_height' => 250, 'textarea_rows' => 10)  ); ?>
                    	<p class="description">Enter Editor Content</p>
                    </fieldset>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Enter Date:</th>
                <td>
                    <fieldset>
                        <input type="text" name="wp_date" class="datepicker" size="40" value="<?php echo esc_attr(get_option('wp_date')); ?>" />
                        <p class="description">Enter a date</p>
                    </fieldset>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Image:</th>
                <td>
                    <fieldset>
						<input id="wp_image" type="text" name="wp_image" value="<?php echo get_option('wp_image'); ?>" />
						<input id="wp_image_button" type="button" class="button-primary" value="Choose Image" />
						<?php if(!empty(get_option('wp_image'))) { ?>
							<br><br>
							<img src="<?php echo get_option('wp_image'); ?>" alt="" width="100" height="100" />
						<?php } else { ?> 
                        	<p class="description">Choose Image</p>
                        <?php } ?>
                    </fieldset>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Color Picker:</th>
                <td>
					<?php $wp_skin_color = ( esc_attr(get_option('wp_color')) ) ? esc_attr(get_option('wp_color')) : '#000000' ; ?>
					
                    <input type="text" name="wp_color" class='web-color-field' value="<?php echo $wp_skin_color; ?>" data-default-color="#000000" />
                    <p class="description">Choose Color</p>
                </td>
            </tr>
        </table>
    	<?php submit_button('Save changes', 'primary','submit', TRUE); ?>  

        </form>
    </div> <!-- settings_wrap end -->
</div>
