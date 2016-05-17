<?php

namespace Aptarus\PromClient;

class Gauge extends Metric
{
    public function __construct($var, $help = "", $labels = [])
    {
        parent::__construct('gauge', $var, $help, $labels);
    }

    public function inc($value = 1)
    {
        $this->_metric_inc($value);
    }

    public function dec($value = 1)
    {
        $this->_metric_dec($value);
    }

    public function set($value)
    {
        $this->_metric_set($value);
    }

    public function labels($label_values)
    {
        return $this->_metric_labels($label_values);
    }
}

// vim:sw=4 ts=4 et
