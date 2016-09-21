<?php

namespace Aptarus\PromClientTest;

use Aptarus\PromClient;
use Aptarus\PromClient\Exceptions;
use Aptarus\PromClient\Exposition;

// @codingStandardsIgnoreStart
if (version_compare(\PHPUnit_Runner_Version::id(), '5.0.0', '>=')) {
    /**
     * Needed to save sqlite db for inspection on a failed test in PHPUnit 5+.
     *
     * See https://github.com/minkphp/Mink/pull/687/files for inspiration.
     *
     * @internal
     */
    class SaveDBOnFailure extends \PHPUnit_Framework_TestCase
    {
        protected static $PromClient_delete = true;

        protected function onNotSuccessfulTest($e)
        {
            self::$PromClient_delete = false;
            throw $e;
        }
    }
} else {
    /**
     * Needed to save sqlite db for inspection on a failed test in PHPUnit 4.
     *
     * @internal
     */
    class SaveDBOnFailure extends \PHPUnit_Framework_TestCase
    {
        protected static $PromClient_delete = true;

        protected function onNotSuccessfulTest(\Exception $e)
        {
            self::$PromClient_delete = false;
            throw $e;
        }
    }
}

class PromClientTest extends SaveDBOnFailure
{
    public static $PromClient_delete = true;

    public static function setUpBeforeClass()
    {
        file_exists('data/metrics.db') and unlink('data/metrics.db');
        if (!is_dir('data')) {
            mkdir('data');
        }
        PromClient\Configuration::$storage_dir = 'data';
    }

    public function testCounter()
    {
        $c = PromClient\Counter('test_counter');
        $this->assertEquals("Aptarus\\PromClient\\Counter", get_class($c));
        $c->inc();
        // TODO: read counter and check that it's incremented.
    }

    /**
     * @expectedException \Aptarus\PromClient\Exceptions\LabelValueMismatch
     * @expectedExceptionMessageRegExp #.*(2/3)#
     */
    public function testBadLabel()
    {
        $c = PromClient\Counter(
            'test_counter',
            'Test counter',
            array('l1', 'l2')
        );
        $this->assertEquals(
            "Aptarus\\PromClient\\_LabelWrapper",
            get_class($c)
        );
        $cl = $c->labels(array(1, 2, 3));
    }

    /**
     * @expectedException \Aptarus\PromClient\Exceptions\InvalidName
     * @expectedExceptionMessageRegExp #Metric name '1bad_metric' is invalid#
     */
    public function testBadMetricWithoutLabelsName()
    {
        $c = PromClient\Counter('1bad_metric', 'Test counter');
    }

    /**
     * @expectedException \Aptarus\PromClient\Exceptions\InvalidName
     * @expectedExceptionMessageRegExp #Metric name '1bad_metric' is invalid#
     */
    public function testBadMetricWithLabelsName()
    {
        $c = PromClient\Counter(
            '1bad_metric',
            'Test counter',
            array('l1', 'l2')
        );
    }

    /**
     * @expectedException \Aptarus\PromClient\Exceptions\InvalidName
     * @expectedExceptionMessageRegExp #Label name '1bad_label' is invalid#
     */
    public function testBadLabelName()
    {
        $c = PromClient\Gauge(
            'test_counter',
            'Test gauge',
            array('1bad_label', 'l2')
        );
    }

    public function testCounterLabel()
    {
        $c = PromClient\Counter(
            'test_counter',
            'Test counter',
            array('l1', 'l2')
        );
        $this->assertEquals(
            "Aptarus\\PromClient\\_LabelWrapper",
            get_class($c)
        );
        $cl = $c->labels(array(1, 2));
        $this->assertEquals("Aptarus\\PromClient\\Counter", get_class($cl));
        return $cl;
    }

    /**
     * @depends testCounterLabel
     */
    public function testCounterLabelInc($c)
    {
        $c->inc();
        // TODO: read counter and check that it's incremented.
    }

    public function testGauge()
    {
        $g = PromClient\Gauge('test_gauge');
        $this->assertEquals("Aptarus\\PromClient\\Gauge", get_class($g));
        $g->inc();
        // TODO: read counter and check that it's incremented.
        $g->dec();
        // TODO: read counter and check that it's incremented.
        $g->set(100);
        // TODO: read counter and check that it's incremented.
        $g->set_to_current_time();
        // TODO: read counter and check that it's incremented.
    }

    public function testGaugeLabel()
    {
        $g = PromClient\Gauge(
            'test_gauge',
            'Test gauge',
            array('l1', 'l2')
        );
        $this->assertEquals(
            "Aptarus\\PromClient\\_LabelWrapper",
            get_class($g)
        );
        $gl = $g->labels(array(1, 2));
        $this->assertEquals("Aptarus\\PromClient\\Gauge", get_class($gl));
        return $gl;
    }

    /**
     * @depends testGaugeLabel
     */
    public function testGaugeLabelInc($g)
    {
        $g->inc();
        // TODO: read gauge and check that it's incremented.
    }

    /**
     * @runInSeparateProcess
     */
    public static function tearDownAfterClass()
    {
        $emit = new Exposition\Emit();
        print $emit->Text();
        if (self::$PromClient_delete) {
            file_exists('data/metrics.db') and unlink('data/metrics.db');
        }
    }
}
// @codingStandardsIgnoreEnd

// vim:sw=4 ts=4 et
