<?php

namespace Tonik\CLI;

use League\CLImate\CLImate;
use Symfony\Component\Finder\Finder;
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
        $climate->arguments->add([
            'help' => [
                'prefix' => 'h',
                'longPrefix' => 'help',
                'description' => 'Shake command help guide',
                'noValue' => true,
            ],
        ]);

        $this->climate = $climate;
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
        $this->climate->addArt(__DIR__.'/art');
        $this->climate->draw('tonik');

        $this->climate->arguments->parse();

        if ($this->climate->arguments->defined('help')) {
            return $this->climate->usage();
        }

        foreach ($this->questions as $placeholder => $message) {
            $input = $this->climate->input($message);

            $input->defaultTo($placeholder);

            $this->answers[$placeholder] = $input->prompt();
        }

        $input = $this->climate->confirm('Continue?');

        if ($input->confirmed()) {
            $shake->rename($this->answers);

            $this->climate->out('<success>Done.</success>');
        } else {
            $this->climate->whisper('Shaking abored.');
        }
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