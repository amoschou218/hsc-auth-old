<?php

namespace HamiltonSC\Auth\App\Drivers;

use AMoschou\RemoteAuth\App\Drivers\BaseDriver;
use HamiltonSC\Auth\App\Support\Filr as Support;

class Filr extends BaseDriver
{
    /**
     * Determine whether the given username and password can authenticate using
     * this driver.
     */
    public function attempt(string $username, string $password): bool
    {
        return $this->support()->attempt($username, $password);
    }

    /**
     * Get a newly synced set of details about the user for the given username
     * and password.
     */
    public function profile(string $username, ?string $password = null): array
    {
        return $this->support()->profile($username, $password);
    }

    /**
     * Provide helper functions to the driver.
     */
    private function support()
    {
        return Support::for($this->key);
    }
}
