<?php

namespace HRM\Core\User;

use League\Fractal\TransformerAbstract;
use HRM\Models\User;

class User_Transformer extends TransformerAbstract {

    public function transform( User $user ) {
        $data = [
            'id'           => $user->ID,
            'username'     => $user->user_login,
            'nicename'     => $user->user_nicename,
            'email'        => $user->user_email,
            'profile_url'  => $user->user_url,
            'display_name' => $user->display_name,
            'avatar_url'   => get_avatar_url( $user->user_email ),
        ];

        return $data;
    }
}