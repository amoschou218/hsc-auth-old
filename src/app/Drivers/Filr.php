<?php

namespace HamiltonSC\Auth\App\Drivers;

use AMoschou\RemoteAuth\App\Drivers\BaseDriver;
use HamiltonSC\Auth\App\Support\Filr as Support;
use stdClass;

class Filr extends BaseDriver
{
    /**
     * Determine whether the given username and password can authenticate using
     * this driver.
     */
    public function validate(string $username, string $password): bool
    {
        return $this->support()->validate($username, $password);
    }

    /**
     * Get a newly synced set of details about the user for the given username
     * and password.
     */
    // public function profile(string $username, ?string $password = null): array
    // {
    //     return $this->support()->profile($username, $password);
    // }

    public function record(string $username, string $password): ?stdClass
    {
        return $this->support()->record($username, $password);
    }

    /**
     * Provide helper functions to the driver.
     */
    private function support()
    {
        return Support::for($this->getKey());
    }
}
