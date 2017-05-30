<?php
	$settings = get_option( 'wll_we_settings' );

	$subject = isset( $settings['subject'] ) ? stripslashes( $settings['subject'] ) : "";
	$body = isset( $settings['body'] ) ? stripslashes( $settings['body'] ) : "";
	$logo = isset( $settings['logo'] ) ? stripslashes( $settings['logo'] ) : "";
	$footer_credit = isset( $settings['footer_credit'] ) ? stripslashes( $settings['footer_credit'] ) : "";
?>
<tr>
	<th colspan='2'>
		<h2><?php _e('When Last Login - Welcome Email Settings', 'when-last-login-welcome-email'); ?></h2>
	</th>
</tr>
<tr>
	<th><?php _e('Welcome Email Subject', 'when-last-login-welcome-email'); ?></th>
	<td>
		<input type='text' style='width: 300px;' name='wll_we_subject' value='<?php echo $subject; ?>' />
	</td>
</tr>
<tr>
	<th><?php _e('Welcome Email Logo', 'when-last-login-welcome-email'); ?></th>
	<td>
		<input type='text' style='width: 300px;' name='wll_we_logo' id='wll_we_logo' value='<?php echo $logo; ?>' /><button class='button' id='wll_we_upload_media'><?php _e('Upload Logo', 'when-last-login-welcome-email'); ?>
	</td>
</tr>
<tr>
	<th><?php _e('Welcome Email Body', 'when-last-login-welcome-email'); ?></th>
	<td>
		<textarea name='wll_we_body' rows='7' style='width: 50%'><?php echo strip_tags( $body, '<p>'); ?></textarea>
		<small class='description'><p><?php _e('The following tags can be used: ', 'when-last-login-welcome-email'); ?></p><code>**site_name**</code><code>**website_name**</code><code>**mail_subject**</code><code>**footer_credit**</code></small>
	</td>
</tr>
<tr>
	<th><?php _e('Welcome Email Footer Credit', 'when-last-login-welcome-email'); ?></th>
	<td>
		<input type='text' style='width: 300px;' name='wll_we_footer_credit' value='<?php echo strip_tags( $footer_credit, '<a><p>' ); ?>' />
	</td>
</tr>
<tr>
    <th><input type="submit" name="wll_we_save_settings"  class="button-primary" value="<?php _e('Save Settings', 'when-last-login'); ?>" /></th>
    <td></td>
</tr>