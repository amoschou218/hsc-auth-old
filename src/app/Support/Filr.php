<?php

namespace HamiltonSC\Auth\App\Support;

use AMoschou\RemoteAuth\App\Support\ReadsConfig;
use Illuminate\Support\Facades\Http;

class Filr
{
    use ReadsConfig;

    /**
     * The key that is used to identify the provider in the config file.
     *
     * @var string
     */
    private $key;

    /**
     * The support data that the driver requires.
     *
     * @var array<string, mixed>
     */
    private $data = [];

    /**
     * Create a new Filr support instance.
     *
     * @param  string  $key
     * @return void
     */
    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * Create a new Filr support instance using a static interface.
     *
     * @param  string  $key
     * @return AMoschou\RemoteAuth\App\Support\Filr
     */
    public static function for($key)
    {
        return new Filr($key);
    }

    /**
     * Return whether the given credentials are valid on the Filr server.
     */
    public function attempt($username, $password)
    {
        return $this->api($username, $password, '/self')->successful();
    }

    /**
     * Return the profile of the user with the given credentials.
     */
    public function profile($username, $password)
    {
        if (! $this->attempt($username, $password)) {
            return null;
        }

        $id = $this->api($username, $password, '/self')['id'];

        $user = $this->api($username, $password, "/users/{$id}");

        $groups = $this->api($username, $password, "/users/{$id}/groups")['items'];

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

        return $profile;
    }

    private function api($username, $password, $path)
    {
        $connection = $this->config('connection');

        return Http::withBasicAuth($username, $password)->get("{$connection}{$path}");
    }
}
