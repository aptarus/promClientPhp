<?php

namespace Aptarus\PromClient;

class Gauge extends Metric
{
    public function __construct($var, $help = "",
                                $labels = null, $label_values = null)
    {
        parent::__construct('gauge', $var, $help, $labels, $label_values);
    }

    public function inc($value = 1)
    {
        $this->_metric_inc($value);
    }

    public function dec($value = 1)
    {
        $this->_metric_inc(-$value);
    }

    public function set($value)
    {
        $this->_metric_set($value);
    }

    public function set_to_current_time()
    {
        $this->_metric_set(time());
    }
}

// vim:sw=4 ts=4 et
