<?php

namespace Tonik\CLI;

use League\CLImate\CLImate;
use Tonik\CLI\Renaming\Placeholders;
use Tonik\CLI\Renaming\Renamer;
use Tonik\CLI\Scaffolding\Scaffolder;

class CLI
{
    public $placeholders = [
        '{{ theme.name }}' => [
            'value' => 'Tonik Starter Theme',
            'message' => '<comment>Theme Name</comment> [Tonik Starter Theme]',
        ],
        '{{ theme.url }}' => [
            'value' => '//labs.tonik.pl/theme/',
            'message' => '<comment>Theme URI</comment> [//labs.tonik.pl/theme/]',
        ],
        '{{ theme.description }}' => [
            'value' => 'Enhance your WordPress theme development workflow',
            'message' => '<comment>Theme Description</comment> [Enhance your WordPress theme development workflow]',
        ],
        '{{ theme.version }}' => [
            'value' => '2.0.0',
            'message' => '<comment>Theme Version</comment> [2.0.0]',
        ],
        '{{ theme.author }}' => [
            'value' => 'Tonik',
            'message' => '<comment>Author</comment> [Tonik]',
        ],
        '{{ theme.author.url }}' => [
            'value' => '//tonik.pl/',
            'message' => '<comment>Author URI</comment> [//tonik.pl/]',
        ],
        '{{ theme.textdomain }}' => [
            'value' => 'tonik',
            'message' => '<comment>Theme Textdomain</comment> [tonik]',
        ],
        'App\Theme' => [
            'value' => 'App\Theme',
            'message' => '<comment>Theme Namespace</comment> [App\Theme]',
        ],
    ];

    public $presets = ['foundation', 'bootstrap', 'none'];

    /**
     * Construct CLI.
     *
     * @param \League\CLImate\CLImate $climate
     */
    public function __construct(CLImate $climate) {
        $this->climate = $climate;
    }

    /**
     * Run CLI logic.
     *
     * @param \Tonik\CLI\Command\Shake $shake
     *
     * @return void
     */
    public function run(
        Renamer $renamer,
        Scaffolder $scaffolder
    ) {
        $this->drawBanner();

        $replacements = $this->askForReplacements();
        $presset = $this->askForPreset();

        if ($this->askForConfirmation()) {
            $renamer->replace($replacements);
            $scaffolder->build($presset);

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
        $this->climate->addArt(dirname(__DIR__).'/../art');
        $this->climate->draw('tonik');
    }

    /**
     * Asks placeholders and saves answers.
     *
     * @return void
     */
    public function askForReplacements()
    {
        $replacements = [];

        foreach ($this->placeholders as $placeholder => $data) {
            $input = $this->climate->input($data['message']);

            $input->defaultTo($data['value']);

            $replacements[$placeholder] = $input->prompt();
        }

        return $replacements;
    }

    public function askForPreset()
    {
        $input = $this->climate->input('<comment>Choose the front-end scaffolding</comment>');

        $input->accept($this->presets, true);

        return strtolower($input->prompt());
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
}
