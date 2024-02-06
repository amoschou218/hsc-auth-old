<?php

namespace HamiltonSC\Auth\App\Support;

use AMoschou\RemoteAuth\App\Support\ReadsConfig;
use Illuminate\Support\Facades\Http;

class Filr
{
    use ReadsConfig;

    public $profile;

    public function getProfile(): array
    {
        return $this->profile;
    }

    private function api($username, $password, $path)
    {
        $connection = $this->config('connection');

        return Http::withBasicAuth($username, $password)->get("{$connection}{$path}");
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

    private function credentialsMore($user, $groups)
    {
        $accountName = $user['name'];

        $memberships = [];

        foreach ($groups as $group) {
            $memberships[] = $group['title'];
        }

        $profile = [];

        foreach ($this->config('profile_map') as $profilekey => $filrkey) {
            $profile[$profilekey] = $user[$filrkey];
        }

        $profile['groups'] = $memberships;

        $this->profile = $profile;

        return $this;
    }
}
