<?php

namespace Aptarus\PromClient;

class Configuration
{
    private function __construct()
    {
        // Block it from being instantiated.
    }

    public static $storage_dir = '/var/lib/promClientPhp/default';

}
