<?php

class When_Last_Login_Email_Class{

	function __construct(){}
	
	public static function sendEmail( $email = NULL, $from = NULL, $fromname = NULL, $subject = NULL, $body = NULL ){

		 global $current_user;


		if( empty( $email ) ){
			$email = $current_user->user_email;
		}

		if( empty( $from ) ){
			$from = bloginfo( 'name') . ' ' . bloginfo( 'admin_email' );
		}

		if( empty( $fromname ) ){
			$fromname = bloginfo( 'name' ); //show site name for fromname.
		}

		if( empty( $subject ) ){
			$subject = 'Some Fallback subject';
		}

		if( empty( $body ) ){
			$body = 'Some body';
		}
	
		//decode the subject line in case there are apostrophes/etc in it
		//$subject = html_entity_decode($subject, ENT_QUOTES, 'UTF-8');

		$headers = array( 'Content Type: text/html' );
		$attachments = NULL;

		$temp_data = When_Last_Login_Email_Class::rewrite_html_content();

		//get content from template file and rewrite
		//$body = $temp_data;

		wp_mail( $email, $subject, $temp_data, $headers, $attachments );

	}

	public static function rewrite_html_content(){
		//str_replace $data and return the data.
		$data = file_get_contents( dirname( __DIR__ ) . "/templates/welcome_email.html" );

		
		return $data;
	}

	//do a rewrite of magic tags too. {{name}} = $current_user->name;
} //end class