<?php

namespace HamiltonSC\Auth\App\Models;

use AMoschou\RemoteAuth\App\Models\User as RemoteAuthUser;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\DB;

class User extends RemoteAuthUser
{
    public $roles = [
        'student' => 'UG_Students',
        'teacher' => 'UG_Staff_Teachers',
    ];

    /**
     * Get the groups for the user.
     */
    public function getGroups()
    {
        return DB::table('remote_auth_memberships')->where('username', $this->username)->pluck('group')->toArray();
    }
}
