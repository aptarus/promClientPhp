<?php

namespace Aptarus\PromClient;

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
