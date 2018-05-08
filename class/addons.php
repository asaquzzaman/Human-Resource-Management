<?php

class HRM_Addons {

	private static $_instance;

    public static function getInstance() {
        if ( !self::$_instance ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public static function init( $addons ) {
    	require_once HRM_TEMPLATE_PATH . '/addons/menu.php';
    }

    public static function licenses( $licenses ) {
        require_once HRM_TEMPLATE_PATH . '/addons/licenses.php';
    }
}