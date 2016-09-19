<?php

namespace Aptarus\PromClient;

function Counter($var, $help = "", $labels = null)
{
    if ($labels) {
        return new LabelWrapper('Counter', $var, $help, $labels);
    } else {
        return new Counter($var, $help);
    }
}

function Gauge($var, $help = "", $labels = null)
{
    if ($labels) {
        return new LabelWrapper('Gauge', $var, $help, $labels);
    } else {
        return new Gauge($var, $help);
    }
}

// vim:sw=4 ts=4 et
