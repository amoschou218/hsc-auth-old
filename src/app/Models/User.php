<?php

namespace HamiltonSC\Auth\App\Models;

use AMoschou\RemoteAuth\App\Models\User as RemoteAuthUser;

class User extends RemoteAuthUser
{
    public $roles = [
        'student' => 'UG_Students',
        'teacher' => 'UG_Staff_Teachers',
    ];
}
