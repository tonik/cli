<?php

namespace Tonik\CLI\Scaffolding\Presets;

use Symfony\Component\Filesystem\Filesystem;

class Bootstrap extends Preset
{
    /**
     * Preset name.
     *
     * @var string
     */
    private $name = 'bootstrap';

    /**
     * Scaffold a Bootstrap boilerplate preset.
     *
     * @return void
     */
    public function scaffold()
    {
        $this->updatePackages([
            "bootstrap-sass" => "^3.3.7",
        ]);
        $this->updateSass($this->name);
        $this->updateJavascript($this->name);
        $this->updateAssets($this->name);
    }
}
