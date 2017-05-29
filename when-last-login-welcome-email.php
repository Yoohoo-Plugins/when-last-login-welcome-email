<?php
/**
 * Plugin Name: When Last Login Welcome Email Add-on
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


    //functions go below


    public function check_if_user_first_time( $user_login, $users ){

    	$is_first_time = get_user_meta( $users->ID, 'wll_first_time', true );

    	//if( $is_first_time != 1 ){
    		//email the current user logging in from $users
    		//send an email
            When_Last_Login_Email_Class::sendEmail( $users->user_email );
            //wp_mail( 'admin@admin.com', 'subject', 'hi', '', array( '' ) );
    		update_user_meta( $users->ID, 'wll_first_time', 1 );
    	//}else{
    		//do nothing - for now
    	//}

    }


} //end of class

When_Last_Login_Welcome_Email::get_instance();



