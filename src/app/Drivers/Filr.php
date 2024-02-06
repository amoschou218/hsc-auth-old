<?php

namespace HamiltonSC\Auth\App\Drivers;

use AMoschou\RemoteAuth\App\Drivers\BaseDriver;
use HamiltonSC\Auth\App\Support\Filr as Support;

class Filr extends BaseDriver
{
    /**
     * Determine whether the username and password can authenticate against
     * this driver.
     * 
     * @param  string  $username
     * @param  string  $password
     * 
     * @return bool
     */
    public function attempt($username, $password): bool
    {
        return $this->support()->attempt($username, $password);
    }

    /**
     * Get a newly synced set of details about the user for the given username
     * and password.
     * 
     * @param  string  $username
     * @param  string|null  $password
     * 
     * @return array<string, mixed>
     */
    protected function profile($username, $password = null): array
    {
        return $this->support()->credentials($username, $password)->getProfile();
    }

    /**
     * Provide helper functions to the driver.
     */
    private function support()
    {
        return Support::for($this->key);
    }
}
