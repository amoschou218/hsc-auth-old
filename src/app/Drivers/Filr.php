<?php

namespace HamiltonSC\Auth\App\Drivers;

use AMoschou\RemoteAuth\App\Drivers\Driver;
use HamiltonSC\Auth\App\Support\Filr as FilrSupport;

class Filr extends Driver
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
        if (! $this->dnsRecordExists()) {
            return false;
        }

        return (new FilrSupport)
            ->credentials($username, $password, true);
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
    protected function user($username, $password): array
    {
        return (new FilrSupport)
            ->credentials($username, $password)
            ->getProfile();
    }
}
