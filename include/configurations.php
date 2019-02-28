<?php
use HRM\Core\Config\Config;

function hrm_config( $key = null ) {
    return Config::get( $key );
}