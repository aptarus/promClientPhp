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
        $this->_metric_inc(-$value);
    }

    public function set($value)
    {
        $this->_metric_set($value);
    }

    public function labels($label_values)
    {
        $this->_metric_labels($label_values);
        return $this;
    }

    public function set_to_current_time()
    {
        $this->_metric_set(time());
    }
}

// vim:sw=4 ts=4 et
