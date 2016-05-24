<?php

namespace Aptarus\PromClient;

class Metric
{
    static $metrics_db = null;

    public function __construct($typ, $var, $help = "", $labels = [])
    {
        $this->typ = $typ;
        $this->var = $var;
        $this->help = $help;
        $this->labels = $labels;
        $this->label_values = [];
        if (!self::$metrics_db)
        {
            $file_existed = file_exists(Configuration::$storage_dir
                . '/metrics.db');
            self::$metrics_db = new PDO('sqlite:' . Configuration::$storage_dir
                . '/metrics.db');
            if (!$file_existed)
            {
                self::$metrics_db->exec(
                    'CREATE TABLE IF NOT EXISTS meta (
                        var VARCHAR(128) UNIQUE ON CONFLICT REPLACE,
                        typ VARCHAR(20),
                        help VARCHAR(128),
                        changed TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL)');
                self::$metrics_db->exec(
                    'CREATE TABLE IF NOT EXISTS metrics (
                        var VARCHAR(128),
                        value VARCHAR(20),
                        labels VARCHAR(256),
                        label_values VARCHAR(256),
                        changed TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
                        UNIQUE (var, labels) ON CONFLICT REPLACE)');
            }
            self::$metrics_db->exec(
                'INSERT INTO meta (var, typ, help) VALUES (?, ?, ?)',
                $this->var, $this->typ, $this->help);
        }
    }

    protected function _metric_inc($var_value)
    {
        if (count($this->label_values) == count($this->labels))
        {
            self::$metrics_db->exec(
                'INSERT OR IGNORE INTO metrics (var,labels,value,label_values)
                        VALUES (?, ?, ?, ?)',
                0, serialize($this->label_values),
                $this->var, serialize($this->labels));
            self::$metrics_db->exec(
                'UPDATE metrics
                    SET value = value + ?,
                        label_values = ?
                 WHERE var = ? AND labels = ?', $var_value,
                 serialize($this->label_values), $this->var,
                 serialize($this->labels));
            $this->label_values = [];
        } else {
            // Raise exception.
        }
    }

    protected function _metric_set($var_value)
    {
        if (count($this->label_values) == count($this->labels))
        {
            self::$metrics_db->exec(
                'INSERT INTO metrics (value, label_values, var, labels)
                        VALUES (?, ?, ?, ?)',
                $var_value, serialize($this->label_values),
                $this->var, serialize($this->labels));
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
}

// vim:sw=4 ts=4 et
