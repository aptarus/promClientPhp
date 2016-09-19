<?php

namespace Aptarus\PromClient;

use PDO;
use Aptarus\PromClient\Utility as U;

class Metric
{
    static $metrics_db = null;

    public function __construct($typ, $var, $help, $labels, $label_values)
    {
        if (!preg_match('/^[a-zA-Z_:][a-zA-Z0-9_:]*$/', $var)) {
            throw new Exceptions\InvalidName(sprintf(
                "Metric name '%s' is invalid",
                $var
            ));
        }
        $this->typ = $typ;
        $this->var = $var;
        $this->help = $help;
        $this->labels = $labels;
        $this->label_values = $label_values;
        if (!self::$metrics_db) {
            self::$metrics_db = U\PromClientOpenDB(Configuration::$storage_dir);
        }
        $sth = self::$metrics_db->
            prepare('INSERT INTO meta (var, typ, help) VALUES (?, ?, ?)');
        $sth->execute(array($this->var, $this->typ, $this->help));
    }

    protected function metricInc($var_value)
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

    protected function metricSet($var_value)
    {
        $sth = self::$metrics_db->
            prepare(
                'INSERT INTO metrics (value, label_values, var, labels)
                        VALUES (?, ?, ?, ?)'
            );

        $sth->execute(array($var_value, serialize($this->label_values),
            $this->var, serialize($this->labels)));
        $this->label_values = [];
    }
}

// vim:sw=4 ts=4 et
