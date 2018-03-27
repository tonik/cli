<?php

namespace Tonik\CLI;

use League\CLImate\CLImate;
use Tonik\CLI\Renaming\Placeholders;
use Tonik\CLI\Renaming\Renamer;
use Tonik\CLI\Scaffolding\Scaffolder;

class CLI
{
    /**
     * Collection of general placeholders to ask.
     *
     * @var array
     */
    public $placeholders = [
        '{{ theme.name }}' => [
            'value' => 'Tonik WordPress Starter Theme',
            'message' => '<comment>Theme Name</comment> [Tonik WordPress Starter Theme]',
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
            'value' => '3.0.0',
            'message' => '<comment>Theme Version</comment> [3.0.0]',
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
        'Tonik\Theme' => [
            'value' => 'Tonik\\Theme',
            'message' => '<comment>Theme Namespace</comment> [Tonik\Theme]',
        ],
    ];

    /**
     * Collection of child theme specific placeholders to ask.
     *
     * @var array
     */
    public $childPlaceholders = [
        '{{ theme.parent }}' => [
            'value' => 'theme',
            'message' => '<comment>Name of the Parent Theme</comment> [theme]',
        ],
    ];

    /**
     * Collection of presets names.
     *
     * @var array
     */
    public $presets = ['none', 'foundation', 'bootstrap', 'bulma', 'vue'];

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

        $child = $this->askForChildConfirmation();
        $replacements = $this->askForReplacements($child);

        if (! $child) {
            $preset = $this->askForPreset();
        }

        if ($this->askForConfirmation()) {
            if (isset($preset) && $preset !== 'none') {
                $scaffolder->build($preset);
            }

            $renamer->replace($replacements);

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
     * @param boolean child
     *
     * @return array
     */
    public function askForReplacements($child)
    {
        $replacements = [];

        if ($child) {
            $this->placeholders = array_merge($this->placeholders, $this->childPlaceholders);
        }

        foreach ($this->placeholders as $placeholder => $data) {
            $input = $this->climate->input($data['message']);

            $input->defaultTo($data['value']);

            $replacements[$placeholder] = addslashes($input->prompt());
        }

        return $replacements;
    }

    /**
     * Asks for preset name which files will be generated.
     *
     * @return string
     */
    public function askForPreset()
    {
        $input = $this->climate->input('<comment>Choose the front-end scaffolding</comment>');

        $input->accept($this->presets, true);

        return strtolower($input->prompt());
    }

    /**
     * Asks for preset name which files will be generated.
     *
     * @return string
     */
    public function askForChildConfirmation()
    {
        $input = $this->climate->confirm('Are we scaffolding a child theme?');

        return $input->confirmed();
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
