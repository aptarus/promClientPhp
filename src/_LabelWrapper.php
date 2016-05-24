<?php

namespace Aptarus\PromClient;

class _LabelWrapper
{
    public function __construct($metric_class, $var, $help, $labels)
    {
        $this->metric_class = $metric_class;
        $this->var = $var;
        $this->help = $help;
        $this->labels = $labels;
    }

    public function labels($label_values)
    {
        $this->_metric_labels($label_values);
        return new $this->metric_class($var, $help, $labels, $label_values);
    }
}

// vim:sw=4 ts=4 et
