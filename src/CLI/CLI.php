<?php

namespace Tonik\CLI;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputOption;

class CLI
{
    /**
     * List of commands to register.
     *
     * @var array
     */
    protected $commands = [
        'Tonik\CLI\Command\ShakeCommand'
    ];

    /**
     * Boodstraps CLI.
     *
     * @return void
     */
    public function boot(Application $app, $dir)
    {
        foreach ($this->commands as $name) {
            $command = new $name;

            $command->addOption(
                'directory',
                'dir',
                InputOption::VALUE_REQUIRED,
                'Root directory path of theme.',
                $dir
            );

            $app->add($command);
        }

        return $app->run();
    }

    /**
     * Gets the List of commands to register.
     *
     * @return array
     */
    public function getCommands()
    {
        return $this->commands;
    }
}