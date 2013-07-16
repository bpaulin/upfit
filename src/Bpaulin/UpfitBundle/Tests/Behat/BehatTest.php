<?php

namespace Bpaulin\UpfitBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Behat\Behat\Console\BehatApplication;

class BehatTest extends WebTestCase
{
    /**
     * @group behat
     * @group behat-without-browser
     */
    public function testBehatWithoutBrowser()
    {
        try {
            $input = new ArrayInput(array('--profile' => 'report', '--ansi' =>'', '--tags' => "~@javascript"));
            $output = new ConsoleOutput();

            $app = new \Behat\Behat\Console\BehatApplication('dev');
            $app->setAutoExit(false);

            $result = $app->run($input, $output);

            $this->assertEquals(0, $result);
        } catch (\Exception $exception) {
            $this->fail($exception->getMessage());
        }
    }

    /**
     * @group behat
     * @group behat-with-browser
     */
    public function testBehat()
    {
        try {
            $input = new ArrayInput(array('--profile' => 'report', '--ansi' =>''));
            $output = new ConsoleOutput();

            $app = new \Behat\Behat\Console\BehatApplication('dev');
            $app->setAutoExit(false);

            $result = $app->run($input, $output);

            $this->assertEquals(0, $result);
        } catch (\Exception $exception) {
            $this->fail($exception->getMessage());
        }
    }
}
