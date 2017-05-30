<?php

class When_Last_Login_Email_Class{

	function __construct(){


	}
	
	public static function sendEmail( $user_object = NULL, $email = NULL, $from = NULL, $fromname = NULL, $subject = NULL, $body = NULL ){

		if( is_object( $user_object ) ){

			if( empty( $email ) ){

				$email = $user_object->data->user_email;
				$name = $user_object->data->display_name;

			}

		}

		if( empty( $from ) || $from == null ){
			$from = get_bloginfo( 'name') . ' ' . get_bloginfo( 'admin_email' );
		}

		if( empty( $fromname ) || $fromname == null ){
			$fromname = get_bloginfo( 'name' ); //show site name for fromname.
		}

		$settings = get_option( 'wll_we_settings' );

		$subject = isset( $settings['subject'] ) ? $settings['subject'] : "";
		$body = isset( $settings['body'] ) ? $settings['body'] : "";
		$logo = isset( $settings['logo'] ) ? $settings['logo'] : "";
		$footer_credit = isset( $settings['footer_credit'] ) ? $settings['footer_credit'] : "";

		if( empty( $subject ) || !$subject || $subject == "" ){
			$subject = sprintf( __('Welcome to %s', 'when-last-login-welcome-email'), get_bloginfo( 'name' ) );
		}

		if( empty( $body ) || !$body || $body == "" ){
			// Should get this from the settings | set a default
			$body = 'Some body';
		}

		//decode the subject line in case there are apostrophes/etc in it
		//$subject = html_entity_decode($subject, ENT_QUOTES, 'UTF-8');

		$headers = array( 'Content-Type: text/html; charset=UTF-8' );
		
		$headers = apply_filters( 'wll_we_mail_headers', $headers );

		$attachments = NULL;

		$attachments = apply_filters( 'wll_we_mail_attachments', $attachments );

		$available_tags = array(
			'**name**' => $name,
			'**site_name**' => $fromname,
			'**website_name**' => $fromname,
			'**mail_subject**' => $subject,
			'**logo**' => $logo,
			'**footer_credit**' => $footer_credit
		);

		if( is_array( $available_tags ) ){

			foreach( $available_tags as $key => $val ){

				$body = str_replace( $key, $val, $body );

			}

		}

		$available_tags['**mail_body**'] = $body;

		$available_tags = apply_filters( 'wll_we_available_tags', $available_tags );

		$temp_data = When_Last_Login_Email_Class::rewrite_html_content( $available_tags );

		$sent = wp_mail( $email, $subject, $temp_data, $headers, $attachments );

	}

	public static function rewrite_html_content( $available_tags ){
		
		$data = file_get_contents( dirname( __DIR__ ) . "/templates/welcome_email.html" );

		if( is_array( $available_tags ) ){

			foreach( $available_tags as $key => $val ){

				$data = str_replace( $key, $val, $data );

			}

		}

		$data = str_replace( '**stylesheet_url**', plugins_url( 'when-last-login-welcome-email/css/app.css', 'when-last-login-welcome-email' ), $data );
		
		return $data;

	}
	
} //end class