<?php
/**
 * Plugin Name: When Last Login - Welcome Email Add-on
 * Description: Send an HTML welcome email when a user logs in for the first time.
 * Plugin URI: https://yoohooplugins.com
 * Author: YooHoo Plugins
 * Author URI: https://yoohooplugins.com
 * Version: 1.1.1
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: when-last-login-welcome-email-add-on
 * Requires at least: 5.0
 * Tested up to: 6.9
 */

defined( 'ABSPATH' ) or exit;

require_once( 'classes/class.when-last-login-email.php' );

class When_Last_Login_Welcome_Email {

    private static $instance = null;

    public static function get_default_settings() {
        $body_content = "<p>" . __( 'Hi there **name**', 'when-last-login-welcome-email-add-on' ) . "</p>" . PHP_EOL;
        $body_content .= "<p>" . __( 'Thank you for logging in to **site_name**', 'when-last-login-welcome-email-add-on' ) . "</p>" . PHP_EOL;
        $body_content .= "<p>" . __( 'We noticed that this was your first time logging into our site - we just wanted to send a warm welcome and let you know that if you need help with anything, please get in touch with us', 'when-last-login-welcome-email-add-on' ) . "</p>" . PHP_EOL;

        return array(
            'subject' => __( 'Welcome to ', 'when-last-login-welcome-email-add-on' ) . get_bloginfo( 'name' ),
            'logo' => '',
            'body' => $body_content,
            'footer_credit' => '<a href="' . home_url() . '">' . get_bloginfo( 'name' ) . '</a>'
        );
    }

    public static function get_settings() {
        $settings = get_option( 'wll_we_settings', array() );
        $defaults = self::get_default_settings();
        return wp_parse_args( $settings, $defaults );
    }

    private function __construct() {
        add_action( 'wp_login', array( $this, 'check_if_user_first_time' ), 10, 2 );
        add_filter( 'wll_settings_page_tabs', array( $this, 'wll_we_settings_tab' ) );
        add_filter( 'wll_settings_page_content', array( $this, 'wll_we_settings_content' ) );
        add_action( 'admin_init', array( $this, 'wll_we_save_settings' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'wll_we_admin_scripts' ) );
    }

    public function wll_we_admin_scripts( $hook ) {
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Tab parameter is read-only, no form data processed.
        if ( ! isset( $_GET['tab'] ) || 'welcome-emails' !== sanitize_key( $_GET['tab'] ) ) {
            return;
        }
        wp_enqueue_script( 'jquery' );
        wp_enqueue_media();
        wp_enqueue_script( 'wll-we-admin-script', plugin_dir_url( __FILE__ ) . 'js/admin.js', array( 'jquery' ), '1.1', true );
    }

    public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function check_if_user_first_time( $user_login, $user ) {
        if ( get_user_meta( $user->ID, 'wll_we_sent_first_email', true ) ) {
            return;
        }

        When_Last_Login_Email_Class::sendEmail( $user );
        update_user_meta( $user->ID, 'wll_we_sent_first_email', 1 );
    }

    public function wll_we_settings_tab( $tabs ) {
        $tabs['welcome-emails'] = array(
            'title' => __( 'Welcome Email', 'when-last-login-welcome-email-add-on' ),
            'icon' => ''
        );
        return $tabs;
    }

    public function wll_we_settings_content( $content ) {
        $content['welcome-emails'] = plugin_dir_path( __FILE__ ) . 'when-last-login-welcome-email-settings.php';
        return $content;
    }

    public function wll_we_save_settings() {
        if ( ! isset( $_POST['wll_we_save_settings'] ) ) {
            return;
        }

        if ( ! isset( $_POST['wll_we_settings_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['wll_we_settings_nonce'] ) ), 'wll_we_settings_save' ) ) {
            return;
        }

        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        $settings = array(
            'subject' => isset( $_POST['wll_we_subject'] ) ? sanitize_text_field( wp_unslash( $_POST['wll_we_subject'] ) ) : '',
            'body' => isset( $_POST['wll_we_body'] ) ? wp_kses_post( wp_unslash( $_POST['wll_we_body'] ) ) : '',
            'logo' => isset( $_POST['wll_we_logo'] ) ? esc_url_raw( wp_unslash( $_POST['wll_we_logo'] ) ) : '',
            'footer_credit' => isset( $_POST['wll_we_footer_credit'] ) ? wp_kses_post( wp_unslash( $_POST['wll_we_footer_credit'] ) ) : '',
        );

        update_option( 'wll_we_settings', $settings );

        // Set transient to show success message on next page load
        set_transient( 'wll_we_settings_saved', true, 30 );
    }
}

When_Last_Login_Welcome_Email::get_instance();
