<?php

namespace Tonik\CLI;

use League\CLImate\CLImate;
use Tonik\CLI\Command\Shake;

class CLI
{
    /**
     * List of answers.
     *
     * @var array
     */
    protected $answers = [];

    /**
     * List of questions.
     *
     * @var array
     */
    protected $questions = [
        'Tonik Theme' => '<comment>Theme Name</comment> [<info>Tonik Theme</info>]',
        'https://github.com/tonik/tonik' => '<comment>Theme URI</comment> [<info>https://github.com/tonik/tonik</info>]',
        'Modern Starter Theme' => '<comment>Theme Description</comment> [<info>Modern Starter Theme</info>]',
        '2.0.0' => '<comment>Theme Version</comment> [<info>2.0.0</info>]',
        'Tonik' => '<comment>Author</comment> [<info>Tonik</info>]',
        'http://tonik.pl' => '<comment>Author URI</comment> [<info>http://tonik.pl</info>]',
        'tonik' => '<comment>Theme Textdomain</comment> [<info>tonik</info>]',
        'App\Theme' => '<comment>Theme Namespace</comment> [<info>App\Theme</info>]',
    ];

    /**
     * Construct CLI.
     *
     * @param \League\CLImate\CLImate $climate
     */
    public function __construct(CLImate $climate) {
        $this->climate = $climate;

        $climate->arguments->add([
            'help' => [
                'prefix' => 'h',
                'longPrefix' => 'help',
                'description' => 'Shake command help guide',
                'noValue' => true,
            ],
        ]);
    }

    /**
     * Run CLI logic.
     *
     * @param \Tonik\CLI\Command\Shake $shake
     *
     * @return void
     */
    public function run(Shake $shake)
    {
        $this->drawBanner();

        $this->climate->arguments->parse();

        if ($this->climate->arguments->defined('help')) {
            return $this->climate->usage();
        }

        $this->askQuestions();

        if ($this->askForConfirmation()) {
            $shake->rename($this->answers);

            $this->climate->out('<success>Done.</success>');
        } else {
            $this->climate->whisper('Shaking abored.');
        }
    }

    /**
     * Draws CLI banner.
     *
     * @return void
     */
    public function drawBanner()
    {
        $this->climate->addArt(__DIR__.'/art');
        $this->climate->draw('tonik');
    }

    /**
     * Asks questions and saves answers.
     *
     * @return void
     */
    public function askQuestions()
    {
        foreach ($this->questions as $placeholder => $message) {
            $input = $this->climate->input($message);

            $input->defaultTo($placeholder);

            $this->answers[$placeholder] = $input->prompt();
        }
    }

    /**
     * Asks for confirmation for finalizing process.
     *
     * @return boolean
     */
    public function askForConfirmation()
    {
        $input = $this->climate->confirm('Continue?');

        return $input->confirmed();
    }

    /**
     * Gets the List of answers.
     *
     * @return array
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * Gets the List of questions.
     *
     * @return array
     */
    public function getQuestions()
    {
        return $this->questions;
    }
}