<?php

namespace Aptarus\PromClient;

class Counter extends Metric
{
    public function __construct(
        $var,
        $help = "",
        $labels = null,
        $label_values = nulli
    ) {
        parent::__construct('counter', $var, $help, $labels, $label_values);
    }

    public function inc($value = 1)
    {
        $this->metricInc($value);
    }
}

// vim:sw=4 ts=4 et
