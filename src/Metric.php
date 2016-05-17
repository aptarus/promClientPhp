<?php

namespace Aptarus\PromClient;

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
        print("Reading $var from " . Configuration::$storage_dir . "\n");
    }

    public function _metric_inc($label_values, $value)
    {
        if (count($this->label_values) == count($this->labels))
        {
            // Write metrics.
            print("Writing $var to " . Configuration::$storage_dir . "\n");
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

// vim:sw=4 ts=4 et
