<?php

namespace Aptarus\PromClient;

use PDO;

function PromClientOpenDB($storage_dir)
{
    $file_existed = file_exists($storage_dir . '/metrics.db');
    $metrics_db = new PDO('sqlite:' . $storage_dir . '/metrics.db');
    $metrics_db->setAttribute(PDO::ATTR_ERRMODE,
                                    PDO::ERRMODE_EXCEPTION);
    if (!$file_existed)
    {
        $metrics_db->exec(
            'CREATE TABLE IF NOT EXISTS meta (
                var VARCHAR(128) UNIQUE ON CONFLICT REPLACE,
                typ VARCHAR(20),
                help VARCHAR(128),
                changed TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL)');
        $metrics_db->exec(
            'CREATE TABLE IF NOT EXISTS metrics (
                var VARCHAR(128),
                value VARCHAR(20),
                labels VARCHAR(256),
                label_values VARCHAR(256),
                changed TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
                UNIQUE (var, labels) ON CONFLICT REPLACE)');
    }

    return $metrics_db;
}
