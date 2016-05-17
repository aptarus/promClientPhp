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

// vim:sw=4 ts=4 et
