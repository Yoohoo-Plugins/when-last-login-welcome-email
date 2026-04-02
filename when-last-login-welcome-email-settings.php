<?php

defined( 'ABSPATH' ) || exit;

$wll_we_settings = When_Last_Login_Welcome_Email::get_settings();

$wll_we_subject = isset( $wll_we_settings['subject'] ) ? stripslashes( $wll_we_settings['subject'] ) : "";
$wll_we_body = isset( $wll_we_settings['body'] ) ? stripslashes( $wll_we_settings['body'] ) : "";
$wll_we_logo = isset( $wll_we_settings['logo'] ) ? stripslashes( $wll_we_settings['logo'] ) : "";
$wll_we_footer_credit = isset( $wll_we_settings['footer_credit'] ) ? stripslashes( $wll_we_settings['footer_credit'] ) : "";

// Check for saved success message
$wll_we_saved_successfully = get_transient( 'wll_we_settings_saved' );
if ( $wll_we_saved_successfully ) {
    delete_transient( 'wll_we_settings_saved' );
}
?>
<tr>
    <th colspan='2'>
        <h2><?php echo esc_html__( 'When Last Login - Welcome Email Settings', 'when-last-login-welcome-email' ); ?></h2>
        <p class="description">
            <?php echo esc_html__( 'Sends a welcome email to users on their very first login to your site.', 'when-last-login-welcome-email' ); ?>
        </p>
        <?php if ( $wll_we_saved_successfully ) : ?>
            <div class="notice notice-success is-dismissible inline" style="margin: 10px 0;">
                <p><?php echo esc_html__( 'Settings saved successfully!', 'when-last-login-welcome-email' ); ?></p>
            </div>
        <?php endif; ?>
    </th>
</tr>
<tr>
    <th><?php esc_html_e( 'Welcome Email Subject', 'when-last-login-welcome-email-add-on' ); ?></th>
    <td>
        <input type="text" style="width: 300px;" name="wll_we_subject" value="<?php echo esc_attr( $wll_we_subject ); ?>" />
    </td>
</tr>
<tr>
    <th><?php esc_html_e( 'Welcome Email Logo', 'when-last-login-welcome-email-add-on' ); ?></th>
    <td>
        <input type="text" style="width: 300px;" name="wll_we_logo" id="wll_we_logo" value="<?php echo esc_url( $wll_we_logo ); ?>" />
        <button class="button" id="wll_we_upload_media"><?php esc_html_e( 'Upload Logo', 'when-last-login-welcome-email-add-on' ); ?></button>
    </td>
</tr>
<tr>
    <th><?php esc_html_e( 'Welcome Email Body', 'when-last-login-welcome-email-add-on' ); ?></th>
    <td>
        <textarea name="wll_we_body" rows="7" style="width: 50%"><?php echo esc_textarea( $wll_we_body ); ?></textarea>
        <small class="description">
            <p><?php esc_html_e( 'The following tags can be used: ', 'when-last-login-welcome-email-add-on' ); ?></p>
            <code>**name**</code><code>**site_name**</code><code>**website_name**</code><code>**mail_subject**</code><code>**footer_credit**</code>
        </small>
    </td>
</tr>
<tr>
    <th><?php esc_html_e( 'Welcome Email Footer Credit', 'when-last-login-welcome-email-add-on' ); ?></th>
    <td>
        <input type="text" style="width: 300px;" name="wll_we_footer_credit" value="<?php echo esc_attr( $wll_we_footer_credit ); ?>" />
    </td>
</tr>
<tr>
    <td colspan="2">
        <?php wp_nonce_field( 'wll_we_settings_save', 'wll_we_settings_nonce' ); ?>
        <input type="submit" name="wll_we_save_settings" class="button-primary" value="<?php esc_attr_e( 'Save Settings', 'when-last-login-welcome-email-add-on' ); ?>" />
    </td>
</tr>
