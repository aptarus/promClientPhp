<?php

namespace PromClient;

class Configuration
{
    private function __construct()
    {
        // Block it from being instantiated.
    }

    public static $storage_dir = '/var/lib/php_prom/default';

}

class Metric
{
    public function __construct($typ, $var, $help = "", $labels = [])
    {
        $this->typ = $typ;
        $this->var = $var;
        $this->help = $help;
        $this->labels = $labels;
        $this->label_values = [];
        $this->var_value = 0; // TODO: Need to read this from disk.
    }

    public function _metric_inc($label_values, $value)
    {
        if (count($this->label_values) == count($this->labels))
        {
            // Write metrics.
            $this->label_values = [];
        } else {
            // Raise exception.
        }
    }

    public function _metric_labels($label_values)
    {
        $this->label_values = $label_values;
        return $this;
    }
}

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
