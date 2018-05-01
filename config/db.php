<?php
global $wpdb;
return [
    'driver'    => 'mysql',
    'host'      => DB_HOST,
    'database'  => DB_NAME,
    'username'  => DB_USER,
    'password'  => DB_PASSWORD,
    'charset' => 'utf8',
    'collation' => 'utf8_general_ci',
    'prefix'    => $wpdb->prefix,
];