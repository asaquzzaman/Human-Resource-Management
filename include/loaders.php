<?php
function hrm_load_configurations() {
    $files = glob( __DIR__ . "/../config/*.php" );

    if ( $files === false ) {
        throw new RuntimeException( "Failed to glob for config files" );
    }

    foreach ( $files as $file ) {
        $config[basename( $file, '.php' )] = require_once $file;
    }

    unset( $file );
    unset( $files );

    return $config;
}