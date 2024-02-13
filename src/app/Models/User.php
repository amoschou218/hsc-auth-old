<?php

namespace HamiltonSC\Auth\App\Models;

use AMoschou\RemoteAuth\App\Models\User as BaseUser;

class User extends BaseUser
{
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
        'profile' => 'array',
        'socialite' => 'array',
    ];
}
