<?php

namespace HRM\Core\Common\Traits;

use League\Fractal;
use League\Fractal\Manager as Manager;
use League\Fractal\Serializer\DataArraySerializer;

trait Transformer_Manager {

    public function get_response( $resource, $extra = [] ) {
        $get_data = wp_unslash( $_GET );

        $manager = new Manager();
        $manager->setSerializer( new DataArraySerializer() );

        if ( isset( $get_data['with'] ) ) {
            $manager->parseIncludes( $get_data['with'] );
        }

        if ($resource) {
            $response = $manager->createData( $resource )->toArray();

        } else {
            $response = [];
        }

        return array_merge( $extra, $response );
    }

    public function get_json_response( $resource, $extra = [] ) {
        $get_data = wp_unslash( $_GET );
        
        $manager = new Manager();
        $manager->setSerializer( new DataArraySerializer() );

        if ( isset( $get_data['with'] ) ) {
            $manager->parseIncludes( $get_data['with'] );
        }

        if ($resource) {
            $response = $manager->createData( $resource )->toArray();
        } else {
            $response = [];
        }

        return json_encode( array_merge( $extra, $response ) );
    }
}