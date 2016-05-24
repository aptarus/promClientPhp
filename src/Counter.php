<?php

namespace Aptarus\PromClient;

class Counter extends Metric
{
    public function __construct($var, $help = "",
                                $labels = null, $label_values = null)
    {
        parent::__construct('counter', $var, $help, $labels, $label_values);
    }

    public function inc($value = 1)
    {
        $this->_metric_inc($value);
    }
}

// vim:sw=4 ts=4 et
