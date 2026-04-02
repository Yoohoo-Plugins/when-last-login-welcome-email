<?php

defined( 'ABSPATH' ) || exit;

$settings = When_Last_Login_Welcome_Email::get_settings();

$subject = $settings['subject'];
$body = $settings['body'];
$logo = $settings['logo'];
$footer_credit = $settings['footer_credit'];
?>
<tr>
    <th colspan="2">
        <h2><?php esc_html_e( 'When Last Login - Welcome Email Settings', 'when-last-login-welcome-email-add-on' ); ?></h2>
    </th>
</tr>
<tr>
    <th><?php esc_html_e( 'Welcome Email Subject', 'when-last-login-welcome-email-add-on' ); ?></th>
    <td>
        <input type="text" style="width: 300px;" name="wll_we_subject" value="<?php echo esc_attr( $subject ); ?>" />
    </td>
</tr>
<tr>
    <th><?php esc_html_e( 'Welcome Email Logo', 'when-last-login-welcome-email-add-on' ); ?></th>
    <td>
        <input type="text" style="width: 300px;" name="wll_we_logo" id="wll_we_logo" value="<?php echo esc_url( $logo ); ?>" />
        <button class="button" id="wll_we_upload_media"><?php esc_html_e( 'Upload Logo', 'when-last-login-welcome-email-add-on' ); ?></button>
    </td>
</tr>
<tr>
    <th><?php esc_html_e( 'Welcome Email Body', 'when-last-login-welcome-email-add-on' ); ?></th>
    <td>
        <textarea name="wll_we_body" rows="7" style="width: 50%"><?php echo esc_textarea( $body ); ?></textarea>
        <small class="description">
            <p><?php esc_html_e( 'The following tags can be used: ', 'when-last-login-welcome-email-add-on' ); ?></p>
            <code>**name**</code><code>**site_name**</code><code>**website_name**</code><code>**mail_subject**</code><code>**footer_credit**</code>
        </small>
    </td>
</tr>
<tr>
    <th><?php esc_html_e( 'Welcome Email Footer Credit', 'when-last-login-welcome-email-add-on' ); ?></th>
    <td>
        <input type="text" style="width: 300px;" name="wll_we_footer_credit" value="<?php echo esc_attr( $footer_credit ); ?>" />
    </td>
</tr>
<tr>
    <td colspan="2">
        <?php wp_nonce_field( 'wll_we_settings_save', 'wll_we_settings_nonce' ); ?>
        <input type="submit" name="wll_we_save_settings" class="button-primary" value="<?php esc_attr_e( 'Save Settings', 'when-last-login-welcome-email-add-on' ); ?>" />
    </td>
</tr>
