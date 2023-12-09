<?php

namespace HamiltonSC\Auth\App\Support;

use Illuminate\Support\Facades\Http;

class Filr
{
    public $aboutUser;

    public function getAboutUser(): array
    {
        return $this->aboutUser;
    }

    private function api($username, $password, $path)
    {
        $filr = config('remote_auth.drivers.filr.connection');

        return Http::withBasicAuth($username, $password)->get("{$filr}{$path}");
    }

    public function credentials($username, $password, $returnAfterAuth = false)
    {
        $self = $this->api($username, $password, '/self');

        if ($returnAfterAuth) {
            return $self->successful();
        }

        $id = $self['id'];

        $user = $this->api($username, $password, "/users/{$id}");

        $groups = $this->api($username, $password, "/users/{$id}/groups")['items'];

        return $this->credentialsMore($user, $groups);
    }

    public function credentialsMore($user, $groups)
    {
        $accountName = $user['name'];

        $memberships = [];

        foreach ($groups as $group) {
            $memberships[] = $group['title'];
        }
        
        $this->aboutUser = [
            'username' => $user['name'],
            'id' => $user['phone'] ?? null,
            'display_name' => $user['title'],
            'email' => $user['email'] ?? null,
            'last_name' => $user['last_name'],
            'first_name' => $user['first_name'],
            'groups' => $memberships,
        ];

        return $this;
    }

    // $user['id']
    // $user['href']
    // $user['disabled']
    // $user['middle_name']
}
