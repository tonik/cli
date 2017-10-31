<?php

namespace Tonik\CLI\Scaffolding\Presets;

use Symfony\Component\Filesystem\Filesystem;

class Vue extends Preset
{
    /**
     * Preset name.
     *
     * @var string
     */
    private $name = 'vue';

    /**
     * Scaffold a Vue boilerplate preset.
     *
     * @return void
     */
    public function scaffold()
    {
        $this->updateDependencies([
            "vue" => "^2.4.3",
        ]);
        $this->updateDevDependencies([
            "vue-loader" => "^13.3.0",
            "vue-template-compiler" => "^2.5.2",
        ]);
        $this->updateJavascript($this->name);
        $this->updateAssets($this->name);
    }
}
