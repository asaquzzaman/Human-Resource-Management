<?php 

class HRM_Email {
    private static $_instance;

    public static function getInstance() {
        if ( !self::$_instance ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }
    /**
     * Get content html.
     *
     * @access public
     * @return string
     */
    public function get_content_html( $template, $args ) {
        ob_start();
        $this->load_templae( $template, $args );
        return ob_get_clean();
    }

    public function load_templae( $file, $args = null ) {
        if ( $args && is_array( $args ) ) {
            extract( $args );
        }

        if ( file_exists( $file ) ){
            include( $file );
        }
    }

    public function from_email() {
        $email = get_option( 'hrm_email_settings', [
            'form_email' => get_bloginfo( 'admin_email' )
        ]);
        return apply_filters('hrm_from_email', $email['form_email'] );
    }

    public function email_tyle() {
        $settings = get_option( 'hrm_email_settings', []);
        return apply_filters('hrm_email_type', $settings['email_type'] );
    }

    /**
     * Get WordPress blog name.
     *
     * @return string
     */
    public function get_blogname() {
        return wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
    }
    
    public static function send( $to, $subject, $message, $headers = [], $attachments = null ) {
        
        $blogname     = self::getInstance()->get_blogname();
        $no_reply     = 'no-reply@' . preg_replace( '#^www\.#', '', strtolower( $_SERVER['SERVER_NAME'] ) );
        $content_type = 'Content-Type: text/html';
        $charset      = 'Charset: UTF-8';
        $from_email   = self::getInstance()->from_email();
        $from         = "From: $blogname <$from_email>";
        $reply_to     = "Reply-To: $no_reply";

        $headers = array(
            $reply_to,
            $content_type,
            $charset,
            $from,
        );

       return wp_mail( $to, $subject, $message, $headers, $attachments );
        
    }
}