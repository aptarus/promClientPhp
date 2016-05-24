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

function Counter($var, $help = "", $labels = null)
{
    if ($labels)
    {
        return new _LabelWrapper('Counter', $var, $help, $labels);
    } else {
        return new Counter($var, $help);
    }
}

// vim:sw=4 ts=4 et
