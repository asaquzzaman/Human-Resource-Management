<?php

namespace HRM\Core\Common;

use HRM\Transformers\User_Transformer;

trait Resource_Editors {

    public function includeEmployee( $item ) {
        $user = $item->user;
        return $this->item( $user, new User_Transformer );
    }
}