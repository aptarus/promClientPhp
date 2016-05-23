<?php

namespace Aptarus\PromClient;

use Flintstone\Flintstone;

class Metric
{
    public function __construct($typ, $var, $help = "", $labels = [])
    {
        $this->typ = $typ;
        $this->var = $var;
        $this->help = $help;
        $this->labels = $labels;
        $this->label_values = [];
        $this->_fs_open();
        $this->_fs_set_meta();
    }

    protected function _metric_inc($var_value)
    {
        if (count($this->label_values) == count($this->labels))
        {
            $v = $this->_fs_get();
            if (!$v)
            {
                $v = array($var_value, $label_values);
            } else {
                $v = array($v[0] + $var_value, $label_values);
            }
            $this->_fs_set($var_value);
            $this->label_values = [];
        } else {
            // Raise exception.
        }
    }

    protected function _metric_set($var_value)
    {
        if (count($this->label_values) == count($this->labels))
        {
            $this->_fs_set($var_value);
            $this->label_values = [];
        } else {
            // Raise exception.
        }
    }

    protected function _metric_labels($label_values)
    {
        $this->label_values = $label_values;
        return $this;
    }

    private function _fs_open()
    {
        $this->meta = new Flintstone('meta',
            array('dir' => Configuration::$storage_dir));
        $this->metrics = new Flintstone('metrics',
            array('dir' => Configuration::$storage_dir));
    }

    /*
     * Store the meta data for a variable. The resulting storage looks
     * like: var -> [ last update time, type of var, help string ]
     */
    private function _fs_set_meta()
    {
        $this->meta->set($this->var,
           array(time(), $this->typ, $this->help));
    }

    private function _fs_get_meta()
    {
        return $this->meta->get($this->var);
    }

    /*
     * Store a variable. The resulting storage looks
     * like: var + labels -> [ last update time, var value, label values ]
     */
    private function _fs_set($var_value)
    {
        $this->metrics->set(serialize(array($this->var, $this->labels)),
           array(time(), $var_value, $this->label_values));
    }

    private function _fs_get()
    {
        return $this->metrics->get(serialize(array($this->var, $this->labels)));
    }
}

// vim:sw=4 ts=4 et
