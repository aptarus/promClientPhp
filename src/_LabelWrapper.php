<?php

namespace Aptarus\PromClient;

class _LabelWrapper
{
    public function __construct($metric_class, $var, $help, $labels)
    {
        $this->metric_class = "Aptarus\\PromClient\\" . $metric_class;
        // TODO: Check var name is valid.
        //       See: https://prometheus.io/docs/concepts/data_model/#metric-names-and-labels
        $this->var = $var;
        $this->help = $help;
        // TODO: Check label names are valid.
        //       See: https://prometheus.io/docs/concepts/data_model/#metric-names-and-labels
        $this->labels = $labels;
    }

    public function labels($label_values)
    {
        if (count($this->labels) != count($label_values))
        {
            // TODO: Make exception classes.
            throw new \Exception(sprintf(
                "labels/value counts don't match (%d/%d)",
                count($this->labels), count($label_values)));
        }
        return new $this->metric_class($this->var, $this->help,
                                       $this->labels, $label_values);
    }
}

// vim:sw=4 ts=4 et
