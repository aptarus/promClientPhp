<?php

namespace Aptarus\PromClient;

class _LabelWrapper
{
    public function __construct($metric_class, $var, $help, $labels)
    {
        if (!preg_match('/^[a-zA-Z_:][a-zA-Z0-9_:]*$/', $var))
        {
            throw new Exceptions\InvalidName(sprintf(
                "Metric name '%s' is invalid", $var));
        }
        foreach ($labels as $label)
        {
            if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $label)
                or substr($label, 0, 4) === "__")
            {
                throw new Exceptions\InvalidName(sprintf(
                    "Label name '%s' is invalid", $label));
            }
        }
        $this->metric_class = "Aptarus\\PromClient\\" . $metric_class;
        $this->var = $var;
        $this->help = $help;
        $this->labels = $labels;
    }

    public function labels($label_values)
    {
        if (count($this->labels) != count($label_values))
        {
            throw new Exceptions\LabelValueMismatch(sprintf(
                "labels/value counts don't match (%d/%d)",
                count($this->labels), count($label_values)));
        }
        return new $this->metric_class($this->var, $this->help,
                                       $this->labels, $label_values);
    }
}

// vim:sw=4 ts=4 et
