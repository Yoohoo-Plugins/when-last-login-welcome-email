<?php

defined( 'ABSPATH' ) || exit;

class When_Last_Login_Email_Class {

    public static function sendEmail( $user_object = null, $email = null, $from = null, $fromname = null, $subject = null, $body = null ) {
        if ( ! is_object( $user_object ) ) {
            return false;
        }

        if ( empty( $email ) ) {
            $email = $user_object->data->user_email;
            $name = $user_object->data->display_name;
        }

        if ( empty( $from ) ) {
            $from = get_bloginfo( 'name' ) . ' <' . get_bloginfo( 'admin_email' ) . '>';
        }

        if ( empty( $fromname ) ) {
            $fromname = get_bloginfo( 'name' );
        }

        $settings = When_Last_Login_Welcome_Email::get_settings();

        $subject = $settings['subject'] ?? '';
        $body = $settings['body'] ?? '';
        $logo = $settings['logo'] ?? '';
        $footer_credit = $settings['footer_credit'] ?? '';

        $headers = array( 'Content-Type: text/html; charset=UTF-8' );
        $headers = apply_filters( 'wll_we_mail_headers', $headers );

        $attachments = apply_filters( 'wll_we_mail_attachments', array() );

        $available_tags = array(
            '**name**' => $name ?? '',
            '**site_name**' => $fromname,
            '**website_name**' => $fromname,
            '**mail_subject**' => $subject,
            '**logo**' => $logo,
            '**footer_credit**' => $footer_credit
        );

        foreach ( $available_tags as $key => $val ) {
            $body = str_replace( $key, (string) $val, $body );
        }

        $available_tags['**mail_body**'] = $body;
        $available_tags = apply_filters( 'wll_we_available_tags', $available_tags );

        $temp_data = self::rewrite_html_content( $available_tags );

        return wp_mail( $email, $subject, $temp_data, $headers, $attachments );
    }

    public static function rewrite_html_content( $available_tags ) {
        $template_path = dirname( __DIR__ ) . '/templates/welcome_email.html';

        if ( ! file_exists( $template_path ) ) {
            return '';
        }

        $data = file_get_contents( $template_path );

        if ( ! $data ) {
            return '';
        }

        foreach ( $available_tags as $key => $val ) {
            $data = str_replace( $key, (string) $val, $data );
        }

        $data = str_replace( '**stylesheet_url**', plugins_url( 'css/app.css', dirname( __DIR__ ) . '/when-last-login-welcome-email.php' ), $data );

        return $data;
    }
}
