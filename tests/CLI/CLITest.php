<?php

use Symfony\Component\Console\Application;
use Tonik\CLI\CLI;

class CLITest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function test_commands_getter()
    {
        $cli = $this->getCLI();

        $this->assertEquals(count($cli->getCommands()), 1);
    }

    /**
     * @test
     */
    public function test_bootstraping_of_cli()
    {
        $cli = $this->getCLI();
        $app = $this->getApplication();

        $app->shouldReceive('add')
            ->times(count($cli->getCommands()));

        $app->shouldReceive('run')
            ->once();

        $cli->boot($app, 'dir/path');
    }

    public function getApplication()
    {
        return Mockery::mock(Application::class);
    }

    public function getCLI()
    {
        return new CLI;
    }
}