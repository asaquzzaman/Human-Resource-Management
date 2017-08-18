<?php
$crate_project = CPM_Proect::getInstance()
				 ->validator( $postdata )
				 ->create( $postdata );
use WP_Error;

class CPM_Proect {
    public static $error = false;

	public static function getInstance() {
        if ( !self::$_instance ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function validator( $postdata ) {
        try {
            $error = new WP_Error( 'Code', 'Message', 'server E' );
            throw new Exception();
        
        } catch( Excetion $e ) {
            
            return $error;

            if ( ! is_wp_error() )
               return $this;
            }
        }


    }

    public function create( $postdata ) {
    	return $project_id;
    }
}
WP_Error::create not found