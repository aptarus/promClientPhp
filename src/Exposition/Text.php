<?php

namespace Aptarus\PromClient;

use PDO;
use Aptarus\PromClient\Utility;

class Emit
{
    public function __construct()
    {
        $metrics_db = PromClientOpenDB(Configuration::$storage_dir);

        // Clean up the DB first.
        $julian_day = unixtojd();
        $sth = $metrics_db->
            prepare('DELETE FROM metrics
                            WHERE var IN (SELECT var FROM meta
                                          WHERE ? - JULIANDAY(changed) > 3)');
        $sth->execute(array($julian_day));
        $meta_deleted = $sth->fetchColumn();
        $sth = $metrics_db->prepare('DELETE FROM metrics
                                            WHERE ? - JULIANDAY(changed) > 3');
        $sth->execute(array($julian_day));
        $metics_deleted = $sth->fetchColumn();

        $meta = $metrics_db
            ->query('SELECT var, typ, help FROM meta ORDER BY var ASC')
            ->fetchAll(PDO::FETCH_UNIQUE);

        $sth = $metrics_db
            ->prepare('SELECT labels, value, label_values
                         FROM metrics where var = ? ORDER BY var ASC');

        foreach (array_keys($meta) as $var)
        {
            $metrics[$var] = $sth->execute(array($var))
                ->fetchAll(PDO::FETCH_UNIQUE);
        }

        // Spew metrics.
        header('Content-Type: text/plain; version=0.0.4');
    }
}

// vim:sw=4 ts=4 et
