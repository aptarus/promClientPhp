<?php

namespace PromClient;

class Counter
{
    /**
     * Create a new Counter Instance
     */
    public function __construct()
    {
        // constructor body
    }

    public function inc($value = 1)
    {
        // Increment the counter.
    }
}


class Gauge
{
    /**
     * Create a new Gauge Instance
     */
    public function __construct()
    {
        // constructor body
    }

    public function inc($value = 1)
    {
        // Increment the gauge.
    }

    public function dec($value = 1)
    {
        // Decrement the gauge.
    }

    public function set($value)
    {
        // Set the gauge.
    }
}

// vim:sw=4 ts=4 et
