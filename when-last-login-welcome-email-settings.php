<?php
/**
 * Settings page for When Last Login - Welcome Email
 *
 * @package When_Last_Login_Welcome_Email
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$settings = get_option( 'wll_we_settings' );

$subject = isset( $settings['subject'] ) ? stripslashes( $settings['subject'] ) : "";
$body = isset( $settings['body'] ) ? stripslashes( $settings['body'] ) : "";
$logo = isset( $settings['logo'] ) ? stripslashes( $settings['logo'] ) : "";
$footer_credit = isset( $settings['footer_credit'] ) ? stripslashes( $settings['footer_credit'] ) : "";
?>
<tr>
    <th colspan='2'>
        <h2><?php echo esc_html__( 'When Last Login - Welcome Email Settings', 'when-last-login-welcome-email-add-on' ); ?></h2>
    </th>
</tr>
<tr>
    <th><?php echo esc_html__( 'Welcome Email Subject', 'when-last-login-welcome-email-add-on' ); ?></th>
    <td>
        <input type='text' style='width: 300px;' name='wll_we_subject' value='<?php echo esc_attr( $subject ); ?>' />
    </td>
</tr>
<tr>
    <th><?php echo esc_html__( 'Welcome Email Logo', 'when-last-login-welcome-email-add-on' ); ?></th>
    <td>
        <input type='text' style='width: 300px;' name='wll_we_logo' id='wll_we_logo' value='<?php echo esc_url( $logo ); ?>' />
        <button class='button' id='wll_we_upload_media'><?php echo esc_html__( 'Upload Logo', 'when-last-login-welcome-email-add-on' ); ?></button>
    </td>
</tr>
<tr>
    <th><?php echo esc_html__( 'Welcome Email Body', 'when-last-login-welcome-email-add-on' ); ?></th>
    <td>
        <textarea name='wll_we_body' rows='7' style='width: 50%'><?php echo esc_textarea( strip_tags( $body, '<p>' ) ); ?></textarea>
        <small class='description'>
            <p><?php echo esc_html__( 'The following tags can be used: ', 'when-last-login-welcome-email-add-on' ); ?></p>
            <code>**name**</code><code>**site_name**</code><code>**website_name**</code><code>**mail_subject**</code><code>**footer_credit**</code>
        </small>
    </td>
</tr>
<tr>
    <th><?php echo esc_html__( 'Welcome Email Footer Credit', 'when-last-login-welcome-email-add-on' ); ?></th>
    <td>
        <input type='text' style='width: 300px;' name='wll_we_footer_credit' value='<?php echo esc_attr( strip_tags( $footer_credit, '<a><p>' ) ); ?>' />
    </td>
</tr>
<tr>
    <th>
        <?php wp_nonce_field( 'wll_we_settings_save', 'wll_we_settings_nonce' ); ?>
        <input type="submit" name="wll_we_save_settings" class="button-primary" value="<?php echo esc_attr__( 'Save Settings', 'when-last-login-welcome-email-add-on' ); ?>" />
    </th>
    <td></td>
</tr>
