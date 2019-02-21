<?php

namespace HRM\Core;

use League\Fractal;
use League\Fractal\Manager as Manager;
use League\Fractal\Serializer\DataArraySerializer;

trait Transformer_Manager {
    public function get_response( $resource ) {
        $get_data = wp_unslash( $_GET );

        $manager = new Manager();
        $manager->setSerializer( new DataArraySerializer() );

        if ( isset( $get_data['with'] ) ) {
            $manager->parseIncludes( $get_data['with'] );
        }

        return $manager->createData( $resource )->toArray();
    }

    public function get_json_response( $resource ) {
        $get_data = wp_unslash( $_GET );
        
        $manager = new Manager();
        $manager->setSerializer( new DataArraySerializer() );

        if ( isset( $get_data['with'] ) ) {
            $manager->parseIncludes( $get_data['with'] );
        }

        return json_encode( $manager->createData( $resource )->toArray() );
    }
}