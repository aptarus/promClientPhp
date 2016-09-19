<?php

namespace Aptarus\PromClient\Exposition;

use PDO;
use Aptarus\PromClient\Utility as U;
use Aptarus\PromClient\Configuration as Configuration;

class Emit
{
    public function __construct()
    {
        $metrics_db = U\PromClientOpenDB(Configuration::$storage_dir);

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

        $this->meta = $metrics_db
            ->query('SELECT var, typ, help FROM meta ORDER BY var ASC')
            ->fetchAll(PDO::FETCH_UNIQUE);

        $sth = $metrics_db
            ->prepare('SELECT labels, value, label_values
                         FROM metrics where var = ? ORDER BY var ASC');

        foreach (array_keys($this->meta) as $var) {
            if ($sth->execute(array($var))) {
                $this->metrics[$var] = $sth->fetchAll(PDO::FETCH_UNIQUE);
            }
        }
    }

    // @codingStandardsIgnoreStart
    public function Text()
    {
        // @codingStandardsIgnoreEnd
        // Spew metrics.
        header('Content-Type: text/plain; version=0.0.4');

        foreach ($this->meta as $var) {
            print("# HELP $var " + $this->meta[$var]['help'] + "\n");
            print("# TYPE $var " + $this->meta[$var]['typ'] + "\n");
            foreach ($this->metrics[$var] as $labels) {
                $labels_quoted = '';
                $lnames = unserialize($labels);
                if ($lnames) {
                    $lvalues = unserialize(
                        $this->metrics[$var][$labels]['label_values']
                    );
                    $lnv = $array_combine($lnames, $lvalues);
                    $lnv_quoted = array();
                    foreach ($lnv as $l) {
                        $lnv_quoted[] = $l + '="' + $lvalues[$l] + '"';
                    }
                    $labels_quoted = '{' + join(',', $lnv_quoted) + '}';
                }
                print(
                    "$var$plabels_quoted "
                    + $this->metrics[$var][$labels]['value'] + "\n"
                );
            }
        }
    }
}

// vim:sw=4 ts=4 et
