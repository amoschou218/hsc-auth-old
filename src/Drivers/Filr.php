<?php

namespace HamiltonSC\Auth\App\Drivers;

use AMoschou\RemoteAuth\App\Drivers\Driver;
use HamiltonSC\Auth\App\Support\Filr as FilrSupport;

class Filr extends Driver
{
    public $driver = 'filr';

    public function validate($username, $password): bool
    {
        if (! $this->dnsRecordExists()) {
            return false;
        }

        $filrAuth = new FilrSupport;

        $success = $filrAuth->credentials($username, $password, true);
        
        return $success;
    }

    public function getUser($username, $password): array
    {
        $filrAuth = new FilrSupport;
    
        $aboutUser = $filrAuth->credentials($username, $password)
            ->getAboutUser();
    
        return $aboutUser;
    }
}
