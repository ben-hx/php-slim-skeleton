<?php
/**
 * Created by PhpStorm.
 * User: ben-hx
 * Date: 25.10.2016
 * Time: 12:11
 */

namespace BenHx\Api\Test\Base;


class TestListener extends \PHPUnit_Framework_BaseTestListener
{

    private function startWebserver() {
        $docRoot = realpath(WEB_SERVER_DOCROOT);
        $command = sprintf(
            'php -S %s:%d %s echo $!',
            WEB_SERVER_HOST,
            WEB_SERVER_PORT,
            $docRoot
        );

// Execute the command and store the process ID
        $output = array();
        exec($command, $output);
        $pid = (int) $output[0];

        echo sprintf(
                '%s - Web server started on %s:%d with PID %d',
                date('r'),
                WEB_SERVER_HOST,
                WEB_SERVER_PORT,
                $pid
            ) . PHP_EOL;

// Kill the web server when the process ends
        register_shutdown_function(function() use ($pid) {
            echo sprintf('%s - Killing process with ID %d', date('r'), $pid) . PHP_EOL;
            exec('kill ' . $pid);
        });
    }

    public function startTestSuite(\PHPUnit_Framework_TestSuite $suite)
    {
        print "hello";
        //$this->startWebserver();
        /*
        if (strpos($suite->getName(),"integration") !== false ) {
            // Bootstrap integration tests
        } else {
            // Bootstrap unit tests
        }
        */
    }
}