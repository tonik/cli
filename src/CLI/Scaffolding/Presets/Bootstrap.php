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
        $this->updateDependencies([
            "bootstrap" => "^4.3.1",
            "jquery"  => "^1.9.1",
            "popper.js" => "^1.15.0"
        ]);
        $this->updateConfig([
            'bootstrap' => [
                './resources/assets/js/bootstrap.js',
                './resources/assets/sass/bootstrap.scss',
            ],
        ]);
        $this->updateSass($this->name);
        $this->updateJavascript($this->name);
        $this->updateAssets($this->name);
    }
}
