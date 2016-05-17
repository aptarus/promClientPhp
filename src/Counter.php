<?php

namespace Aptarus\PromClient;

class Counter extends Metric
{
    public function __construct($var, $help = "", $labels = [])
    {
        parent::__construct('counter', $var, $help, $labels);
    }

    public function inc($value = 1)
    {
        $this->_metric_inc($value);
    }

    public function labels($label_values)
    {
        return $this->_metric_labels($label_values);
    }
}
