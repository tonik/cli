<?php

namespace Tonik\CLI;

use League\CLImate\CLImate;
use Tonik\CLI\Renaming\Placeholders;
use Tonik\CLI\Renaming\Renamer;
use Tonik\CLI\Scaffolding\Scaffolder;

class CLI
{
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
        $preset = $this->askForPreset();

        if ($this->askForConfirmation()) {
            $renamer->replace($replacements);
            $scaffolder->build($preset);

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
     * Asks placeholders and saves answers.
     *
     * @return void
     */
    public function askForReplacements()
    {
        $replacements = [];

        foreach (Placeholders::REPLACEMENTS as $placeholder => $replacement) {
            $input = $this->climate->input($replacement['message']);

            $input->defaultTo($replacement['value']);

            $replacement['value'] = $input->prompt();

            $placeholders[$placeholder] = $replacement;
        }

        return $placeholders;
    }

    public function askForPreset()
    {
        $input = $this->climate->input('<comment>Choose the front-end scaffolding</comment>');

        $input->accept(Scaffolder::PRESETS, true);

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