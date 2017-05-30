<?php
/**
 * Plugin Name: When Last Login - Welcome Email Add-on
 * Description: Send an HTML welcome email when a user logs in for the first time.
 * Plugin URI: https://yoohooplugins.com
 * Author: YooHoo Plugins
 * Author URI: https://yoohooplugins.com
 * Version: 1.0
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: when-last-login-welcome-email
 */

defined( 'ABSPATH' ) or exit;

require('classes/class.when-last-login-email.php');
/**
*  Class for When Last Login Welcome Email Add-on
*/
class When_Last_Login_Welcome_Email {
	

	/** Refers to a single instance of this class. */
    private static $instance = null;

    /**
    * Initializes the plugin by setting localization, filters, and administration functions.
    */
    private function __construct() {

    	add_action( 'init', array( $this, 'init' ) );

    	add_action( 'wp_login', array( $this, 'check_if_user_first_time' ), 10, 2 );
        add_filter( 'wll_settings_page_tabs', array( $this, 'wll_we_settings_tab' ) );
        add_filter( 'wll_settings_page_content', array( $this, 'wll_we_settings_content' ) );
        add_action( 'admin_head', array( $this, 'wll_we_save_settings') );
        add_action( 'admin_enqueue_scripts', array( $this, 'wll_we_admin_scripts' ) );

        register_activation_hook( __FILE__, array( $this, 'wll_we_activate' ) );

    }

    public function wll_we_activate(){

        $current_settings = get_option( 'wll_we_settings' );

        if( !$current_settings || $current_settings == "" || !is_array( $current_settings ) ){
                
            $body_content = "";

            $body_content .= "<p>".__('Hi there **name**', 'when-last-login-welcome-email')."</p>".PHP_EOL;
            $body_content .= "<p>".__('Thank you for logging in to **site_name**', 'when-last-login-welcome-email')."</p>".PHP_EOL;
            $body_content .= "<p>".__('We noticed that this was your first time logging into our site - we just wanted to send a warm welcome and let you know that if you need help with anything, please get in touch with us', 'when-last-login-welcome-email')."</p>".PHP_EOL;

            $settings = array(
                'subject' => __('Welcome to ', 'when-last-login-welcome-email').get_bloginfo( 'name' ),
                'logo' => '',
                'body' => $body_content,
                'footer_credit' => '<a href="'.get_option('siteurl').'">'.get_bloginfo( 'name' ).'</a>'
            );

            update_option( 'wll_we_settings', $settings );

        }
    }

    public function wll_we_admin_scripts(){

        if( isset( $_GET['tab'] ) && $_GET['tab'] == 'welcome-emails' ){
            wp_enqueue_script( 'jquery' );
            wp_enqueue_media();
            wp_enqueue_script( 'wll-we-admin-script', plugins_url( '/js/admin.js', __FILE__ ) );
        }

    }

    /**
     * Creates or returns an instance of this class.
     *
     * @return  When_Last_Login A single instance of this class.
     */
    public static function get_instance() {
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
        return self::$instance;
    } // end get_instance;


    public static function init(){
    	//add all actions here fam.

    }

    public function check_if_user_first_time( $user_login, $users ){

    	$is_first_time = get_user_meta( $users->ID, 'wll_we_first_time', true );

        if( $is_first_time == '' ){

            When_Last_Login_Email_Class::sendEmail( $users );

            update_user_meta( $users->ID, 'wll_we_first_time', 0 );

        }

    }

    public function wll_we_settings_tab( $array ){

        $array['welcome-emails'] = array(
            'title' => __('Welcome Emails', 'when-last-login-email'),
            'icon' => ''
        );

        return $array;

    }

    public function wll_we_settings_content( $content ){

        $content['welcome-emails'] = plugin_dir_path( __FILE__ ).'/when-last-login-welcome-email-settings.php';

        return $content;

    }

    public function wll_we_save_settings(){

        if( isset( $_POST['wll_we_save_settings'] ) ){

            $subject = isset( $_POST['wll_we_subject'] ) ? sanitize_text_field( $_POST['wll_we_subject'] ) : "";
            $body = isset( $_POST['wll_we_body'] ) ? nl2br( $_POST['wll_we_body'] ) : "";
            $logo = isset( $_POST['wll_we_logo'] ) ? sanitize_text_field( $_POST['wll_we_logo'] ) : "";
            $footer_credit = isset( $_POST['wll_we_footer_credit'] ) ? $_POST['wll_we_footer_credit'] : "";

            $settings = array(
                'subject' => $subject,
                'body' => $body,
                'logo' => $logo,
                'footer_credit' => $footer_credit
            );

            $updated = update_option( 'wll_we_settings', $settings );

            if( $updated ){
                echo "<div class='updated'><p>".__('Settings successfully updated', 'when-last-login-welcome-email')."</p></div>";
            }

        }

    }


} //end of class

When_Last_Login_Welcome_Email::get_instance();



