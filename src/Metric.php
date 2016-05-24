<?php

namespace Aptarus\PromClient;

use PDO;

class Metric
{
    static $metrics_db = null;

    public function __construct($typ, $var, $help, $labels, $label_values)
    {
        $this->typ = $typ;
        $this->var = $var;
        $this->help = $help;
        $this->labels = $labels;
        $this->label_values = $label_values;
        if (!self::$metrics_db)
        {
            $file_existed = file_exists(Configuration::$storage_dir
                . '/metrics.db');
            self::$metrics_db = new PDO('sqlite:' . Configuration::$storage_dir
                . '/metrics.db');
            self::$metrics_db->setAttribute(PDO::ATTR_ERRMODE,
                                            PDO::ERRMODE_EXCEPTION);
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
            $sth = self::$metrics_db->
                prepare('INSERT INTO meta (var, typ, help) VALUES (?, ?, ?)');
            $sth->execute(array($this->var, $this->typ, $this->help));
        }
    }

    protected function _metric_inc($var_value)
    {
        $sth = self::$metrics_db->
            prepare('INSERT OR IGNORE INTO metrics
            (value,label_values,var,labels) VALUES (?, ?, ?, ?)');
        $sth->execute(array(0, serialize($this->label_values),
            $this->var, serialize($this->labels)));
        $sth = self::$metrics_db->
            prepare('UPDATE metrics
                        SET value = value + ?,
                            label_values = ?
                     WHERE var = ? AND labels = ?');
        $sth->execute(array($var_value, serialize($this->label_values),
                      $this->var, serialize($this->labels)));
        $this->label_values = [];
    }

    protected function _metric_set($var_value)
    {
        $sth = self::$metrics_db->
            prepare(
            'INSERT INTO metrics (value, label_values, var, labels)
                                 VALUES (?, ?, ?, ?)');

        $sth->execute(array($var_value, serialize($this->label_values),
            $this->var, serialize($this->labels)));
        $this->label_values = [];
    }
}

// vim:sw=4 ts=4 et
