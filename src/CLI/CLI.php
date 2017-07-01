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
        '{{ theme.name }}' => '<comment>Theme Name</comment> [<info>{{ theme.name }}</info>]',
        '{{ theme.url }}' => '<comment>Theme URI</comment> [<info>{{ theme.url }}</info>]',
        '{{ theme.description }}' => '<comment>Theme Description</comment> [<info>{{ theme.description }}</info>]',
        '{{ theme.version }}' => '<comment>Theme Version</comment> [<info>{{ theme.version }}</info>]',
        '{{ theme.author }}' => '<comment>Author</comment> [<info>{{ theme.author }}</info>]',
        '{{ theme.author.url }}' => '<comment>Author URI</comment> [<info>{{ theme.author.url }}</info>]',
        '{{ theme.textdomain }}' => '<comment>Theme Textdomain</comment> [<info>{{ theme.textdomain }}</info>]',
        'App\Theme' => '<comment>Theme Namespace</comment> [<info>{{ App\Theme }}</info>]',
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

            $this->climate->backgroundLightGreen('Done. Cheers!');
        } else {
            $this->climate->backgroundRed('Shaking abored.');
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