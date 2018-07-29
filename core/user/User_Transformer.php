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
            'avatar_url'   => hrm_get_avater($user->ID)
        ];

        return $data;
    }
}