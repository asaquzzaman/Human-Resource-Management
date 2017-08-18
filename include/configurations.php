<?php
use HRM\Core\Config\Config;

function config( $key = null ) {
    return Config::get( $key );
}