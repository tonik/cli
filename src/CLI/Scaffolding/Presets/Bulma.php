<?php

namespace Tonik\CLI\Scaffolding\Presets;

use Symfony\Component\Filesystem\Filesystem;

class Bulma extends Preset
{
    /**
     * Preset name.
     *
     * @var string
     */
    private $name = 'bulma';

    /**
     * Scaffold a Bulma boilerplate preset.
     *
     * @return void
     */
    public function scaffold()
    {
        $this->updateDependencies([
            "bulma" => "^0.5.1",
        ]);
        $this->updateConfig([
            'bulma' => [
                './resources/assets/sass/bulma.scss',
            ],
        ]);
        $this->updateSass($this->name);
        $this->updateJavascript($this->name);
        $this->updateAssets($this->name);
    }
}
